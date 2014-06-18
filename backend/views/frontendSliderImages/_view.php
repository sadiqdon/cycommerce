<?php $this->widget('bootstrap.widgets.TbAlert'); ?> 
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
		array(
			'name'=>'title', 
			'header'=>'Title',
			'value'=>$model->getTitle(), 
		),
		'link',
		array(
			'name'=>'image',
			'type' => 'raw',
			'value' => !empty($model->images) ? TbHtml::image(TbHtml::encode(Yii::app()->getBaseUrl().$model->images[0]->source), Yii::t('label','Image')) : null,
		),
	),
)); ?>
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>