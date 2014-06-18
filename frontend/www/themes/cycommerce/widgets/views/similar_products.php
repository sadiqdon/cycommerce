<?php if(!empty($products)){ ?>
<div class="display_grid">
	<div class="section_head">
		<h4>Similar Products</h4>
		<div class="clear"></div><br/>
	</div>
	<div class="row-fluid">	
	<?php 
	shuffle($products);
	for($i=0; $i < 3; $i++){
		if(isset($products[$i])){
			$product = $products[$i];
			$name = $product->getName();
			
			if(!empty($name)){
	?>
	<div class="col-md-4 product_preview">
		<div class="product_add_cart">
			<!--<a href="<?php echo Yii::app()->createUrl('product/view',UtilityHelper::productLink($product->id)); ?>" class="add_t_cart>
				<?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/quick-view.png'); ?>
				<?php echo Yii::t('label','View'); ?>
			</a>-->
			<a href="<?php echo Yii::app()->createUrl('cart/addtocart',array_merge(array('id'=>$product->id,'quantity'=>1, 'quick'=>1), UtilityHelper::productLink($product->id))); ?>"  class="quick_view"">
				<p style="font-size: 300%;" class="img-responsive img-cirle glyphicon glyphicon-shopping-cart"></p>
			</a>
			<a href="<?php echo Yii::app()->createUrl('product/view',UtilityHelper::productLink($product->id)); ?>"><span class="sale round">SALE</span></a>	
		</div>
		<?php $tpath = Yii::app()->request->baseUrl.'/img/no-image.jpg';
			if(!empty($product->thumbs)){
			$tpath = Yii::app()->request->baseUrl.$product->thumbs[0]->source;
		 }
		?>
				<?php echo CHtml::image($tpath,'',array('class'=>'product_img'));?>
		<div style="background-color:#e4f3f2;">
			<a href="<?php echo Yii::app()->createUrl('product/view',UtilityHelper::productLink($product->id)); ?>"><span class="product_name"><?php echo $product->getName(); ?></span>
			<span class="product_price"><?php echo UtilityHelper::formatPrice($product->price); ?></span></a>					
		</div>						
	</div>
	<?php }}} ?>
	</div>
</div>
<?php } ?>
