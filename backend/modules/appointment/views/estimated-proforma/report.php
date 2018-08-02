<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\SubServices;
use common\models\Appointment;
use common\models\EstimatedProforma;
use common\models\Debtor;
use common\models\ServiceCategorys;
use common\models\Services;
use common\models\Vessel;
use common\models\EstimateReport;
use common\models\Currency;

$default_currency = Currency::findOne($appointment->currency);
$currency = Currency::findOne(1);
?>
<!DOCTYPE html>

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
            tfoot{display: table-footer-group;}
            table { page-break-inside:auto;}
            tr{ page-break-inside:avoid; page-break-after:auto; }

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
        .content-description P{
            font-size: 8px;
        }
        .content-body h6 {
            margin-bottom: 3px;
            margin-top: 4px;
        }
        .bankdetails h3 {
            text-decoration: underline;
        }
        .address h4{
            text-align: left;
            text-decoration: underline;
        }
        .address p{
            text-align: left;
            margin: 3px 0px;
        }
        .contact-address p{
            margin: 10px 0px;
        }
        .address h3{
            text-decoration: underline;
            text-align: left;
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
            border-top: 1px solid #848484;
            padding-top: 10px;
        }
        .footer p {
            text-align: center;
            font-size: 8px;
            margin: 0px !important;
            color: #525252 !important;
        }
        .tbl{
            border-collapse: collapse;
        }
        .tbl td{
            border: 1px solid #848484;
            font-size: 9px !important;
            text-align: center;
            padding: 3px;
        }
        .tbl.full-width{
            width: 100%;
        }
    </style>
    <table class="main-tabl" border="0" >
        <thead>
            <tr>
                <th style="width:100%">
                    <div class="header">
                        <div class="main-left">
                            <?php
                            if (!empty($epda_template)) {
                                if ($epda_template->left_logo != '') {
                                    $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/report_template/' . $epda_template->id . '/' . $epda_template->left_logo;
                                    if (file_exists($dirPath)) {
                                        $img = '<img width="90px" height="75px" src="' . Yii::$app->homeUrl . 'uploads/report_template/' . $epda_template->id . '/' . $epda_template->left_logo . '"/>';
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
                            if (!empty($epda_template)) {
                                if ($epda_template->right_logo != '') {
                                    $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/report_template/' . $epda_template->id . '/' . $epda_template->right_logo;
                                    if (file_exists($dirPath)) {
                                        $img = '<img width="90px" height="75px" src="' . Yii::$app->homeUrl . 'uploads/report_template/' . $epda_template->id . '/' . $epda_template->right_logo . '"/>';
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
                    <div class="heading-top" style="margin-bottom: 26px;">
                        <div class="main-left">
                            <table class="tb2">
                                <tr>
                                    <td style="width: 55px;">TO </td> <td style="width: 40px;text-align: center">:</td>
                                    <td style="max-width: 250px">
                                        <span style="font-weight:600;"><?= $princip != '' ? common\models\Debtor::findOne($princip)->principal_name : '' ?></span><br/>
                                        <?= $appointment->getEpdaAddress($princip); ?><br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 55px;font-weight: 600;">TRN </td> <td style="width: 40px;text-align: center">:</td>
                                    <td style="max-width: 405px;font-weight: 600;">
                                        <?= $appointment->getDebtorTax($princip); ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="main-right">
                            <table class="tb2">
                                <tr>
                                    <td>Date </td> <td style="width: 50px;text-align: center">:</td>
                                    <td style="max-width: 200px"><?= date("d-M-Y") ?></td>
                                </tr>
                                <tr>
                                    <td>Client Code </td> <td style="width: 50px;text-align: center">:</td>
                                    <td style="max-width: 200px"><?= $appointment->getClintCode($princip); ?></td>
                                </tr>
                                <tr>
                                    <td>Client Ref </td> <td style="width: 50px;text-align: center">:</td>
                                    <td style="max-width: 200px"><?= $appointment->client_reference ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <br/>
                    <div style="clear:both"></div>
                    <div class="heading" style="margin-bottom: 8px;">ESTIMATED DISBURSEMENT ACCOUNT</div>
                    <div class="topcontent">
                        <div class="topcontent-left">
                            <table class="">
                                <tr>
                                    <td>Port </td> <td>:</td>
                                    <td><?= $appointment->portOfCall->port_name ?></td>
                                </tr>
                                <tr>
                                    <td>ETA </td> <td>:</td>
                                    <td><?= Yii::$app->SetValues->DateFormate($appointment->eta); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="topcontent-center">
                            <table class="">
                                <tr>
                                    <td>Vessel </td> <td>:</td>
                                    <td><?php
                                        if ($appointment->vessel_type == 1) {
                                            echo 'T - ' . $appointment->tug != '' ? Vessel::findOne($appointment->tug)->vessel_name : '' . ' / B - ' . $appointment->barge != '' ? Vessel::findOne($appointment->barge)->vessel_name : '';
                                        } else {
                                            echo $appointment->vessel != '' ? Vessel::findOne($appointment->vessel)->vessel_name : '';
                                        }
                                        ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>Purpose </td> <td>:</td>
                                    <td>
                                        <?php if ($appointment->purpose != '') { ?>
                                            <?= $appointment->purpose0->purpose ?>
                                        <?php }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="topcontent-right">
                            <table class="">
                                <?php if ($epda_template->tax_id != '') { ?>
                                    <tr style="font-weight:700;">
                                        <td>TRN</td>
                                        <td>:</td>
                                        <td><?= $epda_template->tax_id ?></td>
                                    </tr>
                                <?php }
                                ?>
                                <tr>
                                    <td>Ref No </td> <td>:</td>
                                    <?php
                                    $arr = ['1' => 'A', '2' => 'B', '3' => 'C', '4' => 'D', '5' => 'E', '6' => 'F', '7' => 'G', '8' => 'H', '9' => 'I', '10' => 'J', '11' => 'K', '12' => 'L'];
                                    $last_report_saved = EstimateReport::find()->orderBy(['id' => SORT_DESC])->where(['appointment_id' => $appointment->id])->All();
                                    $c = count($last_report_saved);
                                    if ($c == 0) {
                                        $ref_no = 'EMPFUJ-' . $appointment->id . '/' . date('Y');
                                    } else {
                                        $ref_no = 'EMPFUJ-' . $appointment->id . $arr[$c] . '/' . date('Y');
                                    }
                                    ?>
                                    <td><?php echo $ref_no; ?></td>
                                </tr>
                                <tr>
                                    <td>Ops no </td>
                                    <td>:</td>
                                    <td><?= $appointment->appointment_no ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="content-header">
                        <table class="tbl">
                            <tr>
                                <td colspan="2" style="width: 52%; font-weight: bold;">Service Category</td>
                                <td rowspan="2" style="width: 8%;">Unit Tons/No</td>
                                <td rowspan="2" style="width: 12%;"><b>Comments</b></td>
                                <td rowspan="2" style="width: 8%;">Unit Price</td>
                                <td rowspan="2" style="width: 10%;">Tax</td>
                                <td rowspan="2" style="width: 10%;">Amount</td>
                            </tr>
                            <tr>
                                <td style="width: 26%;">&nbsp;</td>
                                <td style="width: 26%;color: red;">Comments/Rate to category</td>
                            </tr>
                        </table>
                    </div>
                    <div class="content-body">
                        <?php
                        $grandtotal = 0;
                        $grand_taxtotal = 0;
                        $tax_grandtotal = 0;
                        $service_categories = ServiceCategorys::find()->orderBy(['(sort_order)' => SORT_ASC])->all();
                        foreach ($service_categories as $service_category) {
                            $subtotal = 0;
                            $tax_sub_total = 0;
                            $estimates = EstimatedProforma::findAll(['apponitment_id' => $appointment->id, 'principal' => $princip, 'service_category' => $service_category->id]);
                            if (!empty($estimates)) {
                                ?>
                                <h6><?= $service_category->category_name ?></h6>
                                <table class="tbl" style="width:100%;">
                                    <?php
                                    foreach ($estimates as $estimate) {
                                        $subcategories = SubServices::findAll(['estid' => $estimate->id]);
                                        ?>
                                        <?php
                                        if (!empty($subcategories)) {
                                            ?>

                                            <?php
                                            foreach ($subcategories as $subcategory) {
                                                ?>
                                                <tr>
                                                    <td style="width: 26%;"><?= $subcategory->sub->sub_service ?></td>
                                                    <td style="width: 26%;"><?= $subcategory->rate_to_category ?></td>
                                                    <td style="width: 8%;"><?= $subcategory->unit ?></td>
                                                    <td style="width: 12%;"><?= $subcategory->comments ?></td>
                                                    <td style="width: 8%;">
                                                        <?php
                                                        if ($appointment->currency == 1) {
                                                            echo Yii::$app->SetValues->NumberFormat($subcategory->unit_price);
                                                        } else {
                                                            echo Yii::$app->SetValues->NumberFormat($subcategory->unit_price);
                                                        }
                                                        ?>
                                                    </td>
                                                    <td style="width: 10%;">
                                                        <?php
                                                        if ($appointment->currency == 1) {
                                                            echo Yii::$app->SetValues->NumberFormat($subcategory->tax_amount);
                                                        } else {
                                                            echo Yii::$app->SetValues->NumberFormat($subcategory->tax_amount);
                                                        }
                                                        ?>
                                                    </td>
                                                    <td style="width: 10%;font-weight: bold;">
                                                        <?php
                                                        if ($appointment->currency == 1) {
                                                            echo Yii::$app->SetValues->NumberFormat($subcategory->total);
                                                        } else {
                                                            echo Yii::$app->SetValues->NumberFormat($subcategory->total);
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php
                                                    $subtotal += $subcategory->total;
                                                    if ($subcategory->tax_amount != '') {
                                                        $tax_sub_total += $subcategory->tax_amount;
                                                    }
                                                    ?>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            ?>

                                            <tr>
                                                <td style="width: 26%;"><?= $estimate->service->service ?></td>
                                                <td style="width: 26%;"><?= $estimate->rate_to_category ?></td>
                                                <td style="width: 8%;"><?= $estimate->unit ?></td>
                                                <td style="width: 12%;"><?= $estimate->comments ?></td>
                                                <td style="width: 8%;">
                                                    <?php
                                                    if ($appointment->currency == 1) {

                                                        echo Yii::$app->SetValues->NumberFormat($estimate->unit_rate);
                                                    } else {
                                                        echo Yii::$app->SetValues->NumberFormat($estimate->unit_rate);
                                                    }
                                                    ?>
                                                </td>
                                                <td style="width: 10%;">
                                                    <?php
                                                    if ($appointment->currency == 1) {
                                                        echo Yii::$app->SetValues->NumberFormat($estimate->tax_amount);
                                                    } else {
                                                        echo Yii::$app->SetValues->NumberFormat($estimate->tax_amount);
                                                    }
                                                    ?>
                                                </td>
                                                <td style="width: 10%;font-weight: bold;">
                                                    <?php
                                                    if ($appointment->currency == 1) {
                                                        echo Yii::$app->SetValues->NumberFormat($estimate->epda);
                                                    } else {
                                                        echo Yii::$app->SetValues->NumberFormat($estimate->epda);
                                                    }
                                                    ?>
                                                </td>
                                                <?php
                                                $subtotal += $estimate->epda;
                                                if ($estimate->tax_amount != '') {
                                                    $tax_sub_total += $estimate->tax_amount;
                                                }
                                                ?>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="5" rowspan="2" style="text-align: center;font-weight: bold;">Sub total:</td>
                                        <td style="width: 10%;font-weight: bold;">
                                            <?php
                                            echo Yii::$app->SetValues->NumberFormat($tax_sub_total);
                                            ?>
                                        </td>
                                        <td style="font-weight: bold;">
                                            <?php
                                            echo Yii::$app->SetValues->NumberFormat($subtotal);
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                                <?php
                            }
                            $grandtotal += $subtotal;
                            $grand_taxtotal += $tax_sub_total;
                        }
                        ?>
                    </div>
                    <br/>
                    <div class="grandtotal">
                        <table class="tbl">
                            <tr>
                                <td style="width: 80%; text-align: center;" rowspan=""><b>Grand Total Estimate</b></td>
                                <?php if ($appointment->currency == 0) { ?>
                                    <td style="width: 10%;font-weight: bold;">
                                        AED : <?= Yii::$app->SetValues->NumberFormat($grandtotal + $grand_taxtotal); ?>
                                    </td>
                                    <?php
                                    $usd = round(($grandtotal + $grand_taxtotal) * $currency->currency_value, 3);
                                    ?>
                                    <td style="width: 10%;font-weight: bold;">
                                        USD : <?= Yii::$app->SetValues->NumberFormat($usd) ?>
                                    </td>
                                    <?php
                                } else {
                                    ?>
                                    <td style="width: 10%;font-weight: bold;">
                                        USD : <?= Yii::$app->SetValues->NumberFormat($grandtotal + $grand_taxtotal); ?>
                                    </td>
                                    <?php
                                    $aed = round(($grandtotal + $grand_taxtotal) / $currency->currency_value, 3);
                                    ?>
                                    <td style="width: 10%;font-weight: bold;">
                                        AED : <?= Yii::$app->SetValues->NumberFormat($aed); ?>
                                    </td>
                                <?php }
                                ?>
                            </tr>
                            <tr>
                                <td colspan="2"style="width: 90%; text-align: center;"></td>
                                <td style="width: 10%;font-weight: bold;background-color: #ffff00;font-size: 6px ! important;">E & OE</td>
                            </tr>
                        </table>

                    </div>

                    <br/>
                    <br/>
                    <br/>

                </td>
            </tr>
            <tr>
                <td>
                    <div class="content-description">
                        <?php
                        if (!empty($epda_template)) {
                            echo $epda_template->report_description;
                        }
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="bankdetails">
                        <h3>BANK DETAILS: </h3>
                        <?php
                        if (!empty($epda_template)) {
                            if ($epda_template->bank != '') {
                                $bank_detail = common\models\BankDetails::find()->where(['id' => $epda_template->bank])->one();
                            }
                        }
                        ?>
                        <table class="tbl full-width">
                            <tr>
                                <td colspan="2" style="text-align: center;font-weight: bold;">CURRENCIES ACCEPTED : USD / AED / EURO / GBP</td>
                            </tr>
                            <tr>
                                <td style="width:30%;text-align: left;">NAME</td>
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
                                <td style="width:30%;text-align: left;">A/C NO</td>
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
                                <td style="width:30%;text-align: left;">IBAN</td>
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
                                <td style="width:30%;text-align: left;">BANK NAME</td>
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
                                <td style="width:30%;text-align: left;">SWIFT</td>
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
                            <tr>
                                <td style="width:30%;text-align: left;">BRANCH</td>
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
                            <tr>
                                <td style="width:30%;text-align: left;">Correspondent Bank in USA</td>
                                <td>
                                    <?php
                                    if (!empty($bank_detail)) {
                                        if ($bank_detail->correspontant_bank != '') {
                                            echo $bank_detail->correspontant_bank;
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="bankdetails">
                        <div class="bankdetails-left">
                            <h5>Account Manager</h5>
                            <?php if (!empty($epda_template)) { ?>
                                <a href="#" style="color: #03a9f4;"><?= $epda_template->account_mannager_email == '' ? '' : $epda_template->account_mannager_email ?></a>
                                <h5><?= $epda_template->account_mannager_phone == '' ? '' : $epda_template->account_mannager_phone ?></h5>
                            <?php }
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="address">
                        <?php
                        if (!empty($epda_template)) {
                            if ($epda_template->address != '') {
                                $address_detail = common\models\Addresses::find()->where(['id' => $epda_template->address])->one();
                            }
                        }
                        ?>
                        <h3>ADDRESS: </h3>
                        <table class="tbl full-width">
                            <tr>
                                <td colspan="2" style="text-align: center;font-weight: bold;text-decoration: underline;">GENERAL ADDRESS:</td>
                            </tr>
                            <tr>
                                <td style="width:50%;">
                                    <?php
                                    if (!empty($address_detail)) {
                                        if ($address_detail->main_office_address != '') {
                                            echo $address_detail->main_office_address;
                                        }
                                    }
                                    ?>
                                </td>
                                <td style="width:50%;">
                                    <?php
                                    if (!empty($address_detail)) {
                                        if ($address_detail->contact_details != '') {
                                            echo $address_detail->contact_details;
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:100%;" colspan="2">
                                    For Suggestion / Feedback : Contact : md@emperor.ae ( 0558567350 | 05538567360 )
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td style="width:100%">
                    <div style="clear:both"></div>
                    <div class="footer">
                        <span>
                            <?php
                            if (!empty($epda_template)) {
                                if ($epda_template->footer_content != '') {
                                    echo $epda_template->footer_content;
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
<div style="display:inline-block">
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
            <a href="<?= Yii::$app->homeUrl ?>appointment/estimated-proforma/save-report?id=<?= $appointment->id ?>"><button onclick="" style="font-weight: bold !important;">Save</button></a>
            <?php
        }
        ?>

    </div>
    <!--        <div class="save" style="float:left;">
    <?php
    //echo Html::a('<span>SAVE</span>', ['/appointment/estimated-proforma/save-report', 'id' => $appointment->id], ['class' => 'btn btn-gray']);
    ?>
            </div>-->
</div>
<!--</body>
</html>-->
