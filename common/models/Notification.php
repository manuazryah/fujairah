<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property integer $id
 * @property integer $notification_type
 * @property integer $appointment_id
 * @property string $content
 * @property integer $status
 */
class Notification extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['notification_type', 'appointment_id', 'status'], 'integer'],
            [['content'], 'string'],
            [['date', 'appointment_no', 'message'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'notification_type' => 'Notification Type',
            'appointment_id' => 'Appointment ID',
            'content' => 'Content',
            'message' => 'Message',
            'status' => 'Status',
        ];
    }

}
