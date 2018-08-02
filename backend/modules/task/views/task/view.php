<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Task */
if (isset($model->assigned_to)) {
    $assign_name = \common\models\Employee::findOne(['id' => $model->assigned_to])->name;
} else {
    $assign_name = '';
}
$this->title = 'Task For ' . $assign_name;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

            </div>
            <div class="panel-body">
                <?= Html::a('<i class="fa-th-list"></i><span> Manage Task</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                <div class="panel-body"><div class="task-view">
                        <?=
                        DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'id',
                                [
                                    'attribute' => 'assigned_from',
                                    'value' => function ($model) {
                                        if (isset($model->assigned_from)) {
                                            return \common\models\Employee::findOne(['id' => $model->assigned_from])->name;
                                        } else {
                                            return '';
                                        }
                                    },
                                ],
                                [
                                    'attribute' => 'assigned_to',
                                    'label' => 'assigned_to',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        if (isset($model->assigned_to)) {
                                            return \common\models\Employee::findOne(['id' => $model->assigned_to])->name;
                                        } else {
                                            return '';
                                        }
                                    },
                                ],
                                'follow_up_msg:ntext',
                                'date',
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
                                ],
                                [
                                    'attribute' => 'follow_up',
                                    'label' => 'follow_up',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        if (isset($model->assigned_from)) {
                                            return $model->getEmployee($model->follow_up);
                                        } else {
                                            return '';
                                        }
                                    },
                                ],
                                [
                                    'attribute' => 'status',
                                    'format' => 'raw',
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
                            ],
                        ])
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


