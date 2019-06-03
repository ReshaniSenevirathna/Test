<!DOCTYPE html>
<html>
    <head>
    
        <title> Create Event | Thousand Plus Events</title>                
    </head>  
    
    <body>        
        
        
        <div class="container">
            
            <div class="row">
                           
                

                <div class="col m8 offset-m2"> 
                    <form method="POST" enctype="multipart/form-data">
                    
                        <div class="row">
                            <div class="col m12">
                                <center><br><h2>Create Event</h2> <br></center>
                            </div>
                        </div>
                       
                       
                        <div class="input-field col m12">                                
                                                           
                                <input type="text" id="name" name="name" required placeholder="Name of the event" class="validate">                               
                                <label for="name">Name of the Event</label>
                        </div>

                       

                       
                        <div class="input-field col m12">
                            <select name="type">
                                <option value="" disabled>Choose</option>
                                <option value="Wedding">Wedding</option>
                                <option value="Birthday">Birthday</option>
                                <option value="Get Together">Get Together</option>
                                <option value="Hackathon">Hackathon</option>        
                            </select>
                            <label>Select Event Type</label>
                        </div>

                      

                        <div class="input-field col m12">                           
                            <input type="text" name="date" class="datepicker"  required placeholder="Choose event date" class="validate" id="td"> 
                            <label for="datepicker"> Choose event date</label>
                        </div>

                       

                        <div class="input-field col m12">                           
                            <input type="text" name="time" class="timepicker"  required placeholder="Choose event time" class="validate" id="tt" > 
                            <label for="timepicker"> Choose event time</label>
                        </div>

                       
                        
                        <div class="input-field col m12">
                          <textarea id="textarea1" class="materialize-textarea" name="desc" placeholder="Provide a description" class="validate"></textarea>
                          <label for="textarea1">Description</label>
                        </div>
                        
                       

                        <div class="input-field col m12">                                                          
                            <input type="text" id="name" name="name" required value="You (<?php echo $_SESSION['username'] ; ?>)" readonly disabled class="validate">  
                            <label for="name">Event admin</label>
                        </div>
                        
                        <div class="file-field input-field col m12">
                          <div class="btn black waves-light waves-effect green">
                            <span>Cover Picture</span>
                            <input type="file" accept="image/jpeg, image/png" onchange="loadFile(event)" name="fileToUpload">
                          </div>
                          <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" value="Select cover picture (optional)" class="validate">
                          </div>
                            
                        <img id="output" style="max-width:100%"/>
                        </div>  
                        
                        <div class="input-field col m12 right-align">                                                          
                             <button name="btn_save" id="btn_save" type="submit" class="btn-large waves-light waves-effect green" value="formSubmit">Create Event </button>
                        </div> 
                    </form>
            </div>
         
        </div>
        </div>
        
     
    </body>
    
    <script src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>js/materialize.js"></script>
   

    <script>

        $(document).ready(function(){
            $('.datepicker').datepicker(
            {
                format: 'yyyy-mm-dd',
                minDate: new Date()
            });       
            $('.timepicker').timepicker({
                twelveHour: false
            });       
            $('select').formSelect();
            
             $('#td').focus(function(){
                $('#td').click();
            });
            
            $('#tt').keypress(function(){
                $('#tt').click();
            });
            
        });             

        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
        };
        
        
       

    </script>
    
   
</html>

