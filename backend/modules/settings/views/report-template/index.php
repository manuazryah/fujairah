<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ReportTemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Report Templates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-template-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

                </div>
                <div class="panel-body">
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= Html::a('<i class="fa-th-list"></i><span> Create Report Template</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <div class="table-responsive" style="border: none;">
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
//                                'id',
                                [
                                    'attribute' => 'type',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        if ($data->type != '') {
                                            if ($data->type == 1) {
                                                return 'EPDA';
                                            } elseif ($data->type == 2) {
                                                return 'FDA';
                                            }
                                        } else {
                                            return '';
                                        }
                                    },
                                ],
                                [
                                    'attribute' => 'left_logo',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        if ($data->left_logo != '') {
                                            $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/report_template/' . $data->id . '/' . $data->left_logo;
                                            if (file_exists($dirPath)) {
                                                $img = '<img width="120px" src="' . Yii::$app->homeUrl . 'uploads/report_template/' . $data->id . '/' . $data->left_logo . '"/>';
                                            } else {
                                                $img = 'No Image';
                                            }
                                        } else {
                                            $img = 'No Image';
                                        }
                                        return $img;
                                    },
                                ],
                                [
                                    'attribute' => 'right_logo',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        if ($data->right_logo != '') {
                                            $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/report_template/' . $data->id . '/' . $data->right_logo;
                                            if (file_exists($dirPath)) {
                                                $img = '<img width="120px" src="' . Yii::$app->homeUrl . 'uploads/report_template/' . $data->id . '/' . $data->right_logo . '"/>';
                                            } else {
                                                $img = 'No Image';
                                            }
                                        } else {
                                            $img = 'No Image';
                                        }
                                        return $img;
                                    },
                                ],
//                                'report_description:ntext',
                                // 'footer_content:ntext',
//                                'address',
//                                'bank',
                                // 'account_mannager_email:email',
                                // 'account_mannager_phone',
                                // 'status',
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
</div>
<script>
    $(document).ready(function () {
        $(".filters").slideToggle();
        $("#search-option").click(function () {
            $(".filters").slideToggle();
        });
    });
</script>


