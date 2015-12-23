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
        // TODO: to delete - test data
        $notifications['success'] = 'Success!!!!!';
        $notifications['error'] = 'Test example error message';
    }

    /**
     * Manage _POST requets
     * @return null
     */
    public function manageSubmits(){
        if(!empty($_POST)){
            switch ($_POST['action']) {
                case 'course_reservation':
                    $res = $this->dbManager->applicationManager ->createReservation($_POST['post_id'], $_POST['first_name'], $_POST['last_name'], $_POST['phone'], $_POST['ci']);
                    $this->dbManager->courseManager->updateReservationCounter($_POST['post_id']);
                    if ($res){
                        $notifications['success'] = 'errrrrr';
                        // TODO: implement notifications/ success
                        // new application/reservation was created
                    }else{
                        // TODO: implement notifications/ error
                        echo 'someting bad has happened';
                        //exit;
                    }
                    header("Location: " . $_SERVER['HTTP_REFERER'] );
                    exit;
                default:
                    break;
            }
        }
    }
}