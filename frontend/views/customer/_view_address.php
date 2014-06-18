<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
		//'id',
		'firstname',
		'lastname',
		'company',
		'tax_id',
		'address_1',
		'address_2',
		'city',
		'postal_code',
		array(
			'name' => 'country',
			'type' => 'raw',
			'value' => $model->country !== null ? TbHtml::encode($model->country->name) : null,
		),
		array(
			'name' => 'zone',
			'type' => 'raw',
			'value' => $model->zone !== null ? TbHtml::encode($model->zone->name) : null,
		),
	),
)); ?>