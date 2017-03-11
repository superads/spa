<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Campaign;

/**
 * CampaignSearch represents the model behind the search form about `common\models\Campaign`.
 */
class CampaignSearch extends Campaign
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'promote_start', 'promote_end', 'effective_time', 'adv_update_time', 'recommended', 'indirect', 'cap', 'cvr', 'status', 'open_type', 'subid_status', 'third_party', 'link_type', 'creator', 'create_time', 'update_time'], 'integer'],
            [['advertiser', 'campaign_name', 'campaign_uuid', 'pricing_mode', 'platform', 'min_version', 'max_version', 'daily_cap', 'target_geo', 'traffic_source', 'note', 'preview_link', 'icon', 'package_name', 'app_name', 'app_size', 'category', 'version', 'app_rate', 'description', 'creative_link', 'creative_type', 'creative_description', 'carriers', 'conversion_flow', 'epc', 'track_way', 'track_link_domain', 'adv_link', 'other_setting', 'ip_blacklist'], 'safe'],
            [['adv_price', 'now_payout', 'avg_price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Campaign::find();
        $query->alias('c');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
//        var_dump($this->traffic_source);
//        die();
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('advertiser0 a');
        // grid filtering conditions
        $query->andFilterWhere([
            'c.id' => $this->id,
            'promote_start' => $this->promote_start,
            'promote_end' => $this->promote_end,
            'effective_time' => $this->effective_time,
            'adv_update_time' => $this->adv_update_time,
            'adv_price' => $this->adv_price,
            'now_payout' => $this->now_payout,
            'recommended' => $this->recommended,
            'indirect' => $this->indirect,
            'cap' => $this->cap,
            'cvr' => $this->cvr,
            'avg_price' => $this->avg_price,
            'c.status' => $this->status,
            'traffic_source' => $this->traffic_source,
            'open_type' => $this->open_type,
            'subid_status' => $this->subid_status,
            'third_party' => $this->third_party,
            'link_type' => $this->link_type,
            'creator' => $this->creator,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'campaign_name', $this->campaign_name])
            ->andFilterWhere(['like', 'campaign_uuid', $this->campaign_uuid])
            ->andFilterWhere(['like', 'pricing_mode', $this->pricing_mode])
            ->andFilterWhere(['like', 'platform', $this->platform])
            ->andFilterWhere(['like', 'min_version', $this->min_version])
            ->andFilterWhere(['like', 'max_version', $this->max_version])
            ->andFilterWhere(['like', 'daily_cap', $this->daily_cap])
            ->andFilterWhere(['like', 'target_geo', $this->target_geo])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'preview_link', $this->preview_link])
            ->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'package_name', $this->package_name])
            ->andFilterWhere(['like', 'app_name', $this->app_name])
            ->andFilterWhere(['like', 'app_size', $this->app_size])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'app_rate', $this->app_rate])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'creative_link', $this->creative_link])
            ->andFilterWhere(['like', 'creative_type', $this->creative_type])
            ->andFilterWhere(['like', 'creative_description', $this->creative_description])
            ->andFilterWhere(['like', 'carriers', $this->carriers])
            ->andFilterWhere(['like', 'conversion_flow', $this->conversion_flow])
            ->andFilterWhere(['like', 'epc', $this->epc])
            ->andFilterWhere(['like', 'track_way', $this->track_way])
            ->andFilterWhere(['like', 'track_link_domain', $this->track_link_domain])
            ->andFilterWhere(['like', 'adv_link', $this->adv_link])
            ->andFilterWhere(['like', 'a.username', $this->advertiser])
            ->andFilterWhere(['like', 'ip_blacklist', $this->ip_blacklist]);
        $query->orderBy('create_time DESC');

        return $dataProvider;
    }
}
