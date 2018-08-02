<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "petty_cash_book".
 *
 * @property integer $id
 * @property integer $appointment_id
 * @property integer $close_estimate_id
 * @property integer $service_id
 * @property integer $supplier
 * @property double $actual_amount
 * @property double $amount_debit
 * @property double $balance_amount
 * @property integer $debtor_id
 * @property string $invoice_date
 * @property integer $status
 * @property integer $CB
 * @property integer $UB
 * @property string $DOC
 * @property string $DOU
 */
class PettyCashBook extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'petty_cash_book';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['appointment_id', 'close_estimate_id', 'service_id', 'supplier', 'debtor_id', 'status', 'CB', 'UB', 'employee_id'], 'integer'],
            [['actual_amount', 'amount_debit', 'balance_amount'], 'number'],
            [['invoice_date', 'DOC', 'DOU', 'fda_amount'], 'safe'],
            [['CB', 'UB', 'DOC'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'appointment_id' => 'Appointment ID',
            'close_estimate_id' => 'Close Estimate ID',
            'service_id' => 'Service ID',
            'supplier' => 'Supplier',
            'actual_amount' => 'Actual Amount',
            'fda_amount' => 'FDA Amount',
            'amount_debit' => 'Amount Debit',
            'balance_amount' => 'Balance Amount',
            'debtor_id' => 'Debtor ID',
            'employee_id' => 'Employee ID',
            'invoice_date' => 'Invoice Date',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

}
