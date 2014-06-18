<?php
/**
 * This is the model base class for the table "online_payment_settings".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "OnlinePaymentSettings".
 *
 * The followings are the available columns in table 'online_payment_settings':
 * @property integer $id
 * @property integer $online_payment_options_id
 * @property string $field
 * @property string $value
 * @property string $date_added
 */
abstract class BaseOnlinePaymentSettings extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OnlinePaymentSettings the static model class
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
		return 'online_payment_settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('online_payment_options_id, field, value', 'required'),
			array('online_payment_options_id', 'numerical', 'integerOnly'=>true),
			array('field', 'length', 'max'=>100),
			array('value', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, online_payment_options_id, field, value, date_added', 'safe', 'on'=>'search'),
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
			'onlinePaymentOptions' => array(self::BELONGS_TO, 'OnlinePaymentOptions', 'online_payment_options_id'),
			'filterByPaymentTypeId'=>array(self::HAS_MANY, 'OnlinePaymentSettings',
                'online_payment_options_id'),
		);
	}

	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('label', 'ID'),
			'online_payment_options_id' => Yii::t('label', 'Online Payment Options'),
			'field' => Yii::t('label', 'Field'),
			'value' => Yii::t('label', 'Value'),
			//'date_added' => Yii::t('label', 'Date Added'),
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
		$criteria->compare('online_payment_options_id',$this->online_payment_options_id);
		$criteria->compare('field',$this->field,true);
		$criteria->compare('value',$this->value,true);
		//$criteria->compare('date_added',$this->date_added,true);
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