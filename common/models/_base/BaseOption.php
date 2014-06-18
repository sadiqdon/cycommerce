<?php
/**
 * This is the model base class for the table "option".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Option".
 *
 * The followings are the available columns in table 'option':
 * @property integer $id
 * @property string $type
 * @property integer $sort_order
 *
 * The followings are the available model relations:
 * @property OptionDescription[] $optionDescriptions
 * @property OptionValue[] $optionValues
 * @property OptionValueDescription[] $optionValueDescriptions
 * @property ProductOption[] $productOptions
 * @property ProductOptionValue[] $productOptionValues
 */
abstract class BaseOption extends CActiveRecord
{
	public $name;
	public $typeList = array('select'=>'Select','radio'=>'Radio','checkbox'=>'Checkbox','text'=>'Text','textarea'=>'TextArea','file'=>'File','date'=>'Date','time'=>'Time','datetime'=>'Date & Time');
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Option the static model class
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
		return 'option';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, sort_order', 'required'),
			array('sort_order', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, sort_order, name', 'safe', 'on'=>'search'),
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
			'optionDescriptions' => array(self::HAS_MANY, 'OptionDescription', 'option_id', 'condition' => 'optionDescriptions.locale_code = \''.$localeCode.'\''),
			'optionValues' => array(self::HAS_MANY, 'OptionValue', 'option_id'),
			'optionValueDescriptions' => array(self::HAS_MANY, 'OptionValueDescription', 'option_id', 'condition' => 'optionValueDescriptions.locale_code = \''.$localeCode.'\''),
			'productOptions' => array(self::HAS_MANY, 'ProductOption', 'option_id'),
			'productOptionValues' => array(self::HAS_MANY, 'ProductOptionValue', 'option_id'),
		);
	}

	/**
	 * @return string name.
	 */
	public function getName()
	{
		return (!empty($this->optionDescriptions)) ? $this->optionDescriptions[0]->name : null;
	}
	/**
	 * @return string name.
	 */
	public function getValueName()
	{
		return (!empty($this->optionValueDescriptions)) ? $this->optionValueDescriptions[0]->name : null;
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('label', 'ID'),
			'type' => Yii::t('label', 'Type'),
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
                    'optionDescriptions'=>array(
                          'together'=>true
                     )
                );
		$criteria->compare('optionDescriptions.name',$this->name,true);		
		$criteria->compare('id',$this->id);
		$criteria->compare('type',$this->type,true);
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
									'asc' => 'optionDescriptions.name ASC',
									'desc' => 'optionDescriptions.name DESC',
							),
							'value_name' => array(
									'asc' => 'optionValueDescriptions.name ASC',
									'desc' => 'optionValueDescriptions.name DESC',
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