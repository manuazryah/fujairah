<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\DemoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tax Masters';
$this->params['breadcrumbs'][] = $this->title;
?>
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
                    <div class="panel-body table-responsive">
                        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
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
                                'name',
                                'value',
                                [
                                    'attribute' => 'status',
                                    'format' => 'raw',
                                    'filter' => [1 => 'Enabled', 0 => 'disabled'],
                                    'value' => function ($model) {
                                        return $model->status == 1 ? 'Enabled' : 'disabled';
                                    },
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'contentOptions' => ['style' => 'width:100px;'],
                                    'header' => 'Actions',
                                    'template' => '{update}{delete}',
                                    'buttons' => [
                                        'update' => function ($url, $model) {
                                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                                        'title' => Yii::t('app', 'update'),
                                                        'class' => '',
                                            ]);
                                        },
                                        'delete' => function ($url, $model) {
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                                        'title' => Yii::t('app', 'delete'),
                                                        'class' => '',
                                                        'data' => [
                                                            'confirm' => 'Are you absolutely sure ?',
                                                        ],
                                            ]);
                                        },
                                    ],
                                    'urlCreator' => function ($action, $model) {
                                        if ($action === 'update') {
                                            $url = Url::to(['index', 'id' => $model->id]);
                                            return $url;
                                        }
                                        if ($action === 'delete') {
                                            $url = Url::to(['del', 'id' => $model->id]);
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
</div>
<script>
    $(document).ready(function () {
        $(".filters").slideToggle();
        $("#search-option").click(function () {
            $(".filters").slideToggle();
        });
    });
</script>

