<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Services;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\MasterSubServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sub Services';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .grid-view td{
        white-space: normal;
    }
</style>
<div class="master-sub-service-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

                </div>
                <div class="panel-body">
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= Html::a('<i class="fa-th-list"></i><span> Create Sub Service</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <button class="btn btn-white" id="search-option" style="float: right;">
                        <i class="linecons-search"></i>
                        <span>Search</span>
                    </button>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            //  'id',
                            [
                                'attribute' => 'service_id',
                                'label' => 'Service',
                                'value' => 'service0.service',
                                'filter' => ArrayHelper::map(Services::find()->asArray()->all(), 'id', 'service'),
                                'filterOptions' => array('id' => "service_search"),
                            ],
                            // 'service_id',
                            'sub_service',
                            'rate_to_category',
                            'unit',
                            'unit_price',
                            'total',
//                            'comments:ntext',
//                            'status',
                            // 'CB',
                            // 'UB',
                            // 'DOC',
                            // 'DOU',
                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2.css">
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2-bootstrap.css">
<script src="<?= Yii::$app->homeUrl; ?>js/select2/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#service_search select').attr('id', 'service');
        $(".filters").slideToggle();
        $("#search-option").click(function () {
            $(".filters").slideToggle();
        });
        /*********** Script for dropdown search widget start ********************/

        $("#service").select2({
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });

        /*********** Script for dropdown search widget end ********************/
    });
</script>


