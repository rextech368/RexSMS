<?php $students = $this->db->get_where('student', array('student_id' => $student_id))->result_array();
        foreach($students as $key => $student):?>

<div class="row">
<div class="col-sm-12">
<div class="panel panel-info">
                          
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body table-responsive">
								
								
				  	<div class="row panel-body">
                    <div class="col-sm-6">
						
					<div class="alert alert-success"><?php echo get_phrase('admission_form'); ?>&nbsp;-&nbsp;PART A</div>

				
                <?php echo form_open(base_url() . 'admin/new_student/update/' .$student_id , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
				<div class="form-group"> 
					 <div class="col-sm-12">
  		  			  <input type='file' name="userfile" onChange="readURL(this);" style="color:red">
       				 <img id="blah"  src="<?=$this->crud_model->get_image_url('student', $student['student_id'])?>" height="150" width="150"/ style="border:1px dotted red">
					 
					</div>
					</div>	
					<div class="form-group">
                     <label class="col-md-12" for="example-text"><?php echo get_phrase('running_session');?> <b style="color:red">*</b></label>
                     <div class="col-sm-12">
                        <input type="text" class="form-control" name="session"  value="<?php echo $this->db->get_where('settings', array('type' => 'session'))->row()->description; ?>" readonly="true">
                        <input type="text" class="form-control" name="roll" value="<?php echo $student['roll'];?>" >
                        <p style="color:green">You can change this to manual student admission number</p>
                     </div>
                  </div>
						<div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('full_name');?></label>
                    <div class="col-sm-12">
							<input type="text" class="form-control" value="<?php echo $student['name'];?>" name="name" autofocus>
						</div>
					</div>

					<div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('parent');?></label>
                    <div class="col-sm-12">
							<select name="parent_id" class="form-control select2" style="width:100%" >
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php 
								$parents = $this->db->get('parent')->result_array();
								foreach($parents as $parent):
									?>
                            		<option value="<?php echo $parent['parent_id'];?>"<?php if($student['parent_id'] == $parent['parent_id']) echo 'selected';?>>
										<?php echo $parent['name'];?>
                                    </option>
                                <?php
								endforeach;
							  ?>
                          </select>
						 	<a href="<?php echo base_url();?>admin/parent/"><button type="button" class="btn btn-info btn-circle btn-xs"><i class="fa fa-plus"></i></button></a>

						</div> 
						</div>
					
					<div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('class');?></label>
                    <div class="col-sm-12">
							<select name="class_id" class="form-control select2" style="width:100%"id="class_id" onchange="return get_class_sections(this.value)" />
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php 
								$classes = $this->db->get('class')->result_array();
								foreach($classes as $key => $class):
									?>
                            		<option value="<?php echo $class['class_id'];?>"<?php if($student['class_id'] == $class['class_id']) echo 'selected';?>>
											<?php echo $class['name'];?>
                                            </option>
                                <?php
								endforeach;
							  ?>
                          </select>
		<a href="<?php echo base_url();?>admin/classes/"><button type="button" class="btn btn-info btn-circle btn-xs"><i class="fa fa-plus"></i></button></a>


						</div> 
					</div>

					<div class="form-group">
                 	<label class="col-md-9" for="example-text"><?php echo get_phrase('section');?></label>
                    <div class="col-sm-12">
		                        <select name="section_id" class="form-control" style="width:100%" id="section_selector_holder" />
		                            <option value=""><?php echo get_phrase('select_class_first');?></option>
			                        
			                    </select>
	                            <a href="<?php echo base_url();?>admin/section/"><button type="button" class="btn btn-info btn-circle btn-xs"><i class="fa fa-plus"></i></button></a>
			                </div>
					</div>						
					

					<div class="form-group">
                 	<label class="col-md-9" for="example-text"><?php echo get_phrase('birthday');?></label>
                    <div class="col-sm-12">
							<input type="text"  value="<?php echo $student['birthday'];?>" class="form-control" name="birthday">
						</div> 
					</div>
					
					
					<div class="form-group">
                 	<label class="col-md-9" for="example-text"><?php echo get_phrase('age');?></label>
                    <div class="col-sm-12">
							<input type="text" class="form-control" name="age" id="age" value="<?php echo $student['age'];?>" readonly="true" />
						</div> 
					</div>
					
					<div class="form-group">
                 	<label class="col-md-9" for="example-text"><?php echo get_phrase('place_birth');?></label>
                    <div class="col-sm-12">
							<input type="text" class="form-control" value="<?php echo $student['place_birth'];?>" name="place_birth" value="" >
						</div> 
					</div>
					
					<div class="form-group">
                 	<label class="col-md-9" for="example-text"><?php echo get_phrase('gender');?></label>
                    <div class="col-sm-12">
							<select name="sex" class="form-control select2" style="width:100%" />
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="male"<?php if($student['sex']== 'male') echo 'selected';?>><?php echo get_phrase('male');?></option>
                              <option value="female" value="male"<?php if($student['sex']== 'female') echo 'selected';?>><?php echo get_phrase('female');?></option>
                          </select>
						</div> 
					</div>
					
					<div class="form-group">
                 	<label class="col-md-9" for="example-text"><?php echo get_phrase('mother_tongue');?></label>
                    <div class="col-sm-12">
							<input type="text" class="form-control" value="<?php echo $student['m_tongue'];?>" name="m_tongue">
						</div> 
					</div>
					
					<div class="form-group">
                 	<label class="col-md-9" for="example-text"><?php echo get_phrase('religion');?></label>
                    <div class="col-sm-12">
							<input type="text" class="form-control" value="<?php echo $student['religion'];?>" name="religion">
						</div> 
					</div>
					
					<div class="form-group">
                 	<label class="col-md-9" for="example-text"><?php echo get_phrase('blood_group');?></label>
                    <div class="col-sm-12">
							<input type="text" class="form-control"  value="<?php echo $student['blood_group'];?>" name="blood_group">
						</div> 
					</div>
					
					<div class="form-group">
                 	<label class="col-md-9" for="example-text"><?php echo get_phrase('address');?></label>
                    <div class="col-sm-12">
					<textarea name="address" class="form-control" rows=""><?php echo $student['address'];?></textarea>
						</div> 
					</div>
					
					
					<div class="form-group">
                 	<label class="col-md-9" for="example-text"><?php echo get_phrase('city');?></label>
                    <div class="col-sm-12">
							<input type="text" class="form-control" value="<?php echo $student['city'];?>" name="city">
						</div> 
					</div>
					

			</div>
					
					
					<div class="col-sm-6">
					
					<div class="alert alert-success"><?php echo get_phrase('admission_form'); ?>&nbsp;-&nbsp;PART B</div>
					
				<div class="form-group">
                 	<label class="col-md-9" for="example-text"><?php echo get_phrase('state');?></label> 
                    <div class="col-sm-12">
							<input type="text" class="form-control" value="<?php echo $student['state'];?>" name="state">
						</div> 
					</div>
					
						<div class="form-group">
                 	<label class="col-md-9" for="example-text"><?php echo get_phrase('nationality');?></label>
                    <div class="col-sm-12">
							<input type="text" class="form-control" value="<?php echo $student['nationality'];?>" name="nationality">
						</div> 
					</div>
					
					<div class="form-group">
                 	<label class="col-md-9" for="example-text"><?php echo get_phrase('phone');?></label>
                    <div class="col-sm-12">
							<input type="text" class="form-control" value="<?php echo $student['phone'];?>" name="phone">
						</div> 
					</div>
					
					<div class="form-group">
                 	<label class="col-md-9" for="example-text"><?php echo get_phrase('email');?></label>
                    <div class="col-sm-12">
							<input type="text" class="form-control" value="<?php echo $student['email'];?>" name="email">
						</div>
					</div>
					

						<div class="form-group">
                 	<label class="col-md-9" for="example-text"><?php echo get_phrase('previous_school_name');?></label>
                    <div class="col-sm-12">
							<input type="text" class="form-control" value="<?php echo $student['ps_attended'];?>" name="ps_attended">
						</div>
					</div>
					
					<div class="form-group">
                 	<label class="col-md-9" for="example-text"><?php echo get_phrase('the_address');?></label>
                    <div class="col-sm-12">
						<textarea name="ps_address" class="form-control" rows=""><?php echo $student['ps_address'];?></textarea>
						</div>
					</div>
					
						<div class="form-group">
                 	<label class="col-md-9" for="example-text"><?php echo get_phrase('purpose_of_leaving');?></label>
                    <div class="col-sm-12">
							<input type="text" class="form-control" name="ps_purpose" value="<?php echo $student['ps_purpose'];?>">
						</div>
					</div>

						<div class="form-group">
                 	<label class="col-md-9" for="example-text"><?php echo get_phrase('class_in_which_was_studying');?></label>
                    <div class="col-sm-12">
							<input type="text" class="form-control" value="<?php echo $student['class_study'];?>" name="class_study">
						</div>
					</div>

					<div class="form-group">
                 	<label class="col-md-9" for="example-text"><?php echo get_phrase('date_of_leaving');?></label>
                    <div class="col-sm-12">
							<input type="date" value="<?php echo $student['date_of_leaving'];?>" id="example-date-input"  class="form-control" name="date_of_leaving">

						</div> 
					</div>
					
						<div class="form-group">
                 	<label class="col-md-9" for="example-text"><?php echo get_phrase('admission_date');?></label>
                    <div class="col-sm-12">
							<input type="date" value="<?php echo $student['am_date'];?>" id="example-date-input" class="form-control datepicker" name="am_date">

						</div> 
					</div>

				<div class="form-group">
                 	<label class="col-md-9" for="example-text"><?php echo get_phrase('transfer_certificate');?></label>
                    <div class="col-sm-12">
							<select name="tran_cert" class="form-control select2" style="width:100%">
                              <option value=""><?php echo get_phrase('select');?></option>
                              
                            <option value="Yes"<?php if($student['tran_cert']== 'Yes') echo 'selected';?>>Yes</option>
                            <option value="No"<?php if($student['tran_cert']== 'No') echo 'selected';?>>No</option> 
                          </select>
						</div> 
					</div>
					
				<div class="form-group">
                 	<label class="col-md-9" for="example-text"><?php echo get_phrase('birth_certificate');?></label>
                    <div class="col-sm-12">
							<select name="dob_cert" class="form-control select2" style="width:100%">
                              <option value=""><?php echo get_phrase('select');?></option>
                              
							<option value="Yes"<?php if($student['dob_cert']== 'Yes') echo 'selected';?>>Yes</option>
                            <option value="No"<?php if($student['dob_cert']== 'No') echo 'selected';?>>No</option> 
                          </select>
						</div> 
					</div>

				<div class="form-group">
                 	<label class="col-md-9" for="example-text"><?php echo get_phrase('any_given_marksheet');?></label>
                    <div class="col-sm-12">
							<select name="mark_join" class="form-control select2" style="width:100%">
                              <option value=""><?php echo get_phrase('select');?></option>
                              
							<option value="Yes"<?php if($student['mark_join']== 'Yes') echo 'selected';?>>Yes</option>
                            <option value="No"<?php if($student['mark_join']== 'No') echo 'selected';?>>No</option> 
                          </select>
							
						</div> 
					</div>

						<div class="form-group">
                 	<label class="col-md-9" for="example-text"><?php echo get_phrase('physical_handicap');?></label>
                    <div class="col-sm-12">
							<select name="physical_h" class="form-control select2" style="width:100%">
                              <option value=""><?php echo get_phrase('select');?></option>
                              
							  <option value="Yes"<?php if($student['physical_h']== 'Yes') echo 'selected';?>>Yes</option>
                            <option value="No"<?php if($student['physical_h']== 'No') echo 'selected';?>>No</option> 
                          </select>
						</div> 
					</div>

						
						
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo get_phrase('Student House');?></label>
                    	<div class="col-sm-12">
							<select name="house_id" class="form-control select2" style="width:100%">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php 
								$house = $this->db->get('house')->result_array();
								foreach($house as $house):
									?>
                            		<option value="<?php echo $house['house_id'];?>"<?php if($student['house_id']== $house['house_id']) echo 'selected';?>>
										<?php echo $house['name'];?>
                                    </option>
                                <?php
								endforeach;
							  ?>
                          </select>
						 	<a href="<?php echo base_url();?>studenthouse/studentHouse/"><button type="button" class="btn btn-info btn-circle btn-xs"><i class="fa fa-plus"></i></button></a>
						</div> 
					</div>
						
				<div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('Student Club');?></label>
                    <div class="col-sm-12">
							<select name="club_id" class="form-control select2" style="width:100%">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php 
								$club = $this->db->get('club')->result_array();
								foreach($club as $club):
									?>
                            		<option value="<?php echo $club['club_id'];?>"<?php if($student['club_id']== $club['club_id']) echo 'selected';?>>
										<?php echo $club['club_name'];?>
                                    </option>
                                <?php
								endforeach;
							  ?>
                          </select>
							<a href="<?php echo base_url();?>admin/club/"><button type="button" class="btn btn-info btn-circle btn-xs"><i class="fa fa-plus"></i></button></a>

						</div> 
					</div>
						

					
					</div>
					</div>
					
					


 <div class="form-group">
						
			<button type="submit" class="btn btn-success btn-sm btn-rounded btn-block"> <i class="fa fa-plus"></i>&nbsp;<?php echo get_phrase('edit_student');?></button>
			<img id="install_progress" src="<?php echo base_url() ?>assets/images/loader-2.gif" style="margin-left: 20px; display: none"/>
						
					</div>
					
					
                <?php echo form_close();?>
	
				</div>
			</div>		
		</div>	
    </div> 
</div>

<?php endforeach;?>



<script type="text/javascript">

	function get_class_sections(class_id) {

    	$.ajax({
            url: '<?php echo base_url();?>admin/get_class_section/' + class_id ,
            success: function(response)
            {
                jQuery('#section_selector_holder').html(response);
            }
        });

    }

</script>


<script type="text/javascript">

	function CheckPasswordStrength(password) {
	var password_strength = document.getElementById("password_strength");

        //TextBox left blank.
        if (password.length == 0) {
            password_strength.innerHTML = "";
            return;
        }

        //Regular Expressions.
        var regex = new Array();
        regex.push("[A-Z]"); //Uppercase Alphabet.
        regex.push("[a-z]"); //Lowercase Alphabet.
        regex.push("[0-9]"); //Digit.
        regex.push("[$@$!%*#?&]"); //Special Character.

        var passed = 0;

        //Validate for each Regular Expression.
        for (var i = 0; i < regex.length; i++) {
            if (new RegExp(regex[i]).test(password)) {
                passed++;
            }
        }

        //Display status.
        var color = "";
        var strength = "";
        switch (passed) {
            case 0:
            case 1:
            case 2:
                strength = "Weak";
                color = "red";
                break;
            case 3:
                 strength = "Medium";
                color = "orange";
                break;
            case 4:
                 strength = "Strong";
                color = "green";
                break;
               
        }
        password_strength.innerHTML = strength;
        password_strength.style.color = color;

if(passed <= 2){
         document.getElementById('show').disabled = true;
        }else{
            document.getElementById('show').disabled = false;
        }

    }

</script>

<script type="text/javascript">
        $(function() {
            $('input[name="birthday"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true
            }, 
            function(start, end, label) {
                var years = moment().diff(start, 'years');
               // alert("You are " + years + " years old.");
                $("#age").val(years);
            });
        });
</script>

<script>
        $(document).ready(function() {
            var class_id = $('#class_id').val();
            var student_id = '<?php echo $student_id;?>';
            get_class_sections(class_id,student_id);
            
        });
    </script>