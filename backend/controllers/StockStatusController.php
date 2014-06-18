<?php

class StockStatusController extends CrudController
{
	public $modelName = 'StockStatus';
	
	public function actionView($id) {
		parent::view($id, $this->modelName);
	}

	public function actionCreate() {		
		$model = new StockStatus;
		
		$this->performAjaxValidation($model, 'stock-status-form');
		
		if (isset($_POST[$this->modelName])) {
			$model->setAttributes($_POST[$this->modelName]);
			$model->locale_code = Yii::app()->getLanguage();
			$suc = Yii::t('info',$this->modelName.' was successfully created');
			$err = Yii::t('info',$this->modelName.' could not be created');
			if ($model->save()) {
				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,$suc);
				if (Yii::app()->getRequest()->getIsAjaxRequest()){
					$this->renderPartial('_view', array('model' => $model), false, true);					
					Yii::app()->end();
				}else
					$this->redirect(array('view', 'id' => $model->id));
			}else{
				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$err);
			}
		}
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_form', array('model' => $model), false, true);
			Yii::app()->end();
		}
		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, $this->modelName);
		parent::update($id, $this->modelName, 'stock-status-form');
	}
	
	public function actionDelete($id) {
			parent::delete($id, $this->modelName);
			}
	
	public function actionBatchDelete() {
			parent::batchDelete($this->modelName);
		}
	
	public function actionExportSelected() {
		$criteriaWith = array();
		$exportfield = array(
		'id',
		'locale_code',
		'name',
		);
		 		parent::exportSelected($this->modelName, 't.id', $criteriaWith, $exportfield);
	}
	
	public function actionExportAll() {
		$criteriaWith = array();
		$exportfield = array(
		'id',
		'locale_code',
		'name',
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
		
		$attr[] = '*';
		$sort = array( 'defaultOrder' => $dorder, 'attributes' => $attr);
		parent::index($this->modelName, $sort, $criteriaWith);
	}

	public function actionAdmin() {
		$model = new StockStatus('search');
		parent::admin($model, $this->modelName);	
	}
}
