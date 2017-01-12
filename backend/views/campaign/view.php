<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Campaign */

$this->title = $model->campaign_name;
$this->params['breadcrumbs'][] = ['label' => 'Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campaign-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            //'advertiser',
            [
                'attribute'=>'advertiser',
                'value'=>$model->advertiser0->username,
            ],
            'campaign_name',
            //'tag',
            'campaign_uuid',
           // 'pricing_mode',
            [
                'attribute'=>'pricing_mode',
                'value'=>ModelsUtil::getValue(ModelsUtil::pricing_mode,$model->pricing_mode),
            ],
            'promote_start',
            'promote_end',
            'end_time:datetime',
            'device',
            'platform',
            'budget',
            'open_budget',
            'daily_cap',
            'open_cap',
            'adv_price',
            'now_payout',
            'target_geo',
            'traffice_source',
            'note',
            'preview_link',
            'icon',
            'package_name',
            'app_name',
            'app_size',
            'category',
            'version',
            'app_rate',
            'description',
            'creative_link',
            'creative_type',
            'creative_description',
            'carriers',
            'conversion_flow',
            'recommended',
            'indirect',
            'cap',
            'cvr',
            'epc',
            'pm',
            'bd',
            'status',
            'open_type',
            'subid_status',
            'track_way',
            'third_party',
            'track_link_domain',
            'adv_link',
            'link_type',
            'other_setting',
            'ip_blacklist',
        ],
    ]) ?>

</div>
