<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ContactsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contacts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contacts-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

                </div>
                <div class="panel-body">
                    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

                    <?= Html::a('<i class="fa-th-list"></i><span> Create Contacts</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <?php Pjax::begin(); ?>
                    <button class="btn btn-white" id="search-option" style="float: right;">
                        <i class="linecons-search"></i>
                        <span>Search</span>
                    </button>                                                                                                     <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            //  'id',
                            'name',
                            'person',
                            'email:email',
//                                                'phone_1',
//                                                'phone_2',
//                                                'address:ntext',
//                                                'comment:ntext',
//                                                'contact_type',
                            [
                                'attribute' => 'status',
                                'format' => 'raw',
                                'filter' => [1 => 'Enabled', 0 => 'disabled'],
                                'value' => function ($model) {
                                    return $model->status == 1 ? 'Enabled' : 'disabled';
                                },
                            ],
                            ['class' => 'yii\grid\ActionColumn',
                                'template' => '{view}{update}'
                            ],
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


