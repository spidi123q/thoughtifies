<?php
   class SessionModel extends CI_Model {

     private $recentVisitorsData;

      function __construct() {
         parent::__construct();

      }
      private function convertHashtags($str){
      	$regex = "/#+([a-zA-Z0-9_]+)/";
        preg_match_all($regex, $str, $matches);
        //print_r($matches[1]);
      	$str = preg_replace($regex, '<a href="hashtag.php?tag=$1">$0</a>', $str);
      	return(
          array('data' => $str ,
          'hashtags' => $matches[1],
         )
        );
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

      private function createThumb($imgUrl,$size,$picture)      {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $imgUrl;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = FALSE;
        $config['quality'] = 100;
        $config['width']         = $size;
        $config['height']       = $size;
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $imgUrl = "images/userimages/".$picture.'_thumb.jpg';
        return $imgUrl;
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
                  $imgUrl = $newFile;
                  $imgUrl =$this->createThumb($imgUrl,150,$this->upload->data('raw_name'));
                  $im = file_get_contents($imgUrl);
                  $im = base64_encode($im);
                  $im = 'data: '.mime_content_type($imgUrl).';base64,'.$im;
                  echo $im;
                }


        }
      }


      public function getDetails($id)      {
        $this->db->select('*');
        $qry = "NOT EXISTS (SELECT receiver as users FROM blocked
        where sender=$id and receiver={$this->session->SESS_MEMBER_ID}
        union
        SELECT sender as users FROM blocked
        where receiver=$id and sender = {$this->session->SESS_MEMBER_ID})";
        if($id !== $this->session->SESS_MEMBER_ID)
          $this->db->where($qry);
        $this->db->where(array('mem_id' => $id));
        $query = $this->db->get('member_details');
        if ($query->num_rows() > 0) {
          $data  = $query->row_array();
          $imgUrl = "images/userimages/".$data['picture'].'.jpg';
          $imgUrl =$this->createThumb($imgUrl,150,$data['picture']);
          $im = file_get_contents($imgUrl);
          $im = base64_encode($im);
          $im = 'data: '.mime_content_type($imgUrl).';base64,'.$im;
          $data['picture'] = $im;
          $this->load->library('country_iso');
          $data['c_name'] = $this->country_iso->countries[ $data['country'] ];
          echo json_encode($data);
        }else {
          echo "0";
        }

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

      public function changeTag($data)    {
        $response = array(
          'sel' => 1,
          'status' => true,
        );

        $this->db->where('mem_id', $this->session->SESS_MEMBER_ID);
        $result = $this->db->update('member_details',$data);
        if ($result) {
          $response['status'] = true;

        }
        else {
          $response['status'] = false;
        }
        echo json_encode($response);
      }
      public function changeAboutMe($data)    {
        $response = array(
          'sel' => 3,
          'status' => true,
        );

        $this->db->where('mem_id', $this->session->SESS_MEMBER_ID);
        $result = $this->db->update('member_details',$data);
        if ($result) {
          $response['status'] = true;

        }
        else {
          $response['status'] = false;
        }
        echo json_encode($response);
      }
      public function changeMyPreferences($data)    {
        $response = array(
          'sel' => 4,
          'status' => true,
        );

        $this->db->where('mem_id', $this->session->SESS_MEMBER_ID);
        $result = $this->db->update('member_details',$data);
        if ($result) {
          $response['status'] = true;

        }
        else {
          $response['status'] = false;
        }
        echo json_encode($response);
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
           'sel' => 8,
           'status' => true,
         );
           $this->db->set($data);
           $this->db->where('mem_id', $this->session->SESS_MEMBER_ID);
           $result = $this->db->update('member');
           if ($result) {
             $response['status'] = true;
             $response['result'] = $data->country;
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

      function convertLinks( $string ) {
          return  preg_replace(
              "~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~",
              "<a href='$1'>$2</a>",
              $string);
      }

      public function insertPost($data)    {
        $hash = $this->convertHashtags($data->content);
        $data->content = $hash['data'];
        $info = array('mem_id' => $this->session->SESS_MEMBER_ID,
        'content' => $data->content,
        );
        $this->db->trans_start();
        $this->db->set('date_time', 'NOW()', FALSE);
        $this->db->insert('posts', $info);
        $query = $this->db->query('SELECT LAST_INSERT_ID() as post_id');
        $post_id  = $query->row()->post_id;
        foreach ($hash['hashtags'] as $key) {
          $this->db->insert('post_tags', array(
            'post_id' => $post_id,
            'hashtag' => $key,
          ));
        }
        $file = $data->upload->file;
        if ( !($file == "") ) {
          $this->db->insert('post_images', array(
            'post_id' => $post_id,
            'image' => $file,
          ));
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE){
          $this->db->where('id',$post_id);
          $result = $this->db->get('post_view');
          echo json_encode($result->row());
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
      public function blockUser($id)  {
        $data = array(
        'sender' => $this->session->SESS_MEMBER_ID,
        'receiver' => $id,
        );
        $this->db->set('date_time', 'NOW()', FALSE);
        echo $this->db->insert('blocked', $data);
      }

      public function getPosts($offset,$id)      {
        if($id !== '')
          $this->db->where('mem_id',$id);

        $this->db->limit(10, $offset);
        $query = $this->db->get("post_view");
        $result = $query->result_array();
        foreach ($result as $key => $row){
          $this->db->select("rating");
          $this->db->where( array(
            'mem_id' => $this->session->SESS_MEMBER_ID,
            'post_id' => $row['id'],
          ));
          $query = $this->db->get("rating");
          $result2 = $query->row();
          $result["$key"]["my_rating"] = isset($result2)?$result2->rating:null;
        }
        echo json_encode($result);
      }

      public function getPostsCount($id)      {
        $this->db->select("COUNT(*) AS count");
        if($id !== '')
          $this->db->where('mem_id',$id);
        $query = $this->db->get("post_view");
        echo json_encode($query->row());
      }

      public function onRating($data)      {
        $qry = "INSERT INTO rating
                (mem_id, post_id, rating)
              VALUES
                (?, ?, ?)
              ON DUPLICATE KEY UPDATE
                rating = VALUES(rating)";
          $this->db->query($qry,$data);

      }

      public function getMyRating($value)      {
        $this->db->select("rating");
        $query = $this->db->get_where('rating', array(
          'mem_id' => $this->session->SESS_MEMBER_ID,
          'post_id' => $value,
        ));
        echo json_encode($query->row());
      }

      public function listBlockedUsers()      {
        $qry = "SELECT member.* FROM blocked,member
        where sender=? and blocked.receiver=member.mem_id";
        /*
        union
        SELECT member.* FROM member,blocked
        where receiver=? and blocked.sender=member.mem_id;*/
        $data = array($this->session->SESS_MEMBER_ID);
        $result = $this->db->query($qry,$data);
        $result = $result->result_array();
        foreach ($result as $key => $row){
          $imgUrl = "images/userimages/".$row['picture'].'.jpg';
          $imgUrl =$this->createThumb($imgUrl,60,$row['picture']);
          $im = file_get_contents($imgUrl);
          $im = base64_encode($im);
          $im = 'data: '.mime_content_type($imgUrl).';base64,'.$im;
          $result["$key"]["picture"] = $im;
        }
        echo json_encode($result);
      }

      public function unblock($mem_id)      {
        $data = array(
        'sender' => $this->session->SESS_MEMBER_ID,
        'receiver' => $mem_id,
        );
        echo $this->db->delete('blocked', $data);
      }

      public function dpFetch($file,$size)      {
        $imgUrl = "images/userimages/".$file.'.jpg';
        $imgUrl =$this->createThumb($imgUrl,$size,$file);
        $im = file_get_contents($imgUrl);
        $im = base64_encode($im);
        $im = 'data: '.mime_content_type($imgUrl).';base64,'.$im;
        echo $im;
      }
      public function userDpFetch($id,$size)        {
        $this->db->select('picture');
        $this->db->where('mem_id',$id);
        $query = $this->db->get('member');
        $query = $query->row();
        $this->dpFetch($query->picture,$size);
      }

      public function getNotification()      {
        $data = array( );
        //selecting messages
        $this->db->select("COUNT(*) as count");
        $this->db->where('type','message');
        $this->db->where('receiver',$this->session->SESS_MEMBER_ID);
        $query = $this->db->get('notification');
        $data['message'] = $query->row()->count;
        //selecting ratings
        $this->db->select("COUNT(*) as count");
        $this->db->where('type','rating');
        $this->db->where('receiver',$this->session->SESS_MEMBER_ID);
        $query = $this->db->get('notification');
        $data['rating'] = $query->row()->count;
        //selecting friend requests
        $this->db->select("COUNT(*) as count");
        $this->db->where('type','friend_req');
        $this->db->where('receiver',$this->session->SESS_MEMBER_ID);
        $query = $this->db->get('notification');
        $data['friend_req'] = $query->row()->count;
        echo json_encode($data);

      }
      public function setNotification($value)      {
        $data = array(
          'type' => $value,
          'receiver' => $this->session->SESS_MEMBER_ID,
        );
        echo $this->db->delete('notification', $data);

      }
      public function addRecentVisitor($id)      {
        $data = array(
                'sender' => $this->session->SESS_MEMBER_ID,
                'receiver' => $id,
        );
        $this->db->set('date_time','NOW()',FALSE);
        $this->db->insert('recent_visitors', $data);
      }







   }
?>
