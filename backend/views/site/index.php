<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\VesselType;
use common\models\Vessel;
use common\models\Ports;
use common\models\Debtor;
use common\models\Terminal;
use common\models\Stages;
use yii\helpers\ArrayHelper;
?>
<style>
    .nav-tabs {
        /*border-bottom: 1px solid #ddd !important;*/
        margin-top: 15px;
    }
    .nav.nav-tabs>li>a {
        background-color: #f9f9f9;
        color: #000;
    }
    .nav-tabs .active {
        border-bottom: 1px solid #337ab7;
    }
    .nav.nav-tabs+.tab-content {
        background: #f9f9f9;
        padding-left: 0px;
    }
    .nav.nav-tabs>li.active>a {
        background-color: #f9f9f9;
    }
    .nav.nav-tabs>li>a:hover {
        background-color: #f9f9f9;
    }
    .hidden-xs{
        padding-left: 7px;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="page-title">

            <div class="title-env">
                <h1 class="title">White Board</h1>
            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body"><div class="demo-create">
                        <div class="col-md-12">

                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#home" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa-envelope-o hidden-xs"></i></span>
                                        <i class="fa fa-th-list" aria-hidden="true"></i>
                                        <span class="hidden-xs span-font-size">  Expected</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#sailed" data-toggle="tab">
                                        <span class="visible-xs"><i class="fa-user"></i></span>
                                        <i class="fa fa-th-list" aria-hidden="true"></i>
                                        <span class="hidden-xs">  Sailed</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#inport" data-toggle="tab">
                                        <span class="visible-xs"><i class="fa-envelope-o"></i></span>
                                        <i class="fa fa-th-list" aria-hidden="true"></i>
                                        <span class="hidden-xs">  Inport</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#reconciled" data-toggle="tab">
                                        <span class="visible-xs"><i class="fa-cog"></i></span>
                                        <i class="fa fa-th-list" aria-hidden="true"></i>
                                        <span class="hidden-xs">  Reconciled</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active" id="home">
                                    <?php
                                    if (!empty($expected_datas)) {
                                        ?>
                                        <table class="table responsive">
                                            <thead>
                                                <tr>
                                                    <th>Vessel Type</th>
                                                    <th>Vessel</th>
                                                    <th>Port Of Call</th>
                                                    <th>ETA</th>
                                                    <th>Appointment No</th>
                                                    <th>Principal</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                foreach ($expected_datas as $expected_data) {
                                                    if (!empty($expected_data)) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                echo VesselType::findOne($expected_data->vessel_type)->vessel_type;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if ($expected_data->vessel_type == 1) {
                                                                    echo 'T -' . Vessel::findOne($expected_data->tug)->vessel_name . ' / </br>B -' . Vessel::findOne($expected_data->barge)->vessel_name;
                                                                } else {
                                                                    if (isset($expected_data->vessel)) {
                                                                        echo Vessel::findOne($expected_data->vessel)->vessel_name;
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                echo Ports::findOne($expected_data->port_of_call)->port_name;
                                                                ?>
                                                            </td>
                                                            <td><?= $expected_data->eta ?></td>
                                                            <td><?= $expected_data->appointment_no ?></td>
                                                            <td>
                                                                <?php
                                                                echo $this->context->getPrincipals($expected_data->principal);
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="tab-pane" id="sailed">
                                    <?php
                                    if (!empty($sailed)) {
                                        ?>
                                        <table class="table responsive">
                                            <thead>
                                                <tr>
                                                    <th>Vessel Type</th>
                                                    <th>Vessel</th>
                                                    <th>Port Of Call</th>
                                                    <th>ETA</th>
                                                    <th>Appointment No</th>
                                                    <th>Principal</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                foreach ($sailed as $value) {
                                                    if (!empty($value)) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                echo VesselType::findOne($value->vessel_type)->vessel_type;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if ($value->vessel_type == 1) {
                                                                    echo 'T -' . Vessel::findOne($value->tug)->vessel_name . ' / </br>B -' . Vessel::findOne($value->barge)->vessel_name;
                                                                } else {
                                                                    if (isset($value->vessel)) {
                                                                        echo Vessel::findOne($value->vessel)->vessel_name;
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                echo Ports::findOne($value->port_of_call)->port_name;
                                                                ?>
                                                            </td>
                                                            <td><?= $value->eta ?></td>
                                                            <td><?= $value->appointment_no ?></td>
                                                            <td>
                                                                <?php
                                                                echo $this->context->getPrincipals($value->principal);
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="tab-pane" id="inport">
                                    <?php
                                    if (!empty($inports)) {
                                        ?>
                                        <table class="table responsive">
                                            <thead>
                                                <tr>
                                                    <th>Vessel Type</th>
                                                    <th>Vessel</th>
                                                    <th>Port Of Call</th>
                                                    <th>ETA</th>
                                                    <th>Appointment No</th>
                                                    <th>Principal</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                foreach ($inports as $inport) {
                                                    if (!empty($inport)) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                echo VesselType::findOne($inport->vessel_type)->vessel_type;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if ($inport->vessel_type == 1) {
                                                                    echo 'T -' . Vessel::findOne($inport->tug)->vessel_name . ' / </br>B -' . Vessel::findOne($expected_data->barge)->vessel_name;
                                                                } else {
                                                                    if (isset($inport->vessel)) {
                                                                        echo Vessel::findOne($inport->vessel)->vessel_name;
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                echo Ports::findOne($inport->port_of_call)->port_name;
                                                                ?>
                                                            </td>
                                                            <td><?= $inport->eta ?></td>
                                                            <td><?= $inport->appointment_no ?></td>
                                                            <td>
                                                                <?php
                                                                echo $this->context->getPrincipals($inport->principal);
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <div class="tab-pane" id="reconciled">

                                    <?php
                                    ?>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
