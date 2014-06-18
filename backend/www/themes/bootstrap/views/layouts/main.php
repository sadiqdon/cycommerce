<?php /* @var $this Controller */ 
Yii::app()->bootstrap->register(); 
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/main.css')?>
	
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/main.js')?>	
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<!--[if lt IE 9]>
		<style type="text/css">
			#wrap{display: none;}
			#noie{ color: red; display: block; margin: 0 auto; position: relative; width: 600px;}
		</style>
	<![endif]-->
</head>

<body>
<?php $this->widget('bootstrap.widgets.TbNavbar', array(
    'brandLabel'=>UtilityHelper::yiiparam('site_name'),
	//'color' => TbHtml::NAVBAR_COLOR_INVERSE,
    'brandUrl'=>'#',
    'collapse'=>true, // requires bootstrap-responsive.css
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbNav',
            'items'=>array(
                array('label'=>'Dashboard', 'url'=>array('/site/index'), 'active'=>Yii::app()->controller->id == 'site', 'visible'=>Yii::app()->user->checkAccess('viewDashboard')),
				array('label' => 'Catalog', 'items' => array(
					array('label'=>'Categories', 'url'=>array('/category/index'), 'active'=>Yii::app()->controller->id == 'category', 'visible'=>(Yii::app()->user->checkAccess('viewCategory'))),
					array('label'=>'product', 'url'=>array('/product/index'), 'active'=>Yii::app()->controller->id == 'product', 'visible'=>(Yii::app()->user->checkAccess('viewProduct'))),
					array('label' => 'Attributes', 'items' => array(
						array('label'=>'Attributes', 'url'=>array('/attribute/index'), 'active'=>Yii::app()->controller->id == 'attribute', 'visible'=>(Yii::app()->user->checkAccess('viewAttribute'))),
						array('label'=>'Attribute Groups', 'url'=>array('/attributeGroup/index'), 'active'=>Yii::app()->controller->id == 'attributeGroup', 'visible'=>(Yii::app()->user->checkAccess('viewAttributeGroup'))),
					)),
					array('label'=>'Options', 'url'=>array('/option/index'), 'active'=>Yii::app()->controller->id == 'option', 'visible'=>(Yii::app()->user->checkAccess('viewOption'))),
					array('label'=>'Manufacturers', 'url'=>array('/manufacturer/index'), 'active'=>Yii::app()->controller->id == 'manufacturer', 'visible'=>(Yii::app()->user->checkAccess('viewManufacturer'))),
					array('label'=>'Store', 'url'=>array('/store/'), 'active'=>Yii::app()->controller->id == 'store', 'visible'=>(Yii::app()->user->checkAccess('viewStore'))),
				)),
				array('label' => 'Sales', 'items' => array(
					array('label'=>'Orders', 'url'=>array('/order/index'), 'active'=>Yii::app()->controller->id == 'order', 'visible'=>(Yii::app()->user->checkAccess('viewOrder'))),
					array('label'=>'Special Orders', 'url'=>array('/specialOrder/index'), 'active'=>Yii::app()->controller->id == 'specialOrder', 'visible'=>(Yii::app()->user->checkAccess('viewSpecialOrder'))),
					array('label' => 'Sales', 'items' => array(
						array('label'=>'Customers', 'url'=>array('/customer/index'), 'active'=>Yii::app()->controller->id == 'customer', 'visible'=>(Yii::app()->user->checkAccess('viewCustomer'))),
						array('label'=>'Customer Groups', 'url'=>array('/cGroup/index'), 'active'=>Yii::app()->controller->id == 'customerGroup', 'visible'=>(Yii::app()->user->checkAccess('viewCustomerGroup'))),
					)),
					array('label'=>'Returns', 'url'=>array('/returns/index'), 'active'=>Yii::app()->controller->id == 'returns', 'visible'=>(Yii::app()->user->checkAccess('viewReturns'))),
					array('label'=>'PaymentTransaction', 'url'=>array('/paymentTransaction/index'), 'active'=>Yii::app()->controller->id == 'paymentTransaction', 'visible'=>Yii::app()->user->checkAccess('viewPaymentTransaction')),
				)),
				array('label' => 'System', 'items' => array(
					array('label'=>'Privileges', 'url'=>array('/auth/assignment/index'), 'active' => $this instanceof AuthController, 'visible'=>Yii::app()->user->checkAccess('viewPrivilege')),
					array('label'=>'Employees', 'url'=>array('/staff'), 'active'=>Yii::app()->controller->id == 'staff' || Yii::app()->controller->id == 'staff', 'visible'=>Yii::app()->user->checkAccess('viewEmployee')),
					array('label'=>'Employee Group', 'url'=>array('/group'), 'active'=>Yii::app()->controller->id == 'group', 'visible'=>Yii::app()->user->checkAccess('viewGroup')),
					array('label' => 'Localization', 'items' => array(
						array('label'=>'Languages', 'url'=>array('/language/index'), 'active'=>Yii::app()->controller->id == 'language', 'visible'=>Yii::app()->user->checkAccess('viewLocalization')),
						array('label'=>'Currencies', 'url'=>array('/currency/index'), 'active'=>Yii::app()->controller->id == 'currency', 'visible'=>Yii::app()->user->checkAccess('viewLocalization')),
						array('label'=>'Countries', 'url'=>array('/country/index'), 'active'=>Yii::app()->controller->id == 'country', 'visible'=>Yii::app()->user->checkAccess('viewLocalization')),
						array('label' => 'Taxes', 'items' => array(
							array('label'=>'Tax Class', 'url'=>array('/taxClass/index'), 'active'=>Yii::app()->controller->id == 'taxClass', 'visible'=>Yii::app()->user->checkAccess('viewLocalization')),
							array('label'=>'Tax Rates', 'url'=>array('/taxRate/index'), 'active'=>Yii::app()->controller->id == 'taxRate', 'visible'=>Yii::app()->user->checkAccess('viewLocalization')),
						)),
						array('label'=>'Zones', 'url'=>array('/zone/index'), 'active'=>Yii::app()->controller->id == 'zone', 'visible'=>Yii::app()->user->checkAccess('viewLocalization')),
						array('label'=>'GeoZones', 'url'=>array('/geoZone/index'), 'active'=>Yii::app()->controller->id == 'geoZone', 'visible'=>Yii::app()->user->checkAccess('viewLocalization')),
						array('label'=>'Length', 'url'=>array('/lengthClass/index'), 'active'=>Yii::app()->controller->id == 'lengthClass', 'visible'=>Yii::app()->user->checkAccess('viewLocalization')),
						array('label'=>'Weight', 'url'=>array('/weightClass/index'), 'active'=>Yii::app()->controller->id == 'weightClass', 'visible'=>Yii::app()->user->checkAccess('viewLocalization')),
					), 'visible'=>Yii::app()->user->checkAccess('viewLocalization')),
					array('label'=>'Audit Trail', 'url'=>array('/auditTrail/admin'), 'active'=>Yii::app()->controller->id == 'auditTrail', 'visible'=>Yii::app()->user->checkAccess('viewAuditTrail')),
					array('label'=>'Newsletter', 'url'=>array('/newsletter/index'), 'active'=>Yii::app()->controller->id == 'newsletter', 'visible'=>Yii::app()->user->checkAccess('viewNewsletter')),
					array('label'=>'Logs', 'url'=>array('/log/index'), 'active'=>Yii::app()->controller->id == 'log', 'visible'=>Yii::app()->user->checkAccess('viewLog')),
					array('label'=>'FrontendSliderImages', 'url'=>array('/frontendSliderImages/index'), 'active'=>Yii::app()->controller->id == 'frontendSliderImages', 'visible'=>Yii::app()->user->checkAccess('viewFrontendSliderImage')),
					array('label'=>'FrontendBackgroundImages', 'url'=>array('/frontendBackgroundImages/index'), 'active'=>Yii::app()->controller->id == 'frontendBackgroundImages', 'visible'=>Yii::app()->user->checkAccess('viewFrontendBackgroundImage')),			
					array('label'=>'Pages', 'url'=>array('/page/index'), 'active'=>Yii::app()->controller->id == 'page', 'visible'=>Yii::app()->user->checkAccess('viewPage')),
					array('label' => 'Themes', 'items' => array(
						array('label'=>'Add Theme', 'url'=>array('/theme/'), 'active'=>Yii::app()->controller->id == 'theme', 'visible'=>Yii::app()->user->checkAccess('viewTheme')),
					array('label'=>'Activate Theme', 'url'=>array('/theme/activateTheme'), 'active'=>Yii::app()->controller->id == 'active', 'visible'=>Yii::app()->user->checkAccess('viewActivate')),
					)),
					array('label' => 'Settings', 'items' => array(
						array('label'=>'Backend Settings', 'url'=>array('/backendSettings'), 'active'=>Yii::app()->controller->id == 'active', 'visible'=>Yii::app()->user->checkAccess('viewSettings')),				
						array('label'=>'Frontend Settings', 'url'=>array('/settings'), 'active'=>Yii::app()->controller->id == 'active', 'visible'=>Yii::app()->user->checkAccess('viewSettings')),				
					)),
					
					array('label'=>'Online Payment Options', 'url'=>array('/onlinepaymentoptions'), 'active'=>Yii::app()->controller->id == 'active', 'visible'=>Yii::app()->user->checkAccess('viewOnlinePaymentOptions')),
				)),
				array('label' => 'Reports', 'items' => array(
					array('label' => 'Sales', 'items' => array(
						array('label'=>'Orders', 'url'=>array('/orderReport/admin'), 'active'=>Yii::app()->controller->id == 'orderReport', 'visible'=>Yii::app()->user->checkAccess('viewReport')),
						array('label'=>'Tax', 'url'=>array('/taxReport/admin'), 'active'=>Yii::app()->controller->id == 'taxReport', 'visible'=>Yii::app()->user->checkAccess('viewReport')),
						array('label'=>'Shipping', 'url'=>array('/shippingReport/admin'), 'active'=>Yii::app()->controller->id == 'shippingReport', 'visible'=>Yii::app()->user->checkAccess('viewReport')),
						array('label'=>'Returns', 'url'=>array('/returnReport/admin'), 'active'=>Yii::app()->controller->id == 'returnReport', 'visible'=>Yii::app()->user->checkAccess('viewReport')),
					)),	
					array('label' => 'Products', 'items' => array(
						array('label'=>'Viewed', 'url'=>array('/productViewReport/admin'), 'active'=>Yii::app()->controller->id == 'productViewReport', 'visible'=>Yii::app()->user->checkAccess('viewReport')),
						array('label'=>'Purchased', 'url'=>array('/productPurchasedReport/admin'), 'active'=>Yii::app()->controller->id == 'productPurchasedReport', 'visible'=>Yii::app()->user->checkAccess('viewReport')),
					)),	
					array('label' => 'Customers', 'items' => array(
						array('label'=>'Customers Online', 'url'=>array('/customersOnReport/admin'), 'active'=>Yii::app()->controller->id == 'customersOnReport', 'visible'=>Yii::app()->user->checkAccess('viewReport')),
						array('label'=>'Orders', 'url'=>array('/customersOrderReport/admin'), 'active'=>Yii::app()->controller->id == 'customersOrderReport', 'visible'=>Yii::app()->user->checkAccess('viewReport')),
					)),	
				)),
            ),
        ),
        array(
            'class'=>'bootstrap.widgets.TbNav',
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(
                array('label'=>'Login', 'url'=>array('/user/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/user/logout'), 'visible'=>!Yii::app()->user->isGuest),
            ),
        ),
    ),
)); ?>
<h2 id="noie">Please install Firefox (version 21.0)</h2>
<div id="wrap">

	<div id="main" class="container">		
				
		<?php if(isset($this->menu)):?>
		<?php $this->widget('bootstrap.widgets.TbNav', array(
			'type'=>TbHtml::NAV_TYPE_PILLS, // '', 'tabs', 'pills' (or 'list')
			'stacked'=>false,
			'items'=>$this->menu,
		)); ?>
		<?php endif?><!-- second secondary menu -->
		<div id="eMessage"></div>
		<?php echo $content; ?>

		<div class="clear"></div>	
		<div id="footer">
			Copyright &copy; <?php if(date('Y') == '2013'){ echo "2013"; }else{ echo "2013 - ".date('Y');} ?> <?php echo UtilityHelper::yiiparam('site_name'); ?>.<br/>
			All Rights Reserved.<br/>
		</div><!-- footer -->
	</div>	
	
</div><!-- page -->

</body>
</html>
