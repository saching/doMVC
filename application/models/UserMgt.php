<?php

class UserMgt extends Model {

    protected $user = null;
    protected $creadentials = null;
    protected $isAuntenticated = 0;
    protected $lastError = null;

    public function signIn($username=null, $password=null, $remember=0) {
        $sql = "SELECT * FROM users WHERE username='" . $username . "' || email='" . $username . "'";
        $user = $this->query($sql, 1);
        
        if (count($user) > 0) {
            if (md5($password) == $user['User']['password']){

                $this->user = $user;
                $this->creadentials = null;
                $this->isAuntenticated = 1;

                Core::setAttr("user_id", $user['User']['id']);
                Core::setAttr("User", $this);
                return true;
            }else{
                $this->lastError = "Invalid Password";
                return false;
            }
        }else {
            $this->lastError = "User not found";
            return false;
        }
    }

    public function getError(){
        return $this->lastError;
    }

    public function signOut($referer = null) {
        $this->user = null;
        $this->creadentials = null;
        $this->isAuntenticated = 0;
        $this->lastError = null;

        Core::clearAttr("User");
        Core::clearAttr("user_id");
    }

    public function getCredentials(){
        if($this->isAnonymous())
            return null;

        if($this->creadentials == null || count($this->creadentials) < 1){
            $sql = "SELECT DISTINCT(r.name) FROM roles r, user_roles ur WHERE r.id = ur.role_id AND ur.user_id = ".Core::getAttr("user_id");
            $creadentials = $this->query($sql);
            
            foreach($creadentials as $cred){
                $this->creadentials[] = $cred['Role']['name'];
            }

        }

        return $this->creadentials;

    }

    public function hasCredential($credential) {
        if(in_array($credential, $this->creadentials))
            return true;

        return false;
    }

    public function isSuperAdmin() {
        $_user = $this->getUser();
        if($_user != null && $_user['is_super'])
            return true;

        return false;
    }

    public function isAnonymous() {
        if(!$this->isAuthenticated())
            return true;
        
        return false;
    }

    public function getUser() {
        if($this->isAuthenticated())
            return $this->user['User'];

        return null;
    }

    public function getUsername() {
        $_user = $this->getUser();
        if($_user != null)
            return $_user['username'];

        return null;
    }

    public function getEmail() {
        $_user = $this->getUser();
        if($_user != null)
            return $_user['email'];

        return null;
    }

    public function setPassword($password) {
        if($this->isAuthenticated()){
            $sql = "UPDATE users SET PASSWORD = '".md5($password)."'";
            $this->query($sql);
            
            return true;
        }
        return false;
    }

    public function getProfile() {
        if($this->isAnonymous())
            return false;

        $sql = 'SELECT * FROM user_profiles WHERE user_id = ' . Core::getAttr("user_id");
        return $this->query($sql);
    }

    public function isAuthenticated() {
        return $this->isAuntenticated;
    }

}
