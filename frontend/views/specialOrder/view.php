<?php
/* @var $this SpecialOrderController */
/* @var $model SpecialOrder */
?>
<div class="section_head_general">
	<?php echo "Special Order Details"; ?>
</div>
<div class="section_body_general">
	<div class="inner_wrapper">
	<p>Your special order has been placed, we will call you to process the order.</p><br/>
	<?php $this->renderPartial('_view', array(
		'model' => $model,
	)); ?>
	</div>
</div>