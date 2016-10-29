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

        $dpUrl = $this->pathToDP($this->session->SESS_PROEXT,$this->session->SESS_MEMBER_ID);
        $config['image_library'] = 'gd2';
        $config['source_image'] = $dpUrl;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width']         = 200;
        $config['height']       = 200;
        

        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $dpURLThumb;
        //echo $this->image_lib->display_errors();
        if ($this->session->SESS_PROEXT == NULL) {
          $dpURLThumb = base_url()."images/photo_thumb.jpg";
        }
        else {
          $dpURLThumb = base_url()."images/userimages/".$this->session->SESS_MEMBER_ID."_thumb.".$this->session->SESS_PROEXT;
        }
        $baseData = array('dp_thumb' => $dpURLThumb,
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
            $baseData = array_replace($baseData, $row);
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




   }
?>
