<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "funding_master".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $payment_type
 * @property integer $bank_account
 * @property string $reference_id
 * @property string $credit_amount
 * @property string $debit_amount
 * @property integer $journal_type
 * @property string $comment
 * @property string $date
 * @property integer $status
 * @property integer $CB
 * @property integer $UB
 * @property integer $DOC
 * @property string $DOU
 */
class FundingMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'funding_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'payment_type', 'bank_account', 'journal_type', 'status', 'CB', 'UB', 'DOC'], 'integer'],
            [['credit_amount', 'debit_amount'], 'number'],
            [['comment'], 'string'],
            [['date', 'DOU'], 'safe'],
            [['reference_id'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'payment_type' => 'Payment Type',
            'bank_account' => 'Bank Account',
            'reference_id' => 'Reference ID',
            'credit_amount' => 'Credit Amount',
            'debit_amount' => 'Debit Amount',
            'journal_type' => 'Journal Type',
            'comment' => 'Comment',
            'date' => 'Date',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }
}
