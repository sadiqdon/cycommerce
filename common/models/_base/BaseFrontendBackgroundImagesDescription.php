<?php
/**
 * This is the model base class for the table "frontend_background_images_description".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "FrontendBackgroundImagesDescription".
 *
 * The followings are the available columns in table 'frontend_background_images_description':
 * @property integer $frontend_background_images_id
 * @property string $title
 * @property string $locale_code
 *
 * The followings are the available model relations:
 * @property FrontendBackgroundImages $frontendBackgroundImages
 */
abstract class BaseFrontendBackgroundImagesDescription extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FrontendBackgroundImagesDescription the static model class
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
		return 'frontend_background_images_description';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('frontend_background_images_id, title, locale_code', 'required'),
			array('frontend_background_images_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>50),
			array('locale_code', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('frontend_background_images_id, title, locale_code', 'safe', 'on'=>'search'),
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
			'frontendBackgroundImages' => array(self::BELONGS_TO, 'FrontendBackgroundImages', 'frontend_background_images_id'),
		);
	}

	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'frontend_background_images_id' => Yii::t('label', 'Frontend Background Images'),
			'title' => Yii::t('label', 'Title'),
			'locale_code' => Yii::t('label', 'Locale Code'),
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
		$criteria->compare('frontend_background_images_id',$this->frontend_background_images_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('locale_code',$this->locale_code,true);
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