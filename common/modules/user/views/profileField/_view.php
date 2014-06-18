<div class="view">

	<b><?php echo TbHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo TbHtml::link(TbHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo TbHtml::encode($data->getAttributeLabel('varname')); ?>:</b>
	<?php echo TbHtml::encode($data->varname); ?>
	<br />

	<b><?php echo TbHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo TbHtml::encode($data->title); ?>
	<br />

	<b><?php echo TbHtml::encode($data->getAttributeLabel('field_type')); ?>:</b>
	<?php echo TbHtml::encode($data->field_type); ?>
	<br />

	<b><?php echo TbHtml::encode($data->getAttributeLabel('field_size')); ?>:</b>
	<?php echo TbHtml::encode($data->field_size); ?>
	<br />

	<b><?php echo TbHtml::encode($data->getAttributeLabel('field_size_min')); ?>:</b>
	<?php echo TbHtml::encode($data->field_size_min); ?>
	<br />

	<b><?php echo TbHtml::encode($data->getAttributeLabel('required')); ?>:</b>
	<?php echo TbHtml::encode($data->required); ?>
	<br />

	<?php /*
	<b><?php echo TbHtml::encode($data->getAttributeLabel('match')); ?>:</b>
	<?php echo TbHtml::encode($data->match); ?>
	<br />

	<b><?php echo TbHtml::encode($data->getAttributeLabel('range')); ?>:</b>
	<?php echo TbHtml::encode($data->range); ?>
	<br />

	<b><?php echo TbHtml::encode($data->getAttributeLabel('error_message')); ?>:</b>
	<?php echo TbHtml::encode($data->error_message); ?>
	<br />

	<b><?php echo TbHtml::encode($data->getAttributeLabel('other_validator')); ?>:</b>
	<?php echo TbHtml::encode($data->other_validator); ?>
	<br />

	<b><?php echo TbHtml::encode($data->getAttributeLabel('default')); ?>:</b>
	<?php echo TbHtml::encode($data->default); ?>
	<br />

	<b><?php echo TbHtml::encode($data->getAttributeLabel('position')); ?>:</b>
	<?php echo TbHtml::encode($data->position); ?>
	<br />

	<b><?php echo TbHtml::encode($data->getAttributeLabel('visible')); ?>:</b>
	<?php echo TbHtml::encode($data->visible); ?>
	<br />

	*/ ?>

</div>