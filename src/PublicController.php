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
                default:
                    //echo json_encode(['message'=> 'not allowed']);
                    break;
            }
        }
    }
}