<?php
/**
 * Created by PhpStorm.
 * User: Iven.Wu
 * Date: 2017-02-10
 * Time: 10:59
 */

namespace console\controllers;


use common\models\Advertiser;
use common\models\AdvertiserApi;
use common\models\ApiCampaign;
use common\models\Campaign;
use common\models\CampaignLogHourly;
use common\models\Deliver;
use common\models\Feed;
use common\models\LogClick;
use common\models\LogFeed;
use common\models\LogPost;
use common\models\Stream;
use common\utility\ApiUtil;
use linslin\yii2\curl\Curl;
use Yii;
use yii\console\Controller;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * Class TestController
 * @package console\controllers
 */
class TestController extends Controller
{

    public function actionTest()
    {
//        var_dump(Stream::getCountClicks());
//        var_dump(md5('ch58a6d7f5e4fec58a6d7f5e5091'));

        http://api.superads.cn/v1/offers?token=8e5c1e70c5507cf8a556638e68de38c8&u=oneapi&page_size=10&page=1

        $c = new Curl();
        $c->get('http://api.superads.cn/v1/offers?token=8e5c1e70c5507cf8a556638e68de38c8&u=oneapi&page_size=10&page=1');
        var_dump($c->response);
    }

    public function actionUpdateClicks()
    {
        //1. 更新点击
        $clicks = array(); // 用来
        $posts = array();
        $newIpClicks = array();
        $streams = Stream::getCountClicks();
        $this->echoMessage('count click ' . count($streams));
        if (isset($streams)) {
            foreach ($streams as $item) {
                $camp = Campaign::findByUuid($item->cp_uid);
                if ($camp == null) {
                    $this->echoMessage('Count not found campaign ' . $item->cp_uid);
                    continue;
                }
                $click = new LogClick();
                $click->tx_id = $item->id;
                $click->click_uuid = $item->click_uuid;
                $click->click_id = $item->click_id;
                $click->channel_id = $item->ch_id;
                $click->campaign_id = $camp->id;
                $click->campaign_uuid = $item->cp_uid;
                $click->pl = $item->pl;
                $click->ch_subid = $item->ch_subid;
                $click->gaid = $item->gaid;
                $click->idfa = $item->idfa;
                $click->site = $item->site;
                $click->pay_out = $item->pay_out;
                $click->discount = $item->discount;
                $click->daily_cap = $item->daily_cap;
                $click->all_parameters = $item->all_parameters;
                $click->ip = $item->ip;
                $click->redirect = $item->redirect;
                $click->browser = $item->browser;
                $click->browser_type = $item->browser_type;
                $click->click_time = $item->create_time;
//                $click->
                if ($click->save() == false) {
                    var_dump($click->getErrors());
                } else {
                    if (isset($clicks[$click->campaign_id . '-' . $click->channel_id])) {
                        $clicks[$click->campaign_id . '-' . $click->channel_id] += 1;
                    } else {
                        $clicks[$click->campaign_id . '-' . $click->channel_id] = 1;
                    }
                    $newIpClicks[$click->campaign_id . '-' . $click->channel_id][] = $click->ip;
                }
                $item->is_count = 1;
                $item->save();
            }

            $this->echoMessage('Update clicks start :');
            if (!empty($clicks)) { //sts更新点击量
                foreach ($clicks as $k => $v) {
                    $de = explode('-', $k);
                    $sts = Deliver::findIdentity($de[0], $de[1]);
                    $ips = $newIpClicks[$k];
                    $this->echoMessage($de[0] . '-' . $de[1] . ' original unique click to ' . $sts->unique_click);
                    if (!empty($ips)) {
                        $ips = array_unique($ips);
                        foreach ($ips as $ip) {
                            $is = LogClick::findClickIpExist($de[0], $de[1], $ip);
                            if ($is === false) {
                                $sts->unique_click += 1;
                            }
                        }
                    }
                    $sts->click += $v;
                    $this->echoMessage($de[0] . '-' . $de[1] . ' update click to ' . $sts->click);
                    $this->echoMessage($de[0] . '-' . $de[1] . ' update unique click to ' . $sts->unique_click);
                    $sts->save();
                }
            }
        }
        $this->echoMessage('Update clicks end ############');
    }

    public function actionUpdateFeeds()
    {
        //2. 更新feed
        $feeds = Feed::findNeedCounts();
        $this->echoMessage('Total Feeds ' . count($feeds));
        $installs = array();
        if (isset($feeds)) {
            foreach ($feeds as $item) {
                $logClick = LogClick::findByClickUuid($item->click_id);
                if (isset($logClick)) {
                    $camp = Campaign::findById($logClick->campaign_id);
                    if (empty($camp)) {
                        $this->echoMessage('cannot found the campaign -' . $logClick->campaign_id);
                        continue;
                    }
                    $sts = Deliver::findIdentity($logClick->campaign_id, $logClick->channel_id);
                    $logFeed = new LogFeed();
                    $logFeed->auth_token = $item->auth_token;
                    $logFeed->click_uuid = $item->click_id;
                    $logFeed->click_id = $logClick->click_id;
                    $logFeed->channel_id = $logClick->channel_id;
                    $logFeed->campaign_id = $logClick->campaign_id;
                    $logFeed->ch_subid = $logClick->ch_subid;
                    $logFeed->all_parameters = $item->all_parameters;
                    $logFeed->ip = $item->ip;
                    $logFeed->adv_price = $camp->adv_price;
                    $logFeed->feed_time = $item->create_time;
                    if ($logFeed->save() == false) {
                        var_dump($logFeed->getErrors());
                    } else {
                        //更新post 扣量
                        if ($this->isNeedPost($sts)) {
                            $post = new LogPost();
                            $post->click_uuid = $logFeed->click_uuid;
                            $post->click_id = $logFeed->click_id;
                            $post->channel_id = $logFeed->channel_id;
                            $post->campaign_id = $logFeed->campaign_id;
                            $post->pay_out = $logClick->pay_out;
                            $post->discount = $logClick->discount;
                            $post->daily_cap = $logClick->daily_cap;
                            $post->post_link = $this->genPostLink($sts->channel->post_back, $logClick->all_parameters);
                            $post->post_status = 0;
                            if ($post->save() == false) {
                                var_dump($logFeed->getErrors());
                            }
                        }
                    }
                } else {
                    $this->echoMessage('cannot found the click log-channel_click_id-' . $item->click_id);
                }

                $item->is_count = 1;
                $item->save();
            }
        }
    }

    /**
     * @param Deliver $sts
     * @return bool
     */
    private function isNeedPost(&$sts)
    {
        $needPost = false;
        $standard = 100 - $sts->discount;
        $numerator = $sts->discount_numerator + 1;//分子
        $denominator = $sts->discount_denominator + 1;//扣量基数
        $percent = ($numerator / $denominator) * 100;
        if ($percent < $standard) {
            $needPost = true;
            $sts->discount_numerator = $numerator;
            $sts->install += 1;
        }
        $sts->match_install += 1;
        $sts->discount_denominator = $denominator;
        if ($sts->discount_denominator >= 10) {
            $sts->discount_denominator = 0;
            $sts->discount_numerator = 0;
        }
        $sts->save();
        return $needPost;
    }

    private function genPostLink($postback, $allParams)
    {
        if (!empty($allParams)) {
            $params = explode('&', $allParams);
            foreach ($params as $item) {
                $param = explode('=', $item);
                $k = '{' . $param[0] . '}';
                $v = $param[1];
                $postback = str_replace($k, $v, $postback);
            }
        }

        $this->echoMessage("generate url: " . $postback);
        return $postback;
    }

    private function echoMessage($str)
    {
        echo " \t $str \n";
    }


    public function actionTmd()
    {
        //            set time_zone='Asia/ShangHai';
        //SELECT
        //	fc.campaign_id,
        //	fc.campaign_uuid,
        //	FROM_UNIXTIME(
        //        fc.click_time,
        //        "%Y-%m-%d %H:00"
        //    ) time,
        //count(*) clicks
        //FROM
        //	log_click fc
        //where fc.click_time>1488441600
        //GROUP BY
        //fc.campaign_id,fc.campaign_uuid,time
        //ORDER BY time
        Yii::$app->db->createCommand('set time_zone="+8:00"')->execute();
        date_default_timezone_set("Asia/Shanghai");
        $query = new Query();
        $query->select(['fc.campaign_id',
            'fc.channel_id',
            'FROM_UNIXTIME(fc.click_time,"%Y-%m-%d %H:00") time',
            'UNIX_TIMESTAMP(FROM_UNIXTIME(
                fc.click_time,
                "%Y-%m-%d %H:00"
            )) timestamp',
            'count(DISTINCT(fc.ip)) clicks']);
        $query->from('log_click fc');
        $query->groupBy(['fc.campaign_id',
            'fc.channel_id',
            'time', 'timestamp']);
        $query->orderBy('timestamp');

        $command = $query->createCommand();
        $rows = $command->queryAll();
//        var_dump($rows);

        foreach ($rows as $item) {
            var_dump($item);
//            var_dump($item["campaign_id"][]);
            $channel_id='';
            $campaign_id='';
            $timestamp='';
            $time='';
            $clicks='';
            foreach ($item as $k => $v) {
                if ($k == 'channel_id') {
                    $channel_id = $v;
                }
                if ($k == 'campaign_id') {
                    $campaign_id = $v;
                }
                if ($k == 'timestamp') {
                    $timestamp = $v;
                }
                if ($k == 'time') {
                    $time = $v;
                }
                if ($k == 'clicks') {
                    $clicks = $v;
                }

            }
//            $hourly = CampaignLogHourly::findIdentity($campaign_id,$channel_id,$timestamp);
//            if(empty($hourly)){
//                $hourly = new CampaignLogHourly();
//                $hourly->channel_id =$channel_id;
//                $hourly->campaign_id = $campaign_id;
//                $hourly->time = $timestamp;
//                $hourly->time_format = $time;
//                $hourly->unique_clicks = $clicks;
//            } else {
//                $hourly->unique_clicks = $clicks;
//            }
//
//            $hourly->save();
//            var_dump($hourly->getErrors());
        }


    }
}