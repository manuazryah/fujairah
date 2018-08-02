<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
?>
<style>
    .login-page .login-form .form-group .btn.btn-dark {
        border-color: #d2cdcd;
        background-color: rgba(55,57,58,.3);
        color: #fff;
    }
    form .form-group .form-control {
        color: #d61414;
        font-size: 15px;
        background: rgba(55,57,58,.3);
    }
    .login-page .login-form .form-group .control-label {
        color: white;
    }
    .login-page .login-form .login-header p {
        color: white;
    }
    .login-page .login-form .login-footer a {
        color: white;
    }
    form .form-group .form-control {
        color: white;
    }
    .login-page .login-form .form-group .form-control:-webkit-autofill {
        -webkit-box-shadow: 0 0 0 1000px #5a5c64 inset;
        -webkit-text-fill-color: white;
        border: 1px solid #e4e4e4;
    }
    form .form-group.has-error .help-block, form .form-group.has-error .control-label, form .form-group.has-error .radio, form .form-group.has-error .checkbox, form .form-group.has-error .radio-inline, form .form-group.has-error .checkbox-inline {
        color: #fd2c24;
        font-size: 14px;
    }
    .form-control:focus {
        /*border-color: rgba(139, 150, 130, 0.5);*/
        border-color: #d2cdcd;
    }
    .login-page .login-form .login-footer a:hover {
        color: #f8fbfb;
    }
    .login-page {
        padding-top: 88px;
    }
</style>
<div class="login-container">

    <div class="row">

        <div class="col-sm-6" style="background-color: rgba(44, 36, 28, 0.4);">

            <script type="text/javascript">
                jQuery(document).ready(function ($)
                {
                    setTimeout(function () {
                        $(".fade-in-effect").addClass('in');
                    }, 1);

                });
            </script>
            <!-- Errors container -->
            <div class="errors-container">
            </div>

            <!-- Add class "fade-in-effect" for login form effect -->

            <?php
            $form = ActiveForm::begin(
                            [
                                'id' => 'login',
                                'method' => 'post',
                                'options' => [
                                    'class' => 'login-form fade-in-effect'
                                ]
                            ]
            );
            ?>

            <div class="login-header">
                <a href="" class="logo">
                    <?php echo Html::img('@web/images/logoo.png') ?>
                        <!--<span>Emperor Admin log in</span>-->
                </a>

                <p>Dear user, Please log in to access!</p>
                <?php
                if (yii::$app->session['change-pwd-success-msg'] != '') {
                    echo '<p style="color:#4caf50;">' . yii::$app->session['change-pwd-success-msg'] . '</p>';
                    unset(Yii::$app->session['change-pwd-success-msg']);
                }
                if (yii::$app->session['change-pwd-error-msg'] != '') {
                    echo '<p style="color:#fd2c24;">' . yii::$app->session['change-pwd-error-msg'] . '</p>';
                    unset(Yii::$app->session['change-pwd-error-msg']);
                }
                ?>
            </div>


            <div class="form-group">
                <?= $form->field($model, 'user_name')->textInput(['class' => 'form-control', 'autofocus' => 'true']) ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control']) ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton('<i class="fa-lock"></i>Log In', ['class' => 'btn btn-dark  btn-block text-left'])
                ?>

            </div>

            <div class="login-footer">
                <a href="<?= Yii::$app->homeUrl; ?>site/forgot">Forgot your password?</a>

            </div>

            <?php ActiveForm::end(); ?>


        </div>

    </div>

</div>
