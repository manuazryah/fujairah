<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FundingMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Funding Masters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="funding-master-index">

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
                    


                    <?=  Html::a('<i class="fa-th-list"></i><span> Create Funding Master</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <div class="table-responsive">
                                                                            <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                                        'id',
            'type',
            'payment_type',
            'bank_account',
            'reference_id',
            // 'credit_amount',
            // 'debit_amount',
            // 'journal_type',
            // 'comment:ntext',
            // 'date',
            // 'status',
            // 'CB',
            // 'UB',
            // 'DOC',
            // 'DOU',

                            ['class' => 'yii\grid\ActionColumn'],
                            ],
                            ]); ?>
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

