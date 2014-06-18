<div class="row-fluid search_row">
	<form method="get" action="<?php echo Yii::app()->createUrl('category/all', array('category'=>$currentLink)); ?>">
	<div class="span1 search_ico"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/search_icon.png"/></div>
	<div class="span5 search_input"><input type="text" name="search" value="Search for products"/></div>
	<div class="span6">
		<input type="hidden" name="cat_type" value=""/>
		<input class="search_button" type="submit" value=""/>
		<div class="ddwrapper">
			<div class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<?php if($currentLink == 'all') echo 'All Categories'; else echo (!empty($current) ? ucwords($current->getName()) : 'All Categories'); ?> <b class="caret"></b>
				</a>
				<ul class="dropdown-menu">
					<li class="<?php if($current == 'all'){ echo "active"; }?>"><a href="<?php echo Yii::app()->createUrl('category/all', array('category'=>'all')); ?>">All Categories</a></li>
					<?php foreach($categories as $category){ 
						$name = $category->getName();
					if(!empty($name) && $category->top){
					?>
					<li class="<?php if($current == $category->getLink()){ echo "active"; }?>"><a href="<?php echo Yii::app()->createUrl('category/all', array('category'=>$category->getLink())); ?>"><?php echo $name; ?></a></li>
					<?php }} ?>
				</ul>
			</div>
		</div>			
		<div class="clear"></div>	
	</div>
	</form>
</div>