<?php

class WebUser extends CWebUser
{

    /**
     * @var boolean whether to enable cookie-based login. Defaults to false.
     */
    public $allowAutoLogin=true;
    /**
     * @var string|array the URL for login. If using array, the first element should be
     * the route to the login action, and the rest name-value pairs are GET parameters
     * to construct the login URL (e.g. array('/site/login')). If this property is null,
     * a 403 HTTP exception will be raised instead.
     * @see CController::createUrl
     */
    public $loginUrl=array('/user/login');
	
	public $changePasswordUrl= array('/user/profile/changepassword');
	
	//private $_access=array();

    public function getRole()
    {
        return $this->getState('__role');
    }
    
    public function getId()
    {
        return $this->getState('__id') ? $this->getState('__id') : 0;
    }

//    protected function beforeLogin($id, $states, $fromCookie)
//    {
//        parent::beforeLogin($id, $states, $fromCookie);
//
//        $model = new UserLoginStats();
//        $model->attributes = array(
//            'user_id' => $id,
//            'ip' => ip2long(Yii::app()->request->getUserHostAddress())
//        );
//        $model->save();
//
//        return true;
//    }

    protected function afterLogin($fromCookie)
	{
        parent::afterLogin($fromCookie);
        $this->updateSession();
	}

    public function updateSession() {
		if(isset($this->id) && $this->id > 0){
			$user = Yii::app()->getModule('user')->user($this->id);		
			$this->name = $user->username;
			$userAttributes = CMap::mergeArray(array(
													'email'=>$user->email,
													'username'=>$user->username,
													'create_at'=>$user->create_at,
													'lastvisit_at'=>$user->lastvisit_at,
											   ),$user->profile->getAttributes());
			foreach ($userAttributes as $attrName=>$attrValue) {
				$this->setState($attrName,$attrValue);
			}
		}
		
    }
	/*
	 public function checkAccess($operation,$params=array(),$allowCaching=true)
    {
        if($allowCaching && $params===array() && isset($this->_access[$operation]))
            return $this->_access[$operation];

        $cache = Yii::app()->session['checkAccess'];
        if($allowCaching && !$this->getIsGuest() && isset($cache[$operation]) && time() - $cache[$operation]['t'] < 1800)
        {
            $checkAccess = $cache[$operation]['p'];
        } else {
            $checkAccess = Yii::app()->getAuthManager()->checkAccess($operation,$this->getId(),$params);

            if($allowCaching && !$this->getIsGuest())
            {
                $access = isset($cache) ? $cache : array();
                $access[$operation] = array('p'=>$checkAccess, 't'=>time());
                Yii::app()->session['checkAccess'] = $access;
            }
        }

        return $this->_access[$operation] = $checkAccess;
    }*/

    public function model($id=0) {
        return Yii::app()->getModule('user')->user($id);
    }

    public function user($id=0) {
        return $this->model($id);
    }

    public function getUserByName($username) {
        return Yii::app()->getModule('user')->getUserByName($username);
    }

    public function getAdmins() {
        return Yii::app()->getModule('user')->getAdmins();
    }

    public function isAdmin() {
        return Yii::app()->getModule('user')->isAdmin();
    }
	
	public function redirectChangePassword(){
		if (!Yii::app()->request->getIsAjaxRequest())
            $this->setReturnUrl(Yii::app()->request->getUrl());
 
        if (($url = $this->changePasswordUrl) !== null)
        {
            if (is_array($url))
            {
                $route = isset($url[0]) ? $url[0] : Yii::app()->defaultController;
                $url = Yii::app()->createUrl($route, array_splice($url, 1));
            }
            Yii::app()->request->redirect($url);
        }
        else
            throw new CHttpException(403, Yii::t('yii', 'Password Change Required'));
	}

}