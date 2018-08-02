<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\ServiceCategorys;
use common\models\InvoiceType;
use common\models\Contacts;
use common\models\Units;
use common\models\Currency;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ServicesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Services';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="services-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

                </div>
                <div class="panel-body">
                    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

                    <?= Html::a('<i class="fa-th-list"></i><span> Create Services</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <?php Pjax::begin(); ?>
                    <button class="btn btn-white" id="search-option" style="float: right;">
                        <i class="linecons-search"></i>
                        <span>Search</span>
                    </button>                                                                                                      <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            // 'id',
                            [
                                'attribute' => 'category_id',
                                'label' => 'Category',
                                'value' => 'category.category_name',
                                'filter' => ArrayHelper::map(ServiceCategorys::find()->asArray()->all(), 'id', 'category_name'),
                            ],
                            'service',
                            [
                                'attribute' => 'invocie_type',
                                'value' => function($data) {
                                    $invocie_type = explode(',', $data->invocie_type);
                                    $result = '';
                                    foreach ($invocie_type as $invoice) {
                                        $result .= $data->getInvoiceName($invoice) . ', ';
                                    }
                                    return rtrim($result, ",");
                                },
                                'filter' => ArrayHelper::map(InvoiceType::find()->asArray()->all(), 'id', 'invoice_type'),
                            ],
                            [
                                'attribute' => 'supplier',
                                'value' => function($data) {

                                    if ($data->supplier != '') {
                                        $supplier = explode(',', $data->supplier);
                                        $result = '';

                                        foreach ($supplier as $supplie) {

                                            if (isset($supplie)) {
                                                $result .= Contacts::findOne(['id' => $supplie])->name . ', ';
                                            }
                                        }
                                        return rtrim($result, ",");
                                    }
                                },
                                'filter' => ArrayHelper::map(Contacts::find()->asArray()->all(), 'id', 'name'),
                                'filterOptions' => array('id' => "supplier_search"),
                            ],
//                                [
//                                'attribute' => 'unit',
//                                'value' => 'unit0.unit_name',
//                                'filter' => ArrayHelper::map(Units::find()->asArray()->all(), 'id', 'unit_name'),
//                            ],
//                                [
//                                'attribute' => 'currency',
//                                'value' => 'currency0.currency_name',
//                                'filter' => ArrayHelper::map(Currency::find()->asArray()->all(), 'id', 'currency_name'),
//                            ],
//                            'roe',
//                            'epda_value',
                            // 'comments:ntext',
                            [
                                'attribute' => 'status',
                                'format' => 'raw',
                                'filter' => [1 => 'Enabled', 0 => 'disabled'],
                                'value' => function ($model) {
                                    return $model->status == 1 ? 'Enabled' : 'disabled';
                                },
                            ],
                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]);
                    ?>
                    <?php Pjax::end(); ?>                                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2.css">
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2-bootstrap.css">
<script src="<?= Yii::$app->homeUrl; ?>js/select2/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#supplier_search select').attr('id', 'supplier');
        $(".filters").slideToggle();
        $("#search-option").click(function () {
            $(".filters").slideToggle();
        });
        /*********** Script for dropdown search widget start ********************/

        $("#supplier").select2({
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });

        /*********** Script for dropdown search widget end ********************/
    });
</script>


