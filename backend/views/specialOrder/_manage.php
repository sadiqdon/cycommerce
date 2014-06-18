<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery-ui.min.js',CClientScript::POS_HEAD)?><?php $this->widget('bootstrap.widgets.TbAlert'); ?><?php

Yii::app()->clientScript->registerScript('search', "
jQuery('.search-button').click(function(){
	jQuery('.search-form').toggle();
	return false;
});
jQuery('.search-form form').submit(function(){
	jQuery.fn.yiiGridView.update('special-order-grid', {
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
	'id' => 'special-order-grid',
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
		'product_name',
		'product_quantity',
		'product_colour',
		/*'specification',
		'comment',*/
		'payment_code',
		'firstname',
		'lastname',
		'email',
		'telephone',
		'total',
		'order_status_id',
		/*'address_1',
		'address_2',
		'city',
		'postal_code',
		'country_id',
		'zone_id',
		'ip',
		'forwarded_ip',
		'user_agent',
		'date_added',
		'date_modified',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=>array('style'=>'width: 20px'),
			'buttons' => array(
						 'delete' => array(
						 'label' => Yii::t('label', 'Delete'), // text label of the button
						  'options' => array("class" => "dlink", 'title' => Yii::t('label', 'Delete')),
						  ),
						 'update' => array(
						 'label' => Yii::t('label', 'Update'), // text label of the button
						 'options' => array("class" => "update vlink", 'title' => Yii::t('label', 'Update')), 
							),
						 'view' => array(
						  'label' => Yii::t('label', 'View'), // text label of the button
						  'options' => array("class" => "view vlink", 'title' => Yii::t('label', 'View')), 
							)
						),
			'template' => '{view} {update} {delete}',
		),
	),
	'afterAjaxUpdate' => 'js:reSortGrid',
)); ?>
<div class="hlinks hide">
<div class="uid"></div>
<div class="sortLink"><?php echo $this->createUrl('sort'); ?></div>
</div>