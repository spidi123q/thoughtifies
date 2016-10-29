<?php
   class Login extends CI_Controller {

     function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('SessionModel');

     }

     /*******private functions**********/
        private function pageHome()     {

          $recentVisitors = $this->SessionModel->recentVisitors();
          $newUsers = $this->SessionModel->newUsers();
          $data = array('recentVisitors' => $recentVisitors,
          'newUsers' => $newUsers,
         );
           $this->load->view('home/homepage',$data);


        }
        private function pageSearch()     {
         echo "gdfg";

        }
        private function pageMessages()     {
        echo "gdfg";

        }
       private function pageInterest()     {
         echo "gdfg";

       }
      private function pageSettings()     {
        $data =  $this->SessionModel->settings();
        $this->load->view('home/settings',$data);

      }


      public function index() {

         $this->load->view('login/index');

      }

      public function loginUser()      {
        $this->load->model('LoginModel');

        $data = array(
           'username' => $this->input->post('username'),
           'password' => $this->input->post('password')
        );

         $v = $this->LoginModel->login($data);
         if ($v) {
           //echo "gdf";
           $this->load->view('home/header');
           $this->load->view('home/index');
         }
         else {
           echo "fail";
         }

      }

      public function createAccount()   {


        $this->load->model('LoginModel');

        $data = array(
           'email' => $this->input->post('email'),
           'fname' => $this->input->post('fname'),
           'lname' => $this->input->post('lname'),
           'gender' => $this->input->post('gender'),
           'country' => $this->input->post('country'),
           'contact' => $this->input->post('contact'),
           'username' => $this->input->post('username'),
           'password' => $this->input->post('password'),
           'dd' => $this->input->post('dd'),
           'mm' => $this->input->post('mm'),
           'yy' => $this->input->post('yy'),
        );
        $v = $this->LoginModel->createAccount($data);
        if ($v) {

          $this->load->library('email');
              $config['protocol']    = 'smtp';
              $config['smtp_host']    = 'ssl://smtp.gmail.com';
              $config['smtp_port']    = '465';
              $config['smtp_timeout'] = '7';
              $config['smtp_user']    = 'ubuntu123q@gmail.com';
              $config['smtp_pass']    = 'fuck123q';
              $config['charset']    = 'utf-8';
              $config['newline']    = "\r\n";
              $config['mailtype'] = 'text'; // or html
              $config['validation'] = TRUE; // bool whether to validate email or not

          $this->email->initialize($config);
          $this->email->from('ubuntu123q@gmail.com', 'Your Name');
          $this->email->to($data['email']);
          $this->email->subject('Email Test');
          $this->email->message('Testing the email class.');

          $this->email->send();
        }
        else {
          echo "fail";
        }

      }

      public function loadHome()      {
        $this->load->view('home/index');
      }

      public function pageSelection($value)      {

        if($value == 0){
          $this->pageHome();
        }
        elseif ($value == 1) {
          $this->pageSearch();
        }
        elseif ($value == 2) {
          $this->pageMessages();
        }
        elseif ($value == 3) {
          $this->pageInterest();
        }
        elseif ($value == 4) {
          $this->pageSettings();
        }
        else {
          echo "invalid page selection";
        }





      }

      public function changeSettings($value)      {


        if ($value == 1) {

          $data = $this->input->post('data');
          $this->SessionModel->changeTag($data);
        }
        elseif ($value == 2) {
          $data = $this->input->post('data');
          $this->SessionModel->changeAboutMe($data);
        }
        elseif ($value == 3) {
          $data = $this->input->post('data');
          $this->SessionModel->changeAboutPartner($data);
        }
        elseif ($value == 4) {
          $this->pageSettings();
        }
        else {
          echo "invalid  selection";
        }
      }

      public function doUpload()    {
                $config['upload_path']          = 'images/userimages';
               $config['allowed_types']        = 'gif|jpg|png';
               $config['max_size']             = 2000;
               $config['max_width']            = 3000;
               $config['max_height']           = 3000;
               $config['file_name']       =  $this->session->SESS_MEMBER_ID;
               $config['overwrite']       = TRUE;

               $this->load->library('upload', $config);

               if ( ! $this->upload->do_upload('userfile'))
               {
                       $error = array('error' => $this->upload->display_errors());

                       print_r($error);
               }
               else
               {

                       $qry = "UPDATE member SET profileExt=? WHERE mem_id=?";

                       if ($this->db->query($qry, array($this->upload->data('image_type'), $this->session->SESS_MEMBER_ID))) {
                         $config['image_library'] = 'gd2';
                         $config['source_image'] = $this->upload->data('full_path');
                         $config['create_thumb'] = TRUE;
                         $config['maintain_ratio'] = TRUE;
                         $config['width']         = 200;
                         $config['height']       = 200;


                         $this->load->library('image_lib', $config);
                         $this->image_lib->resize();
                         echo "1";
                       }


               }
      }

   }


?>
