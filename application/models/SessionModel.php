<?php
   class SessionModel extends CI_Model {

     private $recentVisitorsData;

      function __construct() {
         parent::__construct();

      }

      private function pathToDP($ext,$id)      {
        if ($ext == NULL) {
          $imageURL = "images/photo.jpg";
          return $imageURL;
        }
        else {
          $imageURL = "images/userimages/".$id.".".$ext;
          return $imageURL;
        }
      }

//-----------------public method--------------------------------------




      public function getDetails($id)      {

        $query = $this->db->get_where('member_details', array('mem_id' => $id) );
        $data  = $query->row_array();
        $this->load->library('country_iso');
        $data['c_name'] = $this->country_iso->countries[ $data['country'] ];
        echo json_encode($data);

      }

      public function changeName($data)    {
        $response = array(
          'sel' => 1,
          'status' => true,
        );

        $this->db->where('mem_id', $this->session->SESS_MEMBER_ID);
        $result = $this->db->update('member',$data);
        if ($result) {
          $response['status'] = true;

        }
        else {
          $response['status'] = false;
        }
        echo json_encode($response);
      }

      public function changeTag($value)    {
      }
      public function changeAboutMe($value)    {
      }
      public function changeAboutPartner($value)    {
      }
      public function changeGender($data)    {

        $response = array(
          'sel' => 1,
          'status' => true,
        );
          $this->db->set($data);
          $this->db->where('mem_id', $this->session->SESS_MEMBER_ID);
          $result = $this->db->update('member');
          if ($result) {
            $response['status'] = true;
          }else {
            $response['status'] = false;
          }
          echo json_encode($response);
      }
      public function changeBday($data)    {

        $response = array(
          'sel' => 1,
          'status' => true,
        );
          $this->db->set($data);
          $this->db->where('mem_id', $this->session->SESS_MEMBER_ID);
          $result = $this->db->update('member');
          if ($result) {
            $response['status'] = true;
          }else {
            $response['status'] = false;
          }
          echo json_encode($response);
      }

      public function changeCountry($data)    {
         $this->load->library('country_iso');
         $cont = array_flip($this->country_iso->countries);
         $data->country = $cont["$data->country"];
         $response = array(
           'sel' => 1,
           'status' => true,
         );
           $this->db->set($data);
           $this->db->where('mem_id', $this->session->SESS_MEMBER_ID);
           $result = $this->db->update('member');
           if ($result) {
             $response['status'] = true;
           }else {
             $response['status'] = false;
           }
           echo json_encode($response);

      }


      public function deleteDP()      {
        $qry = "SELECT picture FROM member WHERE mem_id=?";
        $result = $this->db->query($qry,array($this->session->SESS_MEMBER_ID));
        if($result){
          $row = $result->row();
          $qry = "UPDATE member SET picture='photo.jpg' WHERE mem_id=?";
          $result = $this->db->query($qry,array($this->session->SESS_MEMBER_ID));
          if ($result) {
            return delete_files($this->session->SESS_USERIMAGES.$row->picture);
          }else {
            return false;
          }
        }else {
          return false;
        }
      }

      public function addFriend($data)   {
          $data = array(
          'sender' => $this->session->SESS_MEMBER_ID,
          'receiver' => $data,
          'status' => 0
          );
          $this->db->set('date_time', 'NOW()', FALSE);
          echo $this->db->insert('friendship', $data);
      }

      public function removeFriend($data)   {
          $data = array(
          'sender' => $this->session->SESS_MEMBER_ID,
          'receiver' => $data,
          );
          echo $this->db->delete('friendship', $data);
      }

      public function getFriendshipStatus($value)      {
        $data = array('sender' => $this->session->SESS_MEMBER_ID,
         'receiver' => $value);
        $query = $this->db->select('status')->from('friendship')
                            ->where($data)->get();
        if ($query->num_rows() > 0) {
          $val = $query->row();
          echo $val->status;
        }else {
          echo "-1";
        }

      }






   }
?>
