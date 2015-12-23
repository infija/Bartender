<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once dirname( __FILE__ ) . '/manager/DBManager.php';

/**
* PublicController class
*/
class PublicController
{
    private $dbManager;

    public function __construct(DBManager $dbManager) {
        $this->dbManager = $dbManager;

        global $notifications;
        $notifications = array();
    }

    /**
     * Manage _POST requets
     * @return null
     */
    public function manageSubmits(){
        if(!empty($_POST)){
            switch ($_POST['action']) {
                case 'course_reservation':
                    global $notifications;
                    $res = $this->dbManager->applicationManager ->createReservation($_POST['post_id'], $_POST['first_name'], $_POST['last_name'], $_POST['phone'], $_POST['ci']);
                    $this->dbManager->courseManager->updateReservationCounter($_POST['post_id']);
                    if ($res){
                        $notifications['success'] = 'Su reservacion fue realizada exitosamente.';
                    }else{
                        $notifications['error'] = 'Lo sentimos, su reserva no pudo ser registrada. Por favor intente de nuevo.';
                    }
                default:
                    break;
            }
        }
    }

    /**
     * overriting default query on homepage
     * @return null
     */
    public function overrideHomePostsQuery($query){
        global $wp_the_query;
        if( $wp_the_query === $query && $query->is_home() ) {
            $query->set('post_type', 'course');
        }
    }
}
