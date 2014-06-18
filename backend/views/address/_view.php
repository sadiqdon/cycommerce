<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
'id',
array(
			'name' => 'user',
			'type' => 'raw',
			'value' => $model->user !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->user)), array('users/view', 'id' => GxActiveRecord::extractPkValue($model->user, true))) : null,
			),
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
			'value' => $model->country !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->country)), array('country/view', 'id' => GxActiveRecord::extractPkValue($model->country, true))) : null,
			),
array(
			'name' => 'zone',
			'type' => 'raw',
			'value' => $model->zone !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->zone)), array('zone/view', 'id' => GxActiveRecord::extractPkValue($model->zone, true))) : null,
			),
	),
)); ?>


<div class="uid hide"><a href="<?php echo $this->createUrl('delete', array('id' => $model->id)) ?>" class="del-link"></a><a href="<?php echo $this->createUrl('update', array('id' => $model->id)) ?>" class="up-link"></a></div>