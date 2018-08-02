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

$this->title = 'Petty Cash';
$this->params['breadcrumbs'][] = ['label' => ' Petty Cash', 'url' => ['index']];
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
                <div class="col-lg-12">
                    <?php if (Yii::$app->session->hasFlash('error')): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= Yii::$app->session->getFlash('error') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <hr class="appoint_history" />

                <?= Html::beginForm(['petty-cash-book/save-petty-cash'], 'post') ?>
                <div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true" data-add-focus-btn="true">
                    <?php
                    $user_account = common\models\CashInHand::find()->orderBy(['id' => SORT_DESC])->where(['employee_id' => Yii::$app->user->identity->id])->one();
                    ?>
                    <h5 style="font-weight:bold;color: #f44336;">User Account Balance for :<?= Yii::$app->user->identity->name ?> - <?php if (isset($user_account->balance)) { ?> <?= Yii::$app->SetValues->NumberFormat($user_account->balance) ?> /-<?php } ?> </h5>

                    <input type="hidden" name="app_id" value="<?= $id; ?>" />
                    <table cellspacing="0" class="table table-small-font table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>SERVICES</th>
                                <th>SUPPLIER</th>
                                <th>FDA AMOUNT</th>
                                <th>ACTUAL AMOUNT</th>
                                <th>AMOUNT</th>
                                <th>PRINCIPAL</th>
                                <th>DATE</th>
                                <!--<th data-priority="1">ACTIONS</th>-->
                            </tr>
                        </thead>
                        <?php
                        if (!empty($model_petty_cash)) {
                            ?>
                            <tbody>

                                <?php
                                $j = 0;
                                $fda = 0;
                                $amount_debit_total = 0;
                                $actual_total = 0;
                                $balance_total = 0;
                                foreach ($close_estimates as $close_estimate) {
                                    $j++;
                                    ?>
                                    <tr class="filter">
                                        <td><?= $j; ?></td>
                                        <td><?= Services::findOne($close_estimate->service_id)->service; ?></td>
                                        <td><?= $close_estimate->supplier != '' ? Contacts::findOne($close_estimate->supplier)->name : '' ?></td>
                                        <td><?= Yii::$app->SetValues->NumberFormat($close_estimate->fda); ?></td>
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
                                            $funding = common\models\PettyCashBook::findAll(['close_estimate_id' => $close_estimate->id]);
                                            $debit_balance = 0;
                                            $fund_balance = 0;
                                            $balance = 0;
                                            foreach ($funding as $fund) {
                                                $debit_balance += $fund->amount_debit;
                                                $balance += $fund->amount_debit;
                                                if ($fund->amount_debit != '') {
                                                    ?>
                                                    <span><?= Yii::$app->SetValues->NumberFormat($fund->amount_debit) ?></span><br/>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <input class="form-control" type="text" name="amount_debit[<?= $close_estimate->id; ?>]" value="" />
                                        </td>
                                        <td><?= Debtor::findOne($close_estimate->principal)->principal_id; ?></td>
                                        <td>
                                            <?php
                                            $pettycash = common\models\PettyCashBook::findOne(['close_estimate_id' => $close_estimate->id]);
                                            if (isset($pettycash->invoice_date)) {
                                                $invoice_date = $Supfunding->invoice_date;
                                            } else {
                                                $invoice_date = '';
                                            }
                                            ?>
                                            <?php
                                            echo DatePicker::widget([
                                                'name' => 'invoice_date[' . $close_estimate->id . ']',
                                                'value' => $invoice_date,
                                                'dateFormat' => 'yyyy-MM-dd',
                                                'options' => ['class' => 'form-control']
                                            ]);
                                            ?>
                                        </td>
                                        <?php
                                        $actual_total += $actual_funding->actual_amount;
                                        $amount_debit_total += $debit_balance;
                                        $balance_total += $actual_funding->actual_amount - $debit_balance;
                                        ?>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td colspan="5">Total</td>
                                    <td><?= Yii::$app->SetValues->NumberFormat($amount_debit_total); ?></td>
                                    <td></td>
                                    <td></td>
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

            </div>
            <?php //Pjax::end();             ?>
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
