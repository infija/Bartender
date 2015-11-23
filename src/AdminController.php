<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once dirname( __FILE__ ) . '/manager/DBManager.php';

/**
* AdminController class
*/
class AdminController
{
    private $dbManager;

    function __construct(DBManager $dbManager) {
        $this->dbManager = $dbManager;
    }

    /**
     * Add new option to Admin menu
     * @return null
     */
    public function fillMenu() {

        add_menu_page('Cursos', 'Cursos', 'manage_options', 'bartender_courses', array(&$this, 'courses'));

        // add_submenu_page(self::$rootSlug, 'Add new course', $campaign->title, 'manage_options', $campaignSlug, array(&$this, 'manageAdminPages'));
    }

    /**
     * Loads Campaign's description page
     * @return null
     */
    public function manageAdminPages() {
        // manage pages
        $option = $_GET[self::OPTION];

        if( in_array($option, self::$options) ){
            $this->$option($_GET[self::CAMPAIGN]);
        } else {
            echo "<div> <h3> Building!, sorry for the inconvenience. </h3></div>";
        }
    }

    /**
     * Add scripts to the Admin section
     * @return null
     */
    public function enqueueScripts(){
        // wp_enqueue_script('jquery-min',plugins_url("casumo-blog/public/nominate/lib/jquery-2.1.4.min.js"));

        /** styles */
        // wp_enqueue_style('jquery-style',plugins_url("casumo-blog/public/nominate/css/jquery-styles.css"));
    }

    /**
     * Draws the list of courses
     * @return null
     */
    public function courses(){
        include(dirname( __FILE__ ) . "/../admin/templates/temporal.php");
    }

    /**************** Manage _POST Requests *****************/

    /**
     * Manage _POST requets
     * @return null
     */
    public function manageSubmits(){
        if(!empty($_POST)){
            switch ($_POST['action']) {
                default:
                    //echo json_encode(['message'=> 'not allowed']);
                    break;
            }
        }
    }
}
