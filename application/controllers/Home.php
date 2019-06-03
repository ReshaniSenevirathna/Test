<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    
   
	public function index()
	{
		$this->load->view('landing');
        $this->load->view('footer');
	}
    
   
    
    
    
    public function login()
	{
		$this->load->view('login');
        $this->load->view('footer');    
        
        if ( $this->input->post('btn_submit') )
        {
            $user = $this->input->post('user');
            $pass = $this->input->post('pass');        
            
            $result = $this->tpe_model->login($user, md5($pass));

            if($result) {
                if($result['type'] == 0){
                    $this->session->set_userdata('type', $result['type']);                     
                    $this->session->set_userdata('pic', 'images/propic/default.png');  
                    $this->session->set_userdata('name', "Administrator");
                    header("location:".base_url()."index.php/admin");            
                    
                }
                else if ($result['type'] == 1){
                    $got_user = $result['username'];           
                    $details = $this->tpe_model->get_name($got_user);
                     $f_name = $details['fname'];
                    if ($details['fname'] == null)
                    {
                        $f_name = 'Welcome User!';
                    }

                    $this->session->set_userdata('username', $got_user);
                    $this->session->set_userdata('name', $f_name);
                    $this->session->set_userdata('pic', $details['pic']);
                    $this->session->set_userdata('type', $result['type']);
                    $this->session->set_userdata('reminder_toggle', $details['reminders']);
                    $this->session->set_userdata('reminders', $details['reminders']);
                    header("location:".base_url()."index.php/home/homepage");    
                }
            }
            else
            {
                echo "<script>alert('Username and/or password is incorrect');</script>";
            }
        }       
    }

    public function create()
    {
        if (isset($_SESSION['username']))
        {   
            $this->notifications();
            $this->load->view('navbar');
            $this->load->view('create_event');
            $this->load->view('footer');    

            if ( $this->input->post('btn_save') )
            {
                if (!empty($_FILES['fileToUpload']['name'])) 
                {
                    $config['upload_path']          = './images/events';
                    $config['allowed_types']        = 'jpg|png|jpeg';
                    $config['max_size']             = 5000;
                    $config['max_width']            = 3000;
                    $config['max_height']           = 3000;
                    $config['overwrite']            = TRUE;

                    $file_name = basename($_FILES["fileToUpload"]["name"]);
                    $imageFileType = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));         
                    $config['file_name'] = $this->input->post('name');

                    $this->load->library('upload', $config);

                    if ( ! $this->upload->do_upload('fileToUpload'))
                    {
                        echo $this->upload->display_errors();
                    }
                    else 
                    {
                        $path = "images/events/".$this->upload->data('file_name');
                    }
                }
               
                else
                {                 
                    $path =  "images/events/default.jpg";
                }
                    
                $data = array(
                    'name' => $this->input->post('name'),
                    'type' => $this->input->post('type'),
                    'date' => $this->input->post('date'),
                    'time' => $this->input->post('time'),
                    'description' => $this->input->post('desc'),
                    'pic' => $path,
                    'owner' => $_SESSION['username']
                );

                $this->tpe_model->create($data); 
                header("location:".base_url()."index.php/home/manage");
            }
        }     
        
        else
        {
           header("location:".base_url()."index.php/home/login");
        }
    }

//    public function edit()
//    {
//        if (isset($_SESSION['username']))
//        {
//            $this->load->view('navbar');
//            $this->load->view('view_events');
//            $this->load->view('footer');    
//
//            if ( $this->input->post('btn_save') )
//            {
//                $data = array(
//                    'name' => $this->input->post('name'),
//                    'type' => $this->input->post('type'),
//                    'date' => $this->input->post('date'),
//                    'time' => $this->input->post('time'),
//                    'pic' => "ghf",
//                    'owner' => $this->input->post('owner')
//                );
//
//                $this->tpe_model->create($data);            
//            }
//        }
//        else
//        {
//           header("location:".base_url()."index.php/home/login");
//        }
//
//    }
    
    
    
    public function logout()
    {
        session_destroy();
        header("location:".base_url()."index.php/home/");
    }

    
    
    
    
    
    
    
    
        public function departments($event_id)
            {
                $real_id = $event_id/23;
                $data = array(
                    'event' => $real_id,
                    'finance' => $this->input->post('finance_toggle'),
                    'logistics' => $this->input->post('logistics_toggle'),
                    'decoration' => $this->input->post('decorations_toggle'),
                    'marketing' => $this->input->post('marketing_toggle'),
                    'registration' => $this->input->post('registration_toggle'),
                    'sales' => $this->input->post('sales_toggle')
                );
                $this->tpe_model->toggle_depts($data);
                header("location:".base_url()."index.php/home/event/$event_id");

        }
        public function load()
        {
            $this->load->view('finance');

         }   

    
    //Finance Dept

        public function finance($id_passed)
        {
            $id = $id_passed/23;
            if (isset($_SESSION['username']))
            {
                $username = $_SESSION['username'];
            }
            else 
            {
                 header("location:".base_url()."index.php/home/login");   
            }
            
            $data['events'] = $this->tpe_model->get_event($username, $id);
            if (!empty($data['events'])){
            
                $exist = $this->tpe_model->get_departments($id);

                if ($exist['finance'] == null) {
                    header("location:".base_url()."index.php/home/event/$id_passed");                
                }


                $data['crew'] = $this->tpe_model->show_crew_finance($id);
                $data['tasks'] = $this->tpe_model->fetch_tasks_finance($id);
                $data['companies'] = $this->tpe_model->fetch_companies_finance($id);
                $data['income'] = $this->tpe_model->get_income_finance($id);
                $data['expenses'] = $this->tpe_model->get_expenses_finance($id);

                $data['id_passed'] = $id_passed;
                
                $this->notifications();
                $this->load->view('navbar');
                $this->load->view('finance', $data);                   
                $this->load->view('footer');   

                if ( $this->input->post('add_crew') )
                {
                    $crew_user = $this->input->post('user_crew');
                    $result = $this->tpe_model->add_crew_finance($id, $crew_user);
                    if ($result == "success"){
                        header("location:".base_url()."index.php/home/finance/$id_passed");                    
                    }
                    else {                   
                        echo "<script> alert('$result')</script>";
                    }

                }

                if ( $this->input->post('add_task') )
                {
                    $task = $this->input->post('tasks');
                    $this->tpe_model->add_task_finance($id, $task);
                    header("location:".base_url()."index.php/home/finance/$id_passed");
                }


                if ( $this->input->post('add_company') )
                {
                    $c_name = $this->input->post('c_name');
                    $c_address = $this->input->post('c_address');
                    $c_telephone = $this->input->post('c_telephone');
                    $c_email = $this->input->post('c_email');
                    $c_website = $this->input->post('c_website');
                    $this->tpe_model->add_company_finance($id, $c_name, $c_address, $c_telephone, $c_email, $c_website);
                    header("location:".base_url()."index.php/home/finance/$id_passed");
                }

                if ( $this->input->post('edit_company') )
                {
                    $c_name = $this->input->post('c_name');
                    $c_address = $this->input->post('c_address');
                    $c_telephone = $this->input->post('c_telephone');
                    $c_email = $this->input->post('c_email');
                    $c_website = $this->input->post('c_website');
                    $c_id = $this->input->post('c_id')/23;
                    $this->tpe_model->edit_company_finance($id, $c_id, $c_name, $c_address, $c_telephone, $c_email, $c_website);
                    header("location:".base_url()."index.php/home/finance/$id_passed");
                }

                if ( $this->input->post('add_transaction') )
                {
                    $transaction = array(
                        'dept_id' => $this->tpe_model->get_finance_dept_id($id),
                        'amount' => $this->input->post('amount'),
                        'type' => $this->input->post('type'),
                        'added_by' => $_SESSION['username'],
                        'description' => $this->input->post('description'),
                        'date' => $this->input->post('date')   
                    );

                    $this->tpe_model->add_transaction_finance($transaction);
                    header("location:".base_url()."index.php/home/finance/$id_passed");
                }
            }
            else {header("location:".base_url()."index.php/home/manage"); }
            
        }
    
        public function check_finance()
        {
            $postData = $this->input->post();
            $id = $postData['id'];        
            $value = $postData['value'];        
            $name = $_SESSION['username'];        
            $this->tpe_model->check_task_finance($id, $value, $name);
        }

          
        public function delete_task_finance($e, $t, $d)
        {
            $event = $e/23;
            $owner = $_SESSION['username'];
            $r = $this->tpe_model->delete_task_finance($event, $t, $d, $owner);
            if ($r == true) 
            {
                header("location:".base_url()."index.php/home/finance/$e");
            }
            else 
            {
                header("location:".base_url()."index.php/home/manage");
            }
            
        }
    
    
        public function delete_user_finance($e, $u)
            {
                $event = $e/23;
                $owner = $_SESSION['username'];
                $r = $this->tpe_model->delete_user_finance($event, $u, $owner);
                if ($r == true) 
                {
                    header("location:".base_url()."index.php/home/finance/$e");
                }
                else 
                {
                    header("location:".base_url()."index.php/home/manage");
                }

        }

        public function assigned_to_finance()
        {
            $postData = $this->input->post();
            $split = explode("&",$postData['value']);            
            $task_id = ((int)$split[1])/23;   
            $user = $split[0];    
            $this->tpe_model->assigned_to_finance($task_id, $user);  
            
        }
    
        public function delete_company_finance($e, $c)
        {
            $event_id = $e/23;
            $company_id = $c/23;
            $this->tpe_model->delete_company_finance($event_id, $company_id);
            header("location:".base_url()."index.php/home/finance/$e"); 
            
        }
    
        public function delete_transaction_finance($e, $t, $type)
        {
            $event_id = $e/23;
            $transaction_id = $t/23;
            $this->tpe_model->delete_transaction_finance($event_id, $transaction_id, $type);
            header("location:".base_url()."index.php/home/finance/$e"); 
            
        }
    
        
    
    
    
   
    //Decorations Dept
        public function decorations($id_passed)
        {
            $id = $id_passed/23;
            if (isset($_SESSION['username']))
            {
                $username = $_SESSION['username'];
            }
            else 
            {
                 header("location:".base_url()."index.php/home/login");   
            }
            
            $data['events'] = $this->tpe_model->get_event($username, $id);
            if (!empty($data['events'])){
                
            $exist = $this->tpe_model->get_departments($id);
            
            if ($exist['decoration'] == null) {
                header("location:".base_url()."index.php/home/event/$id_passed");                
            }
            
            
            $data['crew'] = $this->tpe_model->show_crew_decorations($id);
            $data['tasks'] = $this->tpe_model->fetch_tasks_decorations($id);
            $data['income'] = $this->tpe_model->get_income_decorations($id);
            $data['expenses'] = $this->tpe_model->get_expenses_decorations($id);
            
            $data['id_passed'] = $id_passed;
            
            $this->notifications();
            $this->load->view('navbar');  
            $this->load->view('decorations', $data);             
            $this->load->view('footer');   

            if ( $this->input->post('add_crew') )
            {
                $crew_user = $this->input->post('user_crew');
                $result = $this->tpe_model->add_crew_decorations($id, $crew_user);
                if ($result == "success"){
                    header("location:".base_url()."index.php/home/decorations/$id_passed");                    
                }
                else {                   
                    echo "<script> alert('$result')</script>";
                }
            }

            if ( $this->input->post('add_task') )
            {
                $task = $this->input->post('tasks');
                $this->tpe_model->add_task_decorations($id, $task);
                header("location:".base_url()."index.php/home/decorations/$id_passed");
            }
            
            if ( $this->input->post('add_transaction') )
            {
                $transaction = array(
                    'dept_id' => $this->tpe_model->get_decorations_dept_id($id),
                    'amount' => $this->input->post('amount'),
                    'type' => $this->input->post('type'),
                    'added_by' => $_SESSION['username'],
                    'description' => $this->input->post('description'),
                    'date' => $this->input->post('date')   
                );

                $this->tpe_model->add_transaction_decorations($transaction);
                header("location:".base_url()."index.php/home/decorations/$id_passed");
            }
            }
            else {header("location:".base_url()."index.php/home/manage"); }
            
        }
    
        public function check_decorations()
        {
            $postData = $this->input->post();
            $id = $postData['id'];        
            $value = $postData['value'];        
            $name = $_SESSION['username'];            
            $this->tpe_model->check_task_decorations($id, $value, $name);
        }
    
        
    
        public function delete_task_decorations($e, $t, $d)
        {
            $event = $e/23;
            $owner = $_SESSION['username'];
            $r = $this->tpe_model->delete_task_decorations($event, $t, $d, $owner);
            if ($r == true) 
            {
                header("location:".base_url()."index.php/home/decorations/$e");
            }
            else 
            {
                header("location:".base_url()."index.php/home/manage");
            }
            
        }
    
    
        public function delete_user_decorations($e, $u)
            {
                $event = $e/23;
                $owner = $_SESSION['username'];
                $r = $this->tpe_model->delete_user_decorations($event, $u, $owner);
                if ($r == true) 
                {
                    header("location:".base_url()."index.php/home/decorations/$e");
                }
                else 
                {
                    header("location:".base_url()."index.php/home/manage");
                }

        }

        public function assigned_to_decorations()
        {
            $postData = $this->input->post();
            $split = explode("&",$postData['value']);            
            $task_id = ((int)$split[1])/23;   
            $user = $split[0];    
            $this->tpe_model->assigned_to_decorations($task_id, $user);  
            
        }
    
        public function delete_transaction_decorations($e, $t, $type)
        {
            $event_id = $e/23;
            $transaction_id = $t/23;
            $this->tpe_model->delete_transaction_decorations($event_id, $transaction_id, $type);
            header("location:".base_url()."index.php/home/decorations/$e"); 
            
        }
    
    
    //Marketing Dept
        public function marketing($id_passed)
        {
            $id = $id_passed/23;
            if (isset($_SESSION['username']))
            {
                $username = $_SESSION['username'];
            }
            else 
            {
                 header("location:".base_url()."index.php/home/login");   
            }
            
            $data['events'] = $this->tpe_model->get_event($username, $id);
            if (!empty($data['events'])){
                
            $exist = $this->tpe_model->get_departments($id);
            
            if ($exist['marketing'] == null) {
                header("location:".base_url()."index.php/home/event/$id_passed");                  
            }
            
                
            $data['crew'] = $this->tpe_model->show_crew_marketing($id);
            $data['tasks'] = $this->tpe_model->fetch_tasks_marketing($id);
            $data['income'] = $this->tpe_model->get_income_marketing($id);
            $data['expenses'] = $this->tpe_model->get_expenses_marketing($id);
            $data['id_passed'] = $id_passed;
        
            $this->notifications();
            $this->load->view('navbar');
            $this->load->view('marketing', $data);              
            $this->load->view('footer');   

            if ( $this->input->post('add_crew') )
            {
                $crew_user = $this->input->post('user_crew');
                $result = $this->tpe_model->add_crew_marketing($id, $crew_user);
                if ($result == "success"){
                    header("location:".base_url()."index.php/home/marketing/$id_passed");                    
                }
                else {                   
                    echo "<script> alert('$result')</script>";
                }
            }

            if ( $this->input->post('add_task') )
            {
                $task = $this->input->post('tasks');
                $this->tpe_model->add_task_marketing($id, $task);
                header("location:".base_url()."index.php/home/marketing/$id_passed");
            }
        
            if ( $this->input->post('add_transaction') )
                {
                    $transaction = array(
                        'dept_id' => $this->tpe_model->get_marketing_dept_id($id),
                        'amount' => $this->input->post('amount'),
                        'type' => $this->input->post('type'),
                        'added_by' => $_SESSION['username'],
                        'description' => $this->input->post('description'),
                        'date' => $this->input->post('date')   
                    );

                    $this->tpe_model->add_transaction_marketing($transaction);
                    header("location:".base_url()."index.php/home/marketing/$id_passed");
                }
                 }
            else {header("location:".base_url()."index.php/home/manage"); }
        }
    
        public function check_marketing()
        {
            $postData = $this->input->post();
            $id = $postData['id'];        
            $value = $postData['value'];        
            $name = $_SESSION['username'];        
            $this->tpe_model->check_task_marketing($id, $value, $name);
        }
    
        
    
        public function delete_task_marketing($e, $t, $d)
        {
            $event = $e/23;
            $owner = $_SESSION['username'];
            $r = $this->tpe_model->delete_task_marketing($event, $t, $d, $owner);
            if ($r == true) 
            {
                header("location:".base_url()."index.php/home/marketing/$e");
            }
            else 
            {
                header("location:".base_url()."index.php/home/manage");
            }
            
        }
    
    
        public function delete_user_marketing($e, $u)
            {
                $event = $e/23;
                $owner = $_SESSION['username'];
                $r = $this->tpe_model->delete_user_marketing($event, $u, $owner);
                if ($r == true) 
                {
                    header("location:".base_url()."index.php/home/marketing/$e");
                }
                else 
                {
                    header("location:".base_url()."index.php/home/manage");
                }

        }

        public function assigned_to_marketing()
        {
            $postData = $this->input->post();
            $split = explode("&",$postData['value']);            
            $task_id = ((int)$split[1])/23;   
            $user = $split[0];    
            $this->tpe_model->assigned_to_marketing($task_id, $user);  
            
        }
    
        public function delete_transaction_marketing($e, $t, $type)
        {
            $event_id = $e/23;
            $transaction_id = $t/23;
            $this->tpe_model->delete_transaction_marketing($event_id, $transaction_id, $type);
            header("location:".base_url()."index.php/home/marketing/$e"); 
            
        }
}

?>
