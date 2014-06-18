<?php
/* @var $this OptionController */
/* @var $model Option */
/* @var $form CActiveForm */
?>
<?php
Yii::app()->clientScript->registerScript('new-option', '
	hideGrid();
	var $table = jQuery("#option-value-grid table tbody");
	if($table.find("tr").eq(0).children("td").hasClass("empty")){
		$table.find("tr").eq(0).remove();
	}
	jQuery("#Option_type").change(function(){
		hideGrid();
	});
	jQuery(".grid-view").on("click",".doptval", function(e){
		e.preventDefault();
		jQuery(this).parent().parent().remove();
	});
	
	
	jQuery(".add-opval").on("click",function(e) {
		e.preventDefault();
		var number = (($table.find("tr").size())%2 === 0)?"odd":"even";

		var tr = jQuery("<tr/>");
		var td1 = jQuery("<td/>");
		var td2 = jQuery("<td/>");
		tr.append("<td>Not Set</td>");
		bindEditable(td1, "text", "Enter Name","'.Yii::t('info','Click to add Name').'", validateN, "OptionValueDescription", "name", $table);
		bindEditable(td2, "text", "Enter Sort Order","'.Yii::t('info','Click to add Sort Order').'", validateNum, "OptionValue", "sort_order", $table);
		tr.append(td1);
		tr.append(td2);
		tr.append(\'<td><a href="#" rel="tooltip" class="doptval" data-original-title="Delete"><i class="icon-trash"></i></a></td>\');
		$table.append(tr);
		
	});
	
	
	function hideGrid(){
		if(jQuery("#Option_type").val() != "select" && jQuery("#Option_type").val() != "radio" && jQuery("#Option_type").val() != "checkbox"){
			jQuery(".grid-view").hide();
			jQuery(".add-opval").hide();
		}else{
			jQuery(".grid-view").show();
			jQuery(".add-opval").show();
		}
	}
'); 
?>

<div class="form aform">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'option-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	
	<?php echo $form->errorSummary(array($model, $description)); ?>
	<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
	<div class="row">
		<?php echo $form->labelEx($description,'name'); ?>
		<?php echo $form->textField($description,'name',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($description,'name'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type', $model->typeList); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sort_order'); ?>
		<?php echo $form->textField($model,'sort_order'); ?>
		<?php echo $form->error($model,'sort_order'); ?>
	</div>
	<div class="row">
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'option-value-grid',
	'type'=>array(TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_CONDENSED),
	'dataProvider' => $optionValueData,
	'columns' => array(		
		array(
			'class' => 'common.extensions.editable.EditableColumn',
			'name'=>'id', 
			'header'=>Yii::t('label','ID'),
		),
		array(
			'class' => 'common.extensions.editable.EditableColumn',
			'name'=>'name', 
			'header'=>Yii::t('label','Name'),
			'value'=> '!empty($data->optionValueDescriptions) ? $data->optionValueDescriptions[0]->name: $data->name',
			'modelName'=>'OptionValueDescription',
			'editable' => array(
				//'apply' => true,
				'send' => 'never',
				'type' => 'text',
				'onSave' => 'js: function(e, params) {
								updateInput("OptionValueDescription", "name", jQuery(this).parent(), params.newValue);
							}',
			),
		),
		array(
			'class' => 'common.extensions.editable.EditableColumn',
			'name' => 'sort_order',
			'header'=>Yii::t('label','Sort Order'),
			'editable' => array(
				'send' => 'never',
				'type' => 'text',
				'onSave' => 'js: function(e, params) {
								updateInput("OptionValue", "sort_order", jQuery(this).parent(), params.newValue);
							}',
			),
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=>array('style'=>'width: 20px'),
			'deleteButtonUrl' => '#',
			'buttons' => array(
				 'delete' => array(
				 'url' => 'go',
				 'label' => Yii::t('label', 'Delete'), // text label of the button
				  'options' => array("class" => "doptval", 'title' => Yii::t('label', 'Delete')),
				  ),
				),
			'template' => ' {delete}',
		),
	),
)); ?>

<span class="span2 offset8"><?php echo TbHtml::button(Yii::t('label','Add Option Value'), array('class'=>'add-opval','color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>
	</div>	
	<div class="row buttons">
		<?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('label','Create') : Yii::t('label','Save'), array('color' => TbHtml::BUTTON_COLOR_SUCCESS)); ?>
		<?php echo TbHtml::linkButton(Yii::t('label','Cancel'), array('class'=>'cancelButton','color' => TbHtml::BUTTON_COLOR_DANGER, 'url'=>Yii::app()->createUrl('option/admin')));?>
	</div>
	

<?php $this->endWidget(); ?>

</div><!-- form -->
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>