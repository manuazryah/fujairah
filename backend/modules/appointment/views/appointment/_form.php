<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\VesselType;
use common\models\Vessel;
use common\models\Ports;
use common\models\Terminal;
use common\models\Debtor;
use common\models\Contacts;
use common\models\Purpose;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model common\models\Appointment */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .new-width{
        width: 17% !important;
    }
    .form-group-new{
        padding-left: 29px;
        width: 83%;
    }
    .form-group-new label{
        color:black;
        font-weight: bold;
    }
    span a{
        font-size: 16px;
        color: #1630bf;
    }
</style>

<div class="">
    <div class="modal fade" id="modal-6">
        <div class="modal-dialog" id="modal-pop-up">

        </div>
    </div>
    <?php $form = ActiveForm::begin(); ?>
    <?php // $form->errorSummary($model)  ?>
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'vessel_type')->dropDownList(ArrayHelper::map(VesselType::findAll(['status' => 1]), 'id', 'vessel_type'), ['prompt' => '-Choose a Vessel Type-', 'class' => 'form-control vessels']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'vessel')->dropDownList(ArrayHelper::map(Vessel::findAll(['status' => 1, 'vessel_type' => $model->vessel_type]), 'id', 'vessel_name'), ['prompt' => '-Choose a Vessel-', 'disabled' => $model->vessel_type == 1 ? TRUE : FALSE]) ?>
                <a href="" id="vessel-link" class="new-link-box" type="1"><i class="fa fa-plus" aria-hidden="true"></i> New</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'tug')->dropDownList(ArrayHelper::map(Vessel::findAll(['status' => 1, 'vessel_type' => 4]), 'id', 'vessel_name'), ['prompt' => '-Choose a Tug-', 'disabled' => $model->vessel_type != 1 ? TRUE : FALSE]) ?>
                <a href="" id="tug-link" class="new-link-box" type="2"><i class="fa fa-plus" aria-hidden="true"></i> New</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'barge')->dropDownList(ArrayHelper::map(Vessel::findAll(['status' => 1, 'vessel_type' => 6]), 'id', 'vessel_name'), ['prompt' => '-Choose a Barge-', 'disabled' => $model->vessel_type != 1 ? TRUE : FALSE]) ?>
                <a href="" id="barge-link" class="new-link-box" type="3"><i class="fa fa-plus" aria-hidden="true"></i> New</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'port_of_call')->dropDownList(ArrayHelper::map(Ports::findAll(['status' => 1]), 'id', 'port_name'), ['prompt' => '-Choose a Port-', 'class' => 'form-control ports', 'disabled' => $model->isNewRecord ? FALSE : TRUE]) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'terminal')->dropDownList(ArrayHelper::map(Terminal::findAll(['status' => 1]), 'id', 'terminal'), ['prompt' => '-Choose a Terminal-']) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'birth_no')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'appointment_no')->textInput(['maxlength' => true, 'readonly' => true]) ?>
            </div>
        </div>
        <div class="col-md-4">
            <?php
            if ($model->isNewRecord) {
                $model->no_of_principal = 1;
            }
            ?>
            <?php $arr = array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'); ?>
            <div class="col-md-12">
                <?= $form->field($model, 'no_of_principal')->dropDownList($arr, ['prompt' => '-choose no of principal-']) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="col-md-12">
                <?=
                $form->field($model, 'principal', ['template' => "<div class='overly'></div>\n{label}\n{input}\n{hint}\n{error}"]
                )->dropDownList(ArrayHelper::map(Debtor::findAll(['status' => 1]), 'id', 'principal_name'), ['options' => Yii::$app->SetValues->Selected($model->principal), 'prompt' => '-Choose a Principal-', 'multiple' => true])
                ?>
                <a href="" id="principals-link" class="new-principals-link" type="3"><i class="fa fa-plus" aria-hidden="true"></i> New</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'nominator')->dropDownList(ArrayHelper::map(Contacts::find()->where(new Expression('FIND_IN_SET(:contact_type, contact_type)'))->addParams([':contact_type' => 1])->all(), 'id', 'name'), ['prompt' => '-Choose a Nominator-']) ?>
                <a href="" id="nominator-link" class="new-contact-link" type="1"><i class="fa fa-plus" aria-hidden="true"></i> New</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'charterer')->dropDownList(ArrayHelper::map(Contacts::find()->where(new Expression('FIND_IN_SET(:contact_type, contact_type)'))->addParams([':contact_type' => 2])->all(), 'id', 'name'), ['prompt' => '-Choose a Charterer-']) ?>
                <a href="" id="charterer-link" class="new-contact-link" type="2"><i class="fa fa-plus" aria-hidden="true"></i> New</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'shipper')->dropDownList(ArrayHelper::map(Contacts::find()->where(new Expression('FIND_IN_SET(:contact_type, contact_type)'))->addParams([':contact_type' => 3])->all(), 'id', 'name'), ['prompt' => '-Choose a Shipper-']) ?>
                <a href="" id="shipper-link" class="new-contact-link" type="3"><i class="fa fa-plus" aria-hidden="true"></i> New</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'purpose')->dropDownList(ArrayHelper::map(Purpose::findAll(['status' => 1]), 'id', 'purpose'), ['prompt' => '-Choose a Purpose-']) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'cargo')->textInput(['maxlength' => true, 'disabled' => $model->isNewRecord ? FALSE : $model->status == 0 ? TRUE : FALSE]) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'quantity')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'last_port')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'next_port')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'eta')->textInput(['maxlength' => true])->label('ETA ( ddmmyyyy hh:mm / yyyy-mm-dd hh:mm )') ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'client_reference')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 padd-left">
            <?php
            if ($model->isNewRecord) {
                if ($model->epda_content == '') {
                    $content = '- Additional scope of work other than mentioned in the tarrif to be mutually agreed between two parties prior initiation of service.';
                    ?>
                    <?=
                    $form->field($model, 'epda_content', ['options' => []])->textArea([
                        'rows' => '6', 'value' => $content
                    ])
                    ?>
                    <?php
                }
            } else {
                ?>
                <?=
                $form->field($model, 'epda_content', ['options' => []])->textArea([
                    'rows' => '6', 'value' => $model->epda_content
                ])->label(FALSE)
                ?>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 padd-left">
            <?php
            if ($model->isNewRecord) {
                echo $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']);
            } else {
                if (Yii::$app->session['post']['id'] == 1) {
                    echo $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']);
                }
            }
            ?>
            <?php // $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']) ?>
        </div>
        <div class="col-md-4 padd-left">
            <?= $form->field($model, 'currency')->dropDownList(ArrayHelper::map(common\models\Currency::findAll(['status' => 1]), 'id', 'currency_name'), ['class' => 'form-control']) ?>
        </div>
        <div class="col-md-4 padd-left">
            <?= $form->field($model, 'final_draft_bl', ['options' => ['class' => 'form-group'], 'template' => '{label}<label></label>{input}{error}'])->fileInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group" style="margin-left: 12px;margin-top: 20px;">
                <input type="checkbox" id="queue-order" name="check" value="1" checked="checked" uncheckValue="0"><label>Load Previous Proforma</label>
            </div>
        </div>
    </div>
    <?php
//    if ($model->status != 0) {
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top: 18px;margin-left: 20px;']) ?>
            </div>
        </div>
    </div>
    <?php
//    }
    ?>
    <?php ActiveForm::end(); ?>

</div>
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2.css">
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2-bootstrap.css">
<script src="<?= Yii::$app->homeUrl; ?>js/select2/select2.min.js"></script>
<script>
    $("document").ready(function () {
        $('.ports').change(function () {
            var port_id = $(this).val();
            $.ajax({
                type: 'POST',
                cache: false,
                data: {port_id: port_id},
                url: '<?= Yii::$app->homeUrl; ?>appointment/appointment/appointment-no',
                success: function (data) {
                    $('#appointment-appointment_no').val(data);
                }
            });
        });
    });</script>
<script>
    $("document").ready(function () {
        $('#appointment-vessel_type').change(function () {
            var vessel_type = $(this).val();
            if (vessel_type == 1) {
                $("#appointment-vessel").prop('disabled', true);
                $("#appointment-tug").prop('disabled', false);
                $("#appointment-barge").prop('disabled', false);
                $('#tug-link').css('display', 'block');
                $('#barge-link').css('display', 'block');
                $('#vessel-link').css('display', 'none');
            } else {
                $.ajax({
                    type: 'POST',
                    cache: false,
                    data: {vessel_type: vessel_type},
                    url: '<?= Yii::$app->homeUrl; ?>appointment/appointment/vessel-type',
                    success: function (data) {
                        if (data != 'Tug &Barge') {

                            $("#appointment-tug").prop('disabled', true);
                            $("#appointment-barge").prop('disabled', true);
                            $("#appointment-vessel").prop('disabled', false);
                            $('#tug-link').css('display', 'none');
                            $('#barge-link').css('display', 'none');
                            $('#vessel-link').css('display', 'block');
                            var index = $('#appointment-tug').get(0).selectedIndex;
                            $('#appointment-tug option:eq(' + index + ')').prop("selected", false);
                            var indexs = $('#appointment-barge').get(0).selectedIndex;
                            $('#appointment-barge option:eq(' + indexs + ')').prop("selected", false);
                            $('#appointment-vessel').html(data);
                        }

                    }
                });
            }
        });
    });</script>
<script>
    $("document").ready(function () {

        $('#appointment-principal').change(function (e) {

            var principal = $(this).val();
            var No_principal = $('#appointment-no_of_principal').val();
            if (principal.length == No_principal) {
                //alert("Principal same as Number of principal");
                $('#s2id_autogen4').prop('disabled', true);
                $('.overly').addClass('over-active');
            } else if (principal.length < No_principal) {
                $('#s2id_autogen4').prop('disabled', false);
                $('.overly').removeClass('over-active');
            } else if (principal.length > No_principal) {
                var last = principal[principal.length - 1];
                $("#appointment-principal option[value='" + last + "']").prop("selected", false);
                alert("Choose Principal same as Number of principal");
                $('#s2id_autogen4').prop('disabled', true);
                $('.overly').addClass('over-active');
            }

        });
        $('#appointment-no_of_principal').change(function (e) {
            var principal = $('#appointment-no_of_principal').val();
            var No_principal = $(this).val();
            if (principal.length == No_principal) {
                $('#s2id_autogen4').prop('disabled', true);
                $('.overly').addClass('over-active');
            } else if (principal.length < No_principal) {
                $('#s2id_autogen4').prop('disabled', false);
                $('.overly').removeClass('over-active');
            } else if (principal.length > No_principal) {
                $('#s2id_autogen4').prop('disabled', true);
                $('.overly').addClass('over-active');
            }
        });
    });</script>
<script type="text/javascript">
    jQuery(document).ready(function ($)
    {
        $("#appointment-nominator").select2({
            //placeholder: 'Select your country...',
            allowClear: true
        }).on('select2-open', function ()
        {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#appointment-charterer").select2({
            //placeholder: 'Select your country...',
            allowClear: true
        }).on('select2-open', function ()
        {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#appointment-shipper").select2({
            //placeholder: 'Select your country...',
            allowClear: true
        }).on('select2-open', function ()
        {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });

        $("#appointment-principal").select2({
            placeholder: 'Choose Principals',
            allowClear: true
        }).on('select2-open', function ()
        {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
    });
</script>
<style>
    .over-active {
        background-color: rgba(23, 20, 20, 0.11);
        width: 100%;
        height: 100%;
        position: absolute;
        z-index: 100;
    }
    .txtarea{
        width:81% !important;
        margin-left: 28px;
        height: 150px;
    }
    .appoint_history{
        border-top: 2px solid #eee !important;
    }

</style>


<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2.css">
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2-bootstrap.css">
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/multiselect/css/multi-select.css">
<script src="<?= Yii::$app->homeUrl; ?>js/select2/select2.min.js"></script>
<script src="<?= Yii::$app->homeUrl; ?>js/multiselect/js/jquery.multi-select.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function ($)
    {
        $("#appointment-vessel").select2({
            //placeholder: 'Select your country...',
            allowClear: true
        }).on('select2-open', function ()
        {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#appointment-tug").select2({
            //placeholder: 'Select your country...',
            allowClear: true
        }).on('select2-open', function ()
        {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#appointment-barge").select2({
            //placeholder: 'Select your country...',
            allowClear: true
        }).on('select2-open', function ()
        {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#appointment-vessel_type").select2({
            placeholder: 'Vesel Type',
            allowClear: true
        }).on('select2-open', function ()
        {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });

    });
</script>


<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2.css">
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2-bootstrap.css">
<script src="<?= Yii::$app->homeUrl; ?>js/select2/select2.min.js"></script>
<script>
    $(document).ready(function () {

        /*
         * on click of the Add new Vessel link
         * return pop up form for add new vessel details
         */

        $(document).on('click', '.new-link-box', function (e) {
            var vessel_type = $('#appointment-vessel_type').val();
            var type = $(this).attr('type');
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {vessel_type: vessel_type, type: type},
                url: '<?= Yii::$app->homeUrl; ?>appointment/appointment/add-new-vessel',
                success: function (data) {
                    $("#modal-pop-up").html(data);
                    $('#modal-6').modal('show', {backdrop: 'static'});
                    e.preventDefault();
                }
            });
        });
        /*
         * on click of the Add new Contact link
         * return pop up form for add new Contact details
         */

        $(document).on('click', '.new-contact-link', function (e) {
            var type = $(this).attr('type');
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {type: type},
                url: '<?= Yii::$app->homeUrl; ?>appointment/appointment/add-new-contacts',
                success: function (data) {
                    $("#modal-pop-up").html(data);
                    $('#modal-6').modal('show', {backdrop: 'static'});
                    e.preventDefault();
                }
            });
        });
        /*
         * on click of the Add new Principals link
         * return pop up form for add new Principals details
         */

        $(document).on('click', '.new-principals-link', function (e) {
        
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {},
                url: '<?= Yii::$app->homeUrl; ?>appointment/appointment/add-new-principals',
                success: function (data) {
                    $("#modal-pop-up").html(data);
                    $('#modal-6').modal('show', {backdrop: 'static'});
                    e.preventDefault();
                }
            });
        });
        /*
         * on submit of the form add new vessel
         * return new vessel added into vessel/tug/barge field
         */

        $(document).on('submit', '#submit-new-vessel', function (e) {

            if (validateVessel() == 0) {
                var str = $(this).serialize();
                var vessel_name = $("#vessel-vessel_name").val();
                var imo_no = $("#vessel-imo_no").val();
                var official = $("#vessel-official").val();
                var type = $("#type").val();
                $.ajax({
                    type: 'POST',
                    cache: false,
                    data: {vessel_name: vessel_name, imo_no: imo_no, official: official},
                    url: '<?= Yii::$app->homeUrl; ?>appointment/appointment/unique-vessel',
                    success: function (data) {
                        if (data == 0) {
                            $.ajax({
                                url: '<?= Yii::$app->homeUrl; ?>appointment/appointment/update-vessel',
                                type: "POST",
                                data: str,
                                success: function (data) {
                                    var res = $.parseJSON(data);
                                    $('#modal-6').modal('hide');
                                    if (type == 1) {
                                        var data_id = "#appointment-vessel";
                                    } else if (type == 2) {
                                        var data_id = "#appointment-tug";
                                    } else if (type == 3) {
                                        var data_id = "#appointment-barge";
                                    }
                                    $(data_id).append('<option value="' + res.result['id'] + '" selected>' + res.result['name'] + '</option>');
                                    $(data_id).select2().select2('val', res.result['id']);
                                }
                            });
                        } else {

                            if (data == 1) {
                                var var_id = "#vessel-vessel_name";
                            } else if (data == 2) {
                                var var_id = "#vessel-imo_no";
                            } else if (data == 3) {
                                var var_id = "#vessel-official";
                            }
                            if ($(var_id).parent().next(".validation").length == 0) // only add if not added
                            {
                                $(var_id).parent().after("<div class='validation' style='color:red;margin-bottom: 20px;position: absolute;top: 68px;font-size: 12px;'>This Value has already been taken.</div>");
                            }
                            $(var_id).focus();
                        }
                    }

                });
                return false;
            } else {
                e.preventDefault();
            }
        }
        );
        /*
         * on submit of the form add new vessel
         * return new vessel added into vessel/tug/barge field
         */

        $(document).on('submit', '#submit-new-contacts', function (e) {
            if (validateContacts() == 0) {
                var str = $(this).serialize();
                var type = $("#type").val();
                $.ajax({
                    url: '<?= Yii::$app->homeUrl; ?>appointment/appointment/update-contacts',
                    type: "POST",
                    data: str,
                    success: function (data) {
                        var res = $.parseJSON(data);
                        $('#modal-6').modal('hide');
                        if (type == 1) {
                            var data_id = "#appointment-nominator";
                        } else if (type == 2) {
                            var data_id = "#appointment-charterer";
                        } else if (type == 3) {
                            var data_id = "#appointment-shipper";
                        }
                        $(data_id).append('<option value="' + res.result['id'] + '" selected>' + res.result['name'] + '</option>');
                        $(data_id).select2().select2('val', res.result['id']);
                    }
                });
                return false;
            } else {
                e.preventDefault();
            }
        });
        /*
         * on submit of the form add new Principals
         * return new principal added into Debtor
         */

        $(document).on('submit', '#submit-new-principal', function (e) {
            if (validatePrincipals() == 0) {
                var str = $(this).serialize();
                var type = $("#type").val();
                $.ajax({
                    url: '<?= Yii::$app->homeUrl; ?>appointment/appointment/update-principals',
                    type: "POST",
                    data: str,
                    success: function (data) {
                        var res = $.parseJSON(data);
                        $('#modal-6').modal('hide');

                        $('#appointment-principal').append('<option value="' + res.result['id'] + '" selected>' + res.result['name'] + '</option>');
                        $("#appointment-principal").select2("val", $("#appointment-principal").select2("val").concat(res.result['id']));
                        $("#appointment-principal").trigger("change");
                    }
                });
                return false;
            } else {
                e.preventDefault();
            }
        });
    });
    function validateVessel() {

        if (!$('#vessel-vessel_name').val()) {
            if ($("#vessel-vessel_name").parent().next(".validation").length == 0) // only add if not added
            {
                $("#vessel-vessel_name").parent().after("<div class='validation' style='color:red;margin-bottom: 20px;position: absolute;top: 68px;'>Vessel Name cannot be blank.</div>");
            }
            $('#vessel-vessel_name').focus();
            var valid = 1;
        } else {
            $("#vessel-vessel_name").parent().next(".validation").remove(); // remove it
            var valid = 0;
        }
        if (!$('#vessel-imo_no').val()) {
            if ($("#vessel-imo_no").parent().next(".validation").length == 0) // only add if not added
            {
                $("#vessel-imo_no").parent().after("<div class='validation' style='color:red;margin-bottom: 20px;position: absolute;top: 68px;'>Imo No cannot be blank.</div>");
            }
            $('#vessel-imo_no').focus();
            var valid = 1;
        } else {
            $("#vessel-imo_no").parent().next(".validation").remove(); // remove it
            var valid = 0;
        }
        if (!$('#vessel-official').val()) {
            if ($("#vessel-official").parent().next(".validation").length == 0) // only add if not added
            {
                $("#vessel-official").parent().after("<div class='validation' style='color:red;margin-bottom: 20px;position: absolute;top: 68px;'>Official cannot be blank.</div>");
            }
            $('#vessel-official').focus();
            var valid = 1;
        } else {
            $("#vessel-official").parent().next(".validation").remove(); // remove it
            var valid = 0;
        }
        return valid;
    }
    function validateContacts() {

        if (!$('#contacts-name').val()) {
            if ($("#contacts-name").parent().next(".validation").length == 0) // only add if not added
            {
                $("#contacts-name").parent().after("<div class='validation' style='color:red;margin-bottom: 20px;position: absolute;top: 68px;'>Name cannot be blank.</div>");
            }
            $('#contacts-name').focus();
            var valid = 1;
        } else {
            $("#contacts-name").parent().next(".validation").remove(); // remove it
            var valid = 0;
        }
        if (!$('#contacts-person').val()) {
            if ($("#contacts-person").parent().next(".validation").length == 0) // only add if not added
            {
                $("#contacts-person").parent().after("<div class='validation' style='color:red;margin-bottom: 20px;position: absolute;top: 68px;'>Person cannot be blank.</div>");
            }
            $('#contacts-person').focus();
            var valid = 1;
        } else {
            $("#contacts-person").parent().next(".validation").remove(); // remove it
            var valid = 0;
        }
        if (!$('#contacts-phone_1').val()) {
            if ($("#contacts-phone_1").parent().next(".validation").length == 0) // only add if not added
            {
                $("#contacts-phone_1").parent().after("<div class='validation' style='color:red;margin-bottom: 20px;position: absolute;top: 68px;'>Phone Primary cannot be blank.</div>");
            }
            $('#contacts-phone_1').focus();
            var valid = 1;
        } else {
            $("#contacts-phone_1").parent().next(".validation").remove(); // remove it
            var valid = 0;
        }
        if (!$('#contacts-email').val()) {
            if ($("#contacts-email").parent().next(".validation").length == 0) // only add if not added
            {
                $("#contacts-email").parent().after("<div class='validation' style='color:red;margin-bottom: 20px;position: absolute;top: 68px;'>Email cannot be blank.</div>");
            }
            $('#contacts-email').focus();
            var valid = 1;
        } else {
            $("#contacts-email").parent().next(".validation").remove(); // remove it
            var valid = 0;
        }
        return valid;
    }
    function validatePrincipals() {

        if (!$('#debtor-principal_name').val()) {
            if ($("#debtor-principal_name").parent().next(".validation").length == 0) // only add if not added
            {
                $("#debtor-principal_name").parent().after("<div class='validation' style='color:red;margin-bottom: 20px;position: absolute;top: 68px;'>Principal Name cannot be blank.</div>");
            }
            $('#debtor-principal_name').focus();
            var valid = 1;
        } else {
            $("#debtor-principal_name").parent().next(".validation").remove(); // remove it
            var valid = 0;
        }
        if (!$('#debtor-mobile').val()) {
            if ($("#debtor-mobile").parent().next(".validation").length == 0) // only add if not added
            {
                $("#debtor-mobile").parent().after("<div class='validation' style='color:red;margin-bottom: 20px;position: absolute;top: 68px;'>Mobile cannot be blank.</div>");
            }
            $('#debtor-mobile').focus();
            var valid = 1;
        } else {
            $("#debtor-mobile").parent().next(".validation").remove(); // remove it
            var valid = 0;
        }
        if (!$('#debtor-address').val()) {
            if ($("#debtor-address").parent().next(".validation").length == 0) // only add if not added
            {
                $("#debtor-address").parent().after("<div class='validation' style='color:red;margin-bottom: 20px;position: absolute;top: 135px;'>Address cannot be blank.</div>");
            }
            $('#debtor-address').focus();
            var valid = 1;
        } else {
            $("#debtor-address").parent().next(".validation").remove(); // remove it
            var valid = 0;
        }
        return valid;
    }
</script>

