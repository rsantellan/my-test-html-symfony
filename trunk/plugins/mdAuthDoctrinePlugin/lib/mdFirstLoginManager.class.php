<?php
/**
 * Description of mdFirstLoginManager
 *
 * @author chugas
 */
class mdFirstLoginManager
{

    private static $instance = NULL;

    private function  __construct() {
    }

    public static function getInstance()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new mdFirstLoginManager();
        }
        return self::$instance;
    }

    public function init()
    {
        if(sfContext::getInstance()->getUser()->isAuthenticated())
        {
            $firstLogin = mdFirstAccessMysql::retrieveUserAccess(sfContext::getInstance()->getUser()->getMdUserId());
            if($firstLogin)
            {
                return true;
            }
            else
            {
                sfContext::getInstance()->getConfiguration()->loadHelpers('Url');

                $mdFirstAccess = new mdFirstAccess();
                $mdFirstAccess->setMdUserId(sfContext::getInstance()->getUser()->getMdUserId());
                $mdFirstAccess->setAccessIp(gethostbyname(gethostname()));
                $mdFirstAccess->save();

                sfContext::getInstance()->getController()->redirect(url_for("@firstLogin"));

                return true;
            }
        }

        return true;
    }

}
?>
