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
		array(
			'label'=>'Order Status',
			'type'=>'raw',
			'value'=> OrderStatus::model()->findByPk($model->order_status_id)->getName(),
		),
		array(
			'label'=>'comment',
			'type'=>'raw',
			'value'=>!empty($description) ? $description->comment : null,
		),
		'currency_id',
		//'currency_code',
		//'currency_value',
		'ip',
		'forwarded_ip',
		'user_agent',
		'date_added',
		'date_modified',
	),
)); ?>
	

</div>