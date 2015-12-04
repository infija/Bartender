<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once dirname( __FILE__ ) . '/manager/DBManager.php';
require_once dirname( __FILE__ ) . '/manager/CourseManager.php';
require_once dirname( __FILE__ ) . '/AdminController.php';
require_once dirname( __FILE__ ) . '/PublicController.php';

/**
 * Main Class
 */
class Main
{
    public static $app;
    public $dbManager;
    public $adminController;
    public $publicController;

    public function __construct(){
        $this->dbManager = new DBManager;

        if(is_admin()){
            $this->adminController = new AdminController($this->dbManager);
        }
        $this->publicController = new PublicController($this->dbManager);

        $this->addHooks();
        $this->addShortCodes();
    }

    /**
     * Runs the plugin
     * @return Main
     */
    public function initialize(){
        if ( !isset( self::$app ) ) {
            $className      = __CLASS__;
            self::$app = new $className;
        }

        return self::$app;
    }

    /**
     * Function executes when the plugin has been activated
     * @return null
     */
    public function activate(){
        if ( !isset( $this->dbManager ) ) {
            $this->dbManager = new DBManager;
        }
        // TODO: update if table exists
        $this->dbManager->createContext();
    }

    /**
     * Function executes when the plugin has been deactivated
     * @return null
     */
    public function deactivate(){
        // TODO: what happens when deactivated

        // for development porpuses only, delete tables
        if ( !isset( $this->dbManager ) ) {
            $this->dbManager = new DBManager;
        }
        $this->dbManager->removeContext();
    }

    /**
     * Initialize wp short codes
     */
    private function addShortCodes(){
        add_shortcode( 'hello_world', array(&$this, 'defaultPage'));
        add_shortcode( 'show_posts', array(&$this, 'show_sidebar_posts'));
    }

    /**
     * Add the required Hooks
     */
    private function addHooks(){
        // initialize
        add_action('init', array(&$this->dbManager->courseManager, 'setCoursePostType'));
        add_action('init', array(&$this, 'manageSubmits'));

        add_action('wp_enqueue_scripts', array(&$this, 'enqueueScripts'));
        if(is_admin()){
            // add filters
            add_filter( 'manage_edit-course_columns', array(&$this->adminController, 'registerColumns') );
            // add actions
            add_action( 'admin_enqueue_scripts', array(&$this->adminController, 'enqueueScripts'));
            add_action( 'admin_menu', array(&$this->adminController, 'fillMenu'));
            add_action( 'admin_init', array(&$this->adminController, 'drawCourseExtraFields') );
            add_action( 'save_post', array(&$this->adminController, 'saveCourseExtraFields'), 10, 2 );
            add_action( 'manage_posts_custom_column', array(&$this->adminController, 'manageColumns') );
        }
    }

    /**
     * Add scripts to the FE
     * @return null
     */
    public function enqueueScripts(){
        // wp_enqueue_script('jquery-min',plugins_url("casumo-blog/public/nominate/lib/jquery-2.1.4.min.js"));

        /** styles */
        // wp_enqueue_style('bootstrap-min-css',plugins_url("casumo-blog/public/nominate/css/bootstrap.min.css"));
    }

    /**
     * Manage _POST requests
     * @return [type] [description]
     */
    public function manageSubmits(){
        if(!empty($_POST)){
            if(is_admin()){
                $this->adminController->manageSubmits();
            }
            $this->publicController->manageSubmits();
        }
    }

    /**
     * TODO: move to PublicController
     * Add the required templates Jury List
     * @return string   The HTML template
     */
    public function defaultPage(){
        ob_start();
        $rootpath = dirname(dirname(__FILE__));
        include_once "$rootpath/public/templates/temporal.php";
    }
    
    public function show_sidebar_posts(){
        ob_start();
        $rootpath = dirname(dirname(__FILE__));
        include_once "$rootpath/public/templates/news.php";
    }
}


