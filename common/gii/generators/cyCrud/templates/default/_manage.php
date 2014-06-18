<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery-ui.min.js',CClientScript::POS_HEAD)?>"; ?>
<?php echo "<?php \$this->widget('bootstrap.widgets.TbAlert'); ?>"; ?>
<?php
echo "<?php\n";
?>

Yii::app()->clientScript->registerScript('search', "
jQuery('.search-button').click(function(){
	jQuery('.search-form').toggle();
	return false;
});
jQuery('.search-form form').submit(function(){
	jQuery.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid', {
		data: jQuery(this).serialize()
	});
	return false;
});
");
?>

<p>
<?php echo "<?php echo Yii::t('info','You may optionally enter a comparison operator (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) at the beginning of each of your search values to specify how the comparison should be done.'); ?>"; ?>
</p>

<?php echo "<?php echo TbHtml::linkButton(Yii::t('label','Advanced Search'), array('url' => '#', 'class' => 'search-button', 'color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>"; ?>

<div class="search-form hide">
<?php echo "<?php echo \$this->renderPartial('_search', array('model'=>\$model)); ?>"; ?>
</div><!-- search-form -->

<?php echo '<?php'; ?> $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => '<?php echo $this->class2id($this->modelClass); ?>-grid',
	'type'=>array(TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_CONDENSED),
	'dataProvider' => $model->search(),
	'filter' => $model,
	'rowCssClassExpression'=>'"items[]_{$data->id}"',
	'columns' => array(
		array(
			'class'=>'CCheckBoxColumn',
			'id' => 'check',
			'selectableRows' => 2,
		),
<?php
$count=0;
$descrip = $this->getDescriptions($this->modelClass);
if(!empty($descrip)){
$count=1;
echo "\t\tarray(
			'name'=>'name', 
			'header'=>Yii::t('label','Name'),
			'value'=>'\$data->getName()', 
		),\n";
}
foreach($this->tableSchema->columns as $column)
{
	if(++$count==7)
		echo "\t\t/*\n";
	echo "\t\t'".$column->name."',\n";
}
if($count>=7)
	echo "\t\t*/\n";
?>
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=>array('style'=>'width: 20px'),
			'buttons' => array(
						 'delete' => array(
						 'label' => Yii::t('label', 'Delete'), // text label of the button
						  'options' => array("class" => "dlink", 'title' => Yii::t('label', 'Delete')),
						  ),
						 'update' => array(
						 'label' => Yii::t('label', 'Update'), // text label of the button
						 'options' => array("class" => "update vlink", 'title' => Yii::t('label', 'Update')), 
							),
						 'view' => array(
						  'label' => Yii::t('label', 'View'), // text label of the button
						  'options' => array("class" => "view vlink", 'title' => Yii::t('label', 'View')), 
							)
						),
			'template' => '{view} {update} {delete}',
		),
	),
	'afterAjaxUpdate' => 'js:reSortGrid',
)); ?>
<div class="hlinks hide">
<div class="uid"></div>
<div class="sortLink"><?php echo "<?php echo \$this->createUrl('sort'); ?>" ?></div>
</div>