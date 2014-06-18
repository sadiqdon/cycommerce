<?php

/**
 * CyModelCode class file.
 *
 * @author Sadiq Oyapero
 */
Yii::import('system.gii.generators.model.ModelCode');

class CyModelCode extends ModelCode {

	/**
	 * @var string The path of the base model.
	 */
	public $baseModelPath;
	/**
	 * @var string The base model class name.
	 */
	public $baseModelClass;
	
	/**
	 * Prepares the code files to be generated.
	 * This method is based on {@link ModelCode::prepare}, from version 1.1.13. Changes:
	 * <ul>
	 * <li>Generates the base model.</li>
	 * </ul>
	 */
	public function prepare()
	{
		if(($pos=strrpos($this->tableName,'.'))!==false)
		{
			$schema=substr($this->tableName,0,$pos);
			$tableName=substr($this->tableName,$pos+1);
		}
		else
		{
			$schema='';
			$tableName=$this->tableName;
		}
		if($tableName[strlen($tableName)-1]==='*')
		{
			$tables=Yii::app()->{$this->connectionId}->schema->getTables($schema);
			if($this->tablePrefix!='')
			{
				foreach($tables as $i=>$table)
				{
					if(strpos($table->name,$this->tablePrefix)!==0)
						unset($tables[$i]);
				}
			}
		}
		else
			$tables=array($this->getTableSchema($this->tableName));

		$this->files=array();
		$templatePath=$this->templatePath;
		$this->relations=$this->generateRelations();

		foreach($tables as $table)
		{
			$tableName=$this->removePrefix($table->name);
			$className=$this->generateClassName($table->name);
			$params=array(
				'tableName'=>$schema==='' ? $tableName : $schema.'.'.$tableName,
				'modelClass'=>$className,
				'columns'=>$table->columns,
				'labels'=>$this->generateLabels($table),
				'rules'=>$this->generateRules($table),
				'relations'=>isset($this->relations[$className]) ? $this->relations[$className] : array(),
				'connectionId'=>$this->connectionId,
			);
			// Setup base model information.
			$this->baseModelPath = $this->modelPath . '._base';
			$this->baseModelClass = 'Base' . $className;
			// Generate the model.
			$this->files[] = new CCodeFile(
				Yii::getPathOfAlias($this->modelPath . '.' . $className) . '.php',
				$this->render($templatePath . DIRECTORY_SEPARATOR . 'model.php', $params)
			);
			// Generate the base model.
			$this->files[] = new CCodeFile(
				Yii::getPathOfAlias($this->baseModelPath . '.' . $this->baseModelClass) . '.php',
				$this->render($templatePath . DIRECTORY_SEPARATOR . '_base' . DIRECTORY_SEPARATOR . 'basemodel.php', $params)
			);
		}
	}
	
	public function requiredTemplates() {
		return array(
			'model.php',
			'_base' . DIRECTORY_SEPARATOR . 'basemodel.php',
		);
	}
	
	public function getDescriptions($modelClass) {
		$result = array();
		$descriptionClass = $modelClass.'Description';
		$relations = CActiveRecord::model($modelClass)->relations();
		foreach($relations as $name=>$relation){
			if(substr($name, -strlen('Descriptions')) === 'Descriptions'){
				
					$description=CActiveRecord::model($descriptionClass);		
					if(isset($description)){
						foreach ($description->tableSchema->columns as $column){
							if($column->name != 'locale_code' && $column->name != CActiveRecord::model($modelClass)->tableName().'_id'){
								$result[] = $column;
							}
						}
					}
			}
		}
		return $result;
	}
}