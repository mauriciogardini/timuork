<?php
    require_once('BaseController.php');    

    class TestController extends BaseController {
        public function __construct() { 
            parent::__construct();
            $this->beforeFilter();
            $this->loadModel('Interactions');
        }

        public function test()
        {
            $users = array(1, 2);
            $id = 1;
            $name = "Test";
            $interactionInfo = (object) array("title" => $name, "description" =>
                $name, "projectId" => $id, 
                "users" => $users);
            $this->Interactions->createInteraction($interactionInfo);
        }
    }
