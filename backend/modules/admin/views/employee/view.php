<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Employee */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?= Html::a('<i class="fa-th-list"></i><span> Manage Employee</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                <div class="panel-body"><div class="employee-view">
                        <p>
                            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                            <?=
                            Html::a('Delete', ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ])
                            ?>
                        </p>

                        <?=
                        DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                // 'id',
                                    [
                                    'attribute' => 'photo',
                                    'format' => 'raw',
                                    'value' => call_user_func(function($model) {
                                                if ($model->photo != '') {
                                                    $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/' . $model->id . '.' . $model->photo;
                                                    if (file_exists($dirPath)) {
                                                        $img = '<img width="120px" src="' . Yii::$app->homeUrl . 'uploads/' . $model->id . '.' . $model->photo . '"/>';
                                                    } else {
                                                        $img = '<img width="120px" src="' . Yii::$app->homeUrl . 'images/user-4.png"/>';
                                                    }
                                                } else {
                                                    $img = '<img width="120px" src="' . Yii::$app->homeUrl . 'images/user-4.png"/>';
                                                }
                                                return $img;
                                            }, $model),
                                ],
                                    [
                                    'attribute' => 'post_id',
                                    'value' => $model->post->post_name,
                                ],
                                    [
                                    'attribute' => 'branch_id',
                                    'value' => call_user_func(function ($data) {
                                                $branch = explode(',', $data->branch_id);
                                                $result = '';
                                                foreach ($branch as $brnch) {
                                                    $result .= $data->getBranchName($brnch) . ', ';
                                                }
                                                return rtrim($result, ",");
                                            }, $model),
                                ],
                                'user_name',
                                'employee_code',
                                //'password',
                                'name',
                                'email:email',
                                'phone',
                                    [
                                    'attribute' => 'gender',
                                    'value' => $model->gender == 1 ? 'Male' : 'Female',
                                ],
                                    [
                                    'attribute' => 'maritual_status',
                                    'value' => $model->status == 1 ? 'Married' : 'Unmarried',
                                ],
                                'address:ntext',
                                'date_of_join',
                                'salary_package',
                                    [
                                    'attribute' => 'status',
                                    'value' => $model->status == 1 ? 'Enabled' : 'Disabled',
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


