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
          'member_details.yy <=' => date("Y") - $data->l_age,
          'member_details.yy >=' => date("Y") - $data->h_age,
        );
        if ($data->photo == 1) {
          $obj['picture !='] = 'photo';
        }
        if ($data->country != 'Any') {
          $obj['country'] = $data->country;
        }


        if ($data->online == 1) {

          $this->db->join('user_online', 'user_online.mem_id=member_details.mem_id');
          //echo $this->db->get_compiled_select('member_details');
        }


        $this->db->where($obj);
        $this->db->like('CONCAT_WS( " ",fname, lname)', $data->name,'after');

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
        $this->db->where("member_details.mem_id not in (SELECT receiver as users FROM blocked
        where sender={$this->session->SESS_MEMBER_ID}
        union
        SELECT sender as users FROM blocked
        where receiver={$this->session->SESS_MEMBER_ID})");
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
        $this->db->like('CONCAT_WS( " ",fname, lname)', $data->name,'after');

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
        $this->db->select('word AS label');
        $this->db->like('word', $value,'after');
        $this->db->limit(10, 0);
        $query = $this->db->get('dictionary');
        return $query->result();
      }
      public function searchByName($value)      {
        $this->db->distinct();
        $this->db->select('CONCAT_WS( " ",fname, lname) as label');
        $this->db->like('CONCAT_WS( " ",fname, lname)', $value,'after');
        $this->db->limit(10, 0);
        $query = $this->db->get('member');
        return $query->result();
      }
      public function searchHashtag($value)   {
        $this->db->distinct();
        $this->db->select('hashtag AS label');
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
          $result["$key"]["label"] = $row['fname']." ".$row['lname'];
        }
        return $result;
      }

      public function searchPostByHashtag($data,$offset)        {
        $this->db->distinct();
        $this->db->select('post_view.*');
        $this->db->from('post_tags');
        $this->db->where('hashtag',$data);
        $this->db->join('post_view', 'post_view.id = post_tags.post_id');
        $this->db->limit(10, $offset);
        $query = $this->db->get();
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
        //echo $this->db->get_compiled_select();
      }
      public function searchPostByHashtagCount($data)        {
        $this->db->distinct();
        $this->db->select('COUNT(post_id) as count');
        $this->db->from('post_tags');
        $this->db->where('hashtag',$data);
        $query = $this->db->get();
        echo json_encode($query->row());
      }
      public function searchPostByKeyword($data,$offset)      {
        $this->db->like('content',$data);
        $this->db->limit(10, $offset);
        $query = $this->db->get('post_view');
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

      public function searchPostByKeywordCount($data)    {
        $this->db->select('COUNT(*) as count');
        $this->db->from('post_view');
        $this->db->like('content',$data);
        $query = $this->db->get();
        //echo $query;
         echo json_encode($query->row());
      }


   }
?>
