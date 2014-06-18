<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'theme-form',
	'action' => $this->createUrl('activateTheme'),
));
?>
<div class="section_body_general">
	<div class="checkout_wrapper">
		<h2>Theme Options</h2><br/>
		<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
		<?php foreach($models as $model){ ?>
		<div class="row-fluid checkout_options">
			<div class="span1"><?php echo $form->radioButton($model,'name', array('value'=>$model->name)); ?></div>
			<div class="span11">
				<img src="<?php echo Yii::app()->request->baseUrl.'/../../frontend/www/themes/'.$model->name.'/screen.png'; ?>" alt="Screen Shot" title="<?php echo $model->name; ?>" /><br/>
				<br/><span><?php echo ucwords($model->name); ?></span>
			</div>
		</div><hr/>
		<?php } ?>
	</div>
	
</div>
<br/>
<div class="section_foot_general">
	<input type="reset" class="btn" value="Cancel" />
	<input type="submit" class="btn btn-success" value="Activate" />
	<div class="clear"></div>
</div>
<?php $this->endWidget(); ?>