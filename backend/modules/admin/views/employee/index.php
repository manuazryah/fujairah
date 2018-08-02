<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Branch;
use common\models\AdminPosts;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\EmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

                </div>
                <div class="panel-body">
                    <?php // echo $this->render('_search', ['model' => $searchModel]);   ?>

                    <?= Html::a('<i class="fa-th-list"></i><span> Create Employee</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <?php Pjax::begin(); ?>
                    <div class="table-responsive">
                        <button class="btn btn-white" id="search-option" style="float: right;">
                            <i class="linecons-search"></i>
                            <span>Search</span>
                        </button>                                                                                                   <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
//                                ['class' => 'yii\grid\SerialColumn'],
                                // 'id',
                                [
                                    'attribute' => 'photo',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        if ($data->photo != '') {
                                            $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/' . $data->id . '.' . $data->photo;
                                            if (file_exists($dirPath)) {
                                                $img = '<img width="120px" src="' . Yii::$app->homeUrl . 'uploads/' . $data->id . '.' . $data->photo . '"/>';
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
                                    'attribute' => 'post_id',
                                    'value' => 'post.post_name',
                                    'filter' => ArrayHelper::map(AdminPosts::find()->asArray()->all(), 'id', 'post_name'),
                                ],
//                                [
//                                    'attribute' => 'branch_id',
//                                    'value' => function ($data) {
//                                        $branch = explode(',', $data->branch_id);
//                                        $result = '';
//                                        foreach ($branch as $brnch) {
//                                            $result .= $data->getBranchName($brnch) . ', ';
//                                        }
//                                        return rtrim($result, ",");
//                                    },
//                                ],
                                // 'branch_id',
                                'user_name',
                                'employee_code',
                                [
                                    'attribute' => 'department',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        if (isset($data->department) && $data->department != '') {
                                            if ($data->department == 2) {
                                                return 'Operations';
                                            } elseif ($data->department == 3) {
                                                return 'Accounts';
                                            }
                                        } else {
                                            return '';
                                        }
                                    },
                                ],
                                // 'password',
                                 'name',
                                'email:email',
                                // 'phone',
                                // 'gender',
                                // 'maritual_status',
                                // 'address:ntext',
                                // 'date_of_join',
                                // 'salary_package',
                                // 'photo',
                                // 'status',
                                // 'CB',
                                // 'UB',
                                // 'DOC',
                                // 'DOU',
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'headerOptions' => ['style' => 'width: 70px;'],
                                    'template' => '{view} {update} {delete} {cash_in_hand}',
                                    'buttons' => [
                                        'view' => function ($url) {
                                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => Yii::t('app', 'View')]);
                                        },
                                        'update' => function ($url) {
                                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => Yii::t('app', 'Update')]);
                                        },
                                        'delete' => function ($url) {
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['title' => Yii::t('app', 'Delete')]);
                                        },
                                        'cash_in_hand' => function ($url) {
                                            return Html::a('<span><i class="fa fa-credit-card" aria-hidden="true"></i></span>', $url, ['title' => Yii::t('app', 'Cash in hand')]);
                                        }
                                    ],
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                        if ($action === 'view') {
                                            $url = \yii\helpers\Url::toRoute(['/admin/employee/view', 'id' => $key]);
                                            return $url;
                                        } elseif ($action === 'update') {
                                            $url = \yii\helpers\Url::toRoute(['/admin/employee/update', 'id' => $key]);
                                            return $url;
                                        } elseif ($action === 'delete') {
                                            $url = \yii\helpers\Url::toRoute(['/admin/employee/delete', 'id' => $key]);
                                            return $url;
                                        } elseif ($action === 'cash_in_hand') {
                                            $url = \yii\helpers\Url::toRoute(['/admin/employee/add', 'id' => $key]);
                                            return $url;
                                        }
                                    }
                                ],
                            ],
                        ]);
                        ?>
                    </div>
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


