<?php
/* @var $this OptionController */
/* @var $model Option */
/* @var $form CActiveForm */
?>
<?php
Yii::app()->clientScript->registerScript('new-attribute', '
	
	var attr_table = jQuery("#product-attribute-grid table tbody");
	if(attr_table.find("tr").eq(0).children("td").hasClass("empty")){
		attr_table.find("tr").eq(0).remove();
	}

	jQuery("#product-attribute-grid").on("click",".dattrval", function(e){
		e.preventDefault();
		jQuery(this).parent().parent().remove();
	});
	
	
	jQuery(".add-attr").on("click",function(e) {
		e.preventDefault();
		var number = ((attr_table.find("tr").size())%2 === 0)?"odd":"even";

		var tr = jQuery("<tr/>");
		var td1 = jQuery("<td/>");
		var td2 = jQuery("<td/>");
		//tr.append("<td>Not Set</td>");
		bindEditable(td1, "select", "'.Yii::t('info','Choose Attribute Name').'","'.Yii::t('info','Select Attribute Name').'", validateN, "ProductAttribute", "attribute_id", attr_table, null, "'.$this->createUrl('getAttributeName').'" );
		bindEditable(td2, "textarea", "'.Yii::t('info','Enter Text').'","'.Yii::t('info','Add Text').'", validateN, "ProductAttribute", "text", attr_table);
		tr.append(td1);
		tr.append(td2);
		tr.append(\'<td><a href="#" rel="tooltip" class="dattrval" data-original-title="Delete"><i class="icon-trash"></i></a></td>\');
		attr_table.append(tr);
		
	});
'); 
?>

<div class="form aform">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'attribute-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="row-fluid">
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'product-attribute-grid',
	'type'=>array(TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_CONDENSED),
	'dataProvider' => new CArrayDataProvider($attribute),
	'columns' => array(		
		array(
			'class' => 'common.extensions.editable.EditableColumn',
			'name'=>'attribute_id', 
			'header'=>Yii::t('label','Attribute Name'),
			//'value'=> '!empty($data->optionValueDescriptions) ? $data->optionValueDescriptions[0]->name: $data->name',
			//'modelName'=>'ProductAttribute',
			'editable' => array(
				//'apply' => true,
				'send' => 'never',
				'title' => Yii::t('label','Enter Name'),
				'emptytext' => Yii::t('label','Add Name'),
				'source' => $this->createUrl('getAttributeName'),
				'type' => 'select',
				'onSave' => 'js: function(e, params) {
								updateInput("ProductAttribute", "attribute_id", jQuery(this).parent(), params.newValue);
							}',
			),
		),
		array(
			'class' => 'common.extensions.editable.EditableColumn',
			'name' => 'text',
			'header'=>Yii::t('label','Text'),
			'editable' => array(
				'send' => 'never',
				'title' => Yii::t('label','Enter Text'),
				'emptytext' => Yii::t('label','Add Text'),
				'type' => 'textarea',
				'onSave' => 'js: function(e, params) {
								updateInput("ProductAttribute", "text", jQuery(this).parent(), params.newValue);
							}',
			),
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=>array('style'=>'width: 20px'),
			'buttons' => array(
				 'delete' => array(
				 'label' => Yii::t('label', 'Delete'), // text label of the button
				  'options' => array("class" => "dattrval", 'title' => Yii::t('label', 'Delete')),
				  ),
				),
			'template' => ' {delete}',
		),
	),
)); ?>

<span class="span2 offset8"><?php echo TbHtml::button(Yii::t('label','Add Attribute'), array('class'=>'add-attr','color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?></span>
</div>
<?php $this->endWidget(); ?>

</div><!-- form -->