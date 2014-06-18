<br/>
<div class="col-md-12" >
	<div class="col-md-8 " style="margin-top:-2.4%;background-color:#e4f3f2;padding: 0px 20px 10px">
	<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id' => 'address-form',
		'action'=> Yii::app()->createUrl($this->id.'/checkout'),
	));
	?>
	<h3>Enter New Address</h3>
	<?php if(!empty($address)){ ?>
	<?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/checkout_or.png','',array('class'=>'add_or')); ?>
	<span class="old_add_title">Select your Address to Proceed</span>
	<?php } ?>
		<div class="shipping_new_add_inner">
			<div class="row">		
			<?php echo $form->errorSummary($model); ?>
			</div>
			<div class="row-fluid">
			<div class="span4"><?php echo $form->labelEx($model,'firstname'); ?></div>
			<div class="span8"><?php echo $form->textField($model, 'firstname', array('maxlength' => 32)); ?>
			<?php echo $form->error($model,'firstname'); ?>
			</div>
			
			</div><!-- row -->
			<div class="row-fluid">
			<div class="span4"><?php echo $form->labelEx($model,'lastname'); ?></div>
			<div class="span8"><?php echo $form->textField($model, 'lastname', array('maxlength' => 32)); ?>
			<?php echo $form->error($model,'lastname'); ?></div>
			</div><!-- row -->
			<div class="row-fluid">
			<div class="span4"><?php echo $form->labelEx($model,'email'); ?></div>
			<div class="span8"><?php echo $form->textField($model, 'email', array('maxlength' => 32)); ?>
			<?php echo $form->error($model,'email'); ?></div>
			</div><!-- row -->
			<div class="row-fluid">
			<div class="span4"><?php echo $form->labelEx($model,'telephone'); ?></div>
			<div class="span8"><?php echo $form->textField($model, 'telephone', array('maxlength' => 32)); ?><?php echo $form->error($model,'telephone'); ?></div>
			</div><!-- row -->
			<div class="row-fluid">
			<div class="span4"><?php echo $form->labelEx($model,'address_1'); ?></div>
			<div class="span8"><?php echo $form->textField($model, 'address_1', array('maxlength' => 128)); ?>
			<?php echo $form->error($model,'address_1'); ?></div>
			</div><!-- row -->
			<div class="row-fluid">
			<div class="span4"><?php echo $form->labelEx($model,'address_2'); ?></div>
			<div class="span8"><?php echo $form->textField($model, 'address_2', array('maxlength' => 128)); ?>
			<?php echo $form->error($model,'address_2'); ?></div>
			</div><!-- row -->
			<div class="row-fluid">
			<div class="span4"><?php echo $form->labelEx($model,'city'); ?></div>
			<div class="span8"><?php echo $form->textField($model, 'city', array('maxlength' => 128)); ?>
			<?php echo $form->error($model,'city'); ?></div>
			</div><!-- row -->
			<div class="row-fluid">
			<div class="span4"><?php echo $form->labelEx($model,'postal_code'); ?></div>
			<div class="span8"><?php echo $form->textField($model, 'postal_code', array('maxlength' => 10)); ?>
			<?php echo $form->error($model,'postal_code'); ?></div>
			</div><!-- row -->
			<div class="row-fluid">
			<div class="span4"><?php echo $form->labelEx($model,'zone_id'); ?></div>
			<div class="span8"><?php echo $form->dropDownList($model, 'zone_id', CHtml::listData(Zone::model()->findAll('country_id=:country_id', array(':country_id'=>156), 'id', 'name'), 'id', 'name')); ?>
			<?php echo $form->error($model,'zone_id'); ?></div>
			</div>
			<br/><br/>
				<a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('category'); ?>">Continue Shopping</a> <input type="submit" class="pull-right btn btn-success" value="Select a Payment Option"/>
			<!-- row -->
			<input name="id" type="hidden" value="<?php echo $model->id; ?>" />

	
	<?php if(!empty($address)){ ?>
	<div class="shipping_old_add">
		<div class="shipping_old_add_inner">
			<?php foreach($address as $i=>$add){ 
			echo CHtml::hiddenField('add',$add->id); ?>
			<a href="<?php echo Yii::app()->createUrl('cart/checkout', array('ywol'=>$add->id+3,'golp'=>$add->id,'ylop'=>$add->id+2)); ?>"><div class="address_box"><span><?php echo $add->firstname.' '.$add->lastname; ?></span><span><?php echo $add->address_1; ?></span><?php if(!empty($add->address_2))echo '<span>'.$add->address_2.'</span>'; ?><span><?php echo $add->city; ?></span><span><?php echo $add->telephone; ?></span></div></a>
			<?php } ?>
		</div>
	</div>
	<?php } ?>
	</div>
</div>

<div class="col-md-4" style="margin: -2.3% 0px 0px;">
	<?php 
		$cid = strtolower((string)$this->id);
	if($cid != 'specialorder'){ ?>
	<div class="pull-right alert-success">
		<span class="in_your_cart">In your Cart</span> <i class="glyphicon glyphicon-play"></i><span class="badge"><?php echo $this->getCartCount();?></span> <strong>@ <?php echo UtilityHelper::formatPrice($this->getCartTotal());?></strong> <a href="<?php echo $this->createUrl('cart/cart'); ?>"><?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/checkout_edit.png'); ?></a>
	</div>
	<?php } ?>
	<div class="clearfix"><br/></div>
</div>
</div>
<div class="col-md-12"><br/>
		<?php $this->beginClip('column2');
		$this->widget('frontend.widgets.RelatedBlock', array('cart'=>$this->getCartItems())); 
		$this->endClip(); ?>
</div>
<?php $this->endWidget(); ?>