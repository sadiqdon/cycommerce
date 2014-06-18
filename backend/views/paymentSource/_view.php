<?php $this->widget('bootstrap.widgets.TbAlert'); ?> 
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
	),
)); ?>
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>