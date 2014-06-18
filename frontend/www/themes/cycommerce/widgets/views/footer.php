<?php if(!empty($models)){ ?>
	<div class="row">
		<div class="span4">
			<span class="footer_section_head">YorShop</span>
			<ul class="footer_links">
				<li><a href="<?php echo Yii::app()->createUrl('/page/contactus'); ?>">Contact Us</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('/page/view',array('name'=>'about-us')); ?>">About Us</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('/page/faq'); ?>">FAQs</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('/page/view',array('name'=>'return-policy')); ?>">Return Policy</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('/page/view',array('name'=>'privacy-policy')); ?>">Privacy Policy</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('/page/view',array('name'=>'terms-conditions')); ?>">Terms and Conditions</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('/page/view',array('name'=>'how-it-works')); ?>">How it works</a></li>
			</ul>
		</div>
		<div class="span4">
			<span class="footer_section_head">Payments</span>
			<ul class="footer_links">
				<li><img class="payment_logos" src="<?php echo Yii::app()->request->baseUrl; ?>/img/Globalpay logo.gif" title=""/></li>
				<li><img class="payment_logos" src="<?php echo Yii::app()->request->baseUrl; ?>/img/MC_new.png" title=""/></li>
				<li><img class="payment_logos" src="<?php echo Yii::app()->request->baseUrl; ?>/img/logo_visa.gif" title=""/></li>
				<li><img class="payment_logos" src="<?php echo Yii::app()->request->baseUrl; ?>/img/ISW_new.png" title=""/></li>
				<li><img class="payment_logos" src="<?php echo Yii::app()->request->baseUrl; ?>/img/Verve_new.png" title=""/></li>
				<li><img class="payment_logos" src="<?php echo Yii::app()->request->baseUrl; ?>/img/etranzact.jpg" title=""/></li>
			</ul>
		</div>
		<div class="span4">
			<span class="footer_section_head">Partners</span>
			<ul class="footer_links">
				<li><a href="#">Dell</a></li>
				<li><a href="#">HP</a></li>
			</ul>
		</div>
	</div>

<?php } ?>