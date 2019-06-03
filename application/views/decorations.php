<html>
    <head>
        <link rel="stylesheet" href="<?php echo base_url(); ?>/css/materialize.css"> 
        <title> Manage Events | Thousand Plus Events </title>
        <link rel="icon" href="<?php echo base_url(); ?>images/favicon.png" type="image/png"> 
    
    </head>  
    
    <body>  
        
        
      
        
        
            
        <?php foreach($events as $val){ $event_id = $val['id']*23; ?>
        
        
            <div class="row">
               <div class="col m3">  
                    <div class="col m12 center-align">
                        <h4><strong><?php echo $val['name']; ?></strong></h4><?php echo $val['date']; ?> <br>

                    

                        <?php echo $val['time']; ?>
                        <br>&nbsp;
                   
                        <img class="" src="<?php echo base_url().$val['pic']; ?>" width="100%" id="output">                        
                       
                    </div>
                   <div class="col s12 left-align">                  
                    <div id="header">
                        <div id="header-inner"> 
                            <div class="row">
                                <ul class="section table-of-contents">
                                    Quick Links
                                    <li><a href="#crew">Add crew</a></li>
                                    <li><a href="#tasks">Add tasks</a></li>                                    
                                    <li><a href="#budget">Budget tracking</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
               </div>
                </div>
                <div class="col m9" style="margin-top:30px">
                    
                    <div class="row"> 
                        <a href="<?php echo base_url(); ?>index.php/home/manage" class="breadcrumb">My Events</a>
                        <a href="<?php echo base_url(); ?>index.php/home/event/<?php echo $id_passed; ?>" class="breadcrumb"><?php echo $val['name']; ?></a>                    
                        <a href="" class="breadcrumb">Decorations Department</a>                    
                    </div>
                    
                    <div class="row">
                    <div class="col m5">
                               <div class="col s12 card">            
                                
                                   <a class="anchor" id="crew"></a>
                                        <h5 class="center-align row">
                                            Add crew
                                        </h5> 
                        
                                    <hr>
                                    <div class="row">
                                        <form method="POST">
                                            <div class="input-field col m8">                                                          
                                                <input type="text" name="user_crew" required class="validate" placeholder="Username">  
                                                <label for="user_crew">Type Username</label>
                                            </div>
                                            <div class="col m4 right-align"> 
                                                <button class="btn-large green waves-light waves-effect" name="add_crew" type="submit" value="Add">Add</button>
                                            </div>
                                        </form>
                                    </div>
                        
                                    <div>                                        
                                        <div class="row">
                                            <div class="col m12">
                                                 <ul class="collection">     
                                                   <?php foreach($crew as $val){ ?>
                                                                                           
                                                 
                                                    <li class="collection-item avatar">
                                                      <img src="<?php echo base_url().$val['pic']; ?>" alt="" class="circle materialboxed"><strong>
                                                        <span class="title"><?php echo $val['fname']; ?> <?php echo $val['lname']; ?> </span></strong>
                                                      <p><?php echo "<a style='color:darkblue' href='mailto:".$val['email']." '> ".$val['email']."</a>"; ?><br><?php echo $val['telephone']; ?>
                                                      </p>
                                                      <a href="<?=base_url()?>index.php/home/delete_user_decorations/<?php echo $event_id."/".$val['username']    ; ?>" class="secondary-content"><i class="material-icons red-text tooltipped" data-position="left" data-tooltip="Remove user">remove</i></a>
                                                    </li>
                                                      
                                                     <?php } ?>
                                               </ul>
                                            </div>                                 
                                        </div>
                                    </div> 
                        </div>
                        
                         <div class="card col s12">        
                                
                                   <a class="anchor" id="features"></a>
                                        <h5 class="center-align row">
                                            Features
                                        </h5> 
                        
                                    <hr>
                                  
                        
                                    <div>                                        
                                        <div class="row">
                                            <div class="col m12">
                                                <ul class="collection">
                                                    <li class="collection-item avatar">
                                                    <i class="material-icons circle red">toys</i>
                                                        <span class="title">Deco Material (Regiform, Wood)</span>
                                                        <hr>
                                                        <div class="right-align">
                                                            <a href="<?=base_url()?>index.php/vendors?category=grocery" class="btn blue waves-light waves-effect">Suggested</a> 
                                                            <a href="https://www.google.com/search?q=regiform+and+wood+around+me" target="_blank" class="btn green waves-light waves-effect">Web Search</a>
                                                        </div>
                                                    </li>     
                                               
                                                    <li class="collection-item avatar">
                                                    <i class="material-icons circle red">brush</i>
                                                        <span class="title">Paint / Brushes / Thinner</span>
                                                        <hr>
                                                        <div class="right-align">
                                                            <a href="<?=base_url()?>index.php/vendors?category=hardware" class="btn blue waves-light waves-effect">Suggested</a> 
                                                            <a href="https://www.google.com/search?q=paint+shops+around+me" target="_blank" class="btn green waves-light waves-effect">Web Search</a>
                                                        </div>
                                                    </li>       
                                                     <li class="collection-item avatar">
                                                    <i class="material-icons circle red">directions_car</i>
                                                        <span class="title">Transportation</span>
                                                        <hr>
                                                        <div class="right-align">
                                                            <a href="<?=base_url()?>index.php/vendors?category=transport" class="btn blue waves-light waves-effect">Suggested</a> 
                                                            <a href="https://www.google.com/search?q=transportation+providers+around+me" class="btn green waves-light waves-effect" target="">Web Search</a>
                                                        </div>
                                                    </li>       
                                                </ul>
                                            </div>                                 
                                        </div>
                                    </div>                                    
                        </div>
                               
                            </div>
                            <div class="col m7"> 
                                <div class="col s12 card">
                           
                                        <a class="anchor" id="tasks"></a>                        
                                         <h5 class="center-align row">
                                            Add tasks
                                        </h5> 
                                    <hr>
                                    <div class="row">
                                        <form method="POST">
                                            
                                            <div class="input-field col m9">                                                          
                                                <input type="text" name="tasks" required class="validate" placeholder="Type new task">  
                                                <label for="tasks">Add new task</label>
                                            </div>
                                            <div class="col m3 right-align"> 
                                                <button class="btn-large green waves-light waves-effect" name="add_task" type="submit" value="Add">Add</button>
                                            </div>
                                            
                                           
                                         
                                        </form> 
                                    </div>
                                                                  
                                           
                                               
                                    <div class='row'>
                                        <div class='col m12'>
                                                <ul class="collection with-header">

                                                <?php foreach($tasks as $t){ ?>
                                                
                                                    <li class="collection-item">
                                                        <div><?php echo $t['task_name']; ?>
                                                        <a href="<?=base_url()?>index.php/home/delete_task_decorations/<?php echo $event_id."/".$t['id']."/".$t['dept_id']; ?> " class="secondary-content"><i class="material-icons red-text tooltipped" data-position="left" data-tooltip="Remove task">remove</i></a>
                                                            <a  class="secondary-content">
                                                                <label>
                                                                <input type="checkbox" class="ckbx filled-in" <?php if($t['completion']==1) {echo "checked";} ?>  value=1 id="<?php echo $t['id']; ?>" name="<?php echo $t['id']; ?>"/>
                                                                <span></span>
                                                                </label>                                                                
                                                            </a>                                                  
                                                    
                                                        </div>
                                                        <hr>
                                                        <div>
                                                            <label>Currently assigned to</label>
                                                            <select class="browser-default assigned_to">
                                                                <option value="NONE&<?php echo $t['id']*23; ?>" selected>No one</option>
                                                                <?php foreach($crew as $m){
                                                                    if ($t['assigned_to']==$m['username']){
                                                                        $sel = "selected";
                                                                    }
                                                                    else {
                                                                        $sel = "";
                                                                    }
                                                                    $t_id = $t['id']*23;
                                                                    echo "<option ".$sel." value='". $m['username']."&".$t_id."'>".$m['fname']." ".$m['lname']."</option>";
                                                                }                                                         
                                                                ?>                                                    
                                                            </select>     
                                                            
                                                        </div>
                                                    </li>
                                                    
                                                    
                                                <?php } ?>
                                                    </ul>
                                            
                                        
                                        </div>                                 
                                    </div>
                                </div>
                                 <div class="card col s12">
                        <a class="anchor" id="budget"></a>
                        <center><h5><strong>Budget Tracking</strong></h5></center><hr>                 
                        <div class="row">
                            <form method="POST">
                                <div class="input-field col s12">                                                          
                                    <input type="text" name="description" required placeholder="Type Description">  
                                    <label for="description">Decription of transaction</label>
                                </div>
                                <div class="input-field col s12 m3">                                                          
                                    <input type="text" class="datepicker" name="date" required placeholder="Select date">  
                                    <label for="description">Transaction Date</label>
                                </div>
                                <div class="input-field col s12 m3">                                                          
                                    <input type="number" name="amount" step=0.01 min=0 placeholder="Amount (LKR)">  
                                    <label for="description">Amount (LKR) </label>
                                </div>
                                <div class="input-field col s12 m3">                                                          
                                    <select name="type">                                      
                                      <option value="inc" selected>Income</option>
                                      <option value="exp">Expense</option>                                      
                                    </select>
                                    <label>Transaction type</label>
                                </div>
                                <div class="col s12 m3 right-align"> 
                                    <button class="btn-large green waves-light waves-effect wide" name="add_transaction" type="submit" value="Add">Add</button>
                                </div>
                            </form> 
                        </div>
                        <div class="col s12 center-align"><h5>Income</h5></div>                           
                            <table class="responsive-table highlight">
                                <thead>
                                  <tr style="font-size:10pt">
                                      <th>Date</th>
                                      <th>Description</th>
                                      <th>Added by</th>
                                      <th class="right-align">Amount (LKR)</th>
                                      <th></th>
                                  </tr>
                                </thead>
                               

                                <tbody>
                                    <?php $tot_income = 0; foreach ($income as $inc) { ?>
                                    <tr>
                                        <td style="font-size:9pt"><?= $inc['date']; ?></td>
                                        <td style="font-size:11pt"><?= $inc['description']; ?></td>
                                        <td style="font-size:9pt"><?= $inc['added_by']; ?></td>
                                        <td style="font-size:11pt" class="right-align"><?= number_format($inc['amount'],2,"."," "); ?></td>
                                        <td><a href="<?=base_url()?>index.php/home/delete_transaction_decorations/<?= $event_id."/".($inc['id']*23)."/".$inc['type'] ?>" class="secondary-content"><i class="material-icons red-text tooltipped" data-position="left" data-tooltip="Delete Entry">remove</i></a></td>
                                    </tr>
                                    <?php $tot_income += $inc['amount']; } ?>
                                </tbody>
                                 <tfoot>
                                  <tr style="font-size:10pt">
                                      <th></th>
                                      <th></th>
                                      <th class="right-align">Total</th>
                                      <th class="right-align" style="font-size:11pt"><?= number_format($tot_income,2,"."," "); ?></th>
                                      <th></th>
                                  </tr>
                                </tfoot>
                            </table> 
                        
                         <div class="col s12 center-align"><h5>Expenses</h5></div>                           
                            <table class="responsive-table highlight">
                                <thead>
                                  <tr style="font-size:10pt">
                                      <th>Date</th>
                                      <th>Description</th>
                                      <th>Added by</th>
                                      <th class="right-align">Amount (LKR)</th>
                                      <th></th>
                                  </tr>
                                </thead>

                                <tbody>
                                    <?php $tot_expenses = 0; foreach ($expenses as $exp) { ?>
                                    <tr>
                                        <td style="font-size:9pt"><?= $exp['date']; ?></td>
                                        <td style="font-size:11pt"><?= $exp['description']; ?></td>
                                        <td style="font-size:9pt"><?= $exp['added_by']; ?></td>
                                        <td style="font-size:11pt" class="right-align"><?= number_format($exp['amount'],2,"."," "); ?></td>
                                        <td><a href="<?=base_url()?>index.php/home/delete_transaction_decorations/<?= $event_id."/".($exp['id']*23)."/".$exp['type'] ?>" class="secondary-content"><i class="material-icons red-text tooltipped" data-position="left" data-tooltip="Delete Entry">remove</i></a></td>
                                    </tr>
                                    <?php 
                                        $tot_expenses += $exp['amount']; } 
                                        $diff = $tot_income - $tot_expenses;
                                            
                                        if ($diff < 0)
                                            {
                                                $col = "red";
                                            } 
                                        else    
                                            {
                                                $col="green";
                                            }    
                                    ?>
                                </tbody>
                                <tfoot>
                                  <tr style="font-size:10pt">
                                      <th></th>
                                      <th></th>
                                      <th class="right-align">Total</th>
                                      <th class="right-align"  style="font-size:11pt"><?= number_format($tot_expenses,2,"."," "); ?></th>
                                      <th></th>
                                  </tr>
                                </tfoot>
                            </table> 
                        
                         <div class="col s12 center-align" style="margin-top:20px;"><h6 style="font-weight:bold;color:<?= $col ?>">Difference = <?= number_format($tot_income - $tot_expenses,2,"."," "); ?> LKR</h6></div><br>&nbsp;         
                        </div>   
                    </div>
                </div>
                
               
                        
            </div>
        </div>
                
                    <?php } ?>
                                                
            
          
    </body>
    
    <script src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>js/materialize.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script>
        $(document).ready(function(){
            $('.datepicker').datepicker(
            {
                format: 'yyyy-mm-dd',
                maxDate: new Date()
            });  
            $('select').formSelect();
            $('.materialboxed').materialbox();
            $('.tooltipped').tooltip();
            $('.ckbx').change(function(){
                
                if (this.checked){
                    var value = $(this).val();
                    var msg = "completed";
                }
                else {
                    var value = 0;
                    var msg = "pending";
                }
                
                var id = this.getAttribute("name");                        

                $.ajax({
                     url:'<?=base_url()?>index.php/home/check_decorations',
                     method: 'post',
                     data: {id: id, value: value},
                     dataType: 'json',
                     complete: function(){M.toast({html: 'Marked as ' + msg, displayLength: 2000 });}
                    });
            });

            $('.assigned_to').change(function(){               
                
                var value = $(this).val();   
                var name = this.options[this.selectedIndex].innerHTML;
                $.ajax({
                     url:'<?=base_url()?>index.php/home/assigned_to_decorations',
                     method: 'post',
                     data: {value: value},
                     dataType: 'json',
                     complete: function(){M.toast({html: 'Task assigned to ' + name, displayLength: 2000 });}
                    });
            });
            
            
                        
            
             
        });

    
    </script>
    <script src="<?php echo base_url(); ?>/js/scroll.js"></script>
</html>

