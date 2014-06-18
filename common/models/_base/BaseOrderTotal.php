<?php
/**
 * This is the model base class for the table "order_total".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "OrderTotal".
 *
 * The followings are the available columns in table 'order_total':
 * @property integer $id
 * @property integer $order_id
 * @property string $code
 * @property string $value
 * @property integer $sort_order
 *
 * The followings are the available model relations:
 * @property Order $order
 * @property OrderTotalDescription[] $orderTotalDescriptions
 */
abstract class BaseOrderTotal extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderTotal the static model class
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
		return 'order_total';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, code, sort_order', 'required'),
			array('order_id, sort_order', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>32),
			array('value', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, order_id, code, value, sort_order', 'safe', 'on'=>'search'),
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
			'order' => array(self::BELONGS_TO, 'Order', 'order_id'),
			'orderTotalDescriptions' => array(self::HAS_MANY, 'OrderTotalDescription', 'order_total_id', 'condition' => 'orderTotalDescriptions.locale_code = \''.$localeCode.'\''),
		);
	}

	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('label', 'ID'),
			'order_id' => Yii::t('label', 'Order'),
			'code' => Yii::t('label', 'Code'),
			'value' => Yii::t('label', 'Value'),
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
		$criteria->compare('id',$this->id);
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('value',$this->value,true);
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
							'*',
					),
			),		
        	'pagination'=>array(
				'pageSize'=>100,
			),
		));
	}
}