<?php
/**
 * This is the model base class for the table "product_description".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ProductDescription".
 *
 * The followings are the available columns in table 'product_description':
 * @property integer $product_id
 * @property string $locale_code
 * @property string $name
 * @property string $link
 * @property string $description
 * @property string $meta_description
 * @property string $meta_keyword
 * @property string $tag
 *
 * The followings are the available model relations:
 * @property Product $product
 */
abstract class BaseProductDescription extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProductDescription the static model class
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
		return 'product_description';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, locale_code, name, link, description, meta_description, meta_keyword, tag', 'required'),
			array('product_id', 'numerical', 'integerOnly'=>true),
			array('locale_code', 'length', 'max'=>5),
			array('name, link, meta_description, meta_keyword', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('product_id, locale_code, name, link, description, meta_description, meta_keyword, tag', 'safe', 'on'=>'search'),
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
			'product_id' => Yii::t('label', 'Product'),
			'locale_code' => Yii::t('label', 'Locale Code'),
			'name' => Yii::t('label', 'Name'),
			'link' => Yii::t('label', 'Link'),
			'description' => Yii::t('label', 'Description'),
			'meta_description' => Yii::t('label', 'Meta Description'),
			'meta_keyword' => Yii::t('label', 'Meta Keyword'),
			'tag' => Yii::t('label', 'Tag'),
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
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('locale_code',$this->locale_code,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('meta_description',$this->meta_description,true);
		$criteria->compare('meta_keyword',$this->meta_keyword,true);
		$criteria->compare('tag',$this->tag,true);
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