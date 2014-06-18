<?php
/* @var $this OptionController */
/* @var $model Option */
/* @var $form CActiveForm */
?>
<?php
Yii::app()->clientScript->registerScript('new-discount', '
	
	var discount_table = jQuery("#product-discount-grid table tbody");
	if(discount_table.find("tr").eq(0).children("td").hasClass("empty")){
		discount_table.find("tr").eq(0).remove();
	}

	jQuery(".grid-view").on("click",".ddiscountval", function(e){
		e.preventDefault();
		jQuery(this).parent().parent().remove();
	});
	
	
	jQuery(".add-discount").on("click",function(e) {
		e.preventDefault();
		var number = ((discount_table.find("tr").size())%2 === 0)?"odd":"even";

		var tr = jQuery("<tr/>");
		var td1 = jQuery("<td/>");
		var td2 = jQuery("<td/>");
		var td3 = jQuery("<td/>");
		var td4 = jQuery("<td/>");
		var td5 = jQuery("<td/>");
		var td6 = jQuery("<td/>");
		//tr.append("<td>Not Set</td>");
		bindEditable(td1, "select", "'.Yii::t('info','Choose Customer Group').'","'.Yii::t('info','Select Customer Group').'", validateN, "ProductDiscount", "c_group_id", discount_table, null, "'.$this->createUrl('getCustomerGroup').'" );
		bindEditable(td2, "text", "'.Yii::t('info','Enter Quantity').'","'.Yii::t('info','Add Quantity').'", validateNum, "ProductDiscount", "quantity", discount_table);
		bindEditable(td3, "text", "'.Yii::t('info','Enter Priority').'","'.Yii::t('info','Add Priority').'", validateNum, "ProductDiscount", "priority", discount_table);
		bindEditable(td4, "text", "'.Yii::t('info','Enter Price').'","'.Yii::t('info','Add Price').'", validateD, "ProductDiscount", "price", discount_table);
		bindEditable(td5, "date", "'.Yii::t('info','Enter Start Date').'","'.Yii::t('info','Start Date').'", validateN, "ProductDiscount", "date_start", discount_table);
		bindEditable(td6, "date", "'.Yii::t('info','Enter End Date').'","'.Yii::t('info','End Date').'", validateN, "ProductDiscount", "date_end", discount_table);
		tr.append(td1);
		tr.append(td2);
		tr.append(td3);
		tr.append(td4);
		tr.append(td5);
		tr.append(td6);
		tr.append(\'<td><a href="#" rel="tooltip" class="ddiscountval" data-original-title="Delete"><i class="icon-trash"></i></a></td>\');
		discount_table.append(tr);
		
	});
'); 
?>

<div class="form aform">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'discount-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="row-fluid">
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'product-discount-grid',
	'type'=>array(TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_CONDENSED),
	'dataProvider' => new CArrayDataProvider($discount),
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
								updateInput("ProductDiscount", "c_group_id", jQuery(this).parent(), params.newValue);
							}',
				'validate' => 'validateNum'
			),
		),
		array(
			'class' => 'common.extensions.editable.EditableColumn',
			'name' => 'quantity',
			'header'=>Yii::t('label','Quantity'),
			'editable' => array(
				'send' => 'never',
				'title' => Yii::t('label','Enter Quantity'),
				'emptytext' => Yii::t('label','Add Quantity'),
				'type' => 'text',
				'onSave' => 'js: function(e, params) {
								updateInput("ProductDiscount", "quantity", jQuery(this).parent(), params.newValue);
							}',
				'validate' => 'validateN'
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
								updateInput("ProductDiscount", "priority", jQuery(this).parent(), params.newValue);
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
								updateInput("ProductDiscount", "price", jQuery(this).parent(), params.newValue);
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
				'format' => 'yyyy-mm-dd', //format in which date is expected from model and submitted to server
				'onSave' => 'js: function(e, params) {
								updateInput("ProductDiscount", "date_start", jQuery(this).parent(), params.newValue);
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
				'format' => 'yyyy-mm-dd', //format in which date is expected from model and submitted to server
				'onSave' => 'js: function(e, params) {
								updateInput("ProductDiscount", "date_end", jQuery(this).parent(), params.newValue);
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
				  'options' => array("class" => "ddiscountval", 'title' => Yii::t('label', 'Delete')),
				  ),
				),
			'template' => ' {delete}',
		),
	),
)); ?>

<span class="span2 offset8"><?php echo TbHtml::button(Yii::t('label','Add Discount'), array('class'=>'add-discount','color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?></span>
</div>
<?php $this->endWidget(); ?>

</div><!-- form -->