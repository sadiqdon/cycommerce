<?php
/**
 * This is the model base class for the table "payment_transaction".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "PaymentTransaction".
 *
 * The followings are the available columns in table 'payment_transaction':
 * @property integer $id
 * @property string $type
 * @property string $transaction_date
 * @property string $reference_number
 * @property string $payment_reference
 * @property string $approved_amount
 * @property string $response_description
 * @property string $response_code
 * @property string $transaction_amount
 * @property string $customer_name
 * @property string $order_id
 * @property string $query_date
 * @property string $query_code
 */
abstract class BasePaymentTransaction extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PaymentTransaction the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'payment_transaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('reference_number, response_code, transaction_amount, customer_name, order_id', 'required'),
			array('reference_number, payment_reference, customer_name, type', 'length', 'max'=>50),
			array('approved_amount, transaction_amount', 'length', 'max'=>20),
			array('response_description', 'length', 'max'=>100),
			array('response_code', 'length', 'max'=>50),
			array('order_id', 'length', 'max'=>20),
			array('query_code', 'length', 'max'=>250),
			array('reference_number', 'unique', 'message' => Yii::t("branch","This reference code already exists.")),
			array('transaction_date', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => false, 'on' => 'insert'),
			array('query_date', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => false, 'on' => 'update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, transaction_date, reference_number, payment_reference, approved_amount, response_description, response_code, transaction_amount, customer_name, order_id, query_date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.

		$localeCode = Yii::app()->getLanguage(); 

		return array(
		);
	}

	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('label', 'ID'),
			'type' => Yii::t('label', 'Type'),
			'transaction_date' => Yii::t('label', 'Transaction Date'),
			'reference_number' => Yii::t('label', 'Reference Number'),
			'payment_reference' => Yii::t('label', 'Payment Reference'),
			'query_code' => Yii::t('label', 'Query Code'),
			'approved_amount' => Yii::t('label', 'Approved Amount'),
			'response_description' => Yii::t('label', 'Response Description'),
			'response_code' => Yii::t('label', 'Response Code'),
			'transaction_amount' => Yii::t('label', 'Transaction Amount'),
			'customer_name' => Yii::t('label', 'Customer Name'),
			'order_id' => Yii::t('label', 'Order'),
			'query_date' => Yii::t('label', 'Query Date'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('type',$this->transaction_date,true);
		$criteria->compare('transaction_date',$this->transaction_date,true);
		$criteria->compare('reference_number',$this->reference_number,true);
		$criteria->compare('payment_reference',$this->payment_reference,true);
		$criteria->compare('approved_amount',$this->approved_amount,true);
		$criteria->compare('response_description',$this->response_description,true);
		$criteria->compare('response_code',$this->response_code,true);
		$criteria->compare('transaction_amount',$this->transaction_amount,true);
		$criteria->compare('customer_name',$this->customer_name,true);
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('query_date',$this->query_date,true);
		$criteria->compare('query_code',$this->query_code,true);
		$dorder = '';
		if($this->hasAttribute('sort_order')){
			$dorder = 't.sort_order ASC';
		}
		else if($this->hasAttribute('id')){
			$dorder = 't.id DESC';
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
					'defaultOrder' => $dorder,
					'attributes' => array(			
							'*',
					),
			),		
        	'pagination'=>array(
				'pageSize'=>100,
			),
		));
	}
}