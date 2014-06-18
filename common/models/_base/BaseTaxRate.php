<?php
/**
 * This is the model base class for the table "tax_rate".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "TaxRate".
 *
 * The followings are the available columns in table 'tax_rate':
 * @property integer $id
 * @property integer $geo_zone_id
 * @property string $rate
 * @property string $date_added
 * @property string $date_modified
 *
 * The followings are the available model relations:
 * @property TaxRateDescription[] $taxRateDescriptions
 */
abstract class BaseTaxRate extends CActiveRecord
{
	public $name;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TaxRate the static model class
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
		return 'tax_rate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('geo_zone_id', 'numerical', 'integerOnly'=>true),
			array('rate', 'length', 'max'=>15),
			array('date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
			array('date_added','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, geo_zone_id, rate, date_added, date_modified, name', 'safe', 'on'=>'search'),
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
			'taxRateDescriptions' => array(self::HAS_MANY, 'TaxRateDescription', 'tax_rate_id', 'condition' => 'taxRateDescriptions.locale_code = \''.$localeCode.'\''),
		);
	}

	/**
	 * @return string name.
	 */
	public function getName()
	{
		return (!empty($this->taxRateDescriptions)) ? $this->taxRateDescriptions[0]->name : null;
	}
	/**
	 * @return string type.
	 */
	public function getType()
	{
		return (!empty($this->taxRateDescriptions)) ? $this->taxRateDescriptions[0]->type : null;
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('label', 'ID'),
			'geo_zone_id' => Yii::t('label', 'Geo Zone'),
			'rate' => Yii::t('label', 'Rate'),
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
                    'taxRateDescriptions'=>array(
                          'together'=>true
                     )
                );
		$criteria->compare('taxRateDescriptions.name',$this->name,true);		
		$criteria->compare('id',$this->id);
		$criteria->compare('geo_zone_id',$this->geo_zone_id);
		$criteria->compare('rate',$this->rate,true);
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
									'asc' => 'taxRateDescriptions.name ASC',
									'desc' => 'taxRateDescriptions.name DESC',
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