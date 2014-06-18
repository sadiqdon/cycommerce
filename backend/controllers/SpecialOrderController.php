<?php

class SpecialOrderController extends CrudController
{
	public $modelName = 'SpecialOrder';
	
	public function actionView($id) {
		parent::view($id, $this->modelName);
	}

	public function actionCreate() {
		$model = new SpecialOrder;
		
		$this->performAjaxValidation($model, 'special-order-form');
		
		if (isset($_POST[$this->modelName])) {
			$model->setAttributes($_POST[$this->modelName]);
			$model->country_id = 156;
			$model->ip = Yii::app()->request->userHostAddress;
			$model->user_agent = Yii::app()->request->userAgent;
			//$model->order_status_id = 1;
			//UtilityHelper::sendToLog($model->order_status_id);
			$model->payment_code = uniqid().rand(1,9);
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
				parent::update($id, $this->modelName, 'special-order-form');
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
		'product_name',
		'product_quantity',
		'product_colour',
		'specification',
		'comment',
		'payment_code',
		'firstname',
		'lastname',
		'email',
		'telephone',
		'total',
		'order_status_id',
		'address_1',
		'address_2',
		'city',
		'postal_code',
		'country_id',
		'zone_id',
		'ip',
		'forwarded_ip',
		'user_agent',
		'date_added',
		'date_modified',
		);
		 		parent::exportSelected($this->modelName, 't.id', $criteriaWith, $exportfield);
	}
	
	public function actionExportAll() {
		$criteriaWith = array();
		$exportfield = array(
		'id',
		'product_name',
		'product_quantity',
		'product_colour',
		'specification',
		'comment',
		'payment_code',
		'firstname',
		'lastname',
		'email',
		'telephone',
		'total',
		'order_status_id',
		'address_1',
		'address_2',
		'city',
		'postal_code',
		'country_id',
		'zone_id',
		'ip',
		'forwarded_ip',
		'user_agent',
		'date_added',
		'date_modified',
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
		$model = new SpecialOrder('search');
		parent::admin($model, $this->modelName);	
	}
}
