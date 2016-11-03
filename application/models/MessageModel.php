<?php
   class MessageModel extends CI_Model {

      function __construct() {
         parent::__construct();
      }

      public function listMessengers()      {
            $qry = "SELECT DISTINCT sender
            FROM (

            SELECT result.sender, result.date_time
            FROM (

            SELECT  sender, receiver, date_time
            FROM myMessages
            WHERE sender =  ?
            OR receiver =  ?
            ORDER BY date_time DESC
            )result
            UNION SELECT result.receiver, result.date_time
            FROM (

            SELECT  sender, receiver, date_time
            FROM myMessages
            WHERE sender =  ?
            OR receiver =  ?
            ORDER BY date_time DESC
            )result
            ORDER BY date_time DESC
          )r WHERE sender !=  ? ORDER BY r.date_time DESC LIMIT 0,5";

          $result = $this->db->query($qry, array(
            $this->session->SESS_MEMBER_ID,
            $this->session->SESS_MEMBER_ID,
            $this->session->SESS_MEMBER_ID,
            $this->session->SESS_MEMBER_ID,
            $this->session->SESS_MEMBER_ID,
          ));

          $content = '<table><td>';
          foreach ($result->result() as $row){
            $qry = "SELECT mem_id,fname,lname,picture FROM member WHERE mem_id=?";
            $result2 = $this->db->query($qry, array($row->sender,));
            $rw = $result2->row();
            $content .= $this->parser->parse('template/msg_list_view.php', $rw,TRUE);

          }
          for($i=0;$i<50;$i++)
          $content .= '<div class="completed step">
        <i class="truck icon"></i>
        <div class="content">
          <div class="title">Shipping</div>
          <div class="description">Choose your shipping options</div>
        </div>
      </div>';
          return $content.'</td></table>';





          }

      public function displayMessages($id)    {
        $qry2 = "SELECT fname,picture FROM member WHERE mem_id=?";
        $result = $this->db->query($qry2,array($id));
        $user = $result->row_array();
        $content = '';
        $qry = "SELECT *
                FROM (

                SELECT *
                FROM myMessages
                    WHERE (
                                (
                                  receiver =  ?
                                  AND sender =  ?
                                )
                        OR
                                (
                                receiver =  ?
                                AND sender =  ?
                                )
                    )
                ORDER BY date_time DESC
                LIMIT 0 , 88
                )result ORDER BY result.date_time";
          $result = $this->db->query($qry, array(
                  $this->session->SESS_MEMBER_ID,
                  $id,
                  $id,
                  $this->session->SESS_MEMBER_ID,
                ));
              if ($result) {
                foreach ($result->result_array() as $row) {
                  $row = array_replace($row,$user);
                  if ($row['sender'] == $this->session->SESS_MEMBER_ID) {
                    $row = array_replace($row,array(
                      'align' => 'right',
                      'label_type' => '',
                      'fname' => '',
                       ) );
                  } else {
                    $row = array_replace($row,array(
                      'align' => 'left',
                      'label_type' => 'pointing',
                    ));
                  }

                  $content .= $this->parser->parse('template/msgview.php', $row,TRUE);


                }
                return $content;
              }


      }

      public function sentMessage($data)      {
          $info = array(
          'sender' => $this->session->SESS_MEMBER_ID,
          'receiver' => $data['receiver'],
          'message' => "{$data['msg']}" ,
          );
           $this->db->set('date_time', 'NOW()', FALSE);
          return $this->db->insert('myMessages',$info);
      }


   }
?>
