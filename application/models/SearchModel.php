<?php
   class SearchModel extends CI_Model {

      private $advQry,$resultCount;

      function __construct() {
         parent::__construct();
      }

      public function advancedSearch($data)      {


        $obj = array(
          'yy >=' => date("Y") - $data['l_age'],
          'yy <=' => date("Y") - $data['h_age'],
        );
        if ($data['photo'] == 1) {
          $obj['picture !='] = 'photo';
        }
        if ($data['country'] != 'any') {
          $obj['country'] = $data['country'];
        }


        if ($data['online'] == 1) {

          $this->db->join('user_online', 'user_online.mem_id=member_details.mem_id')
          ->group_start()
            ->where('(NOW() - last_logout) >=','0')
            ->where('(NOW() - last_logout) <=','5')
          ->group_end();
        }


        $this->db->where($obj);

        if ($data['keyword'] != '') {
          $like = array(
          'tag' => $data['keyword'],
          'about_partner ' => $data['keyword'],
          'about_me' => $data['keyword'],
          );
          //$qry = $this->db->or_like($like);
              $this->db
                      ->group_start()
                          ->or_like($like)
                      ->group_end();

        }
        $this->advQry = $this->db;
        $this->db->limit(10,0);
        //echo $this->db->get_compiled_select('member_details');
        $result = $this->db->get('member_details');
        $content = '';
        if ($result) {

          if ($result->num_rows() == 0) {

            echo "no matched profile";

          }else {

              $this->resultCount = $result->num_rows();
              foreach ($result->result() as $row) {
              echo  $this->parser->parse('template/profile_card.php', $row,TRUE);
            }

          }

        }else {
          # code...
          echo "failed";
        }



      }

      public function advancedSearchPagination($page)      {
        $this->advQry->limit(10,$page);
        $result = $this->advQry->get('member_details');
        if ($result) {
          echo "donlop";

          if ($result->num_rows() == 0) {

            echo "no matched profile";

          }else {

              foreach ($result->result() as $row) {
              echo $this->parser->parse('template/profile_card.php', $row,TRUE);

            }
          }

        }else {
          echo "ffffffffffffffffffffffffff";
        }
        # code...
      }


   }
?>
