<?php

use yii\helpers\Html;
use yii\grid\GridView;

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

                    <button class="btn btn-white" id="search-option" style="float: right;">
                        <i class="linecons-search"></i>
                        <span>Search</span>
                    </button>

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



                    <?php //  Html::a('<i class="fa-th-list"></i><span> Create Notification</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <div class="table-responsive">
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
//                                'id',
                                [
                                    'attribute' => 'notification_type',
                                    'format' => 'raw',
                                    'filter' => [1 => 'ETA', 2 => 'Cast Off'],
                                    'value' => function ($model) {
                                        return $model->status == 1 ? 'ETA' : 'Cast Off';
                                    },
                                ],
                                'notification_type',
                                'appointment_id',
                                'content:ntext',
                                [
                                    'attribute' => 'status',
                                    'format' => 'raw',
                                    'filter' => [1 => 'Open', 2 => 'Ignore', 3 => 'Close'],
                                    'value' => function ($model) {
                                        if ($model->status == 1) {
                                            return 'Open';
                                        } elseif ($model->status == 2) {
                                            return 'Ignore';
                                        } elseif ($model->status == 3) {
                                            return 'Close';
                                        }
                                    },
                                ],
                                ['class' => 'yii\grid\ActionColumn'],
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
    });
</script>

