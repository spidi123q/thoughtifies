<?php

   class Login extends CI_Controller {

     function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url','file'));
        $this->load->model('SessionModel');
        $this->load->model('MessageModel');
        $this->load->model('SearchModel');

     }

     /*******private functions**********/

     private function getPHPInput()  {
       $temp = json_decode(file_get_contents("php://input"));
       $array = get_object_vars($temp);
       return $array;
       //return get_object_vars($temp);
     }

        private function pageHome()     {

          $recentVisitors = $this->SessionModel->recentVisitors();
          $newUsers = $this->SessionModel->newUsers();
          $data = array('recentVisitors' => $recentVisitors,
          'newUsers' => $newUsers,
         );
           $this->load->view('home/homepage',$data);


        }

        private function convertToJPEG($data)      {

          $fileType = $data->data('file_type');
          $allowedType = array('image/jpeg', 'image/pjpeg');
          if ( !in_array($fileType,$allowedType)) {
            echo "not jpg";
            $png = array('image/png',  'image/x-png');
            if (in_array($fileType,$png)) {
                echo " png";
                $image = imagecreatefrompng ($data->data('full_path') );
                $newFile = $data->data('file_path').$data->data('raw_name').'.jpg';
                 imagejpeg($image,$newFile,100);
                 echo $data->data('full_path');
                  if (unlink($data->data('full_path'))) {
                    //echo "deleted";
                    return true;;
                  }
                  else {
                    return false;
                  }
            }
          }
        }
        private function pageSearch()     {
         $this->load->view('home/search.php');

        }
        private function pageMessages()     {
            $this->load->view('home/messages.php');

        }
       private function pageInterest()     {
         echo "gdfg";

       }
      private function pageSettings()     {
        $this->load->view('home/settings');

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
           $this->load->view('home/index');
         }
         else {
           //echo "fail";
            redirect('', 'refresh');
            //index_page();

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
        elseif ($value == 5) {
          //$temp = json_decode(file_get_contents("php://input"));
          //print_r($temp);
          //$data = get_object_vars($temp);
          $data = $this->getPHPInput();
          //print_r($data);
          $this->SessionModel->changeName($data);
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

                 $this->convertToJPEG($this->upload);
                 $newFile = $this->upload->data('file_path').$this->upload->data('raw_name').'.jpg';


                       $qry = "UPDATE member SET picture=? WHERE mem_id=?";

                       if ($this->db->query($qry, array($this->upload->data('raw_name'), $this->session->SESS_MEMBER_ID))) {
                         $config['image_library'] = 'gd2';
                         $config['source_image'] = $newFile;
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
        $data = array(
          'id' => $id,
          'count' => $count,
          'page' => $page,

          );
        echo $this->MessageModel->displayMessages($data);


      }

      public function sentMessage()    {

        $data =  $this->input->post() ;
        print_r($data);
        //$this->MessageModel->sentMessage($data);


      }

      public function f($p)      {

          $data = array('count' => 500,
        );
        if ($p != 6)
        $this->MessageModel->temp();
        else
          echo json_encode($data);



      }



      public function countMsg($id)      {
        echo $this->MessageModel->countMsg($id);
      }

      public function advancedSearch()      {
        $pic = ( $this->input->post('photo') != NULL )?1:0;
        $online = ( $this->input->post('online') != NULL )?1:0;
        $data = array(
          'l_age' => $this->input->post('l_age'),
          'h_age' => $this->input->post('h_age'),
          'photo' => $pic,
          'online' => $online,
          'keyword' => $this->input->post('keyword'),
          'country' => $this->input->post('country'),
        );

        $this->SearchModel->advancedSearch($data);

            //echo $this->SearchModel->advancedSearchPagination(3);

      }


      public function listOnlineUsers()      {
        $this->MessageModel->listOnlineUsers();
      }

      public function getMyDetails()      {
          $this->SessionModel->getDetails($this->session->SESS_MEMBER_ID);
      }

      public function getDialog($sel)      {
        if($sel == 1)
          $this->load->view('template/dialog/settings_edit.php');
      }

      public function getDialogContent($sel)      {

          if($sel == 1)
            $this->load->view('template/dialog/content/change_name.php');
          else if($sel == 3)
                $this->load->view('template/dialog/content/change_aboutme.php');
          else if($sel == 4)
              $this->load->view('template/dialog/content/change_mypre.php');
          else if($sel == 6)
            $this->load->view('template/dialog/content/change_bday.php');
        }

        public function getMyInfo()        {
          $data = array('mem_id' => $this->session->SESS_MEMBER_ID, );
          echo json_encode($data);
        }







   }


?>
