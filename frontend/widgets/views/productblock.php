<?php if(!empty($products)){ 
$catName = $category->getName();
?>
<div class="display_grid">
	<div class="section_head">
		<span><?php echo ucwords($catName); ?></span>
		<a href="<?php echo Yii::app()->createUrl('category/all',array('category'=>$category->getLink())); ?>" class="more_link"><?php echo Yii::t('label','More'); ?> <?php echo strtolower($catName); ?></a>
		<div class="clear"></div>
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
	<div class="span4 product_preview">
		<div class="product_add_cart">
			<a href="<?php echo Yii::app()->createUrl('cart/addtocart',array_merge(array('id'=>$product->id,'quantity'=>1, 'quick'=>1), UtilityHelper::productLink($product->id))); ?>"  class="add_t_cart">
				<?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/quick_cart.png'); ?>
				<?php echo Yii::t('label','Add to Cart'); ?>
			</a>
			<a href="<?php echo Yii::app()->createUrl('product/view',UtilityHelper::productLink($product->id)); ?>" class="quick_view">
				<?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/quick-view.png'); ?>
				<?php echo Yii::t('label','View'); ?>
			</a>
		</div>
		<?php $tpath = Yii::app()->request->baseUrl.'/img/no-image.jpg';
			if(!empty($product->thumbs)){
			$tpath = Yii::app()->request->baseUrl.$product->thumbs[0]->source;
		 }
		?>
		<?php echo CHtml::image($tpath,'',array('class'=>'product_img'));?>
		<a href="<?php echo Yii::app()->createUrl('product/view',UtilityHelper::productLink($product->id)); ?>">
		<span class="product_name"><?php echo $product->getName(); ?></span>
		<span class="product_price"><?php echo UtilityHelper::formatPrice($product->price); ?></span></a>						
	</div>
	<?php }}} ?>
	</div>
</div>
<?php } ?>
