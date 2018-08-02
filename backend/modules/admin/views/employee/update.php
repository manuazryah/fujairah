<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Employee */

$this->title = 'Update Employee: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

            </div>
            <div class="panel-body">
                <?= Html::a('<i class="fa-th-list"></i><span> Manage Employee</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                <?= Html::a('<i class="fa fa-pencil-square-o"></i><span> Change password</span>', ['change-password', 'id' => $model->id], ['class' => 'btn btn-purple btn-icon btn-icon-standalone']) ?>
                <div class="panel-body"><div class="employee-create">
                        <?=
                        $this->render('_form', [
                            'model' => $model,
                            'model_upload' => $model_upload,
                        ])
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
