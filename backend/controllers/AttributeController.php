<?php

class AttributeController extends CrudController
{
	public $modelName = 'Attribute';
	
	public function actionView($id) {
		parent::view($id, $this->modelName);
	}

	public function actionCreate() {		
		$model = new Attribute;
		$description = new AttributeDescription;
		$this->performAjaxValidation(array($model,$description), 'attribute-form');
		
		if (isset($_POST[$this->modelName])) {
			$model->setAttributes($_POST[$this->modelName]);
			$description->setAttributes($_POST[$this->modelName.'Description']);
			$suc = Yii::t('info','Attribute was successfully created');
			$err = Yii::t('info','Could not update Attribute');
			$description->attribute_id = 0;
			$description->locale_code = Yii::app()->getLanguage();
			if ($model->validate() && $description->validate()){
				if ($model->save()) {
					$description->attribute_id = $model->id;
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
		$this->render('create', array( 'model' => $model, 'description' => $description));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, $this->modelName);
		$description = $model->attributeDescriptions[0];
		$this->performAjaxValidation(array($model,$description), 'attribute-form');
		
		if (isset($_POST[$this->modelName])) {
			$model->setAttributes($_POST[$this->modelName]);
			$description->setAttributes($_POST[$this->modelName.'Description']);
			$suc = Yii::t('info','Attribute was successfully updated');
			$err = Yii::t('info','Could not update Attribute');
			if ($model->validate() && $description->validate()){
				if ($model->save()) {
					$description->attribute_id = $model->id;
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
	
	public function actionSort()
	{
		if (isset($_POST['items']) && is_array($_POST['items'])) {
			$i = 0;
			foreach ($_POST['items'] as $item) {
				$project = Attribute::model()->findByPk($item);
				$project->sort_order = $i;
				$project->save();
				$i++;
			}
		}
	}
	
	public function actionDelete($id) {
			parent::delete($id, $this->modelName, array('attributeDescriptions'));
	}
	
	public function actionBatchDelete() {
			parent::batchDelete($this->modelName, array('attributeDescriptions'));
	}
	
	public function actionExportSelected() {
		$criteriaWith = array();
		$exportfield = array(
			'id',
			array(
				'header'=>Yii::t('label','Name'),
				'type'=>'raw',
				'value'=>'$data->getName()', 
			),
			array(
				'header'=>Yii::t('label','Attribute Group'),
				'value'=>'$data->attributeGroup->name', 
			),
			'sort_order',
		);
		$criteriaWith = array(
			'attributeDescriptions'=>array(
                          'together'=>true
                     ),
			'attributeGroup'=>array(
                          'together'=>true
                     )
		);
		parent::exportSelected($this->modelName, 't.id', $criteriaWith, $exportfield);
	}
	
	public function actionExportAll() {
		$criteriaWith = array();
		$exportfield = array(
			'id',
			array(
				'header'=>Yii::t('label','Name'),
				'type'=>'raw',
				'value'=>'$data->getName()', 
			),
			array(
				'header'=>Yii::t('label','Attribute Group'),
				'value'=>'$data->attributeGroup->name', 
			),
			'sort_order',
		);
		$criteriaWith = array(
			'attributeDescriptions'=>array(
                          'together'=>true
                     ),
			'attributeGroup'=>array(
                          'together'=>true
                     )
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
			'attributeDescriptions'=>array(
                          'together'=>true
                     ),
			'attributeGroup'=>array(
                          'together'=>true
                     )
		);
		$attr['name'] = array('asc' => 'attributeDescriptions.name ASC', 'desc' => 'attributeDescriptions.name DESC');
		$attr[] = '*';
		$sort = array( 'defaultOrder' => $dorder, 'attributes' => $attr);
		parent::index($this->modelName, $sort, $criteriaWith);
	}

	public function actionAdmin() {
		$model = new Attribute('search');
		parent::admin($model, $this->modelName);	
	}
}
