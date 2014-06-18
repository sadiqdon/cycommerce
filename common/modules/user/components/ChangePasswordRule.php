<?php
 
/**
 * ChangePasswordRule class file.
 *
 * @author Matt Skelton
 * @date 27-Jun-2011
 * 
 * This class performs the actual validation and returns a boolean indicating if
 * the user is required to change their password.
 */
class ChangePasswordRule extends CComponent
{
    public $passwordExpiry;
 
    /**
     * Checks if a user is required to change their password.
     * 
     * @param $user the user whose password needs to be validated
     * @return boolean if the user must change their password
     */
    public function changePasswordRequired(User $user)
    {
        return (strtotime($user->password_update_time)<strtotime("-{$this->passwordExpiry} days")) ? true : false;
    }
 
}
?>