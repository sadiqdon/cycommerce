<?php /* @var $this Controller */ ?>
<?php $cyCommercethemePath = '/themes/' . UtilityHelper::yiiparam('theme') . "/"; ?>
<?php $this->beginContent('//layouts/main'); ?>
	<section class="container-fluid">
			<section id="page">
				<section class="col-md-12" style='margin-top: -0.5%;'>
					<section class="col-lg-7">
						<h3 class="col-md-offset-7"><span class="glyphicon glyphicon-earphone" style="color:#fff;"></span> <?php echo UtilityHelper::yiiparam('sitePhone'); ?></h3>
					</section>
					<section class="col-lg-5">
							<div class="navbar-header">
							  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only" style="color:#333;background-color:#fff;">Toggle navigation</span>
								<span class="icon-bar" style="color:#fff;background-color:#333;"></span>
								<span class="icon-bar" style="color:#fff;background-color:#333;"></span>
								<span class="icon-bar" style="color:#fff;background-color:#333;"></span>
							  </button>
							</div>
								<nav>
									<ul class="breadcrumb">
										<li><a href="#"><span class="glyphicon glyphicon-gift"></span>&nbsp;Delivery</a></li>
										<li><a href="<?php echo Yii::app()->createUrl('/page/view',array('name'=>'faq')); ?>"><span class="glyphicon glyphicon-question-sign"></span>&nbsp;Faq</a></li>
										<li><a href="<?php echo $this->createUrl('cart/cart'); ?>"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Checkout </a></li>
										<li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;My Account</a></li>
									</ul> 
								</nav>
							<div class="collapse navbar-collapse">	  					
								<div class="visible-sm visible-xs">
									<?php $this->widget('themealias.widgets.LeftNavigation',array('current'=>$this->getCurrentCategoryLink())); ?>
								</div>	
							</div><!-- /.nav-collapse -->
					</section>
				</section>	
				<header class="container navCon">
					<section class="row">
						<section class="col-md-12">
								<section class="col-md-4 logoHelper">
									<section class="logo pull-left">
										<a href="<?php echo Yii::app()->createUrl('site'); ?>">
											<img class="img-responsive" src="<?php echo Yii::app()->request->baseUrl;?>/themes/cycommerce/img/logo.png" alt="CyCommerce" title="CyCommerce">
										</a>
									</section>
								</section>
								<section class="col-md-5">
									<section class="form-inline">
										<?php $this->widget('themealias.widgets.SearchBlock', array('current'=>$this->getCurrentCategory(),'currentLink'=>$this->getCurrentCategoryLink())); ?>
									</section>
								</section>	
								<section class="col-md-3">
									<section class="col-md-offset-3" style="margin-top: -18px;">
										<article><h3><a class="btn btn-success" href="<?php echo $this->createUrl('/cart/cart'); ?>"><span class="glyphicon glyphicon-shopping-cart"></span>Shopping Cart <span class="badge"><?php echo $this->getCartCount(); ?></span></a></h3></article>
								</section>
							</section>
						</section>
					</section>
				</header><hr/>
				<section class="row">
					<section class="col-md-12">
						<article class="col-md-3 visible-lg visible-md">
							<?php $this->widget('themealias.widgets.LeftNavigation',array('current'=>$this->getCurrentCategoryLink())); ?>
							<br/><a class=" btn btn-success btn-lg" href="<?php echo Yii::app()->createUrl('/specialOrder'); ?>" class="full_dir">Special Order</a>
							<br/><br/>
							<!--<nav style="padding: 5px;border:1px solid #eee;">-->
							<nav>
							<!--<img style="margin-left: -1%" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/cycommerce/img/sale.png" title="Sale" />-->
								<a href="#"><img class="img-thumbnail img-responsive" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/cycommerce/img/hotDeal.jpg" title="top seller"/></a>
								<br/><br/>
								<!--<a style="padding-left: 7%;" href="#"><img class="img-thumbnail img-responsive" src="<?php echo Yii::app()->request->baseUrl; ?>/uploads/83/0f0b2d3baaac17805d143691900c4b6e.jpg" title="most viewed"/></a>-->
							</nav>
						</article>
						<article class="col-md-9">
							<?php echo $content; ?>
							<?php if(isset($this->clips['similar_products'])){
								echo $this->clips['similar_products'];		
							}else{
								$this->widget('themealias.widgets.ProductBlock'); 
								}?>
						</article>
						<div class="clearfix"></div>
						<nav style="padding: 5px; position: relative; bottom: 0px">
								<ul class="nav nav-pills nav-justified">
									<li><img class="payment_logos" src="<?php echo Yii::app()->request->baseUrl; ?>/img/Globalpay logo.gif" title=""/></li>
									<li><img class="payment_logos" src="<?php echo Yii::app()->request->baseUrl; ?>/img/MC_new.png" title=""/></li>
									<li><img class="payment_logos" src="<?php echo Yii::app()->request->baseUrl; ?>/img/logo_visa.gif" title=""/></li>
									<li><img class="payment_logos" src="<?php echo Yii::app()->request->baseUrl; ?>/img/ISW_new.png" title=""/></li>
									<li><img class="payment_logos" src="<?php echo Yii::app()->request->baseUrl; ?>/img/Verve_new.png" title=""/></li>
									<li><img class="payment_logos" src="<?php echo Yii::app()->request->baseUrl; ?>/img/etranzact.jpg" title=""/></li>
								</ul>
						</nav>
					</section>
				</section>
				<br/><br/>
				<footer class="container footer navbottomBG" style="background-color: #EFF4D0;width: 105%;margin: 0px 0px -2% -2.5%; padding: 0px;">
					<section class="row">
						<section class="col-md-12">
								<section class="col-md-3">
									<nav>
										<h3>Site Links</h3>
											<ul>
												<li><a href="<?php echo Yii::app()->createUrl('/page/view',array('name'=>'faq')); ?>">FAQs</a></li>
												<li><a href="<?php //echo Yii::app()->createUrl('/page/contactus'); ?>">Contact Us</a></li>
												<li><a href="<?php //echo Yii::app()->createUrl('/page/view',array('name'=>'about-us')); ?>">About Us</a></li>
												<li><a href="<?php //echo Yii::app()->createUrl('/page/view',array('name'=>'return-policy')); ?>">Return Policy</a></li>
												<li><a href="<?php //echo Yii::app()->createUrl('/page/view',array('name'=>'privacy-policy')); ?>">Privacy Policy</a></li>
												<li><a href="<?php //echo Yii::app()->createUrl('/page/view',array('name'=>'terms-conditions')); ?>">Terms and Conditions</a></li>
												<li><a href="<?php //echo Yii::app()->createUrl('/page/view',array('name'=>'how-it-works')); ?>">How it works</a></li>	
											</ul>
									</nav> 
								</section>
								<section class="col-md-3">
										<nav style="padding: 5px;">
											<h3>Socials</h3>
												<a style="background-color: rgb(59, 89, 152);padding: 10px;" href="#" target="blank" data-toggle="tooltip" data-placement="right"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/facebook.png" alt="Facebook" title="Like us on Facebook"/></a>
												<a style="background-color: rgb(85, 172, 238);padding: 10px;" href="#" target="blank" data-toggle="tooltip" data-placement="right"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/twitter.png" alt="Twitter" title="Twitter"/></a>
												<a style="background-color: rgb(14, 118, 168);padding: 10px;" href="#" target="blank" data-toggle="tooltip" data-placement="right"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/linkedin.png" alt="Linkedin" title="Linkedin"/></a>
												<a style="background-color: rgb(221, 75, 57);padding: 10px;" href="#" target="blank" data-toggle="tooltip" data-placement="right"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/google_plus.png" alt="Google+" title="Google+"/></a><br/><br/>
												<a style="background-color: rgb(0, 175, 240);padding: 10px;" href="#" target="blank" data-toggle="tooltip" data-placement="right"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/skype.png" alt="Skype" title="Skype"/></a>
												<a style="background-color: rgb(196, 48, 47);padding: 10px;" href="#" target="blank" data-toggle="tooltip" data-placement="right"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/youtube.png" alt="Youtube" title="Youtube"/></a>
										</nav>
								</section>
								<section class="col-md-3">
									<h3>ABOUT</h3>
									<p>Lorem ipsum dolor sit ametcter adipiscing
									elistie lacus. Aenean nonuit mauris.
									Phasellus porta. Fusce suscvarius
									sociis natoque penatibu.</p>
								</section>
								<section class="col-md-3">
									<h3>CONTACTS</h3> 
									<address>
										No 1 Aso Rock Village Lagos Nigeria
										<br/><a href="tel:phone<?php echo UtilityHelper::yiiparam('sitePhone'); ?>"><span class="glyphicon glyphicon-phone"></span>  <?php echo UtilityHelper::yiiparam('sitePhone'); ?></a><br/>
										<a href="mailto:<?php echo UtilityHelper::yiiparam('salesEmail'); ?>"><span class="glyphicon glyphicon-envelope"></span>  <?php echo UtilityHelper::yiiparam('salesEmail'); ?></a>
									</address>
								</section>
						</section><div class="clearfix"></div>
						<p style="background-color: #333; color: #eee;margin: 0px 1% 0% 1%;" class="text-justify text-center"><small>Copyright (c) <?php echo Date('Y'); ?> <?php echo UtilityHelper::yiiparam('site_name'); ?></small></p>
					</section>
				</footer>       
			</section>
			<!--<div id="back-top-wrapper" class="visible-lg">
				<p style="display: block;" id="back-top">
					<a href="#top"><span></span></a> </p>
			</div>-->
	</section>
<?php $this->endContent(); ?>