<?php

$this->breadcrumbs = array(
	'Tax Rates' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' TaxRate', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' TaxRate', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Tax Rates</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>