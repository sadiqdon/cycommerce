<?php
/* @var $this ProductOptionValueController */
/* @var $model ProductOptionValue */
/* @var $form CActiveForm */
?>
<?php            
Yii::app()->clientScript->registerScript('new-product-option', '
	if(jQuery("#copyGrid .grid-view table tbody").find("tr").eq(0).children("td").hasClass("empty")){
		jQuery("#copyGrid .grid-view table tbody").find("tr").eq(0).remove();
	}
	
	jQuery("#OptionValue").on("click",".doptval", function(e){
		e.preventDefault();
		jQuery(this).parent().parent().remove();
	});
	jQuery("#OptionValue").on("click",".removeOpt", function(e){
		e.preventDefault();
		jQuery(this).parent().parent().remove();
	});
	
	jQuery(".add-opt").on("click", function(e){
		e.preventDefault();
		
		
		var c_val = 0;
		if(jQuery("#OptionValue .accordion-group").get(0) != null){
			var c_id = jQuery("#OptionValue .accordion-group").last().find(".collapse").attr("id");
			c_val = parseInt(c_id.replace("collapse", ""))+1;
		}
		var optvaltype = jQuery("#option_type_list option[value=\'"+jQuery("#s2id_optSelect").select2("val")+"\']").text();		
		var prefix = [{value: 1, text: "Add"},{value: 2, text: "Subtract"}];
		var prefix2 = [{value: 0, text: "No"},{value: 1, text: "Yes"}];
		
		var collapse = jQuery(\'<div class="accordion-group"><div class="accordion-heading"><a href="#collapse\'+c_val+\'" data-parent="#OptionValue" data-toggle="collapse" class="accordion-toggle"> \'+jQuery("#s2id_optSelect .select2-choice span").text()+\'</a><a href="#" class="removeOpt" style="float: right; margin: -28px 10px; text-decoration: none"><i class="icon-minus-sign" style="color: #EE0000;"></i> Delete</a></div><div class="accordion-body collapse in" id="collapse\'+c_val+\'"><div class="accordion-inner"><div class="row-fluid req"><label class="required" for="ProductOption[\'+c_val+\'][required]">'.Yii::t('info','Required').' <span class="required">*</span></label></div><input type="hidden" class="opts" id="ProductOption_\'+c_val+\'_option_id" name="ProductOption[\'+c_val+\'][option_id]" value="\'+jQuery("#s2id_optSelect").select2("val")+\'"/><div class="row-fluid optionVal"></div></div></div></div>\').appendTo("#OptionValue");
			
		bindEditable(collapse.find(".accordion-inner .req"), "select", "'.Yii::t('info','Required?').'","'.Yii::t('info','Required?').'", validateN, "ProductOption", "required", jQuery("#OptionValue"), null, prefix2);
		
		if(optvaltype == "select" || optvaltype == "radio" || optvaltype =="checkbox"){
			collapse.find(".accordion-inner .optionVal").append(jQuery("#copyGrid").html());
			//var $table = collapse.find(".grid-view table tbody");
			collapse.find(".add-opval").on("click", function(){
				
				var grid= jQuery(this).parent().parent().siblings(".grid-view");
				var $table = grid.find("table tbody");
				//alert(grid.parent().parent().find(".opts").val());
				var parent_model = new Array();
				parent_model[0] = c_val;
				parent_model[1] = "ProductOption";
				
				var number = (($table.find("tr").size())%2 === 0)?"odd":"even";
				
				
				
				
				
				if($table.find("tr").eq(0).children("td").hasClass("empty")){
					$table.find("tr").eq(0).remove();
				}

				var tr = jQuery("<tr/>");
				var td1 = jQuery("<td/>");
				var td2 = jQuery("<td/>");
				var td3 = jQuery("<td/>");
				var td4 = jQuery("<td/>");
				var td5 = jQuery("<td/>");
				var td6 = jQuery("<td/>");
				var td7 = jQuery("<td/>");
				tr.append("<td>Not Set</td>");

				bindEditable(td1, "select", "'.Yii::t('info','Enter Value').'","'.Yii::t('info','Add Value').'", validateN, "ProductOptionValue", "option_value_id", $table, parent_model, "'.$this->createUrl('getOptionValue').'"+grid.parent().parent().find(".opts").val() );
				bindEditable(td2, "text", "'.Yii::t('info','Enter Quantity').'","'.Yii::t('info','Add Quantity').'", validateNum, "ProductOptionValue", "quantity", $table, parent_model);
				bindEditable(td3, "select", "'.Yii::t('info','Subtract Stock').'","'.Yii::t('info','Subtract stock').'", validateN, "ProductOptionValue", "subtract", $table, parent_model, prefix2);
				bindEditable(td4, "select", "'.Yii::t('info','Choose Operator').'","'.Yii::t('info','Select Operator').'", validateN, "ProductOptionValue", "price_prefix", $table, parent_model, prefix);
				bindEditable(td5, "text", "'.Yii::t('info','Enter Price').'","'.Yii::t('info','Add Price').'", validateD, "ProductOptionValue", "price", $table, parent_model);
				bindEditable(td6, "select", "'.Yii::t('info','Choose Operator').'","'.Yii::t('info','Select Operator').'", validateN, "ProductOptionValue", "weight_prefix", $table, parent_model, prefix);
				bindEditable(td7, "text", "'.Yii::t('info','Enter Weight').'","'.Yii::t('info','Add Weight').'", validateD, "ProductOptionValue", "weight", $table, parent_model);
				
				tr.append(td1);
				tr.append(td2);
				tr.append(td3);
				tr.append(td4);
				tr.append(td5);
				tr.append(td6);
				tr.append(td7);
				tr.append(\'<td><a href="#" rel="tooltip" class="doptval" data-original-title="Delete"><i class="icon-trash"></i></a></td>\');
				$table.append(tr);
			});
		}else if(optvaltype == "text" || optvaltype == "textarea"){
			collapse.find(".accordion-inner .optionVal").append(jQuery(\'<br/><label class="required" for="ProductOption[\'+c_val+\'][option_value]">'.Yii::t('info','Option Value').' <span class="required">*</span></label>\'));	
			bindEditable(collapse.find(".accordion-inner .optionVal"), optvaltype, "'.Yii::t('info','Enter Option Value').'","'.Yii::t('info','Add Option Value').'", validateN, "ProductOption", "option_value", jQuery("#OptionValue"));}
	});
');?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'product-option-form',
	'enableAjaxValidation'=>false,
)); ?>
<div id="OptionValue" class="accordion">

<?php 
//echo print_r($option);
foreach($option as $i=>$opt){ 
	$optionModel = Option::model()->findByPk($opt[0]->option_id);
?>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a href="#collapse<?php echo $i; ?>" data-parent="#OptionValue" data-toggle="collapse" class="accordion-toggle"> <?php echo $optionModel->getName();?></a><a href="#" class="removeOpt" style="float: right; margin: -28px 10px; text-decoration: none"><i class="icon-minus-sign" style="color: #EE0000;"></i> Delete</a>
			</div><div class="accordion-body collapse in" id="collapse<?php echo $i; ?>"><div class="accordion-inner">
			<div class="row-fluid">
			<?php echo $form->labelEx($opt[0],'required'); ?>
			<?php $this->widget('common.extensions.editable.Editable', array(
					'type' => 'select',
					'name' => "required",
					'value' => $opt[0]->required,
					'emptytext' => Yii::t('info','Required?'),
					'title' => Yii::t('info','Required?'),
					'source' => Editable::source(array('0'=>'No', '1'=>'Yes')),
					'inputField' => array('type'=>'hidden','class'=>"optvalinputrequired", 'id'=>"ProductOption_{$i}_required", 'name'=>"ProductOption[{$i}][required]", 'value'=>$opt[0]->required),
					'send' => 'never',
					'onSave' => 'js: function(e, params) {
								updateInput("ProductOption", "required", jQuery(this).parent(), params.newValue );
							}',
				));
			?>
			<?php echo $form->error($opt[0],'required'); ?>
			</div>
			<?php echo '<input type="hidden" class="opts" id="ProductOption_'.$i.'_option_id" name="ProductOption['.$i.'][option_id]" value="'.$opt[0]->option_id.'"/>'; ?>
			<?php 				
			if($optionModel->type == 'select' || $optionModel->type == 'radio' || $optionModel->type =='checkbox'){
				$this->widget('bootstrap.widgets.TbGridView', array(
				'type'=>array(TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_CONDENSED),
				'dataProvider' => new CArrayDataProvider($opt[1]),
				'columns' => array(
					'id',
					array(
						'class' => 'common.extensions.editable.EditableColumn',
						'name'=>'option_value_id',
						'header'=>Yii::t('label','Option Value'),
						'parentModel' => array($i,'ProductOption'),
						'editable' => array(
							'send' => 'never',
							'type' => 'select',
							'emptytext' => Yii::t('info','Add Value'),
							'title' => Yii::t('info','Enter Value'),
							'source' => $this->createUrl('getOptionValue').$opt[0]->option_id,
							'onSave' => 'js: function(e, params) {
											updateInput("ProductOptionValue", "option_value_id", jQuery(this).parent(), params.newValue,["'.$i.'","ProductOption"]);
										}',
						),
					),
					array(
						'class' => 'common.extensions.editable.EditableColumn',
						'name'=>'quantity',
						'header'=>Yii::t('label','Quantity'),
						'parentModel' => array($i,'ProductOption'),
						'editable' => array(
							'send' => 'never',
							'type' => 'text',
							'emptytext' => Yii::t('info','Add Quantity'),
							'title' => Yii::t('info','Enter Value'),
							'onSave' => 'js: function(e, params) {
											updateInput("ProductOptionValue", "quantity", jQuery(this).parent(), params.newValue,["'.$i.'","ProductOption"]);
										}',
						),
					),
					array(
						'class' => 'common.extensions.editable.EditableColumn',
						'name'=>'subtract',
						'header'=>Yii::t('label','Subtract'),
						'parentModel' => array($i,'ProductOption'),
						'editable' => array(
							'send' => 'never',
							'emptytext' => Yii::t('info','Subtract Stock'),
							'title' => Yii::t('info','Subtract Stock'),
							'type' => 'select',
							'source' => Editable::source(array('0'=>'No','1'=>'Yes')),
							'onSave' => 'js: function(e, params) {
											updateInput("ProductOptionValue", "subtract", jQuery(this).parent(), params.newValue,["'.$i.'","ProductOption"]);
										}',
						),
					),
					array(
						'class' => 'common.extensions.editable.EditableColumn',
						'name'=>'price_prefix',
						'header'=>Yii::t('label','Price Operator'),
						'parentModel' => array($i,'ProductOption'),
						'editable' => array(
							'send' => 'never',
							'emptytext' => Yii::t('info','Select Operator'),
							'title' => Yii::t('info','Choose Operator'),
							'type' => 'select',
							'source' => Editable::source(array('1'=>'Add','2'=>'Subtract')),
							'onSave' => 'js: function(e, params) {
											updateInput("ProductOptionValue", "price_prefix", jQuery(this).parent(), params.newValue,["'.$i.'","ProductOption"]);
										}',
						),
					),
					array(
						'class' => 'common.extensions.editable.EditableColumn',
						'name'=> 'price',
						'header'=>Yii::t('label','Price'),
						'parentModel' => array($i,'ProductOption'),
						'editable' => array(
							'send' => 'never',
							'emptytext' => Yii::t('info','Add Price'),
							'title' => Yii::t('info','Enter Price'),
							'type' => 'text',
							'onSave' => 'js: function(e, params) {
											updateInput("ProductOptionValue", "price", jQuery(this).parent(), params.newValue,["'.$i.'","ProductOption"]);
										}',
						),
					),
					array(
						'class' => 'common.extensions.editable.EditableColumn',
						'name'=>'weight_prefix',
						'header'=>Yii::t('label','Weight Operator'),
						'parentModel' => array($i,'ProductOption'),
						'editable' => array(
							'send' => 'never',
							'emptytext' => Yii::t('info','Select Operator'),
							'title' => Yii::t('info','Choose Operator'),
							'type' => 'select',
							'source' => Editable::source(array('1'=>'Add','2'=>'Subtract')),
							'onSave' => 'js: function(e, params) {
											updateInput("ProductOptionValue", "weight_prefix", jQuery(this).parent(), params.newValue,["'.$i.'","ProductOption"]);
										}',
						),
					),
					array(
						'class' => 'common.extensions.editable.EditableColumn',
						'name'=>'weight',
						'header'=>Yii::t('label','Weight'),
						'parentModel' => array($i,'ProductOption'),
						'editable' => array(
							'send' => 'never',
							'emptytext' => Yii::t('info','Add Weight'),
							'title' => Yii::t('info','Enter Weight'),
							'type' => 'text',
							'onSave' => 'js: function(e, params) {
											updateInput("ProductOptionValue", "weight", jQuery(this).parent(), params.newValue,["'.$i.'","ProductOption"]);
										}',
						),
					),
					array(
						'class'=>'bootstrap.widgets.TbButtonColumn',
						'htmlOptions'=>array('style'=>'width: 20px'),
						'buttons' => array(
							 'delete' => array(
							 'label' => Yii::t('label', 'Delete'), // text label of the button
							  'options' => array("class" => "doptval", 'title' => Yii::t('label', 'Delete')),
							  ),
							),
						'template' => ' {delete}',
					),	
				)));

				
				
			}else if(in_array($optionModel->type, array('text','textarea','date','datetime'))){?>
				<div class="row-fluid">
				<br/>
			<?php echo $form->labelEx($opt[0],'option_value'); ?>
			<?php $this->widget('common.extensions.editable.Editable', array(
					'type' => $optionModel->type,
					'name' => "option_value",
					'text' => $opt[0]->option_value,
					'emptytext' => Yii::t('info','Add Option Value'),
					'title' => Yii::t('info','Enter Option Value'),				
					'inputField' => array('type'=>'hidden','class'=>"optvalinputoption_value", 'id'=>"ProductOption_{$i}_option_value", 'name'=>"ProductOption[{$i}][option_value]", 'value'=>$opt[0]->option_value),
					'send' => 'never',
					'onSave' => 'js: function(e, params) {
								updateInput("ProductOption", "option_value", jQuery(this).parent(), params.newValue );
							}',
				));
			?>
			<?php echo $form->error($opt[0],'option_value'); ?>
				</div>
			<?php }?>
			</div></div></div>
<?php }?>
</div>
<div class="row">
		<span class="span2">
		<?php
			$this->widget('yiiwheels.widgets.select2.WhSelect2', array(
				'asDropDownList' => true,
				'name' => 'optvalsearch',
				'model' => new Option,
				'attribute' => 'name',
				'htmlOptions' => array('id'=>'optSelect'),
				'data' => TbHtml::listData(Option::model()->findAll(), 'id', function($data){ return $data->getName();} ),
				'pluginOptions' => array(
					//'tags' => TbHtml::listData(Option::model()->findAll(), 'id', 'id' ),
					'placeholder' => 'Enter Option',
					'width' => '100%',
					//'tokenSeparators' => array(',', ' ')
				)
			));
		?>
		</span>
		<span class="span2"><?php echo TbHtml::button(Yii::t('label','Add Option'), array('class'=>'add-opt','color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?></span>
	</div>
<div id="copyGrid" class="row hide">
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	//'id' => 'option-value-grid',
	'type'=>array(TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_CONDENSED),
	'dataProvider' => new CArrayDataProvider(array()),
	'columns' => array(
		'id',
        array(
			'name'=>'option_value_id',
			'header'=>Yii::t('label','Option Value'),
		),
        array(
			'name'=>'quantity',
			'header'=>Yii::t('label','Quantity'),
		),
        array(
			'name'=>'subtract',
			'header'=>Yii::t('label','Subtract'),
		),
		array(
			'name'=>'price_prefix',
			'header'=>Yii::t('label','Price Operator'),
		),
		array(
			'name'=> 'price',
			'header'=>Yii::t('label','Price'),
		),
		array(
			'name'=>'weight_prefix',
			'header'=>Yii::t('label','Weight Operator'),
		),
        array(
			'name'=>'weight',
			'header'=>Yii::t('label','Weight'),
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=>array('style'=>'width: 20px'),
			'buttons' => array(
				 'delete' => array(
				 'label' => Yii::t('label', 'Delete'), // text label of the button
				  'options' => array("class" => "doptval", 'title' => Yii::t('label', 'Delete')),
				  ),
				),
			'template' => ' {delete}',
		),	
	)));
?>
<div class="row"><span class="span2 offset7"><?php echo TbHtml::button(Yii::t('label','Add Option Value'), array('class'=>'add-opval','color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?></span></div>
</div>
<div class="row optiontype hide"><?php echo TbHtml::dropDownList('option_type', '', TbHtml::listData(Option::model()->findAll(), 'id', 'type'), array('id'=>'option_type_list')); ?></div>
<?php $this->endWidget(); ?>
<br/>
<br/>