<?php echo "<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery-ui.min.js',CClientScript::POS_HEAD)?>"; ?>
<?php echo "<?php \$this->widget('bootstrap.widgets.TbAlert'); ?>"; ?>
<?php echo '<?php'; ?> $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => '<?php echo $this->class2id($this->modelClass); ?>-grid',
	'type'=>array(TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_CONDENSED),
	'dataProvider' => $dataProvider,
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
			'type'=>'raw',
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
			'htmlOptions'=>array('style'=>'width: 40px'),
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