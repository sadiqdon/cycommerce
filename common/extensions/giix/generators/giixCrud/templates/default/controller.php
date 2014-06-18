<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends CrudController {

<?php 
	$authpath = 'common.extensions.giix.generators.giixCrud.templates.default.auth.';
	Yii::app()->controller->renderPartial($authpath . $this->authtype);
?>
	
	public $modelName = '<?php echo $this->modelClass; ?>';
	
	public function actionView($id) {
		parent::view($id, $this->modelName);
	}

	public function actionCreate() {		
		$model = new <?php echo $this->modelClass; ?>;
		parent::create($model, $this->modelName, '<?php echo $this->class2id($this->modelClass)?>-form');
	}

	public function actionUpdate($id) {
		parent::update($id, $this->modelName, '<?php echo $this->class2id($this->modelClass)?>-form');
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
		$model = new <?php echo $this->modelClass; ?>('search');
		parent::admin($model, $this->modelName);
	}
}