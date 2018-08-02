<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\NotificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notifications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive" style="border: none;">
                        <button class="btn btn-white" id="search-option" style="float: right;">
                            <i class="linecons-search"></i>
                            <span>Search</span>
                        </button>

                        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



                        <?php //  Html::a('<i class="fa-th-list"></i><span> Create Notification</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>

                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'rowOptions' => function ($model, $key, $index, $grid) {
                                return ['id' => $model['id']];
                            },
                            'pager' => ['firstPageLabel' => 'First', 'lastPageLabel' => 'Last'],
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
//                                'id',
                                [
                                    'attribute' => 'notification_type',
                                    'format' => 'raw',
                                    'filter' => [1 => 'ETA', 2 => 'Cast Off'],
                                    'value' => function ($model) {
                                        return $model->notification_type == 1 ? 'ETA' : 'Cast Off';
                                    },
                                ],
                                'appointment_no',
                                'message:ntext',
//                                [
//                                    'attribute' => 'status',
//                                    'format' => 'raw',
//                                    'filter' => [1 => 'Open', 2 => 'Ignore', 3 => 'Close'],
//                                    'value' => function ($model) {
//                                        if ($model->status == 1) {
//                                            return 'Open';
//                                        } elseif ($model->status == 2) {
//                                            return 'Ignore';
//                                        } elseif ($model->status == 3) {
//                                            return 'Close';
//                                        }
//                                    },
//                                ],
//                                [
//                                    'class' => 'yii\grid\ActionColumn',
//                                    'contentOptions' => ['style' => 'width:100px;'],
//                                    'header' => 'Actions',
//                                    'template' => '{ignore}',
//                                    'buttons' => [
//                                        'ignore' => function ($url, $model) {
//                                            return Html::checkbox('status', TRUE, ['class' => 'iswitch iswitch-secondary notification-status', 'id' => $model->id]);
//                                        },
//                                    ],
//                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(".filters").slideToggle();
        $("#search-option").click(function () {
            $(".filters").slideToggle();
        });
        $('.notification-status').on('change', function (e) {
            var idd = $(this).attr('id');
            var count = $('#notify-count').text();
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {id: idd},
                url: '<?= Yii::$app->homeUrl; ?>appointment/notification/update-notification',
                success: function (data) {
                    var res = $.parseJSON(data);
                    $('#' + idd).remove();
                    $('#notify-' + idd).remove();
                    $('#notify-count').text(count - 1);
                    $('#notify-counts').text(count - 1);
                    if (data != 1) {
                        var next_row = '<li class="active notification-success" id="notify-' + res.result["id"] + '" >\n\
                                <a href="#">\n\
                                                    <span class="line" style="width: 85%;padding-left: 0;">\n\
                                                        <strong style="line-height: 20px;">' + res.result["content"] + '</strong>\n\
                                                    </span>\n\
                                                    <span class="line small time" style="padding-left: 0;">' + res.result["date"] + '\n\
                                                    </span>\n\
                                                    <input type="checkbox" checked="" class="iswitch iswitch-secondary disable-notification" data-id= "' + res.result["id"] + '" style="margin-top: -35px;float: right;" title="Ignore">\n\
                                                </a>\n\
                                </li>';
                        $(".dropdown-menu-list-notify").append(next_row);
                    }
                }
            });
        });
    });
</script>

