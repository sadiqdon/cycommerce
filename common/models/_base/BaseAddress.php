<?php
/**
 * This is the model base class for the table "address".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Address".
 *
 * The followings are the available columns in table 'address':
 * @property integer $id
 * @property integer $user_id
 * @property string $firstname
 * @property string $lastname
 * @property string $telephone
 * @property string $company
 * @property string $tax_id
 * @property string $address_1
 * @property string $address_2
 * @property string $city
 * @property string $postal_code
 * @property integer $country_id
 * @property integer $zone_id
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Country $country
 * @property Zone $zone
 */
abstract class BaseAddress extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Address the static model class
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
		return 'address';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, firstname, lastname, address_1, city, country_id, zone_id', 'required'),
			array('user_id, country_id, zone_id', 'numerical', 'integerOnly'=>true),
			array('firstname, lastname, telephone, company, tax_id', 'length', 'max'=>32),
			array('address_1, address_2, city', 'length', 'max'=>128),
			array('postal_code', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, firstname, lastname, telephone, company, tax_id, address_1, address_2, city, postal_code, country_id, zone_id', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
			'zone' => array(self::BELONGS_TO, 'Zone', 'zone_id'),
		);
	}

	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('label', 'ID'),
			'user_id' => Yii::t('label', 'User'),
			'firstname' => Yii::t('label', 'Firstname'),
			'lastname' => Yii::t('label', 'Lastname'),
			'telephone' => Yii::t('label', 'Telephone'),
			'company' => Yii::t('label', 'Company'),
			'tax_id' => Yii::t('label', 'Tax'),
			'address_1' => Yii::t('label', 'Address 1'),
			'address_2' => Yii::t('label', 'Address 2'),
			'city' => Yii::t('label', 'City'),
			'postal_code' => Yii::t('label', 'Postal Code'),
			'country_id' => Yii::t('label', 'Country'),
			'zone_id' => Yii::t('label', 'Zone'),
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('tax_id',$this->tax_id,true);
		$criteria->compare('address_1',$this->address_1,true);
		$criteria->compare('address_2',$this->address_2,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('postal_code',$this->postal_code,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('zone_id',$this->zone_id);
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