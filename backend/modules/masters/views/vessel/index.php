<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\VesselType;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\VesselSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vessels';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vessel-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

                </div>
                <div class="panel-body">
                    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

                    <?= Html::a('<i class="fa-th-list"></i><span> Create Vessel</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <?php Pjax::begin(); ?>
                    <button class="btn btn-white" id="search-option" style="float: right;">
                        <i class="linecons-search"></i>
                        <span>Search</span>
                    </button>                                                                                                   <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            //  'id',
                            [
                                'attribute' => 'vessel_type',
                                'value' => function($data) {
                                    return VesselType::findOne($data->vessel_type)->vessel_type;
                                },
                                'filter' => ArrayHelper::map(VesselType::find()->asArray()->all(), 'id', 'vessel_type'),
                            ],
                            'vessel_name',
                            'imo_no',
                            'official',
                            'mmsi_no',
                            'owners_info:ntext',
//                            'mobile',
                            // 'land_line',
                            // 'direct_line',
                            // 'fax',
                            // 'picture',
                            // 'dwt',
                            // 'grt',
                            // 'nrt',
                            // 'loa',
                            // 'beam',
//                            [
//                                'attribute' => 'status',
//                                'format' => 'raw',
//                                'filter' => [1 => 'Enabled', 0 => 'disabled'],
//                                'value' => function ($model) {
//                                    return $model->status == 1 ? 'Enabled' : 'disabled';
//                                },
//                            ],
                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]);
                    ?>
                    <script>
                        $(document).ready(function () {
                            $(".filters").slideToggle();
                            $("#search-option").click(function () {
                                $(".filters").slideToggle();
                            });
                        });
                    </script>
                    <?php Pjax::end(); ?>                                </div>
            </div>
        </div>
    </div>
</div>


