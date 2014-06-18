<?php
/**
 * This is the model base class for the table "return".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Returns".
 *
 * The followings are the available columns in table 'return':
 * @property string $id
 * @property string $orderId
 * @property string $customerID
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $telephone
 * @property string $productid
 * @property string $model
 * @property string $quantity
 * @property string $return_reason
 * @property string $opened
 * @property string $comment
 * @property string $return_action
 * @property string $return_status
 * @property string $date_added
 * @property string $date_modified
 */
abstract class BaseReturns extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Returns the static model class
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
		return 'returns';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('orderId, firstname, lastname, email, telephone, productid, model, quantity, comment', 'required'),
			array('orderId, customerID, productid, quantity', 'length', 'max'=>10),
			array('firstname, lastname', 'length', 'max'=>40),
			array('email, telephone', 'length', 'max'=>70),
			array('model', 'length', 'max'=>50),
			array('return_reason', 'length', 'max'=>15),
			array('opened', 'length', 'max'=>3),
			array('return_action', 'length', 'max'=>16),
			array('return_status', 'length', 'max'=>17),
			array('date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
			array('date_added','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, orderId, customerID, firstname, lastname, email, telephone, productid, model, quantity, return_reason, opened, comment, return_action, return_status, date_added, date_modified', 'safe', 'on'=>'search'),
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
			'orderId' => Yii::t('label', 'Order'),
			'customerID' => Yii::t('label', 'Customer ID'),
			'firstname' => Yii::t('label', 'Firstname'),
			'lastname' => Yii::t('label', 'Lastname'),
			'email' => Yii::t('label', 'Email'),
			'telephone' => Yii::t('label', 'Telephone'),
			'productid' => Yii::t('label', 'Productid'),
			'model' => Yii::t('label', 'Model'),
			'quantity' => Yii::t('label', 'Quantity'),
			'return_reason' => Yii::t('label', 'Return Reason'),
			'opened' => Yii::t('label', 'Opened'),
			'comment' => Yii::t('label', 'Comment'),
			'return_action' => Yii::t('label', 'Return Action'),
			'return_status' => Yii::t('label', 'Return Status'),
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
		$criteria->compare('id',$this->id,true);
		$criteria->compare('orderId',$this->orderId,true);
		$criteria->compare('customerID',$this->customerID,true);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('productid',$this->productid,true);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('quantity',$this->quantity,true);
		$criteria->compare('return_reason',$this->return_reason,true);
		$criteria->compare('opened',$this->opened,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('return_action',$this->return_action,true);
		$criteria->compare('return_status',$this->return_status,true);
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