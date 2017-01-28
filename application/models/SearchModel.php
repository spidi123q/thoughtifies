<?php
   class SearchModel extends CI_Model {

      private $advQry,$resultCount;

      function __construct() {
         parent::__construct();
      }

      public function t()      {
        echo $advQry;
      }

      public function advancedSearch($data)      {


        $obj = array(
          'yy <=' => date("Y") - $data->l_age,
          'yy >=' => date("Y") - $data->h_age,
        );
        if ($data->photo == 1) {
          $obj['picture !='] = 'photo';
        }
        if ($data->country != 'Any') {
          $obj['country'] = $data->country;
        }


        if ($data->online == 1) {

          $this->db->join('user_online', 'user_online.mem_id=member_details.mem_id');
        }


        $this->db->where($obj);

        if ($data->keyword != '') {
          $like = array(
          'tag' => $data->keyword,
          'about_partner ' => $data->keyword,
          'about_me' => $data->keyword,
          );
          //$qry = $this->db->or_like($like);
              $this->db
                      ->group_start()
                          ->or_like($like)
                      ->group_end();

        }
        $this->advQry = $this->db;
        $this->db->limit(10,$data->offset);
        //$advQry = $this->db->get_compiled_select('member_details');
        $advQry = $this->db->get('member_details');
        echo json_encode($advQry->result());




      }

      public function advancedSearchCount($data)      {


        $obj = array(
          'yy <=' => date("Y") - $data->l_age,
          'yy >=' => date("Y") - $data->h_age,
        );
        if ($data->photo == 1) {
          $obj['picture !='] = 'photo';
        }
        if ($data->country != 'Any') {
          $obj['country'] = $data->country;
        }


        if ($data->online == 1) {

          $this->db->join('user_online', 'user_online.mem_id=member_details.mem_id');
        }


        $this->db->where($obj);

        if ($data->keyword != '') {
          $like = array(
          'tag' => $data->keyword,
          'about_partner ' => $data->keyword,
          'about_me' => $data->keyword,
          );
          //$qry = $this->db->or_like($like);
              $this->db
                      ->group_start()
                          ->or_like($like)
                      ->group_end();

        }
        $this->advQry = $this->db;
        $this->db->limit(10,$data->offset);
        //$advQry = $this->db->get_compiled_select('member_details');
        $advQry = $this->db->select("COUNT(*) as count")->get('member_details');
        echo json_encode($advQry->row());




      }




   }
?>
