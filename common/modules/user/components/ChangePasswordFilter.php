<?php
 
/**
 * ChangePasswordFilter class file.
 *
 * @author Matt Skelton
 * @date 27-Jun-2011
 * 
 * Determines if a user needs to change their password. 
 * A user must change their password if:
 *      User->daysSincePasswordChange() > ChangePasswordRule->passwordExpiry
 */
class ChangePasswordFilter extends CFilter
{
    private $rule;
 
    /**
     * Runs a check to see if the user is required to change the password. This 
     * method is called before controller actions are run.
     * @param CFilterChain $filterChain the filter chain that the filter is on.
     * @return boolean whether the filtering process should continue and the action
     * should be executed.
     */
    public function preFilter($filterChain)
    {
        $allowed = true;		
		if(!Yii::app()->user->isGuest){
			if ($this->rule->changePasswordRequired(Yii::app()->user->user(Yii::app()->user->id)))
			{
				$allowed = false;	 
				Yii::app()->user->setFlash('notice', 'Your password has expired, you must change your password before you can proceed.');
				Yii::app()->user->redirectChangePassword();
			}
		}
        return $allowed;
    }
 
    /**
     * Builds the rule for the filter.
     * @param array $rules the list of rules as set in the controller
     */
    public function setRules($rule)
    {
        $passwordRule = new ChangePasswordRule();
        $passwordRule->passwordExpiry = $rule['days'];
 
        $this->rule = $passwordRule;
    }
}
?>