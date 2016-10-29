<?php
   class Home extends CI_Controller {

     function __construct() {
        parent::__construct();

     }


      public function index() {
         echo "Hello World!";
         $this->load->view('m');

      }

      public function kk()
      {
        echo "dgdf";
      }
   }
?>
