<?php

class ThemeController extends CrudController
{
	public $modelName = 'Theme';
	
	public function actionView($id) {
		parent::view($id, $this->modelName);
	}

	public function actionCreate() {
		$model = new Theme();
		$suc = Yii::t('info','The record was successfully created');
		$err = Yii::t('info','The record could not be created');
		
		$zip = new XUploadForm;
		$userZips = array();
		if(!isset($_POST[$this->modelName]))
			Yii::app()->user->setState( 'images', NULL );
		
		if(isset($_POST['Theme'])){
			$model->attributes=$_POST['Theme'];
			
			$userZips = Yii::app()->user->getState('images');
			
			if($model->validate()){
				//$path = Yii::app()->runtimePath.'/dir/'.$model->zip;
				//$img->saveAs('dir/'.$model->name);
				$model->save();
				$path = $userZips[0]["path"];
				$this->unzipTheme($path,$model->name,UtilityHelper::yiiparam('frontPath')."/www/themes");
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,$suc);
				if (Yii::app()->getRequest()->getIsAjaxRequest()){
					$this->renderPartial('_view', array('model' => $model), false, true);					
					Yii::app()->end();
				}else
					$this->redirect(array('view', 'id' => $model->id));
            }else{
				
				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$err);
			}
			UtilityHelper::sendToLog($userZips);
        }
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_form', array('model' => $model, 'zip' => $zip, 'userZips'=> $userZips), false, true);
			Yii::app()->end();
		}
        $this->render('create', array('model'=>$model, 'zip' => $zip, 'userZips'=> $userZips));
	}

	private function unzipTheme($zipFile , $destination = 'default', $themesFolder){
		$zip = new ZipArchive;
		if (is_file($zipFile)) {
			$zip->open($zipFile);
			if(is_dir($themesFolder)){
				if(mkdir($themesFolder."/{$destination}", 0700)){
					$zip->extractTo($themesFolder."/{$destination}");
				}else{
					$zip->close();
					return FALSE;
				}
			}
			$zip->close();
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function actionActivateTheme() {
		$themes = Theme::model()->findAll();
		$suc = Yii::t('info','Theme has been Activated');
		$err = Yii::t('info','Theme was not Activated');	
		if(isset($_POST['Theme']['name'])){
			$valid = Theme::model()->findByAttributes(array('name'=>$_POST['Theme']['name']));
			if(!empty($valid)){
				file_put_contents(UtilityHelper::yiiparam('frontPath')."/config/main-theme.php", $this->getConfigTemplate($_POST['Theme']['name']));	
				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,$suc);
			}
			else{
				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$err);
			}
		}
		else{				
				//Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$err);
			}
		$this->render('activate', array('models'=>$themes));
	}
	
	private function getConfigTemplate($choosenTheme){
		return 	"
<?php
/**
 * prod.php
 *
 * This file will be copied to `../main-theme.php` configuration file for `prod` environment.
 * @see Deploy::createEnvConfigs()
 */
return array(
	'theme' => '{$choosenTheme}',
);

" ;
	
	}
	
	
	public function actionUpdate($id) {
		$model = $this->loadModel($id, $this->modelName);
				parent::update($id, $this->modelName, 'theme-form');
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
		'name',
		'active',
		'zip',
		'time_added',
		);
		 		parent::exportSelected($this->modelName, 't.id', $criteriaWith, $exportfield);
	}
	
	public function actionExportAll() {
		$criteriaWith = array();
		$exportfield = array(
		'id',
		'name',
		'active',
		'zip',
		'time_added',
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
		$model = new Theme('search');
		parent::admin($model, $this->modelName);	
	}
}
