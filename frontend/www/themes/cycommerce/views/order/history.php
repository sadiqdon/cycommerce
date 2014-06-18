<?php $this->pageTitle=Yii::app()->name . ' - '.Yii::t("order","Order History");
$this->menu=array(
	array('label'=>Yii::t('label','Order History'), 'url'=>array('/order/history'), 'active'=>Yii::app()->controller->id == 'order' && Yii::app()->controller->action->id == 'history'),
	array('label'=>Yii::t('label','Profile'), 'url'=>array('/customer'), 'active'=>Yii::app()->controller->id == 'customer' && Yii::app()->controller->action->id == 'view'),
    array('label'=>Yii::t('label','Edit'), 'url'=>array('/customer/update'), 'active'=>Yii::app()->controller->id == 'customer' && Yii::app()->controller->action->id == 'update'),
    array('label'=>Yii::t('label','Change password'), 'url'=>array('/profile/changepassword'), 'active'=>Yii::app()->controller->id == 'profile' && Yii::app()->controller->action->id == 'changepassword'),
    //array('label'=>Yii::t('label','Logout'), 'url'=>array('/user/logout')),
);
?>
<div class="section_head_general"><?php echo Yii::t('order','Your Order History');; ?></div>
<div class="section_body_general">

<div class="inner_wrapper">
<?php if(isset($this->menu)):?>
<?php $this->widget('bootstrap.widgets.TbNav', array(
	'type'=>TbHtml::NAV_TYPE_PILLS, // '', 'tabs', 'pills' (or 'list')
	'stacked'=>false,
	'items'=>$this->menu,
)); ?>
<?php endif?><!-- second secondary menu -->
<?php if(Yii::app()->user->hasFlash('orderMessage')): ?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<?php echo Yii::app()->user->getFlash('orderMessage'); ?>
</div>
<?php endif; ?>
<?php 
	if(isset($orders)){
		if(!empty($orders)){
			$this->widget('bootstrap.widgets.TbGridView', array(
				'id' => 'manufacturer-grid',
				'type'=>array(TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_CONDENSED),
				'dataProvider' => $orders->search(),
				'filter' => $orders,
				'rowCssClassExpression'=>'"items[]_{$data->id}"',
				'columns' => array(
					'id',
					array(
						'name'=>'total',
						'type' => 'raw',
						'value'=> function(){ return UtilityHelper::formatPrice($data->total); },
					),
					array(
						'name'=>'order_status_id',
						'type' => 'raw',
						//'header' => 'Order Status',
						'value'=> function(){
						$status = OrderStatus::model()->findByPk($data->order_status_id);
						return !empty($status) ? $status->name : null;},
					),
					'payment_code',
					'invoice_no'
				),
			)); 
		}else{
			echo "<h5>You have not placed an order with us yet.</h5>";
		}		
	}else{
		echo "<h3>Please <a href=".$this->createUrl('/user/login').">Log in</a> to view your order history</h3>";
	}
?>
</div>
</div>