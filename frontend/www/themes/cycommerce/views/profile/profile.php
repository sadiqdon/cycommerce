<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Profile"),
);
$this->menu=array(
	array('label'=>UserModule::t('Order History'), 'url'=>array('/order/history')),
	array('label'=>UserModule::t('Profile'), 'url'=>array('/user/profile'), 'active'=>Yii::app()->controller->id == 'profile' && Yii::app()->controller->action->id == 'profile'),
    array('label'=>UserModule::t('Edit'), 'url'=>array('edit')),
    array('label'=>UserModule::t('Change password'), 'url'=>array('changepassword'), 'active'=>Yii::app()->controller->id == 'profile' && Yii::app()->controller->action->id == 'changepassword'),
    //array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
);
?>
<div class="section_head_general"><?php echo UserModule::t('Your profile');; ?></div>
<div class="section_body_general">

<div class="inner_wrapper">
<?php if(isset($this->menu)):?>
<?php $this->widget('bootstrap.widgets.TbNav', array(
	'type'=>TbHtml::NAV_TYPE_PILLS, // '', 'tabs', 'pills' (or 'list')
	'stacked'=>false,
	'items'=>$this->menu,
)); ?>
<?php endif?><!-- second secondary menu -->
<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>
<?php endif; ?>
<table class="dataGrid">
	<tr>
		<th class="label"><?php echo TbHtml::encode($model->getAttributeLabel('username')); ?></th>
	    <td>&#160;&#160;<?php echo TbHtml::encode($model->username); ?></td>
	</tr>
	<?php 
		$profileFields=ProfileField::model()->forOwner()->sort()->findAll();
		if ($profileFields) {
			foreach($profileFields as $field) {
				if($field->varname != 'branch_id'){
				//echo "<pre>"; print_r($profile); die();
			?>
	<tr>
		<th class="label"><?php echo TbHtml::encode(UserModule::t($field->title)); ?></th>
    	<td>&#160;&#160;<?php echo (($field->widgetView($profile))?$field->widgetView($profile):TbHtml::encode((($field->range)?Profile::range($field->range,$profile->getAttribute($field->varname)):$profile->getAttribute($field->varname)))); ?></td>
	</tr>
			<?php
			}
			}//$profile->getAttribute($field->varname)
		}
	?>
	<tr>
		<th class="label"><?php echo TbHtml::encode($model->getAttributeLabel('email')); ?></th>
    	<td>&#160;&#160;<?php echo TbHtml::encode($model->email); ?></td>
	</tr>
	<tr>
		<th class="label"><?php echo TbHtml::encode($model->getAttributeLabel('create_at')); ?></th>
    	<td>&#160;&#160;<?php echo $model->create_at; ?></td>
	</tr>
	<tr>
		<th class="label"><?php echo TbHtml::encode($model->getAttributeLabel('lastvisit_at')); ?></th>
    	<td>&#160;&#160;<?php echo $model->lastvisit_at; ?></td>
	</tr>
	<tr>
		<th class="label"><?php echo TbHtml::encode($model->getAttributeLabel('status')); ?></th>
    	<td>&#160;&#160;<?php echo TbHtml::encode(User::itemAlias("UserStatus",$model->status)); ?></td>
	</tr>
</table>
</div>
</div>