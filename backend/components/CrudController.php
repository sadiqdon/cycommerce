<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class CrudController extends Controller
{

	public function view($id, $modelName) {
		$model = $this->loadModel($id, $modelName);
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_view', array('model' => $model), false, true);	
			Yii::app()->end();
		}
		$this->render('view', array(
			'model' => $model,
		));
	}

	public function create($model, $modelName, $formID) {
		
		$this->performAjaxValidation($model, $formID);
		
		if (isset($_POST[$modelName])) {
			$model->setAttributes($_POST[$modelName]);
			$suc = Yii::t('info',$modelName.' was successfully created');
			$err = Yii::t('info',$modelName.' could not be created');
			if ($model->save()) {
				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,$suc);
				if (Yii::app()->getRequest()->getIsAjaxRequest()){
					$this->renderPartial('_view', array('model' => $model), false, true);					
					Yii::app()->end();
				}else
					$this->redirect(array('view', 'id' => $model->id));
			}else{
				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$err);
			}
		}
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_form', array('model' => $model), false, true);
			Yii::app()->end();
		}
		$this->render('create', array( 'model' => $model));
	}

	public function update($id, $modelName, $formID) {
		$model = $this->loadModel($id, $modelName);
		
		$this->performAjaxValidation($model, $formID);

		if (isset($_POST[$modelName])) {
			$model->setAttributes($_POST[$modelName]);
			$suc = Yii::t('info','The record was successfully updated');
			$err = Yii::t('info','The record could not be updated');
			if ($model->save()) {
				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,$suc);
				if (Yii::app()->getRequest()->getIsAjaxRequest()){					
					$this->renderPartial('_view', array('model' => $model), false, true);
					Yii::app()->end();
				}else
					$this->redirect(array('view', 'id' => $model->id));
			}else{
				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$err);
			}
		}
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_form', array('model' => $model), false, true);
			Yii::app()->end();
		}
		$this->render('update', array(
				'model' => $model,
				));
	}

	public function delete($id, $modelName, $relations = array()) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$suc = Yii::t('info','The record was successfully deleted');
			$err = Yii::t('info','The record could not be deleted');
			$mesg = $suc;
			$stat = 'success';
			$model = $this->loadModel($id, $modelName);
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
				if(!empty($extraModels)){
					foreach($extraModels as $m){
						$m->delete();
					}
				}
				if($model->delete()){									
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,$mesg);
					$mesg = $this->createUrl('admin');
				}else{
					$mesg = $err;
					$stat = 'error';
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$mesg);
				}
			}catch (CDbException $e){
				if($e->getCode()===23000){
					$mesg = "Another model is using the model you attempted to delete.";
					$stat = 'error';
					header("HTTP/1.0 400 Model Relation Restriction");
				}else{
					throw $e;
				}
			}
			
			if (Yii::app()->getRequest()->getIsAjaxRequest()){
				echo json_encode(array($stat => $mesg));
			}else{				
				$this->redirect(array('admin'));
			}
		} else
			throw new CHttpException(400, Yii::t('info', 'Your request is invalid.'));
	}
	
	public function batchDelete($modelName, $relations = array()) {
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
				
				foreach ($ids as $id) {
					$model = $this->loadModel($id, $modelName);
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
				}				
				$mesg = $err;
				if(!$fail){
					$stat = 'success';
					$mesg = $suc;
				}
			}else{
				$mesg = Yii::t('info','No record was selected');
			}
			if (Yii::app()->getRequest()->getIsAjaxRequest()){
				echo json_encode(array($stat => $mesg));
			}else{
				$this->redirect(array('admin'));
			}
		} else
			throw new CHttpException(400, Yii::t('info', 'Your request is invalid.')); 
	}
	
	public function exportSelected($modelName, $pk, $criteriaWith = array(), $exportfield = array()) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$ids = $_POST['ids'];
			if(!empty($ids)){
				$nids = explode(',',$ids);
			
				$criteria=new CDbCriteria;
				if(!empty($criteriaWith))
					$criteria->with = $criteriaWith;
				$criteria->addInCondition($pk,$nids);
				$dataProvider=new CActiveDataProvider($modelName, array(
					'criteria'=>$criteria,
				));
				$this->export($dataProvider, $modelName, $exportfield);
				Yii::app()->end();
			}
		} 
		throw new CHttpException(400, Yii::t('info', 'Your request is invalid.'));
	}
	
	public function exportAll($modelName, $criteriaWith = array(), $exportfield = array()) {
		
		//$criteria->with=array('author'=>array('select'=>'username'));
		$criteria=new CDbCriteria;
		if(!empty($criteriaWith))
			$criteria->with = $criteriaWith;
		
		$dataProvider = new CActiveDataProvider($modelName, array(
			'criteria'=>$criteria
		));
		$this->export($dataProvider, $modelName, $exportfield);
	}
	
	private function export($dataP, $modelName, $exportfield){
		if(empty($exportfield)){
			foreach($modelName::model()->getAttributes() as $name=>$val){
				$exportfield[] = $name;
			}
		}
		$this->toExcel($dataP,
			$exportfield,
			$modelName,
			array(
				'creator' => 'CyCommerce',
			),
			'Excel2007'
		);
	}
	
	public function index($modelName, $sort, $criteriaWith = array()){		
		$criteria=new CDbCriteria;		
		
		if(!empty($criteriaWith))
			$criteria->with = $criteriaWith;
			
		$dataProvider = new CActiveDataProvider($modelName, array(
			'criteria'=>$criteria,
			'sort' => $sort,
			'pagination'=>array(
				'pageSize'=>100,
			),
		));
		
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_list', array('dataProvider' => $dataProvider), false, true);	
			//$this->renderPartial('_list', array('dataProvider' => $dataProvider));					
			Yii::app()->end();
		}
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function admin($model, $modelName) {
		$model->unsetAttributes();

		if (isset($_GET[$modelName]))
			$model->setAttributes($_GET[$modelName]);
			
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_manage', array('model' => $model), false, true);	
			//$this->renderPartial('_manage', array('model' => $model));	
			Yii::app()->end();
		}

		$this->render('admin', array(
			'model' => $model,
		));
	}
	
	public function actionUpload() {
		$svar = 'images';
		if(isset($_GET['svar']))
			$svar = $_GET['svar'];
		//Here we define the paths where the files will be stored temporarily

		$path = realpath( UtilityHelper::yiiparam('frontPath')."/www/uploads/tmp/" )."/";
		$publicPath = Yii::app( )->getBaseUrl( )."/uploads/tmp/";
	
		//This is for IE which doens't handle 'Content-type: application/json' correctly
		header( 'Vary: Accept' );
		if( isset( $_SERVER['HTTP_ACCEPT'] ) 
			&& (strpos( $_SERVER['HTTP_ACCEPT'], 'application/json' ) !== false) ) {
			header( 'Content-type: application/json' );
		} else {
			header( 'Content-type: text/plain' );
		}
	 
		//Here we check if we are deleting and uploaded file
		if( isset( $_GET["_method"] ) ) {
			if( $_GET["_method"] == "delete" ) {
				if( $_GET["file"][0] !== '.' ) {
					$file = $path.$_GET["file"];
					if( is_file( $file ) ) {
						unlink( $file );
					}
				}
				$uImages = $nuImages = Yii::app()->user->getState($svar);
				foreach($nuImages as $i=>$image){
					if($image["filename"] == $_GET["file"]){
						unset($uImages[$i]);
						Yii::app()->user->setState( $svar, $uImages );
						break;
					}
				}
				if(count($uImages) == 0 )
					Yii::app()->user->setState( $svar, NULL );
					
				//echo json_encode( array('success'=>true) );
				echo json_encode( array('success'=>$uImages) );
			}
		} else {
			$model = new XUploadForm;
			$model->file = CUploadedFile::getInstance( $model, 'file' );
			//We check that the file was successfully uploaded
			if( $model->file !== null ) {
				//Grab some data
				$model->mime_type = $model->file->getType( );
				$model->size = $model->file->getSize( );
				$model->name = $model->file->getName( );
				//(optional) Generate a random name for our file
				$filename = md5( Yii::app( )->user->id.microtime( ).$model->name);
				$filename .= ".".$model->file->getExtensionName( );
				if( $model->validate() ) {
					//Move our file to our temporary dir
					//Yii::log( "Could not save Image:\n".$path.$filename, CLogger::LEVEL_ERROR );
					//UtilityHelper::sendToLog()
					$model->file->saveAs( $path.$filename );
					chmod( $path.$filename, 0777 );
									
					//here you can also generate the image versions you need 
					//using something like PHPThumb
	 
	 
					//Now we need to save this path to the user's session
					if( Yii::app( )->user->hasState( $svar ) ) {
						$userImages = Yii::app( )->user->getState( $svar );
					} else {
						$userImages = array();
					}
					 $userImages[] = array(
						"path" => $path.$filename,
						//the same file or a thumb version that you generated
						"thumb" => $path.$filename,
						"filename" => $filename,
						'size' => $model->size,
						'mime' => $model->mime_type,
						'name' => $model->name,
					);
					Yii::app( )->user->setState( $svar, $userImages );
	 
					//Now we need to tell our widget that the upload was succesfull
					//We do so, using the json structure defined in
					// https://github.com/blueimp/jQuery-File-Upload/wiki/Setup
					echo json_encode( array( "files" => array(array(
							"name" => $model->name,
							"type" => $model->mime_type,
							"size" => $model->size,
							"url" => $publicPath.$filename,
							"thumbnailUrl" => $publicPath."thumbs/$filename",
							"deleteUrl" => $this->createUrl( "upload", array(
								"_method" => "delete",
								"svar" => $svar,
								"file" => $filename
							) ),
							"deleteType" => "DELETE"
						) ) ), JSON_UNESCAPED_SLASHES);
				} else {
					//If the upload failed for some reason we log some data and let the widget know
					echo json_encode( array( 
						array( "error" => $model->getErrors( 'file' ),
					) ) );
					Yii::log( "UploadAction: ".CVarDumper::dumpAsString( $model->getErrors( ) ),
						CLogger::LEVEL_ERROR, "actions.Upload" 
					);
				}
			} else {
				throw new CHttpException( 500, "Could not upload file" );
			}
		}
	}
	
	
	public function deleteImages($model,$relate = 'images') {
		foreach($model->$relate as $image)
			$image->delete();
	}
	
	public function loadImages($model, $svar = 'images', $relation = 'images') {

		/*if( Yii::app()->request->urlReferrer == Yii::app()->request->hostInfo.Yii::app()->request->url ) {
			$userImages = Yii::app( )->user->getState( $svar );
		} else {*/
			Yii::app( )->user->setState( $svar, NULL );
			$path = UtilityHelper::yiiparam('frontPath')."/www";
			$userImages = array();
			foreach($model->$relation as $image){
				$tp = explode("/",$image->source);
				
				$userImages[] = array(
					"path" => $path.$image->source,
					//the same file or a thumb version that you generated
					"thumb" => $path.$image->source,
					"filename" => $tp[count($tp)-1],
					'size' => $image->size,
					'mime' => $image->mime,
					'name' => $image->name,
				);
			}
			if(count($userImages)>0)
				Yii::app( )->user->setState( $svar, $userImages );
		//}
		
	}
	
	public function addImages($id, $imageClass, $svar = 'images', $model_name) {
		//If we have pending images
		$class = $imageClass;
		if( Yii::app()->user->hasState( $svar ) ) {
			$userImages = Yii::app()->user->getState( $svar );
			//Resolve the final path for our images
			$path = UtilityHelper::yiiparam('frontPath')."/www/uploads/{$id}/";
			//Create the folder and give permissions if it doesnt exists
			if( !is_dir( $path ) ) {
				mkdir( $path );
				chmod( $path, 0777 );
			}
	 
			//Now lets create the corresponding models and move the files
			//$image = $userImages[0];
						
			foreach( $userImages as $image ) {
				if( is_file( $image["path"] ) ) {
					if( rename( $image["path"], $path.$image["filename"] ) ) {
						chmod( $path.$image["filename"], 0777 );
						$img = new $imageClass;
						$img->size = $image["size"];
						$img->mime = $image["mime"];
						$img->name = $image["name"];
						$img->source = "/uploads/{$id}/".$image["filename"];
						if(isset($image["sort_order"]))
							$img->sort_order = $image["sort_order"];
						if($class == 'ProductImage'){
							$img->product_id = $id;							
						}else{
							$img->model_name = $model_name;
							$img->model_id = $id;
						}
						
						if( !$img->save() ) {
							//Its always good to log something
							Yii::log( "Could not save Image:\n".CVarDumper::dumpAsString( 
								$img->getErrors() ), CLogger::LEVEL_ERROR );
							//this exception will rollback the transaction
							//print_r($img->getErrors());
							throw new Exception( 'Could not save Image');
						}
					}
				} else {
					//You can also throw an execption here to rollback the transaction
					//echo $image["path"]." is not a file";
					Yii::log( $image["path"]." is not a file:\n".CVarDumper::dumpAsString( 
								$userImages), CLogger::LEVEL_WARNING );
				}
			}
			//Clear the user's session
			Yii::app()->user->setState( $svar, NULL );
		}
	}
	
	/**
	 * Performs the AJAX validation.
	 * #MethodTracker
	 * This method is based on the gii generated method controller::performAjaxValidation, from version 1.1.7 (r3135). Changes:
	 * <ul>
	 * <li>Supports multiple models.</li>
	 * </ul>
	 * @param CModel|array $model The model or array of models to be validated.
	 * @param string $form The name of the form. Optional.
	 */
	protected function performAjaxValidation($model, $form = null) {
		if (Yii::app()->getRequest()->getIsAjaxRequest() && (($form === null) || (isset($_POST['ajax']) && $_POST['ajax'] == $form))) {
			echo GxActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/**
	 * Returns the data model based on the primary key or another attribute.
	 * This method is designed to work with the values passed via GET.
	 * If the data model is not found or there's a malformed key, an
	 * HTTP exception will be raised.
	 * #MethodTracker
	 * This method is based on the gii generated method controller::loadModel, from version 1.1.7 (r3135). Changes:
	 * <ul>
	 * <li>Support to composite PK.</li>
	 * <li>Support to use any attribute (column) name besides the PK.</li>
	 * <li>Support to multiple attributes.</li>
	 * <li>Automatically detects the PK column names.</li>
	 * </ul>
	 * @param mixed $key The key or keys of the model to be loaded.
	 * If the key is a string or an integer, the method will use the tables' PK if
	 * the PK has a single column. If the table has a composite PK and the key
	 * has a separator (see below), the method will detect it and use it.
	 * <pre>
	 * $key = '12-27'; // PK values with separator for tables with composite PK.
	 * </pre>
	 * If $key is an array, it can be indexed by integers or by attribute (column)
	 * names, as for {@link CActiveRecord::findByAttributes}.
	 * If the array doesn't have attribute names, as below, the method will use
	 * the table composite PK.
	 * <pre>
	 * $key = array(
	 *   12,
	 *   27,
	 *   ...,
	 * );
	 * </pre>
	 * If the array is indexed by attribute names, as below, the method will use
	 * the attribute names to search for and load the model.
	 * <pre>
	 * $key = array(
	 *   'model_id' => 44,
	 * 	 ...,
	 * );
	 * </pre>
	 * Warning: each attribute used should have an index on the database and the set of
	 * attributes used should identify only one item on the database (the attributes being
	 * ideally part of or multiple unique keys).
	 * @param string $modelClass The model class name.
	 * @return GxActiveRecord The loaded model.
	 * @see GxActiveRecord::pkSeparator
	 * @throws CHttpException if there's an invalid request (with code 400) or if the model is not found (with code 404).
	 */
	public function loadModel($key, $modelClass) {

		// Get the static model.
		$staticModel = GxActiveRecord::model($modelClass);

		if (is_array($key)) {
			// The key is an array.
			// Check if there are column names indexing the values in the array.
			reset($key);
			if (key($key) === 0) {
				// There are no attribute names.
				// Check if there are multiple PK values. If there's only one, start again using only the value.
				if (count($key) === 1)
					return $this->loadModel($key[0], $modelClass);

				// Now we will use the composite PK.
				// Check if the table has composite PK.
				$tablePk = $staticModel->getTableSchema()->primaryKey;
				if (!is_array($tablePk))
					throw new CHttpException(400, Yii::t('info', 'Your request is invalid.'));

				// Check if there are the correct number of keys.
				if (count($key) !== count($tablePk))
					throw new CHttpException(400, Yii::t('info', 'Your request is invalid.'));

				// Get an array of PK values indexed by the column names.
				$pk = $staticModel->fillPkColumnNames($key);

				// Then load the model.
				$model = $staticModel->findByPk($pk);
			} else {
				// There are attribute names.
				// Then we load the model now.
				$model = $staticModel->findByAttributes($key);
			}
		} else {
			// The key is not an array.
			// Check if the table has composite PK.
			$tablePk = $staticModel->getTableSchema()->primaryKey;
			if (is_array($tablePk)) {
				// The table has a composite PK.
				// The key must be a string to have a PK separator.
				if (!is_string($key))
					throw new CHttpException(400, Yii::t('info', 'Your request is invalid.'));

				// There must be a PK separator in the key.
				if (stripos($key, $staticModel->pkSeparator) === false)
					throw new CHttpException(400, Yii::t('info', 'Your request is invalid.'));

				// Generate an array, splitting by the separator.
				$keyValues = explode($staticModel->pkSeparator, $key);

				// Start again using the array.
				return $this->loadModel($keyValues, $modelClass);
			} else {
				// The table has a single PK.
				// Then we load the model now.
				$model = $staticModel->findByPk($key);
			}
		}

		// Check if we have a model.
		if ($model === null)
			throw new CHttpException(404, Yii::t('info', 'The requested page does not exist.'));

		return $model;
	}
}
