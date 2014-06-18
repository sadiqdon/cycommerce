<?php $this->widget('bootstrap.widgets.TbAlert'); ?> 
<?php 

	$tabs = array(array('label' => Yii::t('label','Customer'), 'active' => true, 'content' => 
		$this->renderPartial('_customer_view', array('model'=>$model), true, false)
	));
	
	$tabs[] = array('label' => Yii::t('label','Payment Address'), 'content' => 
			$this->renderPartial('_payment_view', array('model'=>$model), true, false), 'linkOptions'=>array('class'=>'poption')
		);

	$tabs[] = array('label' => Yii::t('label','Shipping Address'), 'content' => 
		$this->renderPartial('_shipping_view', array('model'=>$model), true, false), 'linkOptions'=>array('class'=>'poption')
	);

	$tabs[] = array('label' => Yii::t('label','Details'), 'content' => 
		$this->renderPartial('_details_view', array('orderproduct'=>$orderproduct, 'model'=>$model, 'description'=>$description), true, false), 'linkOptions'=>array('class'=>'poption')
	);

echo TbHtml::tabbableTabs($tabs, array('placement' => TbHtml::TABS_PLACEMENT_LEFT)); ?>
<?php /*$this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'payment_code',
		'invoice_no',
		'store_name',
		'store_url',
		'customer_id',
		'customer_group_id',
		'firstname',
		'lastname',
		'email',
		'telephone',
		'fax',
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
		'payment_method',
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
		'total',
		'order_status_id',
		'currency_id',
		'currency_code',
		'currency_value',
		'ip',
		'forwarded_ip',
		'user_agent',
		'accept_language',
		'date_added',
		'date_modified',
	),
)); */ ?>

	
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>