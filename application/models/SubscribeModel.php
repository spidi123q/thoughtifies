<?php
   class SubscribeModel extends CI_Model {

      private $request,$client,$data;
      function __construct() {
         parent::__construct();
         $this->request = array();
          $this->client = new Aws\Ses\SesClient([
              'version'=> 'latest',
              'region' => 'us-west-2',
          ]);
          $this->request['Source'] = "Thoughtifies <noreply@thoughtifies.com>";
      }
      private function setDestination(){
         $this->request['Destination']['ToAddresses'] = array($this->data->email);
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
      private function getReceiverDetails($memId){
         $this->db->select("email");
         $this->db->where("mem_id",$memId);
         $query = $this->db->get("member");
         $this->data =  $query->row();
          $this->setDestination();
      }
      public function addFriend($receiver){
         $this->getReceiverDetails($receiver);
         $this->setType(0);
      }
       public function newMessage($receiver){
           $this->getReceiverDetails($receiver);
           $this->setType(1);
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
