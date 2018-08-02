<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Branch;
use common\models\AdminPosts;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Employee */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    #add_new_upload{
        float: right;
        padding-right: 10%;
    }
    .btn.btn-red {
        margin-top: 28px;
    }
</style>

<div class="">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <?php $posts = ArrayHelper::map(AdminPosts::findAll(['status' => 1]), 'id', 'post_name'); ?>
            <div class="col-md-12">
                <?= $form->field($model, 'post_id')->dropDownList($posts, ['prompt' => '-Choose a Post-']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <?php $branch = ArrayHelper::map(Branch::findAll(['status' => 1]), 'id', 'branch_name'); ?>
            <?php
            if (!$model->isNewRecord && $model->branch_id != '') {
                $model->branch_id = explode(',', $model->branch_id);
            }
            ?>
            <div class="col-md-12">
                <?= $form->field($model, 'branch_id')->dropDownList($branch, ['prompt' => '-Choose a Branch-', 'id' => 'branchs', 'multiple' => 'multiple']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <?php if ($model->isNewRecord) { ?>
            <div class="col-md-4">
                <div class="col-md-12">
                    <?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        <?php } ?>
        <?php if ($model->isNewRecord) { ?>
            <div class="col-md-4">
                <div class="col-md-12">
                    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
                </div>
            </div>
        <?php } ?>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'employee_code')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'department')->dropDownList(['2' => 'Operations', '3' => 'Accounts'], ['prompt' => '-Select Department-']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'gender')->dropDownList(['1' => 'Male', '0' => 'Female']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'maritual_status')->dropDownList(['1' => 'Married', '0' => 'Unmarried']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?php
                if (!isset($model->date_of_join)) {
                    $model->date_of_join = date('d-m-Y');
                }
                ?>
                <?=
                $form->field($model, 'date_of_join')->widget(\yii\jui\DatePicker::classname(), [
                    //'language' => 'ru',
                    'dateFormat' => 'dd-MM-yyyy',
                    'options' => ['class' => 'form-control']
                ])
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'salary_package')->textInput() ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'photo')->fileInput() ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="col-md-12">
                <?= $form->field($model, 'address')->textarea(['rows' => 4]) ?>
            </div>
        </div>
    </div>

    <hr class="appoint_history" />
    <div class="row">
        <div id="p_scents">
            <input type="hidden" id="delete_port_vals"  name="delete_port_vals" value="">
            <?php
            if (!empty($model_additional)) {

                foreach ($model_additional as $data) {
                    ?>
                    <span>
                        <div class="col-md-12">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="updatee[<?= $data->id; ?>][label][]" value="<?= $data->label; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <input class="form-control" id = "fileupload" type = "file" name="updatee[<?= $data->id; ?>][value][]"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="updatee[<?= $data->id; ?>][comment][]" value="<?= $data->comment; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <a id="remScnt" val="<?= $data->id; ?>" class="btn btn-icon btn-red remScnt" ><i class="fa-remove"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </span>
                    <br>
                    <?php
                }
            }
            ?>
            <br>
            <span>
                <div class="col-md-12">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Label</label>
                            <input type="text" class="form-control" name="create[label][]">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group ">
                            <label class="control-label" for="">File</label>
                            <input class="form-control" id = "fileupload" type = "file" name="create[valuee][]"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label" >Expiry Date</label>
                            <input type="text" class="form-control" name="create[comment][]">
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </span>
            <br/>
        </div>



        <div class="form-group field-portcalldatarob-fresh_water_arrival_quantity" id="add_new_upload">
            <a id="addScnt" class="btn btn-icon btn-blue addScnt" ><i class="fa-plus"></i></a>
        </div><br/>
    </div>
    <hr class="appoint_history" />

    <div class="row">
        <div class="col-md-12">
            <div class="form-group" style="float: left;">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top: 18px;margin-left: 20px;']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>/js/select2/select2.css">
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>/js/select2/select2-bootstrap.css">
<script src="<?= Yii::$app->homeUrl; ?>/js/select2/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $("#branchs").select2({
            placeholder: '--Select Branch--',
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        /*
         * Add more bnutton function
         */
        var scntDiv = $('#p_scents');
        var i = $('#p_scents span').size() + 1;
        $('#addScnt').on('click', function () {
            var ver = '<span>\n\
                                <div class="clearfix"></div><div class="col-md-12">\n\
                                <div class="col-md-3">\n\
                <div class="form-group">\n\
                    <label class="control-label">Label</label>\n\
                    <input type="text" class="form-control" name="create[label][]">\n\
                </div>\n\
            </div>\n\
            <div class="col-md-3">\n\
                <div class="form-group ">\n\
                    <label class="control-label" for="">File</label>\n\
                     <input class="form-control" id = "fileupload" type = "file" name="create[valuee][]"/>\n\
                </div>\n\
            </div>\n\
            <div class="col-md-3">\n\
                <div class="form-group">\n\
                    <label class="control-label" >Expiry Date</label>\n\
                    <input type="text" class="form-control" name="create[comment][]">\n\
                </div>\n\
            </div>\n\
            <div class="col-md-3">\n\
                                <div class="form-group">\n\
                                <a id="remScnt" class="btn btn-icon btn-red remScnt" ><i class="fa-remove"></i></a>\n\
                                 </div></div></div><br/>\n\
                                </span><br/>';
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
    });
</script>
