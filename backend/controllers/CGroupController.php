<?php

class CGroupController extends CrudController
{
	public $modelName = 'CGroup';
	
	public function actionView($id) {
		parent::view($id, $this->modelName);
	}

	public function actionCreate() {		
		$model = new CGroup;
		$description = new CGroupDescription;
		$this->performAjaxValidation(array($model,$description), 'cgroup-form');
		
		if (isset($_POST['CGroupDescription'])) {
			//$model->setAttributes($_POST[$this->modelName]);
			$description->setAttributes($_POST[$this->modelName.'Description']);
			$suc = Yii::t('info','CGroup was successfully created');
			$err = Yii::t('info','Could not update CGroup');
			$description->c_group_id = 0;
			$description->locale_code = Yii::app()->getLanguage();
			if ($model->validate() && $description->validate()){
				if ($model->save()) {
					$description->c_group_id = $model->id;
					$description->save();
					
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,$suc);
					if (Yii::app()->getRequest()->getIsAjaxRequest()){
						$this->renderPartial('_view', array('model' => $model, 'description' => $description), false, true);					
						Yii::app()->end();
					}else
						$this->redirect(array('view', 'id' => $model->id));
				}else{
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$err);
				}
			}else $description->validate();
			UtilityHelper::sendToLog($model->getErrors());
			UtilityHelper::sendToLog($description->getErrors());
		}
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_form', array('model' => $model, 'description' => $description), false, true);
			Yii::app()->end();
		}
		$this->render('create', array( 'model' => $model, 'description' => $description));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, $this->modelName);
		$description = $model->cGroupDescriptions[0];
		$this->performAjaxValidation(array($model,$description), 'cgroup-form');
		
		if (isset($_POST['CGroupDescription'])) {
			//$model->setAttributes($_POST[$this->modelName]);
			$description->setAttributes($_POST[$this->modelName.'Description']);
			$suc = Yii::t('info','CGroup was successfully updated');
			$err = Yii::t('info','Could not update CGroup');
			if ($model->validate() && $description->validate()){
				if ($model->save()) {
					$description->c_group_id = $model->id;
					$description->save();
					
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,$suc);
					if (Yii::app()->getRequest()->getIsAjaxRequest()){
						$this->renderPartial('_view', array('model' => $model, 'description' => $description), false, true);					
						Yii::app()->end();
					}else
						$this->redirect(array('view', 'id' => $model->id));
				}else{
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$err);
				}
			}else $description->validate();
		}
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_form', array('model' => $model, 'description' => $description), false, true);
			Yii::app()->end();
		}
		$this->render('update', array( 'model' => $model, 'description' => $description));
	}
	
	public function actionDelete($id) {
			parent::delete($id, $this->modelName, array('cGroupDescriptions'));
	}
	
	public function actionBatchDelete() {
			parent::batchDelete($this->modelName, array('cGroupDescriptions'));
	}
	
	public function actionExportSelected() {
		$criteriaWith = array();
		$exportfield = array(
		'id',
		);
		 		$criteriaWith = array(
			'cGroupDescriptions'=>array(
                          'together'=>true
                     ),
		);
		parent::exportSelected($this->modelName, 't.id', $criteriaWith, $exportfield);
	}
	
	public function actionExportAll() {
		$criteriaWith = array();
		$exportfield = array(
		'id',
		);
		$criteriaWith = array(
			'cGroupDescriptions'=>array(
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
			'cGroupDescriptions'=>array(
                          'together'=>true
                     ),
		);
		$attr['name'] = array('asc' => 'cGroupDescriptions.name ASC', 'desc' => 'cGroupDescriptions.name DESC');
		
		$attr[] = '*';
		$sort = array( 'defaultOrder' => $dorder, 'attributes' => $attr);
		parent::index($this->modelName, $sort, $criteriaWith);
	}

	public function actionAdmin() {
		$model = new CGroup('search');
		parent::admin($model, $this->modelName);	
	}
}
