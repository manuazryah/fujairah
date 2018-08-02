<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PortCallData */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="port-call-data-form form-inline">
    <?php $form = ActiveForm::begin(); ?>

    <?php //$form->field($model, 'appointment_id')->textInput(['readonly' => true, 'value' => $model->appointment->appointment_no]) ?>

    <div><a class="portcall">If Immigration Clearance Applicable</a></div>
    <!--    <div class="form-group "></div>
        <div class="form-group "></div>
        <div class="form-group "></div>
        <div class="form-group "></div>-->
    <?php
    //var_dump($model->appointment_id);exit;
    ?>
    <div class="row hidediv1">
        <div class="col-md-12">
            <?= $form->field($model_imigration, 'arrived_ps')->textInput(['tabindex' => 1]) ?>


            <?= $form->field($model_imigration, 'first_line_ashore')->textInput(['tabindex' => 3]) ?>

            <?= $form->field($model_imigration, 'all_fast')->textInput(['tabindex' => 4]) ?>

            <?= $form->field($model_imigration, 'agent_on_board')->textInput(['tabindex' => 5]) ?>

            <?= $form->field($model_imigration, 'imi_clearence_commenced')->textInput(['tabindex' => 6]) ?>

            <?= $form->field($model_imigration, 'imi_clearence_completed')->textInput(['tabindex' => 7]) ?>

            <?= $form->field($model_imigration, 'pob_inbound')->textInput(['tabindex' => 8]) ?>

            <?= $form->field($model_imigration, 'pob_outbound')->textInput(['tabindex' => 9]) ?>

            <?= $form->field($model_imigration, 'cast_off')->textInput(['tabindex' => 10]) ?>

            <?= $form->field($model_imigration, 'cleared_break_water')->textInput(['tabindex' => 11]) ?>

            <?= $form->field($model_imigration, 'drop_anchor')->textInput(['tabindex' => 12]) ?>

            <?= $form->field($model_imigration, 'heave_up_anchor')->textInput(['tabindex' => 13]) ?>

            <?= $form->field($model_imigration, 'pilot_boarded')->textInput(['tabindex' => 14]) ?>
        </div>
    </div>
    <hr class="appoint_history" />
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'eta')->textInput(['tabindex' => 15])->label('ETA <span class="required-star"> * </span>') ?>

            <?= $form->field($model, 'ets')->textInput(['tabindex' => 16]) ?>

            <?= $form->field($model, 'eosp')->textInput(['tabindex' => 17])->label('EOSP <span class="required-star"> * </span>') ?>

            <?= $form->field($model, 'arrived_anchorage')->textInput(['tabindex' => 18]) ?>

            <?= $form->field($model, 'nor_tendered')->textInput(['tabindex' => 19]) ?>
        </div>
    </div>
    <hr class="appoint_history" />
    <div class="row">
        <div class="col-md-12">
            <?php
            if ($model_appointment->port_of_call == 2 || $model_appointment->port_of_call == 3) {
                if ($model_appointment->purpose == 2 && $model_appointment->port_of_call == 2) {
                    //$var = "_form_rmc_tanker";
                    echo $this->render('_form_rmc_tanker', [
                        'model' => $model,
                        'form' => $form,
                    ]);
                } else {
                    //$var = "_form_stevin_rocks";
                    echo $this->render('_form_stevin_rocks', [
                        'model' => $model,
                        'form' => $form,
                    ]);
                }
            } else {
                //$var = "_form_common";
                echo $this->render('_form_common', [
                    'model' => $model,
                    'form' => $form,
                ]);
            }
            ?>
        </div>
    </div>

    <hr class="appoint_history" />
    <div id="p_scents">
        <h4 style = "color:#000;font-style: italic;font-weight: 600;">Additional SOF Details</h4>
        <input type="hidden" id="delete_port_vals"  name="delete_port_vals" value="">
        <?php
        if (!empty($model_additional)) {

            foreach ($model_additional as $data) {
                ?>
                <span>
                    <div class="row list_additional">
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="updatee[<?= $data->id; ?>][label][]" value="<?= $data->label; ?>" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="updatee[<?= $data->id; ?>][value][]" value="<?= $data->value; ?>" required>
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="updatee[<?= $data->id; ?>][comment][]" value="<?= $data->comment; ?>" required>
                        </div>
                        <div class="col-md-1">
                            <a id="" val="<?= $data->id; ?>" class="btn btn-icon btn-red remaddition" style="margin-top:0px;"><i class="fa-remove"></i></a>
                        </div>
                    </div>
                </span>
                <br>
                <?php
            }
        }
        ?>
        <br>
        <span>
            <div class="row">
                <div class="col-md-3">
                    <label class="control-label">Label</label>
                    <input type="text" class="form-control" name="create[label][]">
                </div>
                <div class="col-md-3">
                    <label class="control-label" for="">Date / Time</label>
                    <input type="text" class="form-control" name="create[valuee][]">
                </div>
                <div class="col-md-5">
                    <label class="control-label" >Port Call Activities</label>
                    <input type="text" class="form-control" name="create[comment][]">
                </div>
                <div class="col-md-1"></div>
        </span>
    </div>
    <br/>
</div>
<div class="row">
    <div class="col-md-12">
        <a id="addScnt" class="btn btn-icon btn-blue addScnt" ><i class="fa-plus"></i></a>
    </div>
</div>
<br/>
<hr class="appoint_history" />

<?php // $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']) ?>
<div class="form-group "></div>
<div class="form-group "></div>
<div class="form-group "></div>
<br/>
<div class="row" style="margin-left: 0px;">
    <h4 style = "color:#000;font-style: italic;font-weight: 600;">Comments</h4>
    <?= Html::a('<img width="35" src="' . Yii::$app->homeUrl . 'images/pdf-icon.png" >', ['pdf-export', 'id' => $model_appointment->id], ['target' => '_blank', 'style' => 'float:right;']) ?>
    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($model_comments)) { ?>
                <table class="table table-bordered table-responsive comment-tbl">
                    <tr>
                        <th>User Name</th>
                        <th>Date</th>
                        <th>Department</th>
                        <th>Assigned To</th>
                        <th>Comments</th>
                    </tr>
                    <?php
                    foreach ($model_comments as $data) {
                        ?>
                        <tr>
                            <td><?= \common\models\Employee::findOne(['id' => $data->user_id])->name ?></td>
                            <td><?= $data->comment_date ?></td>
                            <td>
                                <?php
                                if ($data->department == '') {
                                    echo '';
                                } elseif ($data->department == 1) {
                                    echo 'Common';
                                } elseif ($data->department == 2) {
                                    echo 'Operations';
                                } elseif ($data->department == 3) {
                                    echo 'Accounts';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if (isset($data->assigned_to) && $data->assigned_to != '') {
                                    echo common\models\Employee::findOne($data->assigned_to)->name;
                                } else {
                                    echo '';
                                }
                                ?>
                            </td>
                            <td><?= $data->comment ?></td>
                        </tr>
                    <?php }
                    ?>
                </table>
            <?php }
            ?>
        </div>
    </div>
</div>
<div id="p_comments">
    <input type="hidden" id="delete_comment_vals"  name="delete_comment_vals" value="">
    <span>
        <div class="row">
            <div class = 'col-md-5 col-sm-12 col-xs-12 left_padd'>
                <label class="control-label">Comment</label>
                <textarea id="port_comment-1" rows="3" cols="90" class="form-control port-comment" name="addd[comment][]"></textarea>

            </div>
            <div class = 'col-md-3 col-sm-12 col-xs-12 left_padd'>
                <label class="control-label" for="">Department</label>
                <select id="port_department-1" class="form-control port-department" name="addd[department][]">
                    <option value="1">Common</option>
                    <option value="2">Operations</option>
                    <option value="3">Accounts</option>
                </select>
            </div>
            <div class = 'col-md-3 col-sm-12 col-xs-12 left_padd'>
                <label class="control-label port-assign_to" for="">Assigned To</label>
                <select id="port_assign_to-1" class="form-control" name="addd[assign-to][]">
                    <option value="">- Select -</option>
                    <?php
                    $emp_datas = \common\models\Employee::findAll(['status' => 1]);
                    foreach ($emp_datas as $emp_data) {
                        ?>
                        <option value="<?= $emp_data->id ?>"><?= $emp_data->name ?></option>
                    <?php }
                    ?>
                </select>
            </div>
        </div>
        <div style="clear:both"></div>
    </span>
    <br/>
</div>
<div class="row">
    <div class="col-md-12">
        <a id="addComments" title="Add More Comments" class="btn btn-icon btn-blue addComments" style=""><i class="fa-plus"></i></a>
    </div>
</div>
<hr class="appoint_history" />
<?php
if ($model_appointment->status != 0) {
    ?>
    <div class="col-md-12">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top: 18px;float:right;']) ?>
    </div>
    <?php
}
?>
<?php ActiveForm::end(); ?>
<style>
    .form-inline .form-group {
        width: 16%;
        margin-left: 30px;
        margin-bottom: 22px;
    }
    .form-inline .eosp .form-group {
        width: 100%;
    }
    .portcall {
        color: #0049a0;
        font-size: 16px;
        margin-left: 31px;
        margin-bottom: 12px;
        cursor: pointer;
        text-decoration: underline;
    }
    .nav.nav-tabs+.tab-content {
        background-color: #f9f9f9 !important;
        padding: 30px;
        margin-bottom: 30px;
    }
    .form-control {
        width: 100% !important;
        font-weight: bold !important;
    }
    .nav.nav-tabs>li.active>a {
        background-color: #e4e4e4;
    }
    .txtarea{
        width:97% !important;
        margin-left: 28px;
        height: 150px;
    }
    .hidediv1{
        display:none;
    }
</style>
</div>
<script>
    $(document).ready(function () {
        $(document).on('click', '.remaddition', function (e) {
            e.preventDefault();
            $(this).closest('.list_additional').remove();
            if (this.hasAttribute("val")) {
                var valu = $(this).attr('val');
                $('#delete_port_vals').val($('#delete_port_vals').val() + valu + ',');
                var value = $('#delete_port_vals').val();
            }
            return false;
        });
        /*
         * Add more bnutton function
         */
        var scntDiv = $('#p_scents');
        var i = $('#p_scents span').size() + 1;
        $('#addScnt').on('click', function () {
            var ver = '<span>\n\
            <div class="row">\n\
                <div class="col-md-3">\n\
                    <label class="control-label">Label</label>\n\
                    <input type="text" class="form-control" name="create[label][]">\n\
                </div>\n\
                <div class="col-md-3">\n\
                    <label class="control-label" for="">Date / Time</label>\n\
                    <input type="text" class="form-control" name="create[valuee][]">\n\
                </div>\n\
                <div class="col-md-5">\n\
                    <label class="control-label" >Port Call Activities</label>\n\
                    <input type="text" class="form-control" name="create[comment][]">\n\
                </div>\n\
                <div class="col-md-1">\n\
<a id="remScnt" class="btn btn-icon btn-red remScnt" ><i class="fa-remove"></i></a>\n\
</div>\n\
</div>\n\
<br/>\n\
        </span>';
            $(ver).appendTo(scntDiv);
            i++;
            return false;
        });
        $('#p_scents').on('click', '.remScnt', function () {
            if (i > 2) {
                $(this).parents('span').remove();
                i--;
            }
            if (this.hasAttribute("val")) {
                var valu = $(this).attr('val');
                $('#delete_port_vals').val($('#delete_port_vals').val() + valu + ',');
                var value = $('#delete_port_vals').val();
            }
            return false;
        });
        $('.portcall').click(function () {
            $('.hidediv1').slideToggle();
        });
        /*
         * Add more bnutton function
         */
        var scntDiv1 = $('#p_comments');
        var i = $('#p_comments span').size() + 1;
        $('#addComments').on('click', function () {
            var ver = '<span><div class="row">\n\
            <div class = "col-md-5 col-sm-12 col-xs-12 left_padd">\n\
                <label class="control-label">Comment</label>\n\
                <textarea id="port_comment-' + i + '" rows="3" cols="90" class="form-control port-comment" name="addd[comment][]"></textarea>\n\
            </div>\n\
            <div class = "col-md-3 col-sm-12 col-xs-12 left_padd">\n\
                <label class="control-label" for="">Department</label>\n\
                <select id="port_department-' + i + '" class="form-control port-department" name="addd[department][]">\n\
                    <option value="1">Common</option>\n\
                    <option value="2">Operations</option>\n\
                    <option value="3">Accounts</option>\n\
                </select>\n\
            </div>\n\
            <div class = "col-md-3 col-sm-12 col-xs-12 left_padd">\n\
                <label class="control-label port-assign_to" for="">Assigned To</label>\n\
                <select id="port_assign_to-' + i + '" class="form-control" name="addd[assign-to][]">\n\
                    <option value="">- Select -</option>\n\
                </select>\n\
            </div>\n\
            <div class = "col-md-1 col-sm-12 col-xs-12 left_padd">\n\
               <a id="remCommnt" class="btn btn-icon btn-red remCommnt" style="margin-top: 27px;"><i class="fa-remove"></i></a>\n\
                </div></div><div style="clear:both"></div><br>\n\
        </span>';
            $(ver).appendTo(scntDiv1);
            i++;
            return false;
        });
        $('#p_comments').on('click', '.remCommnt', function () {
            if (i > 2) {
                $(this).parents('span').remove();
                i--;
            }
            if (this.hasAttribute("val")) {
                var valu = $(this).attr('val');
                $('#delete_comment_vals').val($('#delete_comment_vals').val() + valu + ',');
                var value = $('#delete_comment_vals').val();
            }
            return false;
        });
    });
</script>