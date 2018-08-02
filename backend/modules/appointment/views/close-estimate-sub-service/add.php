<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\MasterSubService;
use yii\helpers\ArrayHelper;
use common\components\AppointmentWidget;
use common\models\TaxMaster;

/* @var $this yii\web\View */
/* @var $model common\models\EstimatedProforma */

$this->title = 'Create Close Estimate Sub Services';
$this->params['breadcrumbs'][] = ['label' => 'Close Estimate', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .form-group {
        margin-bottom: 0px;
    }
</style>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h2  class="appoint-title panel-title"><?= Html::encode($this->title) . ' # <b style="color: #008cbd;">' . $appointment->appointment_no . '</b>' ?></h2>

            </div>
            <?php //Pjax::begin();    ?>
            <div class="panel-body">
                <?= AppointmentWidget::widget(['id' => $appointment->id]) ?>

                <hr class="appoint_history" />

                <div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true" data-add-focus-btn="true">

                    <table cellspacing="0" class="table table-small-font table-bordered table-striped">
                        <thead>
                            <tr>
                                <th data-priority="1">#</th>
                                <th data-priority="3">SUB SERVICE</th>
                                <th data-priority="3">UNIT</th>
                                <th data-priority="6" >UNIT PRICE</th>
                                <th data-priority="6">TOTAL</th>
                                <th data-priority="6">TAX</th>
                                <th data-priority="6">COMMENTS</th>
                                <th data-priority="1">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //var_dump($subcat);exit;
                            $subtotal = 0;
                            $i = 0;
                            foreach ($subcat as $sub):
                                $i++;
                                ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $sub->sub->sub_service; ?></td>
                                    <td><?= $sub->unit; ?></td>
                                    <td><?= $sub->unit_price; ?></td>
                                    <td><?= $sub->total; ?></td>
                                    <td><?= $sub->tax_amount; ?></td>
                                    <td><?= $sub->comments; ?></td>
                                    <td>
                                        <?= Html::a('<i class="fa fa-pencil"></i>', ['/appointment/close-estimate-sub-service/add', 'id' => $sub->close_estimate_id, 'sub_id' => $sub->id], ['class' => '']) ?>
                                        <?= Html::a('<i class="fa fa-remove"></i>', ['/appointment/close-estimate-sub-service/delete-sub', 'id' => $sub->id], ['class' => '']) ?>
                                    </td>
                                    <?php
                                    $subtotal += $sub->total;
                                    ?>
                                </tr>
                                <?php
                            endforeach;
                            ?>
                            <tr class="filter">
                                <?php $form = ActiveForm::begin(['id' => 'close-estimate-sub']); ?>
                                <td></td>
                                <td><?= $form->field($model, 'sub_service')->dropDownList(ArrayHelper::map(MasterSubService::findAll(['status' => 1, 'service_id' => $estimates->service_id]), 'id', 'sub_service'), ['prompt' => '- Sub Service-'])->label(false); ?></td>
                                <td><?= $form->field($model, 'unit')->textInput(['placeholder' => 'Unit'])->label(false) ?></td>
                                <td><?= $form->field($model, 'unit_price')->textInput(['placeholder' => 'Unit Price'])->label(false) ?></td>
                                <td><?= $form->field($model, 'total')->textInput(['placeholder' => 'Total', 'disabled' => true])->label(false) ?></td>
                                <td>
                                    <?php
                                    if ($model->isNewRecord) {
                                        $tax_percent = '';
                                    } else {
                                        $service = \common\models\Services::find()->where(['id' => $model->service_id])->one();
                                        if (!empty($service)) {
                                            if ($service->tax != '' && $service->tax > 0) {
                                                $tax_percent = TaxMaster::findOne($service->tax)->value . ' %';
                                            }
                                        }
                                    }
                                    ?>
                                    <input type="text" id="tax_percentage" name="tax_percentage" value="<?= $tax_percent ?>" readonly="" class="form-control" style="width: 60px ! important;">
                                </td>
                                <td><?= $form->field($model, 'comments')->textInput(['placeholder' => 'Comments'])->label(false) ?></td>
                                <td><?= Html::submitButton($model->isNewRecord ? 'Add' : 'Update', ['class' => 'btn btn-success']) ?>
                                </td>
                                <?php ActiveForm::end(); ?>
                            </tr>

                        </tbody>
                    </table>
                    <div>
                        <?php
                        echo Html::a('<i class="fa fa-chevron-left"></i><span>Back to Close Estimate</span>', ['/appointment/close-estimate/add', 'id' => $appointment->id], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']);
                        ?>
                    </div>
                </div>

                <script>
                    $("document").ready(function () {
                        $('#closeestimatesubservice-sub_service').change(function () {
                            var service_id = $(this).val();
                            $.ajax({
                                type: 'POST',
                                cache: false,
                                data: {service_id: service_id},
                                url: '<?= Yii::$app->homeUrl; ?>appointment/sub-services/tax-percentage',
                                success: function (data) {
                                    $("#tax_percentage").val(data + ' %');
                                }
                            });
                        });

                    });
                </script>
                <script type="text/javascript">
                    jQuery(document).ready(function ($)
                    {
                        $("#closeestimatesubservice-sub_service").select2({
                            //placeholder: 'Select your country...',
                            allowClear: true
                        }).on('select2-open', function ()
                        {
                            // Adding Custom Scrollbar
                            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                        });

//                        $(document).on('submit', '#close-estimate-sub', function (e) {
//                            if (validateForm() == 0) {
//                                return true;
//                            } else {
//                                e.preventDefault();
//                            }
//                        });

                    });
                    function validateForm() {
                        var valid = 0;
                        if (!$('#closeestimatesubservice-sub_service').val()) {
                            if ($("#closeestimatesubservice-sub_service").parent().next(".validation").length == 0) // only add if not added
                            {
                                $("#closeestimatesubservice-sub_service").parent().after("<div class='validation' style='color:red;font-size: 11px;'>Sub service is required</div>");
                            }
                            $('#closeestimatesubservice-sub_service').focus();
                            var valid = 1;
                        } else {
                            $("#closeestimatesubservice-sub_service").parent().next(".validation").remove(); // remove it
                        }
                        if (!$('#closeestimatesubservice-unit').val()) {
                            if ($("#closeestimatesubservice-unit").parent().next(".validation").length == 0) // only add if not added
                            {
                                $("#closeestimatesubservice-unit").parent().after("<div class='validation' style='color:red;font-size: 11px;padding-top: 3px;'>Unit is required</div>");
                            }
                            $('#closeestimatesubservice-unit').focus();
                            var valid = 1;
                        } else {
                            $("#closeestimatesubservice-unit").parent().next(".validation").remove(); // remove it
                        }
                        if (!$('#closeestimatesubservice-unit_price').val()) {
                            if ($("#closeestimatesubservice-unit_price").parent().next(".validation").length == 0) // only add if not added
                            {
                                $("#closeestimatesubservice-unit_price").parent().after("<div class='validation' style='color:red;font-size: 11px;padding-top: 3px;'>Unit Price is required</div>");
                            }
                            $('#closeestimatesubservice-unit_price').focus();
                            var valid = 1;
                        } else {
                            $("#closeestimatesubservice-unit_price").parent().next(".validation").remove(); // remove it
                        }
                        return valid;
                    }
                </script>


                <link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2.css">
                <link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2-bootstrap.css">
                <script src="<?= Yii::$app->homeUrl; ?>js/select2/select2.min.js"></script>

                <script>
                    $(document).ready(function () {
                        $("#closeestimatesubservice-unit").keyup(function () {
                            multiply();
                        });
                        $("#closeestimatesubservice-unit_price").keyup(function () {
                            multiply();
                        });
                    });
                    function multiply() {
                        var rate = $("#closeestimatesubservice-unit").val();
                        var unit = $("#closeestimatesubservice-unit_price").val();
                        if (rate != '' && unit != '') {
                            $("#closeestimatesubservice-total").val(rate * unit);
                        }

                    }
                    $("#closeestimatesubservice-total").prop("disabled", true);
                </script>
            </div>
            <?php //Pjax::end();      ?>
        </div>
    </div>
</div>
<!--<a href="javascript:;" onclick="showAjaxModal();" class="btn btn-primary btn-single btn-sm">Show Me</a>
 Modal code
<script type="text/javascript">
        function showAjaxModal(id)
        {
            jQuery('#add-sub').modal('show', {backdrop: 'static'});
            jQuery('#add-sub .modal-body').html(id);
            /*setTimeout(function ()
             {
             jQuery.ajax({
             url: "data/ajax-content.txt",
             success: function (response)
             {
             jQuery('#modal-7 .modal-body').html(response);
             }
             });
             }, 800); // just an example
             */
        }
</script>-->
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
