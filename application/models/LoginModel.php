<?php
   class LoginModel extends CI_Model {
     private $fb;
       function __construct() {
         parent::__construct();
         $this->fb = new Facebook\Facebook([
                   'app_id' => $_SERVER['FB_APP_ID'],
                   'app_secret' => $_SERVER['FB_APP_SECRET'],
                   'default_graph_version' => 'v2.8',
                   ]);
      }

       /**
        * @param $sel
        */
       public function loadIndex($sel)    {
            $fb = $this->fb;
            $helper = $fb->getRedirectLoginHelper();
            $permissions = ['email','public_profile','user_birthday','user_friends','user_hometown','user_location']; // Optional permissions
            $loginUrl = $helper->getLoginUrl(base_url().'data/4', $permissions);
            $img = "<img src='".base_url()."images/fb_button.jpg' class='fb-login-button' id='fb-login-button' alt='fb'/>";
            $u = '<a class="fb_button" href="' . htmlspecialchars($loginUrl) . '">'.$img.'</a>';
            $data = array('fb' => $u,
            );

            if ($sel === 0) {
                if($this->agent->is_mobile() && ($this->agent->browser() == 'Chrome')){
                    $buttonChrome['chromebutton'] =  '';
                }
                else{
                    $buttonChrome['chromebutton'] =  'hide';
                }
              $data['content'] =  $this->parser->parse('login/phone',$buttonChrome,TRUE);
            }
            else if ($sel === 1) {
              $data['content'] =  $this->load->view('login/license','',TRUE);
            }
            else if ($sel === 2) {
              $data['content'] =  $this->load->view('login/privacy','',TRUE);
            }
            else if ($sel === 3) {
              $data['content'] =  $this->load->view('login/credits','',TRUE);
            }
            else if ($sel === 4) {
              $data['content'] =  $this->load->view('login/contact','',TRUE);
            }
           if($this->agent->is_mobile() && ($this->agent->browser() == 'Chrome')){
               $data['chrome_home'] =  $this->load->view('login/chrome_home','',TRUE);
            }
            else{
                $data['chrome_home'] = '';
            }


           if (isset($this->session->fb_acces_token) && isset($this->session->SESS_MEMBER_ID)) {
               $accessToken =  new Facebook\Authentication\AccessToken($this->session->fb_acces_token);
               if (!$accessToken->isExpired()){
                   redirect(base_url()."login/1");
               }

           }else {
               $this->parser->parse('login/index',$data);
           }

      }

      private function createAccountFacebook($userNode,$fb,$accessToken)      {

          $loc =  $userNode->getLocation();

          if ($loc !== null) {

            $loc = $loc->getId();
            $this->load->library('country_iso');
            $cont = array_flip($this->country_iso->countries);
            $response = $fb->get("$loc?fields=location", $accessToken);
            $locNode = $response->getGraphObject()->getProperty("location");
            $country = $cont["{$locNode['country']}"];
          }
          else {
            $country = 'XX';
          }
            $date  = $userNode->getBirthday();
            $tmpfname = tempnam("images/userimages", "fb");
            $img = "$tmpfname.jpg";
            file_put_contents($img, file_get_contents( $userNode->getPicture()['url'] ) );
            $newFileName = basename($img, ".jpg");
            $info = array(
            'email' => $userNode->getEmail(),
            'fname' => $userNode->getFirstName(),
            'lname' => $userNode->getLastName(),
            'picture' => $newFileName,
            'gender' => ($userNode->getGender() === "male")? 'M':'F',
            'dd' => $date->format('j'),
            'mm' => $date->format('n'),
            'yy' => $date->format('Y'),
            'country' => $country,
            );
            //print_r($info);
            $this->db->trans_start();
            $this->db->set('join_date', 'NOW()', FALSE);
            $this->db->insert('member', $info);
            $query = $this->db->query('SELECT LAST_INSERT_ID() as mem_id');
            $mem_id = $query->row()->mem_id;
            $data = array(
              'id' => $userNode->getId(),
              'mem_id' => $mem_id,
            );
            //print_r($data);
            $this->db->insert('facebook_member', $data);
            $this->db->trans_complete();
            if ($this->db->trans_status() === TRUE){
              //echo "1";
              $fb_access_token = (string) $accessToken;
              $this->session->set_userdata('fb_access_token', $fb_access_token);
              $this->startSession($mem_id);

            }else {
              echo "0";
            }




      }
      public function startSession($mem_id)      {
        $this->db->select('*');
        $this->db->where('mem_id',$mem_id);
        $query = $this->db->get('member');
        $row = $query->row();
        if ($query->num_rows() === 0){
            $this->session->sess_destroy();
            redirect( base_url());
        }
        $data = array(
         'SESS_MEMBER_ID' => $row->mem_id,
         'SESS_FIRST_NAME' => $row->fname,
         'SESS_LAST_NAME' => $row->lname,
         'SESS_EMAIL' => $row->email,
         'SESS_USERIMAGE' => $row->picture,
       );
        $this->session->set_userdata($data);
        $data = array(
          'mem_id' => $this->session->SESS_MEMBER_ID,
          'picture' =>  $this->session->SESS_USERIMAGE,
            'chat_url' =>$_SERVER['CHAT_URL'],
         );
         if ( $this->session->has_userdata('fb_acces_token') ) {
             $accessToken = new Facebook\Authentication\AccessToken($this->session->fb_acces_token);
            if (!$accessToken->isExpired()){
                $this->session->set_userdata('fb_acces_token_val',(String)$accessToken->getValue());
                $this->load->view('home/index',$data);
                $this->db->set('last_login',"NOW()",FALSE);
                $this->db->where('mem_id', $this->session->SESS_MEMBER_ID);
                $this->db->update('member');
            }
         }else {
             $this->session->sess_destroy();
           redirect( base_url());
         }

      }

      private function loginFacebook()    {
        $fb = $this->fb;
        $accessToken = new Facebook\Authentication\AccessToken($this->session->fb_acces_token);
        $accessToken = $accessToken->getValue();
        try {
             // Get the \Facebook\GraphNodes\GraphUser object for the current user.
             // If you provided a 'default_access_token', the '{access-token}' is optional.
             $response = $fb->get('/me?fields=id,birthday,email,picture.type(large),gender,location{location},hometown,first_name,middle_name,last_name', $accessToken);
             $userNode = $response->getGraphUser();
             $this->db->select('mem_id');
             $this->db->where('id',$userNode->getId());
             $query = $this->db->get('facebook_member');
             //$response = $fb->get('/me/friends', $accessToken);
            // $graphEdge = $response->getGraphEdge();

            if ($query->num_rows() === 0) {
              $this->createAccountFacebook($userNode,$fb,$accessToken);
             }
             else {
               //echo "account exitst";
               $result = $query->row();
               $this->startSession($result->mem_id);

             }
          } catch(\Facebook\Exceptions\FacebookResponseException $e) {
           // When Graph returns an error
           echo 'Graph returned an error: ' . $e->getMessage();
            $this->session->sess_destroy();
           redirect(base_url());
           exit;
          } catch(\Facebook\Exceptions\FacebookSDKException $e) {
           // When validation fails or other local issues
           echo 'Facebook SDK returned an error: ' . $e->getMessage();
            $this->session->sess_destroy();
            redirect(base_url());
           exit;
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
                'SESS_USERIMAGE' => $row->picture,
                    'SESS_EMAIL' => $row->email,
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



      public function initFacebook()      {

        $id_token = $this->session->fb_acces_token;      /** @var Facebook\Authentication\AccessToken $id_token */

          if ( isset($id_token) ) {
              if (!$id_token->isExpired()){
                  $this->loginFacebook();
              }
          }
          else {
                  $fb = $this->fb;

                $helper = $fb->getRedirectLoginHelper();
                $this->session->set_userdata('FBRLH_state', $this->input->get('state'));

                try {
                  $accessToken = $helper->getAccessToken();
                } catch(Facebook\Exceptions\FacebookResponseException $e) {
                  // When Graph returns an error
                  echo 'Graph returned an error: ' . $e->getMessage();
                    $this->session->sess_destroy();
                  redirect(base_url());
                  exit;
                } catch(Facebook\Exceptions\FacebookSDKException $e) {
                  // When validation fails or other local issues
                  echo 'Facebook SDK returned an error: ' . $e->getMessage();
                    $this->session->sess_destroy();
                  redirect(base_url());
                  exit;
                }

                if (! isset($accessToken)) {
                  if ($helper->getError()) {
                    header('HTTP/1.0 401 Unauthorized');
                    echo "Error: " . $helper->getError() . "\n";
                    echo "Error Code: " . $helper->getErrorCode() . "\n";
                    echo "Error Reason: " . $helper->getErrorReason() . "\n";
                    echo "Error Description: " . $helper->getErrorDescription() . "\n";
                  } else {
                    header('HTTP/1.0 400 Bad Request');
                    echo 'Bad request';
                  }
                  exit;
                }

                // Logged in
              //  echo '<h3>Access Token</h3>';
              //var_dump($accessToken->getValue());

                // The OAuth 2.0 client handler helps us manage access tokens
                $oAuth2Client = $fb->getOAuth2Client();

                // Get the access token metadata from /debug_token
                $tokenMetadata = $oAuth2Client->debugToken($accessToken);
                //echo '<h3>Metadata</h3>';
              //  var_dump($tokenMetadata);

                // Validation (these will throw FacebookSDKException's when they fail)
                $tokenMetadata->validateAppId($_SERVER['FB_APP_ID']); // Replace {app-id} with your app id
                // If you know the user ID this access token belongs to, you can validate it here
                //$tokenMetadata->validateUserId('123');
                $tokenMetadata->validateExpiration();

                if (! $accessToken->isLongLived()) {
                  // Exchanges a short-lived access token for a long-lived one
                  try {
                    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
                  } catch (Facebook\Exceptions\FacebookSDKException $e) {
                    echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
                    exit;
                  }

                  echo '<h3>Long-lived</h3>';
                  var_dump($accessToken->getValue());
                }
              $_SESSION['fb_acces_token'] = $accessToken;
                $this->loginFacebook();

                // User is logged in with a long-lived access token.
                // You can redirect them to a members-only page.
                //header('Location: https://example.com/members.php');
                }

      }


   }
?>
