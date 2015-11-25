<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * DBManager Class
 */
class DBManager
{
    public $wpdb;
    public static $prefix = 'cb_';

    public $campaignManager;
    public $categoryManager;
    public $juryManager;
    public $nomineeManager;

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

    public function setCoursePostType() {
        // create Post-type
        register_post_type( 'course',
            array(
                'labels' => array(
                    'name' => 'Courses',
                    'singular_name' => 'Course',
                    'add_new' => 'Add New',
                    'add_new_item' => 'Add New Course',
                    'edit' => 'Edit',
                    'edit_item' => 'Edit Course',
                    'new_item' => 'New Course',
                    'view' => 'View',
                    'view_item' => 'View Course',
                    'search_items' => 'Search Courses',
                    'not_found' => 'No Courses found',
                    'not_found_in_trash' => 'No Courses found in Trash',
                    'parent' => 'Parent Course'
                ),
     
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'capability_type' => 'post',
                'map_meta_cap' => true,
                'menu_position' => 15,
                'supports' => array( 'title', 'editor', 'comments', 'thumbnail', 'custom-fields' ),
                'taxonomies' => array( 'course-categories' ),
                'has_archive' => true
            )
        );

        register_taxonomy(
            'course-categories',
            'course',
            array(
                'labels' => array(
                    'name' => 'Course Category',
                    'add_new_item' => 'Add New Course Category',
                    'new_item_name' => "New Course Category"
                ),
                'show_ui' => true,
                'show_tagcloud' => false,
                'hierarchical' => true
            )
        );
    }
}