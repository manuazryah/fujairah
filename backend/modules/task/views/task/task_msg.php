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
?>
<!DOCTYPE html>

<div id="print">
    <link rel="stylesheet" href="<?= Yii::$app->homeUrl ?>css/pdf.css">
    <style type="text/css">

        @media print {
            thead {display: table-header-group;}
            tfoot {display: table-footer-group}
            /*tfoot {position: absolute;bottom: 0px;}*/
            .main-tabl{width: 100%}
            .footer {position: fixed ; left: 0px; bottom: 0px; right: 0px; font-size:10px; }
        }
        /*.footer {position: fixed ; left: 0px; bottom: 0px; right: 0px; font-size:10px; }*/
        @media screen{
            .main-tabl{
                width: 60%;
            }
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
    </style>
    <table class="main-tabl" border="0" >
        <tbody>
            <tr>
                <td>
                    <div class="bankdetails">
                        <h3>New Task: </h3>
                        <table class="table">
                            <tr>
                                <td colspan="2" style="text-align: center;font-weight: bold;">CURRENCIES ACCEPTED : USD / AED / EURO / GBP</td>
                            </tr>
                            <tr>
                                <td style="width:30%;text-align: left;">NAME</td>
                                <td>EMPEROR SHIPPING LINES LLC</td>
                            </tr>
                            <tr>
                                <td style="width:30%;text-align: left;">A/C NO</td>
                                <td>90050200004102</td>
                            </tr>
                            <tr>
                                <td style="width:30%;text-align: left;">IBAN</td>
                                <td>AE150110090050200004102</td>
                            </tr>
                            <tr>
                                <td style="width:30%;text-align: left;">BANK NAME</td>
                                <td>Bank of Baroda</td>
                            </tr>
                            <tr>
                                <td style="width:30%;text-align: left;">SWIFT</td>
                                <td>BARBAEADRAK</td>
                            </tr>
                            <tr>
                                <td style="width:30%;text-align: left;">BRANCH</td>
                                <td>RAS AL KHAIMAH, UAE</td>
                            </tr>
                            <tr>
                                <td style="width:30%;text-align: left;">Correspondent Bank in USA</td>
                                <td>Bank of Baroda,Newyork <br/>Swift Code : BARBUS33</td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!--</body>
</html>-->
