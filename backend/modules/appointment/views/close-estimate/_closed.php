<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use common\models\Services;
use common\models\Currency;
use common\models\Contacts;
use common\models\CloseEstimate;
use common\models\Debtor;
use common\models\InvoiceType;
use common\models\Vessel;
use common\models\Employee;
use common\models\FdaReport;
use common\models\InvoiceNumber;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use common\components\AppointmentWidget;

/* @var $this yii\web\View */
/* @var $model common\models\EstimatedProforma */

$this->title = 'Create Close Estimte';
$this->params['breadcrumbs'][] = ['label' => 'Close Estimte', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h2  class="appoint-title panel-title"><?= Html::encode($this->title) . ' # <b style="color: #008cbd;">' . $appointment->appointment_no . '</b>' ?></h2>

            </div>
            <?php //Pjax::begin();  ?>
            <div class="panel-body">

                <?= AppointmentWidget::widget(['id' => $appointment->id]) ?>


                <hr class="appoint_history" />
                <div>
                    <h2 style="text-align: center;color: red;">Appointment Closed</h2>
                </div>
                <hr class="appoint_history" />
                <ul class="estimat nav nav-tabs nav-tabs-justified">
                    <li>
                        <?php
                        echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Appointment</span>', ['appointment/update', 'id' => $appointment->id]);
                        ?>

                    </li>
                    <li>
                        <?php
                        echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Estimated Proforma</span>', ['estimated-proforma/add', 'id' => $appointment->id]);
                        ?>

                    </li>
                    <li>
                        <?php
                        echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Port call Data</span>', ['port-call-data/update', 'id' => $appointment->id]);
                        ?>

                    </li>
                    <li class="active">
                        <?php
                        echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Close Estimate</span>', ['close-estimate/add', 'id' => $appointment->id]);
                        ?>

                    </li>
                </ul>
                <div class="outterr">
                    <div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true" data-add-focus-btn="true">

                        <table cellspacing="0" class="table table-small-font table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="1">SERVICES</th>
                                    <th data-priority="3">SUPPLIER</th>
    <!--                                                                <th data-priority="3">CURRENCY</th>-->
                                    <th data-priority="1">RATE /QTY</th>
                                    <th data-priority="3">QTY</th>
    <!--                                                                <th data-priority="6">ROE</th>-->
                                    <th data-priority="6">EPDA VALUE</th>
                                    <th data-priority="6">FDA VALUE</th>
                                    <th data-priority="6">PAYMENT TYPE</th>
                                    <th data-priority="6">TOTAL</th>
                                    <th data-priority="6">INVOICE TYPE</th>
                                    <th data-priority="6">PRINCIPAL</th>
                                    <th data-priority="6">COMMENTS</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $i = 0;
                                $grandtotal = 0;
                                $epdatotal = 0;
                                $fdatotal = 0;
                                var_dump($estimates);
                                exit;
                                foreach ($estimates as $estimate):
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><span class="co-name"><?= $estimate->service->service ?></span></td>
                                        <td><?= isset($estimate->supplier0->name) ? $estimate->supplier0->name : '' ?></td>
        <!--                                                                <td><? //$estimate->currency0->currency_symbol ?></td>-->
                                        <td><?= $estimate->unit_rate; ?></td>
                                        <td><?= $estimate->unit; ?></td>
        <!--                                                                <td><? $estimate->roe; ?></td>-->
                                        <td><?= $estimate->epda; ?></td>
                                        <td><?= $estimate->fda; ?></td>
                                        <?php
                                        if ($estimate->payment_type == 1) {
                                            $payment_type = 'Manual';
                                        } elseif ($estimate->payment_type == 2) {
                                            $payment_type = 'Check';
                                        } else {
                                            $payment_type = '';
                                        }
                                        ?>
                                        <td><?= $payment_type; ?></td>
                                        <td><?= $estimate->total; ?></td>
                                        <td><?= $estimate->invoice->invoice_type ?></td>
                                        <td><?= $estimate->principal0->principal_name; ?></td>
                                        <td><?= $estimate->comments; ?></td>
                                        <?php
                                        $epdatotal += $estimate->epda;
                                        $fdatotal += $estimate->fda;
                                        $grandtotal += $estimate->total;
                                        ?>
                                    </tr>

                                    <?php
                                endforeach;
                                ?>
                                <tr>
                                    <td></td>
                                    <td colspan="4"> <b>GRAND TOTAL</b></td>
                                    <td style="font-weight: bold;"><?php echo $epdatotal . '/-'; ?></td>
                                    <td style="font-weight: bold;"><?php echo $fdatotal . '/-'; ?></td>
                                    <td></td>
                                    <td style="font-weight: bold;"><?php echo $grandtotal . '/-'; ?></td>
                                    <td colspan=""></td>
                                </tr>
                                <tr></tr>

                                <!-- Repeat -->

                            </tbody>

                        </table>
                        <br/>
                    </div>
                </div>
                <script>
                    $("document").ready(function () {
                        $('#closeestimate-service_id').change(function () {
                            var service_id = $(this).val();
                            $.ajax({
                                type: 'POST',
                                cache: false,
                                data: {service_id: service_id},
                                url: '<?= Yii::$app->homeUrl; ?>appointment/close-estimate/supplier',
                                success: function (data) {
                                    if (data == 1) {
                                        $("#closeestimate-supplier").prop('disabled', false);
                                    } else {
                                        $("#closeestimate-supplier").prop('disabled', true);
                                    }
                                }
                            });
                        });

                    });
                </script>
                <script type="text/javascript">
                    jQuery(document).ready(function ($)
                    {
                        $("#closeestimate-service_id").select2({
                            //placeholder: 'Select your country...',
                            allowClear: true
                        }).on('select2-open', function ()
                        {
                            // Adding Custom Scrollbar
                            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                        });



                        $("#closeestimate-supplier").select2({
                            //placeholder: 'Select your country...',
                            allowClear: true
                        }).on('select2-open', function ()
                        {
                            // Adding Custom Scrollbar
                            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                        });

                        $("#estimatedproforma-currency").select2({
                            //placeholder: 'Select your country...',
                            allowClear: true
                        }).on('select2-open', function ()
                        {
                            // Adding Custom Scrollbar
                            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                        });


                        $("#closeestimate-principal").select2({
                            //placeholder: 'Select your country...',
                            allowClear: true
                        }).on('select2-open', function ()
                        {
                            // Adding Custom Scrollbar
                            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                        });



                    });
                </script>

                <script>
                    $(document).ready(function () {
                        $("#closeestimate-unit_rate").keyup(function () {
                            multiply();
                        });
                        $("#closeestimate-unit").keyup(function () {
                            multiply();
                        });
                    });
                    function multiply() {
                        var rate = $("#closeestimate-unit_rate").val();
                        var unit = $("#closeestimate-unit").val();
                        if (rate != '' && unit != '') {
                            $("#closeestimate-epda").val(rate * unit);
                        }

                    }
                    $("#closeestimate-epda").prop("disabled", true);
                </script>


                <link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2.css">
                <link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2-bootstrap.css">
                <script src="<?= Yii::$app->homeUrl; ?>js/select2/select2.min.js"></script>


            </div>
            <?php //Pjax::end();          ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2  class="appoint-title panel-title">Previously Generated FDA'S  &  Uploaded Files</h2>

                </div>
                <?php //Pjax::begin();  ?>
                <div class="panel-body">
                    <div class="row">

                        <div class="col-md-12" style="margin-left: 0px;">
                            <h4 class="sub-heading">Previously Generated FDA'S</h4>
                            <br/>
                            <div class="row mgleft-padd">
                                <?php
                                $estmate_reports = InvoiceNumber::findAll(['appointment_id' => $appointment->id]);
                                ?>
                                <?php
                                foreach ($estmate_reports as $estmate_report) {
                                    $invoice_number = InvoiceType::findOne($estmate_report->invoice_type)->invoice_type . '-' . $estmate_report->sub_invoice;
                                    if ($estmate_report->principal_id != '') {
                                        $princip_name1 = Debtor::findOne(['id' => $estmate_report->principal_id])->principal_name;
                                    } else {
                                        $princip_name1 = '';
                                    }
                                    ?>
                                    <div class="row" style="width: 180px;display: inline-block;" title="<?= $princip_name1 ?>">
                                        <div class="upload_file_list" style="float:left;height: 55px;">
                                            <div>
                                                <!--<span class=""><?php // echo Html::a($invoice_number, ['/appointment/close-estimate/show-report'], ['onclick' => "window.open('/appointment/close-estimate/show-report?id=$estmate_report->id', 'newwindow', 'width=750, height=500');return false;"]) . '&nbsp;&nbsp;';      ?></span>-->
                                                <span class=""><?php echo Html::a($invoice_number, ['/appointment/close-estimate/show-report', 'id' => $estmate_report->id], ['target' => "_blank"]) . '&nbsp;&nbsp;'; ?></span>
                                            </div>
                                            <div style="color:#676262;">
                                                <?php
                                                if (isset($estmate_report->CB)) {
                                                    echo Employee::findOne($estmate_report->CB)->user_name;
                                                }
                                                ?>

                                            </div>
                                        </div>
                                        <div class="upload_file_list" style="float:left;height: 55px;">
                                            <div>
                                                <span style="font-size: 20px;"><?= Html::a('<i class="fa fa-remove"></i>', ['/appointment/close-estimate/remove-report', 'id' => $estmate_report->id, 'est_id' => $estmate_report->estimate_id], ['class' => '']) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                $estmate_all_reports = FdaReport::findAll(['appointment_id' => $appointment->id]);
                                ?>
                                <?php
                                foreach ($estmate_all_reports as $estmate_all_report) {
//                                                                        $invoice_number = InvoiceType::findOne($estmate_report->invoice_type)->invoice_type . '-' . $estmate_report->sub_invoice;
                                    if ($estmate_all_report->principal_id != '') {
                                        $princip_name = Debtor::findOne(['id' => $estmate_all_report->principal_id])->principal_name;
                                    } else {
                                        $princip_name = '';
                                    }
                                    ?>
                                    <div class="row" style="width: 170px;display: inline-block;" title="<?= $princip_name ?>">
                                        <div class="upload_file_list" style="float:left;height: 55px;">
                                            <div>
                                                <!--<span class=""><?php // echo Html::a($estmate_all_report->invoice_number, ['/appointment/close-estimate/show-all-report'], ['onclick' => "window.open('/appointment/close-estimate/show-all-report?id=$estmate_all_report->id', 'newwindow', 'width=1200, height=500');return false;"]) . '&nbsp;&nbsp;';    ?></span>-->
                                                <span class=""><?php echo Html::a($estmate_all_report->invoice_number, ['/appointment/close-estimate/show-all-report', 'id' => $estmate_all_report->id], ['target' => "_blank"]) . '&nbsp;&nbsp;'; ?></span>
                                            </div>
                                            <div style="color:#676262;">
                                                <?php
                                                if (isset($estmate_all_report->CB)) {
                                                    echo Employee::findOne($estmate_all_report->CB)->user_name;
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="upload_file_list" style="float:left;height: 55px;">
                                            <div>
                                                <span style="font-size: 20px;"><?= Html::a('<i class="fa fa-remove"></i>', ['/appointment/close-estimate/remove-all-report', 'id' => $estmate_all_report->id], ['class' => '']) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <hr class="appoint_history" />
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="sub-heading">Uploaded Files</h4>
                            <br/>
                            <div style="margin-left:15px;">
                                <?php
                                if (!empty(Yii::$app->UploadFile->ListFile($appointment->id, Yii::$app->params['closePath']))) {
                                    $string = Yii::$app->UploadFile->ListFile($appointment->id, Yii::$app->params['closePath']);
                                    $uploads = explode("|", $string);
                                    array_pop($uploads);
                                    foreach ($uploads as $upload) {
                                        ?>
                                        <span class="upload_file_list upload_file_list1"><?= $upload ?></span>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div style="float:right;padding-top: 5px;">
                        <?php if ($token == 1) { ?>
                            <button class="btn btn-red">Closed</button>
                            <?php
                        } else {
                            echo Html::a('<span> Close Estimate Completed</span>', ['close-estimate/estimate-complete', 'id' => $appointment->id], ['class' => 'btn btn-secondary']);
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .filter{
            background-color: #b9c7a7;
        }
        table.table tr td:last-child a {
            padding: 0px 4px;
        }
        .principp{
            display:none;
        }
    </style>
</div>