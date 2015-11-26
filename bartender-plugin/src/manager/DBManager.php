<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once dirname( __FILE__ ) . '/ApplicationManager.php';

/**
 * DBManager Class
 */
class DBManager
{
    public $wpdb;
    public static $prefix = 'bt_';
    public $applicationManager;

    public function __construct(){
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->applicationManager = new ApplicationManager($wpdb, $this);

        // import wp sql functions
        require_once(ABSPATH.'wp-admin/includes/upgrade.php');
    }

    /**
     * gets the DB prefix
     * @return string
     */
    public static function getDBPrefix(){
        global $wpdb;
        return $wpdb->prefix;
    }

    /**
     * Creates tables in the DB
     * @return null
     */
    public function createContext(){
        // TODO: create tables & test data
        $this->applicationManager->createTable();

        $this->applicationManager->createTestData();
    }

    /**
     * Drop tables, only for development
     * @return null
     */
    public function removeContext(){
        $this->applicationManager->removeTable();
    }
}