<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "report_template".
 *
 * @property integer $id
 * @property integer $type
 * @property string $left_logo
 * @property string $right_logo
 * @property string $report_description
 * @property string $footer_content
 * @property integer $address
 * @property integer $bank
 * @property string $account_mannager_email
 * @property string $account_mannager_phone
 * @property integer $status
 * @property integer $CB
 * @property integer $UB
 * @property string $DOC
 * @property string $DOU
 */
class ReportTemplate extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'report_template';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['type'], 'required'],
            [['type', 'address', 'bank', 'status', 'CB', 'UB'], 'integer'],
            [['report_description', 'footer_content'], 'string'],
            [['DOC', 'DOU', 'default_address','tax_id'], 'safe'],
            [['left_logo', 'right_logo', 'account_mannager_email'], 'string', 'max' => 100],
            [['account_mannager_phone'], 'string', 'max' => 50],
            [['address', 'report_description', 'bank', 'account_mannager_email', 'account_mannager_phone', 'footer_content'], 'required', 'when' => function ($model) {
                    return $model->type == 1;
                }, 'whenClient' => "function (attribute, value) { return $('#id').val() == '0'; }"],
            [['bank', 'footer_content'], 'required', 'when' => function ($model) {
                    return $model->type == 2;
                }, 'whenClient' => "function (attribute, value) { return $('#id').val() == '0'; }"],
            [['left_logo', 'right_logo'], 'required', 'on' => 'create'],
//                [['left_logo','right_logo'], 'image', 'extensions' => 'jpg,png', 'skipOnEmpty' => 'skipOnEmpty' => !$this->isNewRecord],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'left_logo' => 'Left Logo',
            'right_logo' => 'Right Logo',
            'report_description' => 'Report Description',
            'footer_content' => 'Footer Content',
            'address' => 'Address',
            'default_address' => 'Set as Default Address',
            'bank' => 'Bank',
            'account_mannager_email' => 'Account Mannager Email',
            'account_mannager_phone' => 'Account Mannager Phone',
            'tax_id' => 'TAX / VAT ID',
             'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

}
