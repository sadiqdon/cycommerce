<?php
/**
 * This is the model base class for the table "country".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Country".
 *
 * The followings are the available columns in table 'country':
 * @property integer $id
 * @property string $name
 * @property string $iso_code_2
 * @property string $iso_code_3
 * @property string $address_format
 * @property integer $postcode_required
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Address[] $addresses
 * @property Zone[] $zones
 * @property ZoneGeoZone[] $zoneGeoZones
 */
abstract class BaseCountry extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Country the static model class
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
		return 'country';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, iso_code_2, iso_code_3, address_format, postcode_required', 'required'),
			array('postcode_required, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>128),
			array('iso_code_2', 'length', 'max'=>2),
			array('iso_code_3', 'length', 'max'=>3),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, iso_code_2, iso_code_3, address_format, postcode_required, status', 'safe', 'on'=>'search'),
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
			'addresses' => array(self::HAS_MANY, 'Address', 'country_id'),
			'zones' => array(self::HAS_MANY, 'Zone', 'country_id'),
			'zoneGeoZones' => array(self::HAS_MANY, 'ZoneGeoZone', 'country_id'),
		);
	}

	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('label', 'ID'),
			'name' => Yii::t('label', 'Name'),
			'iso_code_2' => Yii::t('label', 'Iso Code 2'),
			'iso_code_3' => Yii::t('label', 'Iso Code 3'),
			'address_format' => Yii::t('label', 'Address Format'),
			'postcode_required' => Yii::t('label', 'Postcode Required'),
			'status' => Yii::t('label', 'Status'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('iso_code_2',$this->iso_code_2,true);
		$criteria->compare('iso_code_3',$this->iso_code_3,true);
		$criteria->compare('address_format',$this->address_format,true);
		$criteria->compare('postcode_required',$this->postcode_required);
		$criteria->compare('status',$this->status);
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