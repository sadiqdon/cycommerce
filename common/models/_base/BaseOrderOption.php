<?php
/**
 * This is the model base class for the table "order_option".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "OrderOption".
 *
 * The followings are the available columns in table 'order_option':
 * @property integer $id
 * @property integer $order_id
 * @property integer $order_product_id
 * @property integer $product_option_id
 * @property integer $product_option_value_id
 * @property string $name
 * @property string $value
 * @property string $type
 *
 * The followings are the available model relations:
 * @property ProductOptionValue $productOptionValue
 * @property Order $order
 * @property OrderProduct $orderProduct
 * @property ProductOption $productOption
 */
abstract class BaseOrderOption extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderOption the static model class
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
		return 'order_option';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, order_product_id, product_option_id, name, type', 'required'),
			array('order_id, order_product_id, product_option_id, product_option_value_id', 'numerical', 'integerOnly'=>true),
			array('value', 'safe'),
			array('name', 'length', 'max'=>255),
			array('type', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, order_id, order_product_id, product_option_id, product_option_value_id, name, type', 'safe', 'on'=>'search'),
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
			'productOptionValue' => array(self::BELONGS_TO, 'ProductOptionValue', 'product_option_value_id'),
			'order' => array(self::BELONGS_TO, 'Order', 'order_id'),
			'orderProduct' => array(self::BELONGS_TO, 'OrderProduct', 'order_product_id'),
			'productOption' => array(self::BELONGS_TO, 'ProductOption', 'product_option_id'),
		);
	}

	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('label', 'ID'),
			'order_id' => Yii::t('label', 'Order'),
			'order_product_id' => Yii::t('label', 'Order Product'),
			'product_option_id' => Yii::t('label', 'Product Option'),
			'product_option_value_id' => Yii::t('label', 'Product Option Value'),
			'name' => Yii::t('label', 'Name'),
			'value' => Yii::t('label', 'Value'),
			'type' => Yii::t('label', 'Type'),
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
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('order_product_id',$this->order_product_id);
		$criteria->compare('product_option_id',$this->product_option_id);
		$criteria->compare('product_option_value_id',$this->product_option_value_id);
		$criteria->compare('name',$this->name,true);
		//$criteria->compare('value',$this->value,true);
		$criteria->compare('type',$this->type,true);
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