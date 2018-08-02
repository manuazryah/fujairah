<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CashInHandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cash In Hands';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cash-in-hand-index">

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

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



                    <?= Html::a('<i class="fa-th-list"></i><span> Create Cash In Hand</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <div class="table-responsive">
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
//                                        'id',
                                'employee_id',
                                'date',
                                'transaction_type',
                                'payment_type',
                                // 'check_no',
                                // 'amount',
                                // 'balance',
                                // 'appointment_id',
                                // 'debtor_id',
                                // 'comment:ntext',
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

