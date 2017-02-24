<?php

   class Login extends CI_Controller {

     function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url','file'));
        $this->load->model('SessionModel');
        $this->load->model('MessageModel');
        $this->load->model('SearchModel');
        $this->load->model('LoginModel');

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
      private function pageTBS()     {
        $this->load->view('home/tbs');
      }


      public function index() {
                $fb = new Facebook\Facebook([
        'app_id' => '1789323091320402', // Replace {app-id} with your app id
        'app_secret' => 'b60c05bf4115283ec3e33d5c2d92b8f0',
        'default_graph_version' => 'v2.8',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl('http://localhost/code/data/5', $permissions);

        $u = '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
        $data = array('fb' => $u, );
        $this->load->view('login/index',$data);

      }
      public function t()
      {
              //  echo "string";
        $this->LoginModel->t();
      }

      public function loginUser()      {

        $data = array(
           'username' => $this->input->post('username'),
           'password' => $this->input->post('password')
        );

         $v = $this->LoginModel->login($data);
         if ($v) {
           $data = array(
             'mem_id' => $this->session->SESS_MEMBER_ID,
             'picture' => $this->session->SESS_USERIMAGE,
            );
           $this->load->view('home/index',$data);
         }
         else {
           //echo "fail";
            redirect('', 'refresh');
            //index_page();

         }

      }

      public function loginFacebook() {
        $id_token =  $this->input->post('idtoken');
        $this->LoginModel->loginFacebook($id_token);

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
        elseif ($value == 5) {
          $this->pageTBS();
        }
        else {
          echo "invalid page selection";
        }





      }

      public function changeSettings($value)      {

        $data = $this->input->raw_input_stream;
        $data = json_decode($data);

        if ($value == 1) {
          $this->SessionModel->changeTag($data);
        }
        elseif ($value == 2) {

          $this->SessionModel->changeAboutMe($data);
        }
        elseif ($value == 3) {
          $this->SessionModel->changeAboutPartner($data);
        }
        elseif ($value == 4) {
            echo  ($this->SessionModel->deleteDP())?1:0;
        }
        elseif ($value == 5) {
          $this->SessionModel->changeName($data);
        }
        elseif ($value == 6) {
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
          $data = array('count' => 100,
        );
        if ($p != 6)
        $this->MessageModel->temp();
        else
          echo json_encode($data);

      }
      public function getMsgUsers($offset) {
        $this->MessageModel->listMessengers($offset);
      }

      public function getMsgUsersCount() {
        $this->MessageModel->listMessengersCount();
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
          $this->load->view('template/dialog/settings_edit');
        else if ($sel == 2)
          $this->load->view('template/dialog/chat_box');
        else if ($sel == 3)
          $this->load->view('template/dialog/block');
      }

      public function getDialogContent($sel)      {
          if ($sel == 0)
            $this->load->view('template/dialog/content/change_dp.php');
          else if($sel == 1)
            $this->load->view('template/dialog/content/change_name.php');
          else if($sel == 2)
            $this->load->view('template/dialog/content/change_tag.php');
          else if($sel == 3)
            $this->load->view('template/dialog/content/change_aboutme.php');
          else if($sel == 4)
            $this->load->view('template/dialog/content/change_mypre.php');
          else if($sel == 5)
            $this->load->view('template/dialog/content/change_gender.php');
          else if($sel == 6)
            $this->load->view('template/dialog/content/change_bday.php');
          else if($sel == 7)
            $this->load->view('template/dialog/content/change_mail.php');
          else if($sel == 8)
            $this->load->view('template/dialog/content/change_phone.php');
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
          if($value == 0){
            $this->load->view('template/friendpanel');
          }
          else if($value == 1)
              $this->load->view('template/usercard');
          else if($value == 2)
              $this->load->view('template/postcard');
          else if($value == 3)
              $this->load->view('template/friend_request_card');
          else if($value == 4)
              $this->load->view('template/post_view_card');
          else if($value == 5)
              $this->load->view('template/rating-stars-directive');
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
        public function blockUser($value)      {
          $this->SessionModel->blockUser($value);
        }
        public function listBlockedUsers()        {
          $this->SessionModel->listBlockedUsers();
        }
        public function unBlock($data)        {
          $this->SessionModel->unBlock($data);
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
        public function getPosts($value,$id='')      {
            $this->SessionModel->getPosts($value,$id);
        }
        public function getPostsCount($id = '')      {
            $this->SessionModel->getPostsCount($id);
        }
        public function onRating($id,$val)      {
          $data = array(
            $this->session->SESS_MEMBER_ID,
            $id,$val
          );
          $this->SessionModel->onRating($data);
        }
        public function getMyRating($value)      {
          $this->SessionModel->getMyRating($value);
        }

        public function dpFetch($file,$size)  {
          $this->SessionModel->dpFetch($file,$size);
        }
        public function searchToolBar($type,$data = '')   {
          $result = array(
            'type' => $type
          );
          if ($type === "0") {
            $result['data'] = $this->SearchModel->searchHashtag($data);
            echo json_encode($result);
          }
          else if($type === "1") {
            $data = $this->input->raw_input_stream;
            $data = json_decode($data);
            $result['data'] = $this->SearchModel->searchByEmail($data->email);
            echo json_encode($result);
          }
          else {
            $result['data'] = $this->SearchModel->searchDictionary($data);
            echo json_encode($result);
          }
        }

        public function searchPostByHashtag($data,$offset)        {
          $this->SearchModel->searchPostByHashtag($data,$offset);
        }
        public function searchPostByHashtagCount($data)        {
          $this->SearchModel->searchPostByHashtagCount($data);
        }





   }


?>
