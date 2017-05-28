<?php

use Carbon\Carbon;

   class SessionModel extends CI_Model {

     private $recentVisitorsData,$fb;

      function __construct() {
         parent::__construct();
          $this->fb = new Facebook\Facebook([
              'app_id' => $_SERVER['FB_APP_ID'],
              'app_secret' => $_SERVER['FB_APP_SECRET'],
              'default_graph_version' => 'v2.8',
          ]);


      }
      private function convertHashtags($str){
      	$regex = "/#+([a-zA-Z0-9_]+)/";
        preg_match_all($regex, $str, $matches);
        //print_r($matches[1]);
      	$str = preg_replace($regex, '<a class="hash-tag" href="#/tbs/hash/$1">$0</a>', $str);
      	return(
          array('data' => $str ,
          'hashtags' => $matches[1],
         )
        );
      }

      private function friendsListQuery()      {
        $this->db->select('receiver AS user');
        $this->db->where('sender',$this->session->SESS_MEMBER_ID);
        $this->db->where('status',1);
        $table1 = $this->db->get_compiled_select('friendship');
        $this->db->select('sender AS user');
        $this->db->where('receiver',$this->session->SESS_MEMBER_ID);
        $this->db->where('status',1);
        $table2 = $this->db->get_compiled_select('friendship');
        $qry = "($table1 )UNION ($table2)";
        $this->db->select('*');
        $this->db->from("($qry)");
        $qry = $this->db->get_compiled_select();
        return "($qry as u) as t";
      }
      private function convertToJPEG($data)      {

        $fileType = $data->data('file_type');
        $type = get_mimes();
        if ( !in_array($fileType,$type['jpg']) || !in_array($fileType,$type['jpeg'])) {

          if (in_array($fileType,$type['png'])) {
              $image = imagecreatefrompng ($data->data('full_path') );
              $newFile = $data->data('file_path').$data->data('raw_name').'.jpg';
               imagejpeg($image,$newFile,100);
                if (unlink($data->data('full_path'))) {
                  //echo "deleted";
                  return true;
                }
                else {
                  return false;
                }
          }
        }
        else {
            $newFile = $data->data('file_path').$data->data('raw_name').'.jpg';
            rename($data->data('full_path'),$newFile);
          return true;
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
        $this->image_lib->clear();
        $imgUrl = "images/userimages/".$picture.'_thumb.jpg';
        return $imgUrl;
      }
      private function cropDp($values)    {
        $length = (float)$values[0] - (float)$values[2];
        $length = abs($length);
        $length = floor($length);
        $config['image_library'] = 'gd2';
        $config['source_image'] = './images/userimages/'.$this->session->TEMP_DP.".jpg";
        $config['x_axis'] = $values[0];
        $config['y_axis'] = $values[1];
        $config['height'] = $length;
        $config['width'] =  $length;
        $config['maintain_ratio'] = FALSE;
        $this->load->library('image_lib', $config);
        $this->image_lib->initialize($config);
        if ( ! $this->image_lib->crop())
        {
                echo $this->image_lib->display_errors();
        }
        else {
          return true;
        }
        $this->image_lib->clear();
      }

//-----------------public method--------------------------------------

          public function postImageUpload()      {
            $config['upload_path']          = 'images/userimages/posts';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 10000;
            $config['max_width']            = 3000;
            $config['max_height']           = 3000;
            $config['encrypt_name']       = TRUE;

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('file'))
            {
                    $error = array('error' => $this->upload->display_errors());
                     echo json_encode($error);
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
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 10000;
        $config['max_width']            = 3000;
        $config['max_height']           = 3000;
        $config['encrypt_name']       = TRUE;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('file'))
        {
                $error = array('error' => $this->upload->display_errors());

                echo json_encode($error);
        }
        else
        {

          $this->convertToJPEG($this->upload);
          $newFile = $this->upload->data('file_path').$this->upload->data('raw_name').'.jpg';
          $this->session->set_userdata('TEMP_DP', $this->upload->data('raw_name'));
                  $imgUrl = $newFile;
                  //$imgUrl =$this->createThumb($imgUrl,1000,$this->upload->data('raw_name'));
                  $im = file_get_contents($imgUrl);
                  $im = base64_encode($im);
                  $im = 'data: '.mime_content_type($imgUrl).';base64,'.$im;
                  $response = array(
                    'dp' => $im,
                    'filename' => $this->session->TEMP_DP,
                   );
                   echo json_encode($response);
        }
      }

      public function setDp($data)    {
        $response = array(
          'sel' => 0,
          'status' => false,
        );

        if ( $this->cropDp($data) ) {
          $this->db->set('picture', $this->session->TEMP_DP);
          $this->db->where('mem_id', $this->session->SESS_MEMBER_ID);
           if ( $this->db->update('member') ) {
             $response['status'] = true;
             $imgUrl = "images/userimages/".$this->session->TEMP_DP.'.jpg';
             $config['image_library'] = 'gd2';
             $config['source_image'] = $imgUrl;
             $config['create_thumb'] = TRUE;
             $config['maintain_ratio'] = FALSE;
             $config['quality'] = 100;
             $config['width']         = 150;
             $config['height']       = 150;
             $this->load->library('image_lib', $config);
             $this->image_lib->resize();
             $im = file_get_contents($imgUrl);
             $im = base64_encode($im);
             $im = 'data: '.mime_content_type($imgUrl).';base64,'.$im;
             $response['dp'] = $im;
           }
        }
         echo json_encode($response);
      }


      public function getDetails($id)      {
        $this->db->select('*');
        $qry = "NOT EXISTS (SELECT receiver as users FROM blocked
        where sender=$id and receiver={$this->session->SESS_MEMBER_ID}
        union
        SELECT sender as users FROM blocked
        where receiver=$id and sender = {$this->session->SESS_MEMBER_ID})";

        if($id !== $this->session->SESS_MEMBER_ID){
          $this->db->where($qry);
        }

        $this->db->where(array('mem_id' => $id));
        $query = $this->db->get('member_details');
        if ($query->num_rows() > 0) {
          $data  = $query->row_array();
          $imgUrl = "images/userimages/".$data['picture'].'.jpg';
          $imgUrl = $this->createThumb($imgUrl,150,$data['picture']);
          /*
          $im = file_get_contents($imgUrl);
          $im = base64_encode($im);
          $im = 'data: '.mime_content_type($imgUrl).';base64,'.$im;
          */
          $data['picture'] = base_url().$imgUrl;
          $this->load->library('country_iso');
          if ( isset($this->country_iso->countries[ $data['country'] ])){
              $data['c_name'] = $this->country_iso->countries[ $data['country'] ];
          }
          else{
              $data['c_name'] = 'Unknown';
          }
          $this->db->select("NOW() as time",FALSE);
          $result = $this->db->get()->row();

          $data['friend_count'] = $this->friendsCount(1);
          $date = new DateTime($data['last_login']);
          $dt = Carbon::create(
              $date->format("Y"),
              $date->format("m"),
              $date->format("d"),
              $date->format("H"),
              $date->format("i"),
              $date->format("s"),
              $date->getTimezone()
          );
            $timeNow = new DateTime($result->time);
            $timeNow = Carbon::create(
                $timeNow->format("Y"),
                $timeNow->format("m"),
                $timeNow->format("d"),
                $timeNow->format("H"),
                $timeNow->format("i"),
                $timeNow->format("s"),
                $timeNow->getTimezone()
            );
          $data['last_login'] = $dt->diffForHumans($timeNow);
            //$data['last_login'] = $result->time;

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

      public function addFriend($receiver)   {

          $data = array(
          'sender' => $this->session->SESS_MEMBER_ID,
          'receiver' => $receiver,
          'status' => 0
          );
          $this->db->set('date_time', 'NOW()', FALSE);
          $this->SubscribeModel->initFlush();
          echo $this->db->insert('friendship', $data);
          $this->SubscribeModel->closeFlush();
          $this->SubscribeModel->addFriend($receiver);
      }

      public function removeFriend($data)   {
          $data = array(
          'sender' => $this->session->SESS_MEMBER_ID,
          'receiver' => $data,
          );
          echo $this->db->delete('friendship', $data);
      }

      public function getFriendshipStatus($value)      {
        $data = array('receiver' => $this->session->SESS_MEMBER_ID,
         'sender' => $value);
         $data2 = array('sender' => $this->session->SESS_MEMBER_ID,
          'receiver' => $value);
        $query = $this->db->select('sender,receiver,status')->from('friendship');
                  $this->db->group_start();
                            $this->db->where($data);
                  $this->db->group_end();
                  $this->db->or_group_start();
                        $this->db->where($data2);
                  $this->db->group_end();
                $query =   $this->db->get();
        if ($query->num_rows() > 0) {
          $val = $query->row();
          echo json_encode($val);
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
            $this->db->where('receiver', $this->session->SESS_MEMBER_ID);
            $this->db->where('sender', $id);
            echo $this->db->update('friendship');

          }elseif ($value == "1") {
            $this->db->where('receiver', $this->session->SESS_MEMBER_ID);
            $this->db->where('sender', $id);
            echo $this->db->delete('friendship');
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
      public function reportPost($data)      {
        echo $this->db->insert('report_post',$data);
      }

      public function getPosts($offset,$id,$type = 0)      {
        $friendQry = $this->friendsListQuery();
        if($id !== '')
          $this->db->where('mem_id',$id); //view post of users in profile
        if ($type === 1) {
            $this->db->join($friendQry, 't.user = post_view.mem_id');
        }

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

      public function getPostsCount($id,$type = 0)      {
        $friendQry = $this->friendsListQuery();
        $this->db->select("COUNT(*) AS count");
        if($id !== '')
          $this->db->where('mem_id',$id);
        if ($type === 1) {
            $this->db->join($friendQry, 't.user = post_view.mem_id');
          }
        $query = $this->db->get("post_view");
        //echo  $query;
        echo json_encode($query->row());
      }
      public function getPostById($id)    {
        $this->db->where('id',$id);
        $query = $this->db->get('post_view');
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
        if ($im === FALSE) {
          echo "0";
        }
        else {
          $im = base64_encode($im);
          $im = 'data: '.mime_content_type($imgUrl).';base64,'.$im;
          echo $im;
        }
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
      public function getRecentVisitor()    {
        $this->db->distinct('mem_id');
        $this->db->where('receiver',$this->session->SESS_MEMBER_ID);
        $this->db->limit(10,0);
        $query = $this->db->get('rv_view');
        echo json_encode($query->result());
      }

      public function listPostRating($offset)      {
        $this->db->select('id');
        $this->db->where('mem_id',$this->session->SESS_MEMBER_ID);
        $where = "post_id IN ({$this->db->get_compiled_select('posts')})";
        $this->db->where($where);
        $this->db->limit(10,$offset);
        $query = $this->db->get('rating_view');
        echo json_encode($query->result());
      }
      public function listPostRatingCount()      {
        $this->db->select('id');
        $this->db->where('mem_id',$this->session->SESS_MEMBER_ID);
        $where = "post_id IN ({$this->db->get_compiled_select('posts')})";
        $this->db->where($where);
        $this->db->select('COUNT(*) AS count');
        $query = $this->db->get('rating_view');
        echo json_encode($query->row());
      }

      public function friendsCount($format = 0)      {
        $this->db->select('COUNT(*) as count');
        $this->db->group_start();
        $this->db->where('sender',$this->session->SESS_MEMBER_ID);
        $this->db->or_where('receiver',$this->session->SESS_MEMBER_ID);
        $this->db->group_end();
        $this->db->where('status',1);
        $count = $this->db->get('friendship');
        $count = $count->row();
        if ($format === 0) {
          echo json_encode($count);
        }else {
          return $count->count;
        }
      }

      public function friendsList($offset)      {
        $qry = $this->friendsListQuery();
        $this->db->select('member_details.*');
        $this->db->from($qry);
        $this->db->join('member_details', 'member_details.mem_id = t.user');
        $this->db->limit(10,$offset);
        $query = $this->db->get();
        echo json_encode($query->result());

      }

      public function unfriendUser($data)      {
        $this->db->group_start();
          $this->db->group_start();
            $this->db->where('sender',$this->session->SESS_MEMBER_ID);
            $this->db->where('receiver',$data);
          $this->db->group_end();
          $this->db->or_group_start();
            $this->db->where('receiver',$this->session->SESS_MEMBER_ID);
            $this->db->where('sender',$data);
          $this->db->group_end();
        $this->db->group_end();
        $this->db->where('status',1);
        echo $this->db->delete('friendship');
      }

      public function deletePost($id)    {
        $this->db->set('deleted', 1);
        $this->db->where('id', $id);
        $this->db->where('mem_id', $this->session->SESS_MEMBER_ID);
        $this->db->update('posts');
        echo  $this->db->affected_rows();
      }

      public function getFbFriends(){
          $fb = $this->fb;
          try {
              $accessToken = new Facebook\Authentication\AccessToken($this->session->fb_access_token);
              $response = $fb->get("me/friends", $this->session->fb_access_token);
              $friends = $response->getGraphEdge();
              if ($fb->next($friends)) {
                  $allFriends = array();
                  $friendsArray = $friends->asArray();
                  $allFriends = array_merge($friendsArray, $allFriends);
                  while ($friends = $fb->next($friends)) {
                      $friendsArray = $friends->asArray();
                      $allFriends = array_merge($friendsArray, $allFriends);
                  }
                  foreach ($allFriends as $key) {
                      echo $key['name'] . "<br>";
                  }
                  echo count($allFriends);
              } else {
                  $allFriends = $friends->asArray();
              }
              $allFriendsFbId = array();
              foreach ($allFriends as $key) {
                  array_push($allFriendsFbId,$key['id']);
              }

              $this->db->select("mem_id");
              $this->db->where_in("id",$allFriendsFbId);
              $query = $this->db->get("facebook_member");
              $fbAppUsers = array();
              foreach ($query->result() as $row) {
                  array_push($fbAppUsers,$row->mem_id);
              }
              $qry = $this->MessageModel->friendsListQuery();
              $query = $this->db->query($qry);
              $myFriends = array();
              foreach ($query->result() as $row) {
                  array_push($myFriends,$row->user);
              }
              array_push($myFriends,$this->session->SESS_MEMBER_ID);
              $this->db->select("mem_id,picture");
              $this->db->where_not_in("mem_id",$myFriends);
              $this->db->where_in('mem_id',$fbAppUsers);
              $this->db->order_by("join_date","DESC");
              $this->db->limit(10);
              $query = $this->db->get("member");
              echo json_encode($query->result());



          } catch(Facebook\Exceptions\FacebookSDKException $e) {
              echo 'Error: ' . $e->getMessage();
              exit;
          }
      }


   }
?>
