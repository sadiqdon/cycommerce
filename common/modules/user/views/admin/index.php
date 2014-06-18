<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('/user'),
	UserModule::t('Manage'),
);
$this->tab=array(   
	array('label'=>UserModule::t('Users'), 'url'=>array('/user/admin'), 'active'=>true),
    array('label'=>UserModule::t('Groups'), 'url'=>array('/group/admin'), 'active'=>false),
);
$this->menu=array(
    array('label'=>UserModule::t('Create User'), 'url'=>array('create'), 'active'=>Yii::app()->controller->id == 'admin' && Yii::app()->controller->action->id == 'create'),
    array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'), 'active'=>Yii::app()->controller->id == 'admin' && Yii::app()->controller->action->id == 'admin'),
    //array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin'), 'active'=>Yii::app()->controller->id == 'profileField'),
    array('label'=>UserModule::t('List Users'), 'url'=>array('/user'), 'active'=>Yii::app()->controller->id == 'user' && Yii::app()->controller->action->id == 'index'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});	
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('user-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
//echo Yii::app()->controller->id." -- dflkfllkl";
?>
<h1><?php echo UserModule::t("Manage Users"); ?></h1>

<p><?php echo UserModule::t("You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done."); ?></p>
<?php echo TbHtml::linkButton(UserModule::t('Advanced Search'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'url'=>'#', 'class'=>'search-button'));
?>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
    'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'user-grid',
	'type'=>array(TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_CONDENSED),
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' => 'id',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->id),array("admin/view","id"=>$data->id))',
		),
		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(UHtml::markSearch($data,"username"),array("admin/view","id"=>$data->id))',
		),
		array(
			'name'=>'email',
			'type'=>'raw',
			'value'=>'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
		),
		'create_at',
		'lastvisit_at',
		array(
			'name'=>'superuser',
			'value'=>'User::itemAlias("AdminStatus",$data->superuser)',
			'filter'=>User::itemAlias("AdminStatus"),
		),
		array(
			'name'=>'status',
			'value'=>'User::itemAlias("UserStatus",$data->status)',
			'filter' => User::itemAlias("UserStatus"),
		),
		array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'htmlOptions'=>array('style'=>'width: 50px'),
			'template' => '{view},{update}',
        ),
	),
)); ?>
