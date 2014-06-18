<?php

/**
 * GxActiveForm class file.
 *
 * @author Rodrigo Coelho <rodrigo@giix.org>
 * @link http://giix.org/
 * @copyright Copyright &copy; 2010-2011 Rodrigo Coelho
 * @license http://giix.org/license/ New BSD License
 */

/**
 * GxActiveForm provides forms with additional features.
 *
 * @author Rodrigo Coelho <rodrigo@giix.org>
 * @package giix.components
 */
class GxActiveForm extends CActiveForm {

	/**
	 * Renders a checkbox list for a model attribute.
	 * This method is a wrapper of {@link GxHtml::activeCheckBoxList}.
	 * #MethodTracker
	 * This method is based on {@link CActiveForm::checkBoxList}, from version 1.1.7 (r3135). Changes:
	 * <ul>
	 * <li>Uses GxHtml.</li>
	 * </ul>
	 * @see CActiveForm::checkBoxList
	 * @param CModel $model The data model.
	 * @param string $attribute The attribute.
	 * @param array $data Value-label pairs used to generate the check box list.
	 * @param array $htmlOptions Addtional HTML options.
	 * @return string The generated check box list.
	 */
	public function checkBoxList($model, $attribute, $data, $htmlOptions = array()) {
		return GxHtml::activeCheckBoxList($model, $attribute, $data, $htmlOptions);
	}
	
	public static function validateMultiple($models, $attributes=null, $loadInput=true)
	{
		$result=array();
		if(!is_array($models))
			$models=array($models);
		foreach($models as $i=>$model)
		{
			if(is_array($_POST[get_class($model)])){
				foreach($_POST[get_class($model)] as $j=>$m){
					if($loadInput && isset($_POST[get_class($model)][$j]))
						$model->attributes=$_POST[get_class($model)][$j];
					$model->validate($attributes);
					foreach($model->getErrors() as $attribute=>$errors)
						$result[CHtml::activeId($model,'['.$j.']'.$attribute)]=$errors;
				}
			}else{
				if($loadInput && isset($_POST[get_class($model)]))
					$model->attributes=$_POST[get_class($model)];
				$model->validate($attributes);
				foreach($model->getErrors() as $attribute=>$errors)
					$result[CHtml::activeId($model,$attribute)]=$errors;
			}
		}
		return function_exists('json_encode') ? json_encode($result) : CJSON::encode($result);
	}
}