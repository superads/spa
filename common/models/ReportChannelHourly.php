<?php

namespace common\models;


class ReportChannelHourly extends CampaignLogHourly
{

    public $campaign_name;
    public $channel_name;
    public $om;

    public $cvr;
    public $cost;
    public $match_cvr;
    public $revenue;
    public $def;
    public $deduction_percent;
    public $profit;
    public $margin;

    public $type;
    public $start;
    public $end;

    public function attributeLabels()
    {
        return [
            'cvr' => 'Cvr',
            'cost' => 'Cost',
            'match_cvr' => 'Match Cvr',
            'revenue' => 'Revenue',
            'def' => 'Def',
            'deduction_percent' => 'Deduction Percent',
            'profit' => 'Profit',
            'margin' => 'Margin',
            'type' => 'Type',
        ];
    }
}
