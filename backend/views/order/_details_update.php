<div class="row-fluid">
<?php 
	//$orderproduct = Yii::app()->user->getState('order_product');
	if(empty($orderproduct))
		$orderproduct = array();
	
	$this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'order-total-grid',
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
		/*array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=>array('style'=>'width: 20px'),
			'buttons' => array(
				 'delete' => array(
				 'label' => Yii::t('label', 'Delete'), // text label of the button
				  'options' => array("class" => "dorderline", 'title' => Yii::t('label', 'Delete')),
				  ),
				),
			'template' => ' {delete}',
		),*/
	)));
?>
</div>
<?php
	
	if(!empty($orderproduct)){
		$total = 0;
		foreach($orderproduct as $oproduct){
			$total += $oproduct->total;
		}
	
		$vat = $total * 0.05;
		$subtotal = $total - $vat;
?>
<table class="order-details table table-striped table-bordered table-condensed" style="width:30%; float:right; clear:left;">
	<tbody>
		<tr class="odd">
			<td><strong>Sub Total</strong></td><td>N<?php echo $subtotal; ?></td>
		</tr>
		<tr class="even">
			<td><strong>VAT</strong></td><td>N<?php echo $vat; ?></td>
		</tr>
		<tr class="odd">
			<td><strong>Total</strong></td><td>N<?php echo $total; ?></td>
		</tr>
	</tbody>
</table>
<?php } ?>
<div class="clear"></div>
	<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'payment_code',
		'invoice_no',
		//'total',
		//'order_status_id',
		'currency_id',
		'currency_code',
		//'currency_value',
		/*'ip',
		'forwarded_ip',
		'user_agent',
		'date_added',
		'date_modified',*/
	),
)); ?>

<div class="form order-details-page">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'multiple-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php echo $form->errorSummary(array($model, $description)); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'payment_method'); ?>
		<?php echo $form->dropDownList($model,'payment_method', CHtml::listData(PaymentMethod::model()->findAll(), 'id', function($data){return $data->getName();})); ?>
		<?php echo $form->error($model,'payment_method'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'shipping_method'); ?>
		<?php echo $form->dropDownList($model,'shipping_method', CHtml::listData(ShippingMethod::model()->findAll(), 'id', function($data){return $data->getName();})); ?>
		<?php echo $form->error($model,'shipping_method'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'order_status_id'); ?>
		<?php echo $form->dropDownList($model,'order_status_id', CHtml::listData(OrderStatus::model()->findAll(), 'id', function($data){return $data->getName();})); ?>
		<?php echo $form->error($model,'order_status_id'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($description,'comment'); ?>
		<?php echo $form->textArea($description,'comment',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($description,'comment'); ?>
	</div>
	<div class="row buttons">
		<?php echo TbHtml::submitButton('Update', array('color' => TbHtml::BUTTON_COLOR_SUCCESS)); ?>
	</div>
	
<?php $this->endWidget(); ?>
	
</div>