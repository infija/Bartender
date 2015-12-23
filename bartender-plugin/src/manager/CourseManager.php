<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Holds COURSE data-type
 * CourseManager Class
 */
class CourseManager
{
    // define new custom post type
    const POST_TYPE = 'courses';

    // define Course custom fields
    const COURSE_DURATION = "course_duration";
    const COURSE_DESCRIPTION = "course_description";
    const COURSE_PLACES = "course_places";
    const COURSE_RESERVATION_COUNTER = "reservation_counter";
    const COURSE_RESERVATION_START_DATE = "course_reservation_start_date";
    const COURSE_RESERVATION_END_DATE = "course_reservation_end_date";

    private $wpdb, $dbManager;

    public function __construct($wpdb, $dbManager){
        $this->wpdb = $wpdb;
        $this->dbManager = $dbManager;

        // import wp sql functions
        require_once(ABSPATH.'wp-admin/includes/upgrade.php');
    }


    // getters
    public function getDuration($courseId){
        return esc_html( get_post_meta( $courseId, self::COURSE_DURATION, true ) );
    }

    public function getDescription($courseId){
        return esc_html( get_post_meta( $courseId, self::COURSE_DESCRIPTION, true ) );
    }

    public function getPlaces($courseId){
        return  esc_html( get_post_meta( $courseId, self::COURSE_PLACES, true ) );
    }

    public function getReservationsCount($courseId){
        return esc_html( get_post_meta( $courseId, self::COURSE_RESERVATION_COUNTER, true ) );
    }

    public function getReservationsStartDate($courseId){
        return esc_html( get_post_meta( $courseId, self::COURSE_RESERVATION_START_DATE, true ) );
    }

    public function getReservationsEndDate($courseId){
        return esc_html( get_post_meta( $courseId, self::COURSE_RESERVATION_END_DATE, true ) );
    }

    /**
     * Define Course post-type
     */
    public function setCoursePostType() {
        // create Post-type
        register_post_type( self::POST_TYPE,
            array(
                'labels' => array(
                    'name' => 'Cursos',
                    'singular_name' => 'Curso',
                    'add_new' => 'Agregar nuevo Curso',
                    'add_new_item' => 'Agregar nuevo Curso',
                    'edit' => 'Editar',
                    'edit_item' => 'Editar Curso',
                    'new_item' => 'Nuevo Curso',
                    'view' => 'Ver',
                    'view_item' => 'Ver Curso',
                    'search_items' => 'Buscar Cursos',
                    'not_found' => 'Ningun curso encontrado',
                    'not_found_in_trash' => 'Ningun curso encontrado en la Papelera de reciclage',
                    'parent' => 'Curso Padre'
                ),

                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_nav_menu' => true,
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
            self::POST_TYPE,
            array(
                'labels' => array(
                    'name' => 'Categoria de curso',
                    'add_new_item' => 'Agregar nueva Cateria',
                    'new_item_name' => "Nueva Cateria"
                ),
                'show_ui' => true,
                'show_tagcloud' => false,
                'hierarchical' => false
            )
        );
    }

    /**
     * Create data for testing purposes
     * @return null
     */
    public function createTestData(){
        $postId = wp_insert_post(
                        array(
                            'ping_status'   => get_option('default_ping_status'),
                            'post_author'   => get_current_user_id(),
                            'post_name'   => 'test-course',
                            'post_title'    => 'Test Course',
                            'post_content' => 'Lorem ipsum content',
                            'post_status'   => 'publish',
                            'post_type'   => self::POST_TYPE
                        ));
        return $postId;
    }

    /**
     * Create data for testing purposes
     * @return null
     */
    public function removeTestData(){
        $posts = get_posts(array(
            'name' => 'test-course',
            'posts_per_page' => 1,
            'post_type' => self::POST_TYPE,
            'post_status' => 'publish'
            ));
        // $posts[0];
        wp_delete_post($posts[0]->ID);

    }

    /**
     * Update reservation counter values
     * @param  int|string  $id      courseId
     * @param  boolean $increase    increase | decrease
     * @return null
     */
    public function updateReservationCounter($id){
        $reservationCounter = count($this->dbManager->applicationManager->getApplications($id));
        update_post_meta($id, CourseManager::COURSE_RESERVATION_COUNTER, $reservationCounter);
    }

}