<?php

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Rodrigo Santellan <rsantellan@gmail.com> 
 * @version    0.2
 */
class mdSecurityUser extends sfBasicSecurityUser {

    protected $user = null;

    protected $location = null;

    /**
     * Initializes the mdSecurityUser object. // This has not been tested yet
     *
     * @param sfEventDispatcher $dispatcher The event dispatcher object
     * @param sfStorage $storage The session storage object
     * @param array $options An array of options
     */
    public function initialize(sfEventDispatcher $dispatcher, sfStorage $storage, $options = array()) {
        
        parent::initialize($dispatcher, $storage, $options);
        if( sfConfig::get( 'sf_plugins_user_geoip', false ) )
        {
            $this->location = GeoIpFactory::getFactory(GeoIpFactory::GEO_IP_INFO)->getGeoIpInfo();
        }
        
        if (!$this->isAuthenticated()) {
            // remove user if timeout
            //$this->getAttributeHolder()->removeNamespace('mdSecurityUser');
            //$this->user = null;
        }
    }

    public function getUserCountryCode()
    {
        if( sfConfig::get( 'sf_plugins_user_geoip', false ) )
        {
            return $this->location->getCountry_code();
        }
        else
        {
            throw new Exception("Plugin mdGeolocationPlugin must be installed", 250);
        }
        
    }

    /**
     * Returns the referer uri.
     *
     * @param string $default The default uri to return
     * @return string $referer The referer
     */
    public function getReferer($default) {
        $referer = $this->getAttribute('referer', $default);
        $this->getAttributeHolder()->remove('referer');

        return $referer;
    }

    /**
     * Sets the referer.
     *
     * @param string $referer
     */
    public function setReferer($referer) {
        if (!$this->hasAttribute('referer')) {
            $this->setAttribute('referer', $referer);
        }
    }

    /**
     * Returns whether or not the user has the given credential.
     *
     * @param string $credential The credential name
     * @param boolean $useAnd Whether or not to use an AND condition
     * @return boolean
     */
    public function hasCredential($credential, $useAnd = true) {
        if (empty($credential)) {
            return true;
        }

        if (!$this->getMdPassport()) {
            return false;
        }

        if ($this->getMdPassport()->getIsSuperAdmin()) {
            return true;
        }

        return parent::hasCredential($credential, $useAnd);
    }

    /**
     * Returns whether or not the user is a super admin.
     *
     * @return boolean
     */
    public function isSuperAdmin() {
        return $this->getMdPassport() ? $this->getMdPassport()->isSuperAdmin() : false;
    }

    /**
     * Returns whether or not the user is anonymous.
     *
     * @return boolean
     */
    public function isAnonymous() {
        return !$this->isAuthenticated();
    }

    /**
     * Signs in the user on the application.
     *
     * @param sfGuardUser $user The sfGuardUser id
     * @param boolean $remember Whether or not to remember the user
     * @param Doctrine_Connection $con A Doctrine_Connection object
     */
    public function signIn($user, $remember = false, $con = null) {
        // signin
        $this->setAttribute('user_id', $user->getId(), 'mdSecurityUser');
        $this->setAuthenticated(true);
        $this->clearCredentials();
        if (sfConfig::get('app_plugins_user_groups_permissions', false)) {
            $this->addCredentials($user->getAllPermissionNames(sfContext::getInstance()->getConfiguration()->getApplication()));
        }


        // save last login
        $user->setLastLogin(date('Y-m-d H:i:s'));


        $user->save($con);


        // remember?
        if ($remember) {
            $expiration_age = sfConfig::get('app_md_passport_remember_key_expiration_age', 15 * 24 * 3600);

            // remove old keys
            Doctrine::getTable('mdPassportRememberKey')->createQuery()
                    ->delete()
                    ->where('created_at < ?', date('Y-m-d H:i:s', time() - $expiration_age))
                    ->execute();

            // remove other keys from this user
            Doctrine::getTable('mdPassportRememberKey')->createQuery()
                    ->delete()
                    ->where('md_passport_id = ?', $user->getId())
                    ->execute();

            // generate new keys
            $key = $this->generateRandomKey();

            // save key
            $rk = new mdPassportRememberKey();
            $rk->setRememberKey($key);
            $rk->setMdPassport($user);
            $rk->setIpAddress($_SERVER['REMOTE_ADDR']);
            $rk->save($con);

            // make key as a cookie
            $remember_cookie = sfConfig::get('app_md_passport_remember_cookie_name', 'mdRemember');
            sfContext::getInstance()->getResponse()->setCookie($remember_cookie, $key, time() + $expiration_age);
        }
    }

    /**
     * Returns a random generated key.
     *
     * @param int $len The key length
     * @return string
     */
    protected function generateRandomKey($len = 20) {
        return base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }

    /**
     * Signs out the user.
     *
     */
    public function signOut() {
        if( sfConfig::get( 'sf_plugins_user_status_active', false ) ){
            
            mdUserStatus::statusOff($this->getMdUserId());
        }
        $this->getAttributeHolder()->removeNamespace('mdSecurityUser');
        $this->user = null;
        $this->clearCredentials();
        $this->setAuthenticated(false);
        $expiration_age = sfConfig::get('app_md_passport_remember_key_expiration_age', 15 * 24 * 3600);
        $remember_cookie = sfConfig::get('app_md_passport_remember_cookie_name', 'mdRemember');
        sfContext::getInstance()->getResponse()->setCookie($remember_cookie, '', time() - $expiration_age);

    }

    /**
     * Returns the related mdPassport.
     *
     * @return mdPassport
     */
    public function getMdPassport() {
        $this->user = unserialize($this->getAttribute('user', null, 'mdSecurityUser'));

        if (!$this->user && $id = $this->getAttribute('user_id', null, 'mdSecurityUser')) {
            $this->user = mdPassport::retrieveLoadedMdPassportForSession($id);

            if (sfConfig::get('app_plugins_user_groups_permissions', false)) {
                $this->user->loadGroupsAndPermissions();
            }

            if (!$this->user) {
                // the user does not exist anymore in the database
                $this->signOut();

                throw new sfException('The user does not exist anymore in the database.');
            }

            $this->setAttribute('user', serialize($this->user), 'mdSecurityUser');


        }

        return $this->user;
    }

    public function getGuardUser() {
        return $this->getMdPassport();
    }

    /**
     * Returns the string representation of the object.
     *
     * @return string
     */
    public function __toString() {
        return $this->getMdPassport()->__toString();
    }

    /**
     * Returns the sfGuardUser object's username.
     *
     * @return string
     */
    public function getUsername() {
        return $this->getMdPassport()->getUsername();
    }

    /**
     * Returns the sfGuardUser object's email.
     *
     * @return string
     */
    public function getEmail() {
        return $this->getMdPassport()->retrieveMdUser()->getEmail();
    }

    /**
     * Sets the user's password.
     *
     * @param string $password The password
     * @param Doctrine_Collection $con A Doctrine_Connection object
     */
    public function setPassword($password, $con = null) {
        $this->getMdPassport()->setPassword($password);
        $this->getMdPassport()->save($con);
    }

    /**
     * Returns whether or not the given password is valid.
     *
     * @return boolean
     */
    public function checkPassword($password) {
        return $this->getMdPassport()->checkPassword($password);
    }

    /**
     * Returns whether or not the user belongs to the given group.
     *
     * @param string $name The group name
     * @return boolean
     */
    public function hasGroup($name) {
        if (sfConfig::get('sf_plugins_user_groups_permissions', false)) {
            return $this->getMdPassport() ? $this->getMdPassport()->hasGroup($name) : false;
        }
        return true;
    }

    /**
     * Returns the user's groups.
     *
     * @return array|Doctrine_Collection
     */
    public function getGroups() {
        $appName = sfContext::getInstance()->getConfiguration()->getApplication();
        return $this->getMdPassport() ? $this->getMdPassport()->getApplicationGroups($appName) : array();
    }

    /**
     * Returns the user's group names.
     *
     * @return array
     */
    public function getGroupNames() {
        $appName = sfContext::getInstance()->getConfiguration()->getApplication();
        return $this->getMdPassport() ? $this->getMdPassport()->getGroupNames($appName) : array();
    }

    /**
     * Returns whether or not the user has the given permission.
     *
     * @param string $name The permission name
     * @return string
     */
    public function hasPermission($name) {
        if (sfConfig::get('sf_plugins_user_groups_permissions', false)) {
            return $this->getMdPassport() ? $this->getMdPassport()->hasPermission($name) : false;
        }
        return true;
    }

    public function getAplicationsOfPermission($name) {
        if (sfConfig::get('sf_plugins_user_groups_permissions', false)) {
            $appName = sfContext::getInstance()->getConfiguration()->getApplication();
            return $this->getMdPassport() ? $this->getMdPassport()->getAplicationsOfPermission($name, $appName) : array();
        }
        return array();
    }

    /**
     * Returns the Doctrine_Collection of single sfGuardPermission objects.
     *
     * @return Doctrine_Collection
     */
    public function getPermissions() {
        if (sfConfig::get('sf_plugins_user_groups_permissions', false)) {
            $appName = sfContext::getInstance()->getConfiguration()->getApplication();
            return $this->getMdPassport()->getPermissions($appName);
        }
        return array();
    }

    /**
     * Returns the array of permissions names.
     *
     * @return array
     */
    public function getPermissionNames() {
        if (sfConfig::get('sf_plugins_user_groups_permissions', false)) {
            $appName = sfContext::getInstance()->getConfiguration()->getApplication();
            return $this->getMdPassport() ? $this->getMdPassport()->getAllPermissionNames($appName) : array();
        }
        return array();
    }

    /**
     * Returns the array of all permissions.
     *
     * @return Doctrine_Collection
     */
    public function getAllPermissions() {
        if (sfConfig::get('app_plugins_user_groups_permissions', false)) {
            return $this->getMdPassport() ? $this->getMdPassport()->getAllPermissions($appName) : array();
        } else {
            return array();
        }
    }

    /**
     * Returns the array of all permissions names.
     *
     * @return array
     */
    public function getAllPermissionNames() {
        if (sfConfig::get('sf_plugins_user_groups_permissions', false)) {
            $appName = sfContext::getInstance()->getConfiguration()->getApplication();
            return $this->getMdPassport() ? $this->getMdPassport()->getAllPermissionNames($appName) : array();
        }
        return array();
    }

    /**
     * Returns the related profile object.
     *
     * @return Doctrine_Record
     */
    public function getProfile() {
        return $this->getMdPassport() ? $this->getMdPassport()->getMdUserProfile() : null;
    }

    /**
     * Adds a group from its name to the current user.
     *
     * @param string $name The group name
     * @param Doctrine_Connection $con A Doctrine_Connection object
     */
    public function addGroupByName($name, $con = null) {
        $appName = sfContext::getInstance()->getConfiguration()->getApplication();
        return $this->getMdPassport()->addGroupByName($name, $con, $appName);
    }

    /**
     * Adds a permission from its name to the current user.
     *
     * @param string $name The permission name
     * @param Doctrine_Connection $con A Doctrine_Connection object
     */
    public function addPermissionByName($name, $con = null) {
        $appName = sfContext::getInstance()->getConfiguration()->getApplication();
        return $this->getMdPassport()->addPermissionByName($name, $con, $appName);
    }

    /**
     * Returns true if user is authenticated.
     *
     * @return boolean
     */
    public function isAuthenticated() {


        if ($this->authenticated) {
            return true;
        } else {
            return false;
        }
    }

    public function getMdUserId() {
        return $this->getMdPassport()->getMdUserId();
    }

    public function isActive() {
        if (!$this->isValidated()) {
            return $this->getMdPassport()->isActive();
        }
        return true;
    }

    public function isConfirmed() {
        if (!$this->isValidated()) {
            return $this->getMdPassport()->isOnWindowPeriod();
        }
        return true;
    }

    public function isValidated() {
        if ($this->isAuthenticated()) {
            return $this->getMdPassport()->getAccountActive();
        } else {
            return false;
        }
    }

}
