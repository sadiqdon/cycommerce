<?php
$this->breadcrumbs=array(
	'Groups'=>array('index'),
	'Manage',
);

$this->tab=array(   
	array('label'=>Yii::t('group','Users'), 'url'=>array('/user/admin'), 'active'=>false),
    array('label'=>Yii::t('group','Groups'), 'url'=>array('/group/admin'), 'active'=>true),
);
$this->menu=array(
	array('label'=>'Create Group', 'url'=>array('/group/create'), 'active'=>Yii::app()->controller->action->id == 'create'),
	array('label'=>'Manage Groups', 'url'=>array('/group/admin'), 'active'=>Yii::app()->controller->action->id == 'admin'),
	array('label'=>'List Group', 'url'=>array('/group/index'), 'active'=>Yii::app()->controller->action->id == 'index'),
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('group-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Groups</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo TbHtml::linkButton(UserModule::t('Advanced Search'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'url'=>'#', 'class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'group-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'htmlOptions'=>array('style'=>'width: 20px'),
			'template' => '{view},{update}',
        ),
	),
)); ?>
