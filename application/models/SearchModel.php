<?php
   class SearchModel extends CI_Model {

      private $advQry,$resultCount;

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
      public function searchDictionary($value)   {
        $this->db->distinct();
        $this->db->select('word');
        $this->db->like('word', $value,'after');
        $this->db->limit(10, 0);
        $query = $this->db->get('dictionary');
        return $query->result();
      }
      public function searchHashtag($value)   {
        $this->db->distinct();
        $this->db->select('hashtag');
        $this->db->like('hashtag', $value,'after');
        $this->db->limit(10, 0);
        $query = $this->db->get('post_tags');
        return $query->result();
      }
      public function searchByEmail($value) {
        $this->db->select('mem_id,picture,fname,lname');
        $this->db->where('email',$value);
        $result = $this->db->get('member');
        $result = $result->result_array();
        foreach ($result as $key => $row){
          $imgUrl = "images/userimages/".$row['picture'].'.jpg';
          $imgUrl =$this->createThumb($imgUrl,60,$row['picture']);
          $im = file_get_contents($imgUrl);
          $im = base64_encode($im);
          $im = 'data: '.mime_content_type($imgUrl).';base64,'.$im;
          $result["$key"]["picture"] = $im;
        }
        return $result;
      }




   }
?>
