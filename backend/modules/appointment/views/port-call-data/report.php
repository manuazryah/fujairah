<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\SubServices;
use common\models\Appointment;
use common\models\EstimatedProforma;
use common\models\PortCargoDetails;
use common\models\Debtor;
use common\models\PortCallData;
use common\models\Vessel;
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<div id="print">
    <!--<html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <title></title>-->
    <link rel="stylesheet" href="<?= Yii::$app->homeUrl ?>css/pdf.css">
    <style type="text/css">

        @media print {
            thead {display: table-header-group;}
            .main-tabl{width: 100%}
            body,p,tr,td,table,div,span{
                font-family: 'Roboto', sans-serif;
            }
            .main-tabl{
                margin: auto;
            }
            /*thead { display: table-header-group;   }*/
            tfoot{display: table-footer-group;}
            table { page-break-inside:auto;}
            tr{ page-break-inside:avoid; page-break-after:auto; }

            /*//h6 {page-break-before: always}*/
            /*//table {page-break-after: always}*/
            table.table{
                border: .1px solid #969696;
                border-collapse: collapse;
                width:100%;
            }
            .table th {
                border: .1px solid black !important;
                color: #525252;
                font-size: 11px;
                font-weight: bold;
            }
            .table td {
                border: .1px solid #969696;
                font-size: 8px;
                text-align: center;
                padding: 3px;
            }
            .tbl{
                border: 1px solid #525252 ! important;
            }
            .tb2 td {
                font-size: 9px;
            }
            .main{
                width:900px;
                margin: auto;
                font-family: 'Roboto', sans-serif;
                white-space: nowrap;
            }
            h6{
                margin-bottom: 2px;
                margin-top: 15px;
                font-size: 15px;
                color: #525252;
            }
            .content-body h6 {
                margin-bottom: 2px;
                margin-top: 15px;
                font-size: 10px;
                color: #525252;
            }

            .main-left{
                float: left;
            }
            .main-right{
                float: right;
            }
            .main-right h2{
                font-size: 24px;
                color: #4e4e4e;
            }
            .header{
                font-size: 12.5px;
                display: inline-block;
                width: 100%;
            }
            .footer{
                font-size: 12.5px;
                display: inline-block;
                width: 100%;
            }
            .header table{
                margin-top: 12px;
            }
            .heading{
                width: 98%;
                /*//margin-top: 26px;*/
                text-align: center;
                font-weight: bold;
                font-size: 17px;
            }
            .topcontent{
                width:100%;
                display:inline-block;
                padding-bottom: 12px;
            }
            .topcontent td{
                font-size: 9px;
            }
            .topcontent-left{
                float:left;
                padding-right: 118px;
            }
            .topcontent-center{
                float:left;
            }
            .topcontent-right{
                float:right;
            }
            .content{
                width:100%;
            }
            .content-body h6{
                margin-bottom: 3px;
                margin-top: 4px;
            }
            .content-description span{
                font-size: 10px;
                color: red;
                font-style: italic;
            }
            .sub-heading{
                margin-bottom: 4px;
                margin-top: 6px;
                font-size: 12px;
                color: #525252 !important;
            }
        }
        @media screen{
            .main-tabl{
                width: 60%;
            }
        }
        .table td {
            border: 1px solid black;
            font-size: 12px;
            text-align: left;
            padding: 7px;
            /*font-weight: bold;*/
        }
        .cargodetails{
            page-break-inside: avoid;
        }
        .print{
            margin-top: 18px;
            margin-left: 434px;
        }
    </style>
    <!--    </head>
        <body >-->
    <table class="main-tabl" border="0">
        <thead>
            <tr>
                <th style="width:100%">
                    <div class="header">
                        <div class="main-left">
                            <img src="<?= Yii::$app->homeUrl ?>images/report-logo.jpg" style="width: 100px;height: 100px;"/>

                        </div>
                        <div class="main-right">
                            <h2>Statement Of Facts</h2>
                            <h2 style="font-style: italic;font-size: 18px;"><?= $appointment->appointment_no ?></h2>
                        </div>
                        <br/>
                    </div>
                </th>
            </tr>

        </thead>
        <tbody>
            <tr>
                <td>


                    <div class="content">
                        <table class="table tbl">
                            <tr>
                                <td style="width: 20%;"><?php echo common\models\VesselType::findOne($appointment->vessel_type)->vessel_type; ?> Name</td>
                                <td style="width: 30%;"> <?php
                                    if ($appointment->vessel_type == 1) {
                                        echo 'T - ' . Vessel::findOne($appointment->tug)->vessel_name . ' / B - ' . Vessel::findOne($appointment->barge)->vessel_name;
                                    } else {
                                        echo Vessel::findOne($appointment->vessel)->vessel_name;
                                    }
                                    ?></td>
                                <td style="width: 20%;">Cargo Quantity</td>
                                <td style="width: 30%;"><?php
                                    if (empty($ports_cargo->loaded_quantity)) {
                                        echo $appointment->quantity;
                                    } else {
                                        echo $ports_cargo->loaded_quantity;
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">Load Port</td>
                                <td style="width: 30%;"><?= $appointment->portOfCall->port_name ?></td>
                                <td style="width: 20%;">Cargo Type</td>
                                <td style="width: 30%;"><?= $appointment->cargo; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">Last Port</td>
                                <td style="width: 30%;"><?= $appointment->last_port ?></td>
                                <td style="width: 20%;">Operation</td>
                                <td style="width: 30%;"><?php if ($appointment->purpose != '') { ?> <?= $appointment->purpose0->purpose ?><?php } ?></td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">Next Port</td>
                                <td style="width: 30%;"><?= $appointment->next_port ?></td>
                                <td style="width: 20%;">NOR Tendered</td>
                                <td style="width: 30%;"><?= Yii::$app->SetValues->DateFormate($ports->nor_tendered); ?>
                                </td>
                            </tr>

                        </table>
                    </div>


                </td>
            </tr>
            <tr>
                <td>


                    <div class="events">
                        <?php
                        $port = $this->context->portcallReport($ports, 'ports');
//                echo "<pre>";
//                var_dump($port['ports']['mins']);
//                exit;
                        if (!empty($port['ports']['no_mins']))
                            uasort($port['ports']['no_mins'], 'cmp');

                        if (!empty($port['ports']['mins']))
                            uasort($port['ports']['mins'], 'cmp');

                        function cmp($port, $b) {
                            return strtotime($port) < strtotime($b) ? -1 : 1;
                        }

                        if (!empty($port)) {
                            ?>
                            <h6>Events</h6>
                            <table class="table">
                                <?php
                                $flag = 0;
                                if (!empty($port['ports']['mins'])) {
                                    foreach ($port['ports']['mins'] as $key => $value) {
                                        $flag++;
                                        if ($flag == 1) {
                                            echo "<tr>";
                                        }
                                        ?>
                                        <td style="width: 20%;"><?= $key; ?></td>
                                        <td style="width: 30%;"><?= Yii::$app->SetValues->DateFormate($value); ?></td>
                                        <?php
                                        if ($flag == 2) {
                                            echo "</tr>";
                                            $flag = 0;
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td colspan = "4"></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td style="width: 20%;">Pob Outbound</td>
                                    <td style="width: 30%;"><?= Yii::$app->SetValues->DateFormate($ports->pob_outbound); ?></td>
                                    <td style="width: 20%;">Cast Off</td>
                                    <td style="width: 30%;"><?= Yii::$app->SetValues->DateFormate($ports->cast_off); ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 20%;">Lastline Away</td>
                                    <td style="width: 30%;"><?= Yii::$app->SetValues->DateFormate($ports->lastline_away); ?></td>
                                    <td style="width: 20%;">COSP</td>
                                    <td style="width: 30%;"><?= Yii::$app->SetValues->DateFormate($ports->cosp); ?></td>

                                </tr>
                                <tr>
                                    <td style="width: 20%;">ETA Next Port</td>
                                    <td style="width: 30%;"><?= Yii::$app->SetValues->DateFormate($ports->eta_next_port); ?></td>
                                </tr>

                            </table>
                            <?php
                        }
                        ?>

                    </div>

                </td>
            </tr>
            <tr>
                <td>



                    <div class="survey_cargo">
                        <h6>Survey/Cargo Timings</h6>
                        <table class="table">
                            <tr>
                                <td style="width: 20%;"><?php if ($appointment->vessel_type == 3) { ?>Ullaging / Sampling Commenced<?php } else { ?>Initial Draft Survey (Commenced)<?php } ?></td>
                                <td style="width: 30%;"><?= Yii::$app->SetValues->DateFormate($ports_draft->intial_survey_commenced); ?></td>
                                <td style="width: 20%;"><?php if ($appointment->vessel_type == 3) { ?>Tank Inspection Commenced<?php } else { ?>Final Draft Survey (Commenced)<?php } ?></td>
                                <td style="width: 30%;"><?= Yii::$app->SetValues->DateFormate($ports_draft->finial_survey_commenced); ?></td>
                            </tr>
                            <tr >
                                <td style="width: 20%;"><?php if ($appointment->vessel_type == 3) { ?>Ullaging / Sampling Completed<?php } else { ?>Initial Draft Survey (Completed)<?php } ?></td>
                                <td style="width: 30%;"><?= Yii::$app->SetValues->DateFormate($ports_draft->intial_survey_completed); ?></td>
                                <td style="width: 20%;"><?php if ($appointment->vessel_type == 3) { ?>Tank Inspection Completed<?php } else { ?>Final Draft Survey (Completed)<?php } ?></td>
                                <td style="width: 30%;"><?= Yii::$app->SetValues->DateFormate($ports_draft->finial_survey_completed); ?></td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">Cargo Operation Commenced</td>
                                <td style="width: 30%;"><?= Yii::$app->SetValues->DateFormate($ports->cargo_commenced); ?></td>
                                <td style="width: 20%;">Cargo Operation Completed</td>
                                <td style="width: 30%;"><?= Yii::$app->SetValues->DateFormate($ports->cargo_completed); ?></td>
                            </tr>
                        </table>
                    </div>




                </td>
            </tr>
            <tr>
                <td>




                    <div class="robdetails">
                        <table style="width: 100%;" border="0">
                            <tr>
                                <td style="width: 50%;"><h6>ROB-Arrival</h6></td>
                                <td style="width: 50%;"><h6 style="margin-left: 2%;">ROB-Sailing</h6></td>
                            </tr>
                        </table>
                        <!--                <div class="row" style="display:inline-block;">

                                            <div class="arrival" style="float:left;margin-right: 347px;"><h6>ROB-Arrival</h6></div>
                                            <div class="sailing" style="float:right;margin-left: 347px;"><h6>ROB-Sailing</h6></div>
                                        </div>-->

                        <table class="table" style="border: none;">
                            <tr style="border: none;">
                                <th style="width: 16.66%;">FO</th>
                                <th style="width: 16.66%;">DO</th>
                                <th style="width: 16.66%;">Fresh Water</th>
                                <th style="border: none;width: 1%;"></th>
                                <th style="width: 16.66%;">FO</th>
                                <th style="width: 16.66%;">DO</th>
                                <th style="width: 16.66%;">Fresh Water</th>
                            </tr>
                            <tr>
                                <td style="width: 16.66%;"><?php
                                    if ($ports_rob->fo_arrival_quantity != '') {
                                        echo $ports_rob->fo_arrival_quantity
                                        ?><?=
                                        $ports_rob->fo_arrival_unit == 1 ? 'MT' : 'L';
                                    }
                                    ?></td>
                                <td style="width: 16.66%;"><?php
                                    if ($ports_rob->do_arrival_quantity != '') {
                                        echo $ports_rob->do_arrival_quantity
                                        ?> <?=
                                        $ports_rob->do_arrival_unit == 1 ? 'MT' : 'L';
                                    }
                                    ?></td>
                                <td style="width: 16.66%;"><?php
                                    if ($ports_rob->fresh_water_arrival_quantity != '') {
                                        echo $ports_rob->fresh_water_arrival_quantity
                                        ?> <?=
                                        $ports_rob->fresh_water_arrival_unit == 1 ? 'MT' : 'L';
                                    }
                                    ?></td>
                                <td style="border: none;width: 1%;"></td>
                                <td style="width: 16.66%;"><?php
                                    if ($ports_rob->fo_sailing_quantity != '' && $ports_rob->fo_sailing_quantity != NULL) {
                                        echo $ports_rob->fo_sailing_quantity
                                        ?> <?=
                                        $ports_rob->fo_sailing_unit == 1 ? 'MT' : 'L';
                                    }
                                    ?></td>
                                <td style="width: 16.66%;"><?php
                                    if ($ports_rob->do_sailing_quantity != '') {
                                        echo $ports_rob->do_sailing_quantity
                                        ?> <?=
                                        $ports_rob->do_sailing_unit == 1 ? 'MT' : 'L';
                                    }
                                    ?></td>
                                <td style="width: 16.66%;"><?php
                                    if ($ports_rob->fresh_water_sailing_quantity != '') {
                                        echo $ports_rob->fresh_water_sailing_quantity
                                        ?> <?=
                                        $ports_rob->fresh_water_sailing_unit == 1 ? 'MT' : 'L';
                                    }
                                    ?></td>
                            </tr>
                            <tr>
                                <td style="width: 16.66%;">ROB Received</td>
                                <td colspan="6" style="width: 83.3%;"><?= $ports_rob->rob_received ?></td>
                            </tr>
                        </table>
                    </div>



                </td>
            </tr>
            <tr>
                <td>




                    <div class="draftdetails">
                        <!--<h6>Drafts-Arrival/Departure</h6>-->
                        <table style="width: 60%;" border="0">
                            <tr>
                                <td style="width: 50%;"><h6>Drafts-Arrival</h6></td>
                                <td style="width: 50%;"><h6 style="margin-left: 2%;">Drafts-Departure</h6></td>
                            </tr>
                        </table>
                        <table class="table" style="width:60%;border: none;">
        <!--                    <tr>
                                <th colspan="2"style="width: 25%;">ARRIVAL</th>
                                <th colspan="2"style="width: 25%;">DEPARTURE</th>
                            </tr>-->
                            <tr>
                                <td style="width: 12.5%;">FWD</td>
                                <td style="width: 12.5%;"><?php
                                    if ($ports_draft->fwd_arrival_quantity != '') {
                                        echo $ports_draft->fwd_arrival_quantity . ' m';
                                    }
                                    ?></td>
                                <td style="border: none;width: 1%;"></td>
                                <td style="width: 12.5%;">FWD</td>
                                <td style="width: 12.5%;"><?php
                                    if ($ports_draft->fwd_sailing_quantity != '') {
                                        echo $ports_draft->fwd_sailing_quantity . ' m';
                                    }
                                    ?></td>
                            </tr>
                            <tr>
                                <td style="width: 12.5%;">AFT</td>
                                <td style="width: 12.5%;"><?php
                                    if ($ports_draft->aft_arrival_quantity != '') {
                                        echo $ports_draft->aft_arrival_quantity . ' m';
                                    }
                                    ?></td>
                                <td style="border: none;"></td>
                                <td style="width: 12.5%;">AFT</td>
                                <td style="width: 12.5%;"><?php
                                    if ($ports_draft->aft_sailing_quantity != '') {
                                        echo $ports_draft->aft_sailing_quantity . ' m';
                                    }
                                    ?></td>
                            </tr>
                        </table>
                    </div>



                </td>
            </tr>
            <tr>
                <td>


                    <?php
                    if ($check != '') {
                        ?>
                        <div class="portbreakdetails">
                            <h6>Port Break Timing:</h6>
                            <table class="table">
                                <tr>
                                    <td style="width: 25%;">Tea Break</td>
                                    <td style="width: 25%;">0200 - 0230</td>
                                    <td style="width: 25%;">Lunch break</td>
                                    <td style="width: 25%;">1300 - 1400</td>
                                </tr>
                                <tr>
                                    <td style="width: 25%;">Tea Break</td>
                                    <td style="width: 25%;">1000 - 1030</td>
                                    <td style="width: 25%;">Dinner Break</td>
                                    <td style="width: 25%;">2200 - 2300</td>
                                </tr>
                                <tr>
                                    <td style="width: 25%;">Tea Break</td>
                                    <td style="width: 25%;">1700 - 1730</td>

                                </tr>
                            </table>
                        </div>
                        <?php
                    }
                    ?>





                </td>
            </tr>
            <tr>
                <td>





                    <div class="cargodetails">

                        <h6>Cargo Details </h6>
                        <table class="table">
                            <tr>
                                <th style="width: 50%;">Cargo Type</th>
                                <th style="width: 25%;">Loaded Quantity</th>
                                <th style="width: 25%;">B/L Quantity</th>
                            </tr>
                            <tr>
                                <td style="width: 50%;height: 13px;"><?php if (isset($ports_cargo->cargo_type)) { ?> <?= $ports_cargo->cargo_type ?> <?php } ?></td>
                                <td style="width: 25%;"><?php if (isset($ports_cargo->loaded_quantity)) { ?> <?= $ports_cargo->loaded_quantity ?> <?php } ?></td>
                                <td style="width: 25%;"><?php if (isset($ports_cargo->bl_quantity)) { ?> <?= $ports_cargo->bl_quantity ?> <?php } ?></td>
                            </tr>
                        </table>
                        <br/>
                        <?php
                        if (!empty($port_stoppages)) {
                            ?>
                            <div class="cargodetails">

                                <h6>Stoppages / Delays - Description </h6>
                                <table class="table">

                                    <tr>
                                        <th style="width: 33%;">From</th>
                                        <th style="width: 33%;">To</th>
                                        <th style="width: 34%;">Comment</th>
                                    </tr>
                                    <?php
                                    foreach ($port_stoppages as $port_stoppage) {
                                        ?>
                                        <tr>
                                            <td style="width: 33%;height: 13px;"><?= Yii::$app->SetValues->DateFormate($port_stoppage->stoppage_from); ?></td>
                                            <td style="width: 33%;"><?= Yii::$app->SetValues->DateFormate($port_stoppage->stoppage_to); ?></td>
                                            <td style="width:34%;"><?= $port_stoppage->comment; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                                <br/>

                            </div>
                        <?php } ?>
                        <br/>
                        <table class="table">
                            <tr>
                                <th style="width: 25%;">Remarks (if any):</th>
                                <td style="width: 75%;"><?php if (isset($ports_cargo->remarks)) { ?> <?= $ports_cargo->remarks ?> <?php } ?></td>
                            </tr>
                            <tr>

                                <th style="width: 25%;">Stoppages / Delays:</th>
                                <td style="width: 75%;height: 35px;"><?php if (isset($ports_cargo->stoppages_delays)) { ?> <?= $ports_cargo->stoppages_delays ?> <?php } ?></td>
                            </tr>
                            <tr>

                                <th style="width: 25%;">Cargo Document</th>
                                <td style="width: 75%;height: 35px;"><?php if (isset($ports_cargo->cargo_document)) { ?> <?= $ports_cargo->cargo_document ?> <?php } ?></td>
                            </tr>
                            <tr>
                                <th style="width: 25%;">Master's Comments (if any)</th>
                                <td style="width: 75%;height: 80px;;"><?php if (isset($ports_cargo->masters_comment)) { ?> <?= $ports_cargo->masters_comment ?> <?php } ?></td>
                            </tr>

                        </table>
                    </div>

                    <br/>
                    <!--            <div class="footer">
                                    <div class="footer-left">
                                        <h4> Master<br/>M/V Eastern View<br/><?= date('d/m/Y') ?></h4>
                                    </div>
                                    <div class="footer-right">
                                        Agent
                                    </div>
                                </div>-->
                </td>
            </tr>
            <tr>
                <td>
                    <div class="footer">
                        <div class="main-left">
                            <h4> Master<br/><br/><?php
                                if ($appointment->vessel_type == 1) {
                                    echo 'T - ' . Vessel::findOne($appointment->tug)->vessel_name . ' / B - ' . Vessel::findOne($appointment->barge)->vessel_name;
                                } else {
                                    echo Vessel::findOne($appointment->vessel)->vessel_name;
                                }
                                ?><br/><br/>Dated:<?= date('d/m/Y') ?></h4>

                        </div>
                        <div class="main-right">
                            <table class="">
                                <h4>Agent</h4>
                            </table>
                        </div>
                        <br/>
                    </div>
                </td></tr>
        </tbody>
    </table>
</div>
<!--</body>-->
<script>
    function printContent(el) {
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(el).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }
</script>
<div class="print">
    <button onclick="printContent('print')" style="font-weight: bold !important;">Print</button>
    <button onclick="window.close();" style="font-weight: bold !important;">Close</button>
</div>


<!--</html>-->
