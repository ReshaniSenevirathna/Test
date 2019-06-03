<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {   
    
	public function index()
	{
        if($_SESSION['type'] != 0)
        {
            header("location:".base_url()."index.php/home/logout");
        }        	
		$this->load->view('admin');
        $this->load->view('footer');
    }
    
    function search_events()
    {   
        $name = $this->input->post('name');         
        $output = '<ul class="collection"><li class="collection-item">0 matches found</li></ul>';
        if($name != ''){
            $result = $this->tpe_model->search_admin_events($name);
            $output = '<ul class="collection"><li class="collection-item">'.count($result).' matches found</li></ul>';
            $output = $output.'<ul class="collection">';
            foreach($result as $row){                
                $output = $output.'<li class="collection-item avatar">';
                $output = $output.'<img src="'.base_url().$row['pic'].'" alt="" class="circle">';
                $output = $output.'<span class="title"><b>'.$row['name'].'</b></span>';
                $output = $output.'<p>Date - <b>'.$row['date'].'</b><br>Owner - <b>'.$row['fname'].' '.$row['lname'].'</b></p>';
                $output = $output.'<a href="'.base_url().'index.php/admin/delete_event/'.($row['id']*23).'" class="secondary-content btn red waves-effect waves-light">Delete</a>';               
                $output = $output.'</li>';               
            }
            $output = $output.'</ul>';
            
           
        }
        echo $output;    
    }
    
    function search_vendors()
    {   
        $name = $this->input->post('name');         
        $output = '<ul class="collection"><li class="collection-item">0 matches found</li></ul>';
        if($name != ''){
            $result = $this->tpe_model->search_admin_vendors($name);
            $output = '<ul class="collection"><li class="collection-item">'.count($result).' matches found</li></ul>';
            $output = $output.'<ul class="collection">';
            foreach($result as $row){                
                $output = $output.'<li class="collection-item avatar">';
                $output = $output.'<img src="'.base_url().$row['pic'].'" alt="" class="circle">';
                $output = $output.'<span class="title"><b>'.$row['name'].'</b></span>';
                $output = $output.'<p>Type - <b>'.$row['category'].'</b><br>Address - <b>'.$row['address'].'</b></p>';
                $output = $output.'<a href="'.base_url().'index.php/admin/delete_vendor/'.($row['id']*23).'" class="secondary-content btn red waves-effect waves-light">Delete</a>';               
                $output = $output.'</li>';               
            }
            $output = $output.'</ul>';
        }
        echo $output;    
    }
    
    function search_users()
    {   
        $name = $this->input->post('name');         
        $output = '<ul class="collection"><li class="collection-item">0 matches found</li></ul>';
        if($name != ''){
            $result = $this->tpe_model->search_admin_users($name);
            $output = '<ul class="collection"><li class="collection-item">'.count($result).' matches found</li></ul>';
            $output = $output.'<ul class="collection">';
            foreach($result as $row){                
                $output = $output.'<li class="collection-item avatar">';
                $output = $output.'<img src="'.base_url().$row['pic'].'" alt="" class="circle">';
                $output = $output.'<span class="title"><b>'.$row['fname']." ".$row['lname'].'</b></span><br>';            
                $output = $output.'<span>Username - <b>'.$row['username'].'</b></span>';            
                $output = $output.'<a href="'.base_url().'index.php/admin/delete_user/'.($row['username']).'" class="secondary-content btn red waves-effect waves-light">Delete</a>';               
                $output = $output.'</li>';               
            }
            $output = $output.'</ul>';
            
           
        }
        echo $output;    
    }
    
    function delete_event($id)
    {
        if($_SESSION['type'] == 0)
        {
            $this->tpe_model->admin_delete_event($id/23);
            header("location:".base_url()."index.php/admin");
        }
        else
        {
            header("location:".base_url()."index.php/home/logout");
        }
        
    }
    
    function delete_vendor($id)
    {
        if($_SESSION['type'] == 0)
        {
            $this->tpe_model->admin_delete_vendor($id/23);
            header("location:".base_url()."index.php/admin");
        }
        else
        {
            header("location:".base_url()."index.php/home/logout");
        }
        
    }
    
    function delete_user($name)
    {
        if($_SESSION['type'] == 0)
        {
            $this->tpe_model->admin_delete_user($name);
            header("location:".base_url()."index.php/admin");
        }
        else
        {
            header("location:".base_url()."index.php/home/logout");
        }
        
    }
    
    
    
}
?>