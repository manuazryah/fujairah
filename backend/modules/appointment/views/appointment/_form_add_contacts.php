<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(['id' => 'submit-new-contacts']);
?>
<?= $form->errorSummary($contact_model); ?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD CONTACTS</h4>
    </div>

    <div class="modal-body">

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($contact_model, 'name')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-md-6">

                <?= $form->field($contact_model, 'person')->textInput(['maxlength' => true]) ?>

            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($contact_model, 'phone_1')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($contact_model, 'email')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?= $form->field($contact_model, 'address')->textarea(['rows' => 4]) ?>
            </div>

        </div>

    </div>
    <input type="hidden" id="contacts-contact_type" value="<?= $contact_type ?>" name="Contacts[contact_type]"/>
    <input type="hidden" id="type" value="<?= $type ?>" name="type"/>
    <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
        <?= Html::submitButton($contact_model->isNewRecord ? 'Create' : 'Update', ['class' => $contact_model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>