<?php
/**
 * This is the model base class for the table "order".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Order".
 *
 * The followings are the available columns in table 'order':
 * @property integer $id
 * @property integer $invoice_no
 * @property string $invoice_prefix
 * @property integer $store_id
 * @property string $store_name
 * @property string $store_url
 * @property integer $customer_id
 * @property integer $customer_group_id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $telephone
 * @property string $fax
 * @property string $payment_firstname
 * @property string $payment_lastname
 * @property string $payment_company
 * @property string $payment_company_id
 * @property string $payment_tax_id
 * @property string $payment_address_1
 * @property string $payment_address_2
 * @property string $payment_city
 * @property string $payment_postcode
 * @property string $payment_country
 * @property integer $payment_country_id
 * @property string $payment_zone
 * @property integer $payment_zone_id
 * @property string $payment_address_format
 * @property string $payment_method
 * @property string $payment_code
 * @property string $shipping_firstname
 * @property string $shipping_lastname
 * @property string $shipping_company
 * @property string $shipping_address_1
 * @property string $shipping_address_2
 * @property string $shipping_city
 * @property string $shipping_postcode
 * @property string $shipping_country
 * @property integer $shipping_country_id
 * @property string $shipping_zone
 * @property integer $shipping_zone_id
 * @property string $shipping_address_format
 * @property string $shipping_method
 * @property string $shipping_code
 * @property string $total
 * @property integer $order_status_id
 * @property integer $currency_id
 * @property string $currency_code
 * @property string $currency_value
 * @property string $ip
 * @property integer $check
 * @property string $forwarded_ip
 * @property string $user_agent
 * @property string $accept_language
 * @property string $date_added
 * @property string $date_modified
 *
 * The followings are the available model relations:
 * @property OrderDescription[] $orderDescriptions
 * @property OrderHistory[] $orderHistories
 * @property OrderOption[] $orderOptions
 * @property OrderProduct[] $orderProducts
 * @property OrderTotal[] $orderTotals
 */
abstract class BaseOrder extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Order the static model class
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
		return 'order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('store_name, store_url, firstname, lastname, email, telephone, payment_firstname, payment_lastname, payment_tax_id, payment_address_1, payment_city, payment_country, payment_country_id, payment_zone, payment_zone_id, payment_method, payment_code, shipping_firstname, shipping_lastname, shipping_address_1, shipping_city, shipping_country, shipping_country_id, shipping_zone, shipping_zone_id, shipping_method', 'required'),
			array('invoice_no, store_id, customer_id, customer_group_id, payment_country_id, payment_zone_id, shipping_country_id, shipping_zone_id, order_status_id, currency_id', 'numerical', 'integerOnly'=>true),
			array('invoice_prefix', 'length', 'max'=>26),
			array('store_name', 'length', 'max'=>64),
			array('store_url, user_agent, accept_language', 'length', 'max'=>255),
			array('firstname, lastname, telephone, fax, payment_firstname, payment_lastname, payment_company, payment_company_id, payment_tax_id, shipping_firstname, shipping_lastname, shipping_company', 'length', 'max'=>32),
			array('email', 'length', 'max'=>96),
			array('payment_address_1, payment_address_2, payment_city, payment_country, payment_zone, payment_method, payment_code, shipping_address_1, shipping_address_2, shipping_city, shipping_country, shipping_zone, shipping_method, shipping_code', 'length', 'max'=>128),
			array('payment_postcode, shipping_postcode', 'length', 'max'=>10),
			array('total, currency_value', 'length', 'max'=>15),
			array('currency_code', 'length', 'max'=>3),
			array('ip, forwarded_ip', 'length', 'max'=>40),
			array('date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
			array('date_added','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, invoice_no, invoice_prefix, store_id, store_name, store_url, customer_id, customer_group_id, firstname, lastname, email, telephone, fax, payment_firstname, payment_lastname, payment_company, payment_company_id, payment_tax_id, payment_address_1, payment_address_2, payment_city, payment_postcode, payment_country, payment_country_id, payment_zone, payment_zone_id, payment_address_format, payment_method, payment_code, shipping_firstname, shipping_lastname, shipping_company, shipping_address_1, shipping_address_2, shipping_city, shipping_postcode, shipping_country, shipping_country_id, shipping_zone, shipping_zone_id, shipping_address_format, shipping_method, shipping_code, total, order_status_id, currency_id, currency_code, currency_value, ip, forwarded_ip, user_agent, accept_language, date_added, date_modified', 'safe', 'on'=>'search'),
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
			'orderDescriptions' => array(self::HAS_MANY, 'OrderDescription', 'order_id', 'condition' => 'orderDescriptions.locale_code = \''.$localeCode.'\''),
			'orderStatus'=> array(self::BELONGS_TO, 'OrderStatus', 'order_status_id'),
			'orderHistories' => array(self::HAS_MANY, 'OrderHistory', 'order_id'),
			'orderOptions' => array(self::HAS_MANY, 'OrderOption', 'order_id'),
			'orderProducts' => array(self::HAS_MANY, 'OrderProduct', 'order_id'),
			'orderTotals' => array(self::HAS_MANY, 'OrderTotal', 'order_id'),
		);
	}

	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('label', 'ID'),
			'invoice_no' => Yii::t('label', 'Invoice No'),
			'invoice_prefix' => Yii::t('label', 'Invoice Prefix'),
			'store_id' => Yii::t('label', 'Store'),
			'store_name' => Yii::t('label', 'Store Name'),
			'store_url' => Yii::t('label', 'Store Url'),
			'customer_id' => Yii::t('label', 'Customer'),
			'customer_group_id' => Yii::t('label', 'Customer Group'),
			'firstname' => Yii::t('label', 'Firstname'),
			'lastname' => Yii::t('label', 'Lastname'),
			'email' => Yii::t('label', 'Email'),
			'telephone' => Yii::t('label', 'Telephone'),
			'fax' => Yii::t('label', 'Fax'),
			'payment_firstname' => Yii::t('label', 'Payment Firstname'),
			'payment_lastname' => Yii::t('label', 'Payment Lastname'),
			'payment_company' => Yii::t('label', 'Payment Company'),
			'payment_company_id' => Yii::t('label', 'Payment Company'),
			'payment_tax_id' => Yii::t('label', 'Payment Tax'),
			'payment_address_1' => Yii::t('label', 'Payment Address 1'),
			'payment_address_2' => Yii::t('label', 'Payment Address 2'),
			'payment_city' => Yii::t('label', 'Payment City'),
			'payment_postcode' => Yii::t('label', 'Payment Postcode'),
			'payment_country' => Yii::t('label', 'Payment Country'),
			'payment_country_id' => Yii::t('label', 'Payment Country'),
			'payment_zone' => Yii::t('label', 'Payment Zone'),
			'payment_zone_id' => Yii::t('label', 'Payment Zone'),
			'payment_address_format' => Yii::t('label', 'Payment Address Format'),
			'payment_method' => Yii::t('label', 'Payment Method'),
			'payment_code' => Yii::t('label', 'Payment Code'),
			'shipping_firstname' => Yii::t('label', 'Shipping Firstname'),
			'shipping_lastname' => Yii::t('label', 'Shipping Lastname'),
			'shipping_company' => Yii::t('label', 'Shipping Company'),
			'shipping_address_1' => Yii::t('label', 'Shipping Address 1'),
			'shipping_address_2' => Yii::t('label', 'Shipping Address 2'),
			'shipping_city' => Yii::t('label', 'Shipping City'),
			'shipping_postcode' => Yii::t('label', 'Shipping Postcode'),
			'shipping_country' => Yii::t('label', 'Shipping Country'),
			'shipping_country_id' => Yii::t('label', 'Shipping Country'),
			'shipping_zone' => Yii::t('label', 'Shipping Zone'),
			'shipping_zone_id' => Yii::t('label', 'Shipping Zone'),
			'shipping_address_format' => Yii::t('label', 'Shipping Address Format'),
			'shipping_method' => Yii::t('label', 'Shipping Method'),
			'shipping_code' => Yii::t('label', 'Shipping Code'),
			'total' => Yii::t('label', 'Total'),
			'order_status_id' => Yii::t('label', 'Order Status'),
			'currency_id' => Yii::t('label', 'Currency'),
			'currency_code' => Yii::t('label', 'Currency Code'),
			'currency_value' => Yii::t('label', 'Currency Value'),
			'ip' => Yii::t('label', 'Ip'),
			'forwarded_ip' => Yii::t('label', 'Forwarded Ip'),
			'user_agent' => Yii::t('label', 'User Agent'),
			'accept_language' => Yii::t('label', 'Accept Language'),
			'date_added' => Yii::t('label', 'Date Added'),
			'date_modified' => Yii::t('label', 'Date Modified'),
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
		$criteria->compare('invoice_no',$this->invoice_no);
		$criteria->compare('invoice_prefix',$this->invoice_prefix,true);
		$criteria->compare('store_id',$this->store_id);
		$criteria->compare('store_name',$this->store_name,true);
		$criteria->compare('store_url',$this->store_url,true);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('customer_group_id',$this->customer_group_id);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('payment_firstname',$this->payment_firstname,true);
		$criteria->compare('payment_lastname',$this->payment_lastname,true);
		$criteria->compare('payment_company',$this->payment_company,true);
		$criteria->compare('payment_company_id',$this->payment_company_id,true);
		$criteria->compare('payment_tax_id',$this->payment_tax_id,true);
		$criteria->compare('payment_address_1',$this->payment_address_1,true);
		$criteria->compare('payment_address_2',$this->payment_address_2,true);
		$criteria->compare('payment_city',$this->payment_city,true);
		$criteria->compare('payment_postcode',$this->payment_postcode,true);
		$criteria->compare('payment_country',$this->payment_country,true);
		$criteria->compare('payment_country_id',$this->payment_country_id);
		$criteria->compare('payment_zone',$this->payment_zone,true);
		$criteria->compare('payment_zone_id',$this->payment_zone_id);
		$criteria->compare('payment_address_format',$this->payment_address_format,true);
		$criteria->compare('payment_method',$this->payment_method,true);
		$criteria->compare('payment_code',$this->payment_code,true);
		$criteria->compare('shipping_firstname',$this->shipping_firstname,true);
		$criteria->compare('shipping_lastname',$this->shipping_lastname,true);
		$criteria->compare('shipping_company',$this->shipping_company,true);
		$criteria->compare('shipping_address_1',$this->shipping_address_1,true);
		$criteria->compare('shipping_address_2',$this->shipping_address_2,true);
		$criteria->compare('shipping_city',$this->shipping_city,true);
		$criteria->compare('shipping_postcode',$this->shipping_postcode,true);
		$criteria->compare('shipping_country',$this->shipping_country,true);
		$criteria->compare('shipping_country_id',$this->shipping_country_id);
		$criteria->compare('shipping_zone',$this->shipping_zone,true);
		$criteria->compare('shipping_zone_id',$this->shipping_zone_id);
		$criteria->compare('shipping_address_format',$this->shipping_address_format,true);
		$criteria->compare('shipping_method',$this->shipping_method,true);
		$criteria->compare('shipping_code',$this->shipping_code,true);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('order_status_id',$this->order_status_id);
		$criteria->compare('currency_id',$this->currency_id);
		$criteria->compare('currency_code',$this->currency_code,true);
		$criteria->compare('currency_value',$this->currency_value,true);
		$criteria->compare('check',$this->check);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('forwarded_ip',$this->forwarded_ip,true);
		$criteria->compare('user_agent',$this->user_agent,true);
		$criteria->compare('accept_language',$this->accept_language,true);
		$criteria->compare('date_added',$this->date_added,true);
		$criteria->compare('date_modified',$this->date_modified,true);
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