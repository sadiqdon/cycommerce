<?php if(!empty($models)){ 
$c=0;
?>
<ul class="nav nav-pills nav-stacked" style="border: 1px solid #edebe8;margin: 0px 20px 0px 0px;">
	<?php foreach($models as $category){ 
		$name = $category->getName();
	if(!empty($name) && $category->top){
		$param = array('category'=>$category->link);
		if(!empty($category->parent)){
			$param = array('category'=>$category->parent->link,'subcategory'=>$category->link);
		}
	?>
	<li class="<?php if($c==0){ echo "";}
	if($current == $category->getLink()){ echo "active"; }?>"><a href="<?php echo Yii::app()->createUrl('category/all',array('category'=>$category->getLink())); ?>"><?php echo $name; ?><span class="pull-right glyphicon glyphicon-chevron-right"></span></a></li>
	<?php $c++; }} ?>
</ul>
<?php } ?><br/>
	<?php echo TbHtml::beginForm(array('site/newsletter'),'post'); ?>
	<div class="input-group input-group-lg" style="padding: 0px 15px 0px 0px; ">
	<?php echo TbHtml::TextField('email','Newsletter',array('class'=>'form-control')) ?><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
	<div class="clear"></div>
	</div>
	<?php echo TbHtml::endForm(); ?>
