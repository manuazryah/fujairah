<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use common\models\Services;
use common\models\MasterSubService;
use common\models\Currency;
use common\models\Contacts;
use common\models\Debtor;
use common\models\Appointment;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use common\components\AppointmentWidget;

/* @var $this yii\web\View */
/* @var $model common\models\EstimatedProforma */

$this->title = 'Create Sub Services';
$this->params['breadcrumbs'][] = ['label' => 'Estimated Proformas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

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
<!--                                <th data-priority="1">SERVICES</th>-->
                                <th data-priority="3">SUB SERVICE</th>
                                <th data-priority="1">RATE TO CATEGORY</th>
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
                            $i = 0;
                            $subtotal = 0;
                            foreach ($subcat as $sub):
                                $i++;
                                ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $sub->sub->sub_service; ?></td>
                                    <td class="edit_text" id="<?= $sub->id ?>-rate_to_category" val="<?= $sub->rate_to_category ?>">
                                        <?php
                                        if ($sub->rate_to_category == '') {
                                            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                        } else {
                                            if (strlen($sub->rate_to_category) > 15) {
                                                echo substr($sub->rate_to_category, 0, 15) . '...';
                                            } else {
                                                echo $sub->rate_to_category;
                                            }
                                        }
                                        ?>

                                    </td>
                                    <td class="edit_text" id="<?= $sub->id ?>-unit" val="<?= $sub->unit ?>" data-service="<?= $sub->sub_service ?>">
                                        <?php
                                        if ($sub->unit == '') {
                                            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                        } else {
                                            echo Yii::$app->SetValues->NumberFormat($sub->unit);
                                        }
                                        ?>
                                    </td>
                                    <td class="edit_text" id="<?= $sub->id ?>-unit_price" val="<?= $sub->unit_price ?>" data-service="<?= $sub->sub_service ?>">
                                        <?php
                                        if ($sub->unit_price == '') {
                                            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                        } else {
                                            echo Yii::$app->SetValues->NumberFormat($sub->unit_price);
                                        }
                                        ?>
                                    </td>
                                    <td class="edit_text" id="<?= $sub->id ?>-total" val="<?= $sub->total ?>" data-service="<?= $sub->sub_service ?>">
                                        <?php
                                        if ($sub->total == '') {
                                            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                        } else {
                                            echo Yii::$app->SetValues->NumberFormat($sub->total);
                                        }
                                        ?>
                                    </td>
                                    <td id="<?= $sub->id ?>-tax_amount">
                                        <?php
                                        if ($sub->tax_amount == '') {
                                            echo Yii::$app->SetValues->NumberFormat(0);
                                        } else {
                                            echo Yii::$app->SetValues->NumberFormat($sub->tax_amount);
                                        }
                                        ?>
                                    </td>
                                    <td class="edit_text" id="<?= $sub->id ?>-comments" val="<?= $sub->comments ?>">
                                        <?php
                                        if ($sub->comments == '') {
                                            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                        } else {
                                            if (strlen($sub->comments) > 15) {
                                                echo substr($sub->comments, 0, 15) . '...';
                                            } else {
                                                echo $sub->comments;
                                            }
                                        }
                                        ?>

                                    </td>
                                    <td>
                                        <?= Html::a('<i class="fa fa-pencil"></i>', ['/appointment/sub-services/add', 'id' => $sub->estid, 'sub_id' => $sub->id], ['class' => '']) ?>
                                        <?= Html::a('<i class="fa fa-remove"></i>', ['/appointment/sub-services/delete-sub', 'id' => $sub->id], ['class' => '']) ?>
                                    </td>
                                    <?php
                                    $subtotal += $sub->total;
                                    ?>
                                </tr>
                                <?php
                            endforeach;
                            ?>
                            <tr class="filter">
                                <?php $form = ActiveForm::begin(); ?>
                                <td></td>
<!--                                <td><?php // $form->field($model, 'service_id')->dropDownList(ArrayHelper::map(Services::findAll(['status' => 1]), 'id', 'service'), ['prompt' => '-Service-'])->label(false);                                                       ?></td>-->
                                <td><?= $form->field($model, 'sub_service')->dropDownList(ArrayHelper::map(MasterSubService::findAll(['status' => 1, 'service_id' => $estimates->service_id]), 'id', 'sub_service'), ['prompt' => '- Sub Service-'])->label(false); ?></td>
<!--                                <td><?php // $form->field($model, 'supplier')->dropDownList(ArrayHelper::map(Contacts::findAll(['status' => 1]), 'id', 'name'), ['prompt' => '-Supplier-'])->label(false);                                                              ?></td>
                               <td><?php //$form->field($model, 'currency')->dropDownList(ArrayHelper::map(Currency::findAll(['status' => 1]), 'id', 'currency_name'), ['prompt' => '-Currency-'])->label(false);                                                                           ?></td>-->
                                <td><?= $form->field($model, 'rate_to_category')->textInput(['placeholder' => 'Rate To Category'])->label(false) ?></td>
                                <td><?= $form->field($model, 'unit')->textInput(['type' => 'number', 'min' => 0, 'placeholder' => 'Unit'])->label(false) ?></td>
                                <td><?= $form->field($model, 'unit_price')->textInput(['placeholder' => 'Unit Price'])->label(false) ?></td>
<!--                                <td><?php //$form->field($model, 'roe')->textInput(['placeholder' => 'ROE'])->label(false)                                                                           ?></td>-->
                                <td><?= $form->field($model, 'total')->textInput(['placeholder' => 'Total', 'disabled' => true])->label(false) ?></td>
                                <td><input type="text" id="tax_percentage" name="tax_percentage" value="" readonly="" class="form-control" style="width: 60px ! important;"></td>
                                <td><?= $form->field($model, 'comments')->textInput(['placeholder' => 'Comments'])->label(false) ?></td>
                                <td><?= Html::submitButton($model->isNewRecord ? 'Add' : 'Update', ['class' => 'btn btn-success']) ?>
                                </td>
                                <?php ActiveForm::end(); ?>
                            </tr>

                        </tbody>
                    </table>
                    <div>
                        <?php
                        echo Html::a('<i class="fa fa-chevron-left"></i><span>Back to Estmated Proforma</span>', ['/appointment/estimated-proforma/add', 'id' => $appointment->id], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']);
                        ?>
                    </div>
                </div>

                <script>
                    $("document").ready(function () {
                        $('#subservices-sub_service').change(function () {
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
                        $("#subservices-sub_service").select2({
                            //placeholder: 'Select your country...',
                            allowClear: true
                        }).on('select2-open', function ()
                        {
                            // Adding Custom Scrollbar
                            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                        });

                    });</script>


                <link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2.css">
                <link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2-bootstrap.css">
                <script src="<?= Yii::$app->homeUrl; ?>js/select2/select2.min.js"></script>

                <script>
                    $(document).ready(function () {
                        $("#subservices-unit").keyup(function () {
                            multiply();
                        });
                        $("#subservices-unit_price").keyup(function () {
                            multiply();
                        });
                    });
                    function multiply() {
                        var rate = $("#subservices-unit").val();
                        var unit = $("#subservices-unit_price").val();
                        if (rate != '' && unit != '') {
                            $("#subservices-total").val(rate * unit);
                        }

                    }
                    $("#subservices-total").prop("disabled", true);
                </script>
            </div>
            <?php //Pjax::end();    ?>
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
    <script>
        $("document").ready(function () {

            /*
             * Double click enter function
             * */

            $('.edit_text').on('dblclick', function () {

                var val = $(this).attr('val');
                var service = $(this).attr('data-service');
                var idd = this.id;
                var res_data = idd.split("-");
                if (res_data[1] == 'comments' || res_data[1] == 'rate_to_category') {
                    $(this).html('<textarea class="' + idd + '" value="' + val + '">' + val + '</textarea>');

                } else {
                    $(this).html('<input class="' + idd + '" type="text" value="' + val + '" service-id="' + service + '"/>');

                }

                $('.' + idd).focus();
            });
            $('.edit_text').on('focusout', 'input,textarea', function () {
                var thiss = $(this).parent('.edit_text');
                var data_id = thiss.attr('id');
                var update = thiss.attr('update');
                var res_id = data_id.split("-");
                var res_val = $(this).val();
                var service_id = $(this).attr('service-id');
                $.ajax({
                    type: 'POST',
                    cache: false,
                    data: {id: res_id[0], name: res_id[1], valuee: res_val, service: service_id},
                    url: '<?= Yii::$app->homeUrl; ?>appointment/sub-services/edit-estimate-sub',
                    success: function (data) {
                        if (res_val == '') {
                            res_val = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                        } else {
                            $("#" + res_id[0] + "-tax_amount").text(data);
                        }
                        thiss.html(res_val);
                        location.reload();
                    }
                });

            });
        });
    </script>
</div>
