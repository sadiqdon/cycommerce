<?php
/**
 * This is the model base class for the table "product".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $id
 * @property string $model
 * @property string $sku
 * @property string $upc
 * @property string $ean
 * @property string $jan
 * @property string $isbn
 * @property string $mpn
 * @property string $location
 * @property integer $quantity
 * @property integer $stock_status_id
 * @property string $image
 * @property integer $manufacturer_id
 * @property integer $shipping
 * @property string $price
 * @property integer $points
 * @property integer $tax_class_id
 * @property string $date_available
 * @property string $weight
 * @property integer $weight_class_id
 * @property string $length
 * @property string $width
 * @property string $height
 * @property integer $length_class_id
 * @property integer $subtract
 * @property integer $minimum
 * @property integer $sort_order
 * @property integer $status
 * @property string $date_added
 * @property string $date_modified
 * @property integer $viewed
 *
 * The followings are the available model relations:
 * @property ProductAttribute[] $productAttributes
 * @property Category[] $categories
 * @property ProductDescription[] $productDescriptions
 * @property ProductDiscount[] $productDiscounts
 * @property ProductImage[] $productImages
 * @property ProductOption[] $productOptions
 * @property ProductOptionValue[] $productOptionValues
 * @property ProductSpecial[] $productSpecials
 * @property Store[] $stores
 */
abstract class BaseProduct extends CActiveRecord
{
	public $name;
	public $category_id;
	public $store_id;
	public $related_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Product the static model class
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
		return 'product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('model, sku, upc, ean, jan, isbn, mpn, location, stock_status_id, manufacturer_id, tax_class_id, date_available', 'required'),
			array('quantity, stock_status_id, manufacturer_id, shipping, points, tax_class_id, weight_class_id, length_class_id, subtract, minimum, sort_order, status, viewed', 'numerical', 'integerOnly'=>true),
			array('model, sku, mpn', 'length', 'max'=>64),
			array('upc', 'length', 'max'=>12),
			array('ean', 'length', 'max'=>14),
			array('jan, isbn', 'length', 'max'=>13),
			array('location', 'length', 'max'=>128),
			//array('image', 'length', 'max'=>255),
			//array('image', 'file', 'types'=>'jpg, gif, png'),
			array('categories, relatedA, stores, relatedB', 'safe'),
			array('price, weight, length, width, height', 'length', 'max'=>15),
			array('date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
			array('date_added','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, model, sku, upc, ean, jan, isbn, mpn, location, quantity, stock_status_id, image, manufacturer_id, shipping, price, points, tax_class_id, date_available, weight, weight_class_id, length, width, height, length_class_id, subtract, minimum, sort_order, status, date_added, date_modified, viewed, name', 'safe', 'on'=>'search'),
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
			'productAttributes' => array(self::HAS_MANY, 'ProductAttribute', 'product_id', 'condition' => 'productAttributes.locale_code = \''.$localeCode.'\''),
			'categories' => array(self::MANY_MANY, 'Category', 'product_category(product_id, category_id)'),
			'relatedA' => array(self::MANY_MANY, 'Product', 'product_related(product_id, related_id)'),
			'relatedB' => array(self::MANY_MANY, 'Product', 'product_related(related_id, product_id)'),
			'productDescriptions' => array(self::HAS_MANY, 'ProductDescription', 'product_id', 'condition' => 'productDescriptions.locale_code = \''.$localeCode.'\''),
			'productDiscounts' => array(self::HAS_MANY, 'ProductDiscount', 'product_id'),
			'images' => array(self::HAS_MANY, 'ProductImage', 'product_id'),
			'productOptions' => array(self::HAS_MANY, 'ProductOption', 'product_id'),
			'productOptionValues' => array(self::HAS_MANY, 'ProductOptionValue', 'product_id'),
			'productSpecials' => array(self::HAS_MANY, 'ProductSpecial', 'product_id'),
			'stores' => array(self::MANY_MANY, 'Store', 'product_store(product_id, store_id)'),
			'brand'=> array(self::BELONGS_TO, 'Manufacturer', 'manufacturer_id'),
			'orderCount'=>array(self::HAS_MANY, 'OrderProduct', 'product_id', 'select' => 'SUM(orderCount.quantity) AS qsum, product_id', 'order'=>'qsum DESC', 'group'=>'orderCount.product_id'),
		);
	}
	
	/**
	 * @return string price with currency symbol.
	 */
	public function printPrice($price)
	{
		return (!empty($price)) ? '&#8358;'.$price : null;
	}
	/**
	 * @return string name.
	 */
	public function getName()
	{
		return (!empty($this->productDescriptions)) ? $this->productDescriptions[0]->name : null;
	}
	/**
	 * @return string link.
	 */
	public function getLink()
	{
		return (!empty($this->productDescriptions)) ? $this->productDescriptions[0]->link : null;
	}
	/**
	 * @return string description.
	 */
	public function getDescription()
	{
		return (!empty($this->productDescriptions)) ? $this->productDescriptions[0]->description : null;
	}
	/**
	 * @return string meta_description.
	 */
	public function getMetaDescription()
	{
		return (!empty($this->productDescriptions)) ? $this->productDescriptions[0]->meta_description : null;
	}
	/**
	 * @return string meta_keyword.
	 */
	public function getMetaKeyword()
	{
		return (!empty($this->productDescriptions)) ? $this->productDescriptions[0]->meta_keyword : null;
	}
	/**
	 * @return string tag.
	 */
	public function getTag()
	{
		return (!empty($this->productDescriptions)) ? $this->productDescriptions[0]->tag : null;
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('label', 'ID'),
			'model' => Yii::t('label', 'Model'),
			'sku' => Yii::t('label', 'Sku'),
			'upc' => Yii::t('label', 'Upc'),
			'ean' => Yii::t('label', 'Ean'),
			'jan' => Yii::t('label', 'Jan'),
			'isbn' => Yii::t('label', 'Isbn'),
			'mpn' => Yii::t('label', 'Mpn'),
			'location' => Yii::t('label', 'Location'),
			'quantity' => Yii::t('label', 'Quantity'),
			'stock_status_id' => Yii::t('label', 'Stock Status'),
			'image' => Yii::t('label', 'Image'),
			'manufacturer_id' => Yii::t('label', 'Manufacturer'),
			'shipping' => Yii::t('label', 'Shipping'),
			'price' => Yii::t('label', 'Price'),
			'points' => Yii::t('label', 'Points'),
			'tax_class_id' => Yii::t('label', 'Tax Class'),
			'date_available' => Yii::t('label', 'Date Available'),
			'weight' => Yii::t('label', 'Weight'),
			'weight_class_id' => Yii::t('label', 'Weight Class'),
			'length' => Yii::t('label', 'Length'),
			'width' => Yii::t('label', 'Width'),
			'height' => Yii::t('label', 'Height'),
			'length_class_id' => Yii::t('label', 'Length Class'),
			'subtract' => Yii::t('label', 'Subtract'),
			'minimum' => Yii::t('label', 'Minimum'),
			'sort_order' => Yii::t('label', 'Sort Order'),
			'status' => Yii::t('label', 'Status'),
			'date_added' => Yii::t('label', 'Date Added'),
			'date_modified' => Yii::t('label', 'Date Modified'),
			'viewed' => Yii::t('label', 'Viewed'),
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
	
		$criteria->with = array(
                    'productDescriptions'=>array(
                          'together'=>true
                     )
                );
		$criteria->compare('productDescriptions.name',$this->name,true);		
		$criteria->compare('id',$this->id);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('sku',$this->sku,true);
		$criteria->compare('upc',$this->upc,true);
		$criteria->compare('ean',$this->ean,true);
		$criteria->compare('jan',$this->jan,true);
		$criteria->compare('isbn',$this->isbn,true);
		$criteria->compare('mpn',$this->mpn,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('stock_status_id',$this->stock_status_id);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('manufacturer_id',$this->manufacturer_id);
		$criteria->compare('shipping',$this->shipping);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('points',$this->points);
		$criteria->compare('tax_class_id',$this->tax_class_id);
		$criteria->compare('date_available',$this->date_available,true);
		$criteria->compare('weight',$this->weight,true);
		$criteria->compare('weight_class_id',$this->weight_class_id);
		$criteria->compare('length',$this->length,true);
		$criteria->compare('width',$this->width,true);
		$criteria->compare('height',$this->height,true);
		$criteria->compare('length_class_id',$this->length_class_id);
		$criteria->compare('subtract',$this->subtract);
		$criteria->compare('minimum',$this->minimum);
		$criteria->compare('sort_order',$this->sort_order);
		$criteria->compare('status',$this->status);
		$criteria->compare('date_added',$this->date_added,true);
		$criteria->compare('date_modified',$this->date_modified,true);
		$criteria->compare('viewed',$this->viewed);
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
							'name' => array(
									'asc' => 'productDescriptions.name ASC',
									'desc' => 'productDescriptions.name DESC',
							),
							'*',
					),
			),		
        	'pagination'=>array(
				'pageSize'=>100,
			),
		));
	}
}