<div class="section_head_general">
	Your Shopping Cart
</div>
<div class="section_body_general"  style="margin-top: -6%">
<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
	<?php if(empty($cart)){ ?>
	<div class="checkout_wrapper"><p>There are no items in your shopping cart</p></div>
	<?php }else{ ?>
	<table class="cart table table-striped table-bordered">
	<thead>
	<tr>
	<th>Product</th><th></th><th>Price</th><th>Quantity</th><th>To Pay</th><th></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach($cart as $pos=>$product){ ?>
	<tr>
		<td><?php echo CHtml::image(Yii::app()->request->baseUrl.$this->productImageThumb($product['product_id']),'',array('class'=>'thumb')); ?></td>
		<td class="title"><span><a href="<?php echo Yii::app()->createUrl('product/view', UtilityHelper::productLink($product['product_id'])); ?>"><?php echo $product['name']; ?></a></span>
			<span class="<?php if($product['stock'] < 6) { echo 'red';} else{ echo 'green';} ?>">Only <strong><?php echo $product['stock']; ?></strong> <em>in stock</em></span>
		</td>
		<td><span class="price"><?php echo UtilityHelper::formatPrice($product['price']); ?></span></td>
		<td><select class="quantity" name="quantity"><?php for($i=1; $i <= 20; $i++){echo "<option value='$i'";if($i==$product['quantity']) echo " selected='selected'"; echo ">$i</option>";}?></select><span class="hide addlink"><?php echo Yii::app()->createUrl('cart/addtocart',array('id'=>$product['product_id'])); ?></span><span class="hide pid"><?php echo $product['product_id']; ?></span></td>
		<td><div class="topay"><?php echo UtilityHelper::formatPrice($product['total']); ?></div><div class="topay_break"><span class="badge"><?php echo $product['quantity']; ?></span> x <?php echo UtilityHelper::formatPrice($product['price']); ?></div></td>
		<td><a href="<?php echo Yii::app()->createUrl('cart/removefromcart',array('id'=>$pos)); ?>" class="del_check_line"><i class="alert-danger glyphicon glyphicon-remove"></i> </a></td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
	<br/>
	<div class="pull-right">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-6">Sub Total</div>
				<div class="col-md-6"><?php echo UtilityHelper::formatPrice($this->getCartSubTotal());?></div>
			</div>
			<div class="row odd">
				<div class="col-md-6">Delivery</div>
				<div class="col-md-6"><?php echo UtilityHelper::formatPrice($this->getDelivery());?></div>
			</div>
			<div class="row">
				<div class="col-md-6">VAT</div>
				<div class="col-md-6"><?php echo UtilityHelper::formatPrice($this->getVAT());?></div>
			</div>
			<div class="row odd">
				<div class="col-md-6">Total</div>
				<div class="col-md-6"><?php echo UtilityHelper::formatPrice($this->getCartTotal());?></div>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
<div class="clearfix"></div><br/>
<div class="section_foot_general" style="background-color:#e4f3f2;">
	<a  class="btn btn-success" href="<?php echo Yii::app()->createUrl('category'); ?>" class="f_left"><i class="glyphicon glyphicon-shopping-cart"></i> Continue Shopping</a>
	<?php if(!empty($cart)){ ?>
	<a href="<?php echo Yii::app()->createUrl('cart/checkout'); ?>" class="f_right btn btn-primary"><i class="glyphicon glyphicon-bell"></i> Checkout</a>
	<?php } ?>
	<div class="clearfix"></div>
</div><br/>