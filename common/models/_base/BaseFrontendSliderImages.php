<?php
/**
 * This is the model base class for the table "frontend_slider_images".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "FrontendSliderImages".
 *
 * The followings are the available columns in table 'frontend_slider_images':
 * @property integer $id
 * @property string $link
 *
 * The followings are the available model relations:
 * @property FrontendSliderImagesDescription $frontendSliderImagesDescription
 */
abstract class BaseFrontendSliderImages extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FrontendBackgroundImages the static model class
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
		return 'frontend_slider_images';
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
			array('link','required'),
			array('id,link', 'safe', 'on'=>'search'),
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
			'frontendSliderImagesDescriptions' => array(self::HAS_MANY, 'FrontendSliderImagesDescription', 'frontend_slider_images_id', 'condition' => 'frontendSliderImagesDescriptions.locale_code = \''.$localeCode.'\''),
		);
	}

	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('label', 'ID'),
			'link' => Yii::t('label', 'Link'),
		);
	}
	
	/**
	 * @return string name.
	 */
	public function getTitle()
	{
		return (!empty($this->frontendSliderImagesDescriptions)) ? ((!empty($this->frontendSliderImagesDescriptions[0])) ? $this->frontendSliderImagesDescriptions[0]->title : null) : null;
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
		$criteria->compare('id',$this->id);
		$criteria->compare('link',$this->link);
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