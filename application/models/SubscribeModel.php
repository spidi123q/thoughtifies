<?php

   class SubscribeModel extends CI_Model {

      private $request,$client,$data,$webPushAuth,$webPush,$endpoints;
      function __construct() {
         parent::__construct();
         $this->request = array();
          $this->client = new Aws\Ses\SesClient([
              'version'=> 'latest',
              'region' => 'us-west-2',
          ]);
          $this->request['Source'] = "Thoughtifies <noreply@thoughtifies.com>";
          $this->webPushAuth = array(
              'VAPID' => array(
                  'subject' => 'https://thoughtifies.com', // can be a mailto: or your website address
                  'publicKey' => 'BAQZq2fU0WXMO8algZPK3X_I0gQalpPgiZtDNQkRZt8KMixVo0QNFGebvXvpLPm7V2foc3ITykg4WVc8X-pUuCA', // (recommended) uncompressed public key P-256 encoded in Base64-URL
                  'privateKey' => 'rMOq3wWACtLoS5d8n--5WQ0wVNfJUUUdhtKr22kfOoA', // (recommended) in fact the secret multiplier of the private key encoded in Base64-URL
              ),
          );
          $this->webPush = new \Minishlink\WebPush\WebPush($this->webPushAuth);
          $this->endpoints = array();
      }

      private function setDestination(){
         $this->request['Destination']['ToAddresses'] = array($this->data->email);
         $this->db->select('endpoint,public_key,auth_token');
         $this->db->where('mem_id',$this->data->mem_id);
         $query = $this->db->get('web_push');
         if($query->num_rows() > 0){
             $this->endpoints = $query->result();
         }
      }

      private function setType($type){

         if ($type === 0){
             $this->request['Message']['Subject']['Data'] = $this->session->SESS_FIRST_NAME." ".$this->session->SESS_LAST_NAME.' has send you friend request';
             $template = $this->parser->parse('template/email/friend_request.html',array(
                 'mem_id' => $this->session->SESS_MEMBER_ID,
                 'fname' => $this->session->SESS_FIRST_NAME,
                 'lname' => $this->session->SESS_LAST_NAME,
                 'base_url' =>base_url()
             ), TRUE);
             $this->setBody($template);
         }

         else if ($type === 1){
             $this->request['Message']['Subject']['Data'] = 'New message from '.$this->session->SESS_FIRST_NAME." ".$this->session->SESS_LAST_NAME;
             $template = $this->parser->parse('template/email/new_message.html',array(
                 'fname' => $this->session->SESS_FIRST_NAME,
                 'lname' => $this->session->SESS_LAST_NAME,
                 'base_url' =>base_url()
             ), TRUE);
             $this->setBody($template);
             $this->sendWebPushNotification($this->request['Message']['Subject']['Data']);
         }

         else if ($type === 2){
             $this->request['Message']['Subject']['Data'] = 'Your thought rated by '.$this->session->SESS_FIRST_NAME." ".$this->session->SESS_LAST_NAME;
             $template = $this->parser->parse('template/email/new_rating.html',array(
                 'fname' => $this->session->SESS_FIRST_NAME,
                 'lname' => $this->session->SESS_LAST_NAME,
                 'base_url' =>base_url()
             ), TRUE);
             $this->setBody($template);
         }


      }

      private function setBody($template){
          $content = array('content' => $template);
          $string = $this->parser->parse('template/email/layout.html', $content, TRUE);
          $this->request['Message']['Body']['Html']['Data'] = $string;
          $this->sendEmail();
      }

      private function sendEmail(){
          try {
              $result = $this->client->sendEmail($this->request);
              $messageId = $result->get('MessageId');
              echo("Email sent! Message ID: $messageId"."\n");

          } catch (Exception $e) {
              echo("The email was not sent. Error message: ");
              ($e->getMessage()."\n");
          }
      }

      private function sendWebPushNotification($payload){
          // send multiple notifications with payload
          foreach ($this->endpoints as $row) {
              $this->webPush->sendNotification(
                  $row->endpoint,
                  'hai kunne',
                   $row->public_key,
                  $row->auth_token
              );
          }
          $this->webPush->flush();

      }

      private function getReceiverDetails($memId){
         $this->db->select("email,mem_id");
         $this->db->where("mem_id",$memId);
         $query = $this->db->get("member");
         $this->data =  $query->row();
          $this->setDestination();
      }

      private function getRatingDetails($data){
              $this->db->select('mem_id');
              $this->db->where('id',$data['1']);
              $query =  $this->db->get('posts');
              $result = $query->row();
              if ($result->mem_id != $this->session->SESS_MEMBER_ID){
                  $this->getReceiverDetails($result->mem_id);
                  $this->setType(2);
              }

      }

      public function addFriend($receiver){
         $this->getReceiverDetails($receiver);
         $this->setType(0);
      }

       public function newMessage($receiver){
           $this->getReceiverDetails($receiver);
           $this->setType(1);
       }

       public function newRating($data){
           $this->getRatingDetails($data);
       }

      public function initFlush(){
          ignore_user_abort(true);
          set_time_limit(0);
          ob_start();
      }

      public function closeFlush(){
          header('Connection: close');
          header('Content-Length: '.ob_get_length());
          ob_end_flush();
          ob_flush();
          flush();
      }



   }
?>
