<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once dirname( __FILE__ ) . '/DBManager.php';

/**
 * DBManager Class
 */
class ApplicationManager
{
    private $wpdb;
    private $dbManager;
    private static $tableName = 'application';

    const FIRST_NAME = 'first_name';
    const LAST_NAME  = 'last_name';
    const TELEFONO   = 'telefono';
    const CARNET     = 'carnet';
    const POST_ID    = 'post_id';
    const _ID        = 'id';

    public function __construct($wpdb, $dbManager){
        $this->wpdb = $wpdb;
        $this->dbManager = $dbManager;

        // import wp sql functions
        require_once(ABSPATH.'wp-admin/includes/upgrade.php');
    }

    /**
     * gets the full table name
     * @return string
     */
    public static function getTableName(){
        return DBManager::getDBPrefix() . DBManager::$prefix . self::$tableName;
    }

    /**
     * gets the full table name
     * @return string
     */
    public function getApplications($postId){
        return $this->wpdb->get_results("select * from " . self::getTableName() . " WHERE " . self::POST_ID . " = " . $postId);
    }

    /**
     * Creates a Reservation
     * @param  int $postId
     * @param  string $firstName
     * @param  string $lastName
     * @param  int $phoneNumber
     * @param  int $ci
     * @return bool|int
     */
    public function createReservation($postId, $firstName, $lastName, $phoneNumber, $ci){
        $sql = "INSERT INTO `" . self::getTableName() . "` (`" . self::FIRST_NAME . "`,`" . self::LAST_NAME . "`,`" . self::TELEFONO . "`,`" . self::CARNET . "`,`" . self::POST_ID . "`)
                VALUES ('" . $firstName . "', '" . $lastName . "', '" . $phoneNumber . "', '" . $ci . "', '" . $postId . "' );";
        return $this->wpdb->query($sql);
    }

    public function removeReservation($id){
        $sql = "DELETE FROM " . $this->getTableName() . " WHERE id=". $id . ";";
        $this->wpdb->get_results($sql);
    }


    /**
     * Create table
     * @return null
     */
    public function createTable(){
        // check on this sql, when wordpress updates its db post table
        $sql = "CREATE TABLE IF NOT EXISTS " . self::getTableName() . " (
            `" . self::_ID . "` int(11) NOT NULL AUTO_INCREMENT,
            `" . self::FIRST_NAME . "` varchar(255) NOT NULL,
            `" . self::LAST_NAME . "` varchar(255) NOT NULL,
            `" . self::TELEFONO . "` int(11) NOT NULL,
            `" . self::CARNET . "` int(11) NOT NULL,
            `" . self::POST_ID . "` int(11) NOT NULL,
            PRIMARY KEY (`id`),
            CONSTRAINT `FK_" . self::POST_ID . "` FOREIGN KEY (`" . self::POST_ID . "`) REFERENCES `" . DBManager::getDBPrefix() . "posts` (`ID`)
        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8";

        dbDelta($sql);
    }

    /**
     * Drop table
     * @return null
     */
    public function removeTable(){
        // development only
        $sql = "DROP TABLE IF EXISTS " . $this->getTableName();
        $this->wpdb->query($sql);
    }

    /**
     * Create data for testing purposes
     * @return null
     */
    public function createTestData($postId){
        $sql = "INSERT INTO `" . self::getTableName() . "` (`" . self::FIRST_NAME . "`,`" . self::LAST_NAME . "`,`" . self::TELEFONO . "`,`" . self::CARNET . "`,`" . self::POST_ID . "`)
                VALUES ('Juan', 'Perez', '454536636', '1231414', '" . $postId . "' );";

        $sql = "INSERT INTO `" . self::getTableName() . "` (`" . self::FIRST_NAME . "`,`" . self::LAST_NAME . "`,`" . self::TELEFONO . "`,`" . self::CARNET . "`,`" . self::POST_ID . "`)
                VALUES ('Pedro', 'Perez', '334353', '65631414', '" . $postId . "' );";

        $this->wpdb->query($sql);
    }
}