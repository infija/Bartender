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
    }

    /**
     * Manage _POST requets
     * @return null
     */
    public function manageSubmits(){
        if(!empty($_POST)){
            switch ($_POST['action']) {
                case 'course_reservation':
                    $res = $this->dbManager->applicationManager->createReservation($_POST['post_id'], $_POST['first_name'], $_POST['last_name'], $_POST['phone'], $_POST['ci']);
                    if ($res){
                        // new application/reservation was created
                    }else{
                        // someting bad has happened
                    }
                    header("Location: " . $_SERVER['HTTP_REFERER'] );
                    break;
                default:
                    break;
            }
        }
    }
}