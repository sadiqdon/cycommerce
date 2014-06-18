<?php $this->widget('bootstrap.widgets.TbAlert'); ?> 
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
		'store_name',
		'store_url',
		'customer_id',
		'customer_group_id',
		'firstname',
		'lastname',
		'email',
		'telephone',
		'fax'
	),
)); ?>