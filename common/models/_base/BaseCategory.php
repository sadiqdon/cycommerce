<?php
/**
 * This is the model base class for the table "category".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Category".
 *
 * The followings are the available columns in table 'category':
 * @property integer $id
 * @property integer $store_id
 * @property integer $parent_id
 * @property integer $top
 * @property integer $column
 * @property integer $sort_order
 * @property integer $status
 * @property string $date_added
 * @property string $date_modified
 *
 * The followings are the available model relations:
 * @property Store $store
 * @property CategoryDescription[] $categoryDescriptions
 */
abstract class BaseCategory extends CActiveRecord
{
	public $name;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Category the static model class
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
		return 'category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('top, column, status', 'required'),
			array('store_id, parent_id, top, column, sort_order, status', 'numerical', 'integerOnly'=>true),
			//array('date_added, date_modified', 'unsafe'),
			array('parent_id', 'default', 'setOnEmpty' => true, 'value' => null),
			array('sort_order', 'default', 'setOnEmpty' => true, 'value' => 0),
			array('date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
			array('date_added','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			array('id, store_id, parent_id, top, column, sort_order, status, date_added, date_modified, name', 'safe', 'on'=>'search'),
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
			'store' => array(self::BELONGS_TO, 'Store', 'store_id'),
			'parent' => array(self::BELONGS_TO, 'Category', 'parent_id'),
			'categories' => array(self::HAS_MANY, 'Category', 'parent_id'),
			'categoryDescriptions' => array(self::HAS_MANY, 'CategoryDescription', 'category_id', 'condition' => 'categoryDescriptions.locale_code = \''.$localeCode.'\''),
			'products' => array(self::MANY_MANY, 'Product', 'product_category(category_id, product_id)'),
		);
	}

	/**
	 * @return string name.
	 */
	public function getName()
	{
		return (!empty($this->categoryDescriptions)) ? ((!empty($this->categoryDescriptions[0])) ? $this->categoryDescriptions[0]->name : null) : null;
	}
	/**
	 * @return string link.
	 */
	public function getLink()
	{
		return (!empty($this->categoryDescriptions)) ? $this->categoryDescriptions[0]->link : null;
	}
	/**
	 * @return string description.
	 */
	public function getDescription()
	{
		return (!empty($this->categoryDescriptions)) ? $this->categoryDescriptions[0]->description : null;
	}
	/**
	 * @return string meta_description.
	 */
	public function getMetaDescription()
	{
		return (!empty($this->categoryDescriptions)) ? $this->categoryDescriptions[0]->meta_description : null;
	}
	/**
	 * @return string meta_keyword.
	 */
	public function getMetaKeyword()
	{
		return (!empty($this->categoryDescriptions)) ? $this->categoryDescriptions[0]->meta_keyword : null;
	}
	
	/**
	 * @return array products.
	 */
	public function getCategoryProducts() {
		$products = array();
        if ($cat_rs = $this->parent) {
            $products = array_merge($products, $cat_rs->getCategoryProducts());
        } else {
            $products = array_merge($products, $this->products);
        }
		return $products;
    }
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('label', 'ID'),
			'store_id' => Yii::t('label', 'Store'),
			'parent_id' => Yii::t('label', 'Parent'),
			'top' => Yii::t('label', 'Top'),
			'column' => Yii::t('label', 'Column'),
			'sort_order' => Yii::t('label', 'Sort Order'),
			'status' => Yii::t('label', 'Status'),
			'date_added' => Yii::t('label', 'Date Added'),
			'date_modified' => Yii::t('label', 'Date Modified'),
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
                    'categoryDescriptions'=>array(
                          'together'=>true
                     ),'parent.categoryDescriptions' => array('alias' => 'd','together'=>true)
                );
		$criteria->compare('categoryDescriptions.name',$this->name,true);		
		$criteria->compare('id',$this->id);
		$criteria->compare('store_id',$this->store_id);
		$criteria->compare('d.name',$this->parent_id,true);
		$criteria->compare('top',$this->top);
		$criteria->compare('column',$this->column);
		$criteria->compare('sort_order',$this->sort_order);
		$criteria->compare('status',$this->status);
		$criteria->compare('date_added',$this->date_added,true);
		$criteria->compare('date_modified',$this->date_modified,true);
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
									'asc' => 'categoryDescriptions.name ASC',
									'desc' => 'categoryDescriptions.name DESC',
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