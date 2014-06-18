<?php
/**
 * This is the model base class for the table "attribute".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Attribute".
 *
 * The followings are the available columns in table 'attribute':
 * @property integer $id
 * @property integer $attribute_group_id
 * @property integer $sort_order
 *
 * The followings are the available model relations:
 * @property AttributeGroup $attributeGroup
 * @property AttributeDescription[] $attributeDescriptions
 * @property ProductAttribute[] $productAttributes
 */
abstract class BaseAttribute extends CActiveRecord
{
	public $name;
	public $attribute_group_name;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Attribute the static model class
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
		return 'attribute';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('attribute_group_id, sort_order', 'required'),
			array('attribute_group_id, sort_order', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, attribute_group_id, sort_order, name, attribute_group_name', 'safe', 'on'=>'search'),
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
			'attributeGroup' => array(self::BELONGS_TO, 'AttributeGroup', 'attribute_group_id'),
			'attributeDescriptions' => array(self::HAS_MANY, 'AttributeDescription', 'attribute_id', 'condition' => 'attributeDescriptions.locale_code = \''.$localeCode.'\''),
			'productAttributes' => array(self::HAS_MANY, 'ProductAttribute', 'attribute_id'),
		);
	}

	/**
	 * @return string name.
	 */
	public function getName()
	{
		return (!empty($this->attributeDescriptions)) ? $this->attributeDescriptions[0]->name : null;
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('label', 'ID'),
			'attribute_group_id' => Yii::t('label', 'Attribute Group'),
			'sort_order' => Yii::t('label', 'Sort Order'),
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
                    'attributeDescriptions'=>array(
                          'together'=>true
                    ),
					'attributeGroup.attributeGroupDescriptions'=>array(
                          'together'=>true
                    ),
                );
		$criteria->compare('attributeDescriptions.name',$this->name,true);		
		$criteria->compare('id',$this->id);
		$criteria->compare('attributeGroupDescriptions.name',$this->attribute_group_name,true);
		$criteria->compare('sort_order',$this->sort_order);
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
									'asc' => 'attributeDescriptions.name ASC',
									'desc' => 'attributeDescriptions.name DESC',
							),
							'attribute_group_name' => array(
									'asc' => 'attributeGroupDescriptions.name ASC',
									'desc' => 'attributeGroupDescriptions.name DESC',
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