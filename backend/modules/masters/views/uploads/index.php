<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\DemoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Uploads';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .grid-view th{
        white-space: normal;
    }
    .grid-view td{
        white-space: normal;
    }
</style>
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
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body"><div class="demo-create">

                            <?=
                            $this->render('_form', [
                                'model' => $model,
                            ])
                            ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-9">
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
//                                [
//                                    'attribute' => 'status',
//                                    'format' => 'raw',
//                                    'filter' => [1 => 'Enabled', 0 => 'disabled'],
//                                    'value' => function ($model) {
//                                        return $model->status == 1 ? 'Enabled' : 'disabled';
//                                    },
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
    });
</script>

