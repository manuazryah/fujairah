<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "port_call_comment".
 *
 * @property integer $id
 * @property integer $appointment_id
 * @property integer $user_id
 * @property string $comment
 * @property integer $status
 * @property integer $CB
 * @property integer $UB
 * @property string $DOC
 * @property string $DOU
 */
class PortCallComment extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'port_call_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['appointment_id', 'user_id', 'status', 'CB', 'UB', 'assigned_to', 'department'], 'integer'],
            [['comment'], 'string'],
            [['DOC', 'DOU', 'comment_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'appointment_id' => 'Appointment ID',
            'user_id' => 'User ID',
            'comment' => 'Comment',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

}
