<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UploadsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Uploads';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .grid-view td{
        white-space: normal;
    }
</style>
<div class="uploads-index">

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
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
//                            'id',
                            'form_name',
                            'comment:ntext',
                            [
                                'attribute' => 'upload_file',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $link = '<a target="_blank" href="' . Yii::$app->homeUrl . 'uploads/common_uploads/' . $data->id . '/' . $data->upload_file . '">' . $data->upload_file . '</a>';
                                    return $link;
                                },
                            ],
//                            'upload_file',
//                            [
//                                'attribute' => 'status',
//                                'format' => 'raw',
//                                'filter' => [1 => 'Enabled', 0 => 'disabled'],
//                                'value' => function ($model) {
//                                    return $model->status == 1 ? 'Enabled' : 'disabled';
//                                },
//                            ],
                        // 'CB',
                        // 'UB',
                        // 'DOC',
                        // 'DOU',
//                            ['class' => 'yii\grid\ActionColumn'],
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
    });
</script>

