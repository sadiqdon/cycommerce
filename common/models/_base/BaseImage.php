<?php
/**
 * This is the model base class for the table "image".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Image".
 *
 * The followings are the available columns in table 'image':
 * @property integer $id
 * @property integer $model_id
 * @property integer $sort_order
 * @property string $size
 * @property string $mime
 * @property string $name
 * @property string $source
 * @property string $model_name
 */
abstract class BaseImage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Image the static model class
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
		return 'image';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('model_id, size, mime, name, source, model_name', 'required'),
			array('model_id, sort_order', 'numerical', 'integerOnly'=>true),
			array('size, mime', 'length', 'max'=>10),
			array('name, model_name', 'length', 'max'=>50),
			array('source', 'length', 'max'=>255),
			array('sort_order', 'default', 'setOnEmpty' => true, 'value' => null),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, model_id, sort_order, size, mime, name, source, model_name', 'safe', 'on'=>'search'),
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
			'categories' => array(self::HAS_MANY, 'Category', 'image_id'),
		);
	}

	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('label', 'ID'),
			'model_id' => Yii::t('label', 'Model'),
			'sort_order' => Yii::t('label', 'Sort Order'),
			'size' => Yii::t('label', 'Size'),
			'mime' => Yii::t('label', 'Mime'),
			'name' => Yii::t('label', 'Name'),
			'source' => Yii::t('label', 'Source'),
			'model_name' => Yii::t('label', 'Model Name'),
			'categories' => null,
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
		$criteria->compare('id',$this->id);
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('sort_order',$this->sort_order);
		$criteria->compare('size',$this->size,true);
		$criteria->compare('mime',$this->mime,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('model_name',$this->model_name,true);
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