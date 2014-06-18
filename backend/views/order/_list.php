<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery-ui.min.js',CClientScript::POS_HEAD)?><?php $this->widget('bootstrap.widgets.TbAlert'); ?><?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'order-grid',
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
		//'invoice_no',
		array(
			'name'=>'payment_method',
			'type'=>'raw',
			'value'=>function($data){$pay = PaymentMethod::model()->findByPk($data->payment_method); $name = !empty($pay) ? $pay->getName() : null; return $name;},
			'filter'=>function($data){return CHtml::activeDropDownList($data,'payment_method',TbHtml::listData(PaymentMethod::model()->findAll(), 'id', function($data){return $data->getName();}), array('empty'=>''));},
		),
		'payment_code',
		'store_name',
		'firstname',
		'lastname',
		'email',
		'telephone',
		//'fax',
		array(
			'name'=>'total',
			'type'=>'raw',
			'value'=>'UtilityHelper::formatPrice($data->total)',
		),
		array(
			'name'=>'order_status_id',
			'type'=>'raw',
			'value'=>'!empty($data->orderStatus)? TbHtml::encode($data->orderStatus->getName()) : null',
		),
		'date_added',
		//'date_modified',
		/*
		'store_url',
		'customer_id',
		'customer_group_id',
		'payment_firstname',
		'payment_lastname',
		'payment_company',
		'payment_company_id',
		'payment_tax_id',
		'payment_address_1',
		'payment_address_2',
		'payment_city',
		'payment_postcode',
		'payment_country',
		'payment_country_id',
		'payment_zone',
		'payment_zone_id',
		'payment_address_format',	
		'shipping_firstname',
		'shipping_lastname',
		'shipping_company',
		'shipping_address_1',
		'shipping_address_2',
		'shipping_city',
		'shipping_postcode',
		'shipping_country',
		'shipping_country_id',
		'shipping_zone',
		'shipping_zone_id',
		'shipping_address_format',
		'shipping_method',
		'shipping_code',
		'currency_id',
		'currency_code',
		'currency_value',
		'ip',
		'forwarded_ip',
		'user_agent',
		'accept_language',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=>array('style'=>'width: 40px'),
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