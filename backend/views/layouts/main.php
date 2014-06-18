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
	<?php Yii::app()->clientScript->registerCssFile($this->assetsBase.'/css/main.css')?>
	<?php Yii::app()->clientScript->registerScriptFile($this->assetsBase.'/js/main.js')?>	
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
    'brandLabel'=>Yii::app()->name,
    'brandUrl'=>'#',
    'collapse'=>true, // requires bootstrap-responsive.css
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbNav',
            'items'=>array(
                array('label'=>'Dashboard', 'url'=>array('/site/index'), 'active'=>Yii::app()->controller->id == 'site', 'visible'=>Yii::app()->user->checkAccess('viewDashboard')),
				array('label'=>'Admin', 'url'=>array('/admin/index'), 'active'=>Yii::app()->controller->id == 'admin', 'visible'=>Yii::app()->user->checkAccess('viewAdmin')),
				/*array('label'=>'Instruments', 'url'=>array('/instrument/index'), 'active'=>Yii::app()->controller->id == 'instrument', 'visible'=>(Yii::app()->user->checkAccess('viewInstrument') || Yii::app()->user->checkAccess('createInstrument'))),*/
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

		
		
		<?php $this->widget('bootstrap.widgets.TbNav', array(
			'type'=>TbHtml::NAV_TYPE_TABS, // '', 'tabs', 'pills' (or 'list')
			'stacked'=>false,
			'items'=>array(
                array('label'=>'Dashboard', 'url'=>array('/site/index'), 'active'=>Yii::app()->controller->id == 'site', 'visible'=>Yii::app()->user->checkAccess('viewDashboard')),
				/*array('label'=>'Instruments', 'url'=>array('/instrument/index'), 'active'=>Yii::app()->controller->id == 'instrument', 'visible'=>(Yii::app()->user->checkAccess('viewInstrument') || Yii::app()->user->checkAccess('createInstrument'))),*/
                array('label'=>'Organization', 'url'=>array('/branch/index'), 'active'=>true, 'visible'=>Yii::app()->user->checkAccess('viewBranch')),
				array('label'=>'Privileges', 'url'=>array('/auth/assignment/index'), 'active' => $this instanceof AuthController, 'visible'=>Yii::app()->user->checkAccess('viewPrivilege')),
				array('label'=>'Users', 'url'=>array('/user'), 'active'=>Yii::app()->controller->id == 'admin' || Yii::app()->controller->id == 'user', 'visible'=>Yii::app()->user->checkAccess('viewUser')),
				array('label'=>'Audit Trail', 'url'=>array('/auditTrail/admin'), 'active'=>Yii::app()->controller->id == 'auditTrail', 'visible'=>Yii::app()->user->checkAccess('viewAuditTrail')),
				array('label'=>'Logs', 'url'=>array('/log/index'), 'active'=>Yii::app()->controller->id == 'log', 'visible'=>Yii::app()->user->checkAccess('viewLog')),
            ),
		)); ?>
		
		
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
			Copyright &copy; <?php if(date('Y') == '2013'){ echo "2013"; }else{ echo "2013 - ".date('Y');} ?> Cyhermes Limited.<br/>
			All Rights Reserved.<br/>
		</div><!-- footer -->
	</div>	
	
</div><!-- page -->

</body>
</html>
