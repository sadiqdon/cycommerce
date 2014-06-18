<?php

class LogController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	
	private $logPath;
	/**Find a better way**/
	public function __construct($id,$module=null)
	{
	  parent::__construct($id,$module);
	  $this->logPath = Yii::getPathOfAlias('logs');
	}
	
	/**
	 * Lists all log files.
	 */
	public function actionIndex()
	{
		//$this->setLogPath();
		$a_files = CFileHelper::findFiles($this->logPath, array('exclude'=>array('zip')));
		$arr = array();
		foreach($a_files as $k=>$f){
			$arr[] = array('id'=>$k,'name'=>basename($f), 'size'=>filesize($f));
		}
		//print_r($arr);
		$dataProvider=new CArrayDataProvider($arr,array(
			'sort'=>array('attributes'=>array('name','size')),
			'pagination'=>array('pageSize'=>50)
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionDownload()
	{
		//$this->setLogPath();
		$path = $this->logPath.'\\'.$_GET['fname'];
		$zipfile = $this->logPath.'\\zip\\'.$_GET['fname'].'.zip';
		if(isset($_GET['zip']) && $_GET['zip'] == 'yes'){
			$zip=new ZipArchive();
			if($zip->open($zipfile,ZIPARCHIVE::CREATE) === TRUE) {
				$zip->addFile($path, $_GET['fname']);
				$zip->close();
			}
			//return Yii::app()->getRequest()->sendFile($_GET['fname'].'.zip', file_get_contents($zipfile), 'application/zip');
			// Set headers
			 header("Cache-Control: public");
			 header("Content-Description: File Transfer");
			 header("Content-Disposition: attachment; filename={$_GET['fname']}.zip");
			 header("Content-Type: application/zip");
			 header("Content-Transfer-Encoding: binary");
			
			 // Read the file from disk
			 readfile($zipfile);
			 return;
		}
		if(file_exists($path))
		{
			return Yii::app()->getRequest()->sendFile($_GET['fname'], @file_get_contents($path));
		}
	}
	/*//TODO move to init method
	private function setLogPath(){
		$this->logPath = Yii::app()->params['logPath'];
	}*/
}