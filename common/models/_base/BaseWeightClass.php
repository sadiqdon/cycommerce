<?php
/**
 * This is the model base class for the table "weight_class".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "WeightClass".
 *
 * The followings are the available columns in table 'weight_class':
 * @property integer $id
 * @property string $value
 *
 * The followings are the available model relations:
 * @property WeightClassDescription[] $weightClassDescriptions
 */
abstract class BaseWeightClass extends CActiveRecord
{
	public $name;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return WeightClass the static model class
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
		return 'weight_class';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('value', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, value, name', 'safe', 'on'=>'search'),
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
			'weightClassDescriptions' => array(self::HAS_MANY, 'WeightClassDescription', 'weight_class_id', 'condition' => 'weightClassDescriptions.locale_code = \''.$localeCode.'\''),
		);
	}

	/**
	 * @return string name.
	 */
	public function getName()
	{
		return (!empty($this->weightClassDescriptions)) ? $this->weightClassDescriptions[0]->name : null;
	}
	/**
	 * @return string unit.
	 */
	public function getUnit()
	{
		return (!empty($this->weightClassDescriptions)) ? $this->weightClassDescriptions[0]->unit : null;
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('label', 'ID'),
			'value' => Yii::t('label', 'Value'),
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
                    'weightClassDescriptions'=>array(
                          'together'=>true
                     )
                );
		$criteria->compare('weightClassDescriptions.name',$this->name,true);		
		$criteria->compare('id',$this->id);
		$criteria->compare('value',$this->value,true);
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
									'asc' => 'weightClassDescriptions.name ASC',
									'desc' => 'weightClassDescriptions.name DESC',
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