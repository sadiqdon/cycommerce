<?php
/**
 * This is the model base class for the table "option_value".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "OptionValue".
 *
 * The followings are the available columns in table 'option_value':
 * @property integer $id
 * @property integer $option_id
 * @property string $image
 * @property integer $sort_order
 *
 * The followings are the available model relations:
 * @property Option $option
 * @property OptionValueDescription[] $optionValueDescriptions
 * @property ProductOptionValue[] $productOptionValues
 */
abstract class BaseOptionValue extends CActiveRecord
{
	public $name;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OptionValue the static model class
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
		return 'option_value';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('option_id, sort_order', 'required'),
			array('option_id, sort_order', 'numerical', 'integerOnly'=>true),
			array('image', 'length', 'max'=>255),
			array('name', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, option_id, image, sort_order, name', 'safe', 'on'=>'search'),
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
			'option' => array(self::BELONGS_TO, 'Option', 'option_id'),
			'optionValueDescriptions' => array(self::HAS_MANY, 'OptionValueDescription', 'option_value_id', 'condition' => 'optionValueDescriptions.locale_code = \''.$localeCode.'\''),
			'productOptionValues' => array(self::HAS_MANY, 'ProductOptionValue', 'option_value_id'),
		);
	}

	/**
	 * @return string option_id.
	 */
	public function getOptionId()
	{
		return (!empty($this->optionValueDescriptions)) ? $this->optionValueDescriptions[0]->option_id : null;
	}
	/**
	 * @return string name.
	 */
	public function getName()
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
			'option_id' => Yii::t('label', 'Option'),
			'image' => Yii::t('label', 'Image'),
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
                    'optionValueDescriptions'=>array(
                          'together'=>true
                     )
                );
		$criteria->compare('optionValueDescriptions.name',$this->name,true);		
		$criteria->compare('id',$this->id);
		$criteria->compare('option_id',$this->option_id);
		$criteria->compare('image',$this->image,true);
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