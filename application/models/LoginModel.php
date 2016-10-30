<?php
   class LoginModel extends CI_Model {

      function __construct() {
         parent::__construct();
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
                'SESS_USERIMAGES' => base_url().'images/userimages/',
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


   }
?>
