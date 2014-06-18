<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'multiple-form',
	'enableAjaxValidation' => true,
));
?>
<div class='row buttons'>
	<div class="span2 offset9">
	<?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('label','Create') :Yii::t('label','Save'), array('color' => TbHtml::BUTTON_COLOR_SUCCESS));
	?>
	<?php echo TbHtml::linkButton(Yii::t('label','Cancel'), array('color' => TbHtml::BUTTON_COLOR_DANGER, 'url'=>Yii::app()->createUrl('order/admin')));
	?>
	</div>
</div>

<?php 	
$this->endWidget();
?>
<?php 

	$tabs = array(array('label' => Yii::t('label','Customer'), 'active' => true, 'content' => 
		$this->renderPartial('_customer', array('model'=>$model), true, false)
	));
	
	$tabs[] = array('label' => Yii::t('label','Payment Address'), 'content' => 
			$this->renderPartial('_payment', array('model'=>$model), true, false), 'linkOptions'=>array('class'=>'poption')
		);

	$tabs[] = array('label' => Yii::t('label','Shipping Address'), 'content' => 
		$this->renderPartial('_shipping', array('model'=>$model), true, false), 'linkOptions'=>array('class'=>'poption')
	);

	if(isset($orderproduct)){
		$tabs[] = array('label' => Yii::t('label','Products'), 'content' => 
			$this->renderPartial('_products', array('orderproduct'=>$orderproduct), true, false), 'linkOptions'=>array('class'=>'poption')
		);
	}
		$tabs[] = array('label' => Yii::t('label','Details'), 'content' => 
			$this->renderPartial('_details', array('orderproduct'=>$orderproduct, 'model'=>$model, 'description'=>$description), true, false), 'linkOptions'=>array('class'=>'poption')
		);
	

echo TbHtml::tabbableTabs($tabs, array('placement' => TbHtml::TABS_PLACEMENT_LEFT)); ?>
	
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>