<div class="related_head">
	<span class="head1">Leaving already?</span>
	<span class="head2">Check these Out!</span>
</div>
<?php 
shuffle($products);
foreach($products as $i=>$related){ 
	$cat = $related->categories;
	
	if(!empty($cat)){
		$category = $cat[0];
		$link = Yii::app()->createUrl('product/view',array('category'=>$category->getLink(),'product'=>$related->getLink()));
		if(!empty($category->parent))
			$link = Yii::app()->createUrl('product/view',array('category'=>$category->parent->getLink(),'subcategory'=>$category->getLink(),'product'=>$related->getLink()));
	}else{
		$link = Yii::app()->createUrl('product/view',array('product'=>$related->getLink()));
	}
?>

<div class="related<?php if(($i+1) % 2 == 0) echo ' related_odd'; ?>">
	<div class="related_inner">
		<a href="<?php echo $link; ?>"><?php $tpath = Yii::app()->request->baseUrl.'/img/no-image.jpg';
			if(!empty($related->thumbs)){
			$tpath = Yii::app()->request->baseUrl.$related->thumbs[0]->source;
		 }
		?>
		<?php echo CHtml::image($tpath);?>
		<span class="related_title"><?php echo $related->getName(); ?></span>					
		<span class="related_price"><?php echo UtilityHelper::formatPrice($related->price); ?></span></a>
	</div>
</div>
	<?php if($i==2)
		break;
} ?>

