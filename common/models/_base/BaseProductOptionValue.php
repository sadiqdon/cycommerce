<?php
/**
 * This is the model base class for the table "product_option_value".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ProductOptionValue".
 *
 * The followings are the available columns in table 'product_option_value':
 * @property integer $id
 * @property integer $product_option_id
 * @property integer $product_id
 * @property integer $option_id
 * @property integer $option_value_id
 * @property integer $quantity
 * @property integer $subtract
 * @property string $price
 * @property string $price_prefix
 * @property integer $points
 * @property string $points_prefix
 * @property string $weight
 * @property string $weight_prefix
 *
 * The followings are the available model relations:
 * @property ProductOption $productOption
 * @property Product $product
 * @property Option $option
 * @property OptionValue $optionValue
 */
abstract class BaseProductOptionValue extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProductOptionValue the static model class
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
		return 'product_option_value';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_option_id, product_id, option_id, option_value_id, quantity, subtract, price, price_prefix, weight, weight_prefix', 'required'),
			array('product_option_id, product_id, option_id, option_value_id, quantity, subtract, points', 'numerical', 'integerOnly'=>true),
			array('price, weight', 'length', 'max'=>15),
			array('price_prefix, points_prefix, weight_prefix', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, product_option_id, product_id, option_id, option_value_id, quantity, subtract, price, price_prefix, weight, weight_prefix', 'safe', 'on'=>'search'),
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
			'productOption' => array(self::BELONGS_TO, 'ProductOption', 'product_option_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
			'option' => array(self::BELONGS_TO, 'Option', 'option_id'),
			'optionValue' => array(self::BELONGS_TO, 'OptionValue', 'option_value_id'),
		);
	}

	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('label', 'ID'),
			'product_option_id' => Yii::t('label', 'Product Option'),
			'product_id' => Yii::t('label', 'Product'),
			'option_id' => Yii::t('label', 'Option'),
			'option_value_id' => Yii::t('label', 'Option Value'),
			'quantity' => Yii::t('label', 'Quantity'),
			'subtract' => Yii::t('label', 'Subtract'),
			'price' => Yii::t('label', 'Price'),
			'price_prefix' => Yii::t('label', 'Price Prefix'),
			'points' => Yii::t('label', 'Points'),
			'points_prefix' => Yii::t('label', 'Points Prefix'),
			'weight' => Yii::t('label', 'Weight'),
			'weight_prefix' => Yii::t('label', 'Weight Prefix'),
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
		$criteria->compare('product_option_id',$this->product_option_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('option_id',$this->option_id);
		$criteria->compare('option_value_id',$this->option_value_id);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('subtract',$this->subtract);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('price_prefix',$this->price_prefix,true);
		$criteria->compare('points',$this->points);
		$criteria->compare('points_prefix',$this->points_prefix,true);
		$criteria->compare('weight',$this->weight,true);
		$criteria->compare('weight_prefix',$this->weight_prefix,true);
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