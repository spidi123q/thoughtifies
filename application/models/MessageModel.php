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
       public function friendsListQuery()      {
           $this->db->select('receiver AS user');
           $this->db->where('sender',$this->session->SESS_MEMBER_ID);
           $this->db->where('status',1);
           $table1 = $this->db->get_compiled_select('friendship');
           $this->db->select('sender AS user');
           $this->db->where('receiver',$this->session->SESS_MEMBER_ID);
           $this->db->where('status',1);
           $table2 = $this->db->get_compiled_select('friendship');
           return "($table1) UNION ($table2)";
       }
      private function isUserBlocked($user){
          $this->db->group_start();
          $this->db->where(array(
              "sender" => $this->session->SESS_MEMBER_ID,
              "receiver" => $user
          ));
          $this->db->group_end();
          $this->db->or_group_start();
          $this->db->where(array(
              "sender" => $user,
              "receiver" => $this->session->SESS_MEMBER_ID,
          ));
          $this->db->group_end();
          $query = $this->db->get('blocked');
          if ($query->num_rows() > 0){
              return true;
          }else{
              return false;
          }

      }
      private function getLastMsg($user)    {
        $this->db->select('message')->from('myMessages');
        $this->db->group_start();
          $this->db->group_start();
            $this->db->where('sender',$this->session->SESS_MEMBER_ID);
            $this->db->or_where('sender',$user);
          $this->db->group_end();
          $this->db->or_group_start();
            $this->db->where('sender',$this->session->SESS_MEMBER_ID);
            $this->db->or_where('sender',$user);
          $this->db->group_end();
        $this->db->group_end();
        $this->db->order_by('date_time','DESC');
        $this->db->limit(1,0);


      }

      public function listMessengersCount()      {
              $qry = "SELECT count(*) AS count FROM (SELECT DISTINCT sender
              FROM (
              SELECT result.sender, result.date_time
              FROM (
              SELECT  sender, receiver, date_time
              FROM myMessages
              WHERE (sender =  ?
              OR receiver =  ?)
              AND (sender_deleted = ? OR receiver_deleted !=?)
              )result
              UNION SELECT result.receiver, result.date_time
              FROM (

              SELECT  sender, receiver, date_time
              FROM myMessages
              WHERE (sender =  ?
              OR receiver =  ?)
              AND (sender_deleted != ? OR receiver_deleted = ?)
              )result
            )r WHERE sender !=  ?) count_table";

            $result = $this->db->query($qry, array(
              $this->session->SESS_MEMBER_ID,
              $this->session->SESS_MEMBER_ID,
              $this->session->SESS_MEMBER_ID,
              $this->session->SESS_MEMBER_ID,
              $this->session->SESS_MEMBER_ID,
              $this->session->SESS_MEMBER_ID,
              $this->session->SESS_MEMBER_ID,
              $this->session->SESS_MEMBER_ID,
              $this->session->SESS_MEMBER_ID,
            ));
            echo json_encode($result->row());
      }

      public function listMessengers($offset)      {

            $qry = "SELECT DISTINCT sender
            FROM (

            SELECT result.sender, result.date_time
            FROM (

            SELECT  sender, receiver, date_time
            FROM myMessages
            WHERE (sender =  ?
            OR receiver =  ?)
            AND (sender_deleted = ? OR receiver_deleted !=?)
            ORDER BY date_time DESC
            )result
            UNION SELECT result.receiver, result.date_time
            FROM (

            SELECT  sender, receiver, date_time
            FROM myMessages
            WHERE (sender =  ?
            OR receiver =  ?)
            AND (sender_deleted != ? OR receiver_deleted = ?)
            ORDER BY date_time DESC
            )result
            ORDER BY date_time DESC
          )r WHERE sender !=  ? ORDER BY r.date_time ASC LIMIT $offset,10";

          $result = $this->db->query($qry, array(
            $this->session->SESS_MEMBER_ID,
            $this->session->SESS_MEMBER_ID,
            $this->session->SESS_MEMBER_ID,
            $this->session->SESS_MEMBER_ID,
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


          if ( sizeof($listMemid) > 0 ) {
            $this->db->select('*')->from('member');
            $this->db->where_in('mem_id', $listMemid);
            $result = $this->db->get();
            echo json_encode($result->result());
          }


          }



      public function sentMessage($data)      {
          if (!$this->isUserBlocked($data->receiver)){
              $info = array(
                  'sender' => $this->session->SESS_MEMBER_ID,
                  'receiver' => $data->receiver,
                  'message' => "{$data->message}" ,
              );
              $this->db->set('date_time','NOW()',FALSE);
              $this->SubscribeModel->initFlush();
              echo  $this->db->insert('myMessages',$info);
              $this->SubscribeModel->closeFlush();
              $this->SubscribeModel->newMessage($data->receiver);

          }
          else{
              echo "0";
          }

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
                      ->group_start()
                        ->where('sender_deleted !=',$this->session->SESS_MEMBER_ID)
                        ->where('receiver_deleted !=',$this->session->SESS_MEMBER_ID)
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
        $query = $this->db->query( $this->friendsListQuery());
        $friends = array();
          foreach ($query->result() as $row) {
              array_push($friends,$row->user);
          }
         if ( sizeof($friends) > 0){
             $this->db->select("t.mem_id,fname,lname,picture");
             $this->db->from("member t");
             $this->db->where("t.mem_id !=",$this->session->SESS_MEMBER_ID);
             $this->db->where_in("t.mem_id",$friends);
             $this->db->join('user_online', 'user_online.mem_id = t.mem_id');
             $query = $this->db->get("");
             if ($query->num_rows() > 0) {
                 echo  json_encode($query->result());
             }
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
                      ->group_start()
                        ->where('sender_deleted !=',$this->session->SESS_MEMBER_ID)
                        ->where('receiver_deleted !=',$this->session->SESS_MEMBER_ID)
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

      public function deleteMsgUser($id)      {
        $this->db->trans_start();
        $this->db->set('sender_deleted',$this->session->SESS_MEMBER_ID);
        $this->db->where('sender', $this->session->SESS_MEMBER_ID);
        $this->db->where('receiver', $id);
        $this->db->update('myMessages');
        $this->db->set('receiver_deleted',$this->session->SESS_MEMBER_ID);
        $this->db->where('receiver', $this->session->SESS_MEMBER_ID);
        $this->db->where('sender', $id);
        $this->db->update('myMessages');
        $this->db->trans_complete();
      }


   }
?>
