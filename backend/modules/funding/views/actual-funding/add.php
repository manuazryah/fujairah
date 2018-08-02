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
                    <li class="active">
                        <?php
                        echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Actual Price</span>', ['actual-funding/add', 'id' => $appointment->id]);
                        ?>

                    </li>
                    <li>
                        <?php
                        echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Supplier Funding</span>', ['supplier-funding/add', 'id' => $appointment->id]);
                        ?>

                    </li>
                </ul>
                <?= Html::beginForm(['actual-funding/save-actual-price'], 'post') ?>
                <div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true" data-add-focus-btn="true">


                    <input type="hidden" name="app_id" value="<?= $id; ?>" />
                    <table cellspacing="0" class="table table-small-font table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>SERVICES</th>
                                <th>SUPPLIER</th>
                                <th>RATE /QTY</th>
                                <th>QTY</th>
                                <th>FDA AMOUNT</th>
                                <th>ACTUAL AMOUNT</th>
                                <th>AMOUNT DIFFERENCE</th>
                                <!--<th data-priority="1">ACTIONS</th>-->
                            </tr>
                        </thead>
                        <?php
                        if (!empty($actual_fundings)) {
                            ?>
                            <tbody>

                                <?php
                                $j = 0;
                                $fda = 0;
                                $actual_total = 0;
                                $amount_difference = 0;
                                foreach ($actual_fundings as $fund) {
                                    $j++;
                                    ?>
                                    <tr class="filter">
                                        <td><?= $j; ?></td>
                                        <td><?= Services::findOne($fund->service_id)->service; ?></td>
                                        <td><?= $fund->supplier != '' ? Contacts::findOne($fund->supplier)->name : '' ?></td>
                                        <td>
                                            <?php
                                            if (isset($fund->unit_rate)) {
                                                echo Yii::$app->SetValues->NumberFormat($fund->unit_rate);
                                            }
                                            ?>
                                        </td>
                                        <td><?= $fund->unit; ?></td>
                                        <td>
                                            <?php
                                            if (isset($fund->fda_amount)) {
                                                echo Yii::$app->SetValues->NumberFormat($fund->fda_amount);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
//                                            if (isset($fund->actual_amount)) {
//                                                $fund->actual_amount = Yii::$app->SetValues->NumberFormat($fund->actual_amount);
//                                            }
                                            ?>
                                            <input type="text" name="actual_amount[<?= $fund->id; ?>]" value="<?= $fund->actual_amount ?>" />
                                        </td>
                                        <td>
                                            <?php
                                            if (isset($fund->amount_difference)) {
                                                echo Yii::$app->SetValues->NumberFormat($fund->amount_difference);
                                            }
                                            ?>
                                        </td>
                                        <?php
                                        $fda = $fda += $fund->fda_amount;
                                        $actual_total += $fund->actual_amount;
                                        $amount_difference += $fund->amount_difference;
                                        ?>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td colspan="5">Total</td>
                                    <td>
                                        <?php
                                        if (isset($fda)) {
                                            echo Yii::$app->SetValues->NumberFormat($fda);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($actual_total)) {
                                            echo Yii::$app->SetValues->NumberFormat($actual_total);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($amount_difference)) {
                                            echo Yii::$app->SetValues->NumberFormat($amount_difference);
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
