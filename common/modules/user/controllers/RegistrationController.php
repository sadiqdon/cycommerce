<?php

class RegistrationController extends Controller
{
	public $defaultAction = 'registration';
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}
	/**
	 * Registration user
	 */
	public function actionRegistration() {
        Profile::$regMode = true;
        $model = new RegistrationForm;
        $profile=new Profile;

        // ajax validator
        if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
        {
            echo UActiveForm::validate(array($model,$profile));
            Yii::app()->end();
        }

        if (Yii::app()->user->id) {
            $this->redirect(Yii::app()->controller->module->profileUrl);
        } else {
            if(isset($_POST['RegistrationForm'])) {
                $model->attributes=$_POST['RegistrationForm'];
                $profile->attributes=((isset($_POST['Profile'])?$_POST['Profile']:array()));
                if($model->validate()&&$profile->validate())
                {
                    //$soucePassword = $model->password;
                    //$realp = PasswordHelper::generateStrongPassword();
					//$model->password = $realp;
					$model->activkey=UserModule::encrypting(microtime().$model->password);
					$model->password=PasswordHelper::hashPassword($model->password);
					$model->verifyPassword=$model->password;
                    $model->superuser=0;
					$model->type=1;
                    $model->status=((Yii::app()->controller->module->activeAfterRegister)?User::STATUS_ACTIVE:User::STATUS_NOACTIVE);

                    if ($model->save()) {
                        $profile->user_id=$model->id;
                        $profile->save();
                        if (Yii::app()->controller->module->sendActivationMail) {
                            $activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $model->activkey, "email" => $model->email));
                            $name = $_POST['Profile']['first_name'] . ' ' . $_POST['Profile']['last_name'];
                            UserModule::sendMail($model->email,UserModule::t("You registered from {site_name}",array('{site_name}'=>Yii::app()->name)),UserModule::t("<div style='border: 1px solid #FCC32A;border-radius:5px;box-shadow:1px 5px 5px;background-color:#FFFFEE;'><div style='background-color:#333;border-radius:5px;padding:10px;'><img src='http://yorshop.com/img/main_logo.png' style='float:left'/><h2 style='color: #FFF;width:70%;margin-left:15%;'>Successful  Registration</h2><hr/></div><div style='padding:10px;'><p><strong>Dear {name},</strong></p><p>Thank you for registering at <a href='{site_url}' target='blank'>{site_name}</a>.</p><p>Please activate your account by clicking: <a href='{activation_url}' target='blank'>{activation_url}</a> or copy and paste it in your browser.</p><p><a href='{site_url}' target='blank' ><img src='http://yorshop.com/img/form_submit.png'/></a></p></div><div style='padding:0px 10px 0px;'><p>If you need any assistance or have any inquiry or suggestion, feel free to contact our customer service team at <a href='mailto:info@yorshop.com'>info@yorshop.com</a> or call us at <strong>0700 967 7467</strong> between 8am and 10pm on weekdays and 9am to 6pm on weekends, we would be happy to guide you.</p> <address>Thank You!<br/>Your Yorshop Team</address></div></div>",array('{activation_url}'=>$activation_url,'{name}'=>$name,'{site_name}'=>Yii::app()->name,'{site_url}'=>UtilityHelper::yiiparam('site_name'))));
						}

                        if ((Yii::app()->controller->module->loginNotActiv||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin) {
                                $identity=new UserIdentity($model->username,$soucePassword);
                                $identity->authenticate();
                                Yii::app()->user->login($identity,0);
                                $this->redirect(Yii::app()->controller->module->returnUrl);
                        } else {
                            if (!Yii::app()->controller->module->activeAfterRegister&&!Yii::app()->controller->module->sendActivationMail) {
                                Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
                            } elseif(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false) {
                                Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please {{login}}.",array('{{login}}'=>CHtml::link(UserModule::t('Login'),Yii::app()->controller->module->loginUrl))));
                            } elseif(Yii::app()->controller->module->loginNotActiv) {
                                Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email or login."));
                            } else {
                                Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email."));
                            }
                            $this->refresh();
                        }
                    }
                } else $profile->validate();
            }
			if(isset($this->location))
				$this->render('frontend.views.user.registration',array('model'=>$model,'profile'=>$profile));
			else
				$this->render('/user/registration',array('model'=>$model,'profile'=>$profile));
        }
	}
}