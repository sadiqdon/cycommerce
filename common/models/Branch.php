<?php

/**
 * Branch class.
 * Branch is the data structure for keeping
 * branch form data.'.
 */
class Branch extends CActiveRecord
{
	const STATUS_NOTACTIVE=0;
	const STATUS_ACTIVE=1;
	
	/**
	 * @var integer $id of this record
	 * @var string $name
	 * @var string $branchCode
	 * @var string $location
	 * @var boolean $status
	 * @soap
	 */


	public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
 
    public function tableName()
    {
        return 'branch';
    }

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, branchCode and location are required
			array('name, branchCode, location, status', 'required'),
			// branchCode must be unique
			array('branchCode', 'unique', 'message' => Yii::t("branch","This branch code already exists.")),
			array('status', 'boolean'),
			array('status', 'in', 'range'=>array(self::STATUS_NOTACTIVE,self::STATUS_ACTIVE)),
			array('create_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('lastedit_at', 'default', 'value' => '0000-00-00 00:00:00', 'setOnEmpty' => true, 'on' => 'insert'),
			array('status', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'profiles' => array(self::HAS_MANY, 'Profile', 'branch_id'),
			'groups' => array(self::MANY_MANY, 'Group', 'branch_group(branch_id, group_id)'),
			//'instrumentCount'=>array( self::STAT, 'Instrument', 'profiles(branch_id, user_id)'),
		);
	}
	
	public function behaviors()
	{
		return array(
			// Classname => path to Class
			'LoggableBehavior'=>
				'application.behaviors.LoggableBehavior',
		);
	}
	
	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'branchCode'=>'Branch Code',
		);
	}
	
	public function scopes()
    {
        return array(
            'active'=>array(
                'condition'=>'status='.self::STATUS_ACTIVE,
            ),
            'notactive'=>array(
                'condition'=>'status='.self::STATUS_NOTACTIVE,
            ),
            'notsafe'=>array(
            	'select' => 'id, name, branchCode, location, create_at, lastedit_at, status',
            ),
        );
    }
	/*
	public function defaultScope()
    {
        return array(
            'select' => 'id, name, branchCode, location, create_at, lastedit_at, status',
        );
    }
	*/
	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'BranchStatus' => array(
				self::STATUS_NOTACTIVE => Yii::t('label','Not active'),
				self::STATUS_ACTIVE => Yii::t('label','Active'),
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
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
        $criteria->compare('name',$this->name,true);
        $criteria->compare('branchCode',$this->branchCode);
        $criteria->compare('location',$this->location,true);
        $criteria->compare('create_at',$this->create_at);
        $criteria->compare('lastedit_at',$this->lastedit_at);
        $criteria->compare('status',$this->status);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        	'pagination'=>array(
				'pageSize'=>50,
			),
        ));
    }
}