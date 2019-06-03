<?php
    class Auth extends CI_Model {

        public function __construct() {
            parent::__construct();
            $this->load->database();
        }
        

        public function login($user, $pass) {
            $query = $this->db->get_where( 'users', array( 'username' => $user, 'password' => $pass ) );
            return $query->row_array();
        }

        
        public function register($user, $pass) { 
            $pic = "images/propic/default.png"; 
            $sql = "INSERT INTO users VALUES ('$user', '$pass', '1')";
            $sql2 = "INSERT INTO user_details (username, pic) VALUES ('$user','$pic')";
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
        
        
        public function profile($fname, $lname, $gender, $nic, $tele, $email, $username) {
            $query = "UPDATE user_details SET fname = '$fname', lname = '$lname', gender = '$gender', nic = '$nic', telephone = '$tele', email = '$email' WHERE username = '$username'" ;
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
        
        public function update_pro_pic($path, $user) {
            $query = "UPDATE user_details SET pic = '$path' WHERE username = '$user'";
            $this->db->query($query);
        }
        
        public function update_event_pic($path, $id) {
            $query = "UPDATE events SET pic = '$path' WHERE id = '$id'";
            $this->db->query($query);
        }
        
        public function delete_event($id, $user) {
            $query = "DELETE FROM events WHERE id='$id' AND owner='$user'";
            if ( $this->db->query($query) )
            {
                return true;
            }
            
        }
        
        public function add_crew_finance($id, $user) {
            $query = "SELECT id FROM finance_department WHERE event='$id'";
            $result = $this->db->query($query);
            $d = $result->row_array();
            $dept_id = $d['id'];
            $query2 = "INSERT INTO finance_users(dept_id, username) VALUES ('$dept_id', '$user')";
            $this->db->query($query2);           
            
        }
        
        public function show_crew_finance($id) {
            $query = "SELECT id FROM finance_department WHERE event='$id'";
            $result = $this->db->query($query);
            $d = $result->row_array();
            $dept_id = $d['id'];
            $query2 = "SELECT * FROM finance_users WHERE dept_id='$dept_id'";
            $result2 = $this->db->query($query2);
            return $result2->result_array();
        }
        
        public function fetch_tasks_finance($id) {
            $query = "SELECT id FROM finance_department WHERE event='$id'";
            $result = $this->db->query($query);
            $d = $result->row_array();
            $dept_id = $d['id'];
            $query2 = "SELECT * FROM finance_tasks WHERE dept_id='$dept_id'";
            $result2 = $this->db->query($query2);
            return $result2->result_array();
        }
        
        public function add_task_finance($id, $task) {
            $query = "SELECT id FROM finance_department WHERE event='$id'";
            $result = $this->db->query($query);
            $d = $result->row_array();
            $dept_id = $d['id'];
            $query2 = "INSERT INTO finance_tasks(dept_id, task_name) VALUES ('$dept_id', '$task')";
            $this->db->query($query2);
            
            
        }
        
    
    }


?>