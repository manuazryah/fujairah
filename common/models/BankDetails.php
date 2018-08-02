<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bank_details".
 *
 * @property integer $id
 * @property string $account_holder_name
 * @property string $account_no
 * @property string $iban
 * @property string $bank_name
 * @property string $swift
 * @property string $branch
 * @property string $correspontant_bank
 * @property integer $status
 * @property integer $CB
 * @property integer $UB
 * @property string $DOC
 * @property string $DOU
 */
class BankDetails extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'bank_details';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['account_holder_name', 'account_no', 'iban', 'bank_name', 'swift', 'branch', 'account_holder_name'], 'required'],
                [['status', 'CB', 'UB'], 'integer'],
                [['DOC', 'DOU'], 'safe'],
                [['account_holder_name', 'account_no', 'iban', 'bank_name', 'swift', 'branch'], 'string', 'max' => 100],
                [['correspontant_bank'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'account_holder_name' => 'Account Holder Name',
            'account_no' => 'Account No',
            'iban' => 'Iban',
            'bank_name' => 'Bank Name',
            'swift' => 'Swift',
            'branch' => 'Branch',
            'correspontant_bank' => 'Correspontant Bank',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

}
