<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/cycommerce/dist/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/cycommerce/dist/css/bootstrap-theme.min.css"/>
		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
	   <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/cycommerce/img/favicon.ico"/>

		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/cycommerce/asserts/nivo-slider/themes/default/default.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/cycommerce/asserts/nivo-slider/themes/pascal/pascal.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/cycommerce/asserts/nivo-slider/themes/orman/orman.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/cycommerce/asserts/nivo-slider/nivo-slider.css" type="text/css" media="screen" />
		
		<!--<link rel="stylesheet" id="theme48651-css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/cycommerce/css/main-style.css" type="text/css" media="all">-->
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/cycommerce/css/main.css" >
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/css/app.css" >
		<!--flex slider-->
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/cycommerce/css/flexslider.css" >
    </head>
    <body>		
		<?php echo $content?>
		
		<!-- Placed at the end of the document so the pages load faster -->
		<!--CDN
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
		-->
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/cycommerce/asserts/nivo-slider/demo/scripts/jquery-1.7.1.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/cycommerce/dist/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/cycommerce/asserts/nivo-slider/jquery.nivo.slider.pack.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/cycommerce/js/main.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.elevatezoom-3.0.8.min.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.flexslider-min.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app.js"></script>
    </body>
</html>
