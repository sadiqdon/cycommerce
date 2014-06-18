<?php $this->widget('bootstrap.widgets.TbAlert'); ?> 
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'transaction_date',
		'reference_number',
		'payment_reference',
		'approved_amount',
		'response_description',
		'response_code',
		'transaction_amount',
		'customer_name',
		'order_id',
		'query_date',
	),
)); ?>
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>