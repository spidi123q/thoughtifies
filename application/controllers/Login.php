<?php
   class Login extends CI_Controller {

     function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url','file'));
        $this->load->model('SessionModel');
        $this->load->model('MessageModel');

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
            $data = array('listMessengers' => $this->MessageModel->listMessengers(),
            );
            $this->load->view('home/messages.php',$data);

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
            echo  ($this->SessionModel->deleteDP())?1:0;
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
               $config['encrypt_name']       = TRUE;

               $this->load->library('upload', $config);

               if ( ! $this->upload->do_upload('userfile'))
               {
                       $error = array('error' => $this->upload->display_errors());

                       print_r($error);
               }
               else
               {

                       $qry = "UPDATE member SET picture=? WHERE mem_id=?";

                       if ($this->db->query($qry, array($this->upload->data('file_name'), $this->session->SESS_MEMBER_ID))) {
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

      public function displayMessages($page)    {
        $id = $this->input->post('id');
        $count = $this->input->post('count');
        echo "page no : ".$page;
        $data = array(
          'id' => $id,
          'count' => $count,
          'page' => $page,

      );
        echo $this->MessageModel->displayMessages($data);


      }

      public function sentMessage()    {
        $data = array(
          'receiver' => $this->input->post('receiver'),
          'msg' => $this->input->post('msg'),
        );
        echo $this->MessageModel->sentMessage($data);

      }
      public function f($p)
      {
        echo 'page no : '+$p;
        $content = '';
        $content .= '<div class="completed step">
      <i class="truck icon"></i>
      <div class="content">
        <div class="title">Shipping</div>
        <div class="description">Choose your shipping options</div>
      </div>
    </div>';
    $p +=10;
        echo  $content.'<a class="jscoll" href="msg/f/'.$p.'">
loafd
        </a>';
      }

      public function countMsg($id)      {
        echo $this->MessageModel->countMsg($id);
      }

      public function messagePagination($page)      {
        echo $page;

      }


   }


?>
