<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fda_report".
 *
 * @property integer $id
 * @property integer $appointment_id
 * @property string $estimate_id
 * @property integer $principal_id
 * @property string $invoice_number
 * @property string $sub_invoice
 * @property string $report
 * @property integer $status
 * @property integer $CB
 * @property integer $UB
 * @property string $DOC
 * @property string $DOU
 */
class FdaReport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fda_report';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['appointment_id', 'principal_id', 'status', 'CB', 'UB'], 'integer'],
            [['report'], 'string'],
            [['CB', 'UB', 'DOC'], 'required'],
            [['DOC', 'DOU'], 'safe'],
            [['estimate_id'], 'string', 'max' => 100],
            [['invoice_number', 'sub_invoice'], 'string', 'max' => 50],
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
            'estimate_id' => 'Estimate ID',
            'principal_id' => 'Principal ID',
            'invoice_number' => 'Invoice Number',
            'sub_invoice' => 'Sub Invoice',
            'report' => 'Report',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }
}
