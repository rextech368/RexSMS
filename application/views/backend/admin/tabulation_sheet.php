<div class="row">
    <div class="col-sm-12">
		<div class="panel panel-info">
            <div class="panel-heading"> <i class="fa fa-users"></i>&nbsp;&nbsp;<?php echo get_phrase('view_student_scores');?></div>
                <div class="panel-body table-responsive">
			
                    <!----CREATION FORM STARTS---->

                	<?php echo form_open(base_url() . 'admin/tabulation_sheet' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top', 'enctype' => 'multipart/form-data'));?>
					<?php
						$term	= $term;
						if($term == '')
						$term = get_settings('term');
						else
						$term	 = $term;
						$session = $session;
						if($session == '')
						$session = get_settings('session');
						else
						$session = $session;
					?>
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo get_phrase('Running Session');?></label>
							<div class="col-sm-12">
								<select name="session" class="form-control select2" >
									  <?php for($i = 0; $i < 5; $i++):?>
										  <option value="<?php echo (2020+$i);?>-<?php echo (2020+$i+1);?>"
											<?php if($session == (2020+$i).'-'.(2020+$i+1)) echo 'selected';?>>
											  <?php echo (2020+$i);?>-<?php echo (2020+$i+1);?>
										  </option>
									  <?php endfor;?>
								 </select>
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo get_phrase('select_current_term');?></label>
							<div class="col-sm-12">
								<select name="term" class="form-control">
									<option value="1" <?php if ($term == '1') echo 'selected';?>> First Term</option>
									<option value="2" <?php if ($term == '2') echo 'selected';?>> Second Term</option>
									<option value="3" <?php if ($term == '3') echo 'selected';?>> Third Term</option>
								</select>
							</div>
						</div>
                    
                            <div class="form-group">
                                    <label class="col-md-12" for="example-text"><?php echo get_phrase('select_exam');?></label>
                                <div class="col-sm-12">
                                    <select name="exam_id" class="form-control select2">
                                        <?php $exams =  $this->db->get('exam')->result_array();
                                        foreach($exams as $key => $exam):?>
                                        <option value="<?php echo $exam['exam_id'];?>"<?php if($exam_id == $exam['exam_id']) echo 'selected="selected"' ;?>>
										<?php echo $exam['name'];?></option>
                                        <?php endforeach;?>
                                </select>
                                </div>
                            </div>


                            <div class="form-group">
                                    <label class="col-md-12" for="example-text"><?php echo get_phrase('select_class');?></label>
                                <div class="col-sm-12">
                                    <select name="class_id"  class="form-control select2" onchange="show_students(this.value)">
                                        <option value=""><?php echo get_phrase('select_class');?></option>
                                        <?php $classes =  $this->db->get('class')->result_array();
                                        foreach($classes as $key => $class):?>
                                        <option value="<?php echo $class['class_id'];?>"<?php if($class_id == $class['class_id']) echo 'selected="selected"' ;?>>
										Class: <?php echo $class['name'];?></option>
                                        <?php endforeach;?>
                                </select>

                                </div>
                            </div>

								
                            <div class="form-group">
								<label class="col-md-12" for="example-text"><?php echo get_phrase('select_student');?></label>
                                	<div class="col-sm-12">
									<?php $classes = $this->crud_model->get_classes();
											foreach ($classes as $key => $row): ?>
										<select name="<?php if($class_id == $row['class_id']) echo 'student_id'; else echo 'temp';?>" id="student_id_<?php echo $row['class_id'];?>"
										 style="display:<?php if($class_id == $row['class_id']) echo 'block'; else echo 'none';?>"  class="form-control">
											<option value="">Select student in <?php echo $row['name'] ;?></option>
											<?php $students = $this->crud_model->get_students($row['class_id']);
											foreach ($students as $key => $student): ?>
											<option value="<?php echo $student['student_id'];?>"
											<?php if(isset($student_id) && $student_id == $student['student_id']) echo 'selected="selected"';?>>
											<?php echo $student['name'];?></option>
											<?php endforeach;?>
										</select>
									<?php endforeach;?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <select name="" id="student_id_0" style="display:<?php if(isset($student_id) && $student_id > 0) echo 'none'; else echo 'block';?>"  class="form-control">
                                        <option value=""><?php echo get_phrase('select_class_first');?></option>
                                    </select>
                                </div>
                            </div>
							
							
                            <!--
							<div class="form-group">
								<label class="col-md-12" for="example-text"><?php echo get_phrase('class_section');?></label>
                                <div class="col-sm-12">
									<select name="section_id" class="form-control" id="section_selector_holder" / required>
										<option value=""><?php echo get_phrase('select_section');?></option>
									</select>
                                </div>
                            </div>
							-->
                            
                            <input class="" type="hidden" value="selection" name="operation">
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block btn-rounded btn-sm"><i class="fa fa-search"></i>&nbsp;<?php echo get_phrase('Get Details');?></button>
                        </div>
		
                    </form>                
            </div>                
		</div>
	</div>
</div>


<?php if ($class_id != '' && $exam_id != '' && $student_id != ''):?>
    <div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
                <div class="panel-body table-responsive">

    					<table cellpadding="0" cellspacing="0" border="1" class="table" style="width:100%">
								<thead bgcolor="#ccc">
									<tr>
										<th><?php echo get_phrase('subject');?></th>
										<th>1st Sequence</th>
										<th>2nd Sequence</th>
										<th>Final Mark</th>
										<th>Remark</th>
									</tr>
								</thead>
                    				<tbody>

										<?php $select_sunject_with_class_id  =   $this->crud_model->get_subjects_by_class($class_id);
											foreach ($select_sunject_with_class_id as $key => $class_subject_exam_student): 
								
												$verify_data = array('exam_id' => $exam_id, 'class_id' => $class_id, 
												'student_id' 	=> $student_id, 
												'session' 		=> $session,
												'term' 			=> $term,
												'subject_id' 	=> $class_subject_exam_student['subject_id']);
												
												$query = $this->db->get_where('mark', $verify_data);
												$update_subject_marks = $query->result_array();
								
												foreach ($update_subject_marks as $key => $general_select):
								
												$everage = ($general_select['class_score1'] + $general_select['exam_score']) / 2;
										   ?>
										   
										<tr>
											<td><?php echo $class_subject_exam_student['name'];?></td>
											<td><?php echo $general_select['class_score1'];?></td>
											<td><?php echo $general_select['exam_score'];?></td>
											<td><?php echo $everage;?></td>
											<td><?php echo $general_select['comment'];?></td>
										</tr>

								<?php endforeach;endforeach;?>                 	
                    	</tbody>
               	</table> 
				

			
	<style>
		.alert-red{
			background-color: red;
			color:white;
		}
	</style>
			
			<!--
			<div class="alert alert-red">Note that, if you click on generate mass report card button below, it will display students' report cards based on the term selected in system settings 
				<a href="<?php echo base_url()?>systemsetting/system_settings" style="color:white"><i class="fa fa-arrow-right"></i> HERE</a>
			</div>
			-->
			<br>
				
				
				<?php if(get_settings('report_template') == 1):?>	
               <a href="<?php echo base_url(). 'admin/printResultSheet/' . $student_id . '/' . $exam_id; ?>" >
			   		<button class="btn btn-info btn-rounded btn-sm"><i class="fa fa-print"></i> <?=get_phrase('print_report_card_for') .' '. $this->crud_model->get_type_name_by_id('student', $student_id); ?></button>
			   </a>
			   <?php endif;?>
			   
			   <?php if($report_template == 'tanzania' || $report_template == 1 || $report_template == 2) : ?>
			   <?php if($general_select['class_score1'] != "") : ?>
               <a href="<?php echo base_url(). 'admin/print_mass_report_card/' . $class_id . '/' . $exam_id . '/' .$session . '/' . $term . '/' . $section_id; ?>" >
			   		<button class="btn btn-success btn-rounded btn-sm"><i class="fa fa-print"></i> <?php echo get_phrase('generate_mass_report_card');?></button>
			   </a>
			   <?php endif;?>
			   <?php endif;?>
			   <hr>
			   <div align="center">
               <a href="<?php echo base_url(). 'admin/print_mass_report_card/' . $class_id . '/' . $exam_id . '/' .$session . '/' . $term;?>" >
			   		<button class="btn btn-success btn-rounded btn-sm"><i class="fa fa-print"></i> <?php echo get_phrase('generate_mass_report_card');?></button>
			   </a>
			   
			   </div>
			   
			   
			</div>
        </div>
	</div>
 </div>

<?php endif;?>


<script type="text/javascript">
    function show_students(class_id){
            for(i=0;i<=50;i++){
                try{
                    document.getElementById('student_id_'+i).style.display = 'none' ;
                    document.getElementById('student_id_'+i).setAttribute("name" , "temp");
                }
                catch(err){}
            }
            if (class_id == "") {
                class_id = "0";
        }
        document.getElementById('student_id_'+class_id).style.display = 'block' ;
        document.getElementById('student_id_'+class_id).setAttribute("name" , "student_id");
        var student_id = $(".student_id");
        for(var i = 0; i < student_id.length; i++)
            student_id[i].selected = "";
			
			
			
    $.ajax({
        url:        '<?php echo base_url();?>admin/get_class_section/' + class_id,
        success:    function(response){
            jQuery('#section_selector_holder').html(response);
        } 

    });			
			
			
			
    }
</script>


