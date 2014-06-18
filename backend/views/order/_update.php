<?php $this->widget('bootstrap.widgets.TbAlert'); ?> 
<?php 

	$tabs = array(array('label' => Yii::t('label','Customer'), 'content' => 
		$this->renderPartial('_customer_view', array('model'=>$model), true, false)
	));
	
	$tabs[] = array('label' => Yii::t('label','Payment Address'), 'content' => 
			$this->renderPartial('_payment_view', array('model'=>$model), true, false), 'linkOptions'=>array('class'=>'poption')
		);

	$tabs[] = array('label' => Yii::t('label','Shipping Address'), 'content' => 
		$this->renderPartial('_shipping_view', array('model'=>$model), true, false), 'linkOptions'=>array('class'=>'poption')
	);

	$tabs[] = array('label' => Yii::t('label','Details'), 'active' => true, 'content' => 
		$this->renderPartial('_details_update', array('orderproduct'=>$orderproduct, 'model'=>$model, 'description'=>$description), true, false), 'linkOptions'=>array('class'=>'poption')
	);

echo TbHtml::tabbableTabs($tabs, array('placement' => TbHtml::TABS_PLACEMENT_LEFT)); ?>


	
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>