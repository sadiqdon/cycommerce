<?php
/* @var $this SpecialOrderController */
/* @var $model SpecialOrder */
?>
<div class="section_head_general">
	<?php echo "Special Order Details"; ?>
</div>
<div class="section_body_general product">
<?php $this->renderPartial('_view', array(
	'model' => $model,
)); ?>
</div>