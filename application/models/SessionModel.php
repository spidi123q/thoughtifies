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






   }
?>
