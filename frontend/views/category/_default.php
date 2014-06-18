<?php $this->beginClip('column2');
	$this->widget('frontend.widgets.CategoryNavigation', array('current'=>$this->getCurrentCategoryLink())); 
	$this->endClip(); ?>
<div class="display_grid">
<div class="section_cat_head">
	<span><?php $cat=$this->getCurrentCategory(); if(!empty($cat)) echo $this->getCurrentCategory()->getName(); else{ echo 'All Categories'; }?></span>
	<div class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/sort_by.png'); ?> Sort by <b class="caret"></b>
		</a>
		<ul class="dropdown-menu">
		<?php $params = $this->getCategoryParams(); ?>
			<li<?php if($this->getSort() == 'lprice') echo ' class="active"'; ?>><a href="<?php $params['sort'] = 'lprice'; echo Yii::app()->createUrl('category/all',$params); ?>">Lowest Price</a></li>
			<li<?php if($this->getSort() == 'hprice') echo ' class="active"'; ?>><a href="<?php $params['sort'] = 'hprice'; echo Yii::app()->createUrl('category/all',$params); ?>">Highest Price</a></li>
			<li<?php if($this->getSort() == 'arrival') echo ' class="active"'; ?>><a href="<?php $params['sort'] = 'arrival'; echo Yii::app()->createUrl('category/all',$params); ?>">New Arrival</a></li>
			<li<?php if($this->getSort() == 'name') echo ' class="active"'; ?>><a href="<?php $params['sort'] = 'name'; echo Yii::app()->createUrl('category/all',$params); ?>">Name</a></li>
			<li<?php if($this->getSort() == 'brand') echo ' class="active"'; ?>><a href="<?php $params['sort'] = 'brand'; echo Yii::app()->createUrl('category/all',$params); ?>">Brand</a></li>	
		</ul>
	</div>
	<div class="clear"></div>						
</div>
<div class="section_cat_type">
	<a href="<?php $params['type'] = 'arrival'; echo Yii::app()->createUrl('category/all',$params); ?>">New Arrivals</a>
	<a href="<?php $params['type'] = 'top_seller'; echo Yii::app()->createUrl('category/all',$params); ?>">Top Sellers</a>
	<a href="<?php $params['type'] = 'on_sale'; echo Yii::app()->createUrl('category/all',$params); ?>">On Sale</a>
</div>
<?php 
if(!empty($products)){
$i=0;
foreach($products as $i=>$product){
if($i % 3 == 0){ ?>
<div class="row-fluid search_cat_row">		
<?php }
	$name = $product->getName();
	if(!empty($name)){
	?>
	<div class="span4 product_preview">
		<div class="product_add_cart">		
			<?php $param = array();
			if($category = $this->getCurrentCategory()){
				$param = array('category'=>$category->getLink(),'product'=>$product->getLink());
				if(!empty($category->parent))
					$param = array('category'=>$category->parent->getLink(),'subcategory'=>$category->getLink(),'product'=>$product->getLink());
			}else{
				$param = array('category'=>'all','product'=>$product->getLink());
			}			
			?>
			<a href="<?php echo Yii::app()->createUrl('cart/addtocart',array_merge(array('id'=>$product->id,'quantity'=>1, 'quick'=>1), UtilityHelper::productLink($product->id))); ?>"  class="add_t_cart">
				<?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/quick_cart.png'); ?>
				<?php echo Yii::t('label','Add to Cart'); ?>
			</a>
			<a href="<?php echo Yii::app()->createUrl('product/view',UtilityHelper::productLink($product->id)); ?>" class="quick_view">
				<?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/quick-view.png'); ?>
				<?php echo Yii::t('label','View'); ?>
			</a>
		</div>
		
		<?php $tpath = Yii::app()->request->baseUrl.'/no-image.jpg';
			if(!empty($product->thumbs)){
			$tpath = Yii::app()->request->baseUrl.$product->thumbs[0]->source;
		 }
		?>
		<?php echo CHtml::image($tpath,'',array('class'=>'product_img'));?>
		<a href="<?php echo Yii::app()->createUrl('product/view',UtilityHelper::productLink($product->id)); ?>"><span class="product_name"><?php echo $product->getName(); ?></span>
		<span class="product_price"><?php echo UtilityHelper::formatPrice($product->price); ?></span></a>					
	</div>
	<?php }
		
if($i % 3 == 2 || $i == count($products)-1){ ?>	
</div>	
<?php }
$i++;
}
}else{ ?>
	<div class="section_body_general"><div class="checkout_wrapper"><p>Sorry, no results found for your search.</p></div></div>
<?php } ?>
<div class="section_cat_pager">
	<a href="#" class="top"><?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/category_top.png'); ?>Top</a>
	<div class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/sort_by.png'); ?> Sort by <b class="caret"></b>
		</a>
		<ul class="dropdown-menu">
		<?php $params = $this->getCategoryParams(); ?>
			<li<?php if($this->getSort() == 'lprice') echo ' class="active"'; ?>><a href="<?php $params['sort'] = 'lprice'; echo Yii::app()->createUrl('category/all',$params); ?>">Lowest Price</a></li>
			<li<?php if($this->getSort() == 'hprice') echo ' class="active"'; ?>><a href="<?php $params['sort'] = 'hprice'; echo Yii::app()->createUrl('category/all',$params); ?>">Highest Price</a></li>
			<li<?php if($this->getSort() == 'arrival') echo ' class="active"'; ?>><a href="<?php $params['sort'] = 'arrival'; echo Yii::app()->createUrl('category/all',$params); ?>">New Arrival</a></li>
			<li<?php if($this->getSort() == 'name') echo ' class="active"'; ?>><a href="<?php $params['sort'] = 'name'; echo Yii::app()->createUrl('category/all',$params); ?>">Name</a></li>
			<li<?php if($this->getSort() == 'brand') echo ' class="active"'; ?>><a href="<?php $params['sort'] = 'brand'; echo Yii::app()->createUrl('category/all',$params); ?>">Brand</a></li>	
		</ul>
	</div>
	<?php $this->widget('CLinkPager', array(
            'pages' => $pages,
			'header' => "<div class='pagination pagination-right'>",
			'footer' => "</div>",
			'nextPageLabel' => 'Next',
			'prevPageLabel' => 'Prev',
			'selectedPageCssClass' => 'active',
			'hiddenPageCssClass' => 'disabled',
			'htmlOptions' => array(
				'class' => '',
			),
        )); ?>
</div>
</div>