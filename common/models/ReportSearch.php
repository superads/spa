<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Deliver;

/**
 * ReportSearch represents the model behind the search form about `common\models\Deliver`.
 */
class ReportSearch extends Deliver
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pricing_mode', 'daily_cap', 'is_run', 'creator', 'create_time', 'update_time', 'click', 'unique_click', 'install', 'match_install', 'def'], 'integer'],
            [['campaign_id', 'channel_id', 'campaign_uuid', 'track_url', 'note'], 'safe'],
            [['adv_price', 'pay_out', 'actual_discount', 'discount', 'cvr', 'cost', 'match_cvr', 'revenue', 'deduction_percent', 'profit', 'margin'], 'number'],
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
        $query = Deliver::find();
        $query->alias('d');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('campaign ca');
        $query->joinWith('channel ch');
        // grid filtering conditions
        $query->andFilterWhere([
            'adv_price' => $this->adv_price,
            'pricing_mode' => $this->pricing_mode,
            'pay_out' => $this->pay_out,
            'daily_cap' => $this->daily_cap,
            'actual_discount' => $this->actual_discount,
            'discount' => $this->discount,
            'is_run' => $this->is_run,
            'creator' => $this->creator,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'click' => $this->click,
            'unique_click' => $this->unique_click,
            'install' => $this->install,
            'cvr' => $this->cvr,
            'cost' => $this->cost,
            'match_install' => $this->match_install,
            'match_cvr' => $this->match_cvr,
            'revenue' => $this->revenue,
            'def' => $this->def,
            'deduction_percent' => $this->deduction_percent,
            'profit' => $this->profit,
            'margin' => $this->margin,
        ]);
        $query->andFilterWhere(['like', 'campaign_uuid', $this->campaign_uuid])
            ->andFilterWhere(['like', 'track_url', $this->track_url])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'ca.campaign_name', $this->campaign_id])
            ->andFilterWhere(['like', 'ch.username', $this->channel_id]);
        $query->orderBy(['click' => SORT_DESC, 'update_time' => SORT_DESC]);

        return $dataProvider;
    }
}
