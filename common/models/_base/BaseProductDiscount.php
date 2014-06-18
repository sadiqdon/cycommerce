<?php
/**
 * This is the model base class for the table "product_discount".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ProductDiscount".
 *
 * The followings are the available columns in table 'product_discount':
 * @property integer $id
 * @property integer $product_id
 * @property integer $c_group_id
 * @property integer $quantity
 * @property integer $priority
 * @property string $price
 * @property string $date_start
 * @property string $date_end
 *
 * The followings are the available model relations:
 * @property Product $product
 * @property CGroup $cGroup
 */
abstract class BaseProductDiscount extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProductDiscount the static model class
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
		return 'product_discount';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, c_group_id', 'required'),
			array('product_id, c_group_id, quantity, priority', 'numerical', 'integerOnly'=>true),
			array('price', 'length', 'max'=>15),
			array('date_start, date_end', 'safe'),
			array('date_start, date_end', 'default', 'value' => null),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, product_id, c_group_id, quantity, priority, price, date_start, date_end', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
			'cGroup' => array(self::BELONGS_TO, 'CGroup', 'c_group_id'),
		);
	}

	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('label', 'ID'),
			'product_id' => Yii::t('label', 'Product'),
			'c_group_id' => Yii::t('label', 'C Group'),
			'quantity' => Yii::t('label', 'Quantity'),
			'priority' => Yii::t('label', 'Priority'),
			'price' => Yii::t('label', 'Price'),
			'date_start' => Yii::t('label', 'Date Start'),
			'date_end' => Yii::t('label', 'Date End'),
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
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('c_group_id',$this->c_group_id);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('date_start',$this->date_start,true);
		$criteria->compare('date_end',$this->date_end,true);
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