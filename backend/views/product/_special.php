<?php
/* @var $this OptionController */
/* @var $model Option */
/* @var $form CActiveForm */
?>
<?php
Yii::app()->clientScript->registerScript('new-special', '
	
	var special_table = jQuery("#product-special-grid table tbody");
	if(special_table.find("tr").eq(0).children("td").hasClass("empty")){
		special_table.find("tr").eq(0).remove();
	}

	jQuery("#product-special-grid").on("click",".dspecialval", function(e){
		e.preventDefault();
		jQuery(this).parent().parent().remove();
	});
	
	
	jQuery(".add-special").on("click",function(e) {
		e.preventDefault();
		var number = ((special_table.find("tr").size())%2 === 0)?"odd":"even";

		var tr = jQuery("<tr/>");
		var td1 = jQuery("<td/>");
		var td3 = jQuery("<td/>");
		var td4 = jQuery("<td/>");
		var td5 = jQuery("<td/>");
		var td6 = jQuery("<td/>");
		//tr.append("<td>Not Set</td>");
		bindEditable(td1, "select", "'.Yii::t('info','Choose Customer Group').'","'.Yii::t('info','Select Customer Group').'", validateN, "ProductSpecial", "c_group_id", special_table, null, "'.$this->createUrl('getCustomerGroup').'" );
		bindEditable(td3, "text", "'.Yii::t('info','Enter Priority').'","'.Yii::t('info','Add Priority').'", validateNum, "ProductSpecial", "priority", special_table);
		bindEditable(td4, "text", "'.Yii::t('info','Enter Price').'","'.Yii::t('info','Add Price').'", validateD, "ProductSpecial", "price", special_table);
		bindEditable(td5, "date", "'.Yii::t('info','Enter Start Date').'","'.Yii::t('info','Start Date').'", validateN, "ProductSpecial", "date_start", special_table);
		bindEditable(td6, "date", "'.Yii::t('info','Enter End Date').'","'.Yii::t('info','End Date').'", validateN, "ProductSpecial", "date_end", special_table);
		tr.append(td1);
		tr.append(td3);
		tr.append(td4);
		tr.append(td5);
		tr.append(td6);
		tr.append(\'<td><a href="#" rel="tooltip" class="dspecialval" data-original-title="Delete"><i class="icon-trash"></i></a></td>\');
		special_table.append(tr);
		
	});
'); 
?>

<div class="form aform">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'special-form',
	'enableAjaxValidation'=>false,
)); ?>
	
	<div class="row-fluid">
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'product-special-grid',
	'type'=>array(TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_CONDENSED),
	'dataProvider' => new CArrayDataProvider($special),
	'columns' => array(		
		array(
			'class' => 'common.extensions.editable.EditableColumn',
			'name'=>'c_group_id', 
			'header'=>Yii::t('label','Customer Group'),
			'editable' => array(
				'send' => 'never',
				'title' => Yii::t('label','Enter Customer Group'),
				'emptytext' => Yii::t('label','Add Customer Group'),
				'source' => $this->createUrl('getCustomerGroup'),
				'type' => 'select',
				'onSave' => 'js: function(e, params) {
								updateInput("ProductSpecial", "c_group_id", jQuery(this).parent(), params.newValue);
							}',
				'validate' => 'validateNum'
			),
		),
		array(
			'class' => 'common.extensions.editable.EditableColumn',
			'name' => 'priority',
			'header'=>Yii::t('label','Priority'),
			'editable' => array(
				'send' => 'never',
				'title' => Yii::t('label','Enter Priority'),
				'emptytext' => Yii::t('label','Add Priority'),
				'type' => 'text',
				'onSave' => 'js: function(e, params) {
								updateInput("ProductSpecial", "priority", jQuery(this).parent(), params.newValue);
							}',
				'validate' => 'validateNum'
			),
		),
		array(
			'class' => 'common.extensions.editable.EditableColumn',
			'name' => 'price',
			'header'=>Yii::t('label','Price'),
			'editable' => array(
				'send' => 'never',
				'title' => Yii::t('label','Enter Price'),
				'emptytext' => Yii::t('label','Add Price'),
				'type' => 'text',
				'onSave' => 'js: function(e, params) {
								updateInput("ProductSpecial", "price", jQuery(this).parent(), params.newValue);
							}',
				'validate' => 'validateD'
			),
		),
		array(
			'class' => 'common.extensions.editable.EditableColumn',
			'name' => 'date_start',
			'header'=>Yii::t('label','Start Date'),
			'editable' => array(
				'send' => 'never',
				'title' => Yii::t('label','Start Date'),
				'emptytext' => Yii::t('label','Start Date'),
				'type' => 'date',
				'format' => 'yyyy-mm-dd',
				'onSave' => 'js: function(e, params) {
								updateInput("ProductSpecial", "date_start", jQuery(this).parent(), params.newValue);
							}',
				'validate' => 'validateN'
			),
		),
		array(
			'class' => 'common.extensions.editable.EditableColumn',
			'name' => 'date_end',
			'header'=>Yii::t('label','End Date'),
			'editable' => array(
				'send' => 'never',
				'title' => Yii::t('label','End Date'),
				'emptytext' => Yii::t('label','End Date'),
				'type' => 'date',
				'format' => 'yyyy-mm-dd',
				'onSave' => 'js: function(e, params) {
								updateInput("ProductSpecial", "date_end", jQuery(this).parent(), params.newValue);
							}',
				'validate' => 'validateN'
			),
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=>array('style'=>'width: 40px'),
			'buttons' => array(
				 'delete' => array(
				 'label' => Yii::t('label', 'Delete'), // text label of the button
				  'options' => array("class" => "dspecialval", 'title' => Yii::t('label', 'Delete')),
				  ),
				),
			'template' => ' {delete}',
		),
	),
)); ?>

<span class="span2 offset8"><?php echo TbHtml::button(Yii::t('label','Add Special'), array('class'=>'add-special','color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?></span>
</div>
<?php $this->endWidget(); ?>

</div><!-- form -->