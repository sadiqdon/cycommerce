<?php
/**
 * This is the model base class for the table "product_image".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ProductImage".
 *
 * The followings are the available columns in table 'product_image':
 * @property integer $id
 * @property integer $product_id
 * @property integer $sort_order
 * @property string $size
 * @property string $mime
 * @property string $name
 * @property string $source
 *
 * The followings are the available model relations:
 * @property Product $product
 */
abstract class BaseProductImage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProductImage the static model class
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
		return 'product_image';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, size, mime, name, source', 'required'),
			array('product_id, sort_order', 'numerical', 'integerOnly'=>true),
			array('size, mime', 'length', 'max'=>10),
			array('name', 'length', 'max'=>50),
			array('source', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, product_id, sort_order, size, mime, name, source', 'safe', 'on'=>'search'),
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
			'sort_order' => Yii::t('label', 'Sort Order'),
			'size' => Yii::t('label', 'Size'),
			'mime' => Yii::t('label', 'Mime'),
			'name' => Yii::t('label', 'Name'),
			'source' => Yii::t('label', 'Source'),
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
		$criteria->compare('sort_order',$this->sort_order);
		$criteria->compare('size',$this->size,true);
		$criteria->compare('mime',$this->mime,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('source',$this->source,true);
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