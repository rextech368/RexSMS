<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
			<div class="panel-heading"> <i class="fa fa-plus"></i> <?php echo get_phrase('promote_students');?></div>
				<div class="panel-body table-responsive">
				
                        <blockquote class="blockquote-blue">
                            <p style="color:red">
                                <strong>WARNING !</strong>
                            </p>
                            <p> 
								Before promoting students to the next class, the first step to be taking is to go to 
								<strong><a href="<?=base_url();?>admin/alumni">ALUMNI PAGE HERE</a></strong> in other to move the 
								graduated students and also to create empty spaces for the students to be promoted. 
							</p>
                        </blockquote>
				
 				
				
				<div class="row">
				
					<div class="col-sm-4">
						<div class="form-group">
							<label class="col-md-6" for="example-text"><?php echo get_phrase('promote_from_which_class');?> <b style="color:red">*</b></label>
								<select id="from_class" class="form-control">
									<option value=""><?php echo get_phrase('select_class');?></option>
				
									<?php $class =  $this->db->get('class')->result_array();
									foreach($class as $key => $class):?>
									<option value="<?php echo $class['class_id'];?>"
									<?php if($class_id == $class['class_id']) echo 'selected';?>><?php echo $class['name'];?></option>
									<?php endforeach;?>
							   </select>
							</div>
					</div>
					
					<div class="col-sm-4">
						<div class="form-group">
							<label class="col-md-6" for="example-text"><?php echo get_phrase('promote_to_which_class');?> <b style="color:red">*</b></label>
								<select id="to_class" class="form-control">
									<option value=""><?php echo get_phrase('select_class');?></option>
				
									<?php $class =  $this->db->get('class')->result_array();
									foreach($class as $key => $class):?>
									<option value="<?php echo $class['class_id'];?>"
									<?php if($class_id == $class['class_id']) echo 'selected';?>><?php echo $class['name'];?></option>
									<?php endforeach;?>
							   </select>
							</div>
					</div>
					
					<div class="col-sm-4">
						<div class="form-group">
							<label class="col-md-12" for="example-text"></label><br><br>
					
								<button type="button" id="find" class="btn btn-success btn-rounded btn-sm btn-block">Get Student</button>
						</div>
					</div>
				</div>
				
 				<!-- PHP that includes table for subject starts here  ------>
                <div id="data">
                	<?php include 'student_promotion.php';?>
                </div>
                <!-- PHP that includes table for subject ends here  ------>

				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {

		$('#find').on('click', function() {
			var from_class 	= $('#from_class').val();
			var to_class 	= $('#to_class').val();
			if (from_class == "" || to_class == "") {
				$.toast({
					text: 'Please select class before clicking get student button',
					position: 'top-right',
					loaderBg: '#f56954',
					icon: 'warning',
					hideAfter: 3500,
					stack: 6
				})
            return false;
        }
			$.ajax({
				url: '<?php echo site_url('admin/promote_student_selector/');?>' + from_class + '/' + to_class
			}).done(function(response) {
				$('#data').html(response);
			});
		});

	});


</script>