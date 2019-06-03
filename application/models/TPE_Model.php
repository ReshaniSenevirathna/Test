<?php
    class TPE_Model extends CI_Model {

        public function __construct() {
            parent::__construct();
            $this->load->database();
        }
        

        public function login($user, $pass) {
            $query = $this->db->get_where( 'users', array( 'username' => $user, 'password' => $pass ) );
            return $query->row_array();
        }

        
        public function register($user, $pass, $email) { 
            $pic = "images/propic/default.png"; 
            $sql = "INSERT INTO users VALUES ('$user', '$pass', '1')";
            $sql2 = "INSERT INTO user_details (username, pic, email, reminders) VALUES ('$user','$pic', '$email', 1)";
            $this->db->query($sql);                
            $this->db->query($sql2);
        }
        

        public function create($data) {
            $query= $this->db->insert('events',$data);           
        }
        

        public function check_user($user) {
            $query = $this->db->get_where( 'users', array('username' => $user) );
            return $query->row_array();
        }

        
        public function get_name($user) {
            $query = $this->db->get_where( 'user_details', array( 'username' => $user ) );
            return $query->row_array();
        }  
        
        
        public function profile($fname, $lname, $gender, $nic, $tele, $username) {
            $query = "UPDATE user_details SET fname = '$fname', lname = '$lname', gender = '$gender', nic = '$nic', telephone = '$tele' WHERE username = '$username'" ;
            if($this->db->query($query))
            {
                return 0;
            }
            else
            {
                return 1;
            }
        } 
        
        
        public function view_events($user) {
            $query = $this->db->get_where( 'events', array('owner' => $user) );
            return $query->result_array();
        }
        
        public function get_event($user, $id) {
            $query = $this->db->get_where( 'events', array('owner' => $user, 'id' => $id) );
            return $query->result_array();
        }
        
        public function get_collab($user, $event_id, $dept_name)
        {
            $func = "get_".$dept_name."_dept_id";
            $dept_id = $this->$func($event_id);
            
            $q = "SELECT e.* FROM events e, ".$dept_name."_department d, ".$dept_name."_users u WHERE u.username ='$user' AND u.dept_id = d.id AND d.event = e.id AND e.id=$event_id ";
            $query = $this->db->query($q);
            return $query->result_array();
        }
        
        public function update_pro_pic($path, $user) {
            $query = "UPDATE user_details SET pic = '$path' WHERE username = '$user'";
            $this->db->query($query);
        }
        
        public function update_event_pic($path, $id) {
            $query = "UPDATE events SET pic = '$path' WHERE id = '$id'";
            $this->db->query($query);
        }
        
        public function delete_event($id, $user) {
            $id_del = $id/23;
            $query = "DELETE FROM events WHERE id='$id_del' AND owner='$user'";
            
            if ( $this->db->query($query) )
            {
                return true;
            }            
        }
        
        public function update_event_details($data) {
            $this->db->where('id', $data['id']);
            $this->db->update('events', $data);
        }
        
        public function add_reminder_event($data) {
            $query1 = $this->db->get_where( 'events', array('id' => $data['event_id'], 'owner' => $data['username']));
            $num = $query1->num_rows();
            $result = $query1->row_array();
            if ($num == 1)
            {
                $data['event_name'] = $result['name'];  
                $query= $this->db->insert('event_reminders', $data);  
            }
        }
        
        public function fetch_reminder_event($username, $event) {
            $query = $this->db->get_where( 'event_reminders', array('event_id' => $event, 'username' => $username));
            return $query->result_array();
        }
        
        public function delete_reminder($id, $username) {
            $this->db->delete('event_reminders', array('id' => $id, 'username' => $username)); 
        }
        
        public function get_user_reminders($user) {
            $query = $this->db->get_where( 'event_reminders', array('username' => $user));
            return $query->result_array();
        }
        
        public function toggle_reminder($data, $user) {
            $sql = "UPDATE user_details SET reminders='$data' WHERE username='$user'";
            $this->db->query($sql);            
        }
         
        
        public function toggle_depts($data) { 
            $event_id = $data['event'];
            $query = $this->db->get_where( 'event_depts', array('event' => $event_id) );
            $result = $query->num_rows();          
            
            if ($result == 0) {
                $query= $this->db->insert('event_depts',$data);  
            }
            else 
            {
                $this->db->where('event', $event_id);
                $this->db->update('event_depts', $data);
            }
            
            if ($data['finance'] != null) {                  
                $query = "INSERT INTO finance_department(event) VALUES ($event_id) ON DUPLICATE KEY UPDATE event=$event_id";
                $this->db->query($query) ;  
            }
            else {
                $query = "DELETE FROM finance_department WHERE event = $event_id ";            
                $this->db->query($query) ;
            }
            
            if ($data['logistics'] != null) {               
                $query = "INSERT INTO logistics_department(event) VALUES ($event_id) ON DUPLICATE KEY UPDATE event=$event_id";        
                $this->db->query($query) ;  
            }
            else {
                $query = "DELETE FROM logistics_department WHERE event = $event_id ";            
                $this->db->query($query) ;
            }
            
            if ($data['decoration'] != null) {               
                $query = "INSERT INTO decorations_department(event) VALUES ($event_id) ON DUPLICATE KEY UPDATE event=$event_id";            
                $this->db->query($query) ;  
            }
            else {
                $query = "DELETE FROM decorations_department WHERE event = $event_id ";            
                $this->db->query($query) ;
            }
            
            if ($data['marketing'] != null) {               
                $query = "INSERT INTO marketing_department(event) VALUES ($event_id) ON DUPLICATE KEY UPDATE event=$event_id";            
                $this->db->query($query) ;  
            }
            else {
                $query = "DELETE FROM marketing_department WHERE event = $event_id ";            
                $this->db->query($query) ;
            }
            
            if ($data['registration'] != null) {               
                $query = "INSERT INTO registrations_department(event) VALUES ($event_id) ON DUPLICATE KEY UPDATE event=$event_id";          
                $this->db->query($query) ;  
            }
            else {
                $query = "DELETE FROM registrations_department WHERE event = $event_id ";            
                $this->db->query($query) ;
            }
            
            if ($data['sales'] != null) {               
                $query = "INSERT INTO sales_department(event) VALUES ($event_id) ON DUPLICATE KEY UPDATE event=$event_id";            
                $this->db->query($query) ;  
            }
            else {
                $query = "DELETE FROM sales_department WHERE event = $event_id ";            
                $this->db->query($query) ;
            }
            
           
        }
        
         public function get_departments($event_id) { 
            $query = $this->db->get_where( 'event_depts', array('event' => $event_id) );
            return $query->row_array();
           
        }  
        
        //Finance Department
        
        public function get_finance_dept_id($event_id) {
            $query = "SELECT id FROM finance_department WHERE event='$event_id'";
            $dept_id = (($this->db->query($query))->row_array())['id'];  
            return $dept_id;
        }
        
        public function add_crew_finance($id, $user) {
            $dept_id = $this->get_finance_dept_id($id);
            if ( $this->db->query("SELECT * FROM users WHERE username='$user'")->num_rows() > 0 )
            {
                $query2 = "INSERT INTO finance_users(dept_id, username) VALUES ('$dept_id', '$user') ON DUPLICATE KEY UPDATE dept_id=$dept_id ";
                $this->db->query($query2); 
                return "success";
            }
            else
            {
                return "Username not found";
            }    
            
        }
        
        public function show_crew_finance($id) {
            $dept_id = $this->get_finance_dept_id($id);
            $query2 = "SELECT u_d.*  FROM finance_users f_u, user_details u_d WHERE f_u.dept_id ='$dept_id' AND f_u.username = u_d.username ORDER BY id DESC";
            $result2 = $this->db->query($query2);
            return $result2->result_array();
        }
        
        public function fetch_tasks_finance($id) {
            $dept_id = $this->get_finance_dept_id($id);
            $query2 = "SELECT * FROM finance_tasks WHERE dept_id='$dept_id' ORDER BY id DESC";
            $result2 = $this->db->query($query2);
            return $result2->result_array();
        }
        
        public function add_task_finance($id, $task) {
            $dept_id = $this->get_finance_dept_id($id);
            $query2 = "INSERT INTO finance_tasks(dept_id, task_name) VALUES ('$dept_id', '$task')";
            $this->db->query($query2);           
            
        }  
        
        public function check_task_finance($id, $value, $name) {   
            if ($value == 1)
            {
                $query = "UPDATE finance_tasks SET completion = $value, completed_by='$name' WHERE id = $id ";
            }
            else
            {
                $query = "UPDATE finance_tasks SET completed_by = NULL, completion=0 WHERE id = $id";
            }
            $this->db->query($query);
        }

        public function assigned_to_finance($task_id, $user) { 
            if ($user == "NONE"){
                $query = "UPDATE finance_tasks SET assigned_to = NULL WHERE id = $task_id ";
            }  
            else {         
                $query = "UPDATE finance_tasks SET assigned_to = '$user' WHERE id = $task_id ";
                $query2 = "SELECT * FROM finance_notifications WHERE task_id=$task_id";
                $res = $this->db->query($query2);
                if (($res->num_rows()) == 0){
                    $query1 = "INSERT INTO finance_notifications(username, task_id, dismiss) VALUES ('$user', $task_id, 0)";
                }
                else {
                    $query1 = "UPDATE finance_notifications SET dismiss=0, username='$user' WHERE task_id=$task_id";
                }
                $this->db->query($query1);
            }
            $this->db->query($query);
            
        }
        
        public function get_notification_finance($user) {
            $query = "SELECT b.task_name, b.dept_id, c.name, c.pic, d.event FROM finance_notifications a, finance_tasks b, events c, finance_department d WHERE a.task_id = b.id AND b.dept_id = d.id AND d.event = c.id AND a.username = '$user'" ;
            
            $result = $this->db->query($query);
            return $result->result_array();
        }
        
        
        public function delete_task_finance($e, $t, $d, $o)
        {
            $query = $this->db->get_where( 'events', array('owner' => $o, 'id' => $e ) );
            $this->db->query($query);
            $result = $query->num_rows();   
                       
            if ($result == 0) {
                return false; 
            }
            else 
            {
                $query = "DELETE FROM finance_tasks WHERE id='$t' ";
                $this->db->query($query);
                return true;
            }                    
        }        
               
        public function delete_user_finance($e, $u, $o)
        {
            $query = $this->db->get_where( 'events', array('owner' => $o, 'id' => $e ) );
            $result = $query->num_rows(); 
            
                        
            if ($result == 0) {
                return false; 
            }
            else 
            {
                $dept_id = $this->get_finance_dept_id($e);                              
                $query = "DELETE FROM finance_users WHERE dept_id ='$dept_id' AND username = '$u'  ";
                $this->db->query($query);
               
                return true;
            }
                        
        }
        
        public function add_company_finance($event, $c_name, $c_address, $c_telephone, $c_email, $c_website)
        {
            $dept_id = $this->get_finance_dept_id($event);
            $query2 = "INSERT INTO finance_company(dept_id, c_name, c_address, c_telephone, c_email, c_website) VALUES ('$dept_id', '$c_name', '$c_address', '$c_telephone', '$c_email', '$c_website')";
            $this->db->query($query2);          
        }
        
        public function edit_company_finance($event, $c_id, $c_name, $c_address, $c_telephone, $c_email, $c_website)
        {
            $dept_id = $this->get_finance_dept_id($event);
            $query2 = "UPDATE finance_company SET c_name = '$c_name', c_address = '$c_address', c_telephone = '$c_telephone', c_email = '$c_email', c_website = '$c_website' WHERE id=$c_id AND dept_id=$dept_id";
            $this->db->query($query2);          
        }
        
        public function fetch_companies_finance($event) 
        {
            $dept_id = $this->get_finance_dept_id($event);
            $query2 = "SELECT * FROM finance_company WHERE dept_id='$dept_id' ORDER BY id DESC";
            $result2 = $this->db->query($query2);
            return $result2->result_array();
        }
        
        public function delete_company_finance($event, $company_id)
        {
            $dept_id = $this->get_finance_dept_id($event);
            $query = "DELETE FROM finance_company WHERE id=$company_id AND dept_id=$dept_id";
            $this->db->query($query);
        }
        
        public function add_transaction_finance($data) {
            $query= $this->db->insert('finance_budget',$data);           
        }
        
        public function get_income_finance($event) {
            $dept_id = $this->get_finance_dept_id($event);            
            $query = "SELECT * FROM finance_budget WHERE dept_id=$dept_id AND type='inc' ORDER BY date";
            $result = $this->db->query($query);
            return $result->result_array();
        }
        
        public function get_expenses_finance($event) {
            $dept_id = $this->get_finance_dept_id($event);            
            $query = "SELECT * FROM finance_budget WHERE dept_id=$dept_id AND type='exp' ORDER BY date";
            $result = $this->db->query($query);
            return $result->result_array();
        }
        
        public function delete_transaction_finance($event, $transaction_id, $type)
        {
            $dept_id = $this->get_finance_dept_id($event);    
            $query = "DELETE FROM finance_budget WHERE id=$transaction_id AND dept_id=$dept_id AND type='$type'";
            $this->db->query($query);
        }
        
        
        
        //Logistics dept
        
        public function get_logistics_dept_id($event_id) {
            $query = "SELECT id FROM logistics_department WHERE event='$event_id'";
            $dept_id = (($this->db->query($query))->row_array())['id'];  
            return $dept_id;
        }
        
        public function add_crew_logistics($id, $user) {
            $dept_id = $this->get_logistics_dept_id($id);
            if ( $this->db->query("SELECT * FROM users WHERE username='$user'")->num_rows() > 0 )
            {
                $query2 = "INSERT INTO logistics_users(dept_id, username) VALUES ('$dept_id', '$user') ON DUPLICATE KEY UPDATE dept_id=$dept_id ";
                $this->db->query($query2); 
                return "success";
            }
            else
            {
                return "Username not found";
            }    
              
            
        }
        
        public function show_crew_logistics($id) {
            $dept_id = $this->get_logistics_dept_id($id);
            $query2 = "SELECT u_d.*  FROM logistics_users f_u, user_details u_d WHERE f_u.dept_id ='$dept_id' AND f_u.username = u_d.username ORDER BY id DESC";
            $result2 = $this->db->query($query2);
            return $result2->result_array();
        }
        
        public function fetch_tasks_logistics($id) {
            $dept_id = $this->get_logistics_dept_id($id);
            $query2 = "SELECT * FROM logistics_tasks WHERE dept_id='$dept_id' ORDER BY id DESC";
            $result2 = $this->db->query($query2);
            return $result2->result_array();
        }
        
        public function add_task_logistics($id, $task) {
            $dept_id = $this->get_logistics_dept_id($id);
            $query2 = "INSERT INTO logistics_tasks(dept_id, task_name) VALUES ('$dept_id', '$task')";
            $this->db->query($query2);           
            
        }  
        
        public function check_task_logistics($id, $value, $name) {            
             if ($value == 1)
            {
                $query = "UPDATE logistics_tasks SET completion = $value, completed_by='$name' WHERE id = $id ";
            }
            else
            {
                $query = "UPDATE logistics_tasks SET completed_by = NULL, completion=0 WHERE id = $id";
            }
            $this->db->query($query);
        }
        
        public function delete_task_logistics($e, $t, $d, $o)
        {
            $query = $this->db->get_where( 'events', array('owner' => $o, 'id' => $e ) );
            $this->db->query($query);
            $result = $query->num_rows();   
                       
            if ($result == 0) {
                return false; 
            }
            else 
            {
                $query = "DELETE FROM logistics_tasks WHERE id='$t' ";
                $this->db->query($query);
                return true;
            }                    
        }        
               
        public function delete_user_logistics($e, $u, $o)
        {
            $query = $this->db->get_where( 'events', array('owner' => $o, 'id' => $e ) );
            $result = $query->num_rows(); 
            
                        
            if ($result == 0) {
                return false; 
            }
            else 
            {
                $dept_id = $this->get_logistics_dept_id($e);                              
                $query = "DELETE FROM logistics_users WHERE dept_id ='$dept_id' AND username = '$u'  ";
                $this->db->query($query);
               
                return true;
            }
                        
        }

        public function assigned_to_logistics($task_id, $user) { 
            if ($user == "NONE"){
                $query = "UPDATE logistics_tasks SET assigned_to = NULL WHERE id = $task_id ";
            }  
            else {         
                $query = "UPDATE logistics_tasks SET assigned_to = '$user' WHERE id = $task_id ";
                $query2 = "SELECT * FROM logistics_notifications WHERE task_id=$task_id";
                $res = $this->db->query($query2);
                if (($res->num_rows()) == 0){
                    $query1 = "INSERT INTO logistics_notifications(username, task_id, dismiss) VALUES ('$user', $task_id, 0)";
                }
                else {
                    $query1 = "UPDATE logistics_notifications SET dismiss=0, username='$user' WHERE task_id=$task_id";
                }
                $this->db->query($query1);
            }
            $this->db->query($query);
        }
        
        public function get_notification_logistics($user) {
            $query = "SELECT b.task_name, b.dept_id, c.name, d.event FROM logistics_notifications a, logistics_tasks b, events c, logistics_department d WHERE a.task_id = b.id AND b.dept_id = d.id AND d.event = c.id AND a.username = '$user'" ;
            
            $result = $this->db->query($query);
            return $result->result_array();
        }
        
        
        public function add_transaction_logistics($data) {
            $query= $this->db->insert('logistics_budget',$data);           
        }
        
        public function get_income_logistics($event) {
            $dept_id = $this->get_logistics_dept_id($event);            
            $query = "SELECT * FROM logistics_budget WHERE dept_id=$dept_id AND type='inc' ORDER BY date";
            $result = $this->db->query($query);
            return $result->result_array();
        }
        
        public function get_expenses_logistics($event) {
            $dept_id = $this->get_logistics_dept_id($event);            
            $query = "SELECT * FROM logistics_budget WHERE dept_id=$dept_id AND type='exp' ORDER BY date";
            $result = $this->db->query($query);
            return $result->result_array();
        }
        
        public function delete_transaction_logistics($event, $transaction_id, $type)
        {
            $dept_id = $this->get_logistics_dept_id($event);    
            $query = "DELETE FROM logistics_budget WHERE id=$transaction_id AND dept_id=$dept_id AND type='$type'";
            $this->db->query($query);
        }
        
        //Decorations dept
        
        public function get_decorations_dept_id($event_id) {
            $query = "SELECT id FROM decorations_department WHERE event='$event_id'";
            $dept_id = (($this->db->query($query))->row_array())['id'];  
            return $dept_id;
        }
        
        public function add_crew_decorations($id, $user) {
            $dept_id = $this->get_decorations_dept_id($id);
            if ( $this->db->query("SELECT * FROM users WHERE username='$user'")->num_rows() > 0 )
            {
                $query2 = "INSERT INTO decorations_users(dept_id, username) VALUES ('$dept_id', '$user') ON DUPLICATE KEY UPDATE dept_id=$dept_id ";
                $this->db->query($query2); 
                return "success";
            }
            else
            {
                return "Username not found";
            }    
                
            
        }
        
        public function show_crew_decorations($id) {
            $dept_id = $this->get_decorations_dept_id($id);
            $query2 = "SELECT u_d.*  FROM decorations_users f_u, user_details u_d WHERE f_u.dept_id ='$dept_id' AND f_u.username = u_d.username ORDER BY id DESC";
            $result2 = $this->db->query($query2);
            return $result2->result_array();
        }
        
        public function fetch_tasks_decorations($id) {
            $dept_id = $this->get_decorations_dept_id($id);
            $query2 = "SELECT * FROM decorations_tasks WHERE dept_id='$dept_id' ORDER BY id DESC";
            $result2 = $this->db->query($query2);
            return $result2->result_array();
        }
        
        public function add_task_decorations($id, $task) {
            $dept_id = $this->get_decorations_dept_id($id);
            $query2 = "INSERT INTO decorations_tasks(dept_id, task_name) VALUES ('$dept_id', '$task')";
            $this->db->query($query2);           
            
        }  
        
        public function check_task_decorations($id, $value, $name) {            
             if ($value == 1)
            {
                $query = "UPDATE decorations_tasks SET completion = $value, completed_by='$name' WHERE id = $id ";
            }
            else
            {
                $query = "UPDATE decorations_tasks SET completed_by = NULL, completion=0 WHERE id = $id";
            }
            $this->db->query($query);
        }
        
        public function delete_task_decorations($e, $t, $d, $o)
        {
            $query = $this->db->get_where( 'events', array('owner' => $o, 'id' => $e ) );
            $this->db->query($query);
            $result = $query->num_rows();   
                       
            if ($result == 0) {
                return false; 
            }
            else 
            {
                $query = "DELETE FROM decorations_tasks WHERE id='$t' ";
                $this->db->query($query);
                return true;
            }                    
        }        
               
        public function delete_user_decorations($e, $u, $o)
        {
            $query = $this->db->get_where( 'events', array('owner' => $o, 'id' => $e ) );
            $result = $query->num_rows(); 
            
                        
            if ($result == 0) {
                return false; 
            }
            else 
            {
                $dept_id = $this->get_decorations_dept_id($e);
                              
                $query = "DELETE FROM decorations_users WHERE dept_id ='$dept_id' AND username = '$u'  ";
                $this->db->query($query);
               
                return true;
            }
                        
        }

        public function assigned_to_decorations($task_id, $user) { 
           if ($user == "NONE"){
                $query = "UPDATE decorations_tasks SET assigned_to = NULL WHERE id = $task_id ";
            }  
            else {         
                $query = "UPDATE decorations_tasks SET assigned_to = '$user' WHERE id = $task_id ";
                $query2 = "SELECT * FROM decorations_notifications WHERE task_id=$task_id";
                $res = $this->db->query($query2);
                if (($res->num_rows()) == 0){
                    $query1 = "INSERT INTO decorations_notifications(username, task_id, dismiss) VALUES ('$user', $task_id, 0)";
                }
                else {
                    $query1 = "UPDATE decorations_notifications SET dismiss=0, username='$user' WHERE task_id=$task_id";
                }
                $this->db->query($query1);
            }
            $this->db->query($query);
        }
        
        public function get_notification_decorations($user) {
            $query = "SELECT b.task_name, b.dept_id, c.name, d.event FROM decorations_notifications a, decorations_tasks b, events c, decorations_department d WHERE a.task_id = b.id AND b.dept_id = d.id AND d.event = c.id AND a.username = '$user'" ;
            
            $result = $this->db->query($query);
            return $result->result_array();
        }
        
        
        public function add_transaction_decorations($data) {
            $query= $this->db->insert('decorations_budget',$data);
            $query1 = "INSERT INTO decorations_notifications(username, task_id) VALUES ('$user', '$task_id')";
            $this->db->query($query1);
        }
        
        public function get_income_decorations($event) {
            $dept_id = $this->get_decorations_dept_id($event);            
            $query = "SELECT * FROM decorations_budget WHERE dept_id=$dept_id AND type='inc' ORDER BY date";
            $result = $this->db->query($query);
            return $result->result_array();
        }
        
        public function get_expenses_decorations($event) {
            $dept_id = $this->get_decorations_dept_id($event);            
            $query = "SELECT * FROM decorations_budget WHERE dept_id=$dept_id AND type='exp' ORDER BY date";
            $result = $this->db->query($query);
            return $result->result_array();
        }
        
        public function delete_transaction_decorations($event, $transaction_id, $type)
        {
            $dept_id = $this->get_decorations_dept_id($event);    
            $query = "DELETE FROM decorations_budget WHERE id=$transaction_id AND dept_id=$dept_id AND type='$type'";
            $this->db->query($query);
        }
        
        //Marketing Dept
        public function get_marketing_dept_id($event_id) {
            $query = "SELECT id FROM marketing_department WHERE event='$event_id'";
            $dept_id = (($this->db->query($query))->row_array())['id'];  
            return $dept_id;
        }
        
        
        public function add_crew_marketing($id, $user) {
             $dept_id = $this->get_marketing_dept_id($id);
            if ( $this->db->query("SELECT * FROM users WHERE username='$user'")->num_rows() > 0 )
            {
                $query2 = "INSERT INTO marketing_users(dept_id, username) VALUES ('$dept_id', '$user') ON DUPLICATE KEY UPDATE dept_id=$dept_id ";
                $this->db->query($query2); 
                return "success";
            }
            else
            {
                return "Username not found";
            }    
                       
            
        }
        
        public function show_crew_marketing($id) {
            $dept_id = $this->get_marketing_dept_id($id);
            $query2 = "SELECT u_d.*  FROM marketing_users f_u, user_details u_d WHERE f_u.dept_id ='$dept_id' AND f_u.username = u_d.username ORDER BY id DESC";
            $result2 = $this->db->query($query2);
            return $result2->result_array();
        }
        
        public function fetch_tasks_marketing($id) {
            $dept_id = $this->get_marketing_dept_id($id);
            $query2 = "SELECT * FROM marketing_tasks WHERE dept_id='$dept_id' ORDER BY id DESC";
            $result2 = $this->db->query($query2);
            return $result2->result_array();
        }
        
        public function add_task_marketing($id, $task) {
            $dept_id = $this->get_marketing_dept_id($id);
            $query2 = "INSERT INTO marketing_tasks(dept_id, task_name) VALUES ('$dept_id', '$task')";
            $this->db->query($query2);           
            
        }  
        
        public function check_task_marketing($id, $value, $name) {            
             if ($value == 1)
            {
                $query = "UPDATE marketing_tasks SET completion = $value, completed_by='$name' WHERE id = $id ";
            }
            else
            {
                $query = "UPDATE marketing_tasks SET completed_by = NULL, completion=0 WHERE id = $id";
            }
            $this->db->query($query);
        }
        
        public function delete_task_marketing($e, $t, $d, $o)
        {
            $query = $this->db->get_where( 'events', array('owner' => $o, 'id' => $e ) );
            $this->db->query($query);
            $result = $query->num_rows();   
                       
            if ($result == 0) {
                return false; 
            }
            else 
            {
                $query = "DELETE FROM marketing_tasks WHERE id='$t' ";
                $this->db->query($query);
                return true;
            }                    
        }        
               
        public function delete_user_marketing($e, $u, $o)
        {
            $query = $this->db->get_where( 'events', array('owner' => $o, 'id' => $e ) );           
            $result = $query->num_rows(); 
            
                        
            if ($result == 0) {
                return false; 
            }
            else 
            {
                $dept_id = $this->get_marketing_dept_id($e);                              
                $query = "DELETE FROM marketing_users WHERE dept_id ='$dept_id' AND username = '$u'  ";
                $this->db->query($query);
               
                return true;
            }
                        
        }

        public function assigned_to_marketing($task_id, $user) { 
            if ($user == "NONE"){
                $query = "UPDATE marketing_tasks SET assigned_to = NULL WHERE id = $task_id ";
            }  
            else {         
                $query = "UPDATE marketing_tasks SET assigned_to = '$user' WHERE id = $task_id ";
                $query2 = "SELECT * FROM marketing_notifications WHERE task_id=$task_id";
                $res = $this->db->query($query2);
                if (($res->num_rows()) == 0){
                    $query1 = "INSERT INTO marketing_notifications(username, task_id, dismiss) VALUES ('$user', $task_id, 0)";
                }
                else {
                    $query1 = "UPDATE marketing_notifications SET dismiss=0, username='$user' WHERE task_id=$task_id";
                }
                $this->db->query($query1);
            }
            $this->db->query($query);
        }
        
        public function get_notification_marketing($user) {
            $query = "SELECT b.task_name, b.dept_id, c.name, d.event FROM marketing_notifications a, decorations_tasks b, events c, marketing_department d WHERE a.task_id = b.id AND b.dept_id = d.id AND d.event = c.id AND a.username = '$user'" ;
            
            $result = $this->db->query($query);
            return $result->result_array();
        }
        
        
        public function add_transaction_marketing($data) {
            $query= $this->db->insert('marketing_budget',$data);           
        }
        
        public function get_income_marketing($event) {
            $dept_id = $this->get_marketing_dept_id($event);            
            $query = "SELECT * FROM marketing_budget WHERE dept_id=$dept_id AND type='inc' ORDER BY date";
            $result = $this->db->query($query);
            return $result->result_array();
        }
        
        public function get_expenses_marketing($event) {
            $dept_id = $this->get_marketing_dept_id($event);            
            $query = "SELECT * FROM marketing_budget WHERE dept_id=$dept_id AND type='exp' ORDER BY date";
            $result = $this->db->query($query);
            return $result->result_array();
        }
        
        public function delete_transaction_marketing($event, $transaction_id, $type)
        {
            $dept_id = $this->get_marketing_dept_id($event);    
            $query = "DELETE FROM marketing_budget WHERE id=$transaction_id AND dept_id=$dept_id AND type='$type'";
            $this->db->query($query);
        }
        
        
        //Sales
        public function get_sales_dept_id($event_id) {
            $query = "SELECT id FROM sales_department WHERE event='$event_id'";
            $dept_id = (($this->db->query($query))->row_array())['id'];  
            return $dept_id;
        }        
        public function add_crew_sales($id, $user) {
            $dept_id = $this->get_sales_dept_id($id);
            if ( $this->db->query("SELECT * FROM users WHERE username='$user'")->num_rows() > 0 )
            {
                $query2 = "INSERT INTO sales_users(dept_id, username) VALUES ('$dept_id', '$user') ON DUPLICATE KEY UPDATE dept_id=$dept_id ";
                $this->db->query($query2); 
                return "success";
            }
            else
            {
                return "Username not found";
            }    
                     
            
        }
        
        public function show_crew_sales($id) {
            $dept_id = $this->get_sales_dept_id($id);
            $query2 = "SELECT u_d.*  FROM sales_users f_u, user_details u_d WHERE f_u.dept_id ='$dept_id' AND f_u.username = u_d.username ORDER BY id DESC";
            $result2 = $this->db->query($query2);
            return $result2->result_array();
        }
        
        public function fetch_tasks_sales($id) {
            $dept_id = $this->get_sales_dept_id($id);
            $query2 = "SELECT * FROM sales_tasks WHERE dept_id='$dept_id' ORDER BY id DESC";
            $result2 = $this->db->query($query2);
            return $result2->result_array();
        }
        
        public function add_task_sales($id, $task) {
            $dept_id = $this->get_sales_dept_id($id);
            $query2 = "INSERT INTO sales_tasks(dept_id, task_name) VALUES ('$dept_id', '$task')";
            $this->db->query($query2);           
            
        }  
        
        public function check_task_sales($id, $value, $name) {            
             if ($value == 1)
            {
                $query = "UPDATE sales_tasks SET completion = $value, completed_by='$name' WHERE id = $id ";
            }
            else
            {
                $query = "UPDATE sales_tasks SET completed_by = NULL, completion=0 WHERE id = $id";
            }
            $this->db->query($query);
        }
        
        public function delete_task_sales($e, $t, $d, $o)
        {
            $query = $this->db->get_where( 'events', array('owner' => $o, 'id' => $e ) );
            $this->db->query($query);
            $result = $query->num_rows();   
                       
            if ($result == 0) {
                return false; 
            }
            else 
            {
                $query = "DELETE FROM sales_tasks WHERE id='$t' ";
                $this->db->query($query);
                return true;
            }                    
        }        
               
        public function delete_user_sales($e, $u, $o)
        {
            $query = $this->db->get_where( 'events', array('owner' => $o, 'id' => $e ) );
            $this->db->query($query);
            $result = $query->num_rows();            
                        
            if ($result == 0) {
                return false; 
            }
            else 
            {
                $dept_id = $this->get_sales_dept_id($e);                              
                $query = "DELETE FROM sales_users WHERE dept_id ='$i' AND username = '$u'  ";
                $this->db->query($query);               
                return true;
            }
                        
        }

        public function assigned_to_sales($task_id, $user) { 
             if ($user == "NONE"){
                $query = "UPDATE sales_tasks SET assigned_to = NULL WHERE id = $task_id ";
            }  
            else {         
                $query = "UPDATE sales_tasks SET assigned_to = '$user' WHERE id = $task_id ";
                $query2 = "SELECT * FROM sales_notifications WHERE task_id=$task_id";
                $res = $this->db->query($query2);
                if (($res->num_rows()) == 0){
                    $query1 = "INSERT INTO sales_notifications(username, task_id, dismiss) VALUES ('$user', $task_id, 0)";
                }
                else {
                    $query1 = "UPDATE sales_notifications SET dismiss=0, username='$user' WHERE task_id=$task_id";
                }
                $this->db->query($query1);
            }
            $this->db->query($query);
        }
        
        public function get_notification_sales($user) {
            $query = "SELECT b.task_name, b.dept_id, c.name, d.event FROM sales_notifications a, sales_tasks b, events c, sales_department d WHERE a.task_id = b.id AND b.dept_id = d.id AND d.event = c.id AND a.username = '$user'" ;
            
            $result = $this->db->query($query);
            return $result->result_array();
        }
        
        
        public function add_transaction_sales($data) {
            $query= $this->db->insert('sales_budget',$data);           
        }
        
        public function get_income_sales($event) {
            $dept_id = $this->get_sales_dept_id($event);            
            $query = "SELECT * FROM sales_budget WHERE dept_id=$dept_id AND type='inc' ORDER BY date";
            $result = $this->db->query($query);
            return $result->result_array();
        }
        
        public function get_expenses_sales($event) {
            $dept_id = $this->get_sales_dept_id($event);            
            $query = "SELECT * FROM sales_budget WHERE dept_id=$dept_id AND type='exp' ORDER BY date";
            $result = $this->db->query($query);
            return $result->result_array();
        }
        
        public function delete_transaction_sales($event, $transaction_id, $type)
        {
            $dept_id = $this->get_sales_dept_id($event);    
            $query = "DELETE FROM sales_budget WHERE id=$transaction_id AND dept_id=$dept_id AND type='$type'";
            $this->db->query($query);
        }
        
        //registrations dept
        public function get_registrations_dept_id($event_id) {
            $query = "SELECT id FROM registrations_department WHERE event='$event_id'";
            $dept_id = (($this->db->query($query))->row_array())['id'];  
            return $dept_id;
        }
        
        public function add_crew_registrations($id, $user) {
             $dept_id = $this->get_registrations_dept_id($id);
            if ( $this->db->query("SELECT * FROM users WHERE username='$user'")->num_rows() > 0 )
            {
                $query2 = "INSERT INTO registrations_users(dept_id, username) VALUES ('$dept_id', '$user') ON DUPLICATE KEY UPDATE dept_id=$dept_id ";
                $this->db->query($query2); 
                return "success";
            }
            else
            {
                return "Username not found";
            }    
                    
            
        }
        
        public function show_crew_registrations($id) {
            $dept_id = $this->get_registrations_dept_id($id);
            $query2 = "SELECT u_d.*  FROM registrations_users f_u, user_details u_d WHERE f_u.dept_id ='$dept_id' AND f_u.username = u_d.username ORDER BY id DESC";
            $result2 = $this->db->query($query2);
            return $result2->result_array();
        }
        
        public function fetch_tasks_registrations($id) {
            $dept_id = $this->get_registrations_dept_id($id);
            $query2 = "SELECT * FROM registrations_tasks WHERE dept_id='$dept_id' ORDER BY id DESC";
            $result2 = $this->db->query($query2);
            return $result2->result_array();
        }
        
        public function add_task_registrations($id, $task) {
            $dept_id = $this->get_registrations_dept_id($id);
            $query2 = "INSERT INTO registrations_tasks(dept_id, task_name) VALUES ('$dept_id', '$task')";
            $this->db->query($query2);           
            
        }  
        
        public function check_task_registrations($id, $value, $name) {            
             if ($value == 1)
            {
                $query = "UPDATE registrations_tasks SET completion = $value, completed_by='$name' WHERE id = $id ";
            }
            else
            {
                $query = "UPDATE registrations_tasks SET completed_by = NULL, completion=0 WHERE id = $id";
            }
            $this->db->query($query);
        }
        
        public function delete_task_registrations($e, $t, $d, $o)
        {
            $query = $this->db->get_where( 'events', array('owner' => $o, 'id' => $e ) );
            $this->db->query($query);
            $result = $query->num_rows();   
                       
            if ($result == 0) {
                return false; 
            }
            else 
            {
                $query = "DELETE FROM registrations_tasks WHERE id='$t' ";
                $this->db->query($query);
                return true;
            }                    
        }        
               
        public function delete_user_registrations($e, $u, $o)
        {
            $query = $this->db->get_where( 'events', array('owner' => $o, 'id' => $e ) );
            $result = $query->num_rows();             
                        
            if ($result == 0) {
                return false; 
            }
            else 
            {
                $dept_id = $this->get_registrations_dept_id($e);                             
                $query = "DELETE FROM registrations_users WHERE dept_id ='$dept_id' AND username = '$u' ";
                $this->db->query($query);               
                return true;
            }
                        
        }

        public function assigned_to_registrations($task_id, $user) { 
             if ($user == "NONE"){
                $query = "UPDATE registrations_tasks SET assigned_to = NULL WHERE id = $task_id ";
            }  
            else {         
                $query = "UPDATE registrations_tasks SET assigned_to = '$user' WHERE id = $task_id ";
                $query2 = "SELECT * FROM registrations_notifications WHERE task_id=$task_id";
                $res = $this->db->query($query2);
                if (($res->num_rows()) == 0){
                    $query1 = "INSERT INTO registrations_notifications(username, task_id, dismiss) VALUES ('$user', $task_id, 0)";
                }
                else {
                    $query1 = "UPDATE registrations_notifications SET dismiss=0, username='$user' WHERE task_id=$task_id";
                }
                $this->db->query($query1);
            }
            $this->db->query($query);
        }
        
         public function get_notification_registrations($user) {
            $query = "SELECT b.task_name, b.dept_id, c.name, d.event FROM registrations_notifications a, sales_tasks b, events c, registrations_department d WHERE a.task_id = b.id AND b.dept_id = d.id AND d.event = c.id AND a.username = '$user'" ;
            
            $result = $this->db->query($query);
            return $result->result_array();
        }
        
        public function get_confirmed_registrations($id)
        {
            $dept_id = $this->get_registrations_dept_id($id); 
            //$query = $this->db->get_where( 'registrations_rsvp', array('dept_id' => $dept_id, 'confirmed' => 1 ) );
            $q = "SELECT * FROM registrations_rsvp WHERE dept_id = $dept_id AND confirmed=1 ORDER BY name";
            $query = $this->db->query($q);
            $data['total'] = $query->num_rows();
            $data['confirmed'] = $query->result_array();
            return $data;
            
        }
        
         public function check_attendance_registrations($id, $value) {            
            $query = "UPDATE registrations_rsvp SET attended=$value WHERE id=$id ";
            $this->db->query($query);
        }



        //All Departments
        public function get_department_progress($id)
        {
            //finance dept           
            $finance_dept_id = $this->get_finance_dept_id($id);  

            if ($finance_dept_id != null) {
                $finance_query2 = "SELECT * FROM finance_tasks WHERE dept_id=$finance_dept_id";
                $finance_tot_tasks = ($this->db->query($finance_query2))->num_rows();   
                
                if ($finance_tot_tasks > 0) {
                    $finance_query3 = "SELECT * FROM finance_tasks WHERE dept_id=$finance_dept_id AND completion=1";
                    $finance_completed_tasks = ($this->db->query($finance_query3))->num_rows();  
    
                    $finance_percentage = ($finance_completed_tasks/$finance_tot_tasks)*100;
                }
                else {
                    $finance_percentage = 0;
                }                      
            }
            else {
                $finance_percentage = 0;
            }  

            //decorations            
            $decorations_dept_id = $this->get_decorations_dept_id($id);   

            if ($decorations_dept_id != null) {
                $decorations_query2 = "SELECT * FROM decorations_tasks WHERE dept_id=$decorations_dept_id";
                $decorations_tot_tasks = ($this->db->query($decorations_query2))->num_rows();   
                
                if ($decorations_tot_tasks > 0) {
                    $decorations_query3 = "SELECT * FROM decorations_tasks WHERE dept_id=$decorations_dept_id AND completion=1";
                    $decorations_completed_tasks = ($this->db->query($decorations_query3))->num_rows();  
    
                    $decorations_percentage = ($decorations_completed_tasks/$decorations_tot_tasks)*100;
                }
                else {
                    $decorations_percentage = 0;
                }                      
            }
            else {
                $decorations_percentage = 0;
            }     
            
            //logistics            
            $logistics_dept_id = $this->get_logistics_dept_id($id);  
            
            if ($logistics_dept_id != null) {
                $logistics_query2 = "SELECT * FROM logistics_tasks WHERE dept_id=$logistics_dept_id";
                $logistics_tot_tasks = ($this->db->query($logistics_query2))->num_rows();   
                
                if ($logistics_tot_tasks > 0) {
                    $logistics_query3 = "SELECT * FROM logistics_tasks WHERE dept_id=$logistics_dept_id AND completion=1";
                    $logistics_completed_tasks = ($this->db->query($logistics_query3))->num_rows();  
    
                    $logistics_percentage = ($logistics_completed_tasks/$logistics_tot_tasks)*100;
                }
                else {
                    $logistics_percentage = 0;
                }                      
            }
            else {
                $logistics_percentage = 0;
            }       
            
            //marketing
            $marketing_dept_id = $this->get_marketing_dept_id($id); 
            
            if ($marketing_dept_id != null) {
                $marketing_query2 = "SELECT * FROM marketing_tasks WHERE dept_id=$marketing_dept_id";
                $marketing_tot_tasks = ($this->db->query($marketing_query2))->num_rows();   
                
                if ($marketing_tot_tasks > 0) {
                    $marketing_query3 = "SELECT * FROM marketing_tasks WHERE dept_id=$marketing_dept_id AND completion=1";
                    $marketing_completed_tasks = ($this->db->query($marketing_query3))->num_rows();  
    
                    $marketing_percentage = ($marketing_completed_tasks/$marketing_tot_tasks)*100;
                }
                else {
                    $marketing_percentage = 0;
                }                      
            }
            else {
                $marketing_percentage = 0;
            }
            
            //registrations            
            $registrations_dept_id = $this->get_registrations_dept_id($id);  

            if ($registrations_dept_id != null) {
                $registrations_query2 = "SELECT * FROM registrations_tasks WHERE dept_id=$registrations_dept_id";
                $registrations_tot_tasks = ($this->db->query($registrations_query2))->num_rows();   
                
                if ($registrations_tot_tasks > 0) {
                    $registrations_query3 = "SELECT * FROM registrations_tasks WHERE dept_id=$registrations_dept_id AND completion=1";
                    $registrations_completed_tasks = ($this->db->query($registrations_query3))->num_rows();  
    
                    $registrations_percentage = ($registrations_completed_tasks/$registrations_tot_tasks)*100;
                }
                else {
                    $registrations_percentage = 0;
                }                      
            }
            else {
                $registrations_percentage = 0;
            } 
            
            //sales
         
            $sales_dept_id = $this->get_sales_dept_id($id);  

            if ($sales_dept_id != null) {
                $sales_query2 = "SELECT * FROM sales_tasks WHERE dept_id=$sales_dept_id";
                $sales_tot_tasks = ($this->db->query($sales_query2))->num_rows();   
                
                if ($sales_tot_tasks > 0) {
                    $sales_query3 = "SELECT * FROM sales_tasks WHERE dept_id=$sales_dept_id AND completion=1";
                    $sales_completed_tasks = ($this->db->query($sales_query3))->num_rows();  
    
                    $sales_percentage = ($sales_completed_tasks/$sales_tot_tasks)*100;
                }
                else {
                    $sales_percentage = 0;
                }                      
            }
            else {
                $sales_percentage = 0;
            }         
            
            
            return array(
                'finance' => $finance_percentage, 
                'decorations' => $decorations_percentage,
                'logistics' => $logistics_percentage,
                'marketing' => $marketing_percentage,
                'registrations' => $registrations_percentage,
                'sales' => $sales_percentage
            );
       }

        public function test($e){
            $sql = "INSERT INTO test(data) VALUES ('$e')";
            $this->db->query($sql);    
        }
        
        public function summary($id)
        {
            $query = $this->db->get_where( 'events', array('id' => $id) );
            return $query->row_array();
        }
        
        ///////RSVP/////
        public function register_rsvp($data)
        {
            $query = $this->db->get_where( 'registrations_rsvp', array('email' => $data['email'], 'dept_id' => $data['dept_id']) );
            $num = $query->num_rows();
            
            if ($num == 0){
                $query= $this->db->insert('registrations_rsvp',$data);    
                return "Successfully registered! Please await for the confirmation email from the event organizers.";
            }
            else {
                return "The entered email is already registered. Please use a different email.";
            }
             
        }
        
        public function set_target_rsvp($target, $id)
        {
            $sql = "UPDATE registrations_department SET target=$target WHERE event=$id";
            $this->db->query($sql);    
            
        }
        
        public function get_target_rsvp($id)
        {
            $dept_id = $this->get_registrations_dept_id($id);
            $sql = "SELECT target FROM registrations_department WHERE event=$id AND id=$dept_id ";
            return $this->db->query($sql)->row_array();
            
        }
        
        public function get_responses($id)
        {
            $dept_id = $this->get_registrations_dept_id($id);
            $sql = "SELECT * FROM registrations_rsvp WHERE dept_id=$dept_id";
            $result = $this->db->query($sql);
            $data['current'] = $result->num_rows();
            $data['responses'] = $result->result_array();
            return $data;
        }
        
        public function check_confirmation_rsvp($id, $value) {            
            $query = "UPDATE registrations_rsvp SET confirmed=$value WHERE id=$id ";
            $this->db->query($query);
        }
        
        public function check_all_confirmation_rsvp($id) {             
            $dept_id = $this->get_registrations_dept_id($id);
            $this->test($dept_id);
            $query = "UPDATE registrations_rsvp SET confirmed=1 WHERE dept_id=$dept_id ";
            $this->db->query($query);
        }
        
        public function view_other_events($user) {
            $query = "SELECT * FROM finance_users WHERE username='$user'";
            $result = $this->db->query($query);
            return $result->result_array();
            
        }
        
        public function get_confirm_emails($id) {
            $dept_id = $this->get_registrations_dept_id($id);
            $query = "SELECT email FROM registrations_rsvp WHERE confirmed=1 AND dept_id=$dept_id";
            $result = $this->db->query($query);
            return $result->result_array();
        }
        
        public function get_thankyou_emails($id) {
            $dept_id = $this->get_registrations_dept_id($id);
            $query = "SELECT email FROM registrations_rsvp WHERE confirmed=1 AND attended=1 AND dept_id=$dept_id";
            $result = $this->db->query($query);
            return $result->result_array();
        }
        
        
        //////////////////////////////// Collaborations ///////////////////////////////
        
        public function get_collab_depts($user) {             
            $query = "
            SELECT 'logistics' AS dept_name, e.pic, e.name, d.id AS dept_id, d.event FROM logistics_users u, logistics_department d, events e WHERE u.username = '$user' AND u.dept_id = d.id AND d.event = e.id
            UNION
            SELECT 'finance' AS dept_name, e.pic, e.name, d.id AS dept_id, d.event FROM finance_users u, finance_department d, events e WHERE u.username = '$user' AND u.dept_id = d.id AND d.event = e.id
            UNION
            SELECT 'sales' AS dept_name, e.pic, e.name, d.id AS dept_id, d.event FROM sales_users u, sales_department d, events e WHERE u.username = '$user' AND u.dept_id = d.id AND d.event = e.id
            UNION
            SELECT 'decorations' AS dept_name, e.pic, e.name, d.id AS dept_id, d.event FROM decorations_users u, decorations_department d, events e WHERE u.username = '$user' AND u.dept_id = d.id AND d.event = e.id
            UNION
            SELECT 'marketing' AS dept_name, e.pic, e.name, d.id AS dept_id, d.event FROM marketing_users u, marketing_department d, events e WHERE u.username = '$user' AND u.dept_id = d.id AND d.event = e.id
            UNION
            SELECT 'registrations' AS dept_name, e.pic, e.name, d.id AS dept_id, d.event FROM registrations_users u, registrations_department d, events e WHERE u.username = '$user' AND u.dept_id = d.id AND d.event = e.id" ; 
            
            $result = $this->db->query($query);
            return $result->result_array();
        
        }
        //// Not Dismissed notifications (new ones)
        public function get_notifications($user) {
            $query = "
            SELECT 'finance' AS dept_name, b.task_name, b.dept_id, c.name, c.pic, d.event FROM finance_notifications a, finance_tasks b, events c, finance_department d WHERE a.task_id = b.id AND b.dept_id = d.id AND d.event = c.id AND a.username = '$user' AND a.dismiss=0 AND b.completion = 0
            UNION
            SELECT 'logistics' AS dept_name, b.task_name, b.dept_id, c.name, c.pic, d.event FROM logistics_notifications a, logistics_tasks b, events c, logistics_department d WHERE a.task_id = b.id AND b.dept_id = d.id AND d.event = c.id AND a.username = '$user' AND a.dismiss=0 AND b.completion = 0
            UNION
            SELECT 'sales' AS dept_name, b.task_name, b.dept_id, c.name, c.pic, d.event FROM sales_notifications a, sales_tasks b, events c, sales_department d WHERE a.task_id = b.id AND b.dept_id = d.id AND d.event = c.id AND a.username = '$user' AND a.dismiss=0 AND b.completion = 0
            UNION
            SELECT 'decorations' AS dept_name, b.task_name, b.dept_id, c.name, c.pic, d.event FROM decorations_notifications a, decorations_tasks b, events c, decorations_department d WHERE a.task_id = b.id AND b.dept_id = d.id AND d.event = c.id AND a.username = '$user' AND a.dismiss=0 AND b.completion = 0
            UNION
            SELECT 'marketing' AS dept_name, b.task_name, b.dept_id, c.name, c.pic, d.event FROM marketing_notifications a, marketing_tasks b, events c, marketing_department d WHERE a.task_id = b.id AND b.dept_id = d.id AND d.event = c.id AND a.username = '$user' AND a.dismiss=0 AND b.completion = 0
            UNION
            SELECT 'registrations' AS dept_name, b.task_name, b.dept_id, c.name, c.pic, d.event FROM registrations_notifications a, registrations_tasks b, events c, registrations_department d WHERE a.task_id = b.id AND b.dept_id = d.id AND d.event = c.id AND a.username = '$user' AND a.dismiss=0 AND b.completion = 0              
            ";
            
            $result = $this->db->query($query);
            return $result->result_array();
        }
        
        //// All notifications (dismissed + not dismissed)
        public function get_notifications_all($user) {
            $query = "
            (SELECT 'finance' AS dept_name, b.completion, b.task_name, b.dept_id, c.name, c.pic, d.event FROM finance_notifications a, finance_tasks b, events c, finance_department d WHERE a.task_id = b.id AND b.dept_id = d.id AND d.event = c.id AND a.username = '$user' ORDER BY b.completion )
            UNION
            (SELECT 'logistics' AS dept_name, b.completion, b.task_name, b.dept_id, c.name, c.pic, d.event FROM logistics_notifications a, logistics_tasks b, events c, logistics_department d WHERE a.task_id = b.id AND b.dept_id = d.id AND d.event = c.id AND a.username = '$user' ORDER BY b.completion)
            UNION
            (SELECT 'sales' AS dept_name, b.completion, b.task_name, b.dept_id, c.name, c.pic, d.event FROM sales_notifications a, sales_tasks b, events c, sales_department d WHERE a.task_id = b.id AND b.dept_id = d.id AND d.event = c.id AND a.username = '$user' ORDER BY b.completion)
            UNION
            (SELECT 'decorations' AS dept_name, b.completion, b.task_name, b.dept_id, c.name, c.pic, d.event FROM decorations_notifications a, decorations_tasks b, events c, decorations_department d WHERE a.task_id = b.id AND b.dept_id = d.id AND d.event = c.id AND a.username = '$user' ORDER BY b.completion)
            UNION
            (SELECT 'marketing' AS dept_name, b.completion, b.task_name, b.dept_id, c.name, c.pic, d.event FROM marketing_notifications a, marketing_tasks b, events c, marketing_department d WHERE a.task_id = b.id AND b.dept_id = d.id AND d.event = c.id AND a.username = '$user' ORDER BY b.completion)
            UNION
            (SELECT 'registrations' AS dept_name, b.completion, b.task_name, b.dept_id, c.name, c.pic, d.event FROM registrations_notifications a, registrations_tasks b, events c, registrations_department d WHERE a.task_id = b.id AND b.dept_id = d.id AND d.event = c.id AND a.username = '$user' ORDER BY b.completion)               
            ";
            
            $result = $this->db->query($query);
            return $result->result_array();
        }
        
        public function mark_read($user) {
            $this->db->trans_start();
            $this->db->query("UPDATE decorations_notifications SET dismiss=1 WHERE username='$user'");
            $this->db->query("UPDATE sales_notifications SET dismiss=1 WHERE username='$user'");
            $this->db->query("UPDATE registrations_notifications SET dismiss=1 WHERE username='$user'");
            $this->db->query("UPDATE marketing_notifications SET dismiss=1 WHERE username='$user'");
            $this->db->query("UPDATE logistics_notifications SET dismiss=1 WHERE username='$user'");
            $this->db->query("UPDATE finance_notifications SET dismiss=1 WHERE username='$user'");           
            $this->db->trans_complete();
           
        }
        
        
        /////////////////////////// SEARCH
        
    function search_events($name)
    {
        $query = "SELECT e.*, u.fname, u.lname FROM events e, user_details u WHERE e.name LIKE '%$name%' AND     e.owner = u.username";        
        $result = $this->db->query($query);
        return $result->result_array();
    }
        
    function search_vendors($name)
    {
        $query = "SELECT id, name, address, category, pic FROM vendors WHERE name LIKE '%$name%' OR category LIKE '%$name%' OR address LIKE '%$name%'";        
        $result = $this->db->query($query);
        return $result->result_array();
    }
        
    function send_collab_email($event, $user)
    {
        $query = "SELECT u.email, e.name FROM events e, user_details u WHERE e.id = $event AND e.owner = u.username";        
        $result = $this->db->query($query);
        $row['email'] = $result->row_array();
        $query2 = "SELECT fname, lname, email, username FROM user_details WHERE username = '$user'";        
        $result2 = $this->db->query($query2);
        $row['details'] = $result2->row_array();
        return $row;
    }
        
    function add_vendor($data)
    {
        $query= $this->db->insert('vendors',$data);           
        
    }
        
    function get_my_businesses($user)
    {
        $query= $this->db->get_where('vendors',array( 'owner' => $user));
        return $query->result_array();
    }
        
    function get_business($id)
    {
        $query= $this->db->get_where('vendors',array( 'id' => $id));
        return $query->row_array();
    }
        
    function delete_business($id, $user)
    {
        $this->db->delete('vendors', array('id' => $id, 'owner' => $user)); 
    }
        
    function search_admin_events($name)
    {
        $query = "SELECT e.*, u.fname, u.lname FROM events e, user_details u WHERE e.name LIKE '%$name%' AND     e.owner = u.username";        
        $result = $this->db->query($query);
        return $result->result_array();
    }
        
    function search_admin_vendors($name)
    {
        $query = "SELECT * FROM vendors WHERE name LIKE '%$name%' OR category LIKE '%$name%' OR address LIKE '%$name%'";        
        $result = $this->db->query($query);
        return $result->result_array();
    }
        
    function search_admin_users($name)
    {
        $query = "SELECT u.*, d.* FROM users u, user_details d WHERE u.username LIKE '%$name%' AND u.username = d.username ";        
        $result = $this->db->query($query);
        return $result->result_array();
    }
        
    function admin_delete_event($id)
    {
        $this->db->delete('events', array('id' => $id)); 
    }
        
    function admin_delete_user($name)
    {
        $this->db->delete('users', array('username' => $name)); 
    }
        
    function admin_delete_vendor($id)
    {
        $this->db->delete('vendors', array('id' => $id)); 
    }
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    }


?>