<?php Yii::app()->getClientScript()->registerCoreScript('yii');  ?>
<div class="section_head_general"><?php echo Yii::t('label','OrderStatus'); ?></div>
<div class="section_body_general">
<div class="inner_wrapper">
<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<?php if(Yii::app()->user->hasFlash(TbHtml::ALERT_COLOR_ERROR)): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash(TbHtml::ALERT_COLOR_ERROR); ?>
</div>
<?php else: ?>

<div class="form">
<?php echo TbHtml::beginForm(); ?>
	
	<div class="row-fluid">
		<?php echo TbHtml::Label('Transaction Reference #', 'trans_id'); ?>
		<?php echo TbHtml::TextField('trans_id') ?>
		<p class="hint"><?php echo Yii::t('label',"Please enter your Transaction Reference Number."); ?></p>
	</div>
	
	<div class="row-fluid submit">
		<?php echo TbHtml::button(yii::t('label','Get Status'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'submit'=>'')); ?>
	</div>

<?php echo TbHtml::endForm(); ?>
</div><!-- form -->
<?php endif; ?>
</div>
</div>