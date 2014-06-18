<?php if(!empty($models)){ 
$c=0;
?>
<ul class="nav_in">
	<?php foreach($models as $category){ 
		$name = $category->getName();
	if(!empty($name) && $category->top){
		/*$param = array('category'=>$category->link);
		if(!empty($category->parent)){
			$param = array('category'=>$category->parent->link,'subcategory'=>$category->link);
		}*/
	?>
	<li class="<?php if($c==0){ echo "n_first ";}
	if($current == $category->getLink()){ echo "active"; }?>"><a href="<?php echo Yii::app()->createUrl('category/all',array('category'=>$category->getLink())); ?>"><?php echo $name; ?></a></li>
	<?php $c++; }} ?>
</ul>
<?php } ?>