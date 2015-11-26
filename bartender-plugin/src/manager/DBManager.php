<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once dirname( __FILE__ ) . '/ApplicationManager.php';
require_once dirname( __FILE__ ) . '/CourseManager.php';

/**
 * DBManager Class
 */
class DBManager
{
    public $wpdb, $applicationManager, $courseManager;
    public static $prefix = 'bt_';

    public function __construct(){
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->applicationManager = new ApplicationManager($wpdb, $this);
        $this->courseManager = new CourseManager($wpdb, $this);

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

        $postId = $this->courseManager->createTestData();
        $this->applicationManager->createTestData($postId);
    }

    /**
     * Drop tables, only for development
     * @return null
     */
    public function removeContext(){
        $this->applicationManager->removeTable();

        $this->courseManager->removeTestData();
    }
}