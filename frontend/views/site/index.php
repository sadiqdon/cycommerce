<?php
/**
 * index.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 8:30 PM
 */
?>
<?php $this->beginClip('column2');
	$this->widget('frontend.widgets.Column2', array('state'=>'home')); 
$this->endClip();
	?>
<div class="flexslider">
	<ul class="slides">		
		<?php foreach($slides as $i=>$slide){
		?>
		<li class="<?php echo (($i==0) ? 'first': ''); ?>">
			<a href="<?php echo $slide->link; ?>"><img src="<?php echo Yii::app()->request->baseUrl.$slide->images[0]->source; ?>" /></a>
		</li>
		<?php } ?>
	</ul>
	
</div>
