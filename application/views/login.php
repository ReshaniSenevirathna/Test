<html>
    <head>
        <link href="<?php echo base_url(); ?>css/materialize.css" rel="stylesheet" type="text/css">
        <title>Login | Thousand Plus Events </title>
        <link rel="icon" href="<?php echo base_url(); ?>images/favicon.png" type="image/png">
        <style>
          
        
        </style>
    </head>    
    <body>        
       <div class="navbar-fixed">
            
            <nav>
              <div class="nav-wrapper">
                  
                <ul class="right hide-on-med-and-down">

                  <li><a href="<?php echo base_url(); ?>index.php/home/index" class="nav-page">Home</a></li>
                  <li><a href="<?php echo base_url(); ?>index.php/home/register" class="nav-page current">Create account</a></li>
                  <li class="active"><a href="<?php echo base_url(); ?>index.php/home/login" class="nav-page">Log In</a></li>

                </ul>
              </div>
           </nav>
        </div>  
        
        <div class="container">           
            <div class="row">                
                <div class="col m6 offset-m3">                    
                    <a href="<?=  base_url() ?>index.php/home/homepage" class="brand-logo"><img src="<?=  base_url() ?>/images/logo1.png" width="100%" style="margin-top:2%;"></a>
                    <div class="card">                        
                        <center><h2>Log In</h2></center>
                        
                        <form action="<?php echo base_url();?>index.php/home/login" method="POST">
                            
                            <div class="row">
                                <div class="card-action text-center">  
                                
                                <div class="input-field col m12">
                                  <input type="text" name="user" placeholder="Username" required autocomplete="off">
                                  <label for="user">Username</label>                                  
                                </div>
                                    
                                <div class="input-field col m12">
                                  <input type="password" name="pass" placeholder="Password" required autocomplete="off">
                                  <label for="pass">Password</label>                                  
                                </div>   
                            </div>
                            
                            <div class="col m12"> 
                                <center>
                                   
                                    <div class="row">
                                        <button name="btn_submit" type="submit" class="btn-large green waves-light waves-effect" value="Log In">Log In </button>
                                    </div>
                                    <div class="alert-fail" hidden>
                                        <span class="close-btn-fail" id="user_alert" onclick="alert_login_close()">&times;</span>
                                        Username and/or password is incorrect
                                    </div>
                                    
                                    <u><a class="mute" href="#" >Forgot password?</a></u>
                                    <br><br>
                                    Do not have an account? <a class="mute" href="<?php echo base_url(); ?>index.php/home/register"><u>Register</u> </a><br>&nbsp;
                                    <?php  ?>
                                </center>
                            </div>
                            </div>
                        </form>
                        
                        
                    </div>
                </div>
            </div>
        </div>
        
        <script src="<?php echo base_url(); ?>js/jquery.js"></script>
        <script src="<?php echo base_url(); ?>js/materialize.js"></script>
        <script>
            
            function alert_login_close(){
                user_alert.parentElement.style.display='none';
            }

            function show_user_error(){
                user_alert.parentElement.style.display='block';
            }
            
            
        </script>
       
    </body>
</html>

