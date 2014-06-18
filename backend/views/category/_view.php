<?php $this->widget('bootstrap.widgets.TbAlert'); ?> 
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
		array(
			'name'=>'name', 
			'header'=>'Name',
			'value'=>$model->getName(), 
		),
		'id',
		array(
			'name'=>'store_id',
			'type' => 'raw',
			'value'=> !empty($model->store) ? TbHtml::link(TbHtml::encode($model->store->name), array("store/view", "id" => $model->store_id)) : null,
		),
		array(
			'name'=>'image',
			'type' => 'raw',
			'value' => !empty($model->images) ? TbHtml::image(TbHtml::encode(UtilityHelper::getPublishPath($model->images[0]->source)), Yii::t('label','Image')) : null,
			'cssClass' => 'gridimage'
		),
		array(
			'name'=>'parent_id',
			'type'=>'raw',
			'value'=>!empty($model->parent)? TbHtml::link(TbHtml::encode($model->parent->getName()), array("category/view", "id" => $model->parent_id)) : null,
		),
		array(
			'name' => 'top',
			'value' => ($model->top === '0') ? 'No' : 'Yes',
			'filter' => array('0' => 'No', '1' => 'Yes'),
		),
		'sort_order',
		array(
			'name' => 'status',
			'value' => ($model->status === '0') ? 'No' : 'Yes',
			'filter' => array('0' => 'No', '1' => 'Yes'),
		),
		'date_added',
		'date_modified',
	),
)); ?>
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>