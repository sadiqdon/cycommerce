<?php //$this->beginClip('column2');
	//$this->widget('frontend.widgets.RelatedBlock', array('cart'=>$this->getCartItems())); 
	//$this->endClip(); ?>
<div class="col-md-12">
	<div class="checkout_address_option">
	<!--<a href="#" class="checkout_home"><?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/checkout_2_home.png'); ?></a>-->
	<?php if(!empty($add)){ ?>
	<div class="address_box"><span><?php echo $add->firstname.' '.$add->lastname; ?></span><span><?php echo $add->address_1; ?></span><?php if(!empty($add->address_2))echo '<span>'.$add->address_2.'</span>'; ?><span><?php echo $add->city; ?></span><span><?php echo $add->telephone; ?></span></div>
	<?php } ?>
</div>
	<div class="checkout_top">
		<span class="in_your_cart" style="font-size: 120%">Item(s) </span><i style="font-size: 120%" class="glyphicon glyphicon-hand-right"></i> <span class="badge"><?php echo $this->getCartCount();?></span> <strong>@ <?php echo UtilityHelper::formatPrice($this->getCartTotal());?></strong> <a class="btn btn-warning btn-md" href="<?php echo $this->createUrl('cart/cart'); ?>">Edit Cart</a>
	</div>
	<div class="clearfix"></div>
</div>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'payment-form',
	//'action' => $this->createUrl('payment'),
));
?>
<div class="clearfix"></div><br/>
		<div class="col-md-12">
				<h2 class="h2Line">Payment Options 
			<span class="pull-right">
				<a href="<?php echo Yii::app()->createUrl('cart/checkout',array('add'=>$add->id)); ?>" class="btn btn-info btn-md">Edit Delivery Options</a>
			</span>
			</h2>
		</div>
		<div class="clearfix"></div><br/>
		<?php $this->getOnlinePaymentOptions(); ?>
		<!-- We will have to get the value based on their ids -->
		<div class="radio">
                    <label>Pay on Delivery
					<input type="radio" name="Payment[payment_method]" value="1">
					<br/><span class="text-muted">Pay cash on delivery.</span>
					</label>
		</div><hr/>
		<div class="radio">
			<label>Bank Transfer 
			<input type="radio" name="Payment[payment_method]" value="3">
			<br/><span class="text-muted">Pay into our Zenith Bank account.</span>
			</label>
		</div><hr/>
	<div class="clearfix"></div>
<div class="section_foot_general">
	<a class="btn btn-primary btn-md pull-left" href="<?php echo Yii::app()->createUrl('category'); ?>"><i class="glyphicon glyphicon-hand-left"> </i> Shop some more!!!</a>
		<button class="pull-right btn btn-success btn-lg" type="submit">Pay <i class="glyphicon glyphicon-bell"></i></button>
	<div class="clearfix"></div>
</div>
<?php $this->endWidget(); ?>
<br/><br/>