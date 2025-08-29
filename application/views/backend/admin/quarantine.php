<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading">

               &nbsp;
                <div class="pull-right"><a href="#" data-perform="panel-collapse"><i
                            class="fa fa-plus"></i>&nbsp;&nbsp;IMPORT STUDENTS TO QUARANTINE HERE<i
                            class="btn btn-info btn-xs"></i></a> <a href="#" data-perform="panel-dismiss"></a> </div></div>
            <div class="panel-wrapper collapse out" aria-expanded="true">
                <div class="panel-body">
				
				
				
						
							<div class="alert alert-success">AUTO IMPORT STUDENTS TO THE QUARANTINE</div>
							
							<?php echo form_open(base_url() . 'admin/quarantine/save' , array('enctype' => 'multipart/form-data'));?>
								<div class="form-group">
									<label class="col-md-12" for="example-text"><?php echo get_phrase('import_from_which_class');?> <b style="color:red">*</b></label>
									<div class="col-sm-12">
										<select name="class_id" id="class_id" class="form-control" onchange="return get_class_mass_student(this.value)" / required>
											<option value=""><?php echo get_phrase('select_class');?></option>
											<?php $class =  $this->db->get('class')->result_array();
											foreach($class as $key => $class):?>
											<option value="<?php echo $class['class_id'];?>"><?php echo $class['name'];?></option>
											<?php endforeach;?>
									   </select>
									</div>
								</div>
								<strong>LIST OF STUDENTS TO BE QUARANTINE : </strong><br><br>
								<div id="mass_student_selector_holder"></div>
								 
								 
				<style>
					.alert-red{
					background-color:red;
					color:white;
					}
				</style>
				<br>
                        <blockquote class="blockquote-blue">
                            <p>
                                <strong>WARNING !</strong>
                            </p>
                            <p> Ensure you double check the class and the students before clicking quarantine button below. Students quarantined will be moved to quarantine and action cannot be reversed. </p>
                        </blockquote>
				
				
						
								<div class="form-group">
									<button type="submit" class="btn btn-info btn-rounded btn-block btn-sm"><i class="fa fa-times"></i> <?php echo get_phrase('quarantine');?></button>
								</div>
						</div>
						<?php echo form_close();?>
					</div>


        </div>
    </div>
</div>


<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading"> <i class="fa fa-times"></i>&nbsp;&nbsp;<?php echo get_phrase('list_quarantine');?>
            </div>
            <div class="panel-body table-responsive">

<table id="example23" class="table display">
                	<thead>
                		<tr>
                            <th><div><?php echo get_phrase('Image');?></div></th>
                            <th><div><?php echo get_phrase('roll');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>
                    		<th><div><?php echo get_phrase('class');?></div></th>
                    		<th><div><?php echo get_phrase('sex');?></div></th>
                            <th><div><?php echo get_phrase('email');?></div></th>
                            <th><div><?php echo get_phrase('phone');?></div></th>
                            <th><div><?php echo get_phrase('parent');?></div></th>
						</tr>
					</thead>
                    <tbody>
    
						<?php 
							$counter = 1; 
							$students =  $this->db->get('quarantine')->result_array();
							foreach($students as $key => $student):
						?>         
                        <tr>
                            <td><img src="<?php echo $this->crud_model->get_image_url('student', $student['student_id']);?>" class="img-circle" width="30"></td>
                            <td><?php echo $student['roll'];?></td>
                            <td><?php echo $student['name'];?></td>
                            <td><?php echo $this->crud_model->get_type_name_by_id('class', $student['class_id']);?></td>
							<td><?php echo $student['sex'];?></td>
                            <td><?php echo $student['email'];?></td>
                            <td><?php echo $student['phone'];?></td>
                            <td><?php echo $this->crud_model->get_type_name_by_id('parent', $student['parent_id']);?></td>
                        </tr>
    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function select(){
    var chk = $('.check');
    for(i = 0; i < chk.length; i++){
        chk[i].checked = true;
    }
}

function unselect(){
    var chk = $('.check');
    for(i = 0; i < chk.length; i++){
        chk[i].checked = false;
    }
}
</script>
<script type="text/javascript">
function get_class_mass_student(class_id){
    $.ajax({
        url:        '<?php echo base_url();?>admin/get_class_quarantine_mass_student/' + class_id,
        success:    function(response){
            jQuery('#mass_student_selector_holder').html(response);
        } 

    });
}
</script>