<?php
   class LoginModel extends CI_Model {

      function __construct() {
         parent::__construct();
      }

      private function createAccountFacebook($userNode,$fb,$accessToken)      {
        $loc = $userNode->getLocation()->getId();
        $response = $fb->get("$loc?fields=location", $accessToken);
        $locNode = $response->getGraphObject()->getProperty("location");
        $date  = $userNode->getBirthday();
        $this->load->library('country_iso');
        $cont = array_flip($this->country_iso->countries);
        $country = $cont["{$locNode['country']}"];
  //  print_r($userNode) ;
        $info = array(
        'email' => $userNode->getEmail(),
        'fname' => $userNode->getFirstName(),
        'lname' => $userNode->getLastName(),
        'picture' => $userNode->getPicture()['url'],
        'gender' => ($userNode->getGender() === "male")? 'M':'F',
        'dd' => $date->format('j'),
        'mm' => $date->format('n'),
        'yy' => $date->format('Y'),
        'country' => $country,
        );
        $this->db->trans_start();
        $this->db->set('join_date', 'NOW()', FALSE);
        $this->db->insert('member', $info);
        $query = $this->db->query('SELECT LAST_INSERT_ID() as mem_id');
        $mem_id = $query->row()->mem_id;
        $data = array(
          'id' => $userNode->getId(),
          'mem_id' => $mem_id,
        );
        print_r($data);
        $this->db->insert('facebook_member', $data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE){
          echo "1";
        }else {
          echo "0";
        }
      }

      public function insert($data) {
         echo $data ;
      }

      public function login($value)  {
        $query = $this->db->query("
        SELECT * FROM member WHERE username='{$value['username']}' AND password='{$value['password']}'
        ");

        if($query->num_rows() > 0){

          foreach ($query->result() as $row) {
                $array = array('SESS_USERNAME' => $row->username,
                'SESS_MEMBER_ID' => $row->mem_id,
                'SESS_FIRST_NAME' =>$row->fname,
                'SESS_LAST_NAME' => $row->lname,
                'SESS_USERIMAGES' => base_url().'images/userimages/',
              );


          }

          $this->session->set_userdata($array);
          $query2 = $this->db->query("
          UPDATE member SET last_login=NOW() WHERE mem_id={$this->session->SESS_MEMBER_ID}
          ");
          return true;
        }
        else {
          return false;
        }


      }

      public function createAccount($value)      {
        $hash = md5( rand(0,1000) );
        $this->db->set('join_date', 'NOW()', FALSE);
        $this->db->set('hash', $hash, TRUE);
        $result = $this->db->insert("member", $value);
        if ($result) {
          return true;
        }
        else{
          return false;
        }
      }

      public function p()
      {
        $data = array(
        'blog_title' => 'My Blog Title',
        'blog_heading' => 'My Blog Heading'
        );

        $k = $this->parser->parse('template/visitor_view.php', $data,TRUE);
        return $k;

      }

      public function loginFacebook($id_token)    {
        $fb = new \Facebook\Facebook([
          'app_id' => '1789323091320402',
          'app_secret' => 'b60c05bf4115283ec3e33d5c2d92b8f0',
          'default_graph_version' => 'v2.8',
          //'default_access_token' => '{access-token}', // optional
        ]);
        $accessToken = new Facebook\Authentication\AccessToken($id_token);
        try {
             // Get the \Facebook\GraphNodes\GraphUser object for the current user.
             // If you provided a 'default_access_token', the '{access-token}' is optional.
             $response = $fb->get('/me?fields=id,birthday,email,picture.type(large),gender,location,hometown,first_name,middle_name,last_name', $accessToken);
             $userNode = $response->getGraphUser();
             //print_r($userNode) ;
             $this->db->select('mem_id');
             $this->db->where('id',$userNode->getId());
             $query = $this->db->get('facebook_member');
            if ($query->num_rows() === 0) {
              $this->createAccountFacebook($userNode,$fb,$accessToken);
             }
             else {
               echo "account exitst";
             }
          } catch(\Facebook\Exceptions\FacebookResponseException $e) {
           // When Graph returns an error
           echo 'Graph returned an error: ' . $e->getMessage();
           exit;
          } catch(\Facebook\Exceptions\FacebookSDKException $e) {
           // When validation fails or other local issues
           echo 'Facebook SDK returned an error: ' . $e->getMessage();
           exit;
          }
      }


   }
?>
