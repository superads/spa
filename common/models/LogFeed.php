<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_feed".
 *
 * @property integer $id
 * @property string $auth_token
 * @property string $click_uuid
 * @property string $click_id
 * @property integer $channel_id
 * @property integer $campaign_id
 * @property string $ch_subid
 * @property string $all_parameters
 * @property string $ip
 * @property string $adv_price
 * @property integer $feed_time
 * @property integer $is_post
 * @property integer $create_time
 * @property Campaign $campaign
 * @property Channel $channel
 */
class LogFeed extends \yii\db\ActiveRecord
{
    public $advertiser_name;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_feed';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['click_uuid', 'channel_id', 'campaign_id'], 'required'],
            [['channel_id', 'campaign_id', 'feed_time', 'is_post', 'create_time'], 'integer'],
            [['all_parameters'], 'string'],
            [['adv_price'], 'number'],
            [['auth_token'], 'string', 'max' => 32],
            [['click_uuid', 'click_id', 'ch_subid', 'ip'], 'string', 'max' => 255],
            [['click_uuid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'auth_token' => 'Auth Token',
            'click_uuid' => 'Click Uuid',
            'click_id' => 'Click ID',
            'channel_id' => 'Channel ID',
            'campaign_id' => 'Campaign ID',
            'ch_subid' => 'Ch Subid',
            'all_parameters' => 'All Parameters',
            'ip' => 'Ip',
            'adv_price' => 'Adv Price',
            'feed_time' => 'Feed Time',
            'is_post' => 'Is Post',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaign()
    {
        return $this->hasOne(Campaign::className(), ['id' => 'campaign_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChannel()
    {
        return $this->hasOne(Channel::className(), ['id' => 'channel_id']);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->create_time = time();
        }
        return parent::beforeSave($insert);
    }
}
