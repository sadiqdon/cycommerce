<?php 
//manually load editable assets. Is there a better way to do this?
	$editablePath = Yii::getPathOfAlias('common.extensions.editable.assets.bootstrap-editable');
	$datePath = Yii::getPathOfAlias('common.extensions.editable.assets.bootstrap-datetimepicker');
					
	$editableUrl = Yii::app()->assetManager->publish($editablePath, true, -1,false);
	$dateUrl = Yii::app()->assetManager->publish($datePath, true, -1, false);

	$cs = Yii::app()->getClientScript();
	$cs->registerCssFile($editableUrl.'/css/bootstrap-editable.css');
	$cs->registerCssFile($dateUrl.'/css/datetimepicker.css');
	$cs->registerScriptFile($editableUrl.'/js/bootstrap-editable.js', CClientScript::POS_END);
	$cs->registerScriptFile($dateUrl.'/js/bootstrap-datetimepicker.js'); 

?>
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
	<?php echo TbHtml::linkButton(Yii::t('label','Cancel'), array('color' => TbHtml::BUTTON_COLOR_DANGER, 'url'=>Yii::app()->createUrl('customer/admin')));
	?>
	</div>
</div>

<?php 	
$this->endWidget();
?>
<?php 

	$tabs = array(array('label' => 'General', 'active' => true, 'content' => 
		$this->renderPartial('_form', array('model'=>$model,'description'=>$description), true, false)
	));
	
	$tabs[] = array('label' => Yii::t('info','Data'), 'content' => 
			$this->renderPartial('_data', array('model'=>$model, 'image'=>$image, 'thumbs'=>$thumbs), true, false), 'linkOptions'=>array('class'=>'poption')
		);

	$tabs[] = array('label' => Yii::t('info','Related'), 'content' => 
		$this->renderPartial('_related', array('model'=>$model), true, false), 'linkOptions'=>array('class'=>'poption')
	);

	if(isset($option)){
		$tabs[] = array('label' => Yii::t('info','Option'), 'content' => 
			$this->renderPartial('_option', array('option'=>$option), true, false), 'linkOptions'=>array('class'=>'poption')
		);
	}
	if(isset($attribute)){
		$tabs[] = array('label' => Yii::t('info','Attribute'), 'content' => 
			$this->renderPartial('_attribute', array('attribute'=>$attribute), true, false), 'linkOptions'=>array('class'=>'poption')
		);
	}
	if(isset($image)){
		$tabs[] = array('label' => Yii::t('info','Image'), 'content' => 
			$this->renderPartial('_image', array('image'=>$image, 'userImages'=>$userImages), true, false), 'linkOptions'=>array('class'=>'poption')
		);
	}
	if(isset($discount)){
		$tabs[] = array('label' => Yii::t('info','Discount'), 'content' => 
			$this->renderPartial('_discount', array('discount'=>$discount), true, false), 'linkOptions'=>array('class'=>'poption')
		);
	}
	if(isset($special)){
		$tabs[] = array('label' => Yii::t('info','Special'), 'content' => 
			$this->renderPartial('_special', array('special'=>$special), true, false), 'linkOptions'=>array('class'=>'poption')
		);
	}
	//$tabs[] = array('label' => 'Add Address', 'content' => '...', 'linkOptions'=>array('class'=>'add-ress caddress'), 'icon' => TbHtml::ICON_PLUS_SIGN);

echo TbHtml::tabbableTabs($tabs, array('placement' => TbHtml::TABS_PLACEMENT_LEFT)); ?>
	<div id="pageinfo" class="hide">
	<div id="createAdd"><?php echo $this->createUrl('createaddress'); ?></div>
	<div id="labelAdd"><?php echo Yii::t('label', 'Address'); ?></div>
	</div>
	
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>