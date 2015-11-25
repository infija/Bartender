<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * DBManager Class
 */
class DBManager
{
    public $wpdb;
    public static $prefix = 'cb_';

    public function __construct(){
        global $wpdb;
        $this->wpdb = $wpdb;

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

    }

    /**
     * Drop tables, only for development
     * @return null
     */
    public function removeContext(){

    }
}