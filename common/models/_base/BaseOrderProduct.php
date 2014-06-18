<?php
/**
 * This is the model base class for the table "order_product".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "OrderProduct".
 *
 * The followings are the available columns in table 'order_product':
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property string $name
 * @property string $model
 * @property integer $quantity
 * @property string $price
 * @property string $total
 * @property string $tax
 * @property integer $reward
 *
 * The followings are the available model relations:
 * @property OrderOption[] $orderOptions
 * @property Product $product
 * @property Order $order
 */
abstract class BaseOrderProduct extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderProduct the static model class
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
		return 'order_product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, product_id, name, model, quantity', 'required'),
			array('order_id, product_id, quantity, reward', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('model', 'length', 'max'=>64),
			array('price, total, tax', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, order_id, product_id, name, model, quantity, price, total, tax, reward', 'safe', 'on'=>'search'),
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
			'orderOptions' => array(self::HAS_MANY, 'OrderOption', 'order_product_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
			'order' => array(self::BELONGS_TO, 'Order', 'order_id'),
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
			'product_id' => Yii::t('label', 'Product'),
			'name' => Yii::t('label', 'Name'),
			'model' => Yii::t('label', 'Model'),
			'quantity' => Yii::t('label', 'Quantity'),
			'price' => Yii::t('label', 'Price'),
			'total' => Yii::t('label', 'Total'),
			'tax' => Yii::t('label', 'Tax'),
			//'reward' => Yii::t('label', 'Reward'),
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
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('tax',$this->tax,true);
		//$criteria->compare('reward',$this->reward);
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