<?php

Yii::import('gii.generators.crud.CrudGenerator');
class CyCrudGenerator extends CrudGenerator
{
	public $codeModel='common.gii.generators.cyCrud.CyCrudCode';
	
	/**
	 * Returns the model names in an array.
	 * Only non abstract and subclasses of GxActiveRecord models are returned.
	 * The array is used to build the autocomplete field.
	 * @return array The names of the models
	 */
	protected function getModels() {
		$models = array();
		$files = scandir(Yii::getPathOfAlias('application.models'));
		foreach ($files as $file) {
			if ($file[0] !== '.' && CFileHelper::getExtension($file) === 'php') {
				$fileClassName = substr($file, 0, strpos($file, '.'));
				if (class_exists($fileClassName) && is_subclass_of($fileClassName, 'CActiveRecord')) {
					$fileClass = new ReflectionClass($fileClassName);
					if (!$fileClass->isAbstract())
						$models[] = $fileClassName;
				}
			}
		}
		return $models;
	}
}