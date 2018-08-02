<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\daterange\DateRangePicker;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\DemoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .hide-task-div{
        display:none;
    }
</style>
<?php
$emps = \common\models\Employee::find()->where(['status' => 1])->all();
?>
<div style="display:none;">
    <select id="task-assigned_to" class="form-control" name="Task[assigned_to]">
        <option value=""> - Select - </option>
        <?php
        foreach ($emps as $val) {
            ?>
            <option value="<?= $val->id ?>"><?= $val->name ?></option>
            <?php
        }
        ?>
    </select>
</div>
<div class="demo-index">
    <div class="row">
        <div class="col-md-12">
            <div class="page-title">

                <div class="title-env">
                    <h1 class="title"><?= Html::encode($this->title) ?></h1>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-white task-link" style="border: 1px solid #03A9F4;"><span style="font-weight: bold;color: #03A9F4;">Add Task</span></button>
            <?= Html::a('<span style="font-weight: bold;color: #03A9F4;">My Task</span>', ['index', 'task' => 'mytask'], ['class' => 'btn btn-white my-task-link', 'style' => 'border: 1px solid #03A9F4;']) ?>
            <?= Html::a('<span style="font-weight: bold;color: #03A9F4;">All Task</span>', ['index'], ['class' => 'btn btn-white my-task-link', 'style' => 'border: 1px solid #03A9F4;']) ?>
            <?= Html::a('<span style="font-weight: bold;color: #03A9F4;">Completed Task</span>', ['index', 'task' => 'completedtask'], ['class' => 'btn btn-white my-task-link', 'style' => 'border: 1px solid #03A9F4;']) ?>
        </div>
    </div>
    <div class="row hide-task-div">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="demo-create">

                        <?=
                        $this->render('_form', [
                            'model' => $model,
                        ])
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body table-responsive">
                    <button class="btn btn-white" id="search-option" style="float: right;">
                        <i class="linecons-search"></i>
                        <span>Search</span>
                    </button>
                    <?php if (Yii::$app->session->hasFlash('error')): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= Yii::$app->session->getFlash('error') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (Yii::$app->session->hasFlash('success')): ?>
                        <div class="alert alert-success" role="alert">
                            <?= Yii::$app->session->getFlash('success') ?>
                        </div>
                    <?php endif; ?>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'rowOptions' => function ($model, $key, $index, $grid) {
                            return ['id' => $model['id']];
                        },
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
//                                        'id',
                            [
                                'attribute' => 'assigned_from',
                                'value' => function ($model) {
                                    if (isset($model->assigned_from)) {
                                        return \common\models\Employee::findOne(['id' => $model->assigned_from])->name;
                                    } else {
                                        return '';
                                    }
                                },
                                'filter' => ArrayHelper::map(\common\models\Employee::find()->where(['status' => 1])->asArray()->all(), 'id', 'name'),
                                'filterOptions' => array('class' => "assigned_from_search"),
                            ],
                            [
                                'attribute' => 'assigned_to',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->status != 4) {
                                        if ($data->assigned_to == Yii::$app->user->identity->id || Yii::$app->user->identity->post_id == 1) {
                                            return \yii\helpers\Html::dropDownList('assigned_to', null, ArrayHelper::map(\common\models\Employee::find()->all(), 'id', 'name'), ['options' => [$data->assigned_to => ['selected' => 'selected']], 'class' => 'form-control assignedtoo', 'id' => "assigned-" . $data->id]);
                                        } else {
                                            return common\models\Employee::findOne($data->assigned_to)->name;
                                        }
                                    } else {
                                        return common\models\Employee::findOne($data->assigned_to)->name;
                                    }
                                },
                                'filter' => ArrayHelper::map(\common\models\Employee::find()->where(['status' => 1])->asArray()->all(), 'id', 'name'),
                                'filterOptions' => array('class' => "assigned_to_search"),
                            ],
                            [
                                'attribute' => 'follow_up_msg',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $newtext = wordwrap($data->follow_up_msg, 20, "<br />\n");
                                    return $newtext;
                                },
                            ],
                            [
                                'attribute' => 'date',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->status != 4) {
                                        if ($data->assigned_to == Yii::$app->user->identity->id || Yii::$app->user->identity->post_id == 1) {
                                            return DateTimePicker::widget([
                                                        'name' => 'date',
                                                        'id' => 'date-' . $data->id,
                                                        'options' => ['class' => 'date-change'],
                                                        'type' => DateTimePicker::TYPE_INPUT,
                                                        'value' => $data->date,
                                                        'pluginOptions' => [
                                                            'autoclose' => true,
                                                            'format' => 'yyyy-mm-dd hh:ii:ss'
                                                        ]
                                            ]);
                                        } else {
                                            return $data->date;
                                        }
                                    } else {
                                        return $data->date;
                                    }
                                },
                                'filter' => DateRangePicker::widget(['model' => $searchModel, 'attribute' => 'date', 'pluginOptions' => ['format' => 'yyyy-mm-dd hh:ii:ss', 'autoUpdateInput' => false]]),
                            ],
                            [
                                'attribute' => 'appointment_id',
                                'value' => function ($model) {
                                    $appointments = explode(',', $model->appointment_id);
                                    $result = '';
                                    if (!empty($appointments)) {
                                        $i = 0;
                                        foreach ($appointments as $appointment) {
                                            if ($i != 0) {
                                                $result .= ',';
                                            }
                                            $result .= $model->getAppointmentNo($appointment);
                                            $i++;
                                        }
                                    }
                                    return $result;
                                },
                                'filter' => ArrayHelper::map(\common\models\Appointment::find()->where(['status' => 1])->asArray()->all(), 'id', 'appointment_no'),
                                'filterOptions' => array('class' => "appointment_id_search"),
                            ],
                            [
                                'attribute' => 'follow_up',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->status != 4) {
                                        if ($data->assigned_to == Yii::$app->user->identity->id || Yii::$app->user->identity->post_id == 1) {
                                            return \yii\helpers\Html::dropDownList('follow_up', null, ArrayHelper::map(\common\models\Employee::find()->all(), 'id', 'name'), ['options' => Yii::$app->SetValues->Selected($data->follow_up), 'class' => 'form-control followups', 'multiple' => 'multiple', 'id' => "followups-" . $data->id]);
                                        } else {
                                            return $data->getEmployee($data->follow_up);
                                        }
                                    } else {
                                        return $data->getEmployee($data->follow_up);
                                    }
                                },
                                'filter' => ArrayHelper::map(\common\models\Employee::find()->where(['status' => 1])->asArray()->all(), 'id', 'name'),
                                'filterOptions' => array('class' => "assigned_to_search"),
                            ],
                            [
                                'attribute' => 'status',
                                'format' => 'raw',
                                'filter' => [1 => 'Pending', 2 => 'Upcoming', 3 => 'Overdue', 4 => 'Completed'],
                                'value' => function ($model) {
                                    if ($model->status == 1) {
                                        $stat = '<span style="color: black">Pending</span>';
                                    } elseif ($model->status == 2) {
                                        $stat = '<span style="color: #ffba00;">Upcoming</span>';
                                    } elseif ($model->status == 3) {
                                        $stat = '<span style="color: red">Overdue</span>';
                                    } elseif ($model->status == 4) {
                                        $stat = '<span style="color: green">Completed</span>';
                                    }
                                    return $stat;
                                },
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'contentOptions' => ['style' => 'width:100px;'],
                                'header' => 'Actions',
                                'template' => '{completed}{view}',
                                'buttons' => [
                                    'completed' => function ($url, $model) {
                                        if ($model->status != 4) {
                                            return Html::checkbox('status', TRUE, ['class' => 'iswitch iswitch-secondary task-status', 'id' => $model->id]);
                                        }
                                    },
                                    'view' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                                    'title' => Yii::t('app', 'View Task'),
                                                    'class' => '',
                                                    'style' => 'font-size: 20px;padding: 0px 0px 0px 6px;color: #2196F3;',
                                        ]);
                                    },
                                ],
                                'urlCreator' => function ($action, $model) {
                                    if ($action === 'view') {
                                        $url = Url::to(['view', 'id' => $model->id]);
                                        return $url;
                                    }
                                }
                            ],
                        ],
                    ]);
                    ?>
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
        $('.task-status').on('change', function (e) {
            var idd = $(this).attr('id');
            var count = $('#my-task-count').text();
            var whichtr = $(this).closest("tr");
            alert(whichtr);
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {id: idd},
                url: '<?= Yii::$app->homeUrl; ?>task/task/update-task',
                success: function (data) {
                    var res = $.parseJSON(data);
                    $('#' + idd).remove();
                    $('#mytasks-' + idd).remove();
                    $('#tasks-counts').text(count - 1);
                    $('#my-task-count').text(count - 1);
                    if (data != 1) {
                        var next_row = '<li class="active notification-success" id="notify-' + res.result["id"] + '" >\n\
                                <a href="#">\n\
                                                    <span class="line" style="width: 85%;padding-left: 0;">\n\
                                                        <strong style="line-height: 20px;">' + res.result["content"] + '</strong>\n\
                                                    </span>\n\
                                                    <span class="line small time" style="padding-left: 0;">' + res.result["date"] + '\n\
                                                    </span>\n\
                                                    <input type="checkbox" checked="" class="iswitch iswitch-blue disable-notification" data-id= "' + res.result["id"] + '" style="margin-top: -35px;float: right;" title="Closed">\n\
                                                </a>\n\
                                </li>';
                        $(".dropdown-menu-list-task").append(next_row);
                    }
                    whichtr.remove();
                }
            });
        });

        $('.assigned_from_search select').attr('id', 'assigned_from_id');
        $('.assigned_to_search select').attr('id', 'assigned_to_id');
        $('.appointment_id_search select').attr('id', 'appointment_id');

        $('.assignedtoo').on('change', function (e) {
            var task_idd = $(this).attr('id');
            var task_id = task_idd.split('-');
            var idd = $(this).val();
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {id: task_id[1], person_id: idd},
                url: '<?= Yii::$app->homeUrl; ?>task/task/update-assigned-person',
                success: function (data) {

                }
            });
        });

        $('.followups').on('change', function (e) {
            var task_idd = $(this).attr('id');
            var task_id = task_idd.split('-');
            var idd = $(this).val();
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {id: task_id[1], followup_id: idd},
                url: '<?= Yii::$app->homeUrl; ?>task/task/update-followups',
                success: function (data) {

                }
            });
        });
        $('.date-change').on('change', function (e) {
            var task_idd = $(this).attr('id');
            var task_id = task_idd.split('-');
            var assign_date = $(this).val();
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {id: task_id[1], date: assign_date},
                url: '<?= Yii::$app->homeUrl; ?>task/task/update-assign-date',
                success: function (data) {

                }
            });
        });

    });
</script>
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2.css">
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2-bootstrap.css">
<script src="<?= Yii::$app->homeUrl; ?>js/select2/select2.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function ($)
    {
        $("#assigned_from_id").select2({
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#assigned_to_id").select2({
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#appointment_id").select2({
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $(".followups").select2({
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });

    });
</script>

