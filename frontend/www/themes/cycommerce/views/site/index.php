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
		<section class="row visible-lg visible-md">
			<section class="row slider-wrapper theme-default" style="width:810px;margin-left:2%;">
				<section class="ribbon"></section>
				<section id="slider" class="nivoSlider">
					<?php foreach($slides as $i=>$slide){ ?>
						<p><a href="<?php echo $slide->link ; ?>">
							<img class="img-responsive" title="<?php echo $slide->title; ?>"  src="<?php echo Yii::app()->request->baseUrl.$slide->images[0]->source; ?>" />
						</a></p>
					<?php } ?>	
				</section>
			</section>
		</section>
