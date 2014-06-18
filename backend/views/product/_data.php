<?php
/* @var $this ProductController */
/* @var $model Product */
/* @var $form CActiveForm */
?>

<div class="form aform">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'product-data-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo $form->labelEx($model,'model'); ?>
		<?php echo $form->textField($model,'model',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'model'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sku'); ?>
		<?php echo $form->textField($model,'sku',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'sku'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'upc'); ?>
		<?php echo $form->textField($model,'upc',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'upc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ean'); ?>
		<?php echo $form->textField($model,'ean',array('size'=>14,'maxlength'=>14)); ?>
		<?php echo $form->error($model,'ean'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'jan'); ?>
		<?php echo $form->textField($model,'jan',array('size'=>13,'maxlength'=>13)); ?>
		<?php echo $form->error($model,'jan'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'isbn'); ?>
		<?php echo $form->textField($model,'isbn',array('size'=>13,'maxlength'=>13)); ?>
		<?php echo $form->error($model,'isbn'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mpn'); ?>
		<?php echo $form->textField($model,'mpn',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'mpn'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'location'); ?>
		<?php echo $form->textField($model,'location',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'location'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity'); ?>
		<?php echo $form->textField($model,'quantity'); ?>
		<?php echo $form->error($model,'quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'stock_status_id'); ?>
		<?php echo CHtml::activeDropDownList($model,'stock_status_id', CHtml::listData(StockStatus::model()->findAll(), 'id', 'name')); ?>
		<?php echo $form->error($model,'stock_status_id'); ?>
	</div>

	<div class="row">
		<label for="Image_file"><?php echo Yii::t('label','Image'); ?></label>
			<span class="btn btn-success fileinput-button">
				<i class="icon-plus icon-white"></i>
				<span>Select Thumbnail...</span>
				<?php
					$this->widget('yiiwheels.widgets.fileupload.WhBasicFileUpload',
						array(
							//'name' => 'file',
							'attribute' => 'file',
							'id' => 'thumb',
							'model' => $image,						
							'uploadAction' => $this->createUrl('upload',array('svar'=>'thumbs')),
							'pluginOptions' => array(
								'dataType' => 'json',
								'acceptFileTypes' => "js:/(\.|\/)(gif|jpe?g|png)$/i",
								'maxFileSize' => 4000000,
								'maxNumberOfFiles' => 1,
								'getNumberOfFiles' => "js:function(){return jQuery('#bfiles3 .row').length;}",
								'done' => 'js:function(e, data){
									jQuery.each(data.result.files, function(i, file){
										jQuery(\'<div class="row"><div class="span3">\'+file.name+\'</div><div class="span2"><a href="\'+file.deleteUrl+\'" class="deleteupload btn btn-danger"><i class="icon-trash"></i> '.Yii::t('label','Delete').'</a></div></div>\').appendTo("#bfiles3");
									});
								}',
								'processfail' => "js:function(e, data){var index = data.index,
            file = data.files[index];
									if (file.error) { 
										jQuery('<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>'+file.error+'</div>').appendTo('#bfiles3');
									}
								}",
								'progressall' => "js:function (e, data) {
								var progress = parseInt(data.loaded / data.total * 100, 10);
								jQuery('#bprogress2 .bar').css(
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
			<div id="bprogress2" class="progress progress-success progress-striped">
				<div class="bar"></div>
			</div>
			<!-- The container for the uploaded files -->
			<div id="bfiles3" class="files span6">
			<?php if(isset($thumbs)){
				foreach( $thumbs as $image ) { ?>
				<div class="row"><div class="span3"><?php echo $image["name"]; ?></div><div class="span2"><a href="<?php echo $this->createUrl( "upload", array("_method" => "delete","file" => $image["filename"],"svar" => "thumbs") );?>" class="deleteupload btn btn-danger"><i class="icon-trash"></i> <?php echo Yii::t('label','Delete'); ?></a></div></div>
			<?php }
			}
			?>
			</div>
			<div class="clearfix"></div>
		</div><!-- row -->

	<div class="row">
		<?php echo $form->labelEx($model,'shipping'); ?>
		<?php $this->widget('yiiwheels.widgets.switch.WhSwitch', array(
		'attribute' => 'shipping',
		'model' => $model,
		'onColor' => 'success',
		'offColor' => 'danger',
		'onLabel' => Yii::t('label','YES'),
		'offLabel' => Yii::t('label','NO'),
		'size' => null,
		));?>
		<?php echo $form->error($model,'shipping'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tax_class_id'); ?>
		<?php echo CHtml::activeDropDownList($model,'tax_class_id', CHtml::listData(TaxClass::model()->findAll(), 'id', function($data){ return $data->getName();})); ?>
		<?php echo $form->error($model,'tax_class_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_available'); ?>
		<?php echo CHtml::activeDateField($model,'date_available'); ?>
		<?php echo $form->error($model,'date_available'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'weight'); ?>
		<?php echo $form->textField($model,'weight',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'weight'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'weight_class_id'); ?>
		<?php echo CHtml::activeDropDownList($model,'weight_class_id', CHtml::listData(WeightClass::model()->findAll(), 'id', function($data){ return $data->getName();})); ?>
		<?php echo $form->error($model,'weight_class_id'); ?>
	</div>

	<div class="row">
		<?php echo CHtml::label('Dimension (Lx W x H)', false); ?>
		<?php echo $form->textField($model,'length',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->textField($model,'width',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->textField($model,'height',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'length_class_id'); ?>
		<?php echo CHtml::activeDropDownList($model,'length_class_id', CHtml::listData(WeightClass::model()->findAll(), 'id', function($data){ return $data->getName();})); ?>
		<?php echo $form->error($model,'length_class_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subtract'); ?>
		<?php $this->widget('yiiwheels.widgets.switch.WhSwitch', array(
		'attribute' => 'subtract',
		'model' => $model,
		'onColor' => 'success',
		'offColor' => 'danger',
		'onLabel' => Yii::t('label','YES'),
		'offLabel' => Yii::t('label','NO'),
		'size' => null,
		));?>
		<?php echo $form->error($model,'subtract'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'minimum'); ?>
		<?php echo $form->textField($model,'minimum'); ?>
		<?php echo $form->error($model,'minimum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sort_order'); ?>
		<?php echo $form->textField($model,'sort_order'); ?>
		<?php echo $form->error($model,'sort_order'); ?>
	</div>

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
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->
