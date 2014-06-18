<?php 
Yii::app()->clientScript->registerScript('new-order-product', '
	if(jQuery("#order-product-grid table tbody").find("tr").eq(0).children("td").hasClass("empty")){
		jQuery("#order-product-grid table tbody").find("tr").eq(0).remove();
	}
	
	//jQuery("#viewContent").on("click","#order-product-grid .dorderline", function(e){
	//jQuery("#viewContent").delegate( "#order-product-grid .dorderline", "click", function(e){
	jQuery("#order-product-grid .dorderline").bind( "click", function(e){
		e.preventDefault();
		var pos = jQuery(this).parent().parent().index();
		//var pos = jQuery("#order-product-grid tbody tr").index(jQuery(this).parent().parent());
		jQuery(this).parent().parent().remove();		
		jQuery.get(jQuery(".remove-product-link").attr("href")+pos, function( data ) {});
		setTimeout(function(){jQuery.post( jQuery(".refresh-details-link").attr("href"), jQuery(".order-details-page form").serialize(), function(data){
			jQuery(".order-details-page").html(data);
		})}, 500);
	});

');?>		
<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<div class="form order-product-page">	
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'order-product-form',
	'enableAjaxValidation'=>false,
)); 

?>
<div class="row-fluid">
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'order-product-grid',
	'type'=>array(TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_CONDENSED),
	'dataProvider' => new CArrayDataProvider($orderproduct),
	'columns' => array(
        array(
			'name'=>'name',
			'header'=>Yii::t('label','Product'),
		),
        array(
			'name'=>'model',
			'header'=>Yii::t('label','Model'),
		),
		array(
			'header'=>Yii::t('label','Options'),
			'value'=>array($this,'optionDataColumn'),
		),
        array(
			'name'=>'quantity',
			'header'=>Yii::t('label','Quantity'),
		),
		array(
			'name'=>'price',
			'header'=>Yii::t('label','Price'),
		),
		array(
			'name'=> 'total',
			'header'=>Yii::t('label','Total'),
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=>array('style'=>'width: 20px'),
			'buttons' => array(
				 'delete' => array(
				 'label' => Yii::t('label', 'Delete'), // text label of the button
				  'options' => array("class" => "dorderline", 'title' => Yii::t('label', 'Delete')),
				  ),
				),
			'template' => ' {delete}',
		),	
	)));
?>
</div>
<div class="row-fluid">
	<div class="span7">
		<div class="row-fluid select-product">
			<span class="span3"><?php echo CHtml::label(Yii::t('label','Choose Product'), 'productSelect'); ?></span>
			<span class="span5">
			<?php
				$this->widget('yiiwheels.widgets.select2.WhSelect2', array(
					'asDropDownList' => true,
					'name' => 'OrderProduct[id]',
					//'model' => new Product,
					//'attribute' => 'name',
					'htmlOptions' => array('id'=>'productSelect'),
					'data' => TbHtml::listData(Product::model()->findAll(), 'id', function($data){ return $data->getName();} ),
					'pluginOptions' => array(
						//'tags' => TbHtml::listData(Option::model()->findAll(), 'id', 'id' ),
						'placeholder' => 'Select Product',
						'width' => '100%',
					)
				));
			?>
			</span>
		</div>
		<?php 
			if(!empty($orderoption)){
				$this->renderPartial('_product_option', array('options' => $orderoption, 'options'=>$options), false, true);
			}
		?>
		<div class="row-fluid">
			<span class="span3"><?php echo CHtml::label(Yii::t('label','Quantity'), 'product-quantity'); ?></span>
			<span class="span5"><?php echo CHtml::textField('OrderProduct[quantity]', '', array('id'=>'product-quantity','size'=>60,'maxlength'=>255)); ?></span>
		</div>
		<div class="row-fluid">
			<span class="span5 offset3"><?php echo TbHtml::button(Yii::t('label','Add Product'), array('class'=>'add-product-order','color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?></span>
		</div>
	</div>
	
</div>
<div class="hide"><a href="<?php echo $this->createUrl('order/removeproduct') ?>" class="remove-product-link"></a><a href="<?php echo $this->createUrl('order/getProductOption') ?>" class="get-product-option-link"></a><a href="<?php echo $this->createUrl('order/addProduct') ?>" class="add-product-link"></a></div>
<?php $this->endWidget(); ?>
</div>