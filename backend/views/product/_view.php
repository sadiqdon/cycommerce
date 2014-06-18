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
		'model',
		'sku',
		'upc',
		'ean',
		'jan',
		'isbn',
		'mpn',
		'location',
		'quantity',
		'stock_status_id',
		array(
			'name'=>'image',
			'type' => 'raw',
			'value' => !empty($model->thumbs) ? TbHtml::image(TbHtml::encode(UtilityHelper::yiiparam('frontPath').'/www'.$model->thumbs[0]->source), Yii::t('label','Image')) : null,
			'cssClass' => 'gridimage'
		),
		'manufacturer_id',
		'shipping',
		'price',
		'points',
		'tax_class_id',
		'date_available',
		'weight',
		'weight_class_id',
		'length',
		'width',
		'height',
		'length_class_id',
		'subtract',
		'minimum',
		'sort_order',
		'status',
		'date_added',
		'date_modified',
		'viewed',
	),
)); ?>
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>