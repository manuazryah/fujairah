<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "addresses".
 *
 * @property integer $id
 * @property string $tittle
 * @property string $main_office_address
 * @property string $port_office_address
 * @property string $contact_details
 * @property string $emergency_contact_details
 * @property integer $status
 * @property integer $CB
 * @property integer $UB
 * @property string $DOC
 * @property string $DOU
 */
class Addresses extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'addresses';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['tittle', 'main_office_address', 'port_office_address', 'contact_details', 'emergency_contact_details'], 'required'],
            [['main_office_address', 'port_office_address', 'contact_details', 'emergency_contact_details'], 'string'],
            [['status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['tittle'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'tittle' => 'Tittle',
            'main_office_address' => 'Main Office Address',
            'port_office_address' => 'Port Office Address',
            'contact_details' => 'Contact Details',
            'emergency_contact_details' => 'Emergency Contact Details',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

}
