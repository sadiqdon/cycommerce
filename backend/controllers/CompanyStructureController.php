<?php

class CompanyStructureController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'CompanyStructure'),
		));
	}

	public function actionCreate() {
		$model = new CompanyStructure;


		if (isset($_POST['CompanyStructure'])) {
			$model->setAttributes($_POST['CompanyStructure']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest()){
					if(isset($_POST['inlet'])){
						$this->renderPartial('_form', array('model' => $model,), false, true);
					}
					Yii::app()->end();
				}else
					$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'CompanyStructure');


		if (isset($_POST['CompanyStructure'])) {
			$model->setAttributes($_POST['CompanyStructure']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'CompanyStructure')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('CompanyStructure');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new CompanyStructure('search');
		$model->unsetAttributes();

		if (isset($_GET['CompanyStructure']))
			$model->setAttributes($_GET['CompanyStructure']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}