<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profile_uploads".
 *
 * @property integer $id
 * @property integer $employee_id
 * @property string $label
 * @property string $file
 * @property string $expiry_date
 * @property integer $status
 * @property integer $CB
 * @property integer $UB
 * @property string $DOC
 * @property string $DOU
 */
class ProfileUploads extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_uploads';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id', 'status', 'CB', 'UB'], 'integer'],
            [['expiry_date', 'DOC', 'DOU'], 'safe'],
            [['label', 'file'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_id' => 'Employee ID',
            'label' => 'Label',
            'file' => 'File',
            'expiry_date' => 'Expiry Date',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }
}
