<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\SubServices;
use common\models\Appointment;
use common\models\EstimatedProforma;
use common\models\Debtor;
use common\models\PortCallData;
use common\models\Vessel;
use common\models\Purpose;
use common\models\Ports;
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
    <!--<link rel="stylesheet" href="<?= Yii::$app->homeUrl ?>css/pdf.css">-->
    <style type="text/css">

        /*thead { display: table-header-group;   }*/
        tfoot{display: table-footer-group;}
        table { page-break-inside:auto;}
        tr{ page-break-inside:avoid; page-break-after:auto; }

        @page {
            size: A4;
        }
        @media print {
            thead {display: table-header-group;}
            tfoot {display: table-footer-group}
            /*tfoot {position: absolute;bottom: 0px;}*/
            .main-tabl{width: 100%}
            .footer {position: fixed ; left: 0px; bottom: 0px; right: 0px; font-size:10px; }
            .main-tabl{
                -webkit-print-color-adjust: exact;
                margin: auto;
                tr{ page-break-inside:avoid; page-break-after:auto; }
            }

        }
        @media screen{
            .main-tabl{
                width: 60%;
            }
        }
        body h6,h1,h2,h3,h4,h5,p,b,tr,td,span,th,div{
            color:#525252 !important;
        }
        .main-tabl{
            margin: auto;
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
        .header table{
            margin-top: 12px;
        }
        .heading{
            width: 98%;
            text-align: center;
            font-weight: bold;
            font-size: 17px;
        }
        .table td {
            border: 1px solid black;
            font-size: 9px !important;
            text-align: center;
            padding: 3px;
        }
        .print{
            margin-top: 18px;
            margin-left: 375px;
        }
        .save{
            margin-top: 18px;
            margin-left: 6px !important;
        }
        .footer {
            width: 100%;
            display: inline-block;
            font-size: 15px;
            color: #4e4e4e;
        }
        .footer p {
            text-align: center;
            font-size: 8px;
            margin: 0px !important;
            color: #525252 !important;
        }
        table.table{
            border: .1px solid #969696;
            border-collapse: collapse;
            width:100%;
        }
        .table th {
            border: .1px solid black;
            color: #525252;
            font-size: 11px;
            font-weight: bold;
        }
        .table td {
            border: .1px solid black;
            font-size: 8px;
            text-align: center;
            padding: 3px;
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
        .main-tabl{
            font-family: 'Roboto', sans-serif;
        }
        .closeestimate-content td{
            font-size: 11px;
            text-align: left;
        }
        .sub-heading{
            margin-bottom: 4px;
            margin-top: 6px;
            font-size: 12px;
            color: #525252 !important;
        }
        .bank{
            width:100%;
            display:inline-block;
        }
        .bank-left{
            width:50%;
            float:left;
        }
        .bank-right{
            width: 50%;
            float: right;
            padding-top: 33px;
        }
        .bank  h6{
            margin-bottom: 4px;
            margin-top: 6px;
            font-size: 12px;
            color: #525252 !important;
        }
        .bank  p{
            margin-bottom: 4px;
            margin-top: 6px;
            font-size: 12px;
            color: #525252;
        }
        .bank td{
            font-size: 11px;
        }
        .close-estimate-footer{
            width:100%;
            display:inline-block;
        }
        .close-estimate-footer p{
            font-size: 10px;
            font-style: italic;
        }
        .close-left{
            width:50%;
            float:left;
            padding-top:76px;
        }
        .close-right{
            width:50%;
            float: right;
            /*margin-left: 21%;*/
        }
        .close-right h6{
            font-size: 12px;
            padding-left: 129px;
            color: #464545;
        }
        .signature{
            padding-left: 221px;
            padding-top: 45px;
        }
        .tbclose {
            padding-right: 104px;
            padding-bottom: 96px;
            padding-top: 50px;
        }
        .tbl3{
            padding-top: 10px;
            padding-bottom: 12px;
        }
        .receipts h6{
            margin-bottom: 4px;
            margin-top: 12px;
            font-size: 12px;
            color: #464545;
        }
        .cargodetails{
            page-break-inside: avoid;
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
                            <img src="<?= Yii::$app->homeUrl ?>images/logoleft.jpg" style="width: 100px;height: 100px;"/>

                        </div>
                        <div class="main-right">
                            <img src="<?= Yii::$app->homeUrl ?>images/logoright.jpg" style="width: 100px;height: 100px;"/>
                        </div>
                        <br/>
                    </div>
                </th>
            </tr>

        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="heading">Arrival Report</div>
                    <div class="vessel-details">
                        <h6>General Details:</h6>
                        <table>
                            <tr>
                                <td style="width: 50%;">Vessel Name</td>
                                <td style="width: 50%;">:<?php
                                    if ($appointment->vessel_type == 1) {
                                        echo 'T - ' . Vessel::findOne($appointment->tug)->vessel_name . ' / B - ' . Vessel::findOne($appointment->barge)->vessel_name;
                                    } else {
                                        echo Vessel::findOne($appointment->vessel)->vessel_name;
                                    }
                                    ?></td>
                            </tr>
                            <tr>
                                <td style="width: 50%;">Last Port</td>
                                <td style="width: 50%;">:<?= $appointment->last_port ?></td>
                            </tr>
                            <tr>
                                <td style="width: 50%;">Next Port</td>
                                <td style="width: 50%;">:<?= $appointment->next_port ?></td>
                            </tr>
                            <tr>
                                <td style="width: 50%;">Port / Berth no</td>
                                <td style="width: 50%;">:<?= $appointment->birth_no ?> / <?= Ports::findOne($appointment->port_of_call)->port_name; ?>/<?= $appointment->birth_no ?></td>
                            </tr>
                            <tr>
                                <td style="width: 50%;">NOR Tendered</td>
                                <td style="width: 50%;">:<?= Yii::$app->SetValues->DateFormate($ports->nor_tendered); ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="arrival-timings">
                        <h6>Arrival Timings:</h6>
                        <table>
                            <tr>
                                <td style="width: 50%;">EOSP</td>
                                <td style="width: 50%;">:<?= Yii::$app->SetValues->DateFormate($ports->eosp); ?></td>
                            </tr>
                            <tr>
                                <td style="width: 50%;">Arrived at Anchorage</td>
                                <td style="width: 50%;">:<?= Yii::$app->SetValues->DateFormate($ports->arrived_anchorage); ?></td>
                            </tr>
                            <tr>
                                <td style="width: 50%;">Dropped Anchor</td>
                                <td style="width: 50%;">:<?= Yii::$app->SetValues->DateFormate($ports->dropped_anchor); ?></td>
                            </tr>
                            <tr>
                                <td style="width: 50%;">Heave up anchor</td>
                                <td style="width: 50%;">:<?= Yii::$app->SetValues->DateFormate($ports->anchor_aweigh); ?></td>
                            </tr>
                            <tr>
                                <td style="width: 50%;">Arrived P/s</td>
                                <td style="width: 50%;">:<?= Yii::$app->SetValues->DateFormate($ports->arrived_pilot_station); ?></td>
                            </tr>
                            <tr>
                                <td style="width: 50%;">POB-(inbound)</td>
                                <td style="width: 50%;">:<?= Yii::$app->SetValues->DateFormate($ports->pob_inbound); ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%;">First Line Ashore</td>
                                <td style="width: 50%;">:<?= Yii::$app->SetValues->DateFormate($ports->first_line_ashore); ?></td>
                            </tr>
                            <tr>
                                <td style="width: 50%;">All Fast</td>
                                <td style="width: 50%;">:<?= Yii::$app->SetValues->DateFormate($ports->all_fast); ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%;">Draft Survey (commenced)</td>
                                <td style="width: 50%;">:<?= Yii::$app->SetValues->DateFormate($ports_draft->intial_survey_commenced); ?></td>
                            </tr>
                            <tr>
                                <td style="width: 50%;">Draft Survey (completed</td>
                                <td style="width: 50%;">:<?= Yii::$app->SetValues->DateFormate($ports_draft->intial_survey_completed); ?></td>
                            </tr>
                            <tr>
                                <td style="width: 50%;">Expected Loading Commencement</td>
                                <td style="width: 50%;">:</td>
                            </tr>
                        </table>
                    </div>

                    <div class="rob-arrival">
                        <h6>Arrival - ROB (berth):</h6>
                        <table>
                            <tr>
                                <td style="width: 33%;">FO</td>
                                <td style="width: 33%;">DO</td>
                                <td style="width: 34%;">FW</td>
                            </tr>
                            <tr>
                                <td style="width: 33%;"><?php
                                    if ($ports_rob->fo_arrival_quantity != '') {
                                        echo $ports_rob->fo_arrival_quantity
                                        ?><?=
                                        $ports_rob->fo_arrival_unit == 1 ? 'MT' : 'L';
                                    }
                                    ?></td>
                                <td style="width: 33%;"><?php
                                    if ($ports_rob->do_arrival_quantity != '') {
                                        echo $ports_rob->do_arrival_quantity
                                        ?> <?=
                                        $ports_rob->do_arrival_unit == 1 ? 'MT' : 'L';
                                    }
                                    ?></td>
                                <td style="width: 34%;"><?php
                                    if ($ports_rob->fresh_water_arrival_quantity != '') {
                                        echo $ports_rob->fresh_water_arrival_quantity
                                        ?> <?=
                                        $ports_rob->fresh_water_arrival_unit == 1 ? 'MT' : 'L';
                                    }
                                    ?></td>
                            </tr>
                        </table>
                    </div>


                    <div class="draft-departure">
                        <h6>Draft - Arrival:</h6>
                        <table>
                            <tr>
                                <td style="width: 50%;">FWD</td>
                                <td style="width: 50%;">AFT</td>
                            </tr>
                            <tr>
                                <td style="width: 50%;"><?php
                                    if ($ports_draft->fwd_arrival_quantity != '') {
                                        echo $ports_draft->fwd_arrival_quantity . ' m';
                                    }
                                    ?></td>
                                <td style="width: 50%;"><?php
                                    if ($ports_draft->aft_arrival_quantity != '') {
                                        echo $ports_draft->aft_arrival_quantity . ' m';
                                    }
                                    ?></td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td style="width:100%">
                    <div class="footer">
                        <span>
                            <p>Emperor&nbsp;Shipping Lines LLC -&nbsp;Ras Al Khaimah (Br)| P.O.Box-328231 |Ops Email:&nbsp;opsrak@emperor.ae&nbsp;|Accts Email:&nbsp;accrak@emperor.ae</p>

                            <p>www.emperor.ae</p>

                            <p>Main Office: RAK Medical Centre Bldg |Floor II, Room 06 | Al Shaam, RAK, UAE | Tel: +971 7 268 9676 |Fax: +971 7 268 9677</p>

                            <p>Port Office: Shipping Agents Bldg |Ground Floor, Room: 10 A | Saqr Port Authority, Ras Al Khaimah, UAE | Tel: +971 7 268 9626</p>
                        </span>
                    </div>
                </td>
            </tr>
        </tfoot>
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
