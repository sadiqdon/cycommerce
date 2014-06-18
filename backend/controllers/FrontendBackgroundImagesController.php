<?php

class FrontendBackgroundImagesController extends CrudController
{
	public $modelName = 'FrontendBackgroundImages';
	
	public function actionView($id) {
		parent::view($id, $this->modelName);
	}

	//TODO figure out how to clear session if user abandon form after image upload
	public function actionCreate() {		
		$model = new FrontendBackgroundImages;
		$description = new FrontendBackgroundImagesDescription;
		$image = new XUploadForm;
		$this->performAjaxValidation($model, 'frontend-background-images-form');
		$userImages = array();
		if(!isset($_POST[$this->modelName.'Description']))
			Yii::app()->user->setState( 'FrontendBackgroundImg', NULL );
					
		if(isset($_POST[$this->modelName.'Description'])) {
			$model->setAttributes($_POST[$this->modelName]);
			$description->setAttributes($_POST[$this->modelName.'Description']);
			$suc = Yii::t('info','The record was successfully created');
			$err = Yii::t('info','The record could not be created');
			$userImages = Yii::app()->user->getState('FrontendBackgroundImg');
			
			if( Yii::app()->user->hasState('FrontendBackgroundImg') ) {
				$description->frontend_background_images_id = 0;
				$description->locale_code = Yii::app()->getLanguage();
				if ($model->validate() && $description->validate()){
					if ($model->save()) {
						$description->frontend_background_images_id = $model->id;
						$description->save();
						$this->addImages($model->id, 'Image', 'FrontendBackgroundImg','FrontendBackgroundImages');
						Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,$suc);
						if (Yii::app()->getRequest()->getIsAjaxRequest()){
							$this->renderPartial('_view', array('model' => $model), false, true);					
							Yii::app()->end();
						}else
							$this->redirect(array('view', 'id' => $model->id));
					}else{
						Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$err);
					}
				}else $description->validate();
			}else{
				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('info','Please upload an image'));
			}
		}
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_form', array('model' => $model, 'description' => $description, 'image' => $image ,'userImages'=> $userImages), false, true);
			Yii::app()->end();
		}
		$this->render('create', array( 'model' => $model, 'title' => $description, 'image_name' => $image ,'userImages'=> $userImages));
	}

	public function actionUpdate($id) {
		$modelName = $this->modelName;
		$model = $this->loadModel($id, $this->modelName);
		$description = !empty($model->frontendBackgroundImagesDescriptions) ? $model->frontendBackgroundImagesDescriptions[0] : new FrontendBackgroundImagesDescription;
		$image = new XUploadForm;
		//Yii::app()->user->setState( 'FrontendBackgroundImg', NULL );
		if(!isset($_POST[$this->modelName.'Description']))
			$this->loadImages($model, 'FrontendBackgroundImg');
		$this->performAjaxValidation($model, 'frontend-background-images-form');
		
		//

		$userImages = Yii::app( )->user->getState( 'FrontendBackgroundImg' );

		if (isset($_POST[$this->modelName.'Description'])) {
			$model->setAttributes($_POST[$this->modelName]);
			$description->setAttributes($_POST[$this->modelName.'Description']);
			$suc = Yii::t('info','The record was successfully updated');
			$err = Yii::t('info','The record could not be updated');
			//$description->link = str_replace(' ','-',trim(strtolower(str_replace('_','-',preg_replace('/(?<![A-Z])[A-Z]/', '\0', $description->name)))));
			if( Yii::app()->user->hasState('FrontendBackgroundImg') ) {
				if ($model->validate() && $description->validate()){
					if ($model->save()) {
						$description->frontend_background_images_id = $model->id;
						
						$description->save();
						$this->deleteImages($model);
						$this->addImages($model->id, 'Image', 'FrontendBackgroundImg','FrontendBackgroundImages');
						Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,$suc);
						if (Yii::app()->getRequest()->getIsAjaxRequest()){					
							$this->renderPartial('_view', array('model' => $model), false, true);
							Yii::app()->end();
						}else
							$this->redirect(array('view', 'id' => $model->id));
					}else{
						Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$err);
					}
				}else $description->validate();
			}else{
				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('info','Please upload an image'));
			}
		}
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_form', array( 'model' => $model, 'description' => $description, 'image' => $image, 'userImages'=> $userImages), false, true);
			Yii::app()->end();
		}
		$this->render('update', array( 'model' => $model, 'description' => $description, 'image' => $image, 'userImages'=> $userImages));
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
		'image',
		);
		 		parent::exportSelected($this->modelName, 't.id', $criteriaWith, $exportfield);
	}
	
	public function actionExportAll() {
		$criteriaWith = array();
		$exportfield = array(
		'id',
		'image',
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
		$model = new FrontendBackgroundImages('search');
		parent::admin($model, $this->modelName);	
	}
}
