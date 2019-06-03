
<html>
    <head>        
        <title>Admin | Thousand Plus Events</title>
       <link rel="stylesheet" href="<?php echo base_url(); ?>/css/materialize.css">        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>js/materialize.js"></script>
        <link rel="icon" href="<?php echo base_url(); ?>images/favicon.png" type="image/png">    
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        
    </head> 
    
    <body> 
        <!--        Navbar     -->

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
        
        <script>
            $(document).ready(function(){
                $('.modal').modal();
                $(".dropdown-trigger").dropdown();


            });        
        </script>
  
        <ul id="dropdown1" class="dropdown-content">           
            <li><a href="<?=  base_url() ?>index.php/home/logout" class="nav-page">Log out</a></li>              
        </ul>
            
        <div class="navbar-fixed"> 
            
            <nav>
              <div class="nav-wrapper">
                  <a href="<?=  base_url() ?>index.php/admin" class="brand-logo"><img src="<?=  base_url() ?>/images/logo1.png" height="80%" style="margin-top:2%;"></a>

                <ul class="right hide-on-med-and-down">
                 
                  <li><img src="<?= base_url(); ?><?= $_SESSION['pic']; ?>" alt="" class="circle" height="80%" style="margin-top:10%; margin-left:10px; margin-right:5px"></li> 
                    
                  <li><a class="dropdown-trigger" href="#!" data-target="dropdown1"><?= $_SESSION['name']; ?><i class="material-icons right">arrow_drop_down</i></a></li>                    
                  
                    
                </ul>
              </div>
            </nav>  
        </div> 

      
        <!--       Navbar end     -->
        
        <div class="row" style="margin-top:50px">
            <center><h3>Admin Panel</h3></center><hr>
            <div class="col s12 m4">
                <div class="col s12 card">
                <center><h5>Delete Users</h5>
                    Search through thousands of vendors whom you can get products and services from.</center><hr>
                     <div class="row" style="margin-bottom:0">                    
                    <div class="input-field col s12">
                      <i class="material-icons prefix">search</i>
                      <input type="text" id="search_user" name="search_text" placeholder="Search">
                      <label for="search_user">Search Users by username</label>                        
                    </div>
                    </div> 
                    <div class="row">
                        <hr>
                        <div id="result_users" class="col s12"></div></div>
                </div>
                
            </div>
             <div class="col s12 m4">
                 <div class="col s12 card">
                   <center><h5>Delete Vendors</h5>
                    Search through thousands of vendors whom you can get products and services from.</center><hr>
                     <div class="row" style="margin-bottom:0">                    
                    <div class="input-field col s12">
                      <i class="material-icons prefix">search</i>
                      <input type="text" id="search_vendor" name="search_text" placeholder="Search">
                      <label for="search_vendor">Search Vendors by name, category or location</label>                        
                    </div>
                    </div> 
                    <div class="row">
                        <hr>
                        <div id="result_vendors" class="col s12"></div></div>
                               
                </div>
                
            </div>
            
            <div class="col s12 m4">
                 <div class="col s12 card">
                   <center><h5>Delete Events</h5>
                    Search through thousands of vendors whom you can get products and services from.</center><hr>
                     <div class="row" style="margin-bottom:0">                    
                    <div class="input-field col s12">
                      <i class="material-icons prefix">search</i>
                      <input type="text" id="search_event" name="search_text" placeholder="Search">
                      <label for="search_event">Search Events by name</label>                        
                    </div>
                    </div> 
                    <div class="row">
                        <hr>
                        <div id="result_events" class="col s12"></div></div>
                               
                </div>
               
            </div>
        </div>
         
     
        
    </body>
   
    <script></script>
    <script src="<?php echo base_url(); ?>js/materialize.js"></script>
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script>
        $(document).ready(function(){
            $('select').formSelect();
            $('.timepicker').timepicker({
                twelveHour: false
            }); 
            
            //////// Vendor Ajax
            function load_vendor(name){    
                $.ajax({
                    url:"<?php echo base_url(); ?>index.php/admin/search_vendors",
                    method:"POST",
                    data:{name:name},
                    success:function(data){
                        $('#result_vendors').html(data);
                    }
                });
             }
            
            $('#search_vendor').keyup(function(){

                var search = $(this).val();
                if(search != '')
                {
                    load_vendor(search);
                }
                else
                {
                    load_vendor();
                }
            });
            
            
            //////// Event Ajax
            function load_event(name){    
                $.ajax({
                    url:"<?php echo base_url(); ?>index.php/admin/search_events",
                    method:"POST",
                    data:{name:name},
                    success:function(data){
                        $('#result_events').html(data);
                    }
                });
             }
            
            $('#search_event').keyup(function(){

                var search = $(this).val();
                if(search != '')
                {
                    load_event(search);
                }
                else
                {
                    load_event();
                }
            });
            
            //////// User Ajax
            function load_user(name){    
                $.ajax({
                    url:"<?php echo base_url(); ?>index.php/admin/search_users",
                    method:"POST",
                    data:{name:name},
                    success:function(data){
                        $('#result_users').html(data);
                    }
                });
             }
            
            $('#search_user').keyup(function(){

                var search = $(this).val();
                if(search != '')
                {
                    load_user(search);
                }
                else
                {
                    load_user();
                }
            });
            
             $('.collapsible').collapsible();
           
             <?php
    
                if(isset($_GET['category']))
                {
                    $cat = $_GET['category'];
                    echo "load_data('$cat');";
                    echo "$('#search_text').val('$cat');";
                }
            ?>
            
        });
        
        
        
        
    </script>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 80%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
</html>



