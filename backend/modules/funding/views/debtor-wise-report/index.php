<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\DemoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Debtor / Principal Wise Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="demo-index">

    <div class="row">
        <div class="col-md-12">
            <div class="page-title">

                <div class="title-env">
                    <h1 class="title"><?= Html::encode($this->title) ?></h1>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body"><div class="demo-create">
                        <div class="row">
                            <?= Html::beginForm() ?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="contacts-status">Debtor/Principal</label>
                                    <select id="report-debtor-id" class="form-control" name="debtor" aria-invalid="false">
                                        <option value="">Choose Principal/Debtor</option>
                                        <?php
                                        foreach ($debtors as $value) {
                                            ?>
                                            <option value="<?= $value->id ?>"><?= $value->principal_id ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                    <div class="help-block"></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label class="control-label">From Date</label>
                                    <?php
                                    echo DatePicker::widget([
                                        'name' => 'from_date',
                                        'id' => 'print-date',
                                        'value' => date('Y-m-d'),
                                        'dateFormat' => 'yyyy-MM-dd',
                                        'options' => ['class' => 'form-control']
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label class="control-label">To Date</label>
                                    <?php
                                    echo DatePicker::widget([
                                        'name' => 'to_date',
                                        'id' => 'print-date',
                                        'value' => date('Y-m-d'),
                                        'dateFormat' => 'yyyy-MM-dd',
                                        'options' => ['class' => 'form-control']
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <?= Html::submitButton('<span>Submit</span>', ['class' => 'btn btn-secondary', 'style' => 'margin-top: 30px;']) ?>
                                <?= Html::endForm() ?>
                            </div>
                        </div>
                        <div class="row">
                            <table cellspacing="0" class="table table-small-font table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Appointment No</th>
                                        <th>Total Amount</th>
                                        <th>Amount Paid</th>
                                        <th>Outstanding</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($uniq_arr)) { ?>
                                        <?php
                                        foreach ($uniq_arr as $arr) {
                                            $fundings = common\models\FundingAllocation::find()->where(['appointment_id' => $arr])->all();
                                            ?>
                                            <tr>
                                                <td><?= \common\models\Appointment::findOne(['id' => $arr])->appointment_no ?></td>
                                                <?php
                                                $tot_amount = 0;
                                                $paid_amount = 0;
                                                foreach ($fundings as $val) {
                                                    if ($val->appointment_id == $arr) {
                                                        if ($val->type == 4) {
                                                            $tot_amount = $val->outstanding;
                                                        } elseif ($val->type == 3) {
                                                            $tot_amount = $val->outstanding;
                                                        } else {
                                                            $paid_amount = $val->amount;
                                                        }
                                                    }
                                                }
                                                ?>
                                                <td><?= Yii::$app->SetValues->NumberFormat($tot_amount); ?></td>
                                                <td><?= Yii::$app->SetValues->NumberFormat($paid_amount); ?></td>
                                                <td><?= $tot_amount - $paid_amount ?></td>
                                            </tr>
                                        <?php }
                                        ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="4">No Result Fount</td>
                                        </tr>
                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2.css">
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2-bootstrap.css">
<script src="<?= Yii::$app->homeUrl; ?>js/select2/select2.min.js"></script>
<script>
    $(document).ready(function () {

        /*********** Script for dropdown search widget start ********************/

        $("#report-debtor-id").select2({
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });

        /*********** Script for dropdown search widget end ********************/
    });
</script>

