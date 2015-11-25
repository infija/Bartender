<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Holds COURSE data-type
 * CourseManager Class
 */
class CourseManager
{

    // define Course custom fields
    const COURSE_DURATION = "course_duration";
    const COURSE_DESCRIPTION = "course_description";
    const COURSE_PLACES = "course_places";
    const COURSE_RESERVATION_START_DATE = "course_reservation_start_date";
    const COURSE_RESERVATION_END_DATE = "course_reservation_end_date";

    /**
     * Define Course post-type
     */
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


}