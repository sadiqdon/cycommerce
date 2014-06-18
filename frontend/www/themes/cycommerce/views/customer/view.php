<?php
/* @var $this CustomerController */
/* @var $model Customer */

$this->menu=array(
	array('label'=>UserModule::t('Order History'), 'url'=>array('/order/history'), 'active'=>Yii::app()->controller->id == 'order' && Yii::app()->controller->action->id == 'history'),
	array('label'=>UserModule::t('Profile'), 'url'=>array('/customer'), 'active'=>Yii::app()->controller->id == 'customer' && Yii::app()->controller->action->id == 'view'),
    array('label'=>UserModule::t('Edit'), 'url'=>array('/customer/update'), 'active'=>Yii::app()->controller->id == 'customer' && Yii::app()->controller->action->id == 'update'),
    array('label'=>UserModule::t('Change password'), 'url'=>array('/user/profile/changepassword'), 'active'=>Yii::app()->controller->id == 'profile' && Yii::app()->controller->action->id == 'changepassword'),
    //array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
);

?>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?> 
<div class="section_head_general"><?php echo UserModule::t("View Profile"); ?></div>
<div class="section_body_general">
<div class="inner_wrapper">
<?php if(isset($this->menu)):?>
<?php $this->widget('bootstrap.widgets.TbNav', array(
	'type'=>TbHtml::NAV_TYPE_PILLS, // '', 'tabs', 'pills' (or 'list')
	'stacked'=>false,
	'items'=>$this->menu,
)); ?>
<?php endif?><!-- second secondary menu -->
<?php echo $this->renderPartial('_view', array('model'=>$model,'profile'=>$profile,'address'=>$address)); ?>
</div>
</div>