<?php
/**
 * This is the model base class for the table "currency".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Currency".
 *
 * The followings are the available columns in table 'currency':
 * @property integer $id
 * @property string $title
 * @property string $code
 * @property string $symbol_left
 * @property string $symbol_right
 * @property string $decimal_place
 * @property double $value
 * @property integer $status
 * @property string $date_modified
 */
abstract class BaseCurrency extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Currency the static model class
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
		return 'currency';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, code, symbol_left, symbol_right, decimal_place, value, status', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('value', 'numerical'),
			array('title', 'length', 'max'=>32),
			array('code', 'length', 'max'=>3),
			array('symbol_left, symbol_right', 'length', 'max'=>12),
			array('decimal_place', 'length', 'max'=>1),
			array('date_modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, code, symbol_left, symbol_right, decimal_place, value, status, date_modified', 'safe', 'on'=>'search'),
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
		);
	}

	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('label', 'ID'),
			'title' => Yii::t('label', 'Title'),
			'code' => Yii::t('label', 'Code'),
			'symbol_left' => Yii::t('label', 'Symbol Left'),
			'symbol_right' => Yii::t('label', 'Symbol Right'),
			'decimal_place' => Yii::t('label', 'Decimal Place'),
			'value' => Yii::t('label', 'Value'),
			'status' => Yii::t('label', 'Status'),
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
		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('symbol_left',$this->symbol_left,true);
		$criteria->compare('symbol_right',$this->symbol_right,true);
		$criteria->compare('decimal_place',$this->decimal_place,true);
		$criteria->compare('value',$this->value);
		$criteria->compare('status',$this->status);
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
							'*',
					),
			),		
        	'pagination'=>array(
				'pageSize'=>100,
			),
		));
	}
}