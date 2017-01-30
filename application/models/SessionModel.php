<?php
   class SessionModel extends CI_Model {

     private $recentVisitorsData;

      function __construct() {
         parent::__construct();

      }
      private function convertToJPEG($data)      {

        $fileType = $data->data('file_type');
        $allowedType = array('image/jpeg', 'image/pjpeg');
        if ( !in_array($fileType,$allowedType)) {
          $png = array('image/png',  'image/x-png');
          if (in_array($fileType,$png)) {
              $image = imagecreatefrompng ($data->data('full_path') );
              $newFile = $data->data('file_path').$data->data('raw_name').'.jpg';
               imagejpeg($image,$newFile,100);
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

          public function postImageUpload()      {
            $config['upload_path']          = 'images/userimages/posts';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 2000;
            $config['max_width']            = 3000;
            $config['max_height']           = 3000;
            $config['encrypt_name']       = TRUE;

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('file'))
            {
                    $error = array('error' => $this->upload->display_errors());

                    print_r($error);
            }
            else
            {

              $conversion = $this->convertToJPEG($this->upload);
              if ($conversion) {
                $newFile = $this->upload->data('raw_name');
                $response = array('file' => $newFile,
                  "status" => true,
                );
                echo json_encode($response);
              }



            }
          }

      public function dpUpload()      {
        $config['upload_path']          = 'images/userimages';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 2000;
        $config['max_width']            = 3000;
        $config['max_height']           = 3000;
        $config['encrypt_name']       = TRUE;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('file'))
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
                  echo "1";
                }


        }
      }


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

      public function insertPost($data)    {
        $info = array('mem_id' => $this->session->SESS_MEMBER_ID,
        'content' => $data->content,
        );
        $this->db->trans_start();
        $this->db->set('date_time', 'NOW()', FALSE);
        $this->db->insert('posts', $info);
        $query = $this->db->query('SELECT LAST_INSERT_ID() as post_id');
        $file = $data->upload->file;
        if ( !($file == "") ) {
          $this->db->insert('post_images', array(
            'post_id' => $query->row()->post_id,
            'image' => $file,
          ));
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE){
          echo "1";
        }else {
          echo "0";
        }

      }

      public function getFriendRequestList($value)      {
        $qry = "SELECT member_details.* FROM `friendship`,member_details
        WHERE friendship.receiver=?
        AND friendship.status=?
        AND friendship.sender=member_details.mem_id
        LIMIT ?,10";
        $result = $this->db->query($qry, array(
        intval($this->session->SESS_MEMBER_ID), 0, intval($value)));
        echo json_encode($result->result());
      }

      public function getFriendRequestCount()      {
        $qry = "SELECT COUNT(*) AS count FROM `friendship`,member_details
        WHERE friendship.receiver=?
        AND friendship.status=?
        AND friendship.sender=member_details.mem_id";
        $result = $this->db->query($qry, array(
        intval($this->session->SESS_MEMBER_ID), 0
        ));
        echo json_encode($result->row());
      }
      public function friendRequestActions($value,$id)   {
          if ($value == "0") {
            $this->db->set('status', 1);
            $this->db->where('sender', $this->session->SESS_MEMBER_ID);
            $this->db->where('receiver', $id);
            $this->db->update('friendship');

          }elseif ($value == "1") {
            $this->db->where('sender', $this->session->SESS_MEMBER_ID);
            $this->db->where('receiver', $id);
            $this->db->delete('friendship');
          }
      }






   }
?>
