<?php $this->beginClip('column2');
	$this->widget('frontend.widgets.RelatedBlock', array('cart'=>$this->getCartItems())); 
	$this->endClip(); ?>
<div class="checkout_head_general">
	<span class="checkout_title">Checkout</span>
	<div class="checkout_top">
		<span class="in_your_cart">In your Cart</span> <?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/checkout_arrow.png'); ?> <span class="badge"><?php echo $this->getCartCount();?></span> <strong>@ <?php echo UtilityHelper::formatPrice($this->getCartTotal());?></strong> <a href="<?php echo $this->createUrl('cart/cart'); ?>"><?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/checkout_edit.png'); ?></a>
	</div>
	<div class="clear"></div>
</div>
<div class="checkout_address_option">
	<a href="#" class="checkout_home"><?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/checkout_2_home.png'); ?></a>
	<?php if(!empty($add)){ ?>
	<div class="address_box"><span><?php echo $add->firstname.' '.$add->lastname; ?></span><span><?php echo $add->address_1; ?></span><?php if(!empty($add->address_2))echo '<span>'.$add->address_2.'</span>'; ?><span><?php echo $add->city; ?></span><span><?php echo $add->telephone; ?></span></div>
	<?php } ?>
	<a href="<?php echo Yii::app()->createUrl('cart/checkout',array('add'=>$add->id)); ?>" class="checkout_options"><?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/checkout_2_options.png'); ?></a>
	<div class="clear"></div>
</div>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'payment-form',
	//'action' => $this->createUrl('payment'),
));
?>
<div class="section_body_general">
	<div class="checkout_wrapper">
		<h2>Payment Options</h2>
		<div class="row-fluid checkout_options">
			<div class="span1"><input type="radio" name="Payment[payment_method]" value="2"></div>
			<div class="span1"><?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/checkout_2_epayment.png'); ?></div>
			<div class="span10">

				<?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/Interswitch_Verve_Mastercard.gif'); ?><br/>
				<span>Pay with Mastercard and Verve card through Interswitch.</span>
			</div>
		</div>
		<div class="row-fluid checkout_options">
			<div class="span1"><input type="radio" name="Payment[payment_method]" value="4"></div>
			<div class="span1"><?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/checkout_2_epayment.png'); ?></div>
			<div class="span10">
				<!--<div class="head">Online Payment</div>-->
				<?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/Globalpay logo.gif'); ?><br/>
				<span>Pay with Visa through GlobalPay.</span>
			</div>
		</div>
		<div class="row-fluid checkout_options">
			<div class="span1"><input type="radio" name="Payment[payment_method]" value="1"></div>
			<div class="span1"><?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/checkout_2_pay_delivery.png'); ?></div>
			<div class="span10">
				<div class="head">Pay on Delivery</div>
				<span>Pay cash on delivery.</span>
			</div>
		</div>
		<div class="row-fluid checkout_options">
			<div class="span1"><input type="radio" name="Payment[payment_method]" value="3"><checkbox><option value="1"></option></checkbox></div>
			<div class="span1"><?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/checkout_2_bank.png'); ?></div>
			<div class="span10">
				<div class="head">Bank Transfer</div>
				<span>Pay into our Zenith Bank account.</span>
			</div>
		</div>
	</div>
	
</div>

<div class="section_foot_general">
	<a href="<?php echo Yii::app()->createUrl('category'); ?>" class="f_left"><?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/checkout_shopping.png'); ?></a>
	<input type="submit" class="f_right_checkout" value="" />
	<div class="clear"></div>
</div>
<?php $this->endWidget(); ?>