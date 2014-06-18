<?php
/**
 * This is the model base class for the table "product_option".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ProductOption".
 *
 * The followings are the available columns in table 'product_option':
 * @property integer $id
 * @property integer $product_id
 * @property integer $option_id
 * @property string $option_value
 * @property integer $required
 *
 * The followings are the available model relations:
 * @property Product $product
 * @property Option $option
 * @property ProductOptionValue[] $productOptionValues
 */
abstract class BaseProductOption extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProductOption the static model class
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
		return 'product_option';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, option_id, required', 'required'),
			array('product_id, option_id, required', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, product_id, option_id, option_value, required', 'safe', 'on'=>'search'),
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
			'option' => array(self::BELONGS_TO, 'Option', 'option_id'),
			'productOptionValues' => array(self::HAS_MANY, 'ProductOptionValue', 'product_option_id'),
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
			'option_id' => Yii::t('label', 'Option'),
			'option_value' => Yii::t('label', 'Option Value'),
			'required' => Yii::t('label', 'Required'),
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
		$criteria->compare('option_id',$this->option_id);
		$criteria->compare('option_value',$this->option_value,true);
		$criteria->compare('required',$this->required);
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