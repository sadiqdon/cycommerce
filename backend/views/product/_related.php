<div class="form aform">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'related-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'manufacturer_id'); ?>		
        <?php echo CHtml::activeDropDownList($model,'manufacturer_id', CHtml::listData(Manufacturer::model()->findAll(), 'id', 'name')); ?>
        <?php echo $form->error($model,'manufacturer_id'); ?>
    </div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'categories'); ?>		
        <?php echo CHtml::activeListBox($model,'categories', CHtml::listData(Category::model()->findAll(), 'id', function($data){ return $data->getName();}), array('multiple'=>'multiple')); 
		/*$this->widget('common.extensions.editable.Editable', array(
			'type' => 'checklist',
			'name' => 'categories',
			'send' => 'never',
			'source' => Editable::source(Category::model()->findAll(), 'id', function($data){ return $data->getName();}),
			'inputField' => array('type'=>'hidden','class'=>"optvalinputcategories", 'id'=>"Product_0_required", 'name'=>"Product[0][required]", 'value'=>$model->categories),
			'onSave' => 'js: function(e, params) {
							updateInput("Product", "categories", jQuery(this).parent(), params.newValue);
						}',
			));*/
		?>
        <?php echo $form->error($model,'categories'); ?>
    </div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'relatedA'); ?>		
        <?php echo CHtml::activeListBox($model,'relatedA', CHtml::listData(Product::model()->findAll(), 'id', function($data){ return $data->getName();}), array('multiple'=>'multiple')); ?>
        <?php echo $form->error($model,'relatedA'); ?>
    </div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'stores'); ?>		
        <?php echo CHtml::activeListBox($model,'stores', CHtml::listData(Store::model()->findAll(), 'id', 'name'), array('multiple'=>'multiple')); ?>
        <?php echo $form->error($model,'stores'); ?>
    </div>

<?php $this->endWidget(); ?>
</div>