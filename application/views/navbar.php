<!--        Navbar     -->

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
        
        <script>
            $(document).ready(function(){
                $('.modal').modal();
                $(".dropdown-trigger").dropdown();


            });        
        </script>
  
        <ul id="dropdown1" class="dropdown-content">
            
            <li><a href="<?=  base_url() ?>index.php/home/profile" class="nav-page">My Profile</a></li>
            <li class="divider"></li>
            <li><a href="<?=  base_url() ?>index.php/home/logout" class="nav-page">Log out</a></li>  
            
        </ul>
        <ul id="dropdown2" class="dropdown-content">
            
            <li><a href="<?=  base_url() ?>index.php/home/manage" class="nav-page" >View Events</a></li>             
            <li><a href="<?=  base_url() ?>index.php/home/create" class="nav-page current">Create new</a></li>  
            
        </ul>
        
        <div class="navbar-fixed"> 
            
            <nav>
              <div class="nav-wrapper">
                  <a href="<?=  base_url() ?>index.php/home/homepage" class="brand-logo"><img src="<?=  base_url() ?>/images/logo1.png" height="80%" style="margin-top:2%;"></a>
<!--                  <a href="<?=  base_url() ?>index.php/home/homepage" class="brand-logo text-darken-2 blue-text">&nbsp;Thousand Plus Events</a>-->
                <ul class="right hide-on-med-and-down">
                  <li><a href="<?=  base_url() ?>index.php/home/homepage" class="nav-page">Home</a></li>
                  <li><a href="<?=  base_url() ?>index.php/collaborate" class="nav-page">Collaborations</a></li>       <li><a href="<?=  base_url() ?>index.php/vendors" class="nav-page">Vendors</a></li>               
                  <li><a class="dropdown-trigger" href="#!" data-target="dropdown2">My Events<i class="material-icons right">arrow_drop_down</i></a></li>
                    <li><a class="modal-trigger" href="#modal_notifications"><i class="fa fa-bell"></i><span class="new badge red" style="vertical-align:80%" id="noti_badge"><?= $_SESSION['noti_count'] ?></span></a></li>
                  <li><img src="<?= base_url(); ?><?= $_SESSION['pic']; ?>" alt="" class="circle" height="80%" style="margin-top:10%; margin-left:10px; margin-right:5px"></li> 
                    
                  <li><a class="dropdown-trigger" href="#!" data-target="dropdown1"><?= $_SESSION['name']; ?><i class="material-icons right">arrow_drop_down</i></a></li>                    
                  
                    
                </ul>
              </div>
            </nav>  
        </div> 

      
<!--       Navbar end     -->