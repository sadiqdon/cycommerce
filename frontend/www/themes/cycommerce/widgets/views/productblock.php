<?php if(!empty($products)){ 
$catName = $category->getName();
?>
<div class="display_grid">
	<div class="section_head">
		<span><?php echo ucwords($catName); ?></span>
		<a href="<?php echo Yii::app()->createUrl('category/all',array('category'=>$category->getLink())); ?>" class="more_link"><?php echo Yii::t('label','More'); ?> <?php echo strtolower($catName); ?></a>
		<div class="clearfix"></div><br/>
	</div>
	<div class="row-fluid">	
	<?php 
	shuffle($products);
	for($i=0; $i < 3; $i++){
		if(isset($products[$i])){
		$product = $products[$i];
		$name = $product->getName();
		
	if(!empty($name)){
		$param = array('category'=>$category->link);
		if(!empty($category->parent)){
			$param = array('category'=>$category->parent->link,'subcategory'=>$category->link);
		}
	?>
	<div class="col-md-3 product_preview">
		<div class="product_add_cart">	
			<!--<a href="<?php echo Yii::app()->createUrl('product/view',UtilityHelper::productLink($product->id)); ?>" class="add_t_cart">
				<p style="font-size: 400%;" class="img-responsive img-cirle alert-danger glyphicon glyphicon-zoom-in"></p>
			</a>-->
			<a href="<?php echo Yii::app()->createUrl('cart/addtocart',array_merge(array('id'=>$product->id,'quantity'=>1, 'quick'=>1), UtilityHelper::productLink($product->id))); ?>"  class="quick_view">
				<p style="font-size: 300%;" class="img-responsive img-cirle glyphicon glyphicon-shopping-cart"></p>
			</a>
			<?php $randSale = rand(0,2); ?>
			<?php 
				if($randSale == 1){
				?>
					<a href="<?php echo Yii::app()->createUrl('product/view',UtilityHelper::productLink($product->id)); ?>"><span class="sale round">HOT</span></a>	
				<?php }else{ ?>
						<a href="<?php echo Yii::app()->createUrl('product/view',UtilityHelper::productLink($product->id)); ?>"><span class="sale2 round">View</span></a>	
					<?php } ?>
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
