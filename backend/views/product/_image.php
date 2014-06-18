<div class="row-fluid">
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
							'uploadAction' => $this->createUrl('upload', array('svar'=>'product_images')),
							'pluginOptions' => array(
								'dataType' => 'json',
								'acceptFileTypes' => "js:/(\.|\/)(gif|jpe?g|png)$/i",
								'maxFileSize' => 4000000,
								'maxNumberOfFiles' => 10,
								'getNumberOfFiles' => "js:function(){return jQuery('#bfiles .row').length;}",
								'done' => 'js:function(e, data){
									jQuery.each(data.result.files, function(i, file){
										jQuery(\'<div class="row-fluid"><div class="span3">\'+file.name+\'</div><div class="span3 offset2"><a href="\'+file.deleteUrl+\'" class="deleteupload btn btn-danger"><i class="icon-trash"></i> '.Yii::t('label','Delete').'</a></div></div>\').appendTo("#bfiles");
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
				<div class="row-fluid"><div class="span3"><?php echo $image["name"]; ?></div><div class="span3 offset2"><a href="<?php echo $this->createUrl( "upload", array("_method" => "delete","svar" => "product_images","file" => $image["filename"]) );?>" class="deleteupload btn btn-danger"><i class="icon-trash"></i> <?php echo Yii::t('label','Delete'); ?></a></div></div>
			<?php }
			}
			?>
			</div>
			<div class="clearfix"></div>
		</div><!-- row -->