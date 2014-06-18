<?php

class CategoryController extends CrudController {

	
	public $modelName = 'Category';
	
	public function actionView($id) {
		parent::view($id, $this->modelName);
	}
	//TODO figure out how to clear session if user abandon form after image upload
	public function actionCreate() {		
		$model = new Category;
		$description = new CategoryDescription;
		$image = new XUploadForm;
		$this->performAjaxValidation($model, 'category-form');
		$userImages = array();
		if(!isset($_POST[$this->modelName]))
			Yii::app()->user->setState( 'images', NULL );
			
		 
		if(isset($_POST[$this->modelName])) {
			$model->setAttributes($_POST[$this->modelName]);
			$description->setAttributes($_POST[$this->modelName.'Description']);
			$suc = Yii::t('info','The record was successfully created');
			$err = Yii::t('info','The record could not be created');
			$userImages = Yii::app()->user->getState('images');
			
			if( Yii::app()->user->hasState('images') ) {
				$description->category_id = 0;
				$description->locale_code = Yii::app()->getLanguage();
				//$description->link = str_replace(' ','-',trim(strtolower(str_replace('_','-',preg_replace('/(?<![A-Z])[A-Z]/', '\0', $description->name)))));
				$description->link = strtolower(str_replace(' ','-',preg_replace('!\s+!', ' ', trim(preg_replace("/[^A-Za-z ]/", ' ', $description->name))))); 
				if ($model->validate() && $description->validate()){
					if ($model->save()) {
						$description->category_id = $model->id;
						$description->save();
						$this->addImages($model->id, 'Image', 'images','Category');
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
		$this->render('create', array( 'model' => $model, 'description' => $description, 'image' => $image, 'userImages'=> $userImages));
	}

	public function actionUpdate($id) {
		$modelName = $this->modelName;
		$model = $this->loadModel($id, $this->modelName);
		$description = !empty($model->categoryDescriptions) ? $model->categoryDescriptions[0] : new CategoryDescription;
		$image = new XUploadForm;
		if(!isset($_POST[$this->modelName]))
			$this->loadImages($model);
		$this->performAjaxValidation($model, 'category-form');
		
		//Yii::app()->user->setState( 'images', NULL );

		$userImages = Yii::app( )->user->getState( 'images' );

		if (isset($_POST[$this->modelName])) {
			$model->setAttributes($_POST[$this->modelName]);
			$description->setAttributes($_POST[$this->modelName.'Description']);
			$suc = Yii::t('info','The record was successfully updated');
			$err = Yii::t('info','The record could not be updated');
			$description->link = str_replace(' ','-',trim(strtolower(str_replace('_','-',preg_replace('/(?<![A-Z])[A-Z]/', '\0', $description->name)))));
			if( Yii::app()->user->hasState('images') ) {
				if ($model->validate() && $description->validate()){
					if ($model->save()) {
						$description->category_id = $model->id;
						$description->link = strtolower(str_replace(' ','-',preg_replace('!\s+!', ' ', trim(preg_replace("/[^A-Za-z ]/", ' ', $description->name)))));
						$description->save();
						$this->deleteImages($model);
						$this->addImages($model->id, 'Image', 'images','Category');
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
	
	
	public function actionSort()
    {
        if (isset($_POST['items']) && is_array($_POST['items'])) {
            $i = 0;
            foreach ($_POST['items'] as $item) {
                $project = Category::model()->findByPk($item);
                $project->sort_order = $i;
                $project->save();
                $i++;
            }
        }
    }
    
    public function actionDelete($id) {
			$model = $this->loadModel($id, $this->modelName);
			if(empty($model->categories)){
				$mesg = Yii::t('info','The record could not be deleted');
				$stat = 'error';
				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$mesg);
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					echo json_encode(array($stat => $mesg));
			}
			else{
				parent::delete($id, $this->modelName, array('categoryDescriptions'));
			}
    }
    
    public function actionBatchDelete() {
		$relations = array('categoryDescriptions');
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$mesg = '';
			$stat = 'error';
			if(!empty($_POST['ids'])){
				$ids = $_POST['ids'];
				$fail = false;
				if(!is_array($ids))
					$ids = array($ids);
				
				$suc = Yii::t('info','The selected record(s) were successfully deleted');
				$err = Yii::t('info','Some or all the selected records could not be deleted');
				$mesg = $err;
				foreach ($ids as $id) {
					$model = $this->loadModel($id, $this->modelName);
					if(empty($model->categories)){
						$extraModels = array();
						if(!empty($relations)){
							foreach($relations as $k){
								$relation = $model->$k;
								if(is_array($relation)){
									foreach($relation as $m){
										$extraModels[] = $m;
									}
								}else{ $extraModels[] = $relation; }
							}
						}
						try{
							if($model->delete()){
								if(!empty($extraModels)){
									foreach($extraModels as $m){
										$m->delete();
									}
								}						
							}else {$fail = true;}
						}catch (CDbException $e){
							if($e->getCode()===23000){
								header("HTTP/1.0 400 Model Relation Restriction");
							}else{
								throw $e;
							}
						}
					}else{
						$stat = 'error';
						$mesg = Yii::t('info','Some or all the selected records could not be deleted. "'.$model->getName().'" has one or more categories attached to it.');
						$fail = true;
					}
				}				
				
				if(!$fail){
					$stat = 'success';
					$mesg = $suc;
				}
			}else{
				$mesg = Yii::t('info','No record was selected');
			}
			if (Yii::app()->getRequest()->getIsAjaxRequest()){
				echo json_encode(array($stat => $mesg));
			}
		}else
			throw new CHttpException(400, Yii::t('info', 'Your request is invalid.')); 
    }
    
    public function actionExportSelected() {
        $criteriaWith = array();
        $exportfield = array(
        'id',
        'store_id',
        'parent_id',
        'top',
        'column',
        'sort_order',
        'status',
        'date_added',
        'date_modified',
        );
                 $criteriaWith = array(
            'categoryDescriptions'=>array(
                          'together'=>true
                     ),
        );
        parent::exportSelected($this->modelName, 't.id', $criteriaWith, $exportfield);
    }
    
    public function actionExportAll() {
        $criteriaWith = array();
        $exportfield = array(
        'id',
        'store_id',
        'parent_id',
        'top',
        'column',
        'sort_order',
        'status',
        'date_added',
        'date_modified',
        );
        $criteriaWith = array(
            'categoryDescriptions'=>array(
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
            'categoryDescriptions'=>array(
                          'together'=>true
                     ),
        );
        $attr['name'] = array('asc' => 'categoryDescriptions.name ASC', 'desc' => 'categoryDescriptions.name DESC');
        $attr[] = '*';
        $sort = array( 'defaultOrder' => $dorder, 'attributes' => $attr);
        parent::index($this->modelName, $sort, $criteriaWith);
    }

	public function actionAdmin() {
		$model = new Category('search');
		parent::admin($model, $this->modelName);
	}
}