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
                                    <li><a href="#crew">Crew</a></li>
                                    <li><a href="#tasks">Tasks</a></li>
                                    <li><a href="#budget">Budget tracking</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
               </div>
                </div>
                <div class="col m9" style="margin-top:30px">
                    
                    <div class="row"> 
                    <a href="<?php echo base_url(); ?>index.php/collaborate" class="breadcrumb">My Collaborations</a>                      
                    <a href="" class="breadcrumb"><?php echo $val['name']; ?> - Markting Department</a>                    
                </div>
                    
                    <div class="row">
                    <div class="col m5">
                        <div class="col s12 card">
                                           
                                
                                   <a class="anchor" id="crew"></a>
                                        <h5 class="center-align row">
                                            Crew
                                        </h5> 
                        
                                    <hr>
                                    
                        
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
                                                     
                                                    </li>
                                                      
                                                     <?php } ?>
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
                                           Tasks
                                        </h5> 
                                    <hr>
                                      
                                               
                                    <div class='row'>
                                        <div class='col m12'>
                                                <ul class="collection with-header">

                                                <?php foreach($tasks as $t){ ?>
                                                
                                                    <li class="collection-item">
                                            <div><?php echo $t['task_name']; ?>
                                          
                                                <a  class="secondary-content">
                                                     <label>
                                                    <?php if($t['assigned_to'] == $_SESSION['username'] || $t['completed_by'] == null || $t['completed_by'] == $_SESSION['username']) { ?>
                                                   
                                                    <input type="checkbox" class="ckbx filled-in" <?php if($t['completion']==1) {echo "checked";} ?>  value=1 id="<?php echo $t['id']; ?>" name="<?php echo $t['id']; ?>"/>
                                                    <span></span>
                                                    
                                                    <?php } else { ?>
                                                         <span>(completed)</span>
                                                         <?php } ?>
                                                         </label>
                                                </a>  
                                            </div>
                                            <hr>
                                            <div>
                                                <label>Currently assigned to</label>
                                                <select class="browser-default assigned_to" disabled>
                                                    <option value="" selected>Other / No one</option>
                                                    <?php foreach($crew as $m){
                                                        if ($t['assigned_to']==$m['username']){
                                                            $sel = "selected";
                                                            echo "<option ".$sel." value='". $m['username']."&".$t_id."'>".$m['fname']." ".$m['lname']."</option>";
                                                        }
                                                       
                                                        $t_id = $t['id']*23;
                                                        
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
                                    <input type="text" class="datepicker" name="date" required placeholder="Click here" id="td" onkeydown="td_cal()">  
                                    <label for="description">Transaction Date</label>
                                </div>
                                <div class="input-field col s12 m3">                                                          
                                    <input type="number" name="amount" step=0.01 min=0 placeholder="Amount (LKR)" required>  
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
                                        <?php if($inc['added_by'] == $_SESSION['username'])
                                        { ?>
                                        
                                        <td><a href="<?=base_url()?>index.php/collaborate/delete_transaction_marketing/<?= $event_id."/".($inc['id']*23)."/".$inc['type'] ?>" class="secondary-content"><i class="material-icons red-text tooltipped" data-position="left" data-tooltip="Delete Entry">remove</i></a></td>
                                        
                                        <?php } ?>
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
                                        <?php if($exp['added_by'] == $_SESSION['username'])
                                        { ?>
                                        
                                        <td><a href="<?=base_url()?>index.php/collaborate/delete_transaction_marketing/<?= $event_id."/".($exp['id']*23)."/".$exp['type'] ?>" class="secondary-content"><i class="material-icons red-text tooltipped" data-position="left" data-tooltip="Delete Entry">remove</i></a></td>
                                        
                                        <?php } ?>
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
            $('.materialboxed').materialbox();
            $('.tooltipped').tooltip();
            $('.datepicker').datepicker(
            {
                format: 'yyyy-mm-dd',
                maxDate: new Date()
            });  
            $('select').formSelect();
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
                     url:'<?=base_url()?>index.php/home/check_marketing',
                     method: 'post',
                     data: {id: id, value: value},
                     dataType: 'json',
                     complete: function(){M.toast({html: 'Marked as ' + msg, displayLength: 2000 });}
                    });
            }); 
            
             $('#td').keypress(function(){
                $('#td').click();
            });
            
             
        });

    
    </script>
    <script src="<?php echo base_url(); ?>/js/scroll.js"></script>
</html>

