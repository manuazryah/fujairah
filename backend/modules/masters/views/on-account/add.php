<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use common\models\Debtor;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use common\components\AppointmentWidget;
use common\models\OnAccount;
use yii\grid\GridView;
use common\models\Appointment;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $model common\models\EstimatedProforma */

$this->title = 'On Account';
$this->params['breadcrumbs'][] = ['label' => ' On Account', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$credit_total = OnAccount::getTotal($dataProvider->getModels(), 1);
$debit_total = OnAccount::getTotal($dataProvider->getModels(), 2);
?>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h2  class="appoint-title panel-title"><?= Html::encode($this->title) ?></h2>

            </div>
            <?php //Pjax::begin();          ?>
            <div class="panel-body table-responsive">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="form-group ">
                        <table cellspacing="0" class="table table-small-font table-bordered table-striped" style="">
                            <tr>
                                <th></th>
                                <th>Credit Amount</th>
                                <th>Debit Amount</th>
                                <th>Balance Amount</th>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td><?= sprintf('%0.2f', $credit_total); ?></td>
                                <td><?= sprintf('%0.2f', $debit_total); ?></td>
                                <td><?= sprintf('%0.2f', ($credit_total - $debit_total)); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

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
                        [
                            'attribute' => 'debtor_id',
                            'label' => 'Debtor',
                            'value' => function($data) {
                                return Debtor::findOne($data->debtor_id)->principal_id;
                            },
                            'filter' => ArrayHelper::map(Debtor::find()->asArray()->all(), 'id', 'principal_id'),
                            'filterOptions' => array('id' => "principal_name_search"),
                        ],
                        [
                            'attribute' => 'appointment_id',
                            'label' => 'Appointment No',
                            'value' => function($data) {
                                if (isset($data->appointment_id)) {
                                    return Appointment::findOne($data->appointment_id)->appointment_no;
                                } else {
                                    return '';
                                }
                            },
                            'filter' => ArrayHelper::map(Appointment::find()->asArray()->all(), 'id', 'appointment_no'),
                            'filterOptions' => array('id' => "appointment_no_search"),
                        ],
                        [
                            'attribute' => 'transaction_type',
                            'label' => 'Transaction Type',
                            'format' => 'raw',
                            'filter' => [1 => 'Credit', 2 => 'Debit'],
                            'value' => function($data) {
                                if ($data->transaction_type == 1) {
                                    $tracsaction_type = 'Credit';
                                } elseif ($data->transaction_type == 2) {
                                    $tracsaction_type = 'Debit';
                                } else {
                                    $tracsaction_type = '';
                                }
                                return $tracsaction_type;
                            },
                        ],
                        [
                            'attribute' => 'payment_type',
                            'format' => 'raw',
                            'filter' => [1 => 'Cash', 2 => 'Cheque'],
                            'value' => function($data) {
                                if ($data->payment_type == 1) {
                                    $payment_type = 'Cash';
                                } elseif ($data->payment_type == 2) {
                                    $payment_type = 'Cheque';
                                } else {
                                    $payment_type = '';
                                }
                                return $payment_type;
                            },
                        ],
                        [
                            'attribute' => 'check_no',
                            'value' => function($data) {
                                if (isset($data->check_no)) {
                                    return $data->check_no;
                                } else {
                                    return '';
                                }
                            },
                        ],
                        [
                            'attribute' => 'amount',
                            'value' => function($data) {
                                if (isset($data->amount)) {
                                    return Yii::$app->SetValues->NumberFormat($data->amount);
                                } else {
                                    return '';
                                }
                            },
                        ],
                        [
                            'attribute' => 'balance',
                            'value' => function($data) {
                                if (isset($data->balance)) {
                                    return Yii::$app->SetValues->NumberFormat($data->balance);
                                } else {
                                    return '';
                                }
                            },
                        ],
                        [
                            'attribute' => 'date',
                            'value' => function($data) {
                                if (isset($data->date)) {
                                    return $data->date;
                                } else {
                                    return '';
                                }
                            },
                            'filter' => DateRangePicker::widget(['model' => $searchModel, 'attribute' => 'date', 'pluginOptions' => ['format' => 'yyyy-mm-dd hh:ii:ss', 'autoUpdateInput' => false]]),
                        ],
                    // 'amount',
                    // 'balance',
                    // 'appointment_id',
                    // 'debtor_id',
                    // 'comment:ntext',
                    // 'status',
                    // 'CB',
                    // 'UB',
                    // 'DOC',
                    // 'DOU',
//                            ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]);
                ?>


                <div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true" data-add-focus-btn="true">

                    <table cellspacing="0" class="table table-small-font table-bordered table-striped">
                        <thead>
                            <tr>
                                <th data-priority="3">Payment_type</th>
                                <th data-priority="6" >Check No</th>
                                <th data-priority="6">Amount</th>
                                <th data-priority="6">Date</th>
                                <th data-priority="6">Comments</th>
                                <th data-priority="6">Status</th>
                                <th data-priority="1">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="filter">
                                <?php $form = ActiveForm::begin(); ?>
                                <td><?= $form->field($model, 'payment_type')->dropDownList(['1' => 'Cash', '2' => 'Check'], ['prompt' => '-Payment Type-'])->label(false) ?></td>
                                <td><?= $form->field($model, 'check_no')->textInput(['placeholder' => 'Check Number'])->label(false) ?></td>
                                <td><?= $form->field($model, 'amount')->textInput(['placeholder' => 'Amount'])->label(false) ?></td>
                                <td>
                                    <?=
                                    $form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), [
                                        //'language' => 'ru',
                                        'dateFormat' => 'yyyy-MM-dd',
                                        'options' => ['class' => 'form-control', 'placeholder' => 'Date']
                                    ])->label(false)
                                    ?>
                                </td>
                                <td><?= $form->field($model, 'comment')->textInput(['placeholder' => 'Comments'])->label(false) ?></td>
                                <td><?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '2' => 'Disabled'])->label(false) ?></td>
                                <td><?= Html::submitButton($model->isNewRecord ? 'Add' : 'Update', ['class' => 'btn btn-success']) ?>
                                </td>
                                <?php ActiveForm::end(); ?>


                        </tbody>
                    </table>
                    <div>
                        <?php
                        // echo Html::a('<span>Back to Close Estimate</span>', ['/appointment/close-estimate/add', 'id' => $appointment->id], ['class' => 'btn btn-secondary']);
                        ?>
                    </div>
                </div>



                <script type="text/javascript">
                    jQuery(document).ready(function ($)
                    {
                        $("#actualfunding-service_id").prop("disabled", true);

                        $("#actualfunding-fda_amount").prop("disabled", true);

                        $("#actualfunding-amount_difference").prop("disabled", true);

                    });</script>


                <link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2.css">
                <link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2-bootstrap.css">
                <script src="<?= Yii::$app->homeUrl; ?>js/select2/select2.min.js"></script>

            </div>
            <?php //Pjax::end();            ?>
        </div>
    </div>
</div>

<div class="modal fade" id="add-sub">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Dynamic Content</h4>
            </div>

            <div class="modal-body">

                Content is loading...

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info">Save changes</button>
            </div>
        </div>
    </div>
    <style>
        .filter{
            background-color: #b9c7a7;
        }
    </style>
</div>
<script>
                    $(document).ready(function () {
                        $("#onaccount-check_no").prop("disabled", true);
                        $('#onaccount-payment_type').change(function () {
                            var payment_id = $(this).val();
                            if (payment_id == 2) {
                                $("#onaccount-check_no").prop("disabled", false);
                            } else {
                                $("#onaccount-check_no").prop("disabled", true);
                            }
                        });
                        $(".filters").slideToggle();
                        $("#search-option").click(function () {
                            $(".filters").slideToggle();
                        });
                    });
</script>