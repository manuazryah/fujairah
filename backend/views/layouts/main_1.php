<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="Xenon Boostrap Admin Panel" />
        <meta name="author" content="" />
        <title>Emperor Admin</title>
        <script src="<?= Yii::$app->homeUrl; ?>js/jquery-1.11.1.min.js"></script>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>
    </head>
    <body class="page-body">
        <?php $this->beginBody() ?>


        <div class="page-container">
            <div class="sidebar-menu toggle-others fixed">

                <div class="sidebar-menu-inner">
                    <header class="logo-env">
                        <!-- logo -->
                        <div class="logo">
                            <a href="" class="logo-expanded">
                                <img src="<?= Yii::$app->homeUrl; ?>images/logoo.png" width="82" alt="" />
                            </a>

                            <a href="" class="logo-collapsed">
                                <img src="<?= Yii::$app->homeUrl; ?>images/logoemp.png" width="40" alt="" />
                            </a>
                        </div>
                        <!-- This will toggle the mobile menu and will be visible only on mobile devices -->
                        <div class="mobile-menu-toggle visible-xs">
                            <a href="#" data-toggle="user-info-menu">
                                <i class="fa-bell-o"></i>
                                <span class="badge badge-success">7</span>
                            </a>

                            <a href="#" data-toggle="mobile-menu">
                                <i class="fa-bars"></i>
                            </a>
                        </div>
                        <!-- This will open the popup with user profile settings, you can use for any purpose, just be creative -->



                    </header>

                    <ul id="main-menu" class="main-menu">
                        <?php
                        if (Yii::$app->session['post']['admin'] == 1) {
                            ?>
                            <li>
                                <a href="">
                                    <i class="fa fa-cog"></i>
                                    <span class="title">Administration</span>
                                </a>
                                <ul>
                                    <li>
                                        <?= Html::a('Access Powers', ['/admin/admin-posts/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Employees', ['/admin/employee/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Branches', ['/admin/branch/index'], ['class' => 'title']) ?>
                                    </li>
                                </ul>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (Yii::$app->session['post']['appointments'] == 1) {
                            ?>
                            <li>
                                <a href="">
                                    <i class="fa fa-file"></i>
                                    <span class="title">Appointments</span>
                                </a>
                                <ul>
                                    <li>
                                        <?= Html::a('Appointmets', ['/appointment/appointment/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('File Uploads', ['/appointment/uploads/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Reports', ['/appointment/report/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Search', ['/appointment/appointment/search'], ['class' => 'title']) ?>
                                    </li>
                                    <!--                                                                <li>
                                    <?php // Html::a('Reports', ['/appointment/appointment/report'], ['class' => 'title']) ?>
                                                                                                    </li>-->
                                    <!--                               <li>
                                    <?php // Html::a('Test', ['/appointment/test/index'], ['class' => 'title']) ?>
                                                                 </li>
                                                                <li>
                                    <?php // Html::a('Estimated Proforma', ['/appointment/estimated-proforma/index'], ['class' => 'title']) ?>
                                                                 </li>
                                                                 <li>
                                    <?php // Html::a('Port Call Data', ['/appointment/port-call-data/index'], ['class' => 'title']) ?>
                                                                 </li>
                                                                 <li>
                                    <?php // Html::a('Close estimate', ['/appointment/close-estimate/index'], ['class' => 'title']) ?>
                                                                 </li>-->
                                </ul>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (Yii::$app->session['post']['funding_allocation'] == 1) {
                            ?>

                            <li>
                                <a href="">
                                    <i class="fa fa-credit-card"></i>
                                    <span class="title">Funding Allocation</span>
                                </a>
                                <ul>
                                    <li>
                                        <?= Html::a('Fund Allocation', ['/funding/funding-allocation/index'], ['class' => 'title']) ?>
                                    </li>

                                </ul>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (Yii::$app->session['post']['masters'] == 1) {
                            ?>

                            <li>
                                <a href="">
                                    <i class="fa fa-database"></i>
                                    <span class="title">Masters</span>
                                </a>
                                <ul>
                                    <li>
                                        <?= Html::a('Contacts', ['/masters/contacts/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Debtor', ['/masters/debtor/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Ports', ['/masters/ports/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Purpose', ['/masters/purpose/index'], ['class' => 'title']) ?>
                                    </li>

                                    <li>
                                        <?= Html::a('Invoice Type', ['/masters/invoice-type/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Services', ['/masters/services/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a(' Master Sub Services', ['/masters/master-sub-service/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Service Categories', ['/masters/service-categorys/index'], ['class' => 'title']) ?>
                                    </li>
                                    <!--                                                                        <li>
                                    <?php // Html::a('Stages', ['/masters/stages/index'], ['class' => 'title']) ?>
                                                                                                            </li>-->
                                    <!--                                                                        <li>
                                    <?php // Html::a('Stage Categories', ['/masters/stage-categorys/index'], ['class' => 'title']) ?>
                                                                                                            </li>-->
                                    <li>
                                        <?= Html::a('Vessel', ['/masters/vessel/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Vessel Types', ['/masters/vessel-type/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Terminals', ['/masters/terminal/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Units', ['/masters/units/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Currency', ['/masters/currency/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Uploads', ['/masters/uploads/index'], ['class' => 'title']) ?>
                                    </li>

                                </ul>
                            </li>
                            <?php
                        }
                        ?>
                        <li>
                            <a href="">
                                <i class="fa fa-print"></i>
                                <span class="title">Invoices</span>
                            </a>
                            <ul>
                                <li>
                                    <?= Html::a('Generate Invoice', ['/invoice/generate-invoice/index'], ['class' => 'title']) ?>
                                </li>

                                <li>
                                    <?= Html::a('Delivery Order', ['/invoice/delivery-order/index'], ['class' => 'title']) ?>
                                </li>

                            </ul>
                        </li>
                    </ul>

                </div>

            </div>

            <div class="main-content">

                <nav class="navbar user-info-navbar"  role="navigation"><!-- User Info, Notifications and Menu Bar -->

                    <!-- Left links for user info navbar -->
                    <ul class="user-info-menu left-links list-inline list-unstyled">

                        <li class="hidden-sm hidden-xs">
                            <a href="#" data-toggle="sidebar">
                                <i class="fa-bars"></i>
                            </a>
                        </li>
                        <?php
                        $notifications = \common\models\Notification::find()->where(['status' => 1])->orderBy(['id' => SORT_DESC])->limit(10)->all();
                        $notification_count = \common\models\Notification::find()->where(['status' => 1])->count();
                        ?>
                        <li class="dropdown hover-line">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa-bell-o"></i>
                                <span class="badge badge-purple" id="notify-count"><?= $notification_count ?></span>
                            </a>
                            <ul class="dropdown-menu notifications">
                                <li class="top">
                                    <p class="small">
                                        <!--                                        <a href="#" class="pull-right">Mark all Read</a>-->
                                        You have <strong id="notify-count"><?= $notification_count ?></strong> new notifications.
                                    </p>
                                </li>

                                <li>
                                    <ul class="dropdown-menu-list list-unstyled ps-scrollbar ps-container">
                                        <?php
                                        foreach ($notifications as $value) {
                                            ?>
                                            <li class="active notification-success" id="notify-<?= $value->id ?>">
                                                <a href="#">
                                                    <i class="fa fa-envelope-o"></i>

                                                    <span class="line">
                                                        <strong>New user registered</strong>
                                                    </span>

                                                    <span class="line small time">
                                                        30 seconds ago
                                                    </span>
                                                    <input type="checkbox" checked="" class="iswitch iswitch-secondary disable-notification" data-id= "<?= $value->id ?>" style="margin-top: -25px;float: right;">
                                                </a>
                                            </li>
                                            <?php
                                        }
                                        ?>

                                        <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 2px;"><div class="ps-scrollbar-y" style="top: 0px; height: 0px;"></div></div></ul>
                                </li>

                                <li class="external">
                                    <?= Html::a('<span>View all notifications</span> <i class="fa-link-ext"></i>', ['/appointment/notification']) ?>
                                </li>
                            </ul>
                        </li>
                        <!-- Added in v1.2 -->
                    </ul>
                    <!-- Right links for user info navbar -->
                    <ul class="user-info-menu right-links list-inline list-unstyled">

                        <li>
                            <a href="<?= Yii::$app->homeUrl; ?>site/home"><i class="fa-home"></i> Home</a>
                        </li>

                        <li class="dropdown user-profile">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?php
                                $filename = Yii::$app->basePath . '/../uploads/' . Yii::$app->user->identity->photo;
                                if (file_exists($filename)) {
                                    ?>
                                    <img src="<?= Yii::$app->homeUrl; ?>uploads/<?= Yii::$app->user->identity->photo ?>" alt="user-image" class="img-circle img-inline userpic-32" width="28" />
                                    <?php
                                } else {
                                    ?>
                                    <img src="<?= Yii::$app->homeUrl; ?>images/user-5.jpg" alt="user-image" class="img-circle img-inline userpic-32" width="28" />
                                <?php }
                                ?>
                                <span>
                                    <?= Yii::$app->user->identity->name ?>
                                    <i class="fa-angle-down"></i>
                                </span>
                            </a>

                            <ul class="dropdown-menu user-profile-menu list-unstyled">

                                <li>
                                    <?= Html::a('<i class="fa-wrench"></i>Change Password', ['/admin/employee/change-password'], ['class' => 'title']) ?>
                                </li>
                                <li>
                                    <?= Html::a('<i class = "fa-pencil"></i>Edit Profile ', ['/admin/employee/update', 'id' => Yii::$app->user->identity->id], ['class' => 'title']) ?>
                                </li>

                                <?php
                                echo '<li class = "last">'
                                . Html::beginForm(['/site/logout'], 'post') . '<a>'
                                . Html::submitButton(
                                        '<i class = "fa-lock"></i> Logout', ['class' => 'btn logout_btn', 'style' => 'background: white;font-size: 18px;margin-bottom: 0px;border: 1px solid #d0d0d0;']
                                ) . '</a>'
                                . Html::endForm()
                                . '</li>';
                                ?>
                            </ul>
                        </li>

                    </ul>

                </nav>
                <div class="row">


                    <?= $content; ?>


                </div>
                <footer class="main-footer sticky footer-type-1">

                    <div class="footer-inner">

                        <!-- Add your copyright text here -->
                        <div class="footer-text">
                            &copy; <?= Html::encode(date('Y')) ?>
                            <strong>Azryah</strong>
                            All rights reserved.
                        </div>


                        <!-- Go to Top Link, just add rel="go-top" to any link to add this functionality -->
                        <div class="go-up">

                            <a href="#" rel="go-top">
                                <i class="fa-angle-up"></i>
                            </a>

                        </div>

                    </div>

                </footer>
            </div>




        </div>

        <div class="footer-sticked-chat"><!-- Start: Footer Sticked Chat -->

            <script type="text/javascript">
                function toggleSampleChatWindow()
                {
                    var $chat_win = jQuery("#sample-chat-window");

                    $chat_win.toggleClass('open');

                    if ($chat_win.hasClass('open'))
                    {
                        var $messages = $chat_win.find('.ps-scrollbar');

                        if ($.isFunction($.fn.perfectScrollbar))
                        {
                            $messages.perfectScrollbar('destroy');

                            setTimeout(function () {
                                $messages.perfectScrollbar();
                                $chat_win.find('.form-control').focus();
                            }, 300);
                        }
                    }

                    jQuery("#sample-chat-window form").on('submit', function (ev)
                    {
                        ev.preventDefault();
                    });
                }

                jQuery(document).ready(function ($)
                {
                    $(".footer-sticked-chat .chat-user, .other-conversations-list a").on('click', function (ev)
                    {
                        ev.preventDefault();
                        toggleSampleChatWindow();
                    });

                    $(".mobile-chat-toggle").on('click', function (ev)
                    {
                        ev.preventDefault();

                        $(".footer-sticked-chat").toggleClass('mobile-is-visible');
                    });

                    $('.disable-notification').on('change', function (e) {
                        var idd = $(this).attr('data-id');
                        var count = $('#notify-count').text();
                        $.ajax({
                            type: 'POST',
                            cache: false,
                            async: false,
                            data: {id: idd},
                            url: '<?= Yii::$app->homeUrl; ?>site/update-notification',
                            success: function (data) {
                                $('#notify-' + idd).remove();
                                $('#notify-count').text(count - 1);
                                e.preventDefault();
                            }
                        });
                    });
                });
            </script>



            <a href="#" class="mobile-chat-toggle">
                <i class="linecons-comment"></i>
                <span class="num">6</span>
                <span class="badge badge-purple">4</span>
            </a>

            <!-- End: Footer Sticked Chat -->
        </div>






        <!-- Imported styles on this page -->
        <link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>css/fonts/meteocons/css/meteocons.css">

        <!-- Bottom Scripts -->



        <!-- JavaScripts initializations and stuff -->
        <script src="<?= Yii::$app->homeUrl; ?>js/xenon-custom.js"></script>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>