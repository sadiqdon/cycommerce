<?php $this->widget('bootstrap.widgets.TbAlert'); ?><div class="aform form">


<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'category-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		Fields with <span class="required">*</span> are required.
	</p>

	<?php echo $form->errorSummary(array($model, $description)); ?>
		
		<div class="row">
		<?php echo $form->labelEx($description,'name'); ?>
		<?php echo $form->textField($description, 'name'); ?>
		<?php echo $form->error($description,'name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($description,'description'); ?>
		<?php $this->widget('yiiwheels.widgets.redactor.WhRedactor', array(
			'model' => $description,
			'attribute' => 'description',
			'pluginOptions' => array(
				'lang' => Yii::app()->getLanguage(),
			)
		));?>
		<?php echo $form->error($description,'description'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($description,'meta_description'); ?>
		<?php echo TbHtml::activeTextArea($description, 'meta_description'); ?>
		<?php echo $form->error($description,'meta_description'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($description,'meta_keyword'); ?>
		<?php echo TbHtml::activeTextArea($description, 'meta_keyword'); ?>
		<?php echo $form->error($description,'meta_keyword'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'store_id'); ?>
		<?php echo $form->dropDownList($model, 'store_id', TbHtml::listData(Store::model()->findAll(array('order'=>'name')), 'id', 'name')); ?>
		<?php echo $form->error($model,'store_id'); ?>
		</div><!-- row -->
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
							'uploadAction' => $this->createUrl('upload'),
							'pluginOptions' => array(
								'dataType' => 'json',
								'acceptFileTypes' => "js:/(\.|\/)(gif|jpe?g|png)$/i",
								'maxFileSize' => 4000000,
								'maxNumberOfFiles' => 2,
								'getNumberOfFiles' => "js:function(){return jQuery('#bfiles .row').length;}",
								'done' => 'js:function(e, data){
									jQuery.each(data.result.files, function(i, file){
										jQuery(\'<div class="row"><div class="span3">\'+file.name+\'</div><div class="span2"><a href="\'+file.deleteUrl+\'" class="deleteupload btn btn-danger"><i class="icon-trash"></i> '.Yii::t('label','Delete').'</a></div></div>\').appendTo("#bfiles");
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
				<div class="row"><div class="span3"><?php echo $image["name"]; ?></div><div class="span2"><a href="<?php echo $this->createUrl( "upload", array("_method" => "delete","file" => $image["filename"]) );?>" class="deleteupload btn btn-danger"><i class="icon-trash"></i> <?php echo Yii::t('label','Delete'); ?></a></div></div>
			<?php }
			}
			?>
			</div>
			<div class="clearfix"></div>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php echo $form->dropDownList($model, 'parent_id', TbHtml::listData(Category::model()->with('categoryDescriptions')->findAll(array('order'=>'categoryDescriptions.name')), 'id', function($data) { return CHtml::encode($data->getName());}), array('empty'=>'--Parent Category--')); ?>
		<?php echo $form->error($model,'parent_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'top'); ?>
		<?php $this->widget('yiiwheels.widgets.switch.WhSwitch', array(
		'attribute' => 'top',
		'model' => $model,
		'onColor' => 'success',
		'offColor' => 'danger',
		'onLabel' => Yii::t('label','ON'),
		'offLabel' => Yii::t('label','OFF'),
		'size' => null,
		));?>		
		<?php echo $form->error($model,'top'); ?>
		</div><!-- row -->
		
		
		<div class="row">
		<?php echo $form->labelEx($model,'column'); ?>
		<?php echo $form->textField($model, 'column'); ?>
		<?php echo $form->error($model,'column'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'sort_order'); ?>
		<?php echo $form->textField($model, 'sort_order'); ?>
		<?php echo $form->error($model,'sort_order'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php $this->widget('yiiwheels.widgets.switch.WhSwitch', array(
		'attribute' => 'status',
		'model' => $model,
		'onColor' => 'success',
		'offColor' => 'danger',
		'onLabel' => Yii::t('label','ON'),
		'offLabel' => Yii::t('label','OFF'),
		'size' => null,
		));?>
		<?php echo $form->error($model,'status'); ?>
		</div><!-- row -->

<?php
echo GxHtml::submitButton('Save');
$this->endWidget();
?>
</div><!-- form -->
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>