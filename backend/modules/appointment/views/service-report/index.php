<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\Appointment;
use common\models\Services;
use common\models\Contacts;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AppointmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Service Based Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .form-control {
        height: 36px;
    }
</style>
<div class="appointment-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

                </div>
                <div class="panel-body">
                    <div class="row">
                        <?php $form = ActiveForm::begin(); ?>
                        <?php
                        $services = Services::find()->where(['status' => 1])->all();
                        ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="to_date">Service</label>
                                <select name="service_name" id="service-name" class="form-control">
                                    <option value="">Select Service</option>
                                    <?php foreach ($services as $value) { ?>
                                        <option value="<?= $value->id ?>" <?= $service == $value->id ? 'selected' : '' ?>><?= $value->service ?></option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="from_date">From Date</label>
                                <?php
                                echo DatePicker::widget([
                                    'name' => 'from_date',
                                    'value' => $from_date,
                                    //'language' => 'ru',
                                    'dateFormat' => 'yyyy-MM-dd',
                                    'options' => ['class' => 'form-control']
                                ]);
                                ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="to_date">To Date</label>
                                <?php
                                echo DatePicker::widget([
                                    'name' => 'to_date',
                                    'value' => $to_date,
                                    //'language' => 'ru',
                                    'dateFormat' => 'yyyy-MM-dd',
                                    'options' => ['class' => 'form-control']
                                ]);
                                ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?= Html::submitButton('Search', ['class' => 'btn btn-secondary', 'style' => 'margin-top: 30px;padding: 8px 20px;']) ?>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>
                    <?php
                    $gridColumns = [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'apponitment_id',
                            'label' => 'Appointment',
                            'value' => function ($data) {
                                if (isset($data->apponitment_id) && $data->apponitment_id != '') {
                                    return Appointment::findOne($data->apponitment_id)->appointment_no;
                                } else {
                                    return '';
                                }
                            },
                        ],
                        [
                            'attribute' => 'service_id',
                            'label' => 'Service',
                            'value' => function ($data) {
                                if (isset($data->service_id) && $data->service_id != '') {
                                    return Services::findOne($data->service_id)->service;
                                } else {
                                    return '';
                                }
                            },
                        ],
                        [
                            'attribute' => 'supplier',
                            'value' => function ($data) {
                                if (isset($data->supplier) && $data->supplier != '') {
                                    return Contacts::findOne($data->supplier)->name;
                                } else {
                                    return '';
                                }
                            },
                        ],
                        [
                            'attribute' => 'tax_amount',
                            'value' => function ($data) {
                                if (isset($data->tax_amount) && $data->tax_amount != '') {
                                    return $data->tax_amount;
                                } else {
                                    return '';
                                }
                            },
                        ],
                        [
                            'attribute' => 'fda',
                            'label' => 'FDA Amount',
                            'value' => function ($data) {
                                if (isset($data->fda) && $data->fda != '') {
                                    return $data->fda;
                                } else {
                                    return '';
                                }
                            },
                        ],
                        [
                            'attribute' => 'DOC',
                            'label' => 'Date',
                            'value' => function ($data) {
                                if (isset($data->DOC) && $data->DOC != '') {
                                    return $data->DOC;
                                } else {
                                    return '';
                                }
                            },
                        ],
                    ];
                    echo ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $gridColumns,
                    ]);
                    echo \kartik\grid\GridView::widget([
                        'dataProvider' => $dataProvider,
//                        'filterModel' => $searchModel,
                        'columns' => $gridColumns
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2.css">
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2-bootstrap.css">
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/multiselect/css/multi-select.css">
<script src="<?= Yii::$app->homeUrl; ?>js/select2/select2.min.js"></script>
<script src="<?= Yii::$app->homeUrl; ?>js/multiselect/js/jquery.multi-select.js"></script>
<script>
    $(document).ready(function () {
        $("#service-name").select2({
            allowClear: true
        }).on('select2-open', function ()
        {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
    });
</script>


