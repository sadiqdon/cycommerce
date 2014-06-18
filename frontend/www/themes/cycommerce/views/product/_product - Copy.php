<?php $this->beginClip('column2'); ?>
<ul class="breadcrumbs">
	<li><a class="crumb1" href="<?php echo Yii::app()->createUrl('site'); ?>">Home</a></li>
	<?php $category = $this->getCurrentCategory();
	if(!empty($category)){
		$param = array('category'=>$category->getLink());
		if(!empty($category->parent)){
			$param = array('category'=>$category->parent->getLink(),'subcategory'=>$category->getLink());
		?>
			<li><a class="crumb2" href="<?php echo Yii::app()->createUrl('category/all',array('category'=>$category->parent->getLink())); ?>"><?php echo $category->parent->getName(); ?></a></li>
		<?php }?>
		<li><a class="crumb3" href="<?php echo Yii::app()->createUrl('category/all',$param); ?>"><?php echo $category->getName(); ?></a></li>
	<?php }?>
	<li><a class="crumb5" href="#"><?php echo $product->getName(); ?></a></li>
</ul>
<div class="product_gallery">
	<?php if(!empty($product->images)){ ?>
	<div class="flexslider">
	<span class="caption">Mouse over to view large image and scroll on hover to zoom in or out</span>
	  <ul class="slides">
		<?php foreach($product->images as $image){ ?>
		<li data-thumb="<?php echo Yii::app()->request->baseUrl.$image->source; ?>" data-large="<?php echo Yii::app()->request->baseUrl.$image->source; ?>">
		  <?php echo CHtml::image(Yii::app()->request->baseUrl.$image->source,'',array('data-zoom-image'=>Yii::app()->request->baseUrl.$image->source)); ?>
		</li>
		<?php } ?>
	  </ul>
	</div>
	<?php } ?>
</div>
<?php $this->endClip(); ?>
<div class="section_head_general">
	<?php echo $product->getName(); ?>
</div>
<div class="section_body_general product">
	<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
	<form method="post" action="<?php echo Yii::app()->createUrl('cart/addtocart',array('id'=>$product->id)); ?>">
	<div class="row-fluid">
		<div class="span8 product_left">
				<div class="row-fluid">
				<br/>
				<label for="quantity" class="required"><strong>Quantity</strong></label>
				<select class="quantity" name="quantity"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select></div>
			<?php $this->renderPartial('_product_option', array('options'=>$options)); ?>
			<h2><?php echo Yii::t('label','Key Features'); ?></h2>
			<?php echo html_entity_decode($product->getDescription()); 
			if(!empty($product->productAttributes)){
			?>
			<h2><?php echo Yii::t('label','Specifications'); ?></h2>
			<?php $i=0;
			foreach($product->productAttributes as $attr){ ?>
			<div class="row-fluid<?php if($i % 2 == 0){ echo ' odd'; } ?>">
				<div class="span4 column"><?php echo $attr->attribute->getName(); ?></div>
				<div class="span4 column"><?php echo $attr->attribute->text; ?></div>
			</div>
			<?php $i++;
			}} ?>
		</div>
		<div class="span4 product_right">
			<div class="reg"><?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/product_price.png'); ?> <?php echo ' '.Yii::t('label','Price'); ?></div>
			<div class="product_price"><?php echo UtilityHelper::formatPrice($product->price); ?></div>
			<div class="reg"><?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/product_stock.png'); ?><?php echo ' '.Yii::t('label','Stock'); ?></div>
			<div class="product_stock">Only <?php echo $product->quantity; ?> items left</div>
			<div class="product_free"><?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/delivery_icon.png'); ?><div class="p_free"><?php echo Yii::t('info','Free delivery'); ?> <span><?php echo Yii::t('info','In Lagos'); ?></span></div><div class="clear"></div></div>
			<div class="product_free"><?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/pay_delivery.png'); ?><div class="p_free"><?php echo Yii::t('info','Pay on Delivery'); ?></div><div class="clear"></div></div>
			<input type="submit" class="buy_now" value=""/>
		</div>
	</div>
	</form>
</div>