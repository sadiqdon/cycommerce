<?php
/* @var $this OrderController */
/* @var $model Order */

$this->breadcrumbs=array(
	'Orders'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' Order', 'url'=>array('index')),
	array('label'=>Yii::t('label','Manage').' Order', 'url'=>array('admin')),
);
?>

<h1>Create Order</h1>

<?php echo 	$this->renderPartial('_form_order', array('model' => $model, 'description' => $description, 'customer'=>$customer,'profile'=>$profile, 'orderproduct' => $orderproduct), false, true); ?>