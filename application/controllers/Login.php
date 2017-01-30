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



        private function pageHome()     {
           $this->load->view('home/homepage');


        }


        private function pageSearch()     {
         $this->load->view('home/search.php');

        }
        private function pageMessages()     {
            $this->load->view('home/messages.php');

        }
       private function pageRequests()     {
         $this->load->view('home/requests.php');
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
           $data = array('mem_id' => $this->session->SESS_MEMBER_ID, );
           $this->load->view('home/index',$data);
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
          $this->pageRequests();
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
          $data = $this->getPHPInput();
          $this->SessionModel->changeName($data);
        }
        elseif ($value == 6) {
          $data = $this->input->raw_input_stream;
          $data = json_decode($data);
          $this->SessionModel->changeGender($data);
        }
        elseif ($value == 7) {
          $data = $this->input->raw_input_stream;
          $data = json_decode($data);
          $this->SessionModel->changeBday($data);
        }
        elseif ($value == 8) {
          $data = $this->input->raw_input_stream;
          $data = json_decode($data);
          $this->SessionModel->changeCountry($data);
        }

        else {
          echo "invalid  selection";
        }
      }

      public function dpUpload()    {
               $this->SessionModel->dpUpload();
      }
      public function postImageUpload()    {
               $this->SessionModel->postImageUpload();
      }



      public function sentMessage()    {

        $data = $this->input->raw_input_stream;
        $data = json_decode($data);
        $this->MessageModel->sentMessage($data);


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

        $data = $this->input->raw_input_stream;
        $data = json_decode($data);
        $data->online = ($data->online == "")?0:1;
        $data->photo = ($data->photo == "")?0:1;

        //print_r($data);
        $this->SearchModel->advancedSearch($data);

      }
      public function advancedSearchCount()      {

        $data = $this->input->raw_input_stream;
        $data = json_decode($data);
        $data->online = ($data->online == "")?0:1;
        $data->photo = ($data->photo == "")?0:1;
        $this->SearchModel->advancedSearchCount($data);

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
        else if ($sel == 2)
          $this->load->view('template/dialog/chat_box.php');
      }

      public function getDialogContent($sel)      {
          if ($sel == 0) {
            $this->load->view('template/dialog/content/change_dp.php');
          }
          else if($sel == 1)
            $this->load->view('template/dialog/content/change_name.php');
          else if($sel == 3)
                $this->load->view('template/dialog/content/change_aboutme.php');
          else if($sel == 4)
              $this->load->view('template/dialog/content/change_mypre.php');
          else if($sel == 5)
              $this->load->view('template/dialog/content/change_gender.php');
          else if($sel == 6)
            $this->load->view('template/dialog/content/change_bday.php');
          else if($sel == 9)
            $this->load->view('template/dialog/content/change_country.php');
        }

        public function getMyInfo()        {
          $data = array('mem_id' => $this->session->SESS_MEMBER_ID, );
          echo json_encode($data);
        }

        public function getCountriesList()        {
            $this->load->library('country_iso');
            echo json_encode($this->country_iso->countries);
        }
        public function getChatBox()        {
          $this->load->view('template/chatbox.php');
        }
        public function getElement($value)        {
          if($value == 0)
            $this->load->view('template/friendpanel.php');
          else if($value == 1)
              $this->load->view('template/usercard.php');
          else if($value == 2)
              $this->load->view('template/postcard.php');
          else if($value == 3)
              $this->load->view('template/friend_request_card.php');
          else if($value == 4)
              $this->load->view('template/post_view_card.php');
        }

        public function listEmoji($index)      {
          $this->MessageModel->listEmoji($index);
        }

        public function getUserDetails($value)   {
          $this->SessionModel->getDetails($value);
        }

        public function getMessages()   {
          $data = $this->input->raw_input_stream;
          $data = json_decode($data);
          $this->MessageModel->getMessages($data);
          //echo "string";

        }
        public function countMessages($data)   {
          $this->MessageModel->countMsg($data);
        }

        public function addFriend($value)      {
          $this->SessionModel->addFriend($value);
        }
        public function removeFriend($value)      {
          $this->SessionModel->removeFriend($value);
        }

        public function getFriendshipStatus($value)      {
          $this->SessionModel->getFriendshipStatus($value);
        }

        public function insertPost()   {
          $data = $this->input->raw_input_stream;
          $data = json_decode($data);
          $this->SessionModel->insertPost($data);
        }

        public function getFriendRequestList($value)      {
          $this->SessionModel->getFriendRequestList($value);
        }
        public function getFriendRequestCount()      {
          $this->SessionModel->getFriendRequestCount();
        }
        public function friendRequestActions($value,$id)   {
          $this->SessionModel->friendRequestActions($value,$id);
        }








   }


?>
