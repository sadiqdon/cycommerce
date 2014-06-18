<?php
/* @var $this FrontendBackgroundImagesController */
/* @var $model FrontendBackgroundImages */
/* @var $form CActiveForm */
?>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?><div class="form aform">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'frontend-background-images-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary(array($model,$description)); ?>

	
	<div class="row">
		<?php echo $form->labelEx($description,'title'); ?>
		<?php echo $form->textField($description, 'title'); ?>
		<?php echo $form->error($description,'title'); ?>
	</div><!-- row -->
	
	<div class="row">
		<?php echo $form->labelEx($model,'link'); ?>
		<?php echo $form->textField($model,'link',array('maxlength' => 300)); ?>
		<?php echo $form->error($model,'link'); ?>
	</div>
	
	<div class="row">
		<label for="Image_file"><?php echo Yii::t('label','Image'); ?></label>
			<span class="btn btn-success fileinput-button">
				<i class="icon-plus icon-white"></i>
				<span>Select files...</span>
				<?php
					$this->widget('yiiwheels.widgets.fileupload.WhBasicFileUpload',
						array(
							//'name' => 'file',
							'attribute' => 'file',
							'model' => $image,						
							'uploadAction' => $this->createUrl('upload',array('svar'=>'FrontendBackgroundImg')),
							'pluginOptions' => array(
								'dataType' => 'json',
								'acceptFileTypes' => "js:/(\.|\/)(gif|jpe?g|png)$/i",
								'maxFileSize' => 4000000,
								'maxNumberOfFiles' => 1,
								'getNumberOfFiles' => "js:function(){return jQuery('#bfiles .row').length;}",
								'done' => 'js:function(e, data){
									jQuery.each(data.result.files, function(i, file){
										jQuery(\'<div class="row"><div class="span3">\'+file.name+\'</div><div class="span2"><a href="\'+file.deleteUrl+\'"&svar=FrontendBackgroundImg class="deleteupload btn btn-danger"><i class="icon-trash"></i> '.Yii::t('label','Delete').'</a></div></div>\').appendTo("#bfiles");
									});
								}',
								'processfail' => "js:function(e, data){var index = data.index,
            file = data.files[index];
									if (file.error) { 
										jQuery('<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>'+file.error+'</div>').appendTo('#bfiles');
									}
								}",
								'progressall' => "js:function (e, data) {
								var progress = parseInt(data.loaded / data.total * 100, 10);
								jQuery('#bprogress .bar').css(
								'width',
								progress + '%'
								);
								}"
							)
						)
					);
				?>
			</span>
			<br>
			<br>
			<!-- The global progress bar -->
			<div id="bprogress" class="progress progress-success progress-striped">
				<div class="bar"></div>
			</div>
			<!-- The container for the uploaded files -->
			<div id="bfiles" class="files span6">
			<?php if(isset($userImages)){
				foreach( $userImages as $image ) { ?>
				<div class="row"><div class="span3"><?php echo $image["name"]; ?></div><div class="span2"><a href="<?php echo $this->createUrl( "upload", array("_method" => "delete","file" => $image["filename"],"svar" => "FrontendBackgroundImg") );?>" class="deleteupload btn btn-danger"><i class="icon-trash"></i> <?php echo Yii::t('label','Delete'); ?></a></div></div>
			<?php }
			}
			?>
			</div>
			<div class="clearfix"></div>
		</div><!-- row -->


	<div class="row buttons">
		<?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('label','Create') : Yii::t('label','Save'), array('color' => TbHtml::BUTTON_COLOR_SUCCESS)); ?>
		<?php echo TbHtml::linkButton(Yii::t('label','Cancel'), array('class'=>'cancelButton','color' => TbHtml::BUTTON_COLOR_DANGER, 'url'=>Yii::app()->createUrl('frontendbackgroundimages/admin')));?>
	</div>
	

<?php $this->endWidget(); ?>

</div><!-- form -->
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>