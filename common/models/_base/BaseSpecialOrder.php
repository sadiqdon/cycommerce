<?php
/**
 * This is the model base class for the table "special_order".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "SpecialOrder".
 *
 * The followings are the available columns in table 'special_order':
 * @property string $id
 * @property string $product_name
 * @property string $product_quantity
 * @property string $product_colour
 * @property string $specification
 * @property string $comment
 */
abstract class BaseSpecialOrder extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SpecialOrder the static model class
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
		return 'special_order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_name, product_quantity, product_colour, specification, order_status_id', 'required'),
			array('product_name, product_colour', 'length', 'max'=>100),
			array('product_quantity', 'length', 'max'=>10),
			array('firstname, lastname, telephone', 'length', 'max'=>32),
			array('email', 'length', 'max'=>255),
			array('address_1, address_2, city, country_id, zone_id, payment_code', 'length', 'max'=>128),
			array('postal_code', 'length', 'max'=>10),
			array('total', 'length', 'max'=>15),
			array('ip, forwarded_ip', 'length', 'max'=>40),
			array('date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
			array('date_added','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, product_name, product_quantity, product_colour, specification, comment, firstname, lastname, email, telephone, address_1, address_2, city, country_id, zone_id, payment_code', 'safe', 'on'=>'search'),
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
			'orderStatus'=> array(self::BELONGS_TO, 'OrderStatus', 'order_status_id'),
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
			'product_name' => Yii::t('label', 'Product Name'),
			'product_quantity' => Yii::t('label', 'Product Quantity'),
			'product_colour' => Yii::t('label', 'Product Colour'),
			'specification' => Yii::t('label', 'Specification'),
			'comment' => Yii::t('label', 'Comment'),
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
		$criteria->compare('product_name',$this->product_name,true);
		$criteria->compare('product_quantity',$this->product_quantity,true);
		$criteria->compare('product_colour',$this->product_colour,true);
		$criteria->compare('specification',$this->specification,true);
		$criteria->compare('comment',$this->comment,true);
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