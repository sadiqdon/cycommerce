<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery-ui.min.js',CClientScript::POS_HEAD)?><?php $this->widget('bootstrap.widgets.TbAlert'); ?><?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'payment-transaction-grid',
	'type'=>array(TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_CONDENSED),
	'dataProvider' => $dataProvider,
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
			'htmlOptions'=>array('style'=>'width: 40px'),
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