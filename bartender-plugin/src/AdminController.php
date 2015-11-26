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


    /**
     * draws extra data for Course post-type
     * @return null
     */
    public function drawCourseExtraFields(){
        add_meta_box( 'course_meta_box',
            'Course Details',
            array(&$this , 'display_course_meta_box' ),
            'course', 'normal', 'high'
        );
    }


    /**
     * @param  $course
     * @return null
     */
    public function display_course_meta_box( $course ) {
        // Retrieve the course related information
        $course_type = esc_html( get_post_meta( $course->ID, 'course_type', true ) );
        $course_target = esc_html( get_post_meta( $course->ID, 'course_target', true ) );
        $course_duration = esc_html( get_post_meta( $course->ID, 'course_duration', true ) );
        $course_description = esc_html( get_post_meta( $course->ID, 'course_description', true ) );
        $course_legislation = esc_html( get_post_meta( $course->ID, 'course_legisltion', true ) );
        
        ?>
        <table>
            <tr>
                <td style="width: 100%">Course Type</td>
                <td><input type="text" size="80" name="course_type" value="<?php echo $course_type; ?>" /></td>
            </tr>
            <tr>
                <td style="width: 100%">Course Target</td>
                <td><input type="text" size="80" name="course_target" value="<?php echo $course_target; ?>" /></td>
            </tr>
            <tr>
                <td style="width: 100%">Course Duration</td>
                <td><input type="text" size="80" name="course_duration" value="<?php echo $course_duration; ?>" /></td>
                
            </tr>
            <tr>
                <td style="width: 100%">Course Description</td>
                <td><textarea name="course_description" id="course_description" cols="50" rows="1"><?php echo $course_description; ?></textarea></td>
            </tr>
            <tr>
                <td style="width: 100%">Course Legislation</td>
                <td><input type="text" size="80" name="course_legislation" value="<?php echo $course_legislation; ?>" /></td>
                
            </tr>
        </table>
        <?php
    }

    /**
     * @param  String $course_id
     * @param  $course PostObject
     * @return null
     */
    public function saveCourseExtraFields($course_id, $course ) {
        // Check post type for our courses
        if ( $course->post_type == 'course' ) {
            // Store data in post meta table if present in post data
             if ( isset( $_POST['course_type'] ) && $_POST['course_type'] != '' ) {
                update_post_meta( $course_id, 'course_type', $_POST['course_type'] );
            }
            if ( isset( $_POST['course_target'] ) && $_POST['course_target'] != '' ) {
                update_post_meta( $course_id, 'course_target', $_POST['course_target'] );
            }
            if ( isset( $_POST['course_duration'] ) && $_POST['course_duration'] != '' ) {
                update_post_meta( $course_id, 'course_duration', $_POST['course_duration'] );
            }
              if ( isset( $_POST['course_description'] ) && $_POST['course_description'] != '' ) {
                update_post_meta( $course_id, 'course_description', $_POST['course_description'] );
            }
              if ( isset( $_POST['course_legislation'] ) && $_POST['course_legislation'] != '' ) {
                update_post_meta( $course_id, 'course_legislation', $_POST['course_legislation'] );
            }
        }
    }

    /**
     * @param  array    $columns
     * @return null
     */ 
    public function registerColumns( $columns ) {
        $columns['course-type'] = 'Type';
        $columns['course-target'] = 'Target';
        $columns['course-duration'] = 'Duration';
        unset( $columns['comments'] );
        return $columns;
    }

    /**
     * @param  string  $column
     * @return null
     */
    public function manageColumns( $column ) {
        if ( 'course-type' == $column ) {
            $course_type = esc_html( get_post_meta( get_the_ID(), 'course_type', true ) );
            
            echo $course_type;
        }
        elseif ( 'course-target' == $column ) {
            $course_target = esc_html( get_post_meta( get_the_ID(), 'course_target', true ) );
            echo $course_target;
        }
         elseif ( 'course-duration' == $column ) {
            $course_duration = esc_html( get_post_meta( get_the_ID(), 'course_duration', true ) );
            echo $course_duration;
        }
    }

    /**
     * Pick a template for post-course
     * @param  string $template_path
     * @return array
     */
    public function include_template_function( $template_path ) {
        if ( get_post_type() == 'course' ) {
            if ( is_single() ) {
                // checks if the file exists in the theme first,
                // otherwise serve the file from the plugin
                if ( $theme_file = locate_template( array ( 'single-course.php' ) ) ) {
                    $template_path = $theme_file;
                } else {
                    $template_path = plugin_dir_path( __FILE__ ) . '/single-course.php';
                }
                
            }
             elseif ( is_archive() ) {
                if ( $theme_file = locate_template( array ( 'archive-course.php' ) ) ) {
                    $template_path = $theme_file;
                } else { $template_path = plugin_dir_path( __FILE__ ) . '/archive-course.php';
     
                }
            }
        
        }
        return $template_path;
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
