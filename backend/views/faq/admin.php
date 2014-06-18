<?php

$this->breadcrumbs = array(
	'Faqs' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' Faq', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' Faq', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Faqs</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>