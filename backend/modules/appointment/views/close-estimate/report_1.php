<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\SubServices;
use common\models\Appointment;
use common\models\EstimatedProforma;
use common\models\Debtor;
use common\models\PortCallData;
use common\models\Vessel;
use common\models\Ports;
use common\models\CloseEstimate;
use common\models\Services;
use common\models\InvoiceType;
use common\models\Currency;
use common\models\EstimateReport;
use common\models\InvoiceNumber;
use common\models\FundingAllocation;
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!--<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title></title>-->
<div id="print">
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
    </style>
    <!--    </head>
        <body >-->
    <table border ="0"  class="main-tabl" border="0">
        <thead>
            <tr>
                <th style="width:100%">
                    <div class="header">
                        <div class="main-left">
                            <?php
                            if (!empty($fda_template)) {
                                if ($fda_template->left_logo != '') {
                                    $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/report_template/' . $fda_template->id . '/' . $fda_template->left_logo;
                                    if (file_exists($dirPath)) {
                                        $img = '<img width="90px" height="75px" src="' . Yii::$app->homeUrl . 'uploads/report_template/' . $fda_template->id . '/' . $fda_template->left_logo . '"/>';
                                    } else {
                                        $img = '<img width="90px" height="75px" src="' . Yii::$app->homeUrl . 'images/logoleft.jpg"/>';
                                    }
                                } else {
                                    $img = '<img width="90px" height="75px" src="' . Yii::$app->homeUrl . 'images/logoleft.jpg"/>';
                                }
                            } else {
                                $img = '<img width="90px" height="75px" src="' . Yii::$app->homeUrl . 'images/logoleft.jpg"/>';
                            }
                            echo $img;
                            ?>
                        </div>
                        <div class="main-right">
                            <?php
                            if (!empty($fda_template)) {
                                if ($fda_template->right_logo != '') {
                                    $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/report_template/' . $fda_template->id . '/' . $fda_template->right_logo;
                                    if (file_exists($dirPath)) {
                                        $img = '<img width="90px" height="75px" src="' . Yii::$app->homeUrl . 'uploads/report_template/' . $fda_template->id . '/' . $fda_template->right_logo . '"/>';
                                    } else {
                                        $img = '<img width="90px" height="75px" src="' . Yii::$app->homeUrl . 'images/logoright.jpg"/>';
                                    }
                                } else {
                                    $img = '<img width="90px" height="75px" src="' . Yii::$app->homeUrl . 'images/logoright.jpg"/>';
                                }
                            } else {
                                $img = '<img width="90px" height="75px" src="' . Yii::$app->homeUrl . 'images/logoright.jpg"/>';
                            }
                            echo $img;
                            ?>
                        </div>
                        <br/>
                    </div>
                </th>
            </tr>

        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="heading">VOYAGE DISBURSEMENT ACCOUNT</div>
                    <div class="closeestimate-content">
                        <?php
                        if ($principp != '') {
                            $close_estimates = CloseEstimate::find()
                                    ->where(['apponitment_id' => $appointment->id, 'principal' => $principp])
                                    ->all();
                        } else {
                            $close_estimates = CloseEstimate::find()
                                    ->where(['apponitment_id' => $appointment->id, 'principal' => $appointment->principal])
                                    ->all();
                        }
//                    if ($invoice_type != 'all') {
//                        if ($principp != '') {
//                            $close_estimates = CloseEstimate::find()
//                                    ->where(['apponitment_id' => $appointment->id, 'principal' => $principp])
//                                    ->orderBy(['(invoice_type)' => SORT_ASC])
//                                    ->all();
////                                                        $close_estimates = CloseEstimate::findAll(['apponitment_id' => $appointment->id, 'principal' => $principp])->orderBy(['invoice_type' => SORT_DESC]);
//                        } else {
//                            $close_estimates = CloseEstimate::find()
//                                    ->where(['apponitment_id' => $appointment->id, 'principal' => $appointment->principal])
//                                    ->orderBy(['(invoice_type)' => SORT_ASC])
//                                    ->all();
////                                                        $close_estimates = CloseEstimate::findAll(['apponitment_id' => $appointment->id, 'principal' => $appointment->principal])->orderBy(['invoice_type' => SORT_DESC]);
//                        }
//                    } else {
//                        $close_estimates = CloseEstimate::findAll(['apponitment_id' => $appointment->id, 'principal' => $principp]);
//                    }
                        ?>
                        <table border ="0"  class="table tbl">
                            <tr>
                                <td rowspan="2" style="width: 50%;">
                                    <p>
                                        EMPEROR SHIPPING LINES LLC<br>
                                        Room 06 / Floor II; P.O.Box-328231<br>
                                        Near Saqr Port, RAK Medical Bldg, Al Shaam, <br>
                                        Ras Al Khaimah, UAE
                                    </p>
                                </td>
                                <?php
                                $est_id = '';
                                if (!empty($close_estimates)) {
                                    foreach ($close_estimates as $close_estimate) {
                                        $i++;
                                        $est_id .= $close_estimate->id . ',';
                                    }
                                    $est_id = rtrim($est_id, ',');
                                }
                                if ($principp != '') {
                                    $principal_id = $principp;
                                } else {
                                    $principal_id = $appointment->principal;
                                }
                                $model_report = $this->context->InvoiceGeneration($appointment->id, $principal_id, $est_id);
                                ?>

                                <td style="width: 25%;">Invoice No : <?= $model_report->invoice_number ?>-<?= $model_report->sub_invoice ?></td>
                                <?php
                                if ($invoice_date != '') {
                                    $date_invoice = date('d-M-Y', strtotime($invoice_date));
                                } else {
                                    $date_invoice = '';
                                }
                                ?>
                                <td style="width: 25%;">Invoice Date : <?php echo $date_invoice; ?></td>
                            </tr>
                            <tr>
                                <?php
                                $arr = ['1' => 'A', '2' => 'B', '3' => 'C', '4' => 'D', '5' => 'E', '6' => 'F', '7' => 'G', '8' => 'H', '9' => 'I', '10' => 'J', '11' => 'K', '12' => 'L'];
                                $last_report_saved = EstimateReport::find()->orderBy(['id' => SORT_DESC])->where(['appointment_id' => $appointment->id])->All();
                                $c = count($last_report_saved);
                                if ($c == 0) {
                                    $ref_no = 'EMPRK-' . $appointment->id . '/' . date('Y');
                                } else {
                                    $ref_no = 'EMPRK-' . $appointment->id . $arr[$c] . '/' . date('Y');
                                }
                                ?>
                                <td style="width: 25%;">EPDA Ref : <?php echo $ref_no; ?></td>
                                <td style="width: 25%;">Customer Code :
                                    <?php
                                    if ($principp != '') {
                                        echo $appointment->getClintCode($principp);
                                    } else {
                                        echo $appointment->getClintCode($appointment->principal);
                                    }
                                    ?>

                                </td>

                            </tr>
                            <tr>
                                <td rowspan="3" style="width: 50%;">
                                    <p>
                                        <?php
                                        if ($principp != '') {
                                            echo $appointment->getInvoiceAddress($principp);
                                        } else {
                                            echo $appointment->getInvoiceAddress($appointment->principal);
                                        }
                                        ?>
                                    </p>
                                </td>
                                <td style="width: 25%;">Vessel Name : <?php
                                    if ($appointment->vessel_type == 1) {
                                        echo 'T - ' . Vessel::findOne($appointment->tug)->vessel_name . ' / B - ' . Vessel::findOne($appointment->barge)->vessel_name;
                                    } else {
                                        echo Vessel::findOne($appointment->vessel)->vessel_name;
                                    }
                                    ?>
                                </td>
                                <?php
                                $principal_datas = CloseEstimate::find()->select('principal')->distinct()->where(['apponitment_id' => $appointment->id])->all();
                                $data_principal = '';
                                foreach ($principal_datas as $principal_data) {
                                    if ($principal_data->principal != '') {
                                        $data_principal .= $principal_data->principal . ',';
                                    }
                                }
                                ?>
                                <td style="width: 25%;">Ops Reference : <?php echo $appointment->appointment_no . $this->context->oopsNo(rtrim($data_principal, ","), $principp); ?> </td>
                            </tr>
                            <?php ?>
                            <tr>
                                <td style="width: 25%;">Port of Call : <?= $appointment->portOfCall->port_name ?> </td>
                                <td style="width: 25%;">Client Ref : <?= $appointment->client_reference ?></td>
                            </tr>
                            <tr>
                                <td style="width: 25%;">Arrival Date : <?php
                                    if ($ports->all_fast != '') {
                                        echo date("d-M-Y", strtotime($ports->all_fast));
                                    }
                                    ?></td>
                                <td style="width: 25%;">Sailing Date : <?php
                                    if ($ports->cast_off != '') {
                                        echo date("d-M-Y", strtotime($ports->cast_off));
                                    }
                                    ?></td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="closeestimate-content">
                        <h6 class="sub-heading">Disbursement Summary:</h6>
                        <h6 class="sub-heading">Total Disbursement</h6>
                        <table border ="0"  class="table tbl">
                            <tr>
                                <th style="width: 10%;">Sl No.</th>
                                <th style="width: 40%;">Particulars</th>
                                <th style="width: 15%;">Invoice Reference </th>
                                <th style="width: 15%;">Tax </th>
                                <th style="width: 20%;">Amount</th>
                            </tr>
                            <?php
                            $i = 0;
                            $grandtotal = 0;
                            $grand_tax_total = 0;
                            if (!empty($close_estimates)) {
                                foreach ($close_estimates as $close_estimate):
                                    $i++;
                                    ?>
                                    <tr>
                                        <td style="width: 10%;"><?= $i ?></td>
                                        <td style="width: 40%;"><?php echo Services::findOne(['id' => $close_estimate->service_id])->service; ?></td>
                                        <?php
                                        $incoice_data = InvoiceNumber::find()->where("FIND_IN_SET($close_estimate->id,estimate_id)")->one();
                                        ?>
                                        <td style="width: 15%;"><?php if (isset($close_estimate->invoice_type)) { ?> <?= InvoiceType::findOne(['id' => $close_estimate->invoice_type])->invoice_type; ?> <?php } ?><?php
                                            if (!empty($incoice_data)) {
                                                if ($incoice_data->sub_invoice != '') {
                                                    echo '-' . $incoice_data->sub_invoice;
                                                }
                                            }
                                            ?></td>
                                        <td style="width: 15%;text-align:right;"><?= Yii::$app->SetValues->NumberFormat($close_estimate->tax_amount); ?></td>
                                        <td style="width: 20%;text-align:right;"><?= Yii::$app->SetValues->NumberFormat($close_estimate->fda); ?></td>
                                        <?php
                                        $grandtotal += $close_estimate->fda;
                                        if ($close_estimate->tax_amount != '') {
                                            $grand_tax_total += $close_estimate->tax_amount;
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                endforeach;
                            }
                            ?>
                            <tr>
                                <td style="width: 10%;" rowspan="2"></td>
                                <td  colspan="2" rowspan="2" style="width: 55%;text-align:right;font-weight: bold;">Total</td>
                                <td style="width: 15%;font-weight: bold;text-align:right;"><strong style="float: left;">AED  :</strong> <?= Yii::$app->SetValues->NumberFormat(round($grand_tax_total, 2)); ?></td>
                                <td style="width: 20%;font-weight: bold;text-align:right;"><strong style="float: left;">AED  :</strong> <?= Yii::$app->SetValues->NumberFormat(round($grandtotal, 2)); ?></td>
                            </tr>
                            <tr>
                                <td style="width: 15%;font-weight: bold;text-align:right;"><strong style="float: left;">AED  :</strong> <span style="font-size: 12px;"><?= Yii::$app->SetValues->NumberArabic(round($grand_tax_total, 2)); ?></span></td>
                                <td style="width: 20%;font-weight: bold;text-align:right;"><strong style="float: left;">AED  :</strong> <span style="font-size: 12px;"><?= Yii::$app->SetValues->NumberArabic(round($grandtotal, 2)); ?></span></td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    if ($principp != '') {
                        $funds = FundingAllocation::findAll(['appointment_id' => $appointment->id, 'principal_id' => $principp]);
                    } else {
                        $funds = FundingAllocation::findAll(['appointment_id' => $appointment->id]);
                    }
                    $fundamount = 0;
                    $flag = 0;
                    $check_total = 0;
                    $cash_total = 0;
                    foreach ($funds as $fund) {

                        if ($fund->payment_type == 1) {

                            $cash_total += $fund->amount;
                            if ($fund->fund_date != '') {
                                $date = date("d-m-Y", strtotime($fund->fund_date));
                            } else {
                                $date = '';
                            }
                        } elseif ($fund->payment_type == 1) {
                            $flag = 1;
                            $check_total += $fund->amount;
                            $check_no = $fund->check_no;
                            if ($fund->fund_date != '') {
                                $date = date("d-m-Y", strtotime($fund->fund_date));
                            } else {
                                $date = '';
                            }
                        }
                        $fundamount += $fund->amount;
                    }

                    $totaloutstanding = $fundamount - ($grandtotal + $grand_tax_total);
                    ?>
                    <div class="closeestimate-Receipts">
                        <h6 class="sub-heading">Total Receipts(Prefunding)</h6>

                        <table border ="0"  class="table tbl">
                            <tr>
                                <th style="width: 80%;">Description </th>
                                <th style="width: 20%;">Amount</th>
                            </tr>
                            <tr>
                                <?php
                                if ($flag == 1) {
                                    ?>
                                    <td rowspan="2" style="width: 80%;text-align:left;font-size:11px;"><?php if ($check_total != 0) { ?>Net Received on <?= $date ?> <?php if ($check_no != '') { ?>against cheque no: <b><?= $check_no ?><?php
                                                }
                                            } else {
                                                ?>NIL PREFUNDING RECEIVED <?php } ?></b></td>
                                    <td style="width: 20%;font-size: 11px;text-align:right;"><strong style="float: left;">AED  :</strong> <?= Yii::$app->SetValues->NumberFormat(round(abs($check_total), 2)); ?></td>
                                    <?php
                                } else {
                                    ?>
                                    <td rowspan="2" style="width: 80%;text-align:left;font-size: 11px;"><?php if ($cash_total != 0) { ?>Net Received on <?= $date ?><?php } else { ?>NIL PREFUNDING RECEIVED<?php } ?></td>
                                    <td style="width: 20%;font-size: 11px;text-align:right;"><strong style="float: left;">AED  :</strong> <?= Yii::$app->SetValues->NumberFormat(round(abs($cash_total), 2)); ?></td>
                                    <?php
                                }
                                ?>

                            </tr>
                            <tr>
                                <?php
                                if ($flag == 1) {
                                    ?>
                                    <td style="width: 20%;font-size: 11px;"><strong style="float: left;">AED  :</strong> <span style="font-size: 12px;"><?= Yii::$app->SetValues->NumberArabic(round(abs($check_total), 2)); ?></span></td>
                                    <?php
                                } else {
                                    ?>
                                    <td style="width: 20%;font-size: 11px;"><strong style="float: left;">AED  :</strong> <span style="font-size: 12px;"><?= Yii::$app->SetValues->NumberArabic(round(abs($cash_total), 2)); ?></span></td>
                                    <?php
                                }
                                ?>

                            </tr>
                        </table>
                    </div>
                    <?php
                    $number = explode('.', $totaloutstanding);
                    if (isset($number[1][0]) && $number[1][0] < 1) {
                        $totaloutstanding = $number[0];
                    }
                    ?>
                    <div class="closeestimate-content">
                        <h6 class="sub-heading">Total Outstanding</h6>
                        <table border ="0"  class="table tbl">
                            <tr>
                                <?php
                                if ($totaloutstanding < 0) {
                                    ?>
                                    <td rowspan="4" style="width: 80%;text-align:right;">Total Due in our favour </td>
                                    <td style="width: 20%;font-weight: bold;text-align:right;"><strong style="float: left;">AED  :</strong> <?= Yii::$app->SetValues->NumberFormat(round(abs($totaloutstanding), 2)); ?></td>
                                    <?php
                                } else {
                                    ?>
                                    <td rowspan="4" style="width: 80%;text-align:right;">Total Due in Your favour </td>
                                    <td style="width: 20%;font-weight: bold;text-align:right;"><strong style="float: left;">AED  :</strong> <?= Yii::$app->SetValues->NumberFormat(round(abs($totaloutstanding), 2)); ?></td>
                                    <?php
                                }
                                ?>

                            </tr>
                            <tr>
                                <?php
                                if ($totaloutstanding < 0) {
                                    ?>
                                    <td style="width: 20%;font-weight: bold;text-align:right;"><strong style="float: left;">AED  :</strong> <span style="font-size: 12px;"><?= Yii::$app->SetValues->NumberArabic(round(abs($totaloutstanding), 2)); ?></span></td>
                                    <?php
                                } else {
                                    ?>
                                    <td style="width: 20%;font-weight: bold;text-align:right;"><strong style="float: left;">AED  :</strong> <span style="font-size: 12px;"><?= Yii::$app->SetValues->NumberArabic(round(abs($totaloutstanding), 2)); ?></span></td>
                                    <?php
                                }
                                ?>

                            </tr>
                            <?php
                            $currency = Currency::findOne(['id' => 1]);
                            $usd = round(abs($totaloutstanding) * $currency->currency_value, 2);
                            ?>
                            <tr>
                                <td style="width: 20%;font-weight: bold;text-align:right;"><strong style="float: left;">USD  :</strong> <?= Yii::$app->SetValues->NumberFormat($usd); ?></td>
                            </tr>
                            <tr>
                                <td style="width: 20%;font-weight: bold;text-align:right;"><strong style="float: left;">USD  :</strong> <span style="font-size: 12px;"><?= Yii::$app->SetValues->NumberArabic($usd); ?></span></td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="bank">

                        <p>Amount chargeable (in words)</p>
                        <h6>UAE Dirhams <?php echo ucwords(Yii::$app->NumToWord->ConvertNumberToWords(round(abs($totaloutstanding), 2))) . ' Only'; ?> </h6>
                        <h6>USD <?php echo ucwords(Yii::$app->NumToWord->ConvertNumberToWords($usd, 'USD')) . ' Only'; ?> </h6>
                        <h6>Company's Bank Details:</h6>
                        <?php
                        if (!empty($fda_template)) {
                            if ($fda_template->bank != '') {
                                $bank_detail = common\models\BankDetails::find()->where(['id' => $fda_template->bank])->one();
                            }
                        }
                        ?>
                        <div class="bank-left">
                            <table border ="0"  class="tbl3">
                                <tr>
                                    <td>Name: </td> <td>:</td>
                                    <td>
                                        <?php
                                        if (!empty($bank_detail)) {
                                            if ($bank_detail->account_holder_name != '') {
                                                echo $bank_detail->account_holder_name;
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bank Name </td> <td>:</td>
                                    <td>
                                        <?php
                                        if (!empty($bank_detail)) {
                                            if ($bank_detail->bank_name != '') {
                                                echo $bank_detail->bank_name;
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Branch </td> <td>:</td>
                                    <td>
                                        <?php
                                        if (!empty($bank_detail)) {
                                            if ($bank_detail->branch != '') {
                                                echo $bank_detail->branch;
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr><td></td></tr>
                                <tr><td></td></tr>
                                <tr><td></td></tr>
                                <tr><td></td></tr>
                                <tr>
                                    <td>Acct No </td> <td>:</td>
                                    <td>
                                        <?php
                                        if (!empty($bank_detail)) {
                                            if ($bank_detail->account_no != '') {
                                                echo $bank_detail->account_no;
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>IBAN No </td> <td>:</td>
                                    <td>
                                        <?php
                                        if (!empty($bank_detail)) {
                                            if ($bank_detail->iban != '') {
                                                echo $bank_detail->iban;
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Swift </td> <td>:</td>
                                    <td>
                                        <?php
                                        if (!empty($bank_detail)) {
                                            if ($bank_detail->swift != '') {
                                                echo $bank_detail->swift;
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="bank-right">
                            <table border ="0"  class="">
                                <tr>
                                    <td>Remarks </td> <td>:</td>
                                    <td>
                                        <?php
                                        if ($appointment->vessel_type == 1) {
                                            echo 'T - ' . Vessel::findOne($appointment->tug)->vessel_name . ' / B - ' . Vessel::findOne($appointment->barge)->vessel_name;
                                        } elseif ($appointment->vessel_type == 2) {
                                            echo 'M/V - ' . Vessel::findOne($appointment->vessel)->vessel_name;
                                        } elseif ($appointment->vessel_type == 3) {
                                            echo 'M/T - ' . Vessel::findOne($appointment->vessel)->vessel_name;
                                        } else {
                                            echo Vessel::findOne($appointment->vessel)->vessel_name;
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="close-estimate-footer">
                        <div class="close-left">
                            <p>This is computer generated invoice</p>
                        </div>
                        <div class="close-right">
                            <div style="border: 1px solid black;">
                                <h6>for EMPEROR SHIPPING LINES LLC</h6>
                                <p class="signature">Authorised Signatory</p>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>

        </tbody>
        <tfoot>
            <tr>
                <td style="width:100%">
                    <div class="footer">
                        <span>
                            <?php
                            if (!empty($fda_template)) {
                                if ($fda_template->footer_content != '') {
                                    echo $fda_template->footer_content;
                                }
                            }
                            ?>
                        </span>
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
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
    <div class="print" style="float:left;">
        <?php
        if ($print) {
            ?>
            <button onclick="printContent('print')" style="font-weight: bold !important;">Print</button>
            <?php
        }
        ?>
        <button onclick="window.close();" style="font-weight: bold !important;">Close</button>
        <?php
        if ($save) {
            ?>
            <a href="<?= Yii::$app->homeUrl ?>appointment/close-estimate/save-all-report?appintment_id=<?= $appointment->id ?>&&principal_id=<?= $principp ?>&&est_id=<?= $est_id ?>"><button onclick="" style="font-weight: bold !important;">Save</button></a>
            <?php
        }
        ?>

    </div>
</div>
<!--</body>

</html>-->