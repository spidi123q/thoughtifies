<?php
   class SearchModel extends CI_Model {

      function __construct() {
         parent::__construct();
      }

      public function advancedSearch($data)      {

        $qry;
        $like;// = $this->db->where($data)->get_compiled_select('member_details');
        $obj = array(
          'yy >=' => date("Y") - $data['l_age'],
          'yy <=' => date("Y") - $data['h_age'],
        );
        if ($data['photo'] == 1) {
          $obj['picture !='] = 'photo.jpg';
        }
        if ($data['country'] != 'any') {
          $obj['country'] = $data['country'];
        }


        if ($data['online'] == 1) {
          $this->db->join('user_online', 'user_online.mem_id=member_details.mem_id');
        }

        $qry = $this->db->where($obj);

        if ($data['keyword'] != '') {
          $like = array(
          'tag' => "%{$data['keyword']}%",
          'about_partner ' => "%{$data['keyword']}%",
          'about_me' => "%{$data['keyword']}%",
          );
          //$qry = $this->db->or_like($like);
          $qry = $qry
                      ->group_start()
                          ->or_like($like)
                      ->group_end();

        }

        $qry = $qry->get_compiled_select('member_details');
        return $qry;



      }


   }
?>
