<?php

class ReturnsController extends CrudController
{
	public $modelName = 'Returns';
	
	public function actionView($id) {
		parent::view($id, $this->modelName);
	}

	public function actionCreate() {		
		$model = new Returns;
				parent::create($model, $this->modelName, 'returns-form');
			}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, $this->modelName);
				parent::update($id, $this->modelName, 'returns-form');
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
		'orderId',
		'customerID',
		'firstname',
		'lastname',
		'email',
		'telephone',
		'productid',
		'model',
		'quantity',
		'return_reason',
		'opened',
		'comment',
		'return_action',
		'return_status',
		'date_added',
		'date_modified',
		);
		 		parent::exportSelected($this->modelName, 't.id', $criteriaWith, $exportfield);
	}
	
	public function actionExportAll() {
		$criteriaWith = array();
		$exportfield = array(
		'id',
		'orderId',
		'customerID',
		'firstname',
		'lastname',
		'email',
		'telephone',
		'productid',
		'model',
		'quantity',
		'return_reason',
		'opened',
		'comment',
		'return_action',
		'return_status',
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
		$model = new Returns('search');
		parent::admin($model, $this->modelName);	
	}
}
