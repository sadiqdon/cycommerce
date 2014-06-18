<?php if(!empty($options)){ ?>
<div class="row-fluid options-order">
<div class="span3"><?php echo Yii::t('label','Select Options') ?></div>
<div class="span5">
<?php 
foreach($options as $i=>$noption){ 
	$option = Option::model()->findByPk($noption[0]->option_id);
	
	$productoption = $noption[0];
	$productoptionvalue = $noption[1];
	
	$required = array();
	if($productoption->required)
		$required = array('required'=>false); ?>
<div class="row-fluid">
<?php echo CHtml::hiddenField("OrderOption[{$i}][name]", $option->getName());
echo CHtml::hiddenField("OrderOption[{$i}][product_option_id]", $productoption->id);
echo CHtml::hiddenField("OrderOption[{$i}][order_product_id]", $productoption->product_id);
echo CHtml::hiddenField("OrderOption[{$i}][type]", $option->type);
 ?>
<div class="">
<?php echo CHtml::label($option->getName(), $option->getName(), $required); ?>
</div>
<?php if($option->type == 'select' || $option->type == 'radio' || $option->type =='checkbox'){
	if($option->type == 'select')
		$type = 'dropDownList';
	if($option->type == 'radio')
		$type = 'radioButtonList';
	if($option->type =='checkbox')
		$type = 'checkBoxList';	 ?>
	
	<div class="productoptionvalue">
	<?php echo CHtml::$type("OrderOption[{$i}][product_option_value_id]",'',CHtml::listData($productoptionvalue, 'id', function($data){ 
	$sign = '+';
	if($data->subtract)
		$sign = '-';
	$optionvalue = OptionValue::model()->findByPk($data->option_value_id);
	return $optionvalue->getName()." ($sign"."N".$data->price.")";} )); ?>

	</div>
<?php }else if($option->type = 'date'){ ?>
	<div class="input-append">
		<?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
		'name' => "OrderOption[{$i}][value]",
		'pluginOptions' => array(
		'format' => 'mm/dd/yyyy'
		)
		));
		?>
		<span class="add-on"><icon class="icon-calendar"></icon></span>
    </div>
<?php }else if($option->type = 'text'){ ?>
	<div class="">
		<?php echo CHtml::textField("OrderOption[{$i}][value]", $productoption->option_value) ?>
	</div>
<?php }else if($option->type = 'textarea'){ ?>
	<div class="">
		<?php echo CHtml::textArea("OrderOption[{$i}][value]", $productoption->option_value) ?>
	</div>
<?php } ?>
</div>
<?php } ?>
</div>
</div>
<?php } ?>