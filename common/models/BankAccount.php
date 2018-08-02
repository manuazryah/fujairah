<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bank_account".
 *
 * @property integer $id
 * @property string $name
 * @property string $accounnt_no
 * @property string $branch
 * @property string $ifsc_code
 * @property integer $status
 * @property integer $CB
 * @property integer $UB
 * @property string $DOC
 * @property string $DOU
 */
class BankAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bank_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['accounnt_no', 'branch', 'ifsc_code', 'CB', 'UB', 'DOC'], 'required'],
            [['status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['name', 'accounnt_no', 'branch', 'ifsc_code'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'accounnt_no' => 'Accounnt No',
            'branch' => 'Branch',
            'ifsc_code' => 'Ifsc Code',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }
}
