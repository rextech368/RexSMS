				
		<style type="text/css">


.page {
  width: 1000px;
  min-height: 29.7cm;
  padding: 2cm;
  margin: 1cm auto;
  border: 1px #D3D3D3 solid;
  border-radius: 5px;
  background: white;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

@page {
  size: A3;
  margin: 0;
}

@media print {
  .page {
	html, body {
		width: 216mm;
		min-height: 279mm;
		border: 1px #D3D3D3 solid;
		border-radius: 5px;
		background: white;
		box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
	}
  }
  
	.thead > tr > th,
	.tbody > tr > th,
	.tbody > tr > td{
		border-color: #000 !important;
	} 
}

table {
	border-collapse: collapse;
	width: 100%;
	margin: 0 auto;
}
	.style1 {font-weight: bold}
	</style>

<div class="printableArea page" align="center"> 

	
<?php
	$class_name = $this->db->get_where('class', array('class_id' => $class_id))->row()->name;
	$select_student_from_model = $this->crud_model->get_students($class_id);
	foreach($select_student_from_model as $key => $student_selected):

	$student_id 		= $student_selected['student_id'];
	$student_roll 		= $student_selected['roll'];
	$student_sex 		= $student_selected['sex'];
	$student_name 		= $student_selected['name'];
	$number_class 		= $this->db->get_where('student', array('class_id' =>$class_id))->num_rows();
	$ReturnTeacherSub 	= $this->db->get_where('subject', array('class_id' => $class_id))->row_array();
	$term 				= $term;
	$session 			= $session;


	$total_marks        =   0;
	$total_class_score  =   0;
	$total_grade_point  =   0;
?>


<?php if($term == 1) : ?>
<div class="row" style="border:1px solid #000; padding:5px;">
	<div class="col-sm-12">
			<table width="100%">
			  <tr>
				<td class="pull-left"><img src="<?php echo base_url()?>uploads/logo.png"  height="150" width="150"></td>
				<td>
					<h1 align="center" style="font-weight:900; font-size:17px; font-family:Arial Black; line-height:15px;"><?php echo get_settings('system_name')?></h1>
					<h5 align="center" style="font-weight:300; font-size:13px; font-family:Arial Black; line-height:15px;"><?php echo get_settings('address')?></h5>
					<h5 align="center" style="font-weight:500; font-size:15px; font-family:Arial Black; line-height:15px;">Secondary & Higher Education</h5>
					<h5 align="center" style="font-weight:300; font-size:10px; font-family:Arial Black; line-height:15px;">Email: <?php echo get_settings('system_email')?>     Tel: <?php echo get_settings('phone')?></h5>
				</td>
				<td class="pull-right"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="150" width="150"></td>
			  </tr>		
			</table>
			
			<table width="100%" height="100" border="1" class="mb-3">
			  <tr>
				<td><strong>&nbsp;Name:</strong>&nbsp;					  <?=$student_selected['name'];?></td>
				<td><strong>&nbsp;Class:</strong>&nbsp;					  <?=$class_name;?></td>
				<td><strong>&nbsp;Term:</strong>&nbsp;					  <?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></td>
			  </tr>
			  <tr>
				<td><strong>&nbsp;No:</strong>&nbsp;					  <?=$student_selected['roll'];?></td>
				<td>&nbsp;<strong>Gender:</strong>&nbsp;					  <?=ucwords($student_selected['sex']);?></td>
				<td>&nbsp;<strong>Academic Year:</strong>&nbsp;					  <?=$session?></td>
			  </tr>
			</table>
			<table width="100%"  border="1" class="mb-2">
			  <tr>
				<th valign="top">&nbsp;Subjects</th>
				
				<th valign="top">&nbsp;Mark</th>
				<th valign="top">&nbsp;Coef</th>
				<th valign="top">&nbsp;MxC</th>
				<th valign="top">&nbsp;Pos</th>
				<th valign="top">&nbsp;Remarks</th>
				<th valign="top">&nbsp;Name of Teacher</th>
			  </tr>
			  
				<?php 
					$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
					foreach ($select_subject as $key => $subject):
					
					$coefficient = $subject['coefficient'];
					$teacher_id = $subject['teacher_id'];
				?>
				<tr>
					<td valign="top">&nbsp;<?php echo $subject['name'];?></td>
					
					<?php 
						$obtained_mark_query = $this->db->get_where('mark', array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 'student_id' => $student_id, 'term' => $term));
						$ave_first    = $obtained_mark_query->row()->ave_first;
						$mxc_first    = $obtained_mark_query->row()->mxc_first;
						
						$total_score  = $obtained_mark_query->row()->mxc_first;
											
						if($total_score == ""){
							$total_score = 0;
						}else{
							$total_score = $total_score;	
						}			
											
											/*
											$update['mxc_first'] = $total_score;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $update);
											*/
										
					?>
					
					<td valign="top">&nbsp;<?php if($ave_first == 0)echo '';else echo $ave_first;?></td>
					<td valign="top">&nbsp;<?php if($coefficient == 0)echo ''; else echo $coefficient;?></td>
					<td valign="top">&nbsp;<?php if($mxc_first == 0)echo ''; else echo $mxc_first;?></td>
					
					<td valign="top">&nbsp;
					
										<?php
										
										$subject_id = $subject['subject_id'];
										$sql = "SELECT mark_id, mxc_first, FIND_IN_SET( mxc_first,(
												SELECT GROUP_CONCAT( mxc_first  ORDER BY mxc_first DESC ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND mxc_first = $total_score"; 
		
										$rank =  $this->db->query($sql)->row()->rank; 
		
										if($rank == 0){
											echo '--'; 
										}
		
										if($rank == 1 || $rank == 21 || $rank == 31 || $rank == 41 || $rank == 51 || $rank == 61 || $rank == 71 || $rank == 81 || $rank == 91){
											echo $rank.'st';
										}elseif($rank == 2 ||$rank == 22 || $rank == 32 || $rank == 42 || $rank == 52 || $rank == 62 || $rank == 72 || $rank == 82 || $rank == 92){
										echo $rank.'nd'; 
										}elseif($rank == 3 ||$rank == 23 || $rank == 33 || $rank == 43 || $rank == 53 || $rank == 63 || $rank == 73 || $rank == 83 || $rank == 93){
										echo $rank.'rd'; 
										}elseif($rank > 3 && $rank!= 21 && $rank!= 31 && $rank!= 41 && $rank!= 51 && $rank!= 61 && $rank!= 71 && $rank!= 81 && $rank!= 91 && $rank!= 22 && $rank!= 31 && $rank!= 41 && $rank!= 51 && $rank!= 61 && $rank!= 71 && $rank!= 81 && $rank!= 91 && $rank!= 23 && $rank!= 33 && $rank!= 43 && $rank!= 53 && $rank!= 63 && $rank!= 73 && $rank!= 83 && $rank!= 93){
											echo $rank.'th';         
										}else{
											echo '--'; 
										}
										
										
										?>					</td>

					<td valign="top">&nbsp;<?php echo $obtained_mark_query->row()->comment;?></td>
					<?php $teacher = $this->crud_model->get_type_name_by_id('teacher', $teacher_id);?>
					<td valign="top">&nbsp;<?php if($teacher == '')echo '---'; else echo strtoupper($teacher);?></td>
			  	</tr>
			  <?php endforeach;?>
	
				<tr>
					<td valign="top" align="right"><strong>Total</strong>&nbsp;</td>
				
					<td valign="top">&nbsp;<strong><?php
				
						$this->db->select_sum('ave_first');
						$this->db->from('mark');
						$this->db->where('student_id', $student_id);
						$this->db->where('term', $term);
						$this->db->where('session', $session);
								
						$query = $this->db->get();	
						$ave_first = $query->row()->ave_first;
								
						if($ave_first == ""){
							$ave_first = 0;
						}else{
							$ave_first = $ave_first;	
						}
						
						echo round($ave_first,2);
				
					?></strong>					</td>
					<td valign="top">&nbsp;<strong><?php
				
					// Calculate total score for the student
					$this->db->select_sum('mxc_first', 'total_score'); // Assuming mxc_first holds MxC for the first term
					$this->db->from('mark');
					$this->db->where('student_id', $student_id);
					$this->db->where('class_id', $class_id);
					$this->db->where('exam_id', $exam_id);
					$this->db->where('term', $term);
					$this->db->where('session', $session);
					$query = $this->db->get();

					// Check if the query returned a result
					$total_score = ($query && $query->num_rows() > 0) ? $query->row()->total_score : 0;

					// Calculate total coefficient for subjects where coe_first > 0 and student has marks > 0
					$this->db->select_sum('coe_first', 'total_coefficient'); // Use coe_first for coefficient
					$this->db->from('mark');
					$this->db->where('student_id', $student_id);
					$this->db->where('class_id', $class_id);
					$this->db->where('exam_id', $exam_id);
					$this->db->where('term', $term);
					$this->db->where('session', $session);
					$this->db->where('mxc_first >', 0); // Only include subjects with marks greater than 0
					$query_coefficient = $this->db->get();

					// Check if the query returned a result
					$total_coefficient = ($query_coefficient && $query_coefficient->num_rows() > 0) ? $query_coefficient->row()->total_coefficient : 0;

					?></strong></td>
					<td colspan="3" valign="top">&nbsp;</td>
					<td colspan="3" valign="top">&nbsp;</td>
				  </tr>
				</table>
				
				<table width="100%" border="1">
                  <tr>
                    <th width="29%" align="left">&nbsp;STUDENT'S RANK</th>
					<td>&nbsp;<?php
							if ($rank == 0) {
								echo '--'; 
							} else {
								echo htmlspecialchars($rank); // Default to 'th' suffix

								// Determine appropriate suffix for rank (st, nd, rd)
								switch ($rank) {
									case 1:
										echo 'st';
										break;
									case 2:
										echo 'nd';
										break;
									case 3:
										echo 'rd';
										break;
									default:
										echo 'th';
								}
							}

						// Calculate student average
						$student_average = ($total_coefficient > 0) ? round($total_score / $total_coefficient, 2) : 0;

						// Now calculate class average based on all students in the same class
						$this->db->select_avg('(mxc_first / NULLIF(coe_first, 0))', 'class_average'); // Avoid division by zero
						$this->db->from('mark');
						$this->db->where('class_id', $class_id);
						$this->db->where('exam_id', $exam_id);
						$this->db->where('term', $term);
						$this->db->where('session', $session);
						$query_class_avg = $this->db->get();

						// Check if class average was calculated successfully
						$class_average = 0; // Default value for class average
						if ($query_class_avg && ($class_avg_row = $query_class_avg->row())) {
							if (isset($class_avg_row) && isset($class_avg_row->class_average)) {
								// Class average is already calculated above, round it to two decimal places.
								$class_average = round($class_avg_row->class_average, 2);
							}
						}

						// Rank calculation based on student_average compared to others in the same class
						if ($student_average > 0) {
							// Create a subquery to get ranks based on averages
							$sql = "SELECT COUNT(*) + 1 AS rank FROM (
										SELECT DISTINCT (SUM(mxc_first) / NULLIF(SUM(coe_first), 0)) AS avg_score 
										FROM mark 
										WHERE class_id = ? AND exam_id = ? AND term = ? AND session = ?
										GROUP BY student_id 
										HAVING avg_score > ?
									) AS ranked_students";

							// Execute query with parameters
							$rank_query = $this->db->query($sql, array($class_id, $exam_id, $term, $session, $student_average));
							
							if ($rank_row = $rank_query->row()) {
								// Ensure rank is an integer and format it correctly.
								// echo intval($rank_row->rank); // Convert rank to integer

								// Determine appropriate suffix for rank (st, nd, rd)
								
							} else {
								// echo '--'; 
							}
						} else {
							// echo '--'; 
						}

						//Calculate total number of subjects taken by student (mxc_first > 0)
						$num_subjt_taken = $this->db
							->from('mark')
							->where('student_id', $student_id)
							->where('class_id', $class_id)
							->where('term', $term)
							->where('session', $session)
							->where('mxc_first >', 0) // Count only subjects where mxc_first is greater than 0
							->count_all_results(); // Count all subjects taken by this student

						//Calculate number of subjects passed by student (assuming passing score is >=10)
						$num_subjt_passed = $this->db
							->from('mark')
							->where('student_id', $student_id)
							->where('class_id', $class_id)
							->where('term', $term)
							->where('session', $session)
							->where('ave_first >=', 10) // Assuming mxc_first represents scores that determine passing status
							->count_all_results(); // Count all subjects passed by this student

						// //Output results for total students, subjects taken, and subjects passed.
						// echo "Total Students in Class: " . htmlspecialchars($all_students_in_class) . "<br>";
						// echo "Subjects Taken: " . htmlspecialchars($num_subjt_taken) . "<br>";

						
					
					?></td>
					<td width="35%">&nbsp;Out of </td>
					<td width="21%">&nbsp;<?php echo '---' ?></td>	
				</tr>
				<tr>
					<th align="left">&nbsp;TERM</th>
					<th>&nbsp;1st Term</th>
					<th>&nbsp;2nd Term</th>
					<th>&nbsp;3rd Term</th>
				</tr>
				<tr>
					<th align="left">&nbsp;Students Average</th>
					<td>&nbsp;<?= htmlspecialchars($student_average); ?></td>
					<td>&nbsp;--</td>
					<td>&nbsp;--</td>
				</tr>
				<tr>
					<th align="left">&nbsp;Class Average</th>
					<td>&nbsp;<?= htmlspecialchars(round($class_average, 2)); ?></td> <!-- Display calculated class average -->
					<th colspan="2">&nbsp;Subjects Taken : <?= htmlspecialchars($num_subjt_taken); ?></th>
				</tr>
				<tr>
					<th align="left">&nbsp;Rank</th>
					<td>&nbsp;<?php
							if ($rank == 0) {
								echo '--'; 
							} else {
								echo htmlspecialchars($rank); // Default to 'th' suffix

								// Determine appropriate suffix for rank (st, nd, rd)
								switch ($rank) {
									case 1:
										echo 'st';
										break;
									case 2:
										echo 'nd';
										break;
									case 3:
										echo 'rd';
										break;
									default:
										echo 'th';
								}
							}
					?></td>
					<th colspan="2">&nbsp;Number of Subjects Passed : <?= htmlspecialchars($num_subjt_passed); ?> </th>
				</tr>
			</table>
			<br>
			
			<table width="100%" border="1">
			  <tr bgcolor="#ccc" align="center">
				<td colspan="3">&nbsp;<strong>GENERAL REMARKS</strong> </td>
			  </tr>
			  <tr>
				<th colspan="2">&nbsp;CLASS MASTER</th>
				<th width="60%">&nbsp;PRINCIPAL</th>
			  </tr>
			  <tr>
				  <?php $teacher_id = $this->db->get_where('class', array('class_id' => $class_id))->row()->teacher_id;;?>
				<th colspan="2">&nbsp;<?= $this->crud_model->get_type_name_by_id('teacher', $teacher_id)?></th>
				<th>&nbsp;Academics : </th>
			  </tr>
			  <tr>
				<td width="16%" align="left">&nbsp;Absences</td>
				<td width="24%" align="left">&nbsp;0</td>
				<th rowspan="5" align="left" style="font-size:50px; font-family:Arial Black">&nbsp;
							<?php if ($student_average <= '20.0' && $student_average >= '18.0'):?>
							<?php echo '<span style="color:red">Excellent</span>';?>
							<?php endif;?>
							
							<?php if ($student_average <= '17.9' && $student_average >= '16.1'):?>
							<?php echo '<span style="color:red">Very Good</span>';?>
							<?php endif;?>
							
							<?php if ($student_average <= '16.0' && $student_average >= '14.0'):?>
							<?php echo '<span style="color:red">Good</span>';?>
							<?php endif;?>
							
							<?php if ($student_average <= '13.9' && $student_average >= '12.0'):?>
							<?php echo '<span style="color:red">Fairly Good</span>';?>
							<?php endif;?>
							
							<?php if ($student_average <= "11.9" && $student_average >= '10'):?>
							<?php echo '<span style="color:red">Average</span>';?>
							<?php endif;?>
							
							<?php if ($student_average <= "9.9" && $student_average >= '0'):?>
							<?php echo '<span style="color:red">Failed</span>';?>
							<?php endif;?>
				
				</th>
			  </tr>
			  <tr>
				<td align="left">&nbsp;Health</td>
				<td align="left">&nbsp;0</td>
			  </tr>
			  <tr>
				<td align="left">&nbsp;Conduct</td>
				<td align="left">&nbsp;0</td>
			  </tr>
			  <tr>
				<td align="left">&nbsp;Purnishment</td>
				<td align="left">&nbsp;0</td>
			  </tr>
			  <tr>
				<td align="left">&nbsp;Next Term </td>
				<td align="left"> &nbsp;<?= date('jS F Y', strtotime(get_settings('next_term_begin')))?></td>
			  </tr>
			  <tr>
				<td colspan="3" align="center">
				<img src="<?php echo base_url();?>uploads/signature.png" width="200px" height="80px">
				<img src="<?php echo base_url();?>uploads/school_stamp.png" width="200px" height="80px">
				<br><strong style="font-style:italic">NB: Mark below 10 is a <span style="text-decoration:underline;">Fail Mark</span></strong> 
				</td>
			  </tr>
			</table>
			

		  

		  
	</div>

</div><!-- End Row -->
			
<?php endif;?>





<?php if($term == 2) : ?>
<div class="col-sm-12">
		<table width="100%">
			<tr>
			<td class="pull-left"><img src="<?php echo base_url()?>uploads/logo.png"  height="150" width="150"></td>
			<td>
				<h1 align="center" style="font-weight:900; font-size:17px; font-family:Arial Black; line-height:15px;"><?php echo get_settings('system_name')?></h1>
				<h5 align="center" style="font-weight:300; font-size:13px; font-family:Arial Black; line-height:15px;"><?php echo get_settings('address')?></h5>
				<h5 align="center" style="font-weight:500; font-size:15px; font-family:Arial Black; line-height:15px;">Secondary & Higher Education</h5>
				<h5 align="center" style="font-weight:300; font-size:10px; font-family:Arial Black; line-height:15px;">Email: <?php echo get_settings('system_email')?>     Tel: <?php echo get_settings('phone')?></h5>
			</td>
			<td class="pull-right"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="150" width="150"></td>
			</tr>		
		</table>
		
		<table width="100%" height="100" border="1" class="mb-3">
			<tr>
			<td><strong>&nbsp;Name:</strong>&nbsp;					  <?=$student_selected['name'];?></td>
			<td><strong>&nbsp;Class:</strong>&nbsp;					  <?=$class_name;?></td>
			<td><strong>&nbsp;Term:</strong>&nbsp;					  <?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></td>
			</tr>
			<tr>
			<td><strong>&nbsp;No:</strong>&nbsp;					  <?=$student_selected['roll'];?></td>
			<td>&nbsp;<strong>Gender:</strong>&nbsp;					  <?=ucwords($student_selected['sex']);?></td>
			<td>&nbsp;<strong>Academic Year:</strong>&nbsp;					  <?=$session?></td>
			</tr>
		</table>
		<table width="100%"  border="1" class="mb-2">
			<tr>
			<th valign="top">&nbsp;Subjects</th>
			
			<th valign="top">&nbsp;Mark</th>
			<th valign="top">&nbsp;Coef</th>
			<th valign="top">&nbsp;MxC</th>
			<th valign="top">&nbsp;Pos</th>
			<th valign="top">&nbsp;Remarks</th>
			<th valign="top">&nbsp;Name of Teacher</th>
			</tr>
			
			<?php 
				$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
				foreach ($select_subject as $key => $subject):
				
				$coefficient = $subject['coefficient'];
				$teacher_id = $subject['teacher_id'];
			?>
			<tr>
				<td valign="top">&nbsp;<?php echo $subject['name'];?></td>
				
				<?php 
					$obtained_mark_query = $this->db->get_where('mark', array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 'student_id' => $student_id, 'term' => $term));
					$ave_second    = $obtained_mark_query->row()->ave_second;
					$mxc_second    = $obtained_mark_query->row()->mxc_second;
					
					$total_score  = $obtained_mark_query->row()->mxc_second;
										
					if($total_score == ""){
						$total_score = 0;
					}else{
						$total_score = $total_score;	
					}			
										
										/*
										$update['mxc_second'] = $total_score;
										$this->db->where('subject_id' , $subject['subject_id']);
										$this->db->where('student_id' , $student_id);
										$this->db->update('mark', $update);
										*/
									
				?>
				
				<td valign="top">&nbsp;<?php if($ave_second == 0)echo '';else echo $ave_second;?></td>
				<td valign="top">&nbsp;<?php if($coefficient == 0)echo ''; else echo $coefficient;?></td>
				<td valign="top">&nbsp;<?php if($mxc_second == 0)echo ''; else echo $mxc_second;?></td>
				
				<td valign="top">&nbsp;
				
									<?php
									
									$subject_id = $subject['subject_id'];
									$sql = "SELECT mark_id, mxc_second, FIND_IN_SET( mxc_second,(
											SELECT GROUP_CONCAT( mxc_second  ORDER BY mxc_second DESC ) 
											FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
											AS rank 
											FROM mark
											WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND mxc_second = $total_score"; 
	
									$rank =  $this->db->query($sql)->row()->rank; 
	
									if($rank == 0){
										echo '--'; 
									}
	
									if($rank == 1 || $rank == 21 || $rank == 31 || $rank == 41 || $rank == 51 || $rank == 61 || $rank == 71 || $rank == 81 || $rank == 91){
										echo $rank.'st';
									}elseif($rank == 2 ||$rank == 22 || $rank == 32 || $rank == 42 || $rank == 52 || $rank == 62 || $rank == 72 || $rank == 82 || $rank == 92){
									echo $rank.'nd'; 
									}elseif($rank == 3 ||$rank == 23 || $rank == 33 || $rank == 43 || $rank == 53 || $rank == 63 || $rank == 73 || $rank == 83 || $rank == 93){
									echo $rank.'rd'; 
									}elseif($rank > 3 && $rank!= 21 && $rank!= 31 && $rank!= 41 && $rank!= 51 && $rank!= 61 && $rank!= 71 && $rank!= 81 && $rank!= 91 && $rank!= 22 && $rank!= 31 && $rank!= 41 && $rank!= 51 && $rank!= 61 && $rank!= 71 && $rank!= 81 && $rank!= 91 && $rank!= 23 && $rank!= 33 && $rank!= 43 && $rank!= 53 && $rank!= 63 && $rank!= 73 && $rank!= 83 && $rank!= 93){
										echo $rank.'th';         
									}else{
										echo '--'; 
									}
									
									
									?>					</td>

				<td valign="top">&nbsp;<?php echo $obtained_mark_query->row()->comment;?></td>
				<?php $teacher = $this->crud_model->get_type_name_by_id('teacher', $teacher_id);?>
				<td valign="top">&nbsp;<?php if($teacher == '')echo '---'; else echo strtoupper($teacher);?></td>
			</tr>
			<?php endforeach;?>

			<tr>
				<td valign="top" align="right"><strong>Total</strong>&nbsp;</td>
			
				<td valign="top">&nbsp;<strong><?php
			
					$this->db->select_sum('ave_second');
					$this->db->from('mark');
					$this->db->where('student_id', $student_id);
					$this->db->where('term', $term);
					$this->db->where('session', $session);
							
					$query = $this->db->get();	
					$ave_second = $query->row()->ave_second;
							
					if($ave_second == ""){
						$ave_second = 0;
					}else{
						$ave_second = $ave_second;	
					}
					
					echo round($ave_second,2);
			
				?></strong>					</td>
				<td valign="top">&nbsp;<strong><?php
			
				// Calculate total score for the student
				$this->db->select_sum('mxc_second', 'total_score'); // Assuming mxc_second holds MxC for the second term
				$this->db->from('mark');
				$this->db->where('student_id', $student_id);
				$this->db->where('class_id', $class_id);
				$this->db->where('exam_id', $exam_id);
				$this->db->where('term', $term);
				$this->db->where('session', $session);
				$query = $this->db->get();

				// Check if the query returned a result
				$total_score = ($query && $query->num_rows() > 0) ? $query->row()->total_score : 0;

				// Calculate total coefficient for subjects where coe_second > 0 and student has marks > 0
				$this->db->select_sum('coe_second', 'total_coefficient'); // Use coe_second for coefficient
				$this->db->from('mark');
				$this->db->where('student_id', $student_id);
				$this->db->where('class_id', $class_id);
				$this->db->where('exam_id', $exam_id);
				$this->db->where('term ', $term);
				$this->db->where('session', $session);
				$this->db->where('mxc_second >', 0); // Only include subjects with marks greater than 0
				$query_coefficient = $this->db->get();

				if ($coefficient > 0) {
					$average = $total_score / $coefficient;
				} else {
					// Handle the case where coefficient is zero
					$average = 0; // or some other default value
				}	

				// Check if the query returned a result
				$total_coefficient = ($query_coefficient && $query_coefficient->num_rows() > 0) ? $query_coefficient->row()->total_coefficient : 0;

				?></strong></td>
				<td colspan="3" valign="top">&nbsp;$total_coefficient</td>
				<td colspan="3" valign="top">&nbsp;$total_score</td>
				</tr>
			</table>
			
			<table width="100%" border="1">
				<tr>
				<th width="29%" align="left">&nbsp;STUDENT'S RANK</th>e
				<td>&nbsp;<?php
						if ($rank == 0) {
							echo '--'; 
						} else {
							echo htmlspecialchars($rank); // Default to 'th' suffix

							// Determine appropriate suffix for rank (st, nd, rd)
							switch ($rank) {
								case 1:
									echo 'st';
									break;
								case 2:
									echo 'nd';
									break;
								case 3:
									echo 'rd';
									break;
								default:
									echo 'th';
							}
						}

					// Calculate student average
					$student_average = ($total_coefficient > 0) ? round($total_score / $total_coefficient, 2) : 0;

					// Now calculate class average based on all students in the same class
					$this->db->select_avg('(mxc_second / NULLIF(coe_second, 0))', 'class_average'); // Avoid division by zero
					$this->db->from('mark');
					$this->db->where('class_id', $class_id);
					$this->db->where('exam_id', $exam_id);
					$this->db->where('term', $term);
					$this->db->where('session', $session);
					$query_class_avg = $this->db->get();

					// Check if class average was calculated successfully
					$class_average = 0; // Default value for class average
					if ($query_class_avg && ($class_avg_row = $query_class_avg->row())) {
						if (isset($class_avg_row) && isset($class_avg_row->class_average)) {
							// Class average is already calculated above, round it to two decimal places.
							$class_average = round($class_avg_row->class_average, 2);
						}
					}

					// Rank calculation based on student_average compared to others in the same class
					if ($student_average > 0) {
						// Create a subquery to get ranks based on averages
						$sql = "SELECT COUNT(*) + 1 AS rank FROM (
									SELECT DISTINCT (SUM(mxc_second) / NULLIF(SUM(coe_second), 0)) AS avg_score 
									FROM mark 
									WHERE class_id = ? AND exam_id = ? AND term = ? AND session = ?
									GROUP BY student_id 
									HAVING avg_score > ?
								) AS ranked_students";

						// Execute query with parameters
						$rank_query = $this->db->query($sql, array($class_id, $exam_id, $term, $session, $student_average));
						
						if ($rank_row = $rank_query->row()) {
							// Ensure rank is an integer and format it correctly.
							// echo intval($rank_row->rank); // Convert rank to integer

							// Determine appropriate suffix for rank (st, nd, rd)
							
						} else {
							// echo '--'; 
						}
					} else {
						// echo '--'; 
					}

					//Calculate total number of subjects taken by student (mxc_second > 0)
					$num_subjt_taken = $this->db
						->from('mark')
						->where('student_id', $student_id)
						->where('class_id', $class_id)
						->where('term', $term)
						->where('session', $session)
						->where('mxc_second >', 0) // Count only subjects where mxc_second is greater than 0
						->count_all_results(); // Count all subjects taken by this student

					//Calculate number of subjects passed by student (assuming passing score is >=10)
					$num_subjt_passed = $this->db
						->from('mark')
						->where('student_id', $student_id)
						->where('class_id', $class_id)
						->where('term', $term)
						->where('session', $session)
						->where('ave_second >=', 10) // Assuming mxc_second represents scores that determine passing status
						->count_all_results(); // Count all subjects passed by this student

					// //Output results for total students, subjects taken, and subjects passed.
					// echo "Total Students in Class: " . htmlspecialchars($all_students_in_class) . "<br>";
					// echo "Subjects Taken: " . htmlspecialchars($num_subjt_taken) . "<br>";

					
				
				?></td>
				<td width="35%">&nbsp;Out of </td>
				<td width="21%">&nbsp;<?php echo '---' ?></td>	
			</tr>
			<tr>
				<th align="left">&nbsp;TERM</th>
				<th>&nbsp;1st Term</th>
				<th>&nbsp;2nd Term</th>
				<th>&nbsp;3rd Term</th>
			</tr>
			<tr>
				<th align="left">&nbsp;Students Average</th>
				<td>&nbsp;--</td>
				<td>&nbsp;<?= htmlspecialchars($student_average); ?></td>
				<td>&nbsp;--</td>
			</tr>
			<tr>
				<th align="left">&nbsp;Class Average</th>
				<td>&nbsp;<?= htmlspecialchars(round($class_average, 2)); ?></td> <!-- Display calculated class average -->
				<th colspan="2">&nbsp;Subjects Taken : <?= htmlspecialchars($num_subjt_taken); ?></th>
			</tr>
			<tr>
				<th align="left">&nbsp;Rank</th>
				<td>&nbsp;<?php
						if ($rank == 0) {
							echo '--'; 
						} else {
							echo htmlspecialchars($rank); // Default to 'th' suffix

							// Determine appropriate suffix for rank (st, nd, rd)
							switch ($rank) {
								case 1:
									echo 'st';
									break;
								case 2:
									echo 'nd';
									break;
								case 3:
									echo 'rd';
									break;
								default:
									echo 'th';
							}
						}
				?></td>
				<th colspan="2">&nbsp;Number of Subjects Passed : <?= htmlspecialchars($num_subjt_passed); ?> </th>
			</tr>
		</table>
		<br>
		
		<table width="100%" border="1">
			<tr bgcolor="#ccc" align="center">
			<td colspan="3">&nbsp;<strong>GENERAL REMARKS</strong> </td>
			</tr>
			<tr>
			<th colspan="2">&nbsp;CLASS MASTER</th>
			<th width="60%">&nbsp;PRINCIPAL</th>
			</tr>
			<tr>
				<?php $teacher_id = $this->db->get_where('class', array('class_id' => $class_id))->row()->teacher_id;;?>
			<th colspan="2">&nbsp;<?= $this->crud_model->get_type_name_by_id('teacher', $teacher_id)?></th>
			<th>&nbsp;Academics : </th>
			</tr>
			<tr>
			<td width="16%" align="left">&nbsp;Absences</td>
			<td width="24%" align="left">&nbsp;0</td>
			<th rowspan="5" align="left" style="font-size:50px; font-family:Arial Black">&nbsp;
						<?php if ($student_average <= '20.0' && $student_average >= '18.0'):?>
						<?php echo '<span style="color:red">Excellent</span>';?>
						<?php endif;?>
						
						<?php if ($student_average <= '17.9' && $student_average >= '16.1'):?>
						<?php echo '<span style="color:red">Very Good</span>';?>
						<?php endif;?>
						
						<?php if ($student_average <= '16.0' && $student_average >= '14.0'):?>
						<?php echo '<span style="color:red">Good</span>';?>
						<?php endif;?>
						
						<?php if ($student_average <= '13.9' && $student_average >= '12.0'):?>
						<?php echo '<span style="color:red">Fairly Good</span>';?>
						<?php endif;?>
						
						<?php if ($student_average <= "11.9" && $student_average >= '10'):?>
						<?php echo '<span style="color:red">Average</span>';?>
						<?php endif;?>
						
						<?php if ($student_average <= "9.9" && $student_average >= '0'):?>
						<?php echo '<span style="color:red">Failed</span>';?>
						<?php endif;?>
			
			</th>
			</tr>
			<tr>
			<td align="left">&nbsp;Health</td>
			<td align="left">&nbsp;0</td>
			</tr>
			<tr>
			<td align="left">&nbsp;Conduct</td>
			<td align="left">&nbsp;0</td>
			</tr>
			<tr>
			<td align="left">&nbsp;Purnishment</td>
			<td align="left">&nbsp;0</td>
			</tr>
			<tr>
			<td align="left">&nbsp;Next Term </td>
			<td align="left"> &nbsp;<?= date('jS F Y', strtotime(get_settings('next_term_begin')))?></td>
			</tr>
			<tr>
			<td colspan="3" align="center">
			<img src="<?php echo base_url();?>uploads/signature.png" width="200px" height="80px">
			<img src="<?php echo base_url();?>uploads/school_stamp.png" width="200px" height="80px">
			<br><strong style="font-style:italic">NB: Mark below 10 is a <span style="text-decoration:underline;">Fail Mark</span></strong> 
			</td>
			</tr>
		</table>
		

		

		
</div>
			
<?php endif;?>






<?php if($term == 3) : ?>
<div class="row" style="border:1px solid #000; padding:5px;">
	<div class="col-sm-12">
			<table width="100%">
			  <tr>
				<td class="pull-left"><img src="<?php echo base_url()?>uploads/logo.png"  height="150" width="150"></td>
				<td>
					<h1 align="center" style="font-weight:900; font-size:17px; font-family:Arial Black; line-height:15px;"><?php echo get_settings('system_name')?></h1>
					<h5 align="center" style="font-weight:500; font-size:15px; font-family:Arial Black; line-height:15px;"><?php echo get_settings('address')?></h5>
					<h5 align="center" style="font-weight:500; font-size:15px; font-family:Arial Black; line-height:15px;">Day Care, Nursery and Primary School</h5>
					<h5 align="center" style="font-weight:300; font-size:10px; font-family:Arial Black; line-height:15px;">Email: <?php echo get_settings('system_email')?>     Tel: <?php echo get_settings('phone')?></h5>
				</td>
				<td class="pull-right"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="150" width="150"></td>
			  </tr>		
			</table>
			
			<table width="100%" height="100" border="1" class="mb-3">
			  <tr>
				<td><strong>&nbsp;Name:</strong>&nbsp;					  <?=$student_selected['name'];?></td>
				<td><strong>&nbsp;Class:</strong>&nbsp;					  <?=$class_name;?></td>
				<td><strong>&nbsp;Term:</strong>&nbsp;					  <?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></td>
			  </tr>
			  <tr>
				<td><strong>&nbsp;No:</strong>&nbsp;					  <?=$student_selected['roll'];?></td>
				<td>&nbsp;<strong>Gender:</strong>&nbsp;					  <?=ucwords($student_selected['sex']);?></td>
				<td>&nbsp;<strong>Academic Year:</strong>&nbsp;					  <?=$session?></td>
			  </tr>
			</table>
			<table width="100%"  border="1" class="mb-2">
			  <tr>
				<th valign="top">&nbsp;Subjects</th>
				
				<th valign="top">&nbsp;Mark</th>
				<th valign="top">&nbsp;Coef</th>
				<th valign="top">&nbsp;MxC</th>
				<th valign="top">&nbsp;Pos</th>
				<th valign="top">&nbsp;Remarks</th>
				<th valign="top">&nbsp;Name of Tutor</th>
			  </tr>
			  
				<?php 
					$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
					foreach ($select_subject as $key => $subject):
					
					$coefficient = $subject['coefficient'];
					$teacher_id = $subject['teacher_id'];
				?>
				<tr>
				<td valign="top">&nbsp;<?php echo $subject['name'];?></td>
				
				   <?php 
					$obtained_mark_query = $this->db->get_where('mark', array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 'student_id' => $student_id, 'term' => $term));
					$ave_third    = $obtained_mark_query->row()->ave_third;
					$mxc_third    = $obtained_mark_query->row()->mxc_third;
					
					$total_score  = $obtained_mark_query->row()->mxc_third;
										
					if($total_score == ""){
						$total_score = 0;
					}else{
						$total_score = $total_score;	
					}			
										
										/*
										$update['mxc_third'] = $total_score;
										$this->db->where('subject_id' , $subject['subject_id']);
										$this->db->where('student_id' , $student_id);
										$this->db->update('mark', $update);
										*/
									
				?>
				
				<td valign="top">&nbsp;<?php if($ave_third == 0)echo '';else echo $ave_third;?></td>
				<td valign="top">&nbsp;<?php if($coefficient == 0)echo ''; else echo $coefficient;?></td>
				<td valign="top">&nbsp;<?php if($mxc_third == 0)echo ''; else echo $mxc_third;?></td>
				
				<td valign="top">&nbsp;
				
									<?php
									
									$subject_id = $subject['subject_id'];
									 $sql = "SELECT mark_id, mxc_third, FIND_IN_SET( mxc_third,(
											SELECT GROUP_CONCAT( mxc_third  ORDER BY mxc_third DESC ) 
											FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
											AS rank 
											FROM mark
											WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND mxc_third = $total_score"; 
	
									$rank =  $this->db->query($sql)->row()->rank; 
	
									if($rank == 0){
										echo '--'; 
									}
	
									if($rank == 1 || $rank == 21 || $rank == 31 || $rank == 41 || $rank == 51 || $rank == 61 || $rank == 71 || $rank == 81 || $rank == 91){
										echo $rank.'st';
									}elseif($rank == 2 ||$rank == 22 || $rank == 32 || $rank == 42 || $rank == 52 || $rank == 62 || $rank == 72 || $rank == 82 || $rank == 92){
									   echo $rank.'nd'; 
									}elseif($rank == 3 ||$rank == 23 || $rank == 33 || $rank == 43 || $rank == 53 || $rank == 63 || $rank == 73 || $rank == 83 || $rank == 93){
									   echo $rank.'rd'; 
									}elseif($rank > 3 && $rank!= 21 && $rank!= 31 && $rank!= 41 && $rank!= 51 && $rank!= 61 && $rank!= 71 && $rank!= 81 && $rank!= 91 && $rank!= 22 && $rank!= 31 && $rank!= 41 && $rank!= 51 && $rank!= 61 && $rank!= 71 && $rank!= 81 && $rank!= 91 && $rank!= 23 && $rank!= 33 && $rank!= 43 && $rank!= 53 && $rank!= 63 && $rank!= 73 && $rank!= 83 && $rank!= 93){
										echo $rank.'th';         
									}else{
										echo '--'; 
									}
									
									
									?>					</td>

			  <td valign="top">&nbsp;<?php echo $obtained_mark_query->row()->comment;?></td>
			  <?php $teacher = $this->crud_model->get_type_name_by_id('teacher', $teacher_id);?>
			  <td valign="top">&nbsp;<?php if($teacher == '')echo '---'; else echo strtoupper($teacher);?></td>
			  </tr>
			  <?php endforeach;?>
			  <tr>
				<td valign="top" align="right"><strong>Total</strong>&nbsp;</td>
				
				<td valign="top">&nbsp;<strong><?php
				
					$this->db->select_sum('ave_third');
					$this->db->from('mark');
					$this->db->where('student_id', $student_id);
					$this->db->where('term', $term);
					$this->db->where('session', $session);
							
					$query = $this->db->get();	
					$ave_third = $query->row()->ave_third;
							
					if($ave_third == ""){
						$ave_third = 0;
					}else{
						$ave_third = $ave_third;	
					}
					
					echo round($ave_third,2);
				
				?></strong>					</td>
				<td valign="top">&nbsp;<strong><?php
				
					$this->db->select_sum('coe_third');
					$this->db->from('mark');
					$this->db->where('student_id', $student_id);
					$this->db->where('term', $term);
					$this->db->where('session', $session);
							
					$query = $this->db->get();	
					$coe_third = $query->row()->coe_third;
							
					if($coe_third == ""){
						$coe_third = 0;
					}else{
						$coe_third = $coe_third;	
					}
					
					echo round($coe_third,2);
				
				?></strong>					</td>
				
				<td valign="top">&nbsp;<strong><?php
				
					$this->db->select_sum('mxc_third');
					$this->db->from('mark');
					$this->db->where('student_id', $student_id);
					$this->db->where('term', $term);
					$this->db->where('session', $session);
							
					$query = $this->db->get();	
					$mxc_third = $query->row()->mxc_third;
							
					if($mxc_third == ""){
						$mxc_third = 0;
					}else{
						$mxc_third = $mxc_third;	
					}
					
					echo round($mxc_third,2);
				
				?></strong>					</td>
				<td colspan="3" valign="top">&nbsp;</td>
			  </tr>
			</table>
			
			<table width="100%" border="1">
			  <tr>
				<th width="26%" align="left">&nbsp;STUDENT'S RANK</th>
				<td width="13%">&nbsp;<?php
						
						// All student averages in the same class
						$this->db->select_sum('ave_third');
						$this->db->from('mark');
						$this->db->where('class_id', $class_id);
						$this->db->where('exam_id', $exam_id);
						$this->db->where('term', $term);
						$this->db->where('session', $session);
								
						$query = $this->db->get();	
						$all_ave_third = $query->row()->ave_third;
								
						if($all_ave_third == ""){
							$all_ave_third = 0;
						}else{
							$all_ave_third = $all_ave_third;	
						}
				
						// Number of student in the class
						$all_students_in_class = $this->db->get_where('student', array('class_id' => $class_id))->num_rows();
						
						// Sum of MxC / sum of coefficients.	
						$student_average = round($mxc_third / $coe_third,2);
							
						// Sum of student averages / number of student in a class.
						$class_average = round($ave_third / $coe_third,2);
						
						$sql = "SELECT score, FIND_IN_SET( score,(
								SELECT GROUP_CONCAT( score  ORDER BY score desc ) 
								FROM class_position WHERE exam_id = $exam_id AND class_id = $class_id AND term = $term))
								AS rank 
								FROM class_position
								WHERE exam_id = $exam_id AND class_id = $class_id AND term = $term AND score = $student_average AND score != 0"; 
	
								$rank =  $this->db->query($sql)->row()->rank; 
	
								if($rank == 0){
										echo '--'; 
								}
	
								if($rank == 1 || $rank == 21 || $rank == 31 || $rank == 41 || $rank == 51 || $rank == 61 || $rank == 71 || $rank == 81 || $rank == 91){
									echo $rank.'st';
								}elseif($rank == 2 ||$rank == 22 || $rank == 32 || $rank == 42 || $rank == 52 || $rank == 62 || $rank == 72 || $rank == 82 || $rank == 92){
									 echo $rank.'nd'; 
								}elseif($rank == 3 ||$rank == 23 || $rank == 33 || $rank == 43 || $rank == 53 || $rank == 63 || $rank == 73 || $rank == 83 || $rank == 93){
									 echo $rank.'rd'; 
								}elseif($rank > 3 && $rank!= 21 && $rank!= 31 && $rank!= 41 && $rank!= 51 && $rank!= 61 && $rank!= 71 && $rank!= 81 && $rank!= 91 && $rank!= 22 && $rank!= 31 && $rank!= 41 && $rank!= 51 && $rank!= 61 && $rank!= 71 && $rank!= 81 && $rank!= 91 && $rank!= 23 && $rank!= 33 && $rank!= 43 && $rank!= 53 && $rank!= 63 && $rank!= 73 && $rank!= 83 && $rank!= 93){
									echo $rank.'th';         
								}else{
									echo '--'; 
								}
									
									
							?>					</td>
				<td width="13%">&nbsp;Out of </td>
				<td colspan="2">&nbsp;<?php echo  $all_students_in_class;?></td>
			  </tr>
			  <tr>
				<th align="left">&nbsp;TERM</th>
				<th>&nbsp;3rd Term</th>
				<th>&nbsp;1st Term</th>
				<th width="13%">&nbsp;2nd Term</th>
				<th width="35%" rowspan="2">&nbsp;</th>
			  </tr>
			  <tr>
				<th align="left">&nbsp;Student's Average</th>
				<td>&nbsp;<?= $student_average;?></td>
				<?php
					// Calculating first term details...... We need sum of all Ave, MxC
				
						// All student averages in the same class
						$this->db->select_sum('ave_first');
						$this->db->from('mark');
						$this->db->where('class_id', $class_id);
						$this->db->where('term', 1);
						$this->db->where('session', $session);
								
						$query = $this->db->get();	
						$all_ave_first = $query->row()->ave_first;
								
						if($all_ave_first == ""){
							$all_ave_first = 0;
						}else{
							$all_ave_first = $all_ave_first;	
						}
				
					
					// First term everage
					$this->db->select_sum('ave_first');
					$this->db->from('mark');
					$this->db->where('student_id', $student_id);
					$this->db->where('term', 1);
					$this->db->where('session', $session);
							
					$query = $this->db->get();	
					$ave_first = $query->row()->ave_first;
							
					if($ave_first == ""){
						$ave_first = 0;
					}else{
						$ave_first = $ave_first;	
					}
					
					// First term coefficient
					$this->db->select_sum('coe_first');
					$this->db->from('mark');
					$this->db->where('student_id', $student_id);
					$this->db->where('term', 1);
					$this->db->where('session', $session);
							
					$query = $this->db->get();	
					$coe_first = $query->row()->coe_first;
							
					if($coe_first == ""){
						$coe_first = 0;
					}else{
						$coe_first = $coe_first;	
					}
					
					// First term MxC
					$this->db->select_sum('mxc_first');
					$this->db->from('mark');
					$this->db->where('student_id', $student_id);
					$this->db->where('term', 1);
					$this->db->where('session', $session);
							
					$query = $this->db->get();	
					$mxc_first = $query->row()->mxc_first;
							
					if($mxc_first == ""){
						$mxc_first = 0;
					}else{
						$mxc_first = $mxc_first;	
					}
						
					// Sum of MxC / sum of coefficients.	
					$first_term_student_average = round($mxc_first / $coe_first,2);
							
					// Sum of student averages / number of student in a class.
					$first_term_class_average = round($ave_first / $coe_first,2);
					
					
					$first_term_students_class_avegares = round($all_ave_first / $all_students_in_class,2);
					
					
					
					
					/*****  FOR SECOND TERM  ****/
					
						// All student averages in the same class
						$this->db->select_sum('ave_second');
						$this->db->from('mark');
						$this->db->where('class_id', $class_id);
						$this->db->where('term', 2);
						$this->db->where('session', $session);
								
						$query = $this->db->get();	
						$third_all_ave_second = $query->row()->ave_second;
								
						if($third_all_ave_second == ""){
							$third_all_ave_second = 0;
						}else{
							$third_all_ave_second = $third_all_ave_second;	
						}
				
					
					// First term everage
					$this->db->select_sum('ave_second');
					$this->db->from('mark');
					$this->db->where('student_id', $student_id);
					$this->db->where('term', 2);
					$this->db->where('session', $session);
							
					$query = $this->db->get();	
					$ave_second = $query->row()->ave_second;
							
					if($ave_second == ""){
						$ave_second = 0;
					}else{
						$ave_second = $ave_second;	
					}
					
					// First term coefficient
					$this->db->select_sum('coe_second');
					$this->db->from('mark');
					$this->db->where('student_id', $student_id);
					$this->db->where('term', 2);
					$this->db->where('session', $session);
							
					$query = $this->db->get();	
					$coe_second = $query->row()->coe_second;
							
					if($coe_second == ""){
						$coe_second = 0;
					}else{
						$coe_second = $coe_second;	
					}
					
					// First term MxC
					$this->db->select_sum('mxc_second');
					$this->db->from('mark');
					$this->db->where('student_id', $student_id);
					$this->db->where('term', 2);
					$this->db->where('session', $session);
							
					$query = $this->db->get();	
					$mxc_second = $query->row()->mxc_second;
							
					if($mxc_second == ""){
						$mxc_second = 0;
					}else{
						$mxc_second = $mxc_second;	
					}
						
					// Sum of MxC / sum of coefficients.	
					$second_term_student_average = round($mxc_second / $coe_second,2);
							
					// Sum of student averages / number of student in a class.
					$second_term_class_average = round($ave_second / $coe_second,2);
					
					
					$second_term_students_class_avegares = round($third_all_ave_second / $all_students_in_class,2);
					
					/**** SECOND TERM ENDS HERE *****/				
				
				
				
				?>
				<td>&nbsp;<?php echo $first_term_student_average; ?></td>
				<td>&nbsp;<?php echo $second_term_student_average; ?></td>
			  </tr>
			  <tr>
				<th align="left">&nbsp;Class Average</th>
				<td>&nbsp;<?php
					// Sum of student averages / number of student in a class.
					$show_sum_ave_third = 	$all_ave_third / $all_students_in_class;
					echo round($show_sum_ave_third,2);
					
					// Number of subjects taken by student...
					$num_subjt = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => $term, 'session' => $session, 'student_id' => $student_id, 'ave_third !=' => 0))->num_rows();
					
					// Number of subjects passed by student - If the score of a suject is greater than 9, it is considered passed...
					$num_subjt_pass = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => $term, 'session' => $session, 'student_id' => $student_id, 'ave_third >=' => 10))->num_rows();		
				?>					</td>
				<td align="left">&nbsp;<?= $first_term_students_class_avegares ?></td>
				<td align="left">&nbsp;<?= $second_term_students_class_avegares ?></td>
				<th align="left">&nbsp;Subjects Taken :
				  <?= $num_subjt ?></th>
			  </tr>
			  <tr>
				<th align="left">&nbsp;Rank</th>
				<td> &nbsp;<?php
						$sql = "SELECT score, FIND_IN_SET( score,(
								SELECT GROUP_CONCAT( score  ORDER BY score desc ) 
								FROM class_position WHERE exam_id = $exam_id AND class_id = $class_id AND term = $term))
								AS rank 
								FROM class_position
								WHERE exam_id = $exam_id AND class_id = $class_id AND term = $term AND score = $student_average AND score != 0"; 
	
								$rank =  $this->db->query($sql)->row()->rank; 
	
								if($rank == 0){
										echo '--'; 
								}
	
								if($rank == 1 || $rank == 21 || $rank == 31 || $rank == 41 || $rank == 51 || $rank == 61 || $rank == 71 || $rank == 81 || $rank == 91){
									echo $rank.'st';
								}elseif($rank == 2 ||$rank == 22 || $rank == 32 || $rank == 42 || $rank == 52 || $rank == 62 || $rank == 72 || $rank == 82 || $rank == 92){
									 echo $rank.'nd'; 
								}elseif($rank == 3 ||$rank == 23 || $rank == 33 || $rank == 43 || $rank == 53 || $rank == 63 || $rank == 73 || $rank == 83 || $rank == 93){
									 echo $rank.'rd'; 
								}elseif($rank > 3 && $rank!= 21 && $rank!= 31 && $rank!= 41 && $rank!= 51 && $rank!= 61 && $rank!= 71 && $rank!= 81 && $rank!= 91 && $rank!= 22 && $rank!= 31 && $rank!= 41 && $rank!= 51 && $rank!= 61 && $rank!= 71 && $rank!= 81 && $rank!= 91 && $rank!= 23 && $rank!= 33 && $rank!= 43 && $rank!= 53 && $rank!= 63 && $rank!= 73 && $rank!= 83 && $rank!= 93){
									echo $rank.'th';         
								}else{
									echo '--'; 
								}
									
							?>					
				</td>
				<td align="left">&nbsp;<?php
						
						// Sum of MxC / sum of coefficients.
						
						$sql = "SELECT score, FIND_IN_SET( score,(
								SELECT GROUP_CONCAT( score  ORDER BY score desc ) 
								FROM class_position WHERE class_id = $class_id AND term = 1))
								AS rank 
								FROM class_position
								WHERE class_id = $class_id AND term = 1 AND score = $first_term_student_average AND score != 0"; 
	
								$rank =  $this->db->query($sql)->row()->rank; 
	
								if($rank == 0){
										echo '-'; 
								}
	
								if($rank == 1 || $rank == 21 || $rank == 31 || $rank == 41 || $rank == 51 || $rank == 61 || $rank == 71 || $rank == 81 || $rank == 91){
									echo $rank.'st';
								}elseif($rank == 2 ||$rank == 22 || $rank == 32 || $rank == 42 || $rank == 52 || $rank == 62 || $rank == 72 || $rank == 82 || $rank == 92){
									 echo $rank.'nd'; 
								}elseif($rank == 3 ||$rank == 23 || $rank == 33 || $rank == 43 || $rank == 53 || $rank == 63 || $rank == 73 || $rank == 83 || $rank == 93){
									 echo $rank.'rd'; 
								}elseif($rank > 3 && $rank!= 21 && $rank!= 31 && $rank!= 41 && $rank!= 51 && $rank!= 61 && $rank!= 71 && $rank!= 81 && $rank!= 91 && $rank!= 22 && $rank!= 31 && $rank!= 41 && $rank!= 51 && $rank!= 61 && $rank!= 71 && $rank!= 81 && $rank!= 91 && $rank!= 23 && $rank!= 33 && $rank!= 43 && $rank!= 53 && $rank!= 63 && $rank!= 73 && $rank!= 83 && $rank!= 93){
									echo $rank.'th';         
								}else{
									echo '-'; 
								}
									
									
							?>					
				</td>
				<td align="left">&nbsp;<?php
						
						// Sum of MxC / sum of coefficients.
						
						$sql = "SELECT score, FIND_IN_SET( score,(
								SELECT GROUP_CONCAT( score  ORDER BY score desc ) 
								FROM class_position WHERE class_id = $class_id AND term = 2))
								AS rank 
								FROM class_position
								WHERE class_id = $class_id AND term = 2 AND score = $second_term_student_average AND score != 0"; 
	
								$rank =  $this->db->query($sql)->row()->rank; 
	
								if($rank == 0){
										echo '-'; 
								}
	
								if($rank == 1 || $rank == 21 || $rank == 31 || $rank == 41 || $rank == 51 || $rank == 61 || $rank == 71 || $rank == 81 || $rank == 91){
									echo $rank.'st';
								}elseif($rank == 2 ||$rank == 22 || $rank == 32 || $rank == 42 || $rank == 52 || $rank == 62 || $rank == 72 || $rank == 82 || $rank == 92){
									 echo $rank.'nd'; 
								}elseif($rank == 3 ||$rank == 23 || $rank == 33 || $rank == 43 || $rank == 53 || $rank == 63 || $rank == 73 || $rank == 83 || $rank == 93){
									 echo $rank.'rd'; 
								}elseif($rank > 3 && $rank!= 21 && $rank!= 31 && $rank!= 41 && $rank!= 51 && $rank!= 61 && $rank!= 71 && $rank!= 81 && $rank!= 91 && $rank!= 22 && $rank!= 31 && $rank!= 41 && $rank!= 51 && $rank!= 61 && $rank!= 71 && $rank!= 81 && $rank!= 91 && $rank!= 23 && $rank!= 33 && $rank!= 43 && $rank!= 53 && $rank!= 63 && $rank!= 73 && $rank!= 83 && $rank!= 93){
									echo $rank.'th';         
								}else{
									echo '-'; 
								}
									
									
							?>                    
				</td>
				<th align="left">&nbsp;Number of Subjects Passed :
				  <?= $num_subjt_pass ?>                    
				 </th>
			  </tr>
			</table>
			<br>
			
			<table width="100%" border="1">
			  <tr bgcolor="#ccc" align="center">
				<td colspan="3">&nbsp;<strong>GENERAL REMARKS</strong> </td>
			  </tr>
			  <tr>
				<th colspan="2">&nbsp;CLASS MASTER</th>
				<th width="60%">&nbsp;PRINCIPAL</th>
			  </tr>
			  <tr>
				  <?php $teacher_id = $this->db->get_where('class', array('class_id' => $class_id))->row()->teacher_id;?>
				<th colspan="2">&nbsp;<?= $this->crud_model->get_type_name_by_id('teacher', $teacher_id)?></th>
					<?php
						
						$first_second_third_term_averages = $student_average + $first_term_student_average + $second_term_student_average;
						
						if($student_average != 0 && $first_term_student_average != 0 && $second_term_student_average != 0) 
						
						$first_second_third_term_averages = $first_second_third_term_averages / 3;
												
						if($student_average == 0 && $first_term_student_average != 0 && $second_term_student_average != 0) 
						$first_second_third_term_averages = $first_second_third_term_averages / 2;
												
						if($student_average != 0 && $first_term_student_average == 0 && $second_term_student_average != 0) 
						$first_second_third_term_averages = $first_second_third_term_averages / 2;
												
						if($student_average != 0 && $first_term_student_average != 0 && $second_term_student_average == 0) 

						$first_second_third_term_averages = $first_second_third_term_averages / 2;
												
						if($student_average != 0 && $first_term_student_average == 0 && $second_term_student_average == 0) 
						$first_second_third_term_averages = $first_second_third_term_averages / 1;
												
						if($student_average == 0 && $first_term_student_average != 0 && $second_term_student_average == 0) 
						$first_second_third_term_averages = $first_second_third_term_averages / 1;
												
						if($student_average == 0 && $first_term_student_average == 0 && $second_term_student_average != 0) 
						$first_second_third_term_averages = $first_second_third_term_averages / 1;
						
					?>
				
				
				<th align="left">&nbsp;Academics : 
							<?php if ($first_second_third_term_averages <= '20.0' && $first_second_third_term_averages >= '18.0'):?>
							<?php echo '<span style="color:green">Excellent</span>';?>
							<?php endif;?>
							
							<?php if ($first_second_third_term_averages <= '17.9' && $first_second_third_term_averages >= '16.1'):?>
							<?php echo '<span style="color:green">Very Good</span>';?>
							<?php endif;?>
							
							<?php if ($first_second_third_term_averages <= '16.0' && $first_second_third_term_averages >= '14.0'):?>
							<?php echo '<span style="color:green">Good</span>';?>
							<?php endif;?>
							
							<?php if ($first_second_third_term_averages <= '13.9' && $first_second_third_term_averages >= '12.0'):?>
							<?php echo '<span style="color:green">Fairly Good</span>';?>
							<?php endif;?>
							
							<?php if ($first_second_third_term_averages <= "11.9" && $first_second_third_term_averages >= '10'):?>
							<?php echo '<span style="color:green">Average</span>';?>
							<?php endif;?>
							
							<?php if ($first_second_third_term_averages <= "9.9" && $first_second_third_term_averages >= '0'):?>
							<?php echo '<span style="color:red">Failed</span>';?>
							<?php endif;?>
				</th>
			  </tr>
			  <tr>
				<td width="16%" align="left">&nbsp;Absences</td>
				<td width="24%" align="left">&nbsp;0</td>
				<th rowspan="5" align="left" style="font-size:50px; font-family:Arial Black">&nbsp;
							
							<?php if ($first_second_third_term_averages >= '10.0'):?>
							
							<?php echo '<span style="color:green">PROMOTED</span>';?>
							
							<?php else : ?>
							
							<?php echo '<span style="color:green">REPEAT</span>';?>
							
							<?php endif;?>
				
				</th>
			  </tr>
			  <tr>
				<td align="left">&nbsp;Health</td>
				<td align="left">&nbsp;0</td>
			  </tr>
			  <tr>
				<td align="left">&nbsp;Conduct</td>
				<td align="left">&nbsp;0</td>
			  </tr>
			  <tr>
				<td align="left">&nbsp;Purnishment</td>
				<td align="left">&nbsp;0</td>
			  </tr>
			  <tr>
				<td align="left">&nbsp;Next Term </td>
				<td align="left"> &nbsp;<?= date('jS F Y', strtotime(get_settings('next_term_begin')))?></td>
			  </tr>
			  <tr>
				<td colspan="3" align="center">
				<img src="<?php echo base_url();?>uploads/signature.png" width="200px" height="80px">
				<img src="<?php echo base_url();?>uploads/school_stamp.png" width="200px" height="80px">
				<br><strong style="font-style:italic">NB: Mark below 10 is a <span style="text-decoration:underline;">Fail Mark</span></strong> 
				</td>
			  </tr>
			</table>
			

		  

		  
	</div>

</div><!-- End Row -->
			
<?php endif;?>























			

<p style='overflow:hidden;page-break-before:always;'></p>

<?php endforeach;?>
</div><!-- Print Row -->

<div align="center">
	<button id="print" class="btn btn-success btn-sm" type="button"> <span><i class="fa fa-print"></i>&nbsp;Print</span> </button>
</div>