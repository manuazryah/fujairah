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
        <meta name="description" content="DXB Admin Panel" />
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
                                    <i class="fa fa-tachometer"></i>
                                    <span class="title">Administration</span>
                                </a>
                                <ul>
                                    <li>
                                        <?= Html::a('Access Powers', ['/admin/admin-posts/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Employees', ['/admin/employee/index'], ['class' => 'title']) ?>
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
                                        <a href="">
                                            <span class="title">Reports</span>
                                        </a>
                                        <ul>
                                            <li>
                                                <?= Html::a('Reports', ['/appointment/report/index'], ['class' => 'title']) ?>
                                            </li>
                                            <li>
                                                <?= Html::a('Service Report', ['/appointment/service-report/index'], ['class' => 'title']) ?>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <?= Html::a('Search', ['/appointment/appointment/search'], ['class' => 'title']) ?>
                                    </li>
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
                                        <a href="">
                                            <span class="title">Masters</span>
                                        </a>
                                        <ul>
                                            <li>
                                                <?= Html::a('Transaction Category', ['/funding/transaction-category/index'], ['class' => 'title']) ?>
                                            </li>
                                            <li>
                                                <?= Html::a('Bank Account', ['/funding/bank-account/index'], ['class' => 'title']) ?>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <?= Html::a('Fund Allocation', ['/funding/funding-allocation/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Petty Cash', ['/funding/petty-cash-book/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <a href="">
                                            <span class="title">Reports</span>
                                        </a>
                                        <ul>
                                            <li>
                                                <?= Html::a('Debtor Wise Report', ['/funding/debtor-wise-report/index'], ['class' => 'title']) ?>
                                            </li>
                                        </ul>
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
                                        <?= Html::a('Tax', ['/masters/tax-master/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Services', ['/masters/services/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Sub Services', ['/masters/master-sub-service/index'], ['class' => 'title']) ?>
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

                        <li>
                            <a href="">
                                <i class="fa fa-share"></i>
                                <span class="title">Tasks</span>
                            </a>
                            <ul>
                                <li>
                                    <?= Html::a('Tasks', ['/task/task/index'], ['class' => 'title']) ?>
                                </li>

                            </ul>
                        </li>
                        <?php
                        if (Yii::$app->session['post']['admin'] == 1) {
                            ?>
                            <li>
                                <a href="">
                                    <i class="fa fa-cog"></i>
                                    <span class="title">Settings</span>
                                </a>
                                <ul>
                                    <li>
                                        <?= Html::a('Bank Details', ['/settings/bank-details/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Addresses', ['/settings/addresses/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Report Template', ['/settings/report-template/index'], ['class' => 'title']) ?>
                                    </li>
                                </ul>
                            </li>
                            <?php
                        }
                        ?>
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
//                        $notification_count = \common\models\Notification::find()->where(['status' => 1])->count();
                        ?>
                        <li class="dropdown hover-line hover-line-notify">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Notifications">
                                <i class="fa-bell-o"></i>
                                <!--<span class="badge badge-purple" id="notify-count"><?php // $notification_count                            ?></span>-->
                                <span class="badge badge-purple" id="notify-count" style="color: #7c39bc;">.</span>
                            </a>
                            <ul class="dropdown-menu notifications">
                                <li class="top">
                                    <p class="small">
                                        <!--                                        <a href="#" class="pull-right">Mark all Read</a>-->
                                        You have <strong id="notify-counts"><?php // $notification_count ?></strong> new notifications.
                                    </p>
                                </li>

                                <li>
                                    <ul class="dropdown-menu-list list-unstyled ps-scrollbar ps-container dropdown-menu-list-notify">
                                        <?php
                                        foreach ($notifications as $value) {
                                            ?>
                                            <li class="active notification-success" id="notify-<?= $value->id ?>">
                                                <a>
                                                    <span class="line notification-line" style="width: 85%;padding-left: 0;cursor: pointer;" id="<?= $value->appointment_id ?>">
                                                        <strong style="line-height: 20px;"><?= $value->content ?></strong>
                                                    </span>

                                                    <span class="line small time" style="padding-left: 0;">
                                                        <?= $value->date ?>
                                                    </span>
                                                    <!--<input type="checkbox" checked="" class="iswitch iswitch-secondary disable-notification" data-id= "<?= $value->id ?>" style="margin-top: -35px;float: right;" title="Ignore">-->
                                                </a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                        <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 2px;"><div class="ps-scrollbar-y" style="top: 0px; height: 0px;"></div></div>
                                    </ul>
                                </li>

                                <li class="external">
                                    <?= Html::a('<span style="color: #03A9F4;">View all notifications</span> <i class="fa-link-ext"></i>', ['/appointment/notification']) ?>
                                </li>
                            </ul>
                        </li>
                        <?php
                        $my_tasks = \common\models\Task::find()->where(['status' => 1, 'assigned_to' => Yii::$app->user->identity->id])->orderBy(['id' => SORT_DESC])->limit(10)->all();
//                        $my_tasks_count = \common\models\Task::find()->where(['status' => 1, 'assigned_to' => Yii::$app->user->identity->id])->count();
//                        if (empty($my_tasks)) {
//                            $my_tasks = \common\models\Task::find()->where(['status' => 1, 'assigned_to' => Yii::$app->user->identity->id])->orderBy(['id' => SORT_DESC])->limit(10)->all();
//                            $my_tasks_count = \common\models\Task::find()->where(['status' => 1, 'assigned_to' => Yii::$app->user->identity->id])->count();
//                        }
                        ?>
                        <li class="dropdown hover-line hover-line-task">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="My Tasks">
                                <i class="fa-envelope-o"></i>
                                <!--<span class="badge badge-green" id="my-task-count"><?php // $my_tasks_count                           ?></span>-->
                                <span class="badge badge-green" id="my-task-count" style="color: #8dc63e;">.</span>
                            </a>
                            <ul class="dropdown-menu my-task" style="width: 370px;">
                                <li class="top">
                                    <p class="small">
                                        <!--                                        <a href="#" class="pull-right">Mark all Read</a>-->
                                        You have <strong id="tasks-counts"><?php // $my_tasks_count ?></strong> new tasks.
                                    </p>
                                </li>

                                <li>
                                    <ul class="dropdown-menu-list list-unstyled ps-scrollbar ps-container dropdown-menu-list-task">
                                        <?php
                                        foreach ($my_tasks as $value) {
                                            ?>
                                            <li class="active task-success" id="mytasks-<?= $value->id ?>">
                                                <a href="#">
                                                    <span class="line task-line" style="width: 85%;padding-left: 0;" id="<?= $value->id ?>">
                                                        <strong style="line-height: 20px;"><?= $value->follow_up_msg ?></strong>
                                                    </span>

                                                    <span class="line small time" style="padding-left: 0;">
                                                        <?= $value->date ?>
                                                    </span>
                                                    <!--<input type="checkbox" checked="" class="iswitch iswitch-blue close-task" data-id= "<?= $value->id ?>" style="margin-top: -35px;float: right;" title="Close">-->
                                                </a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                        <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 2px;"><div class="ps-scrollbar-y" style="top: 0px; height: 0px;"></div></div>
                                    </ul>
                                </li>

                                <li class="external">
                                    <?= Html::a('<span style="color: #03A9F4;">View all Tasks</span> <i class="fa-link-ext"></i>', ['/task/task']) ?>
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
                                if (Yii::$app->user->identity->photo != '') {
                                    $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/' . Yii::$app->user->identity->id . '.' . Yii::$app->user->identity->photo;
                                    if (file_exists($dirPath)) {
                                        $img = '<img class="img-circle img-inline userpic-32" width="28px" src="' . Yii::$app->homeUrl . 'uploads/' . Yii::$app->user->identity->id . '.' . Yii::$app->user->identity->photo . '"/>';
                                    } else {
                                        $img = '<img class="img-circle img-inline userpic-32" width="28px" src="' . Yii::$app->homeUrl . 'images/user-5.png"/>';
                                    }
                                } else {
                                    $img = '<img class="img-circle img-inline userpic-32" width="28px" src="' . Yii::$app->homeUrl . 'images/user-5.png"/>';
                                }
                                echo $img;
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
                    function Notifications() {
                        $(".dropdown-menu-list-notify").empty();
                        $(".dropdown-menu-list-task").empty();
                        $.ajax({
                            type: 'POST',
                            cache: false,
                            async: false,
                            data: {},
                            url: '<?= Yii::$app->homeUrl; ?>site/get-notification-task',
                            success: function (data) {
                                var res = $.parseJSON(data);
                                $(".dropdown-menu-list-notify").append(res.result["notification-list"]);
                                $('#notify-count').text(res.result["notificationcount"]);
                                $('#notify-counts').text(res.result["notificationcount"]);
//                                $(".hover-line-notify").addClass("open");
                                $(".dropdown-menu-list-task").append(res.result["task-list"]);
                                $('#tasks-counts').text(res.result["taskcount"]);
                                $('#my-task-count').text(res.result["taskcount"]);
//                                $(".hover-line-task").addClass("open");
                            }
                        });
                    }
//                    setInterval(Notifications, 12000);

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
                    $(document).on('change', '.disable-notification', function (e) {
                        var idd = $(this).attr('data-id');
                        var count = $('#notify-count').text();
                        $.ajax({
                            type: 'POST',
                            cache: false,
                            async: false,
                            data: {id: idd},
                            url: '<?= Yii::$app->homeUrl; ?>appointment/notification/update-notification',
                            success: function (data) {
                                $(".hover-line-notify").addClass("open");
                                var res = $.parseJSON(data);
                                $('#notify-' + idd).fadeOut(750, function () {
                                    $(this).remove();
                                });
                                $('#notify-count').text(count - 1);
                                $('#notify-counts').text(count - 1);
                                if (data != 1) {
                                    var next_row = '<li class="active notification-success" id="notify-' + res.result["id"] + '" >\n\
                                <a href="#">\n\
                                                    <span class="line notification-line" style="width: 85%;padding-left: 0;cursor:pointer" id ="' + res.result["appointment_id"] + '" >\n\
                                                        <strong style="line-height: 20px;">' + res.result["content"] + '</strong>\n\
                                                    </span>\n\
                                                    <span class="line small time" style="padding-left: 0;">' + res.result["date"] + '\n\
                                                    </span>\n\
                                                    <input type="checkbox" checked="" class="iswitch iswitch-secondary disable-notification" data-id= "' + res.result["id"] + '" style="margin-top: -35px;float: right;" title="Ignore">\n\
                                                </a>\n\
                                </li>';
                                    $(".dropdown-menu-list-notify").append(next_row);
                                }
                                e.preventDefault();
                            }
                        });
                    });
                    $(document).on('change', '.close-task', function (e) {
                        var idd = $(this).attr('data-id');
                        var count = $('#my-task-count').text();
                        $.ajax({
                            type: 'POST',
                            cache: false,
                            async: false,
                            data: {id: idd},
                            url: '<?= Yii::$app->homeUrl; ?>task/task/update-task',
                            success: function (data) {
                                var res = $.parseJSON(data);
                                $('#mytasks-' + idd).fadeOut(750, function () {
                                    $(this).remove();
                                });
                                $('#tasks-counts').text(count - 1);
                                $('#my-task-count').text(count - 1);
                                $(".hover-line-task").addClass("open");
                                if (data != 1) {
                                    var next_row = '<li class="active notification-success" id="tasks-' + res.result["id"] + '" >\n\
                                <a href="#">\n\
                                                    <span class="line" style="width: 85%;padding-left: 0;">\n\
                                                        <strong style="line-height: 20px;">' + res.result["content"] + '</strong>\n\
                                                    </span>\n\
                                                    <span class="line small time" style="padding-left: 0;">' + res.result["date"] + '\n\
                                                    </span>\n\
                                                    <input type="checkbox" checked="" class="iswitch iswitch-blue close-task" data-id= "' + res.result["id"] + '" style="margin-top: -35px;float: right;" title="Closed">\n\
                                                </a>\n\
                                </li>';
                                    $(".dropdown-menu-list-task").append(next_row);
                                }
                                e.preventDefault();
                            }
                        });
                    });
                    $(document).on('click', '.notification-line', function (e) {
                        var idd = $(this).attr('id');
                        window.location.href = '<?= Yii::$app->homeUrl; ?>appointment/appointment/view?id=' + idd;
                    });
                    $(document).on('click', '.task-line', function (e) {
                        var idd = $(this).attr('id');
                        window.location.href = '<?= Yii::$app->homeUrl; ?>task/task/view?id=' + idd;
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