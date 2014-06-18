<?php

class AddressController extends CrudController {

	
	public $modelName = 'Address';
	
	public function actionView($id) {
		parent::view($id, $this->modelName);
	}

	public function actionCreate() {		
		$model = new Address;
		parent::create($model, $this->modelName, 'address-form');
	}

	public function actionUpdate($id) {
		parent::update($id, $this->modelName, 'address-form');
	}
	
	public function actionDelete($id) {
		parent::delete($id, $this->modelName);
	}
	
	public function actionBatchDelete() {
		parent::batchDelete($this->modelName);
	}
	
	public function actionExportSelected() {
		parent::exportSelected($this->modelName);
	}
	
	public function actionExportAll() {
		parent::exportAll($this->modelName);
	}

	public function actionIndex() {
		parent::index($this->modelName);
	}

	public function actionAdmin() {
		$model = new Address('search');
		parent::admin($model, $this->modelName);
	}
}