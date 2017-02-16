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
          $listMemid = array( );
          $senders =  $result->result_array();
          foreach ($senders as $key ) {
            array_push($listMemid,$key['sender']);
          }
          //print_r($listMemid);

          $this->db->select('*')->from('member');
          $this->db->where_in('mem_id', $listMemid);
          $result = $this->db->get();
          echo json_encode($result->result());

          }



      public function sentMessage($data)      {
          $info = array(
          'sender' => $this->session->SESS_MEMBER_ID,
          'receiver' => $data->receiver,
          'message' => "{$data->message}" ,
          );
          $this->db->set('date_time','NOW()',FALSE);
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
                   ->order_by('date_time', 'DESC')
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
