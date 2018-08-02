<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "petty_cash_book".
 *
 * @property integer $id
 * @property integer $appointment_id
 * @property integer $employee_id
 * @property string $description
 * @property string $type
 * @property string $payment_type
 * @property string $check_no
 * @property string $amount
 * @property double $outstanding
 * @property string $fund_date
 * @property integer $status
 * @property integer $CB
 * @property integer $UB
 * @property string $DOC
 * @property string $DOU
 */
class PettyCashBook extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'petty_cash_book';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['appointment_id', 'employee_id', 'status', 'CB', 'UB'], 'integer'],
            [['amount', 'outstanding'], 'number'],
            [['fund_date', 'DOC', 'DOU'], 'safe'],
            [['CB', 'UB', 'DOC'], 'required'],
            [['description'], 'string', 'max' => 200],
            [['type', 'payment_type', 'check_no'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'appointment_id' => 'Appointment ID',
            'employee_id' => 'Employee ID',
            'description' => 'Description',
            'type' => 'Type',
            'payment_type' => 'Payment Type',
            'check_no' => 'Check No',
            'amount' => 'Amount',
            'outstanding' => 'Outstanding',
            'fund_date' => 'Fund Date',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }
}
