<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Channel */

$this->title = 'Update Channel: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Channels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="col-lg-12">
    <div class="box box-info">
        <div class="box-body">

            <h3><?= Html::encode($this->title) ?></h3>

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
