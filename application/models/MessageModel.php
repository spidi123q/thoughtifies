<?php
   class MessageModel extends CI_Model {



      function __construct() {
         parent::__construct();
      }

      public function temp()      {
        # code...
        $query = $this->db->get('member');
        echo json_encode($query->result());
      }

      public function listMessengers()      {
        $content = '<table><td>';
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



      public function sentMessage($data)      {
          $info = array(
          'sender' => $this->session->SESS_MEMBER_ID,
          'receiver' => $data->receiver,
          'message' => "{$data->message}" ,
          );
          echo  $this->db->insert('myMessages',$info);
      }

      public function countMsg($data)      {
        $query = $this->db->select('COUNT(*) AS count')->from('myMessages')
                    ->group_start()
                      ->group_start()
                              ->group_start()
                                ->where('sender',$this->session->SESS_MEMBER_ID)
                                ->where('receiver',$data)
                              ->group_end()
                              ->or_group_start()
                                      ->where('receiver', $this->session->SESS_MEMBER_ID)
                                      ->where('sender',$data)
                              ->group_end()
                      ->group_end()
                   ->group_end()
            ->get();
            echo json_encode($query->row());

      }

      public function updateOnlineUsers()      {
         $data = array(
                'mem_id' => $this->session->SESS_MEMBER_ID,
                  );
        $this->db->replace('user_online', $data);
      }

      public function listOnlineUsers()      {

        $query = $this->db->get('member_online');
        if ($query) {
          echo  json_encode($query->result());
        }
      }

      public function listEmoji($index)      {
        $query = $this->db->get('emoji_db',10,$index);
        echo json_encode($query->result()) ;
      }

      public function getMessages($data)    {
        $query = $this->db->select('*')->from('myMessages')
                    ->group_start()
                      ->group_start()
                              ->group_start()
                                ->where('sender',$this->session->SESS_MEMBER_ID)
                                ->where('receiver',$data->user)
                              ->group_end()
                              ->or_group_start()
                                      ->where('receiver', $this->session->SESS_MEMBER_ID)
                                      ->where('sender',$data->user)
                              ->group_end()
                      ->group_end()
                      //->where("date_time >=","c")
                   ->group_end()
                   ->limit(10,$data->offset)
            ->get();
            echo json_encode($query->result());
      }
      public function getMessagesInit($id)    {
        $date;
        $query = $this->db->select('*')->from('myMessages')
                    ->group_start()
                      ->group_start()
                              ->group_start()
                                ->where('sender','a')
                                ->where('receiver','b')
                              ->group_end()
                              ->or_group_start()
                                      ->where('receiver', 'a')
                                      ->where('sender', 'b')
                              ->group_end()
                      ->group_end()
                      ->where("date_time >=",$date)
                   ->group_end()
            ->get_compiled_select();
            echo $query;
      }


   }
?>
