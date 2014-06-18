<?php 
$col1 = FrontendBackgroundImages::model()->findByPk(1);
$col2 = FrontendBackgroundImages::model()->findByPk(2);
if(!empty($col1)){ ?>
<a href="<?php echo $col1->link; ?>" class="column_ad"><img src="<?php echo Yii::app()->request->baseUrl.$col1->images[0]->source; ?>" title="<?php echo $col1->title; ?>"/></a>
<?php } ?>
<div class="newsletter">
	<?php echo TbHtml::beginForm(array('site/newsletter'),'post'); ?>
	<?php echo TbHtml::TextField('email','Enter your Email here',array('class'=>'nl_input')) ?><input type="submit" class="nl_submit" value=""/>
	<div class="clear"></div>
	<?php echo TbHtml::endForm(); ?>
</div>
<?php if(!empty($col2)){ ?>
<a href="<?php echo $col1->link; ?>" class="column_ad"><img src="<?php echo Yii::app()->request->baseUrl.$col2->images[0]->source; ?>" title="<?php echo $col2->title; ?>"/></a>
<?php } ?>