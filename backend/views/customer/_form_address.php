<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'multiple-form',
	'enableAjaxValidation' => true,
));
?>
<div class='row buttons'>
	<div class="span2 offset9">
	<?php echo TbHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'), array('color' => TbHtml::BUTTON_COLOR_SUCCESS));
	?>
	<?php echo TbHtml::linkButton(UserModule::t('Cancel'), array('color' => TbHtml::BUTTON_COLOR_DANGER, 'url'=>Yii::app()->createUrl('customer/admin')));
	?>
	</div>
</div>

<?php 	
$this->endWidget();
?>
<?php 

$tabs = array(array('label' => 'General', 'active' => true, 'content' => 
		$this->renderPartial('_form', array('model'=>$model,'profile'=>$profile), true, true)
	));
	if(isset($address)){
		foreach($address as $i=>$add){
			$tabs[] = array('label' => 'Address '.($i+1), 'icon' => TbHtml::ICON_MINUS_SIGN, 'content' => 
						$this->renderPartial('_address', array('model'=>$add,'id'=>$i), true, true), 'linkOptions'=>array('class'=>'caddress ajaxadd')
					);
		}
	}
	$tabs[] = array('label' => 'Add Address', 'content' => '...', 'linkOptions'=>array('class'=>'add-ress caddress'), 'icon' => TbHtml::ICON_PLUS_SIGN);

echo TbHtml::tabbableTabs($tabs, array('placement' => TbHtml::TABS_PLACEMENT_LEFT)); ?>
	<div class="hlinks hide">
	<div class="uid"><?php echo $model->id; ?></div>
	</div>