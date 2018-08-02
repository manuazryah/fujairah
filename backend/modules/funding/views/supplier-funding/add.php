<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use common\models\Contacts;
use common\models\Debtor;
use common\models\Appointment;
use common\models\Services;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use common\components\AppointmentWidget;
use common\models\FundingAllocation;
use common\models\SupplierFunding;
use common\models\ActualFunding;
use kartik\datetime\DateTimePicker;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\EstimatedProforma */

$this->title = 'Funding allocation';
$this->params['breadcrumbs'][] = ['label' => ' Actual Funding', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .btn.btn-icon-standalone i, .btn.btn-icon-standalone span {
        display: block;
        padding: 8px 12px;
    }
</style>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h2  class="appoint-title panel-title"><?= Html::encode($this->title) . ' # <b style="color: #008cbd;">' . $appointment->appointment_no . '</b>' ?></h2>

            </div>
            <?php //Pjax::begin();          ?>
            <div class="panel-body">
                <?= AppointmentWidget::widget(['id' => $appointment->id]) ?>

                <hr class="appoint_history" />
                <ul class="estimat nav nav-tabs nav-tabs-justified">
                    <li>
                        <?php
                        echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Pre-Funding</span>', ['funding-allocation/add', 'id' => $appointment->id]);
                        ?>

                    </li>
                    <li>
                        <?php
                        echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Actual Price</span>', ['actual-funding/add', 'id' => $appointment->id]);
                        ?>

                    </li>
                    <li class="active">
                        <?php
                        echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Supplier Funding</span>', ['supplier-funding/add', 'id' => $appointment->id]);
                        ?>

                    </li>
                </ul>
                <?= Html::beginForm(['supplier-funding/save-supplier-price'], 'post') ?>
                <div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true" data-add-focus-btn="true">


                    <input type="hidden" name="app_id" value="<?= $id; ?>" />
                    <table cellspacing="0" class="table table-small-font table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>SERVICES</th>
                                <th>SUPPLIER</th>
                                <th>ACTUAL AMOUNT</th>
                                <th>DEBITED AMOUNT</th>
                                <th>BALANCE AMOUNT</th>
                                <th>INVOICE NUMBER</th>
                                <th>INVOICE DATE</th>
                                <!--<th data-priority="1">ACTIONS</th>-->
                            </tr>
                        </thead>
                        <?php
                        if (!empty($supplier_fundings)) {
                            ?>
                            <tbody>

                                <?php
                                $j = 0;
                                $fda = 0;
                                $actual_total = 0;
                                $amount_debit_total = 0;
                                $balance = 0;
                                $balance_total = 0;
                                foreach ($close_estimates as $close_estimate) {
                                    $j++;
                                    ?>
                                    <tr class="filter">
                                        <td><?= $j; ?></td>
                                        <td><?= Services::findOne($close_estimate->service_id)->service; ?></td>
                                        <td><?= $close_estimate->supplier != '' ? Contacts::findOne($close_estimate->supplier)->name : '' ?></td>
                                        <?php
                                        $actual_funding = ActualFunding::findOne(['close_estimate_id' => $close_estimate->id]);
                                        ?>
                                        <td>
                                            <?php
                                            if (isset($actual_funding->actual_amount)) {
                                                echo Yii::$app->SetValues->NumberFormat($actual_funding->actual_amount);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $funding = SupplierFunding::findAll(['close_estimate_id' => $close_estimate->id]);
                                            $debit_balance = 0;
                                            $fund_balance = 0;
                                            foreach ($funding as $fund) {
                                                $debit_balance += $fund->amount_debit;
                                                $balance += $fund->amount_debit;
                                                if ($fund->amount_debit != '') {
                                                    ?>
                                                    <span>
                                                        <?php
                                                        if (isset($fund->amount_debit)) {
                                                            echo Yii::$app->SetValues->NumberFormat($fund->amount_debit);
                                                        }
                                                        ?>
                                                    </span><br/>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <input class="form-control" type="text" name="amount_debit[<?= $close_estimate->id; ?>]" value="" />
                                        </td>
                                        <td>
                                            <?php
                                            if (isset($actual_funding->actual_amount)) {
                                                echo Yii::$app->SetValues->NumberFormat($actual_funding->actual_amount - $debit_balance);
                                            }
                                            ?>
                                            <?php // $actual_funding->actual_amount - $debit_balance; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $Supfunding = SupplierFunding::findOne(['close_estimate_id' => $close_estimate->id]);
                                            if (isset($Supfunding->invoice_number)) {
                                                $invoice_no = $Supfunding->invoice_number;
                                                $invoice_date = $Supfunding->invoice_date;
                                            } else {
                                                $invoice_no = '';
                                                $invoice_date = '';
                                            }
                                            ?>
                                            <input class="form-control" type="text" name="invoice_number[<?= $close_estimate->id; ?>]" value="<?= $invoice_no ?>" />
                                        </td>
                                        <td>
                                            <?php
                                            echo DatePicker::widget([
                                                'name' => 'invoice_date[' . $close_estimate->id . ']',
                                                'value' => $invoice_date,
                                                'dateFormat' => 'yyyy-MM-dd',
                                                'options' => ['class' => 'form-control']
                                            ]);
//                                            echo DateTimePicker::widget([
//                                                'name' => 'invoice_date[' . $close_estimate->id . ']',
//                                                'type' => DateTimePicker::TYPE_INPUT,
//                                                'value' => $invoice_date,
//                                                'pluginOptions' => [
//                                                    'autoclose' => true,
//                                                    'format' => 'yyyy-mm-dd hh:ii:ss'
//                                                ]
//                                            ]);
                                            ?>
                                            <!--<input type="text" name="invoice_date[<?= $close_estimate->id; ?>]" value="<?= $invoice_date ?>" />-->
                                        </td>
                                        <!--<td><?php // Html::a('<i class="fa fa-pencil"></i>', ['/funding/actual-funding/add', 'id' => $id, 'fund_id' => $fund->id], ['class' => '', 'tittle' => 'Edit'])                                                                                                                                                                        ?></td>-->
                                        <?php
                                        $actual_total = $actual_total += $actual_funding->actual_amount;
                                        $amount_debit_total += $debit_balance;
                                        $balance_total += $actual_funding->actual_amount - $debit_balance;
                                        ?>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td colspan="3">Total</td>
                                    <td>
                                        <?php
                                        if (isset($actual_total)) {
                                            echo Yii::$app->SetValues->NumberFormat($actual_total);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($amount_debit_total)) {
                                            echo Yii::$app->SetValues->NumberFormat($amount_debit_total);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($balance_total)) {
                                            echo Yii::$app->SetValues->NumberFormat($balance_total);
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        <?php } else {
                            ?>
                            <tr>
                                <td colspan="8"><span class="fund-erro">Close Estimate is empty for this appointment. Please add close estimate</span></td>
                                <td>
                                    <?= Html::a('<i class="fa-share"></i><span> Add Close Estimate</span>', ['/appointment/close-estimate/add', 'id' => $id], ['class' => 'btn btn-blue btn-icon btn-icon-standalone btn-icon-standalone-right']) ?>
                                </td>
                            </tr>
                        <?php }
                        ?>
                    </table>

                </div>
                <div class="col-md-4" style="float:right;">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-black', 'style' => 'float:right;']) ?>
                    <?= Html::endForm() ?>
                    <?php ?>
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

<!--                                <script>
                                        $(document).ready(function () {
                                                $("#closeestimatesubservice-unit").keyup(function () {
                                                        multiply();
                                                });
                                                $("#closeestimatesubservice-unit_price").keyup(function () {
                                                        multiply();
                                                });
                                        });
                                        function multiply() {
                                                var rate = $("#closeestimatesubservice-unit").val();
                                                var unit = $("#closeestimatesubservice-unit_price").val();
                                                if (rate != '' && unit != '') {
                                                        $("#closeestimatesubservice-total").val(rate * unit);
                                                }

                                        }
                                        $("#closeestimatesubservice-total").prop("disabled", true);
                                        $("#fundingallocation-check_no").prop("disabled", true);
                                        $('#fundingallocation-payment_type').change(function () {
                                                var payment_id = $(this).val();
                                                if (payment_id == 2) {
                                                        $("#fundingallocation-check_no").prop("disabled", false);
                                                } else {
                                                        $("#fundingallocation-check_no").prop("disabled", true);
                                                }
                                        });
                                </script>-->
            </div>
            <?php //Pjax::end();             ?>
        </div>
    </div>
</div>
<!--<a href="javascript:;" onclick="showAjaxModal();" class="btn btn-primary btn-single btn-sm">Show Me</a>
 Modal code
<script type="text/javascript">
        function showAjaxModal(id)
        {
            jQuery('#add-sub').modal('show', {backdrop: 'static'});
            jQuery('#add-sub .modal-body').html(id);
            /*setTimeout(function ()
             {
             jQuery.ajax({
             url: "data/ajax-content.txt",
             success: function (response)
             {
             jQuery('#modal-7 .modal-body').html(response);
             }
             });
             }, 800); // just an example
             */
        }
</script>-->
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
