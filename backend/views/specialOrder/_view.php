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
		'payment_code',
		'firstname',
		'lastname',
		'email',
		'telephone',
		array(
			'name' => 'total',
			'type' => 'raw',
			'value' => UtilityHelper::formatPrice($model->total),
		),
		array(
			'name'=>'order_status_id',
			'type'=>'raw',
			'value'=>!empty($model->orderStatus)? TbHtml::encode($model->orderStatus->getName()) : null,
		),
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
		'ip',
		'forwarded_ip',
		'user_agent',
		'date_added',
		'date_modified',
	),
)); ?>
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>