<?php

class OptionController extends CrudController
{
	public $modelName = 'Option';
	
	private $_optionvaluedes = array();
	
	private $_optionvalue = array();
	
	private $delLog = array();
	
	public function actionView($id) {
		parent::view($id, $this->modelName);
	}

	public function actionCreate() {		
		$model = new Option;
		$description = new OptionDescription;
		$optionValue = new OptionValue;
		$optionValueDes = new OptionValueDescription;
		//$optionValueData = new CArrayDataProvider($this->_optionvalue);
		$this->performAjaxValidation(array($model,$description, $optionValue), 'option-form');
		
		if (isset($_POST[$this->modelName])) {
			$model->setAttributes($_POST[$this->modelName]);
			$description->setAttributes($_POST[$this->modelName.'Description']);
			//$optionValue->setAttributes($_POST['OptionValue']);
			$suc = Yii::t('info','Option was successfully created');
			$err = Yii::t('info','Could not update Option');
			$errOpt = Yii::t('info','Please fill in the name and sort number for each option value');
			$description->option_id = 0;
			$description->locale_code = Yii::app()->getLanguage();
			if ($model->validate() && $description->validate() && $this->validateOptionValue()){
				if ($model->save()) {
					$description->option_id = $model->id;
					$description->save();
					
					foreach($this->_optionvalue as $i=>$optionvalue){
						$optionvalue->option_id = $model->id;					
						$optionvalue->save();
						$this->_optionvaluedes[$i]->option_value_id = $optionvalue->id;
						$this->_optionvaluedes[$i]->option_id = $model->id;
						$this->_optionvaluedes[$i]->save();
					}
					
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,$suc);
					if (Yii::app()->getRequest()->getIsAjaxRequest()){
						$this->renderPartial('_view', array('model' => $model, 'description' => $description, 'optionValue' => $this->_optionvalue, 'optionValueDes' => $this->_optionvaluedes, 'optionValueData' => new CArrayDataProvider($this->_optionvalue) ), false, true);					
						Yii::app()->end();
					}else
						$this->redirect(array('view', 'id' => $model->id));
				}else{
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$err);
				}
			}else{ 
				$description->validate();
				if(!$this->validateOptionValue()) Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$errOpt);
			}
		}
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_form', array('model' => $model, 'description' => $description, 'optionValue' => $this->_optionvalue, 'optionValueDes' => $this->_optionvaluedes, 'optionValueData' => new CArrayDataProvider($this->_optionvalue)), false, true);
			Yii::app()->end();
		}
		$this->render('create', array( 'model' => $model, 'description' => $description, 'optionValue' => $this->_optionvalue, 'optionValueDes' => $this->_optionvaluedes, 'optionValueData' => new CArrayDataProvider($this->_optionvalue)));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, $this->modelName);
		$description = $model->optionDescriptions[0];
		$this->loadOptionValue($model->id);
		$this->performAjaxValidation(array($model,$description), 'option-form');
		
		if (isset($_POST[$this->modelName])) {
			$model->setAttributes($_POST[$this->modelName]);
			$description->setAttributes($_POST[$this->modelName.'Description']);
			$suc = Yii::t('info','Option was successfully updated');
			$err = Yii::t('info','Could not update Option');
			$errOpt = Yii::t('info','Please fill in the name and sort number for each option value');
			if ($model->validate() && $description->validate() && $this->validateOptionValue($model->id)){
				if ($model->save()) {
					$description->option_id = $model->id;
					$description->save();
					
					foreach($this->_optionvalue as $i=>$optionvalue){
						$optionvalue->option_id = $model->id;					
						$optionvalue->save();
						$this->_optionvaluedes[$i]->option_value_id = $optionvalue->id;
						$this->_optionvaluedes[$i]->option_id = $model->id;
						$this->_optionvaluedes[$i]->save();
					}
					foreach($this->delLog as $dmodel)
						$dmodel->delete();
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,$suc);
					if (Yii::app()->getRequest()->getIsAjaxRequest()){
						$this->renderPartial('_view', array( 'model' => $model, 'description' => $description, 'optionValue' => $this->_optionvalue, 'optionValueDes' => $this->_optionvaluedes, 'optionValueData' => new CArrayDataProvider($this->_optionvalue)), false, true);					
						Yii::app()->end();
					}else
						$this->redirect(array('view', 'id' => $model->id));
				}else{
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$err);
				}
			}else{ 
				$description->validate();
				if(!$this->validateOptionValue($model->id)) Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$errOpt);
			}
		}
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_form', array( 'model' => $model, 'description' => $description, 'optionValue' => $this->_optionvalue, 'optionValueDes' => $this->_optionvaluedes, 'optionValueData' => new CArrayDataProvider($this->_optionvalue)), false, true);
			Yii::app()->end();
		}
		$this->render('update', array( 'model' => $model, 'description' => $description, 'optionValue' => $this->_optionvalue, 'optionValueDes' => $this->_optionvaluedes, 'optionValueData' => new CArrayDataProvider($this->_optionvalue)));
	}
		
	public function loadOptionValue($id){
		$data = OptionValue::model()->findAll('option_id=:option_id', array(':option_id'=>$id));
		$this->_optionvalue = $data;
	}
	
	public function validateOptionValue($id = null){
		if(isset($_POST['OptionValue']))
		{
			$valid=true;
			$processLog = $this->delLog = array();
			$optionHold = $this->_optionvalue;
			$this->_optionvalue = array();
			if(isset($_POST['Option']['type']) && $_POST['Option']['type'] != 'select' && $_POST['Option']['type'] != 'radio' && $_POST['Option']['type'] !='checkbox')
				$this->delLog = $optionHold;
			else{
				if(isset($id) && !empty($optionHold)){
					//$optionHold = $this->loadOptionValue($id);
					foreach($optionHold as $t=>$model)
					{					
						$description = $model->optionValueDescriptions[0];
						$delFlag = true;
						foreach($_POST['OptionValue'] as $i=>$item)
						{
							if(isset($_POST['OptionValue'][$i]) && isset($_POST['OptionValueDescription'][$i])){
								if(isset($_POST['OptionValue'][$i]['id']) && intVal($_POST['OptionValue'][$i]['id']) == $model->id){
									$model->attributes =$_POST['OptionValue'][$i];
									$description->attributes = $_POST['OptionValueDescription'][$i];
									$model->name=$_POST['OptionValueDescription'][$i]['name'];
									$valid=$model->validate() && $description->validate() && $valid;
									$this->_optionvalue[$i] = $model;
									$this->_optionvaluedes[$i] = $description;
									$delFlag = false;
									$processLog[] = $i;
									break;
								}
							}
						}
						if($delFlag)
							$this->delLog[] = $model;
					}
				}
				foreach($_POST['OptionValue'] as $i=>$item)
				{
					if(empty($processLog) || !in_array($i,$processLog)){
						$model = new OptionValue;
						$description = new OptionValueDescription;

						if(isset($_POST['OptionValue'][$i]) && isset($_POST['OptionValueDescription'][$i])){
							$model->attributes =$_POST['OptionValue'][$i];
							$description->attributes = $_POST['OptionValueDescription'][$i];
							$model->option_id=0;
							$model->name=$_POST['OptionValueDescription'][$i]['name'];
							$description->option_value_id = 0;
							$description->option_id = 0;
							$description->locale_code = Yii::app()->getLanguage();
							$valid=$model->validate() && $description->validate() && $valid;
							$this->_optionvalue[$i] = $model;
							$this->_optionvaluedes[$i] = $description;
						}
					}
				}

				if(!$valid)
					return false;
			}
		}
		return true;
	}
	
	public function actionSort()
	{
		if (isset($_POST['items']) && is_array($_POST['items'])) {
			$i = 0;
			foreach ($_POST['items'] as $item) {
				$project = Option::model()->findByPk($item);
				$project->sort_order = $i;
				$project->save();
				$i++;
			}
		}
	}
	
	public function actionGetOptionValue($id){
		echo CJSON::encode(Editable::source(OptionValue::model()->findAll('option_id=:option_id', array(':option_id'=>$id),'id','function($data){return $data->getName;}')));
	}
	
	public function actionDelete($id) {
			parent::delete($id, $this->modelName, array('optionDescriptions'));
	}
	
	public function actionBatchDelete() {
			parent::batchDelete($this->modelName, array('optionDescriptions'));
	}
	
	public function actionExportSelected() {
		$criteriaWith = array();
		$exportfield = array(
		'id',
		'type',
		'sort_order',
		);
		 		$criteriaWith = array(
			'optionDescriptions'=>array(
                          'together'=>true
                     ),
		);
		parent::exportSelected($this->modelName, 't.id', $criteriaWith, $exportfield);
	}
	
	public function actionExportAll() {
		$criteriaWith = array();
		$exportfield = array(
		'id',
		'type',
		'sort_order',
		);
		$criteriaWith = array(
			'optionDescriptions'=>array(
                          'together'=>true
                     ),
		);
		
		parent::exportAll($this->modelName, $criteriaWith, $exportfield);
	}

	public function actionIndex() {
		$dorder = '';
		$modelName = $this->modelName;
		if($modelName::model()->hasAttribute('sort_order'))
			$dorder = 't.sort_order ASC';
		else if($modelName::model()->hasAttribute('id'))
			$dorder = 't.id DESC';
		$criteriaWith = $attr = array();
		$criteriaWith = array(
			'optionDescriptions'=>array(
                          'together'=>true
                     ),
		);
		$attr['name'] = array('asc' => 'optionDescriptions.name ASC', 'desc' => 'optionDescriptions.name DESC');
		
		$attr[] = '*';
		$sort = array( 'defaultOrder' => $dorder, 'attributes' => $attr);
		parent::index($this->modelName, $sort, $criteriaWith);
	}

	public function actionAdmin() {
		$model = new Option('search');
		parent::admin($model, $this->modelName);	
	}
}
