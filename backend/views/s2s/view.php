<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\S2s */

$this->title = $model->campaign_id;
$this->params['breadcrumbs'][] = ['label' => 'S2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="s2s-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'campaign_id' => $model->campaign_id, 'channel_id' => $model->channel_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'campaign_id' => $model->campaign_id, 'channel_id' => $model->channel_id], [
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
            'campaign_id',
            'channel_id',
            'pay_out',
            'daily_cap',
            'discount',
            'is_run',
            'creator',
            'create_time:datetime',
            'update_time:datetime',
            'note',
        ],
    ]) ?>

</div>
