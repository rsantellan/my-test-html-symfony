<?php
/**
 */
class mdFirstAccessMysql
{
    public static function retrieveUserAccess($mdUserId)
    {
        try
        {
            $sql = "SELECT access_ip FROM md_first_access WHERE md_user_id = :id LIMIT 1;";

            $db = Doctrine_Manager::getInstance()->getConnection("doctrine")->getDbh();
            $st = $db->prepare($sql);
            $st->bindValue(":id", $mdUserId, PDO::PARAM_INT);
            $st->setFetchMode(Doctrine_Core::FETCH_ASSOC);
            $st->execute();
            $result = $st->fetchObject();
            if($result) return $result->access_ip;
            else return false;
        }
        catch(Exception $e)
        {
            throw new Exception("mdFirstAccessMysql::retrieveUserAccess - " . $e->getMessage(), $e->getCode());
        }
    }
}