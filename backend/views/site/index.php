<?php $this->pageTitle=UtilityHelper::yiiparam('site_name'); ?>

<h1>Welcome to <i><?php  echo UtilityHelper::yiiparam('site_name'); ?> Admin Panel</i></h1>

<?php Yii::app()->user->setFlash('success', '<strong> You may login by clicking login on the top right corner.</strong>');?>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?>

<img style='margin-left:20%;' src='<?php echo Yii::app()->request->baseUrl.'/images/admin_icon.png'; ?>' title='Admin' alt='Admin'/>
