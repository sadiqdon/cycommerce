<?php
class SettingsForm extends CWidget{

   // attribute = array('name'=>'','value'=>'',
   // 'type'=>'text|radio|textarea|select',
   // 'items'=>array()<--if select,
   // 'htmlOptions'=>array())
   public $attributes = array();
   public $category = null;
   public $id = null;
   public $enctype = 'multipart/form-data';
   public $action = null;
   public $model_name = '';
   public $method = 'post';
   public $submit = array('label'=>'Submit','options'=>array('class'=>'btn'));
   public $target = null;
  
   // you put as many properties as needed
   public function init(){
     // init procedures here
   }
   
   public function setAttribute($attribute){
		$this->attributes = array_merge($this->attributes,$attribute);
   }
   
   public function setAttributes($attributes){
		foreach($attributes as $attribute)
			$this->setAttribute($attribute);
   }

   public function run(){
     // here render procedures 
     echo CHtml::beginForm($this->action,
          $this->method,
          array('id'=>$this->id,
          'enctype'=>$this->enctype,
          'target'=>$this->target));

     // you better create a function but
     // for the sake of the example...
     foreach($this->attributes as $attr)
     {
		// here we can actually say i
		// this is very simple but you get the idea
		echo CHtml::label($attr['label'], $attr['name']);
		if($attr['type']=='text')
			echo CHtml::textField($this->model_name.'['.$this->category.']'.'['.$attr['name'].']',$attr['value'],$attr['htmlOptions']);
		else if($attr['type']=='textarea')
			echo CHtml::textArea($this->model_name.'['.$this->category.']'.'['.$attr['name'].']',$attr['value'],$attr['htmlOptions']);
		else if($attr['type']=='password')
			echo CHtml::passwordField($this->model_name.'['.$this->category.']'.'['.$attr['name'].']',$attr['value'],$attr['htmlOptions']);
		else if($attr['type']=='checkbox')
			echo CHtml::checkBox($this->model_name.'['.$this->category.']'.'['.$attr['name'].']',$attr['items'],$attr['htmlOptions']);
		else if($attr['type']=='checkboxlist')
			echo CHtml::checkBoxList($this->model_name.'['.$this->category.']'.'['.$attr['name'].']',$attr['value'],$attr['items'],$attr['htmlOptions']);
		else if($attr['type']=='date')
			echo CHtml::dateField($this->model_name.'['.$this->category.']'.'['.$attr['name'].']',$attr['value'],$attr['htmlOptions']);
		else if($attr['type']=='dropdownlist')
			echo CHtml::dropDownList($this->model_name.'['.$this->category.']'.'['.$attr['name'].']',$attr['value'],$attr['items'],$attr['htmlOptions']);
		else if($attr['type']=='file')
			echo CHtml::fileField($this->model_name.'['.$this->category.']'.'['.$attr['name'].']',$attr['value'],$attr['items'],$attr['htmlOptions']);
		else if($attr['type']=='hidden')
			echo CHtml::hiddenField($this->model_name.'['.$this->category.']'.'['.$attr['name'].']',$attr['value'],$attr['items'],$attr['htmlOptions']);
		else if($attr['type']=='radio')
			echo CHtml::radioButton($this->model_name.'['.$this->category.']'.'['.$attr['name'].']',$attr['items'],$attr['htmlOptions']);
		else if($attr['type']=='radiolist')
			echo CHtml::radioButtonList($this->model_name.'['.$this->category.']'.'['.$attr['name'].']',$attr['value'],$attr['items'],$attr['htmlOptions']);

       // do more here
    }
	echo "<br/><br/><div class='row-fluid'>";
	echo CHtml::submitButton($this->submit['label'],$this->submit['options']);
	echo "</div>";
    echo CHtml::endForm();
   }
}