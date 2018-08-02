<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(['id' => 'submit-new-principal']);
?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add New Principal</h4>
    </div>

    <div class="modal-body">

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($debtor_model, 'principal_name')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-md-6">

                <?= $form->field($debtor_model, 'principal_id')->textInput(['maxlength' => true]) ?>

            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($debtor_model, 'principal_ref_no')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($debtor_model, 'mobile')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($debtor_model, 'address')->textarea(['rows' => 4]) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($debtor_model, 'invoicing_address')->textarea(['rows' => 4]) ?>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($debtor_model, 'epda_address')->textarea(['rows' => 4]) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($debtor_model, 'da_dispatch_addresss_1')->textarea(['rows' => 4]) ?>
            </div>
        </div>

    </div>
<!--    <input type="hidden" id="vessel-vessel_type" value="<?php // $vessel_type ?>" name="Vessel[vessel_type]"/>
    <input type="hidden" id="type" value="<?php // $type ?>" name="type"/>-->
    <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
        <?= Html::submitButton($debtor_model->isNewRecord ? 'Create' : 'Update', ['class' => $debtor_model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>