<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\VesselType;
use common\models\Vessel;
use common\models\Ports;
use common\models\Debtor;
use common\models\Terminal;
use common\models\Stages;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AppointmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Appointments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appointment-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

                </div>
                <div class="panel-body table-responsive">
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= Html::a('<i class="fa-th-list"></i><span> Create Appointment</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <button class="btn btn-white" id="search-option" style="float: right;">
                        <i class="linecons-search"></i>
                        <span>Search</span>
                    </button>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            //  'id',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'template' => '{view}{update}',
                            ],
                            [
                                'attribute' => 'vessel_type',
                                'value' => function($data) {
                                    return VesselType::findOne($data->vessel_type)->vessel_type;
                                },
                                'filter' => ArrayHelper::map(VesselType::find()->asArray()->all(), 'id', 'vessel_type'),
                                'filterOptions' => array('id' => "vessel_type_search"),
                            ],
                            [
                                'attribute' => 'vessel',
                                'value' => function($data) {
                                    if ($data->vessel_type == 1) {
                                        return 'T -' . Vessel::findOne($data->tug)->vessel_name . ' / B -' . Vessel::findOne($data->barge)->vessel_name;
                                    } else {
                                        if (isset($data->vessel)) {
                                            return Vessel::findOne($data->vessel)->vessel_name;
                                        }
                                    }
                                    // return Vessel::findOne($data->vessel)->vessel_name;
                                },
                                'filter' => ArrayHelper::map(Vessel::find()->asArray()->all(), 'id', 'vessel_name'),
                                'filterOptions' => array('id' => "vessel_search"),
                            ],
                            [
                                'attribute' => 'port_of_call',
                                'value' => function($data) {
                                    return Ports::findOne($data->port_of_call)->port_name;
                                },
                                'filter' => ArrayHelper::map(Ports::find()->asArray()->all(), 'id', 'port_name'),
                                'filterOptions' => array('id' => "port_of_call_search"),
                            ],
                            'eta',
//                                                [
//                                                    'attribute' => 'terminal',
//                                                    'value' => function($data) {
//                                                            return Terminal::findOne($data->terminal)->terminal;
//                                                    },
//                                                    'filter' => ArrayHelper::map(Terminal::find()->asArray()->all(), 'id', 'terminal'),
//                                                ],
                            // 'birth_no',
                            'appointment_no',
                            // 'no_of_principal',
                            [
                                'attribute' => 'principal',
                                'value' => function($data, $key, $index, $column) {
                                    return $data->getPrincip($data->principal);
                                },
                                'filter' => ArrayHelper::map(Debtor::find()->asArray()->all(), 'id', 'principal_id'),
                                'filterOptions' => array('id' => "principal_search"),
                            ],
//                                                'principal',
                            // 'nominator',
                            // 'charterer',
                            // 'shipper',
                            // 'purpose',
                            // 'cargo',
                            // 'quantity',
                            // 'last_port',
                            // 'next_port',
                            // 'eta',
                            [
                                'attribute' => 'invoice_no',
                                'format' => 'raw',
                                'value' => function($data, $key, $index, $column) {
                                    return $data->getInvoiceNo($data->id);
                                },
                            ],
                            [
                                'attribute' => 'stage',
                                'value' => 'stages0.stage',
                                'filter' => ArrayHelper::map(Stages::find()->asArray()->all(), 'id', 'stage'),
                            ],
//                             'stage',
//                            [
//                                'attribute' => 'status',
//                                'format' => 'raw',
//                                'filter' => [1 => 'Enabled', 0 => 'disabled'],
//                                'value' => function ($model) {
//                                return $model->status == 1 ? 'Enabled' : 'disabled';
//                        },
//                            ],
                            // 'CB',
                            // 'UB',
                            // 'DOC',
                            // 'DOU',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'template' => '{view}{update}',
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .form-control1 {
        width: 20% !important;
        padding: 5px;
    }
    .btn{
        margin-top: 11px !important;
    }
</style>
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2.css">
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2-bootstrap.css">
<script src="<?= Yii::$app->homeUrl; ?>js/select2/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#vessel_type_search select').attr('id', 'vessel_type');
        $('#vessel_search select').attr('id', 'vessel');
        $('#port_of_call_search select').attr('id', 'port_of_call');
        $('#principal_search select').attr('id', 'principal');
        $(".filters").slideToggle();
        $("#search-option").click(function () {
            $(".filters").slideToggle();
        });
        /*********** Script for dropdown search widget start ********************/

        $("#vessel_type").select2({
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#vessel").select2({
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#port_of_call").select2({
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#principal").select2({
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });

        /*********** Script for dropdown search widget end ********************/
    });
</script>


