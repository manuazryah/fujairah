<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAssetLogin;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAssetLogin::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="DXB Admin Panel" />
        <meta name="author" content="" />
        <title><?= Html::encode($this->title) ?></title>


        <script src="<?= Yii::$app->homeUrl; ?>js/jquery-1.11.1.min.js"></script>
        <?php $this->head() ?>
    </head>
    <style>
        .blackoverlay {    position: absolute;    top: 0;    left: 0;    width: 100%;    height: 100%;    background-color: rgba(0, 0, 0, 0.40);
        }
    </style>
    <body class="page-body login-page"style="background-image: url(<?= Yii::$app->homeUrl; ?>images/emperor-bg.jpg);background-size: cover;background-repeat: no-repeat;overflow: hidden;">
        <div class="blackoverlay"></div>
        <?php $this->beginBody() ?>

        <?php echo $content; ?>

        <?php $this->endBody() ?>

    </body>
</html>
<?php $this->endPage() ?>
