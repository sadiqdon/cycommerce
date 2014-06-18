<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends CrudController
{
	public $modelName = '<?php echo $this->modelClass; ?>';
	
	public function actionView($id) {
		parent::view($id, $this->modelName);
	}

	public function actionCreate() {		
		$model = new <?php echo $this->modelClass; ?>;
		<?php $descrip = $this->getDescriptions($this->modelClass);
		$dFK = CActiveRecord::model($this->modelClass)->tableName().'_id';
		if(empty($descrip)){ ?>
		parent::create($model, $this->modelName, '<?php echo $this->class2id($this->modelClass)?>-form');
		<?php }else{ ?>
$description = new <?php echo $this->modelClass.'Description'; ?>;
		$this->performAjaxValidation(array($model,$description), '<?php echo $this->class2id($this->modelClass)?>-form');
		
		if (isset($_POST[$this->modelName])) {
			$model->setAttributes($_POST[$this->modelName]);
			$description->setAttributes($_POST[$this->modelName.'Description']);
			$suc = Yii::t('info','<?php echo $this->modelClass; ?> was successfully created');
			$err = Yii::t('info','Could not update <?php echo $this->modelClass; ?>');
			$description-><?php echo $dFK; ?> = 0;
			$description->locale_code = Yii::app()->getLanguage();
			if ($model->validate() && $description->validate()){
				if ($model->save()) {
					$description-><?php echo $dFK; ?> = $model-><?php echo $this->tableSchema->primaryKey; ?>;
					$description->save();
					
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,$suc);
					if (Yii::app()->getRequest()->getIsAjaxRequest()){
						$this->renderPartial('_view', array('model' => $model, 'description' => $description), false, true);					
						Yii::app()->end();
					}else
						$this->redirect(array('view', 'id' => $model-><?php echo $this->tableSchema->primaryKey; ?>));
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
<?php } ?>
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, $this->modelName);
		<?php
		if(empty($descrip)){ ?>
		parent::update($id, $this->modelName, '<?php echo $this->class2id($this->modelClass)?>-form');
		<?php }else{ ?>
$description = $model-><?php echo lcfirst($this->modelClass); ?>Descriptions[0];
		$this->performAjaxValidation(array($model,$description), '<?php echo $this->class2id($this->modelClass)?>-form');
		
		if (isset($_POST[$this->modelName])) {
			$model->setAttributes($_POST[$this->modelName]);
			$description->setAttributes($_POST[$this->modelName.'Description']);
			$suc = Yii::t('info','<?php echo $this->modelClass; ?> was successfully updated');
			$err = Yii::t('info','Could not update <?php echo $this->modelClass; ?>');
			if ($model->validate() && $description->validate()){
				if ($model->save()) {
					$description-><?php echo $dFK; ?> = $model-><?php echo $this->tableSchema->primaryKey; ?>;
					$description->save();
					
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,$suc);
					if (Yii::app()->getRequest()->getIsAjaxRequest()){
						$this->renderPartial('_view', array('model' => $model, 'description' => $description), false, true);					
						Yii::app()->end();
					}else
						$this->redirect(array('view', 'id' => $model-><?php echo $this->tableSchema->primaryKey; ?>));
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
<?php } ?>
	}
<?php if(isset($this->tableSchema->columns['sort_order'])) { ?>
	public function actionSort()
	{
		if (isset($_POST['items']) && is_array($_POST['items'])) {
			$i = 0;
			foreach ($_POST['items'] as $item) {
				$project = <?php echo $this->modelClass; ?>::model()->findByPk($item);
				$project->sort_order = $i;
				$project->save();
				$i++;
			}
		}
	}
<?php } ?>
	
	public function actionDelete($id) {
	<?php
	if(empty($descrip)){ ?>
		parent::delete($id, $this->modelName);
		<?php
		}else{ ?>
		parent::delete($id, $this->modelName, array('<?php echo lcfirst($this->modelClass); ?>Descriptions'));
<?php } ?>
	}
	
	public function actionBatchDelete() {
	<?php
	if(empty($descrip)){ ?>
		parent::batchDelete($this->modelName);
	<?php
	}else{ ?>
		parent::batchDelete($this->modelName, array('<?php echo lcfirst($this->modelClass); ?>Descriptions'));
<?php } ?>
	}
	
	public function actionExportSelected() {
		$criteriaWith = array();
		$exportfield = array(
<?php		
		foreach($this->tableSchema->columns as $column)
			echo "\t\t'".$column->name."',\n";?>
		);
		 <?php
	if(!empty($descrip)){ ?>
		$criteriaWith = array(
			'<?php echo lcfirst($this->modelClass); ?>Descriptions'=>array(
                          'together'=>true
                     ),
		);
<?php } ?>
		parent::exportSelected($this->modelName, 't.id', $criteriaWith, $exportfield);
	}
	
	public function actionExportAll() {
		$criteriaWith = array();
		$exportfield = array(
<?php		
		foreach($this->tableSchema->columns as $column)
			echo "\t\t'".$column->name."',\n";?>
		);
<?php
	if(!empty($descrip)){ ?>
		$criteriaWith = array(
			'<?php echo lcfirst($this->modelClass); ?>Descriptions'=>array(
                          'together'=>true
                     ),
		);
<?php } ?>		
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
<?php
	if(!empty($descrip)){ ?>
		$criteriaWith = array(
			'<?php echo lcfirst($this->modelClass); ?>Descriptions'=>array(
                          'together'=>true
                     ),
		);
		$attr['name'] = array('asc' => '<?php echo lcfirst($this->modelClass); ?>Descriptions.name ASC', 'desc' => '<?php echo lcfirst($this->modelClass); ?>Descriptions.name DESC');
<?php } ?>		
		$attr[] = '*';
		$sort = array( 'defaultOrder' => $dorder, 'attributes' => $attr);
		parent::index($this->modelName, $sort, $criteriaWith);
	}

	public function actionAdmin() {
		$model = new <?php echo $this->modelClass; ?>('search');
		parent::admin($model, $this->modelName);	
	}
}
