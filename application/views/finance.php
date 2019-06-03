<html>
    <head>
        <link rel="stylesheet" href="<?php echo base_url(); ?>/css/materialize.css"> 
        <title> Manage Events | Thousand Plus Events </title>
        <link rel="icon" href="<?php echo base_url(); ?>images/favicon.png" type="image/png"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <noscript>
            <meta http-equiv="refresh" content="0;url=<?php echo base_url(); ?>index.php/home">
        </noscript>
    
    </head>  
    
    <body>  
        
   
        
        
            
        
        
        
        <div class="row">
           <div class="col s12 m3">  
                <div class="col s6 m12 center-align">
                    

                    

                    <br>&nbsp;
                </div>
                <div class="col s6 m12 center-align">
                    

                </div>  
                <div class="col s12 left-align">                  
                    <div id="header">
                        <div id="header-inner"> 
                            <div class="row">
                                <ul class="section table-of-contents">
                                    Quick Links
                                    <li><a href="#crew">Add crew</a></li>
                                    <li><a href="#tasks">Add tasks</a></li>
                                    <li><a href="#company">Companies/ Sponsors info</a></li>
                                    <li><a href="#budget">Budget tracking</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
               </div>

            </div>


            <div class="col s12 m9" style="margin-top:30px">

                <div class="row"> 
                    

                    <a href="" class="breadcrumb">Finance Department</a>                    
                </div>

                <div class="row">
                <div class="col s12 m5">
                    <div class="card col s12">
                        <a class="anchor" id="crew"></a>
                        <center><h5><strong>Add crew</strong></h5></center><hr>                   
                        <div class="row">
                            <form method="POST">
                                <div class="input-field col s12 m8">                                                          
                                    <input type="text" name="user_crew" required class="validate" placeholder="Username">  
                                    <label for="user_crew">Type Username</label>
                                </div>
                                <div class="col s12 m4 right-align"> 
                                    <button class="btn-large green waves-light waves-effect" name="add_crew" type="submit" value="Add">Add</button>
                                </div>
                            </form>
                        </div>

                        <div>                                        
                            <div class="row">
                                <div class="col s12">
                                     <ul class="collection">     
                                       



                                        <li class="collection-item avatar">
                                          

                                         

                                   </ul>
                                </div>                                 
                            </div>
                        </div>
                    </div>




                    <div id="modal1" class="modal">
                        <form method="post">
                            <div class="modal-content">
                                <h5>Add new Company / Sponsor</h5>                                    
                                    <div class="input-field">
                                        <input type="text" id="c_name" name="c_name" required >
                                        <label for="c_name">Name*</label>  
                                    </div>                                                        
                                    <div class="input-field">
                                        <input type="text" id="c_address" name="c_address">
                                        <label for="c_address">Address</label>  
                                    </div>
                                    <div class="input-field">
                                        <input type="text" name="c_telephone" id="c_telephone">
                                        <label for="c_telephone">Telephone</label>  
                                    </div>
                                    <div class="input-field">
                                        <input type="email" name="c_email" id="c_email">
                                        <label for="c_website">Email</label>  
                                    </div>
                                    <div class="input-field">
                                        <input type="text" name="c_website" id="c_website">
                                        <label for="c_website">Website</label>  
                                    </div>                                       
                            </div>

                            <div class="modal-footer">
                                <button class="modal-close waves-effect waves-green red btn" type="reset" name="close" value="close">Cancel</button>
                                <button class="modalwaves-effect waves-green green btn" type="submit" name="add_company" value="add_company">Add</button>
                            </div>
                        </form>
                    </div>

                    <div class="card col s12 row">
                        <a class="anchor" id="company"></a>
                        <center><h5><strong>Companies / Sponsors Info</strong></h5></center><hr>    
                        <div class=" right-align">
                            <a class="waves-effect waves-light btn large modal-trigger green" href="#modal1">Add New</a>                                                        
                        </div><br>    
                       <ul class="collapsible popout">
                            
                            <li>
                                <div class="collapsible-header">
                                   
                                </div>
                                


                                        
                                            <form method="post">
                                                <div class="modal-content">
                                                    <h5>Edit Company / Sponsor</h5><br>                              


                                                        <div class="input-field">
                                                            <input type="text" id="c_name" name="c_name" required value="<?= $com['c_name']; ?>" >
                                                            <label for="c_name">Name*</label>  
                                                        </div>

                                                        <div class="input-field">
                                                            <input type="text" id="c_address" name="c_address" value="<?= $com['c_address']; ?>">
                                                            <label for="c_address">Address</label>  
                                                        </div>

                                                        <div class="input-field">
                                                            <input type="text" name="c_telephone" id="c_telephone"  value="<?= $com['c_telephone']; ?>">
                                                            <label for="c_telephone">Telephone</label>  
                                                        </div>

                                                        <div class="input-field">
                                                            <input type="email" name="c_email" id="c_email"  value="<?= $com['c_email']; ?>">
                                                            <label for="c_website">Email</label>  
                                                        </div>

                                                        <div class="input-field">
                                                            <input type="text" name="c_website" id="c_website"  value="<?= $com['c_website']; ?>">
                                                            <label for="c_website">Website</label>  
                                                        </div>   

                                                        <div class="input-field">
                                                            <input readonly type="text" id="c_id" name="c_id" required value="<?= $com['id']*23; ?>" >
                                                            <label for="c_id">ID</label>  
                                                        </div>   

                                                </div>
                                                <div class="modal-footer">
                                                    <button class="modal-close waves-effect waves-green red btn" type="reset" name="close" value="close">Cancel</button>
                                                    <button class="waves-effect waves-green green btn" type="submit" name="edit_company" value="edit_company">Save</button>

                                                </div>
                                            </form>
                                        </div>
                                    </span>
                                </div>                                  
                            </li>    

                            

                           </ul>                
                    </div>                     
                </div>
                <div class="col s12 m7">
                    <div class="card col s12">
                        <a class="anchor" id="tasks"></a>
                        <center><h5><strong>Add tasks</strong></h5></center><hr>                 
                        <div class="row">
                            <form method="POST">
                                <div class="input-field col s12 m9">                                                          
                                    <input type="text" name="tasks" required class="validate" placeholder="Type new task">  
                                    <label for="tasks">Add new task</label>
                                </div>
                                <div class="col s12 m3 right-align"> 
                                    <button class="btn-large green waves-light waves-effect" name="add_task" type="submit" value="Add">Add</button>
                                </div>
                            </form> 
                        </div>

                        <div class='row'>
                            <div class='col s12'>
                                    <ul class="collection with-header">
                                    <?php foreach($tasks as $t){ ?>
                                        <li class="collection-item">
                                            <div><?php echo $t['task_name']; ?>
                                            <a href="<?=base_url()?>index.php/home/delete_task_finance/<?php echo $event_id."/".$t['id']."/".$t['dept_id']; ?> " class="secondary-content"><i class="material-icons red-text tooltipped" data-position="left" data-tooltip="Remove task">remove</i></a>
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
                                        <td><a href="<?=base_url()?>index.php/home/delete_transaction_finance/<?= $event_id."/".($inc['id']*23)."/".$inc['type'] ?>" class="secondary-content"><i class="material-icons red-text tooltipped" data-position="left" data-tooltip="Delete Entry">remove</i></a></td>
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
                                        <td><a href="<?=base_url()?>index.php/home/delete_transaction_finance/<?= $event_id."/".($exp['id']*23)."/".$exp['type'] ?>" class="secondary-content"><i class="material-icons red-text tooltipped" data-position="left" data-tooltip="Delete Entry">remove</i></a></td>
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
    </body>
    
    
</html>

