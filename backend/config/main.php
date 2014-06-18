<?php
/**
 * main.php
 *
 * This file holds the configuration settings of your backend application.
 */

// Setup some default path aliases. These alias may vary from projects.
Yii::setPathOfAlias('root', __DIR__ . '/../..');
Yii::setPathOfAlias('common', __DIR__ . '/../../common');
Yii::setPathOfAlias('frontendPath', __DIR__ . '/../../frontend');
Yii::setPathOfAlias('backend', __DIR__ . '/..');
Yii::setPathOfAlias('logs', __DIR__ .'/../logs');
Yii::setPathOfAlias('www', __DIR__ . '/../www');
Yii::setPathOfAlias('bootstrap',  __DIR__ . '/../../common/extensions/bootstrap');
Yii::setPathOfAlias('yiiwheels',  __DIR__ . '/../../common/extensions/yiiwheels');


return CMap::mergeArray(
	require(__DIR__ . '/../../common/config/main.php'),
	array(
		'name' => 'YorShop',
		// @see http://www.yiiframework.com/doc/api/1.1/CApplication#basePath-detail
		'basePath' => 'backend',
		
		// preload components required before running applications
		// @see http://www.yiiframework.com/doc/api/1.1/CModule#preload-detail
		'preload' => array('log'),
		// @see http://www.yiiframework.com/doc/api/1.1/CApplication#language-detail
		'language' => 'en',
		// using bootstrap theme ? not needed with extension
		'theme' => 'bootstrap',
		'language'=>'en',
		'timeZone'=>'Africa/Lagos',
		'aliases' => array(
			'yiiwheels', dirname(__FILE__).'/../common/extensions/yiiwheels'
		),
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
			'application.widgets.*',
			'common.components.*',
			'common.extensions.bootstrap.helpers.*',
			'common.extensions.yiiwheels.*',
			'common.extensions.editable.*',
			'common.gii.generators.cyModel.*',
			'common.extensions.giix.components.*',
			'common.models.*',
			'common.modules.user.models.*',
			'common.modules.user.components.*',
		),
		/* uncomment and set if required */
		// @see http://www.yiiframework.com/doc/api/1.1/CModule#setModules-detail
		 'modules' => array(
			'gii' => array(
				'class' => 'system.gii.GiiModule',
				'password' => 'gii',
				'generatorPaths' => array(
					'bootstrap.gii',
					'common.gii.generators',
					'common.extensions.giix.generators',
				)
			),
			'auth'=> array(
				'class' => 'common.modules.auth.AuthModule',
				'strictMode' => true, // when enabled authorization items cannot be assigned children of the same type.
				'userClass' => 'Group', // the name of the user model class.
				'userIdColumn' => 'id', // the name of the user id column.
				'userNameColumn' => 'name', // the name of the user name column.
				'defaultLayout' => 'www.themes.bootstrap.views.layouts.main', // the layout used by the module.
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
				'autoLogin' => true,

				# registration path
				#'registrationUrl' => array('/user/registration'),

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
			'authManager' => array(
				'class'=>'common.modules.auth.components.CachedDbAuthManager',
				'connectionID'=>'db',
				'cachingDuration'=>0,
				'assignmentTable'=>'authassignment',
				'itemTable'=>'authitem',
				'itemChildTable'=>'authitemchild',
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
			/* load bootstrap components */
			'bootstrap' => array(
				'class' => 'common.extensions.bootstrap.components.TbApi'
			),
			'yiiwheels' => array(
				'class' => 'common.extensions.yiiwheels.YiiWheels',   
			),
			'editable' => array(
				'class'     => 'common.extensions.editable.EditableConfig',
				'form'      => 'bootstrap',        //form style: 'bootstrap', 'jqueryui', 'plain' 
				'mode'      => 'inline',            //mode: 'popup' or 'inline'  
				'defaults'  => array(              //default settings for all editable elements
					'emptytext' => 'Click to Edit',
					'format' => 'yyyy-mm-dd', //format in which date is expected from model and submitted to server
					'viewformat' => 'dd/mm/yyyy',
				)
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
			'errorHandler' => array(
				// @see http://www.yiiframework.com/doc/api/1.1/CErrorHandler#errorAction-detail
				'errorAction'=>'site/error'
			),
			'urlManager' => array(
				'rules' => array(
					'<controller:\w+>/<id:\d+>' => '<controller>/view',
					'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
					'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
				)
			),
			'image' => [
				'class' => 'common.extensions.image.CImageComponent',
				'driver' => 'GD',
			],
			'clientScript' => array(
				'class' => 'common.components.NLSClientScript',
				//'excludePattern' => '/\.tpl/i', //js regexp, files with matching paths won't be filtered is set to other than 'null'
				//'includePattern' => '/\.php/', //js regexp, only files with matching paths will be filtered if set to other than 'null'
			 
				'mergeJs' => false, //def:true
				'compressMergedJs' => false, //def:false
			 
				'mergeCss' => false, //def:true
				'compressMergedCss' => false, //def:false
			 
				'mergeJsExcludePattern' => '/edit_area/', //won't merge js files with matching names
			 
				//'mergeIfXhr' => true, //def:false, if true->attempts to merge the js files even if the request was xhr (if all other merging conditions are satisfied)
			 
				//'serverBaseUrl' => 'http://localhost', //can be optionally set here
				'mergeAbove' => 1, //def:1, only "more than this value" files will be merged,
				'curlTimeOut' => 10, //def:10, see curl_setopt() doc
				'curlConnectionTimeOut' => 10, //def:10, see curl_setopt() doc
				//'appVersion'=>1.0
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
						//'categories'=>'system.db.*',
					),*/
				),
			),
		),
		'params'=>array(
			'frontPath' =>  __DIR__ . '/../../frontend',
			'storeID'      => 1,
			'site_name' => 'http://www.cycommerce.com/',
			'site_redirect_url' => 'http://cycommerce.com/payment/view/',
			'noreplyEmail' => 'no-reply@cycommerce.com',
			'salesEmail' => 'sales@cycommerce.com',
			'sitePhone' => '079 0947 1467',
			'currency' => '566',
		),'params' => (file_exists(__DIR__ . '/main-settings.php') ? require(__DIR__ . '/main-settings.php') : array()),
	),
	(file_exists(__DIR__ . '/main-env.php') ? require(__DIR__ . '/main-env.php') : array()),
	(file_exists(__DIR__ . '/main-local.php') ? require(__DIR__ . '/main-local.php') : array())
);
