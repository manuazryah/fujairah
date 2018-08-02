<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Vessel */

$this->title = $model->vessel_name;
$this->params['breadcrumbs'][] = ['label' => 'Vessels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

            </div>
            <div class="panel-body">
                <?= Html::a('<i class="fa-th-list"></i><span> Manage Vessel</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                <div class="panel-body"><div class="vessel-view">
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
                                'vessel_type',
                                'vessel_name',
                                'imo_no',
                                'official',
                                'mmsi_no',
                                'owners_info:ntext',
                                'mobile',
                                'land_line',
                                'direct_line',
                                'fax',
                                'picture',
                                'dwt',
                                'grt',
                                'nrt',
                                'loa',
                                'beam',
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


