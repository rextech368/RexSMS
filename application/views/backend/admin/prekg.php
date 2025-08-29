
<div class="row">
    <div class="col-sm-12">
		<div class="panel panel-info">
            <div class="panel-heading"> <i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo get_phrase('Enter Student Score');?></div>
                <div class="panel-body table-responsive">
			
                    <!----CREATION FORM STARTS---->

                	<?php echo form_open(base_url() . 'admin/prekg' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top', 'enctype' => 'multipart/form-data'));?>
                    
                            <div class="form-group">
                                    <label class="col-md-12" for="example-text"><?php echo get_phrase('Exam');?></label>
                                <div class="col-sm-12">
                                    <select name="exam_id" class="form-control select2">
                                        <option value=""><?php echo get_phrase('select_examination');?></option>

                                        <?php $exams =  $this->db->get('exam')->result_array();
                                        foreach($exams as $key => $exam):?>
                                        <option value="<?php echo $exam['exam_id'];?>"<?php if($exam_id == $exam['exam_id']) echo 'selected="selected"' ;?>><?php echo $exam['name'];?></option>
                                        <?php endforeach;?>
                                </select>

                                </div>
                            </div>


                            <div class="form-group">
                                    <label class="col-md-12" for="example-text"><?php echo get_phrase('class');?></label>
                                <div class="col-sm-12">
                                    <select name="class_id"  class="form-control select2" onchange="return show_students(this.value), show_subjects(this.value)">
                                        <option value=""><?php echo get_phrase('select_class');?></option>

                                        <?php $classes =  $this->db->get('class')->result_array();
                                        foreach($classes as $key => $class):?>
                                        <option value="<?php echo $class['class_id'];?>"<?php if($class_id == $class['class_id']) echo 'selected="selected"' ;?>>Class: <?php echo $class['name'];?></option>
                                        <?php endforeach;?>
                                </select>

                                </div>
                            </div>
							
							
	                            <div class="form-group">
                                    <label class="col-md-12" for="example-text"><?php echo get_phrase('Student');?></label>
                                <div class="col-sm-12">

                                <?php $classes = $this->crud_model->get_classes();
                                        foreach ($classes as $key => $row): ?>

                                    <select name="<?php if($class_id == $row['class_id']) echo 'student_id'; else echo 'temp';?>" id="student_id_<?php echo $row['class_id'];?>" style="display:<?php if($class_id == $row['class_id']) echo 'block'; else echo 'none';?>"  class="form-control">
                                        <option value="">Student of: <?php echo $row['name'] ;?></option>

                                        <?php $students = $this->crud_model->get_students($row['class_id']);
                                        foreach ($students as $key => $student): ?>
                                        <option value="<?php echo $student['student_id'];?>"<?php if(isset($student_id) && $student_id == $student['student_id']) echo 'selected="selected"';?>><?php echo $student['name'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                <?php endforeach;?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <select name="" id="student_id_0" style="display:<?php if(isset($student_id) && $student_id > 0) echo 'none'; else echo 'block';?>"  class="form-control">
                                        <option value=""><?php echo get_phrase('Select Class First');?></option>
                                    </select>
                                </div>
                            </div>
							
                            <div class="form-group">
                                    <label class="col-md-12" for="example-text"><?php echo get_phrase('Subject');?></label>
                                <div class="col-sm-12">

                                <?php $classes = $this->crud_model->get_classes();
                                        foreach ($classes as $key => $row1): ?>

                                    <select name="<?php if($class_id == $row1['class_id']) echo 'subject_id'; else echo 'temp';?>" id="subject_id_<?php echo $row1['class_id'];?>" style="display:<?php if($class_id == $row1['class_id']) echo 'block'; else echo 'none';?>"  class="form-control">
                                        <option value="">Subject of: <?php echo $row1['name'] ;?></option>

                                        <?php $select_subject_from_model = $this->crud_model->get_subjects_by_class($row1['class_id']);
                                        foreach ($select_subject_from_model as $key => $subject_selected_from_model): ?>
                                        <option value="<?php echo $subject_selected_from_model['subject_id'];?>"<?php if(isset($subject_id) && $subject_id == $subject_selected_from_model['subject_id']) echo 'selected="selected"';?>><?php echo $subject_selected_from_model['name'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                <?php endforeach;?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <select name="" id="subject_id_0" style="display:<?php if(isset($subject_id) && $subject_id > 0) echo 'none'; else echo 'block';?>"  class="form-control">
                                        <option value=""><?php echo get_phrase('Select Class First');?></option>
                                    </select>
                                </div>
                            </div>
							
                            
                            <input class="" type="hidden" value="selection" name="operation">
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block btn-rounded btn-sm"><i class="fa fa-search"></i>&nbsp;<?php echo get_phrase('Get Details');?></button>
                        </div>
		
                    </form>                
            </div>                
		</div>
	</div>
</div>

	<style>
		.alert-red{
			background-color: red;
			color:white;
		}
	</style>
	
	<?php if($class_id > 0 && $student_id > 0 && $exam_id > 0 && $subject_id > 0):?>	

    <?php $select_sunject_with_class_id  =   $this->crud_model->get_subjects_by_class($class_id);
            foreach ($select_sunject_with_class_id as $key => $class_subject_exam_student): 

                $verify_data = array('exam_id' => $exam_id, 'class_id' => $class_id, 'student_id' => $student_id, 'subject_id' => $subject_id);
                $query = $this->db->get_where('prekg', $verify_data);
				
				$sql = "select * from prekg order by prekg_id desc limit 1";
				$return_query = $this->db->query($sql)->row()->prekg_id + 1;
				$verify_data['prekg_id'] 	= $return_query;
				$verify_data['term'] 		= get_settings('term');
				$verify_data['session']		= get_settings('session');

                if($query->num_rows() < 1)
                    $this->db->insert('prekg', $verify_data);
					$prekg_id = $this->db->insert_id();
            endforeach;?>


					
    <div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
            <div class="panel-heading"> <i class="fa fa-plus"></i>&nbsp;<?php echo get_phrase('enter_student_score_for'); ?> : 
			<?=$this->crud_model->get_type_name_by_id('subject', $subject_id);?>
			
			
				<?php 
				$select = $this->db->get_where('prekg', array('exam_id' => $exam_id, 'class_id' => $class_id, 
				'student_id' => $student_id, 'subject_id' => $subject_id))->result_array();
				foreach ($select as $sele) : 
				?>
				
				<span class="pull-right">
                        <a onclick="showAjaxModal('<?php echo base_url();?>modal/popup/student_comment_kg/<?=$student_id;?>')"
						 class="btn btn-danger btn-rounded btn-sm"><i class="fa fa-plus"></i> <?=get_phrase('enter_remarks_for') .' '. $this->crud_model->get_type_name_by_id('student', $student_id); ?></a>
						 
               <a href="<?php echo base_url(). 'admin/printResultSheetKg/' . $student_id . '/' . $exam_id; ?>" >
			   		<button class="btn btn-info btn-rounded btn-sm"><i class="fa fa-print"></i> <?=get_phrase('print_report_card_for') .' '. $this->crud_model->get_type_name_by_id('student', $student_id); ?></button>
			   </a>	 
				</span>
				
				
			
			</div>
                <div class="panel-body table-responsive">
				

				
 			<?php echo form_open(base_url() . 'admin/prekg', array('enctype' => 'multipart/form-data')); ?>
				
					<input class="" type="hidden" value="update_student_subject_score" name="operation">
					<input class="" type="hidden" value="<?=$sele['prekg_id'];?>" name="prekg_id">
					<input class="" type="hidden" value="<?=$class_id;?>" name="class_id">
					<input class="" type="hidden" value="<?=$student_id;?>" name="student_id">
					<input class="" type="hidden" value="<?=$exam_id;?>" name="exam_id">
					<input class="" type="hidden" value="<?=$subject_id;?>" name="subject_id">
							   
                    <span id="deduction">
					
                        <?php if (json_decode($sele['results']) != ''): ?>
                        <?php $counter = 0;
						foreach (json_decode($sele['results']) as $more_entries):?>
                        <?php if ($counter == 0): $counter++; ?>
					
                        <div class="row form-group">
                            
							<div class="col-md-5">
                                <input type="text" class="form-control" name="score_name[]" value="<?php echo $more_entries->score_name; ?>"
                                    placeholder="<?php echo get_phrase('subject_evaluation_content'); ?> eg Able to read and write" />
                            </div>

                           <div class="col-md-5">
								<?php $score = $more_entries->score_grade?>
                                <select name="score_grade[]" class="form-control">
                                        <option value="LEVEL 4"<?php if($score == 'LEVEL 4') echo 'selected="selected"';?>>LEVEL 4</option>
										<option value="LEVEL 3"<?php if($score == 'LEVEL 3') echo 'selected="selected"';?>>LEVEL 3</option>
										<option value="LEVEL 2"<?php if($score == 'LEVEL 2') echo 'selected="selected"';?>>LEVEL 2</option>
										<option value="LEVEL 1"<?php if($score == 'LEVEL 1') echo 'selected="selected"';?>>LEVEL 1</option>
										<option value="SP"<?php if($score == 'SP') echo 'selected="selected"';?>>SP</option>
                                </select>
                            </div>
                        
                            <div class="col-md-2">
								<button type="button" class="btn btn-info btn-rounded btn-sm" onClick="add_deduction()"><i class="fa fa-plus"></i>&nbsp; <?php echo get_phrase('add_more_options'); ?>
								</button>
                        	</div>
						</div>
					
					 <?php else: ?>
					 
					 
                        <div class="row form-group">
                            
							<div class="col-md-5">
                                <input type="text" class="form-control" name="score_name[]" value="<?php echo $more_entries->score_name; ?>"
                                    placeholder="<?php echo get_phrase('subject_evaluation_content'); ?> eg Able to read and write" />
                            </div>

                           <div class="col-md-5">
								<?php $score = $more_entries->score_grade?>
                                <select name="score_grade[]" class="form-control">
                                        <option value="LEVEL 4"<?php if($score == 'LEVEL 4') echo 'selected="selected"';?>>LEVEL 4</option>
										<option value="LEVEL 3"<?php if($score == 'LEVEL 3') echo 'selected="selected"';?>>LEVEL 3</option>
										<option value="LEVEL 2"<?php if($score == 'LEVEL 2') echo 'selected="selected"';?>>LEVEL 2</option>
										<option value="LEVEL 1"<?php if($score == 'LEVEL 1') echo 'selected="selected"';?>>LEVEL 1</option>
										<option value="SP"<?php if($score == 'SP') echo 'selected="selected"';?>>SP</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-circle btn-xs"
                                    id="deduction_amount_delete" onclick="deleteDeductionParentElement(this)">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
						</div>
					
                        <?php endif; ?>
                        <?php endforeach; ?>
                        <?php else: ?> 
						
                        <div class="row form-group">
                            
							<div class="col-md-5">
                                <input type="text" class="form-control" name="score_name[]" 
                                    placeholder="<?php echo get_phrase('subject_evaluation_content'); ?> eg Able to read and write" />
                            </div>

                           <div class="col-md-5">
                                <!--<input type="text" class="form-control" name="score_grade[]" 
                                    placeholder="<?php echo get_phrase('enter_student_grade'); ?> eg LEVEL 1 OR LEVEL 2 ...."
                                    id="deduction_amount_1" />
								-->
								
                                <select name="score_grade[]" class="form-control">
										<option value="">Please Select Grade</option>
                                        <option value="LEVEL 4">LEVEL 4</option>
										<option value="LEVEL 3">LEVEL 3</option>
										<option value="LEVEL 2">LEVEL 2</option>
										<option value="LEVEL 1">LEVEL 1</option>
										<option value="SP">SP</option>
                                </select>
                            </div>
                            <div class="col-md-2">
								<button type="button" class="btn btn-info btn-rounded btn-sm" onClick="add_deduction()"><i class="fa fa-plus"></i>&nbsp; <?php echo get_phrase('add_more_options'); ?>
								</button>
                        	</div>
                           
						</div>
						<?php endif; ?>
                    </span>
					
					
                    <span id="deduction_input">
					
                        <div class="row form-group">
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="score_name[]"
                                    placeholder="<?php echo get_phrase('subject_evaluation_content'); ?> eg Able to read and write" />
                            </div>

                            <div class="col-md-5">
                                <select name="score_grade[]" class="form-control">
										<option value="">Please Select Grade</option>
                                        <option value="LEVEL 4">LEVEL 4</option>
										<option value="LEVEL 3">LEVEL 3</option>
										<option value="LEVEL 2">LEVEL 2</option>
										<option value="LEVEL 1">LEVEL 1</option>
										<option value="SP">SP</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-circle btn-xs"
                                    id="deduction_amount_delete" onclick="deleteDeductionParentElement(this)">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </span>
					

					
			 <?php endforeach;?>	
			 
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block btn-rounded btn-sm"><i class="fa fa-plus"></i>&nbsp;<?php echo get_phrase('save');?></button>
                        </div>
			 <?=form_close();?> 
            
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
    }
</script>

<script type="text/javascript">
    function show_subjects(class_id){
            for(i=0;i<=50;i++){
                try{
                    document.getElementById('subject_id_'+i).style.display = 'none' ;
                    document.getElementById('subject_id_'+i).setAttribute("name" , "temp");
                }
                catch(err){}
            }
            if (class_id == "") {
                class_id = "0";
        }
        document.getElementById('subject_id_'+class_id).style.display = 'block' ;
        document.getElementById('subject_id_'+class_id).setAttribute("name" , "subject_id");
        var subject_id = $(".subject_id");
        for(var i = 0; i < subject_id.length; i++)
            subject_id[i].selected = "";
    }
</script>
<script type="text/javascript">

    var deduction_count     = 1;
    var total_deduction     = 0;
    var deleted_deductions  = [];

   $('#deduction_input').hide();



// Creating the blank allowance input
var blank_deduction     =   '';
$(document).ready(function(){
    blank_deduction    =   $('#deduction_input').html();
});

function add_deduction(){

deduction_count++;
$("#deduction").append(blank_deduction);
$('#deduction_amount').attr('id', 'deduction_amount_' + deduction_count);
$('#deduction_amount_delete').attr('id', 'deduction_amount_delete_' + deduction_count);
$('#deduction_amount_delete_' + deduction_count).attr('onclick', 'deleteDeductionParentElement(this, ' + deduction_count + ')');
}



// Removing deduction input
function deleteDeductionParentElement (n, deduction_count) {
        n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
        deleted_deductions.push(deduction_count);
}

</script>