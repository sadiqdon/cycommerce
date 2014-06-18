<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div id="wrap">
	<div id="wrap_inner">
		<div id="column1">
			<a href="<?php echo Yii::app()->createUrl('site'); ?>" class="main_logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/main_logo.png" title=""/></a>
			<div id="left-nav">
				<?php $this->widget('frontend.widgets.LeftNavigation',array('current'=>$this->getCurrentCategoryLink())); ?>
				<a href="<?php echo Yii::app()->createUrl('/specialOrder'); ?>" class="full_dir"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/special_order.png" title=""/></a>
			</div>
			<!--<a href="#" class="column_ad"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/banner_games.png" title=""/></a>
			<a href="#" class="column_ad"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/banner_tablet.png" title=""/></a>-->
		</div>
		<div id="column2">
			<?php if(isset($this->clips['column2']))
					echo $this->clips['column2'];		
				else
					$this->widget('frontend.widgets.Column2', array('state'=>'home')); ?>
		</div>
		<div id="column3">
			<div class="container-fluid">
				<div class="inner-column3">
					<div class="row-fluid">
						<div class="span4">
							<div class="row-fluid">
							<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/phone_icon.png" class="call_icon span2"/>
							<div class="call_order span10">
								<span class="call_text">Call to order</span><br/>
								<span class="call_phone"><?php echo UtilityHelper::yiiparam('sitePhone'); ?></span>
							</div>
							</div>
						</div>
						<div class="span6 offset2">
							<a href="<?php echo $this->createUrl('/user/profile'); ?>" class="account_link">Account</a>
							<a href="<?php echo $this->createUrl('/cart/cart'); ?>"><div class="s_cart"><span><?php echo $this->getCartCount(); ?></span></div></a>
							<?php if (Yii::app()->user->isGuest) { ?>
							<a href="<?php echo $this->createUrl('/user/login'); ?>" class="logout_link">Login</a>
							<?php }else {; ?>
							<a href="<?php echo $this->createUrl('/user/logout'); ?>" class="logout_link">Logout</a>
							<?php }; ?>
						</div>	
					</div>
					<?php $this->widget('frontend.widgets.SearchBlock', array('current'=>$this->getCurrentCategory(),'currentLink'=>$this->getCurrentCategoryLink())); ?>
					<div id="mainContent" class="row-fluid">
						<?php echo $content; ?>
					</div>
					<?php if(isset($this->clips['similar_products']))
						echo $this->clips['similar_products'];		
					else
						$this->widget('frontend.widgets.ProductBlock'); ?>
					<?php $this->widget('frontend.widgets.ProductBlock'); ?>
				
				</div>
			</div>	
		</div>
		<div class="clear"></div>
	</div>
</div>
<footer>
<div id="footer">
	<div class="container">
		<?php $this->widget('frontend.widgets.Footer'); ?>
	</div>
	<div class="copyright">Copyright &#169; 2014 Yorshop Links Limited</div>
	<a href="http://www.cyhermes.com.ng" class="developed_by">Developed by Cyhermes Limited</a>
</div>
</footer>
<?php $this->endContent(); ?>