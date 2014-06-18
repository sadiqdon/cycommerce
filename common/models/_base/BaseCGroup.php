<?php
/**
 * This is the model base class for the table "c_group".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "CGroup".
 *
 * The followings are the available columns in table 'c_group':
 * @property integer $id
 *
 * The followings are the available model relations:
 * @property CGroupDescription[] $cGroupDescriptions
 * @property ProductDiscount[] $productDiscounts
 * @property ProductSpecial[] $productSpecials
 * @property TaxRule[] $taxRules
 */
abstract class BaseCGroup extends CActiveRecord
{
	public $name;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CGroup the static model class
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
		return 'c_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name', 'safe', 'on'=>'search'),
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
			'cGroupDescriptions' => array(self::HAS_MANY, 'CGroupDescription', 'c_group_id', 'condition' => 'cGroupDescriptions.locale_code = \''.$localeCode.'\''),
			'productDiscounts' => array(self::HAS_MANY, 'ProductDiscount', 'c_group_id'),
			'productSpecials' => array(self::HAS_MANY, 'ProductSpecial', 'c_group_id'),
			'taxRules' => array(self::MANY_MANY, 'TaxRule', 'tax_rate_c_group(c_group_id, tax_rate_id)'),
			'groups' => array(self::MANY_MANY, 'CustomerCGroup', 'customer_c_group(user_id, c_group_id)'),
		);
	}

	/**
	 * @return string name.
	 */
	public function getName()
	{
		return (!empty($this->cGroupDescriptions)) ? $this->cGroupDescriptions[0]->name : null;
	}
	/**
	 * @return string description.
	 */
	public function getDescription()
	{
		return (!empty($this->cGroupDescriptions)) ? $this->cGroupDescriptions[0]->description : null;
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('label', 'ID'),
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
                    'cGroupDescriptions'=>array(
                          'together'=>true
                     )
                );
		$criteria->compare('cGroupDescriptions.name',$this->name,true);		
		$criteria->compare('id',$this->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
	
			'sort' => array(
					'defaultOrder' => 't.sort_order DESC',
					'attributes' => array(
							'name' => array(
									'asc' => 'cGroupDescriptions.name ASC',
									'desc' => 'cGroupDescriptions.name DESC',
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