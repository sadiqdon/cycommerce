<?php $this->widget('bootstrap.widgets.TbAlert'); ?> 
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'product_name',
		'product_quantity',
		'product_colour',
		'specification',
		'comment',
		'firstname',
		'lastname',
		'email',
		'telephone',
		'address_1',
		'address_2',
		'city',
		'postal_code',
		array(
			'name' => 'zone',
			'label'=> 'State',
			'type' => 'raw',
			'value' => $model->zone !== null ? TbHtml::encode($model->zone->name) : null,
		),
		array(
			'name' => 'country',
			'type' => 'raw',
			'value' => $model->country !== null ? TbHtml::encode($model->country->name) : null,
		),
		
	),
)); ?>