<?php
/**
 * This is the model base class for the table "tax_class".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "TaxClass".
 *
 * The followings are the available columns in table 'tax_class':
 * @property integer $id
 * @property string $date_added
 * @property string $date_modified
 *
 * The followings are the available model relations:
 * @property TaxClassDescription[] $taxClassDescriptions
 */
abstract class BaseTaxClass extends CActiveRecord
{
	public $name;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TaxClass the static model class
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
		return 'tax_class';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('date_added, date_modified', 'unsafe'),
			array('date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
			array('date_added','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, date_added, date_modified, name', 'safe', 'on'=>'search'),
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
			'taxClassDescriptions' => array(self::HAS_MANY, 'TaxClassDescription', 'tax_class_id', 'condition' => 'taxClassDescriptions.locale_code = \''.$localeCode.'\''),
		);
	}

	/**
	 * @return string name.
	 */
	public function getName()
	{
		return (!empty($this->taxClassDescriptions)) ? $this->taxClassDescriptions[0]->name : null;
	}
	/**
	 * @return string description.
	 */
	public function getDescription()
	{
		return (!empty($this->taxClassDescriptions)) ? $this->taxClassDescriptions[0]->description : null;
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('label', 'ID'),
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
                    'taxClassDescriptions'=>array(
                          'together'=>true
                     )
                );
		$criteria->compare('taxClassDescriptions.name',$this->name,true);		
		$criteria->compare('id',$this->id);
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
									'asc' => 'taxClassDescriptions.name ASC',
									'desc' => 'taxClassDescriptions.name DESC',
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