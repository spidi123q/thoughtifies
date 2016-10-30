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
      public function recentVisitors()      {
        $content = '<div class="table-responsive"><table class="table"><tr>';
        $qry =" SELECT DISTINCT visitor_id, member.*
                FROM profile_vistors, member
                WHERE profile_vistors.mem_id ={$this->session->SESS_MEMBER_ID}
                AND member.mem_id = visitor_id
                AND username NOT
                IN (

                SELECT sender
                FROM blocked
                UNION SELECT receiver
                FROM blocked
                )
                ORDER BY visit_date DESC
                LIMIT 0 , 10";
        $result = $this->db->query($qry);
        if ($result->num_rows() > 0) {
          foreach ($result->result() as $row) {

            $dp = base_url().$this->pathToDP($row->profileExt,$this->session->SESS_MEMBER_ID);

            $data = array(
            'profileURL' => $this->session->SESS_MEMBER_ID,
            'photoURL' => $dp,
            'name' => $row->fname.' '.$row->lname,
            );
            $content .= '<td>'.$this->parser->parse('template/visitor_view.php', $data,TRUE).'</td>';
          }
          return $content.'</tr></table></div>';
        } else {
          return "no visitors";
        }
      }

      public function newUsers()      {
                $content = '<div class="table-responsive"><table class="table"><tr>';
                $qry =" SELECT *
                        FROM  `member`
                        WHERE username NOT
                        IN (

                        SELECT sender
                        FROM blocked
                        UNION SELECT receiver
                        FROM blocked
                        )
                        ORDER BY join_date DESC
                        LIMIT 0 , 10";
                $result = $this->db->query($qry);
                if ($result->num_rows() > 0) {
                  foreach ($result->result() as $row) {

                    $dp = base_url().$this->pathToDP($row->profileExt,$this->session->SESS_MEMBER_ID);

                    $data = array(
                    'profileURL' => $this->session->SESS_MEMBER_ID,
                    'photoURL' => $dp,
                    'name' => $row->fname.' '.$row->lname,
                    );
                    $content .= '<td>'.$this->parser->parse('template/visitor_view.php', $data,TRUE).'</td>';
                  }
                  return $content.'</tr></table></div>';
                } else {
                  return "no visitors";
                }


      }

      public function settings()      {
        $baseData = array('dp_thumb' => '',
        );
        $qry = "SELECT * FROM mDetails WHERE mem_id = ?";
        $result = $this->db->query($qry, array($this->session->SESS_MEMBER_ID));
        if ($result) {
          foreach ($result->result_array() as $row){
            $baseData = array_replace($baseData, $row);
          }


        }
        $qry = "SELECT * FROM member WHERE mem_id=?";
        $result = $this->db->query($qry, array($this->session->SESS_MEMBER_ID));
        if ($result) {
          foreach ($result->result_array() as $row){
            $baseData = array_replace($baseData,$row );
            //$baseData = array_replace($baseData,array('picture' => base_url()."images/userimages/".$row->picture ) );

          }

        }
        return $baseData;

      }

      public function changeTag($value)    {
        $qry = "INSERT INTO mDetails(mem_id,tag) VALUES(?,?) ON DUPLICATE KEY UPDATE tag=?";
        $result = $this->db->query($qry, array($this->session->SESS_MEMBER_ID,"$value","$value"));
        if ($result) {
          echo "updated";
        }
        else {
          echo "failed";
        }

      }
      public function changeAboutMe($value)    {
        $qry = "INSERT INTO mDetails(mem_id,about_me) VALUES(?,?) ON DUPLICATE KEY UPDATE about_me=?";
        $result = $this->db->query($qry, array($this->session->SESS_MEMBER_ID,"$value","$value"));
        if ($result) {
          echo "updated";
        }
        else {
          echo "failed";
        }

      }
      public function changeAboutPartner($value)    {
        $qry = "INSERT INTO mDetails(mem_id,about_partner) VALUES(?,?) ON DUPLICATE KEY UPDATE about_partner=?";
        $result = $this->db->query($qry, array($this->session->SESS_MEMBER_ID,"$value","$value"));
        if ($result) {
          echo "updated";
        }
        else {
          echo "failed";
        }

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




   }
?>
