<?php

use kartik\typeahead\Typeahead;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Channel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="channel-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'password_hash')->passwordInput() ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'settlement_type')->dropDownList(ModelsUtil::settlement_type) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'om')->widget(Typeahead::classname(), [
                'pluginOptions' => ['highlight' => true],
                'options' => ['value' => isset($model->om0) ? $model->om0->username : '',],
                'dataset' => [
                    [
                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                        'display' => 'value',
                        'remote' => [
                            'url' => Url::to(['channel/get_om']) . '?om=%QUERY',
                            'wildcard' => '%QUERY'
                        ]
                    ]],
            ]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'master_channel')->widget(Typeahead::classname(), [
                'pluginOptions' => ['highlight' => true],
                'options' => ['value' => isset($model->master_channel) ? $model->masterChannel->username : '',],
                'dataset' => [
                    [
                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                        'display' => 'value',
                        'remote' => [
                            'url' => Url::to(['channel/get_channel_name']) . '?name=%QUERY',
                            'wildcard' => '%QUERY'
                        ]
                    ]],
            ]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'payment_way')->checkboxList(ModelsUtil::payment_way) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'payment_term')->checkboxList(ModelsUtil::payment_term) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'beneficiary_name')->textInput() ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'bank_country')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'bank_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'bank_address')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'swift')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'account_nu_iban')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'company_address')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'note')->textarea(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'contacts')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'system')->dropDownList(ModelsUtil::system) ?>
        </div>
    </div>


    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'cc_email')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'phone1')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'skype')->textInput(['maxlength' => true]) ?>
        </div>
    </div>


    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'status')->dropDownList(ModelsUtil::advertiser_status) ?>
        </div>
    </div>


    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'traffic_source')->dropDownList(ModelsUtil::traffic_source) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'pricing_mode')->dropDownList(ModelsUtil::pricing_mode) ?>
        </div>
    </div>


    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'post_back')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'strong_geo')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'strong_catagory')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
