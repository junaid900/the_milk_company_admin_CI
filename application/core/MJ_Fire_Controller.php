<?php
// require 'firebase';
require __DIR__.'/fire_config/vendor/autoload.php';
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
class MJ_Fire_Controller extends CI_Controller{
    public $database;
    public function __construct(){
        // echo phpinfo();
 
        parent::__construct();
         error_reporting(1);
         $this->load->library('session');
          $factory = (new Factory)
              ->withServiceAccount(__DIR__.'/themilkapps-firebase-adminsdk-chqc1-9a357d4739.json')
            ->withDatabaseUri('https://themilkapps-default-rtdb.firebaseio.com');
        $this->database = $factory->createDatabase();
        
        // $newPost = $this->database
        // ->getReference('data')
        // ->push([
        //     'title' => 'Post title',
        //     'body' => 'This should probably be longer.'
        // ]);
        // print_r($value);
    }
    
    
    
}