<?php if(!empty($categories)){ ?>
<!--<div class="cat_filter_head"><?php echo ucwords($name).' '.Yii::t('label','Categories'); ?> </div>-->
<ul class="breadcrumbs">
	<li><a class="crumb1" href="<?php echo Yii::app()->createUrl('site'); ?>">Home</a></li>
	<?php $category = $cat;
	if(!empty($category)){
		$param = array('category'=>$category->getLink());
		if(!empty($category->parent)){
			$param = array('category'=>$category->parent->getLink(),'subcategory'=>$category->getLink());
		?>
			<li><a class="crumb2" href="<?php echo Yii::app()->createUrl('category/all',array('category'=>$category->parent->getLink())); ?>"><?php echo $category->parent->getName(); ?></a></li>
		<?php }?>
		<li><a class="crumb3" href="<?php echo Yii::app()->createUrl('category/all',$param); ?>"><?php echo $category->getName(); ?></a></li>
	<?php }?>
</ul>
<?php if(!$inn){ ?>
	<ul class="cat_filter">
	<?php $catinput = array();
	foreach($categories as $category){ 
		$cname = $category->getName();
	if(!empty($cname)){
		$param = array('category'=>$category->link);
		if(!empty($category->parent)){
			$param = array('category'=>$category->parent->link,'subcategory'=>$category->link);
		}
		$catinput[$category->id] = $category->getName();
	?>
	<li class="<?php if(!next($category)){ echo "n_last ";}
	if($current == $category->link){ echo "active";} ?>"><a href="<?php echo Yii::app()->createUrl('category/all',$param); ?>"><?php echo $cname; ?></a></li>
	<?php }} ?>
	<?php //echo CHtml::checkBoxList('categories', array(), $catinput, array('template'=>'<li class="category">{input} {label}</li>', 'container'=>'', 'separator'=>'')); ?>
</ul>
<?php }} ?>
<?php if(!empty($brands)){ 
$c = 0;
?>
<div class="cat_filter_head"><?php echo Yii::t('label','Brands'); ?>
	<div class="search_filter">
		<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'id' => 'brand-form',
			'method' => 'get'
		));
		?>
		<input name="brand" class="text" type="text"/><input class="submit" type="submit" value="" />
		<?php $this->endWidget(); ?>
	</div>
</div>
<ul class="cat_filter">
	<?php foreach($brands as $id=>$brand){ 
		if($c > 9){ break; }
	?>
	<li><a href="<?php echo Yii::app()->createUrl('category/all', Controller::getCategoryParams()).'?brand='.$brand; ?>"><?php if(trim(Yii::app()->request->getParam('brand')) == trim($brand)){echo "<strong>".$brand."</strong>";}
	else{ echo $brand; } 
	?></a></li>
	<?php $c++; } ?>
	<?php //echo CHtml::checkBoxList('brands', array(), $brands, array('template'=>'<li class="category">{input} {label}</li>', 'container'=>'', 'separator'=>'')); ?>
</ul>
<?php } ?>
<div class="cat_filter_head">Price</div>
<div class="cat_filter_body">
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'id' => 'price-form',
			'method' => 'get'
		));
		?>
	<div class="price_left"><span class="curr">&#8358;</span><input type="text" value="0" name="minValue"/></div>
	<div class="price_right"><span class="curr">&#8358;</span><input type="text" value="5000000" name="maxValue"/></div>
	<input class="hide" type="submit" value="" />
	<?php $this->endWidget(); ?>
	<div class="clear"></div>
	<input type="text" class="slider" value="" data-slider-min="0"  data-slider-max="5000000" data-slider-step="100" data-slider-value="[0, 5000000]" />
</div>
<div class="cat_filter_body">
</div>			