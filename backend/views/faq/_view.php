<?php $this->widget('bootstrap.widgets.TbAlert'); ?> 
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		array(
			'name'=>'name', 
			'header'=>'Name',
			'value'=>$model->getTitle(), 
		),
		array(
			'name'=>'description',
			'header'=>'Description',
			'type'=>'raw',
			'value'=>$model->getDescription(), 
		)
	),
)); ?>
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>