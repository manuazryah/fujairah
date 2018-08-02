<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(['id' => 'submit-new-vessel']);
?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add New Vessel</h4>
    </div>

    <div class="modal-body">

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($vessel_model, 'vessel_name')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-md-6">

                <?= $form->field($vessel_model, 'imo_no')->textInput(['maxlength' => true]) ?>

            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($vessel_model, 'official')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($vessel_model, 'mmsi_no')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($vessel_model, 'mobile')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($vessel_model, 'land_line')->textInput(['maxlength' => true]) ?>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($vessel_model, 'direct_line')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($vessel_model, 'fax')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

    </div>
    <input type="hidden" id="vessel-vessel_type" value="<?= $vessel_type ?>" name="Vessel[vessel_type]"/>
    <input type="hidden" id="type" value="<?= $type ?>" name="type"/>
    <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
        <?= Html::submitButton($vessel_model->isNewRecord ? 'Create' : 'Update', ['class' => $vessel_model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>