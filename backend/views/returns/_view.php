<?php $this->widget('bootstrap.widgets.TbAlert'); ?> 
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'orderId',
		'customerID',
		'firstname',
		'lastname',
		'email',
		'telephone',
		'productid',
		'model',
		'quantity',
		'return_reason',
		'opened',
		'comment',
		'return_action',
		'return_status',
		'date_added',
		'date_modified',
	),
)); ?>
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>