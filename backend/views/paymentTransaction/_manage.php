<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery-ui.min.js',CClientScript::POS_HEAD)?><?php $this->widget('bootstrap.widgets.TbAlert'); ?><?php

Yii::app()->clientScript->registerScript('search', "
jQuery('.search-button').click(function(){
	jQuery('.search-form').toggle();
	return false;
});
jQuery('.search-form form').submit(function(){
	jQuery.fn.yiiGridView.update('payment-transaction-grid', {
		data: jQuery(this).serialize()
	});
	return false;
});
");
?>

<p>
<?php echo Yii::t('info','You may optionally enter a comparison operator (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) at the beginning of each of your search values to specify how the comparison should be done.'); ?></p>

<?php echo TbHtml::linkButton(Yii::t('label','Advanced Search'), array('url' => '#', 'class' => 'search-button', 'color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>
<div class="search-form hide">
<?php echo $this->renderPartial('_search', array('model'=>$model)); ?></div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'payment-transaction-grid',
	'type'=>array(TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_CONDENSED),
	'dataProvider' => $model->search(),
	'filter' => $model,
	'rowCssClassExpression'=>'"items[]_{$data->id}"',
	'columns' => array(
		array(
			'class'=>'CCheckBoxColumn',
			'id' => 'check',
			'selectableRows' => 2,
		),
		'id',
		'type',
		'transaction_date',
		'reference_number',
		'payment_reference',
		'approved_amount',
		'response_description',
		'response_code',
		'transaction_amount',
		'customer_name',
		'order_id',
		/*'query_date',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=>array('style'=>'width: 20px'),
			'buttons' => array(
						 'view' => array(
						  'label' => Yii::t('label', 'Query'), // text label of the button
						  'options' => array("class" => "view vlink", 'title' => Yii::t('label', 'Query')), 
							)
						),
			'template' => '{view}',
		),
	),
	'afterAjaxUpdate' => 'js:reSortGrid',
)); ?>
<div class="hlinks hide">
<div class="uid"></div>
<div class="sortLink"><?php echo $this->createUrl('sort'); ?></div>
</div>