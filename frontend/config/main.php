<?php
/**
 * main.php
 *
 * This file holds frontend configuration settings.
 */

// Setup some default path aliases. These alias may vary from projects.
Yii::setPathOfAlias('root', __DIR__ . '/../..');
Yii::setPathOfAlias('common', __DIR__ . '/../../common');
Yii::setPathOfAlias('frontend', __DIR__ . '/..');
Yii::setPathOfAlias('logs', __DIR__ .'/../logs');
Yii::setPathOfAlias('www', __DIR__ . '/../www');
Yii::setPathOfAlias('bootstrap',  __DIR__ . '/../../common/extensions/bootstrap');
Yii::setPathOfAlias('yiiwheels',  __DIR__ . '/../../common/extensions/yiiwheels');


return CMap::mergeArray(
	require(__DIR__ . '/../../common/config/main.php'),
	array(
		'name' => 'YorShop',
		// @see http://www.yiiframework.com/doc/api/1.1/CApplication#basePath-detail
		'basePath' => 'frontend',
		'theme' => 'cycommerce',
		// set parameters
		// preload components required before running applications
		// @see http://www.yiiframework.com/doc/api/1.1/CModule#preload-detail
		'preload' => array('log'),
		// @see http://www.yiiframework.com/doc/api/1.1/CApplication#language-detail
		'language' => 'en',
		'timeZone'=>'Africa/Lagos',
		'aliases' => array(
			'yiiwheels', dirname(__FILE__).'/../common/extensions/yiiwheels'
		),
		// uncomment if a theme is used
		/*'theme' => '',*/
		// setup import paths aliases
		// @see http://www.yiiframework.com/doc/api/1.1/YiiBase#import-detail
		'import' => array(
			// uncomment if behaviors are required
			// you can also import a specific one
			/* 'common.extensions.behaviors.*', */
			// uncomment if validators on common folder are required
			/* 'common.extensions.validators.*', */
			'application.components.*',
			'application.controllers.*',
			'application.models.*',
			'frontend.widgets.*',
			'common.models._base.*',
			'common.models.*',
			'common.extensions.yiiwheels.*',
			'common.extensions.bootstrap.helpers.*',
			'common.modules.user.models.*',
			'common.modules.user.components.*',
			'common.components.payments.*',
		),
		/* uncomment and set if required */
		// @see http://www.yiiframework.com/doc/api/1.1/CModule#setModules-detail
		/* 'modules' => array(), */
		'modules' => array(
			'auth'=> array(
				'class' => 'common.modules.auth.AuthModule',
				'strictMode' => true, // when enabled authorization items cannot be assigned children of the same type.
				'userClass' => 'Group', // the name of the user model class.
				'userIdColumn' => 'id', // the name of the user id column.
				'userNameColumn' => 'name', // the name of the user name column.
				'defaultLayout' => 'views.layouts.main', // the layout used by the module.
				'viewDir' => null, // the path to view files to use with this module.
			),
			'user'=>array(
				'class' => 'common.modules.user.UserModule',
				'tableUsers' => 'users',
				'tableProfiles' => 'profiles',
				'tableProfileFields' => 'profiles_fields',
				# encrypting method (php hash function)
				'hash' => 'md5',

				# send activation email
				'sendActivationMail' => true,

				# allow access for non-activated users
				'loginNotActiv' => false,

				# activate user on registration (only sendActivationMail = false)
				'activeAfterRegister' => false,

				# automatically login from registration
				'autoLogin' => false,

				# registration path
				'registrationUrl' => array('/user/registration'),

				# recovery password path
				'recoveryUrl' => array('/user/recovery'),

				# login form path
				'loginUrl' => array('/user/login'),

				# page after login
				'returnUrl' => array('/user/profile'),

				# page after logout
				'returnLogoutUrl' => array('/user/login'),
				
				#'profileRelations'=>array('branch'=>array(CActiveRecord::BELONGS_TO, 'Branch', 'branch_id'),),
			),
		), 
		'components' => array(
			'errorHandler' => array(
				// @see http://www.yiiframework.com/doc/api/1.1/CErrorHandler#errorAction-detail
				'errorAction'=>'site/error'
			),
			'urlManager' => array(
				'rules' => array(
					'product/<category>/<subcategory>/<product>' => 'product/view',
					'product/<category>/<product>' => 'product/view',
					'category/<category>/<subcategory>' => 'category/all',
					'category/<category>' => 'category/all',
					//'page/<name>' => 'page/view',
					'<controller:\w+>/<id:\d+>' => '<controller>/view',
					'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
					'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
					
				)
			),
			'authManager' => array(
				'class'=>'common.modules.auth.components.CachedDbAuthManager',
				'connectionID'=>'db',
				'cachingDuration'=>0,
				'behaviors' => array(
					'auth' => array(
						'class' => 'common.modules.auth.components.AuthBehavior',
					),
				),
			),
			'user'=>array(
				// enable cookie-based authentication
				'allowAutoLogin'=>true,
				'authTimeout' => 3600,
				'loginUrl'=>array('/user/login'),
				'class' => 'common.modules.auth.components.AuthWebUser',
				'loginRequiredAjaxResponse' => 'STORE_LOGIN_REQUIRED',
				'admins' => array('admin','cyhermes'), // users with full access
			),
			'cache'=>array(
				'class'=>'system.caching.CDbCache',
				'connectionID'=>'db',
			),
			'settings'=>array(
				'class' => 'Settings',
				
				'cacheId' => 'global_website_settings',
				'cacheTime' => 84000,
				'tableName' => 'settings',
				'dbComponentId' => 'db',
				'createTable' => false,
				'dbEngine' => 'InnoDB',
				'cacheComponentId'  => 'cache',
			),
			'bootstrap' => array(
				'class' => 'common.extensions.bootstrap.components.TbApi'
			),
			'yiiwheels' => array(
				'class' => 'common.extensions.yiiwheels.YiiWheels',   
			),
			'log'=>array(
				'class'=>'CLogRouter',
				'routes'=>array(
					array(
						'class'=>'CPSLiveLogRoute',					
						'levels'=>'error, warning',
						'maxFileSize' => '10240',
						'logPath'=> Yii::getPathOfAlias('logs'),
						'logFile'=>'application.log.'.date('Y-m-d'),
					),
					/*array(
						'class'=>'CWebLogRoute',
						'categories'=>'system.db.*',
					),*/
				),
			),
		),
		'params' => array(
			'storeID'      => 1,
			'site_name' => 'http://www.cycommerce.com',
			'site_redirect_url' => 'http://localhost/SITE/cycommerce_demo/frontend/www/payment/view/',
			'noreplyEmail' => 'no-reply@yorshop.com',
			'salesEmail' => 'sales@yorshop.com',
			'sitePhone' => '1-800-234-5678',
			'currency' => '566'
		),
		'params' => (file_exists(__DIR__ . '/main-settings.php') ? require(__DIR__ . '/main-settings.php') : array()),
		
	),
	
	(file_exists(__DIR__ . '/main-env.php') ? require(__DIR__ . '/main-env.php') : array()),
	(file_exists(__DIR__ . '/main-theme.php') ? require(__DIR__ . '/main-theme.php') : array()),
	(file_exists(__DIR__ . '/main-local.php') ? require(__DIR__ . '/main-local.php') : array())
);
