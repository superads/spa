<?php

use yii\bootstrap\Progress;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\typeahead\TypeaheadBasic;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\TestLinkForm */

$this->title = 'Test Link';
$this->params['breadcrumbs'][] = ['label' => 'Delivers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div id="nav-menu" data-menu="testlink"></div>
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-body">

                <?php $form = ActiveForm::begin([
                    'id' => 'test-link-form',
                    //'enableAjaxValidation' => true,
                ]); ?>

                <?php
//                $form->field($model, 'channel')->textInput()
                          echo  $form->field($model, 'channel')->widget(Typeahead::classname(), [
                                'options' => ['placeholder' => 'Channel'],
                                'pluginOptions' => ['highlight' => true],
                                'dataset' => [
                                    [
                                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                        'display' => 'value',
                                        'remote' => [
                                            'url' => Url::to(['channel/get_channel_name']) . '?name=%QUERY',
                                            'wildcard' => '%QUERY'
                                        ]
                                    ]],
                            ])
                ?>
                <?= $form->field($model, 'tracking_link')->textInput() ?>
                <div class="form-group">
                    <?= Html::button('Test', ['class' => 'btn btn-primary', 'onclick' => 'testPost();', '']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
    <script type="application/javascript">
        function testPost() {
            $('#test-link-form').yiiActiveForm('validate');
            var $form = $("#test-link-form"), data = $form.data("yiiActiveForm");
            $.each(data.attributes, function () {
                this.status = 3;
            });
            $form.yiiActiveForm("validate");
            if ($("#test-link-form").find(".has-error").length) {
                return false;
            }

            $.ajax({
                url: '<?php echo Yii::$app->request->baseUrl . '/deliver/testlink' ?>',
                type: 'post',
                data: {
                    'TestLinkForm[tracking_link]': $('#testlinkform-tracking_link').val(),
                    'TestLinkForm[channel]': $('#testlinkform-channel').val(),
                    _csrf: '<?=Yii::$app->request->getCsrfToken()?>'
                },
                success: function (data) {
                    alert(data);
                    console.log(data);
                }
            });
        }
    </script>
</div>