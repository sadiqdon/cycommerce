<?php
/**
 * This is the model base class for the table "shipping_method".
 * DO NOT MODIFY THIS FILE! It is automatically generated.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ShippingMethod".
 *
 * The followings are the available columns in table 'shipping_method':
 * @property integer $id
 * @property integer $status
 * @property integer $sort_order
 *
 * The followings are the available model relations:
 * @property ShippingMethodDescription[] $shippingMethodDescriptions
 */
abstract class BaseShippingMethod extends CActiveRecord
{
	public $name;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ShippingMethod the static model class
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
		return 'shipping_method';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status, sort_order', 'required'),
			array('status, sort_order', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, status, sort_order, name', 'safe', 'on'=>'search'),
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
			'shippingMethodDescriptions' => array(self::HAS_MANY, 'ShippingMethodDescription', 'shipping_method_id', 'condition' => 'shippingMethodDescriptions.locale_code = \''.$localeCode.'\''),
		);
	}

	/**
	 * @return string name.
	 */
	public function getName()
	{
		return (!empty($this->shippingMethodDescriptions)) ? $this->shippingMethodDescriptions[0]->name : null;
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('label', 'ID'),
			'status' => Yii::t('label', 'Status'),
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
                    'shippingMethodDescriptions'=>array(
                          'together'=>true
                     )
                );
		$criteria->compare('shippingMethodDescriptions.name',$this->name,true);		
		$criteria->compare('id',$this->id);
		$criteria->compare('status',$this->status);
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
									'asc' => 'shippingMethodDescriptions.name ASC',
									'desc' => 'shippingMethodDescriptions.name DESC',
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