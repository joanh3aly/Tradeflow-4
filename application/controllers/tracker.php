<?php
class Tracker extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function parse()
    {
        switch ($_SERVER['HTTP_ORIGIN']) {
            case 'http://vegout.cumanncurrachathcliath.com/API_test3.html':
                header('Access-Control-Allow-Origin: * ');
                header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
                header('Access-Control-Max-Age: 1000');
                header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
                break;
        }
        
        if (isset($_POST['id']) && $_POST['id'] != '') {
            $_SESSION['id'] = $_POST['id'];
        }
        echo json_encode($_SESSION['id']);
    }
    
    
}