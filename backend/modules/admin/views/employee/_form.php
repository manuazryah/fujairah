<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Branch;
use common\models\AdminPosts;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;

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
        <!--        <div class="col-md-4">
        <?php // $branch = ArrayHelper::map(Branch::findAll(['status' => 1]), 'id', 'branch_name'); ?>
        <?php
//            if (!$model->isNewRecord && $model->branch_id != '') {
//                $model->branch_id = explode(',', $model->branch_id);
//            }
        ?>
                    <div class="col-md-12">
        <?php // $form->field($model, 'branch_id')->dropDownList($branch, ['prompt' => '-Choose a Branch-', 'id' => 'branchs', 'multiple' => 'multiple']) ?>
                    </div>
                </div>-->
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
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
        <?php } else {
            ?>
            <div class="col-md-4">
                <div class="col-md-12">
                    <?= $form->field($model, 'user_name')->textInput(['maxlength' => true, 'readonly' => TRUE]) ?>
                </div>
            </div>
        <?php }
        ?>
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
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="col-md-12">
                <?= $form->field($model, 'address')->textarea(['rows' => 4]) ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-12">
                <?= $form->field($model, 'photo')->fileInput() ?>
            </div>
        </div>
    </div>

    <hr class="appoint_history" />
    <div class="clearfix"></div>
    <div id = "p_attach">
        <input type = "hidden" id = "delete_port_vals" name = "delete_port_vals" value = "">
        <h4 style = "color:#000;font-style: italic;">Attachments</h4>
        <p style="margin-bottom: 15px;color: red;font-style: italic;">( Only pdf,txt,doc,docx,xls,xlsx,msg,zip,eml, jpg, jpeg, png files are allowed. )</p>
        <?php if (!empty($model_upload)) { ?>
            <table class="table table-hover">
                <tr>
                    <th>Attachment Name</th>
                    <th>Attachment</th>
                    <th>Expiry Date</th>
                    <th></th>
                </tr>
                <?php foreach ($model_upload as $val) { ?>
                    <tr>
                        <td><?= $val->label ?></td>
                        <td><a href="<?= Yii::$app->homeUrl ?>uploads/employee/<?= $val->id ?>/<?= $val->file ?>" target="_blank"><?= $val->file ?></a></td>
                        <td><?= $val->expiry_date ?></td>
                        <td><?= Html::a('<i class="fa fa-trash" style="color:red;"></i>', ['attachment-delete', 'id' => $val->id], ['onClick' => 'return confirm("Are you sure you want to remove?")']) ?></td>
                    </tr>
                <?php }
                ?>
            </table>
        <?php }
        ?>

        <span>
            <div class = 'col-md-4 col-sm-12 col-xs-12 left_padd'>
                <div class = "form-group field-staffperviousemployer-hospital_address">
                    <label class = "control-label">Attachment</label>
                    <input type = "file" name = "creates[file][]">

                </div>
            </div>
            <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
                <div class="form-group field-staffperviousemployer-designation">
                    <label class="control-label" for="">Attachment Name</label>
                    <input class="form-control" type = "text" name = "creates[file_name][]">
                </div>
            </div>
            <div class='col-md-3 col-sm-12 col-xs-12 left_padd'>
                <div class="form-group field-staffperviousemployer-designation">
                    <label class="control-label" for="">Expiry Date</label>
                    <input type="date" class="form-control" name="creates[expiry_date][]">
                </div>
            </div>


            <div style="clear:both"></div>
        </span>

    </div>


    <div class="row">
        <div class="col-md-12">
            <a id="addAttach" title="Add More Attachment" class="btn btn-blue btn-icon btn-icon-standalone addAttach" style="float:right;margin-right: 15px;"><i class="fa-plus"></i></a>
        </div>
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
<script>
    $("document").ready(function () {
        var scntDiv = $('#p_attach');
        var i = $('#p_attach span').size() + 1;

        $('#addAttach').on('click', function () {
            $.ajax({
                type: 'POST',
                cache: false,
                data: {},
                url: '<?= Yii::$app->homeUrl; ?>admin/employee/attachment',
                success: function (data) {
                    $(data).appendTo(scntDiv);
                    i++;
                    return false;

                }
            });


        });
        $('#p_attach').on('click', '.remAttach', function () {
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
