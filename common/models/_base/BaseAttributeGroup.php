<?php
/**
 * This is the model base class for the table "attribute_group".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "AttributeGroup".
 *
 * The followings are the available columns in table 'attribute_group':
 * @property integer $id
 * @property integer $sort_order
 *
 * The followings are the available model relations:
 * @property Attribute[] $attributes
 * @property AttributeGroupDescription[] $attributeGroupDescriptions
 */
abstract class BaseAttributeGroup extends CActiveRecord
{
	public $name;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AttributeGroup the static model class
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
		return 'attribute_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sort_order', 'required'),
			array('sort_order', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, sort_order, name', 'safe', 'on'=>'search'),
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
			'attributes' => array(self::HAS_MANY, 'Attribute', 'attribute_group_id'),
			'attributeGroupDescriptions' => array(self::HAS_MANY, 'AttributeGroupDescription', 'attribute_group_id', 'condition' => 'attributeGroupDescriptions.locale_code = \''.$localeCode.'\''),
		);
	}

	/**
	 * @return string name.
	 */
	public function getName()
	{
		return (!empty($this->attributeGroupDescriptions)) ? $this->attributeGroupDescriptions[0]->name : null;
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('label', 'ID'),
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
                    'attributeGroupDescriptions'=>array(
                          'together'=>true
                     )
                );
		$criteria->compare('attributeGroupDescriptions.name',$this->name,true);		
		$criteria->compare('id',$this->id);
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