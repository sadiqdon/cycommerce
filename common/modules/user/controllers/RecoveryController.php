<?php

class RecoveryController extends Controller
{
	public $defaultAction = 'recovery';
	
	/**
	 * Recovery password
	 */
	public function actionRecovery () {
		$form = new UserRecoveryForm;
		if (Yii::app()->user->id) {
		    	$this->redirect(Yii::app()->controller->module->returnUrl);
		    } else {
				$email = ((isset($_GET['email']))?$_GET['email']:'');
				$activkey = ((isset($_GET['activkey']))?$_GET['activkey']:'');
				if ($email&&$activkey) {
					$form2 = new UserChangePassword;
		    		$find = User::model()->notsafe()->findByAttributes(array('email'=>$email));
		    		if(isset($find)&&$find->activkey==$activkey) {
			    		if(isset($_POST['UserChangePassword'])) {
							$form2->attributes=$_POST['UserChangePassword'];
							if($form2->validate()) {
								$find->password = PasswordHelper::hashPassword($form2->password);
								$find->activkey = PasswordHelper::hashPassword(microtime().$form2->password);
								$find->password_update_time = date('Y-m-d H:i:s');
								if ($find->status==0) {
									$find->status = 1;
								}
								$find->save();
								$passwordHistory = new PasswordHistory;
								$passwordHistory->profile_id = $find->id;
								$passwordHistory->password = $find->password;
								$passwordHistory->save();
								Yii::app()->user->setFlash('recoveryMessage',UserModule::t("Your password has been changed. Please login with your new password."));
								$this->redirect(Yii::app()->controller->module->loginUrl);
							}
						}
						if(isset($this->location))
							$this->render('frontend.views.recovery.changepassword',array('form'=>$form2));
						else
							$this->render('changepassword',array('form'=>$form2));
		    		} else {
		    			Yii::app()->user->setFlash('recoveryMessage',UserModule::t("Incorrect recovery link."));
						$this->redirect(Yii::app()->controller->module->recoveryUrl);
		    		}
		    	} else {
			    	if(isset($_POST['UserRecoveryForm'])) {
			    		$form->attributes=$_POST['UserRecoveryForm'];
			    		if($form->validate()) {
			    			$user = User::model()->notsafe()->findbyPk($form->user_id);
							$activation_url = 'http://' . $_SERVER['HTTP_HOST'].$this->createUrl(implode(Yii::app()->controller->module->recoveryUrl),array("activkey" => $user->activkey, "email" => $user->email));
							
							$subject = UserModule::t("You have requested password recovery for {site_name}",
			    					array(
			    						'{site_name}'=>Yii::app()->name,
			    					));
			    			$message = UserModule::t("You have requested password recovery for {site_name}. To change your password, click <a href='{$activation_url}'>here</a> or copy and paste this link into your browser: {$activation_url}",
			    					array(
			    						'{site_name}'=>Yii::app()->name,
			    						'{activation_url}'=>$activation_url,
			    					));
							
			    			UserModule::sendMail($user->email,$subject,$message);
			    			//echo $message.'here';
							Yii::app()->user->setFlash('recoveryMessage',UserModule::t("Please check your email, the reset link was sent to your email address."));
			    			$this->refresh();
			    		}
			    	}
					if(isset($this->location))
						$this->render('frontend.views.recovery.recovery',array('form'=>$form));
					else
						$this->render('recovery',array('form'=>$form));
		    	}
		    }
	}

}