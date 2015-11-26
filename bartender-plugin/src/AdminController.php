<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once dirname( __FILE__ ) . '/manager/DBManager.php';
require_once dirname( __FILE__ ) . '/manager/CourseManager.php';

/**
* AdminController class
*/
class AdminController
{
    private $dbManager, $courseManager, $applicationManager;

    function __construct(DBManager $dbManager) {
        $this->dbManager = $dbManager;
        $this->courseManager = $dbManager->courseManager;
        $this->applicationManager = $dbManager->applicationManager;
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
        add_meta_box( 'course_reservations_meta_box',
            'Reservaciones',
            array(&$this , 'displayCourseReservationsMetaBox' ),
            'course', 'normal', 'high'
        );

        add_meta_box( 'course_meta_box',
            'Detalles de curso',
            array(&$this , 'displayCourseMetaBox' ),
            'course', 'normal', 'high'
        );

    }

    /**
     * @param  $course
     * @return null
     */
    public function displayCourseMetaBox( $course ) {
        // Retrieve the course related information
        $course_duration = esc_html( get_post_meta( $course->ID, CourseManager::COURSE_DURATION, true ) );
        $course_description = esc_html( get_post_meta( $course->ID, CourseManager::COURSE_DESCRIPTION, true ) );
        $course_places = esc_html( get_post_meta( $course->ID, CourseManager::COURSE_PLACES, true ) );
        $course_reservation_start_date = esc_html( get_post_meta( $course->ID, CourseManager::COURSE_RESERVATION_START_DATE, true ) );
        $course_reservation_end_date = esc_html( get_post_meta( $course->ID, CourseManager::COURSE_RESERVATION_END_DATE, true ) );

        ?>
        <table>
            <tr>
                <td style="width: 100%">Duracion de Curso</td>
                <td><input type="text" size="80" name="<?php echo CourseManager::COURSE_DURATION ?>" value="<?php echo $course_duration; ?>" /></td>
            </tr>
            <tr>
                <td style="width: 100%">Descripcion de Curso</td>
                <td><textarea name="<?php echo CourseManager::COURSE_DESCRIPTION ?>" id="<?php echo CourseManager::COURSE_DESCRIPTION ?>" cols="50" rows="1"><?php echo $course_description; ?></textarea></td>
            </tr>
            <tr>
                <td style="width: 100%">Número de Cupos</td>
                <td><input type="text" size="80" name="<?php echo CourseManager::COURSE_PLACES ?>" value="<?php echo $course_places; ?>" /></td>
            </tr>
            <tr>
                <td style="width: 100%">Fecha inicio de reservacion</td>
                <td><input type="text" size="80" name="<?php echo CourseManager::COURSE_RESERVATION_START_DATE ?>" value="<?php echo $course_reservation_start_date; ?>" /></td>
            </tr>
            <tr>
                <td style="width: 100%">Fecha limite de reservacion</td>
                <td><input type="text" size="80" name="<?php echo CourseManager::COURSE_RESERVATION_END_DATE ?>" value="<?php echo $course_reservation_end_date; ?>" /></td>
            </tr>
        </table>
        <?php
    }

    /**
     * @param  $course
     * @return null
     */
    public function displayCourseReservationsMetaBox( $course ) {
        // retrieve Reservation
        $reservations = array(''); // TODO: get reservations by a given $course->ID;

        ?>
        <table style="width:100%;">
            <thead>
                <td>Name</td>
                <td>CI</td>
                <td>Telefono</td>
            </thead>
        <?php
            foreach ($reservations as $reservation) {
                ?>
                <tr>
                    <td>alfredo </td>
                    <td>98128163487123</td>
                    <td>65123871</td>
                </tr>
                <?php

            }
        ?>
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
            if ( isset( $_POST[CourseManager::COURSE_DURATION] ) && $_POST[CourseManager::COURSE_DURATION] != '' ) {
                update_post_meta( $course_id, CourseManager::COURSE_DURATION, $_POST[CourseManager::COURSE_DURATION] );
            }
            if ( isset( $_POST[CourseManager::COURSE_DESCRIPTION] ) && $_POST[CourseManager::COURSE_DESCRIPTION] != '' ) {
                update_post_meta( $course_id, CourseManager::COURSE_DESCRIPTION, $_POST[CourseManager::COURSE_DESCRIPTION] );
            }
            if ( isset( $_POST[CourseManager::COURSE_PLACES] ) && $_POST[CourseManager::COURSE_PLACES] != '' ) {
                update_post_meta( $course_id, CourseManager::COURSE_PLACES, $_POST[CourseManager::COURSE_PLACES] );
            }
            if ( isset( $_POST[CourseManager::COURSE_RESERVATION_START_DATE] ) && $_POST[CourseManager::COURSE_RESERVATION_START_DATE] != '' ) {
                update_post_meta( $course_id, CourseManager::COURSE_RESERVATION_START_DATE, $_POST[CourseManager::COURSE_RESERVATION_START_DATE] );
            }
            if ( isset( $_POST[CourseManager::COURSE_RESERVATION_END_DATE] ) && $_POST[CourseManager::COURSE_RESERVATION_END_DATE] != '' ) {
                update_post_meta( $course_id, CourseManager::COURSE_RESERVATION_END_DATE, $_POST[CourseManager::COURSE_RESERVATION_END_DATE] );
            }
            var_dump($_POST);
        }
    }

    /**
     * Define custom columns
     * @param  array  $columns
     * @return null
     */
    public function registerColumns( $columns ) {
        $columns['course-places'] = 'Places';
        $columns['course-reservation-start-date'] = 'Start Date';
        $columns['course-reservation-end-date'] = 'End Date';
        $columns['course-reservations'] = 'Reservaciones';
        unset( $columns['comments'] );
        return $columns;
    }

    /**
     * Draw values for custom columns
     * @param  string  $column
     * @return null
     */
    public function manageColumns( $column ) {
        if ( 'course-places' == $column ) {
            $course_places = esc_html( get_post_meta( get_the_ID(), CourseManager::COURSE_PLACES, true ) );
            echo $course_places;
        }
        elseif ( 'course-reservation-start-date' == $column ) {
            $course_reservation_start_date = esc_html( get_post_meta( get_the_ID(), CourseManager::COURSE_RESERVATION_START_DATE, true ) );
            echo $course_reservation_start_date;
        }
        elseif ( 'course-reservation-end-date' == $column ) {
            $course_reservation_end_date = esc_html( get_post_meta( get_the_ID(), CourseManager::COURSE_RESERVATION_END_DATE, true ) );
            echo $course_reservation_end_date;
        }
        elseif ( 'course-reservations' == $column ) {
            echo '<a href="google.com">link</a>';
        }
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
