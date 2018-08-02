<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "appointment".
 *
 * @property integer $id
 * @property integer $vessel_type
 * @property integer $vessel
 * @property integer $port_of_call
 * @property integer $terminal
 * @property string $birth_no
 * @property string $appointment_no
 * @property string $no_of_principal
 * @property integer $principal
 * @property integer $nominator
 * @property integer $charterer
 * @property integer $shipper
 * @property string $purpose
 * @property string $cargo
 * @property string $quantity
 * @property string $last_port
 * @property string $next_port
 * @property string $eta
 * @property integer $stage
 * @property integer $status
 * @property integer $CB
 * @property integer $UB
 * @property string $DOC
 * @property string $DOU
 */
class Appointment extends \yii\db\ActiveRecord {
    
    public $invoice_no;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'appointment';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['vessel_type', 'port_of_call', 'eta', 'principal'], 'required'],
            [['vessel_type', 'vessel', 'port_of_call', 'tug', 'barge', 'nominator', 'terminal', 'charterer', 'shipper', 'stage', 'sub_stages', 'status', 'CB', 'UB', 'estimate_status', 'currency'], 'integer'],
            [['DOC', 'DOU', 'cargo_details', 'USD', 'client_reference', 'epda_content', 'final_draft_bl', 'quantity'], 'safe'],
            [['birth_no', 'appointment_no'], 'string', 'max' => 50],
            [['no_of_principal'], 'string', 'max' => 15],
            [['purpose', 'last_port', 'next_port'], 'string', 'max' => 200],
            [['cargo'], 'string', 'max' => 100],
            [['appointment_no'], 'unique'],
            ['eta', 'date', 'format' => 'yyyy-M-d H:m'],
            [['final_draft_bl'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf,txt,doc,docx,xls,xlsx,msg,zip,eml, jpg, jpeg, png', 'on' => 'create'],
            [['final_draft_bl'], 'file', 'skipOnEmpty' => FALSE, 'extensions' => 'pdf,txt,doc,docx,xls,xlsx,msg,zip,eml, jpg, jpeg, png', 'on' => 'update'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'vessel_type' => 'Vessel Type',
            'vessel' => 'Vessel',
            'tug' => 'Tug',
            'barge' => 'Barge',
            'port_of_call' => 'Port Of Call',
            'terminal' => 'Terminal',
            'birth_no' => 'Berth No',
            'appointment_no' => 'Appointment No',
            'no_of_principal' => 'No Of Principal',
            'principal' => 'Principal',
            'nominator' => 'Nominator',
            'charterer' => 'Charterer',
            'shipper' => 'Shipper',
            'purpose' => 'Purpose',
            'cargo' => 'Cargo',
            'cargo_details' => 'Cargo Details',
            'quantity' => 'Quantity',
            'last_port' => 'Last Port',
            'next_port' => 'Next Port',
            'eta' => 'ETA',
            'client_reference' => 'Voyage Number',
            'stage' => 'Stage',
            'estimate_status' => 'Estimate Status',
            'final_draft_bl' => 'Final Draft BL',
            'epda_content' => 'EPDA Content',
            'sub_stages' => 'Sub Stages',
            'currency' => 'Currency',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

    public function getVessel0() {
        return $this->hasOne(Vessel::className(), ['id' => 'vessel_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVesselType() {
        return $this->hasOne(VesselType::className(), ['id' => 'vessel_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortOfCall() {
        return $this->hasOne(Ports::className(), ['id' => 'port_of_call']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurpose0() {
        return $this->hasOne(Purpose::className(), ['id' => 'purpose']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerminal0() {
        return $this->hasOne(Terminal::className(), ['id' => 'terminal']);
    }

    public function getDebtorName($debtor_id) {
        $data = Debtor::findOne(['id' => $debtor_id]);
        return $data->principal_name;
    }

    public function getInvoiceAddress($principal) {
        $data = Debtor::findOne(['id' => $principal]);
        return $data->invoicing_address;
    }

    public function getDebtorTax($debtor_id) {
        $data = Debtor::findOne(['id' => $debtor_id]);
        if ($data->tax != '') {
            return 'VAT / TAX ID : ' . $data->tax;
        } else {
            return '';
        }
    }

    public function getClintCode($principal) {
        $data = Debtor::findOne(['id' => $principal]);
        return $data->principal_id;
    }

    public function getClintRef($principal) {
        $data = Debtor::findOne(['id' => $principal]);
        return $data->principal_ref_no;
    }

    public function getStages0() {
        return $this->hasOne(Stages::className(), ['id' => 'stage']);
    }

    public function getEpdaAddress($debtor_id) {
        $data = Debtor::findOne(['id' => $debtor_id]);
        return $data->epda_address;
    }

    public static function getPrincip($id) {

        $princip = explode(',', $id);
        $result = '';
        $i = 0;
        if (!empty($princip)) {
            foreach ($princip as $val) {

                if ($i != 0) {
                    $result .= ',';
                }
                $principals = Debtor::findOne($val);
                $result .= $principals->principal_id;
                $i++;
            }
        }

        return $result;
    }
    
    public static function getInvoiceNo($id) {
        $fda_report = FdaReport::find()->where(['appointment_id' => $id])->all();
        $result = '';
        $i = 0;
        if (!empty($fda_report)) {
            foreach ($fda_report as $value) {
                if ($i != 0) {
                    $result .= ',<br/>';
                }
               $result .= \yii\helpers\Html::a($value->invoice_number, ['/appointment/close-estimate/show-all-report', 'id' => $value->id], ['target' => '_blank']);
                $i++;
            }
        }
        return $result;
    }

    public function getArrivalInfo() {
        return $this->hasOne(PortCallData::className(), ['appointment_id' => 'id']);
    }

    public function getCastoffInfo() {
        return $this->hasOne(PortCallData::className(), ['appointment_id' => 'id']);
    }

}
