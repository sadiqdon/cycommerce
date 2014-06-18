<?php
/**
 * This is the model base class for the table "faq".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Faq".
 *
 * The followings are the available columns in table 'faq':
 * @property integer $id
 *
 * The followings are the available model relations:
 * @property FaqDescription[] $faqDescriptions
 */
abstract class BaseFaq extends CActiveRecord
{
	public $name;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Faq the static model class
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
		return 'faq';
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
			'faqDescriptions' => array(self::HAS_MANY, 'FaqDescription', 'faq_id', 'condition' => 'faqDescriptions.locale_code = \''.$localeCode.'\''),
		);
	}

	/**
	 * @return string id.
	 */
	public function getId()
	{
		return (!empty($this->faqDescriptions)) ? $this->faqDescriptions[0]->id : null;
	}
	/**
	 * @return string title.
	 */
	public function getTitle()
	{
		return (!empty($this->faqDescriptions)) ? $this->faqDescriptions[0]->title : null;
	}
	/**
	 * @return string description.
	 */
	public function getDescription()
	{
		return (!empty($this->faqDescriptions)) ? $this->faqDescriptions[0]->description : null;
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
                    'faqDescriptions'=>array(
                          'together'=>true
                     )
                );
		$criteria->compare('faqDescriptions.name',$this->name,true);		
		$criteria->compare('id',$this->id);
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