<?php

/**
 * This is the model class for table "tbl_audit_trail".
 */
class AuditTrail extends EncryptModel
{
	/**
	 * The followings are the available columns in table 'tbl_audit_trail':
	 * @var integer $id
	 * @var string $new_value
	 * @var string $old_value
	 * @var string $action
	 * @var string $model
	 * @var string $field
	 * @var string $host_add
	 * @var string $stamp
	 * @var integer $user_id
	 * @var string $model_id
	 */
	
	protected $encrypt = array('new_value','old_value','action','model','field','host_add','user_id','model_id');
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return AuditTrail the static model class
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
		return 'audit_trail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('action, model, stamp, model_id', 'required'),
			array('action', 'length', 'max'=>255),
			array('model', 'length', 'max'=>255),
			array('field', 'length', 'max'=>255),
			array('model_id', 'length', 'max'=>255),
			array('user_id', 'length', 'max'=>255),
			array('host_add', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, new_value, old_value, host_add, action, model, field, stamp, user_id, model_id', 'safe', 'on'=>'search'),
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
			'profiles' => array(self::BELONGS_TO, 'Profile', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'old_value' => 'Old Value',
			'new_value' => 'New Value',
			'action' => 'Action',
			'model' => 'Type',
			'field' => 'Field',
			'stamp' => 'Stamp',
			'user_id' => 'User',
			'model_id' => 'Model ID',
			'host_add' => 'Host Address',
		);
	}

	function getParent(){
		$model_name = $this->model;
		return $model_name::model();
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($options = array())
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('old_value',$this->encryptDecrypt($this->old_value));
		$criteria->compare('new_value',$this->encryptDecrypt($this->new_value));
		$criteria->compare('host_add',$this->encryptDecrypt($this->host_add));
		$criteria->compare('action',$this->encryptDecrypt($this->action));
		$criteria->compare('model',$this->encryptDecrypt($this->model));
		$criteria->compare('field',$this->encryptDecrypt($this->field));
		$criteria->compare('stamp',$this->stamp,true);
		$criteria->compare('user_id',$this->encryptDecrypt($this->user_id));
		$criteria->compare('model_id',$this->encryptDecrypt($this->model_id));
		$criteria->mergeWith($this->getDbCriteria());
		return new CActiveDataProvider(
			get_class($this),
			array_merge(
				array(
					'criteria'=>$criteria,			
					'sort' => array('defaultOrder' => 't.stamp DESC',),					
				),
				$options
			)
		);
	}

	public function scopes() {
		return array(
			'recently' => array(
				'order' => ' t.stamp DESC ',
			),

		);
	}
}