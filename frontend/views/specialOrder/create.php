<?php
/* @var $this SpecialOrderController */
/* @var $model SpecialOrder */
?>
<div class="section_head_general">
	<?php echo "Special Order"; ?>
</div>
<div class="section_body_general">
	<div class="inner_wrapper">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
</div>