<?php
/* @var $this StaffController */
/* @var $model Staff */

$this->breadcrumbs=array(
	'Staffs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' Staff', 'url'=>array('index')),
	array('label'=>Yii::t('label','Manage').' Staff', 'url'=>array('admin')),
);
?>

<h1>Create Staff</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>