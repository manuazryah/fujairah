<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cash_in_hand".
 *
 * @property integer $id
 * @property integer $employee_id
 * @property string $date
 * @property integer $transaction_type
 * @property integer $payment_type
 * @property string $check_no
 * @property double $amount
 * @property double $balance
 * @property integer $appointment_id
 * @property integer $debtor_id
 * @property string $comment
 * @property integer $status
 * @property integer $CB
 * @property integer $UB
 * @property string $DOC
 * @property string $DOU
 */
class CashInHand extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'cash_in_hand';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['employee_id', 'transaction_type', 'payment_type', 'appointment_id', 'debtor_id', 'status', 'CB', 'UB'], 'integer'],
            [['date', 'DOC', 'DOU'], 'safe'],
            [['amount', 'balance'], 'number'],
            [['comment'], 'string'],
            [['CB', 'UB', 'DOC'], 'required'],
            [['check_no'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'employee_id' => 'Employee ID',
            'date' => 'Date',
            'transaction_type' => 'Transaction Type',
            'payment_type' => 'Payment Type',
            'check_no' => 'Check No',
            'amount' => 'Amount',
            'balance' => 'Balance',
            'appointment_id' => 'Appointment ID',
            'debtor_id' => 'Debtor ID',
            'comment' => 'Comment',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

    public static function getTotal($model, $id) {
        $total = 0;
        foreach ($model as $value) {
            if ($value->transaction_type == $id) {
                $total += $value->amount;
            }
        }
        return $total;
    }

}
