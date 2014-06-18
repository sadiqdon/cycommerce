<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	'Create',
);

$this->menu = array(
	array('label'=>'List' . ' ' . $model->label(2), 'url' => array('index')),
	array('label'=>'Manage' . ' ' . $model->label(2), 'url' => array('admin')),
);
?>

<h1><?php echo 'Create' . ' ' . GxHtml::encode($model->label()); ?></h1>

<?php
$this->renderPartial('_form', array(
		'model' => $model,
		'buttons' => 'create'));
?>