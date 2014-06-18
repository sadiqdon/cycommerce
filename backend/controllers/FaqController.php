<?php

class FaqController extends CrudController
{
	public $modelName = 'Faq';
	
	public function actionView($id) {
		parent::view($id, $this->modelName);
	}

	public function actionCreate() {		
		$model = new Faq;
		$description = new FaqDescription;
		if(isset($_POST['FaqDescription'])){
			$suc = Yii::t('info','Attribute was successfully created');
			$err = Yii::t('info','Could not update Attribute');
			
			$description->setAttributes($_POST['FaqDescription']);
			$description->faq_id = 0;
			$description->locale_code = Yii::app()->getLanguage();
			
			if ($model->validate() && $description->validate()){
				if ($model->save()){
					$description->faq_id = $model->id;
					$description->save();
					
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,$suc);
					if (Yii::app()->getRequest()->getIsAjaxRequest()){
						$this->renderPartial('_view', array('model' => $model), false, true);					
						Yii::app()->end();
					}else
						$this->redirect(array('view', 'model' => $model));
				}else{
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$err);
				}
					
			}
		}
		$this->render('create', array( 'model' => $model, 'description' => $description, 'title' => $description));
	}


		
		

	public function actionUpdate($id) {
		$model = $this->loadModel($id, $this->modelName);
				parent::update($id, $this->modelName, 'faq-form');
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
		);
		 		parent::exportSelected($this->modelName, 't.id', $criteriaWith, $exportfield);
	}
	
	public function actionExportAll() {
		$criteriaWith = array();
		$exportfield = array(
		'id',
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
		$model = new Faq('search');
		parent::admin($model, $this->modelName);	
	}
}
