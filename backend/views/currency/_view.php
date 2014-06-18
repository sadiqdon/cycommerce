<?php $this->widget('bootstrap.widgets.TbAlert'); ?> 
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'title',
		'code',
		'symbol_left',
		'symbol_right',
		'decimal_place',
		'value',
		'status',
		'date_modified',
	),
)); ?>
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>