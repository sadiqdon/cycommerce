<?php
Yii::import('gii.generators.crud.CrudCode');
class CyCrudCode extends CrudCode
{
	/**
	 * @var string The controller base class name.
	 */
	public $baseControllerClass = 'CrudController';
	
	public function getDescriptions($modelClass) {
		$descriptionClass = $modelClass.'Description';
		$relations = CActiveRecord::model($modelClass)->relations();
		$result = array();
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
	public function generateDescriptionActiveLabel($modelClass,$column)
	{
		return "\$form->labelEx(\${$modelClass},'{$column->name}')";
	}

	public function generateDescriptionActiveField($modelClass,$column)
	{
		if($column->type==='boolean')
			return "\$form->checkBox(\${$modelClass},'{$column->name}')";
		elseif(stripos($column->dbType,'text')!==false)
			return "\$form->textArea(\${$modelClass},'{$column->name}',array('rows'=>6, 'cols'=>50))";
		else
		{
			if(preg_match('/^(password|pass|passwd|passcode)$/i',$column->name))
				$inputField='passwordField';
			else
				$inputField='textField';

			if($column->type!=='string' || $column->size===null)
				return "\$form->{$inputField}(\${$modelClass},'{$column->name}')";
			else
			{
				if(($size=$maxLength=$column->size)>60)
					$size=60;
				return "\$form->{$inputField}(\${$modelClass},'{$column->name}',array('size'=>$size,'maxlength'=>$maxLength))";
			}
		}
	}

	
}