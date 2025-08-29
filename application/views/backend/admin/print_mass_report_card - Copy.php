<style type="text/css">

hr.style1{
	border-top: 1px solid #8c8b8b;
}


hr.style2 {
	border-top: 3px double #8c8b8b;
}

hr.style3 {
	border-top: 1px dashed #8c8b8b;
}
@page Section1 {
    size: 8.27in 11.69in; 
    margin: .5in .5in .5in .5in; 
    mso-header-margin: .5in; 
    mso-footer-margin: .5in; 
    mso-paper-source: 0;
}

div.Section1 {
    page: Section1;
} 
@media print {
	table, table tr, table td {
		border-top: #000 solid 1px;
		border-bottom: #000 solid 1px;
		border-left: #000 solid 1px;
		border-right: #000 solid 1px;
		border-collapse: collapse;
	}
	.pagebreak {page-break-before:always;}
} 

.style1 {color: #FFFFFF}
.style2 {
	color: #FFFFFF;
	font-weight: bold;
}
.style3 {
	color: #000000;
	font-weight: bold;
}
.style4 {color: #FF0000}
</style>

<div class="row">  
  <div class="col-sm-12"> 
  	<div class="panel">   
  		<div class="table-responsive">
		
		<div class="printableArea" align="center"> 
		<div class="print" style="border:1px solid #000; padding-left:5px; padding-right:5px; padding-bottom:5px; padding-top:5px;"> 
		
    <?php
		$class_name = $this->db->get_where('class', array('class_id' => $class_id))->row()->name;
		$select_student_from_model = $this->crud_model->get_section_students($class_id,$section_id);
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
	
	<?php if(get_settings('report_template') == 1):?>
				<?php if($term == 1) : ?>

				<table width="100%">
				  <tr>
					<td class="pull-left"><img src="<?php echo base_url()?>uploads/logo.png"  height="150" width="150"></td>
					<td>
						<h2 align="center"><?php echo get_settings('system_name')?></h2>
						<p align="center"><?php echo get_settings('address')?> <br/>
						<i class="fa fa-envelope"></i> <?php echo get_settings('system_email')?> : <i class="fa fa-phone"></i> <?php echo get_settings('phone')?></p>	
					</td>
					<td class="pull-right"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="150" width="150"></td>
				  </tr>		
				</table>
				
								
				<table width="100%" height="100" border="1">
				  <tr>
					<td width="150"><strong>&nbsp;PUPIL'S NAME:</strong></td>
					<td width="204">&nbsp;<?=$student_selected['name'];?></td>
					<td width="78"><strong>&nbsp;CLASS:</strong></td>
					<td width="168">&nbsp;<?=$class_name;?></td>
					<td><strong>&nbsp;TERM:</strong></td>
					<td>&nbsp;<?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></td>
				  </tr>
				  <tr>
					<td><strong>&nbsp;ADMISSION NO:</strong></td>
					<td>&nbsp;<?=$student_selected['roll'];?></td>
					<td>&nbsp;<strong>SEX:</strong></td>
					<td>&nbsp;<?=ucwords($student_selected['sex']);?></td>
					<td width="154">&nbsp;<strong>SESSION:</strong></td>
					<td width="198">&nbsp;<?=$session?></td>
				  </tr>
				  <tr>
					<td><strong>&nbsp;NEXT TERM BEGINS:</strong></td>
					<td>&nbsp;<?=get_settings('next_term_begin')?></td>
					<td><strong>&nbsp;ATTENDANCE:</strong></td>
					<td></td>
					<td><strong>&nbsp;TIME PRESENT:</strong></td>
					<td></td>
				  </tr>
				</table>
				
				<table width="100%" border="0">
				  <tr>
					<td style="background:black; color:white" align="center">TERMINAL REPORT CARD</td>
				  </tr>
				</table>
				
				<table width="100%"  border="1">
				  <tr>
					<td valign="top"><strong>&nbsp;SUBJECTS</strong></td>
					
					<td valign="top"><strong>&nbsp;C.A (40)</strong> </td>
					<td valign="top"><strong>&nbsp;EXAM (60)</strong> </td>
					<td valign="top"><strong>&nbsp;TOTAL (100)</strong> </td>
					<td valign="top"><strong>&nbsp;AVG.(%) </strong></td>
					<td valign="top"><strong>&nbsp;HIGHEST SCORE</strong> </td>
					<td valign="top"><strong>&nbsp;LOWEST SCORE </strong></td>
					<td valign="top"><strong>&nbsp;GRADE</strong></td>
					<td valign="top">&nbsp;<strong>SUBJECT COMMENT</strong> </td>
				  </tr>
				  
                    <?php 
						$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
						foreach ($select_subject as $key => $subject):
					?>
					<tr>
					<td valign="top">&nbsp;<?php echo $subject['name'];?></td>
					
                                        <?php 
										$obtained_mark_query = $this->db->get_where('mark', 
											array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 
											'student_id' => $student_id, 'term' => 1));
                                        
										

                                            $class_score_one    = $obtained_mark_query->row()->class_score1;
                                            //$class_score_two    = $obtained_mark_query->row()->class_score2;
                                            //$class_score_three  = $obtained_mark_query->row()->class_score3;
                                            $exam_score         = $obtained_mark_query->row()->exam_score;
											$total_CA        	= $class_score_one;// + $class_score_two + $class_score_three;
                                            $total_score        = $class_score_one + $exam_score;// + $class_score_three + $exam_score;
											
											if($total_score == ""){
												$total_score = 0;
											}else{
												$total_score = $total_score;	
											}
                                        
										
											$update['sum_first'] = $total_score;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $update);
										
                                        ?>
					
					<td valign="top">&nbsp;<?php if($total_CA == 0)echo '';else echo $total_CA;?></td>
					<td valign="top">&nbsp;<?php if($exam_score == 0)echo ''; else echo $exam_score;?></td>
					<td valign="top">&nbsp;<?php if($total_score == 0)echo ''; else echo $total_score;?></td>
					<td valign="top">&nbsp;
					
					<?php 
					
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('subject_id', $subject['subject_id']);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
									if($sumTotalOfFirstScore == ""){
										$sumTotalOfFirstScore = 0;
									}else{
										$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
								
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'subject_id' => $subject['subject_id'], 'exam_score !=' => 0))->num_rows();
									
									
									
									$updatePercetangeFirst = round($sumTotalOfFirstScore/$getSubjectNumbered,2);
									if(is_nan($updatePercetangeFirst)){
										echo $updatePercetangeFirst = "";
									}
									if(!is_nan($updatePercetangeFirst)){
										echo $updatePercetangeFirst = $updatePercetangeFirst;
									}
									
									$average['class_position_first'] = $updatePercetangeFirst;
									$this->db->where('subject_id' , $subject['subject_id']);
									$this->db->where('student_id' , $student_id);
									$this->db->update('mark', $average);		
									
					?>
					
					
					</td>
					<td valign="top">&nbsp;

                                            <?php
                                                echo $highest_mark = $this->crud_model->get_highest_marks_first( $exam_id , $class_id , $subject['subject_id'], 1 );
                                                
                                            ?>
											
					</td>
					<td valign="top">&nbsp;
                                            <?php
                                                echo $lowest_mark = $this->crud_model->get_lowest_marks_first( $exam_id , $class_id , $subject['subject_id'], 1 );
                                            ?>
					</td>
					<td valign="top">&nbsp;
								<?php if ($total_score <= '100' && $total_score >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($total_score <= '79' && $total_score >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($total_score <= "59" && $total_score >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					</td>
					<td valign="top">&nbsp;<?php echo $obtained_mark_query->row()->comment;?></td>
				  </tr>
				  <?php endforeach;?>
				</table>
				<table width="100%" height="254" border="1">
				  <tr>
					<td width="254" height="48"><strong>&nbsp;TOTAL SCORE OBTAINABLE :</strong></td>
					<td width="294">&nbsp;
					<?php $session =  $session;?>
					<?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 'session' => $session,  'student_id' => $student_id, 'exam_score !=' => 0))->num_rows() * 100;	
			
					?>					
					</td>
					
					<td width="261">&nbsp;<strong>OVERALL PERCENTAGE: </strong></td>
					<td width="130">&nbsp;
					
					<?php 
					
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
									if($sumTotalOfFirstScore == ""){
										$sumTotalOfFirstScore = 0;
									}else{
										$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
								
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'student_id' => $student_id, 'exam_score !=' => 0))->num_rows();		
					?>
					
					<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?> %
					</td>
					
					<td colspan="2"><strong>&nbsp;Personal Development (5mks) :</strong></td>
				  </tr>
				  
				  
				  <tr>
					<td rowspan="2"><strong>&nbsp;TOTAL SCORE OBTAINED :</strong></td>
					<td rowspan="2">&nbsp;
								<?php
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
									if($sumTotalOfFirstScore == ""){
										echo $sumTotalOfFirstScore = 0;
									}else{
										echo $sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
							?>					
					</td>
					
					
					<td rowspan="2">&nbsp;<strong>OVERALL GRADE:</strong> </td>
					<td rowspan="2">&nbsp;
								<?php $FindGrade = round($sumTotalOfFirstScore /$getSubjectNumbered,2);?>
								<?php if ($FindGrade <= '100' && $FindGrade >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '79.9' && $FindGrade >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '69.9' && $FindGrade >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "59.9" && $FindGrade >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "49.9" && $FindGrade >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "39.9" && $FindGrade >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					</td>
					
					<?php 
					$select = $this->db->get_where('stu_rem', array('student_id' => $student_id, 'session' => $session, 'term' => $term))->row();?>
					<td width="210">&nbsp;Mental Alertness </td>
					<td width="111">&nbsp;<?=$select->ma;?></td>
				  </tr>
				  <tr>
				    <td>&nbsp;Physical Development</td>
			        <td width="111">&nbsp;<?=$select->pd;?></td>
				  </tr>
				  
				  
				  <tr>
					<td rowspan="2"><strong>&nbsp;CLASS TEACHER'S REMARKS :</strong></td>
					<td colspan="3" rowspan="2">&nbsp;<?=$select->class_comment;?></td>
					<td width="210">&nbsp;Relating  with Teacher&rsquo;s</td>
					<td width="111">&nbsp;<?=$select->rt;?></td>
				  </tr>
				  <tr>
				    <td>&nbsp;Relating with mates</td>
			        <td width="111">&nbsp;<?=$select->rm;?></td>
				  </tr>
				  
				  
				  <tr>
					<td rowspan="2"><strong>&nbsp;HEAD TEACHER'S REMARKS :</strong></td>
					<td colspan="3" rowspan="2">&nbsp;<?=$select->head_comment;?></td>
					<td width="210">&nbsp;General Habit &amp; Attitude</td>
					<td width="111">&nbsp;<?=$select->gha;?></td>
				  </tr>
				  <tr>
				    <td>&nbsp;Punctuality</td>
			        <td width="111">&nbsp;<?=$select->p;?></td>
				  </tr> 
				  
				  <tr>
					<td colspan="4" rowspan="2">&nbsp;</td>
					<td width="210">&nbsp;Neatness</td>
					<td width="111">&nbsp;<?=$select->n;?></td>
				  </tr>
				  <tr>
				    <td>&nbsp;Leadership Traits</td>
			        <td width="111">&nbsp;<?=$select->lt;?></td>
				  </tr>
				</table>
				



				<?php endif;?>
				<div class="pagebreak"> </div>
			
			
			
				<?php if($term == 2) : ?>

				<table width="100%">
				  <tr>
					<td class="pull-left"><img src="<?php echo base_url()?>uploads/logo.png"  height="150" width="150"></td>
					<td>
						<h2 align="center"><?php echo get_settings('system_name')?></h2>
						<p align="center"><?php echo get_settings('address')?> <br/>
						<i class="fa fa-envelope"></i> <?php echo get_settings('system_email')?> : <i class="fa fa-phone"></i> <?php echo get_settings('phone')?></p>	
					</td>
					<td class="pull-right"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="150" width="150"></td>
				  </tr>		
				</table>
				
								
				<table width="100%" height="100" border="1">
				  <tr>
					<td width="150"><strong>&nbsp;PUPIL'S NAME:</strong></td>
					<td width="204">&nbsp;<?=$student_selected['name'];?></td>
					<td width="78"><strong>&nbsp;CLASS:</strong></td>
					<td width="168">&nbsp;<?=$class_name;?></td>
					<td><strong>&nbsp;TERM:</strong></td>
					<td>&nbsp;<?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></td>
				  </tr>
				  <tr>
					<td><strong>&nbsp;ADMISSION NO:</strong></td>
					<td>&nbsp;<?=$student_selected['roll'];?></td>
					<td>&nbsp;<strong>SEX:</strong></td>
					<td>&nbsp;<?=ucwords($student_selected['sex']);?></td>
					<td width="154">&nbsp;<strong>SESSION:</strong></td>
					<td width="198">&nbsp;<?=$session?></td>
				  </tr>
				  <tr>
					<td><strong>&nbsp;NEXT TERM BEGINS:</strong></td>
					<td>&nbsp;<?=get_settings('next_term_begin')?></td>
					<td><strong>&nbsp;ATTENDANCE:</strong></td>
					<td></td>
					<td><strong>&nbsp;TIME PRESENT:</strong></td>
					<td></td>
				  </tr>
				</table>
				
				<table width="100%" border="0">
				  <tr>
					<td style="background:black; color:white" align="center">TERMINAL REPORT CARD</td>
				  </tr>
				</table>
				
				<table width="100%"  border="1">
				  <tr>
					<td valign="top"><strong>&nbsp;SUBJECTS</strong></td>
					
					<td valign="top"><strong>&nbsp;C.A (40)</strong> </td>
					<td valign="top"><strong>&nbsp;EXAM (60)</strong> </td>
					<td valign="top"><strong>&nbsp;TOTAL (100)</strong> </td>
					<td valign="top"><strong>&nbsp;AVG.(%) </strong></td>
					<td valign="top"><strong>&nbsp;HIGHEST SCORE</strong> </td>
					<td valign="top"><strong>&nbsp;LOWEST SCORE </strong></td>
					<td valign="top"><strong>&nbsp;GRADE</strong></td>
					<td valign="top">&nbsp;<strong>SUBJECT COMMENT</strong> </td>
				  </tr>
				  
                    <?php 
						$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
						foreach ($select_subject as $key => $subject):
					?>
					<tr>
					<td valign="top">&nbsp;<?php echo $subject['name'];?></td>
					
                                        <?php 
										$obtained_mark_query = $this->db->get_where('mark', 
											array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 
											'student_id' => $student_id, 'term' => 2));
                                        
										

                                            $class_score_one    = $obtained_mark_query->row()->class_score1;
                                            //$class_score_two    = $obtained_mark_query->row()->class_score2;
                                            //$class_score_three  = $obtained_mark_query->row()->class_score3;
                                            $exam_score         = $obtained_mark_query->row()->exam_score;
											$total_CA        	= $class_score_one;// + $class_score_two + $class_score_three;
                                            $total_score        = $class_score_one + $exam_score;// + $class_score_three + $exam_score;
											
											if($total_score == ""){
												$total_score = 0;
											}else{
												$total_score = $total_score;	
											}
                                        
										
											$update['sum_second'] = $total_score;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $update);
										 
                                        ?>
					
					<td valign="top">&nbsp;<?php if($total_CA == 0)echo '';else echo $total_CA;?></td>
					<td valign="top">&nbsp;<?php if($exam_score == 0)echo ''; else echo $exam_score;?></td>
					<td valign="top">&nbsp;<?php if($total_score == 0)echo ''; else echo $total_score;?></td>
					<td valign="top">&nbsp;
					
					<?php 
					
								$set = $session;
                                $this->db->select_sum('sum_second');
                                $this->db->from('mark');
                                $this->db->where('subject_id', $subject['subject_id']);
								$this->db->where('term', 2);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfSecondScore = $query->row()->sum_second;
								
									if($sumTotalOfSecondScore == ""){
										$sumTotalOfSecondScore = 0;
									}else{
										$sumTotalOfSecondScore = $sumTotalOfSecondScore;	
									}
								
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 
									'subject_id' => $subject['subject_id'], 'exam_score !=' => 0))->num_rows();
									
									
									
									$updatePercetangeSecond = round($sumTotalOfSecondScore/$getSubjectNumbered,2);
									if(is_nan($updatePercetangeSecond)){
										echo $updatePercetangeSecond = "";
									}
									if(!is_nan($updatePercetangeSecond)){
										echo $updatePercetangeSecond = $updatePercetangeSecond;
									}
									
									$average['class_position_second'] = $updatePercetangeSecond;
									$this->db->where('subject_id' , $subject['subject_id']);
									$this->db->where('student_id' , $student_id);
									$this->db->update('mark', $average);
					?>
					
					
					</td>
					<td valign="top">&nbsp;

                                            <?php
                                                echo $highest_mark = $this->crud_model->get_highest_marks_second( $exam_id , $class_id , $subject['subject_id'], 2 );
                                                
                                            ?>
											
					</td>
					<td valign="top">&nbsp;
                                            <?php
                                                echo $lowest_mark = $this->crud_model->get_lowest_marks_second( $exam_id , $class_id , $subject['subject_id'], 2 );
                                            ?>
					</td>
					<td valign="top">&nbsp;
								<?php if ($total_score <= '100' && $total_score >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($total_score <= '79' && $total_score >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($total_score <= "59" && $total_score >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					</td>
					<td valign="top">&nbsp;<?php echo $obtained_mark_query->row()->comment;?></td>
				  </tr>
				  <?php endforeach;?>
				</table>
				<table width="100%" height="254" border="1">
				  <tr>
					<td width="247" height="48"><strong>&nbsp;TOTAL SCORE OBTAINABLE :</strong></td>
					<td width="305">&nbsp;
					<?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 'session' => $session,  'student_id' => $student_id, 'exam_score !=' => 0))->num_rows() * 100;	
			
					?>					</td>
					
					
					
					
					
					
					<td width="262">&nbsp;<strong>OVERALL PERCENTAGE: </strong></td>
					<td width="135">&nbsp;
					
					<?php 
					
								$set = $session;
                                $this->db->select_sum('sum_second');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 2);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfSecondScore = $query->row()->sum_second;
								
									if($sumTotalOfSecondScore == ""){
										$sumTotalOfSecondScore = 0;
									}else{
										$sumTotalOfSecondScore = $sumTotalOfSecondScore;	
									}
								
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 
									'student_id' => $student_id, 'exam_score !=' => 0))->num_rows();		
					?>
					
					<?=round($sumTotalOfSecondScore /$getSubjectNumbered,2)?> %					</td>
					<td colspan="2"><strong>&nbsp;Personal Development (5mks) :</strong></td>
				  </tr>
				  
				  
				  <tr>
					<td rowspan="2"><strong>&nbsp;TOTAL SCORE OBTAINED :</strong></td>
					<td rowspan="2">&nbsp;
								<?php
								$set = $session;
                                $this->db->select_sum('sum_second');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 2);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfSecondScore = $query->row()->sum_second;
								
									if($sumTotalOfSecondScore == ""){
										echo $sumTotalOfSecondScore = 0;
									}else{
										echo $sumTotalOfSecondScore = $sumTotalOfSecondScore;	
									}
							?>					</td>
					
					
					
					
					<td rowspan="2">&nbsp;<strong>OVERALL GRADE:</strong> </td>
					<td rowspan="2">&nbsp;
								<?php $FindGrade = round($sumTotalOfSecondScore /$getSubjectNumbered,2);?>
								<?php if ($FindGrade <= '100' && $FindGrade >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '79.9' && $FindGrade >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '69.9' && $FindGrade >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "59.9" && $FindGrade >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "49.9" && $FindGrade >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "39.9" && $FindGrade >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					</td>
					<?php 
					$select = $this->db->get_where('stu_rem', array('student_id' => $student_id, 'session' => $session, 'term' => $term))->row();?>
					<td width="210">&nbsp;Mental Alertness </td>
					<td width="111">&nbsp;<?=$select->ma;?></td>
				  </tr>
				  <tr>
				    <td>&nbsp;Physical Development</td>
			        <td width="111">&nbsp;<?=$select->pd;?></td>
				  </tr>
				  
				  
				  <tr>
					<td rowspan="2"><strong>&nbsp;CLASS TEACHER'S REMARKS :</strong></td>
					<td colspan="3" rowspan="2">&nbsp;<?=$select->class_comment;?></td>
					<td width="210">&nbsp;Relating  with Teacher&rsquo;s</td>
					<td width="111">&nbsp;<?=$select->rt;?></td>
				  </tr>
				  <tr>
				    <td>&nbsp;Relating with mates</td>
			        <td width="111">&nbsp;<?=$select->rm;?></td>
				  </tr>
				  
				  
				  <tr>
					<td rowspan="2"><strong>&nbsp;HEAD TEACHER'S REMARKS :</strong></td>
					<td colspan="3" rowspan="2">&nbsp;<?=$select->head_comment;?></td>
					<td width="210">&nbsp;General Habit &amp; Attitude</td>
					<td width="111">&nbsp;<?=$select->gha;?></td>
				  </tr>
				  <tr>
				    <td>&nbsp;Punctuality</td>
			        <td width="111">&nbsp;<?=$select->p;?></td>
				  </tr> 
				  
				  <tr>
					<td colspan="4" rowspan="2">&nbsp;</td>
					<td width="210">&nbsp;Neatness</td>
					<td width="111">&nbsp;<?=$select->n;?></td>
				  </tr>
				  <tr>
				    <td>&nbsp;Leadership Traits</td>
			        <td width="111">&nbsp;<?=$select->lt;?></td>
				  </tr>
				</table>
				



				<?php endif;?>
				<div class="pagebreak"> </div>
				
				
				
				
				
				
			<?php if($term == 3) : ?>

				<table width="100%">
				  <tr>
					<td class="pull-left"><img src="<?php echo base_url()?>uploads/logo.png"  height="150" width="150"></td>
					<td>
						<h2 align="center"><?php echo get_settings('system_name')?></h2>
						<p align="center"><?php echo get_settings('address')?> <br/>
						<i class="fa fa-envelope"></i> <?php echo get_settings('system_email')?> : <i class="fa fa-phone"></i> <?php echo get_settings('phone')?></p>	
					</td>
					<td class="pull-right"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="150" width="150"></td>
				  </tr>		
				</table>
				
								
				<table width="100%" height="100" border="1">
				  <tr>
					<td width="150"><strong>&nbsp;PUPIL'S NAME:</strong></td>
					<td width="204">&nbsp;<?=$student_selected['name'];?></td>
					<td width="78"><strong>&nbsp;CLASS:</strong></td>
					<td width="168">&nbsp;<?=$class_name;?></td>
					<td><strong>&nbsp;TERM:</strong></td>
					<td>&nbsp;<?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></td>
				  </tr>
				  <tr>
					<td><strong>&nbsp;ADMISSION NO:</strong></td>
					<td>&nbsp;<?=$student_selected['roll'];?></td>
					<td>&nbsp;<strong>SEX:</strong></td>
					<td>&nbsp;<?=ucwords($student_selected['sex']);?></td>
					<td width="154">&nbsp;<strong>SESSION:</strong></td>
					<td width="198">&nbsp;<?=$session?></td>
				  </tr>
				  <tr>
					<td><strong>&nbsp;NEXT TERM BEGINS:</strong></td>
					<td>&nbsp;<?=get_settings('next_term_begin')?></td>
					<td><strong>&nbsp;ATTENDANCE:</strong></td>
					<td></td>
					<td><strong>&nbsp;TIME PRESENT:</strong></td>
					<td></td>
				  </tr>
				</table>
				
				<table width="100%" border="0">
				  <tr>
					<td style="background:black; color:white" align="center">TERMINAL REPORT CARD</td>
				  </tr>
				</table>
				
				<table width="100%"  border="1">
				  <tr>
					<td valign="top"><strong>&nbsp;SUBJECTS</strong></td>
					<td valign="top"><strong>&nbsp;1st Term</strong> </td>
					<td valign="top"><strong>&nbsp;2nd Term</strong> </td>
					<td valign="top"><strong>&nbsp;C.A (40)</strong> </td>
					<td valign="top"><strong>&nbsp;EXAM (60)</strong> </td>
					<td valign="top"><strong>&nbsp;TOTAL (100)</strong> </td>
					<td valign="top"><strong>&nbsp;AVG.(%) </strong></td>
					<td valign="top"><strong>&nbsp;HIGHEST SCORE</strong> </td>
					<td valign="top"><strong>&nbsp;LOWEST SCORE </strong></td>
					<td valign="top"><strong>&nbsp;GRADE</strong></td>
					<td valign="top">&nbsp;<strong>SUBJECT COMMENT</strong> </td>
				  </tr>
				  
                    <?php 
						$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
						foreach ($select_subject as $key => $subject):
					?>
					<tr>
					<td valign="top">&nbsp;<?php echo $subject['name'];?></td>
					
                                        <?php 
										$obtained_mark_query = $this->db->get_where('mark', 
											array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 
											'student_id' => $student_id, 'term' => 3));
                                        
										

                                            $class_score_one    = $obtained_mark_query->row()->class_score1;
                                            //$class_score_two    = $obtained_mark_query->row()->class_score2;
                                            //$class_score_three  = $obtained_mark_query->row()->class_score3;
                                            $exam_score         = $obtained_mark_query->row()->exam_score;
											$total_CA        	= $class_score_one;// + $class_score_two + $class_score_three;
                                            $total_score        = $class_score_one + $exam_score;// + $class_score_three + $exam_score;
											
											if($total_score == ""){
												$total_score = 0;
											}else{
												$total_score = $total_score;	
											}
                                        
										
											$update['sum_third'] = $total_score;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $update);
										 
                                        ?>
					<td valign="top">&nbsp;<?php if ($obtained_mark_query->row()->sum_first == 0) echo '';else echo $obtained_mark_query->row()->sum_first; ?></td>
					<td valign="top">&nbsp;<?php if ($obtained_mark_query->row()->sum_second == 0)echo '';else echo $obtained_mark_query->row()->sum_second;?></td>
					
					<td valign="top">&nbsp;<?php if($total_CA == 0)echo '';else echo $total_CA;?></td>
					<td valign="top">&nbsp;<?php if($exam_score == 0)echo ''; else echo $exam_score;?></td>
					<td valign="top">&nbsp;<?php if($total_score == 0)echo ''; else echo $total_score;?></td>
					<td valign="top">&nbsp;
					
					<?php 
					
									$set = $session;
									$this->db->select_sum('sum_third');
									$this->db->from('mark');
									$this->db->where('subject_id' , $subject['subject_id']);
									$this->db->where('student_id', $student_id);
									$this->db->where('term', 3);
									$this->db->where('session', $set);
									
									$query = $this->db->get();									
									$sumTotalOfThirdScore = $query->row()->sum_third;
				
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3,'subject_id' => $subject['subject_id'], 
									'exam_score !=' => 0))->num_rows();
					
					
									$updatePercetangeThird = round($sumTotalOfThirdScore/$getSubjectNumbered,2);
									if(is_nan($updatePercetangeThird)){
										$updatePercetangeThird = 0;
									}
									if(!is_nan($updatePercetangeThird)){
										$updatePercetangeThird = $updatePercetangeThird;
									}
									
											$average['class_position_third'] = $updatePercetangeThird;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $average);	
					
					
					
					
					$AnnualSum = $obtained_mark_query->row()->class_position_first + $obtained_mark_query->row()->class_position_second + $obtained_mark_query->row()->class_position_third;
						  $AnnualAverage = $AnnualSum / 3;
						  if($AnnualAverage == 0)
						  echo "";
						  else
						  echo round($AnnualAverage, 2);
					?>
					
					
					</td>
					<td valign="top">&nbsp;

                                            <?php
                                                echo $highest_mark = $this->crud_model->get_highest_marks_third( $exam_id , $class_id , $subject['subject_id'], 3 );
                                                
                                            ?>
											
					</td>
					<td valign="top">&nbsp;
                                            <?php
                                                echo $lowest_mark = $this->crud_model->get_lowest_marks_third( $exam_id , $class_id , $subject['subject_id'], 3 );
                                            ?>
					</td>
					<td valign="top">&nbsp;
								<?php if ($AnnualAverage <= '100' && $AnnualAverage >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($AnnualAverage <= '79.9' && $AnnualAverage >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($AnnualAverage <= '69.9' && $AnnualAverage >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($AnnualAverage <= "59.9" && $AnnualAverage >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($AnnualAverage <= "49.9" && $AnnualAverage >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($AnnualAverage <= "39.9" && $AnnualAverage >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					</td>
					<td valign="top">&nbsp;<?php echo $obtained_mark_query->row()->comment;?></td>
				  </tr>
				  <?php endforeach;?>
				</table>
				<table width="100%" height="254" border="1">
				  <tr>
					<td width="243" height="48"><strong>&nbsp;TOTAL SCORE OBTAINABLE :</strong></td>
					<td width="289">&nbsp;
					<?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 'session' => $session,  'student_id' => $student_id, 'exam_score !=' => 0))->num_rows() * 100;	
			
					?>					</td>
					
					
					
					
					<td width="342">&nbsp;<strong>OVERALL PERCENTAGE: </strong></td>
					<td width="75">&nbsp;
					
					<?php 
					
								$set = $session;
                                $this->db->select_sum('sum_third');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 3);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfThirdScore = $query->row()->sum_third;
								
									if($sumTotalOfThirdScore == ""){
										$sumTotalOfThirdScore = 0;
									}else{
										$sumTotalOfThirdScore = $sumTotalOfThirdScore;	
									}
								
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 
									'student_id' => $student_id, 'exam_score !=' => 0))->num_rows();		
					?>
					
					<?=round($sumTotalOfThirdScore /$getSubjectNumbered,2)?> %					</td>
					
					<td colspan="2"><strong>&nbsp;Personal Development (5mks) :</strong></td>
				  </tr>
				  
				  
				  <tr>
					<td rowspan="2"><strong>&nbsp;TOTAL SCORE OBTAINED :</strong></td>
					<td rowspan="2">&nbsp;
								<?php
								$set = $session;
                                $this->db->select_sum('sum_third');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 3);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfThirdScore = $query->row()->sum_third;
								
									if($sumTotalOfThirdScore == ""){
										echo $sumTotalOfThirdScore = 0;
									}else{
										echo $sumTotalOfThirdScore = $sumTotalOfThirdScore;	
									}
							?>					</td>
					<td rowspan="2">&nbsp;<strong>OVERALL GRADE:</strong> </td>
					<td rowspan="2">&nbsp;
								<?php $FindGrade = round($sumTotalOfThirdScore /$getSubjectNumbered,2);?>
								<?php if ($FindGrade <= '100' && $FindGrade >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '79.9' && $FindGrade >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '69.9' && $FindGrade >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "59.9" && $FindGrade >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "49.9" && $FindGrade >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "39.9" && $FindGrade >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					</td>
					<?php 
					$select = $this->db->get_where('stu_rem', array('student_id' => $student_id, 'session' => $session, 'term' => $term))->row();?>
					<td width="210">&nbsp;Mental Alertness </td>
					<td width="111">&nbsp;<?=$select->ma;?></td>
				  </tr>
				  <tr>
				    <td>&nbsp;Physical Development</td>
			        <td width="111">&nbsp;<?=$select->pd;?></td>
				  </tr>
				  
				  
				  <tr>
					<td rowspan="2"><strong>&nbsp;CLASS TEACHER'S REMARKS :</strong></td>
					<td colspan="3" rowspan="2">&nbsp;<?=$select->class_comment;?></td>
					<td width="210">&nbsp;Relating  with Teacher&rsquo;s</td>
					<td width="111">&nbsp;<?=$select->rt;?></td>
				  </tr>
				  <tr>
				    <td>&nbsp;Relating with mates</td>
			        <td width="111">&nbsp;<?=$select->rm;?></td>
				  </tr>
				  
				  
				  <tr>
					<td rowspan="2"><strong>&nbsp;HEAD TEACHER'S REMARKS :</strong></td>
					<td colspan="3" rowspan="2">&nbsp;<?=$select->head_comment;?></td>
					<td width="210">&nbsp;General Habit &amp; Attitude</td>
					<td width="111">&nbsp;<?=$select->gha;?></td>
				  </tr>
				  <tr>
				    <td>&nbsp;Punctuality</td>
			        <td width="111">&nbsp;<?=$select->p;?></td>
				  </tr> 
				  
				  <tr>
					<td colspan="4" rowspan="2">&nbsp;</td>
					<td width="210">&nbsp;Neatness</td>
					<td width="111">&nbsp;<?=$select->n;?></td>
				  </tr>
				  <tr>
				    <td>&nbsp;Leadership Traits</td>
			        <td width="111">&nbsp;<?=$select->lt;?></td>
				  </tr>
				</table>
		<?php endif;?>	
			<?php endif;?>	
						<div class="pagebreak"> </div>
						
						
						
						
						
						
						
						
						
						
						
						
						
		
		
		
		
		
		<?php if(get_settings('report_template') == 'tanzania'):?>
							
			
			<table width="100%" border="0">
			  <tr>
				<td colspan="3" valign="top"><div align="center"><h2 style="color:blue"><?=get_settings('system_name')?></h2></div></td>
			  </tr>
			  <tr>
				<td width="31%"><div align="left">Mobile: <?=get_settings('phone')?> </div></td>
				<td width="23%"><div align="right"><img src="<?=base_url()?>uploads/logo.png"  height="80" width="80"></div></td>
				<td width="46%"><div align="right"><?=get_settings('address')?></div></td>
			  </tr>
			  
			  <tr>
				<td colspan="3" valign="top"><div align="center">Email: <?=get_settings('system_email')?></div></td>
			  </tr>
			  <tr>
				<td colspan="3" valign="top"><div align="center" style="color:#00CC33"><strong>MOTTO: "EDUCATION IS OUR LIBRATION"</strong></div></td>
			  </tr>
			  <tr>
				<td colspan="3" valign="top"><div align="right"></div></td>
			  </tr>
			</table>
			<hr style="width:100%; display:block; background:#000; height:2px; margin-top:-1px">		
				<table width="100%">
				  <tr>
					<td width="38%" >
						<p class="pull-letf" style="font-size:12px"><strong style="color:red">PART A: PUPIL'S ACADEMIC PROGRESS</strong></p>
						<p class="pull-letf" style="margin-top:-10px; font-size:12px"><strong>PUPIL'S NAME:</strong> <strong style="color: #009999" class="text-uppercase"><?=$student_selected['name'];?></strong>&nbsp;<strong>CLASS</strong>:&nbsp;<strong class="text-uppercase" style="text-decoration:underline"><?=$class_name;?></strong></p>
						<p class="pull-letf" style="margin-top:-10px; font-size:12px"><strong>YEAR: </strong> <strong style="text-decoration:underline"><?=$session;?></strong>&nbsp;<strong>TERM: </strong>
						<strong style="text-decoration:underline"><?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></strong></p>
					</td>
					<td width="51%" valign="top">
						<h4 class="pull-center" style="font-style:inherit"><strong>PUPIL'S PROGRESSIVE SHEET</strong></h4>
					</td>
					<td width="11%" valign="top"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="80" width="80"></td>
				  </tr>		
				</table>
				<br>	
			
			<table width="100%" border="1" style="font-size:11px">
			  
			  <tr>
			  <td width="10%"><strong>TYPE OF EXAM</strong></td>
					
                    <?php 
						$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
						foreach ($select_subject as $key => $subject):
						
					?>
					<td width="6%">&nbsp;<strong><?=$subject['name'];?></strong></td>
					<?php endforeach;?>
					
					<td width="4%">&nbsp;<strong>TOTAL</strong></td>
					<td width="4%">&nbsp;<strong>AVER</strong>.</td>
					<td width="4%">&nbsp;<strong>GRAD</strong></td>
					<td width="4%">&nbsp;<strong>POSIT</strong></td>
					<td width="4%">&nbsp;<strong>OUT OF</strong></td>
					
					
		  	  </tr>
			</table>
					<?php 
					$year =  $session;
					$select_exam = $this->db->get_where('exam', array('term' => $term, 'session' => $year))->result_array();
					foreach($select_exam as $exam):?>
			<table width="100%" border="1" style="font-size:11px">
			  <tr>

					<td width="10%"><?=substr($exam['name'],0,20);?></td>
					
                    <?php 
						$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
						foreach ($select_subject as $key => $subject):
						
										$obtained_mark_query = $this->db->get_where('mark', 
											array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 
											'student_id' => $student_id, 'term' => $term, 'session' => $session, 'exam_id' => $exam['exam_id']));
                                        
										if($obtained_mark_query->num_rows() > 0){

                                            $class_score_one    = $obtained_mark_query->row()->class_score1;
                                            //$class_score_two    = $obtained_mark_query->row()->class_score2;
                                            //$class_score_three  = $obtained_mark_query->row()->class_score3;
                                            $exam_score         = $obtained_mark_query->row()->exam_score;
											$total_CA        	= $class_score_one;// + $class_score_two + $class_score_three;
                                            $total_score        = $class_score_one + $exam_score;// + $class_score_three + $exam_score;
											
											if($total_score == ""){
												$total_score = 0;
											}else{
												$total_score = $total_score;	
											}
                                        
										
											$update['sum_first'] = $total_score;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->where('exam_id', $exam['exam_id']);
											$this->db->where('term', $term);
											$this->db->where('session', $session);
											$this->db->update('mark', $update);
										}
						
					?>
					<td width="6%">&nbsp;<?php if($total_score == 0)echo ''; else echo $total_score;?></td>
					<?php endforeach;?>
					
                   
					<td width="4%">&nbsp;
					<?php
											$set = $session;
											$this->db->select_sum('sum_first');
											$this->db->from('mark');
											$this->db->where('student_id', $student_id);
											$this->db->where('term', $term);
											$this->db->where('exam_id', $exam['exam_id']);
											$this->db->where('exam_score !=', 0);
											$this->db->where('session', $set);
											
											$query = $this->db->get();	
											$sumTotalOfFirstScore = $query->row()->sum_first;
											
												if($sumTotalOfFirstScore == ""){
													$sumTotalOfFirstScore = 0;
												}else{
													$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
												}
											
												$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => $term, 
												'student_id' => $student_id, 'exam_score !=' => 0, 'exam_id' => $exam['exam_id']))->num_rows();
												
												
												
									$updatePercetangeFirst = round($sumTotalOfFirstScore/$getSubjectNumbered,2);
									if(is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = 0;
									}
									if(!is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = $updatePercetangeFirst;
									}
											
											$class_position_first['class_position_first'] = $updatePercetangeFirst;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->where('exam_id' , $exam['exam_id']);
											$this->db->update('mark', $class_position_first);
											
											echo $sumTotalOfFirstScore;
					?>
					
					</td>
					<td width="4%">&nbsp;<?=$updatePercetangeFirst?>.</td>
					<td width="4%">&nbsp;
											<?php if($updatePercetangeFirst >= 81 && $updatePercetangeFirst <= 100) : ?>
											<?php echo 'A'; ?>
											<?php endif;?>
											
											<?php if($updatePercetangeFirst >= 61 && $updatePercetangeFirst <= 80) : ?>
											<?php echo 'B'; ?>
											<?php endif;?>
											
											<?php if($updatePercetangeFirst >= 41 && $updatePercetangeFirst <= 60) : ?>
											<?php echo 'C'; ?>
											<?php endif;?>
											
											<?php if($updatePercetangeFirst >= 21 && $updatePercetangeFirst <= 40) : ?>
											<?php echo 'D'; ?>
											<?php endif;?>
											
											<?php if($updatePercetangeFirst != 0 && $updatePercetangeFirst <= 20) : ?>
											<span style="color:red"><?php echo 'E'; ?></span>
											<?php endif;?>
					</td>
					<td width="4%">&nbsp;
										<?php
										
										$subject_id = $subject['subject_id'];
										$exam_id = $exam['exam_id'];
 										$sql = "SELECT mark_id, sum_first, FIND_IN_SET( sum_first,(
												SELECT GROUP_CONCAT( sum_first  ORDER BY sum_first DESC ) 
												FROM mark WHERE class_id = $class_id AND subject_id = $subject_id AND exam_id = $exam_id))
												AS rank 
												FROM mark
												WHERE class_id = $class_id AND subject_id = $subject_id AND sum_first = $total_score AND sum_first != 0 AND exam_id = $exam_id"; 
        
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
					<td width="4%">&nbsp;<?=$number_class;?></td>
		  	  </tr>
			</table>
			<?php endforeach;?>
					<?php 
					$year =  $session;
					$select_exam = $this->db->get_where('exam', array('term' => $term, 'session' => $year, 'terminal' => 1))->result_array();
					foreach($select_exam as $exam2):?>
					<br>
					<table width="100%" border="0">
					  <tr>
						<td>Position in class in Terminal Exam : 
						
									<strong style="color:red;text-decoration:underline">									
										<?php
										$subject_id = $subject['subject_id'];
										$exam_id = $exam2['exam_id'];
 										$sql = "SELECT mark_id, sum_first, FIND_IN_SET( sum_first,(
												SELECT GROUP_CONCAT( sum_first  ORDER BY sum_first DESC ) 
												FROM mark WHERE class_id = $class_id AND subject_id = $subject_id AND exam_id = $exam_id))
												AS rank 
												FROM mark
												WHERE class_id = $class_id AND subject_id = $subject_id AND sum_first = $total_score AND sum_first != 0 AND exam_id = $exam_id"; 
        
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
										
										
										?></strong> out of: <strong style="color:red;text-decoration:underline"><?=$number_class;?></strong> 		in grade: 
											<strong style="color:red;text-decoration:underline">
											<?php if($updatePercetangeFirst >= 81 && $updatePercetangeFirst <= 100) : ?>
											<?php echo 'A'; ?>
											<?php endif;?>
											
											<?php if($updatePercetangeFirst >= 61 && $updatePercetangeFirst <= 80) : ?>
											<?php echo 'B'; ?>
											<?php endif;?>
											
											<?php if($updatePercetangeFirst >= 41 && $updatePercetangeFirst <= 60) : ?>
											<?php echo 'C'; ?>
											<?php endif;?>
											
											<?php if($updatePercetangeFirst >= 21 && $updatePercetangeFirst <= 40) : ?>
											<?php echo 'D'; ?>
											<?php endif;?>
											
											<?php if($updatePercetangeFirst != 0 && $updatePercetangeFirst <= 20) : ?>
											<span style="color:red"><?php echo 'E'; ?></span>
											<?php endif;?>
											</strong>
										
						</td>
					  </tr>
					</table>
			<?php endforeach;?>
			<br>
				<?php 
					  $select = $this->db->get_where('tanzania_stu_rem', array('student_id' => $student_id, 'session' => $session, 'term' => $term))->row();
				 	  
				?>
			<p class="pull-left" style="font-size:12px"><strong style="color:red">PART B: PUPIL'S DESCIPLINE AND ATTENDANCE</strong></p>
				<table width="100%" border="1">
				  <tr>
					<td>&nbsp;</td>
					<td><strong>PERCENTAGES</strong></td>
					<td><strong>AVERAGE</strong></td>
					<td><strong>DESCRIPTION</strong></td>
				  </tr>
				  <tr>
					<td><strong>PUPILS'S DESCIPLINE </strong></td>
					<td>&nbsp;<?=$select->percentage;?></td>
					<td>&nbsp;<?=$select->average;?></td>
					<td>&nbsp;<?=$select->description;?></td>
				  </tr>
				  <tr>
					<td><strong>PUPIL'S ATTENDANCE </strong></td>
					<td>&nbsp;<?=$select->atten_percentage;?></td>
					<td>&nbsp;<?=$select->atten_average;?></td>
					<td>&nbsp;<?=$select->atten_description;?></td>
				  </tr>
				</table>
			<br>
			<?php
			$teacher_id = $this->db->get_where('class', array('class_id' => $class_id))->row()->teacher_id;
			$teacher_details = $this->db->get_where('teacher', array('teacher_id' => $teacher_id))->row();
										
											
			?>
			<p class="pull-left" style="font-size:12px"><strong style="color:red">PART C: REMARKS</strong></p>
				<table width="100%" border="1">
				  <tr>
					<td>&nbsp;<strong>CLASS TEACHER'S NAME</strong> <strong class="text-uppercase" style="color:#00CCCC"><?=$teacher_details->name?></strong> <strong>PHONE NUMBER</strong> <strong style="color: #00CCCC"><?=$teacher_details->phone?></strong> SIGNATURE:  <img src="<?php echo base_url();?>uploads/teacher_image/teacher_<?=$teacher_details->teacher_id?>.jpg" alt="sign" width="150px" height="40px"></td>
				  </tr>
				  <tr>
					<td>&nbsp;<strong>ACADEMIC MASTER/MISTRESS'S REMARKS:</strong> <?=$select->description;?></td>
				  </tr>
				  <tr>
					<td>&nbsp;<strong>HEADMASTER'S SIGNATURE:</strong> <img style="padding-top:10px;padding-bottom:10px" src="<?php echo base_url();?>uploads/signature.png" width="150px" height="40px"></td>
				  </tr>
				</table>
			<div class="pagebreak"> </div>
		<?php endif;?>	
		
		
		
		
		
		
		
		
		
		
			<?php if(get_settings('report_template') == 'gate'):?>
				<?php if($term == 1) : ?>

				<table width="100%">
				  <tr>
					<td class="pull-left"><img src="<?php echo base_url()?>uploads/logo.png"  height="150" width="150"></td>
					<td>
						<h2 align="center"><?php echo get_settings('system_name')?></h2>
						<p align="center">MOTTO: HOME WHERE KNOWLEGE SPEAKS<br><strong>Address:</strong> <?php echo get_settings('address')?> <br/>
						<!--<?php echo get_settings('system_email')?> : <?php echo get_settings('phone')?>-->
						</p>	
					</td>
					<td class="pull-right"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="150" width="150"></td>
				  </tr>		
				</table>
				<table width="100%" border="0">
				  <tr>
					<td align="center"><strong style="font-size:36px">EXAMINATION REPORT SHEET</strong></td>
				  </tr>
				</table>
								
				<table width="100%" height="100" border="1">
				  <tr>
					<td width="234"><strong>&nbsp;NAME:</strong></td>
					<td width="361" class="text-uppercase">&nbsp;<?=$student_selected['name'];?></td>
					<td width="217"><strong>&nbsp;CLASS:</strong></td>
					<td width="182">&nbsp;<?=$class_name;?></td>
					<td width="230"><strong>&nbsp;TERM:</strong></td>
					<td width="206">&nbsp;<?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></td>
				  </tr>
				  <tr>
					<td><strong>&nbsp;ADMISSION NO:</strong></td>
					<td>&nbsp;<?=$student_selected['roll'];?></td>
					<td>&nbsp;<strong>NO. IN CLASS:</strong></td>
					<td>&nbsp;<?=$number_class;?></td>
					<td>&nbsp;<strong>SESSION:</strong></td>
					<td>&nbsp;<?=$session?></td>
				  </tr>
				  <tr>
					<td><strong>&nbsp;DAY(S) SCHOOL OPEN</strong></td>
					<td>&nbsp;
				    <?=$this->db->get_where('attendance', array('session' => $session, 
					'term' => $term))->num_rows(); ?></td>
					<td width="217"><strong>&nbsp;DAY(S) PRESENT:</strong></td>
					<td>&nbsp;<?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 1))->num_rows(); 
						?></td>
					<td><strong>&nbsp;DAY(S) ABSENT:</strong></td>
					<td><strong>&nbsp;</strong><?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 2))->num_rows(); 
						?></td>
			      </tr>
				</table>
				<table width="100%"  border="1">
				  <tr>
					<td valign="top"><strong>&nbsp;Subjects</strong></td>
					
					<td valign="top"><strong>&nbsp;CA1 (20%)</strong> </td>
					<td valign="top"><strong>&nbsp;CA2 (20%)</strong> </td>
					<td valign="top"><strong>&nbsp;CA2 (20%)</strong> </td>
					<td valign="top"><strong>&nbsp;Exam (40%)</strong> </td>
					<td valign="top"><strong>&nbsp;Total (100%)</strong> </td>
					<td valign="top"><strong>&nbsp;Grade</strong> </td>
					<td valign="top"><strong>&nbsp;Avg. SCORE </strong></td>
					<td valign="top">&nbsp;<strong>Remarks</strong> </td>
				  </tr>
				  
                    <?php 
						$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
						foreach ($select_subject as $key => $subject):
					?>
					<tr>
					<td valign="top">&nbsp;<?php echo $subject['name'];?></td>
					
                                        <?php 
										$obtained_mark_query = $this->db->get_where('mark', 
											array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 
											'student_id' => $student_id, 'term' => 1));
                                        
										

                                            $class_score_one    = $obtained_mark_query->row()->class_score1;
                                            $class_score_two    = $obtained_mark_query->row()->class_score2;
                                            $class_score_three  = $obtained_mark_query->row()->class_score3;
                                            $exam_score         = $obtained_mark_query->row()->exam_score;
											$total_CA        	= $class_score_one; + $class_score_two + $class_score_three;
                                            $total_score        = $class_score_one + $class_score_two + $class_score_three + $exam_score;
											
											if($total_score == ""){
												$total_score = 0;
											}else{
												$total_score = $total_score;	
											}
                                        
										
											$update['sum_first'] = $total_score;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $update);
										
                                        ?>
					
					<td valign="top">&nbsp;<?php if($class_score_one == 0)echo '';else echo $class_score_one;?></td>
					<td valign="top">&nbsp;<?php if($class_score_two == 0)echo '';else echo $class_score_two;?></td>
					<td valign="top">&nbsp;<?php if($class_score_three == 0)echo '';else echo $class_score_three;?></td>
					<td valign="top">&nbsp;<?php if($exam_score == 0)echo ''; else echo $exam_score;?></td>
					<td valign="top">&nbsp;<?php if($total_score == 0)echo ''; else echo $total_score;?></td>
					<td valign="top">&nbsp;
								<?php if ($total_score <= '100' && $total_score >= '70'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($total_score <= '59' && $total_score >= '50'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>
								<?php echo 'P';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '0'):?>
								<?php echo 'E';?>
								<?php endif;?>
					</td>
					
					
					<td valign="top">&nbsp;<?=$total_score/4?></td>


					<td valign="top">&nbsp;<?php echo $obtained_mark_query->row()->comment;?></td>
				  </tr>
				  <?php endforeach;?>
				</table>
				
					<?php 
					
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
									if($sumTotalOfFirstScore == ""){
										$sumTotalOfFirstScore = 0;
									}else{
										$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
								
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'student_id' => $student_id, 'exam_score !=' => 0))->num_rows();		
					?>
				
				
				<table width="100%" border="0">
				  <tr>
					<td style="background:white; color:black"><span class="pull-left">GRADE DETAILS:</span><span class="pull-right"><strong>Number of Subject Offered: 
						<?php echo $getSubjectNumbered?>
					</strong> </span><br>
					A = 70 - 100, B = 60 - 69, C = 50 - 59, D = 40 - 49, E = 0 - 39</td>
				  </tr>
				</table>
				
				
				<table width="100%" border="1">
				  <tr>
					<td width="349" height="59"><strong>&nbsp;TOTAL MARK OBTAINABLE:</strong></td>
					<td width="132" class="text-uppercase">&nbsp;<?php echo $getSubjectNumbered*100?></td>
					<td width="249"><strong>&nbsp;TOTAL MARK:</strong></td>
					<td width="97">&nbsp;
								<?php
								
									if($sumTotalOfFirstScore == ""){
										echo $sumTotalOfFirstScore = 0;
									}else{
										echo $sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
							?>					</td>
					<td width="223">&nbsp;<strong>AVERAGE MARK:</strong></td>
					<td width="81">&nbsp;

					
					<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?> %					</td>
				    <td width="193">&nbsp;<strong>FINAL GRADE:</strong> </td>
				    <td width="94">&nbsp;
								<?php $FindGrade = round($sumTotalOfFirstScore /$getSubjectNumbered,2);?>
								<?php if ($FindGrade <= '100' && $FindGrade >= '70'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '69.9' && $FindGrade >= '60'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '59.9' && $FindGrade >= '50'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "49.9" && $FindGrade >= '40'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "39.9" && $FindGrade >= '0'):?>
								<?php echo 'E';?>
								<?php endif;?>					</td>
				  </tr>
				  
				</table>
				
					<?php $select = $this->db->get_where('udemy_stu_rem', array('student_id' => $student_id, 'session' => $session, 'term' => $term))->row();?>
				<table width="100%" border="1">
                  <tr>
                    <td colspan="2"><div align="center"><strong>AFFECTIVE ASSESSMENT </strong></div></td>
                    <td colspan="2"><div align="center"><strong>PSYCHOMOTOR ASSESSMENT</strong></div></td>
                  </tr>
                  <tr>
                    <td width="19%"><span role="presentation" dir="ltr"><strong>AFFECTIVE TRAITS</strong></span></td>
                    <td width="28%"><div align="center"><strong>RATING</strong></div></td>
                    <td width="23%"><span role="presentation" dir="ltr"><strong>PSYCHOMOTOR</strong></span></td>
                    <td width="30%"><div align="center"><strong>RATING</strong></div></td>
                  </tr>
                  <tr>
                    <td><span role="presentation" dir="ltr">Punctuality</span></td>
                    <td><div align="center"><?=$select->at;?></div></td>
                    <td><span role="presentation" dir="ltr">Handwriting</span></td>
                    <td><div align="center"><?=$select->cl;?></div></td>
                  </tr>
                  <tr>
                    <td><span role="presentation" dir="ltr">Attendance</span></td>
                    <td><div align="center"><?=$select->ho;?></div></td>
                    <td><span role="presentation" dir="ltr">Games</span></td>
                    <td><div align="center"><?=$select->dr;?></div></td>
                  </tr>
                  <tr>
                    <td><span role="presentation" dir="ltr">Reliability</span></td>
                    <td><div align="center"><?=$select->ne;?></div></td>
                    <td><span role="presentation" dir="ltr">Sports</span></td>
                    <td><div align="center"><?=$select->ha;?></div></td>
                  </tr>
                  <tr>
                    <td><span role="presentation" dir="ltr">Neatness</span></td>
                    <td><div align="center"><?=$select->po;?></div></td>
                    <td><span role="presentation" dir="ltr">Drawing &amp; Painting</span></td>
                    <td><div align="center"><?=$select->hob;?></div></td>
                  </tr>
                  <tr>
                    <td><span role="presentation" dir="ltr">Politeness</span></td>
                    <td><div align="center"><?=$select->pu;?></div></td>
                    <td><span role="presentation" dir="ltr">Crafts</span></td>
                    <td><div align="center"><?=$select->sp;?></div></td>
                  </tr>
                  <tr>
                    <td>Relationship with Students </td>
                    <td><div align="center"><?=$select->re;?></div></td>
                    <td><span role="presentation" dir="ltr">Musical Skills</span></td>
                    <td><div align="center"><?=$select->sp;?></div></td>
                  </tr>
                </table>
				<br>
				
				<table width="100%" border="1">
                  <tr>
                    <td width="17%"><span role="presentation" dir="ltr">FORM TEACHER&rsquo;S REMARKS:</span></td>
                    <td colspan="3"><?=$select->fmc;?></td>
                  </tr>
                  <tr>
                    <td><span role="presentation" dir="ltr">FORM TEACHER' NAME: </span></td>
                    <td><?=$select->fma;?></td>
                    <td>Signature</td>
                    <td><em><strong><?=$select->fma;?></strong><em></td>
                  </tr>
                  <tr>
                    <td><span role="presentation" dir="ltr">HEAD OF SCHOOL&rsquo;S REMARKS:</span></td>
                    <td colspan="3"><?=$select->pc;?></td>
                  </tr>
                  <tr>
                    <td><span role="presentation" dir="ltr">HEAD OF SCHOOL&rsquo;S NAME:</span></td>
                    <td width="42%"><?=$this->db->get_where('admin', array('admin_id' => 1))->row()->name;?></td>
                    <td width="10%">Signature</td>
                    <td width="31%"><img src="<?php echo base_url();?>uploads/signature.png" width="150px" height="50px"></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="left"><strong>Next term Begins:</strong> <?=get_settings('next_term_begin')?></td>
                  </tr>
                </table>
				<?php endif;?>
				<div class="pagebreak"> </div>
			
			
			
				<?php if($term == 2) : ?>
				<table width="100%">
				  <tr>
					<td class="pull-left"><img src="<?php echo base_url()?>uploads/logo.png"  height="150" width="150"></td>
					<td>
						<h2 align="center"><?php echo get_settings('system_name')?></h2>
						<p align="center">MOTTO: HOME WHERE KNOWLEGE SPEAKS<br><strong>Address:</strong> <?php echo get_settings('address')?> <br/>
						<!--<i class="fa fa-envelope"></i> <?php echo get_settings('system_email')?> : <i class="fa fa-phone"></i> <?php echo get_settings('phone')?>--></p>	
					</td>
					<td class="pull-right"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="150" width="150"></td>
				  </tr>		
				</table>
				<table width="100%" border="0">
				  <tr>
					<td align="center"><strong>REPORT SHEET FOR <?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?> <?=$session?> ACADEMIC SESSION</strong></td>
				  </tr>
				</table>
								
				<table width="100%" height="100" border="1">
				  <tr>
					<td width="322"><strong>&nbsp;PUPIL'S NAME:</strong></td>
					<td width="267" class="text-uppercase">&nbsp;<?=$student_selected['name'];?></td>
					<td width="265"><strong>&nbsp;CLASS:</strong></td>
					<td width="69">&nbsp;<?=$class_name;?></td>
					<td width="233"><strong>&nbsp;TERM:</strong></td>
					<td width="92">&nbsp;<?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></td>
				  </tr>
				  <tr>
					<td><strong>&nbsp;ADMISSION NO:</strong></td>
					<td>&nbsp;<?=$student_selected['roll'];?></td>
					<td>&nbsp;<strong>SEX:</strong></td>
					<td>&nbsp;<?=ucwords($student_selected['sex']);?></td>
					<td>&nbsp;<strong>ACADEMIC YEAR:</strong></td>
					<td>&nbsp;<?=$session?></td>
				  </tr>
				  <tr>
					<td><strong>&nbsp;DAY(S) SCHOOL OPEN</strong></td>
					<td>&nbsp;
				    <?=$this->db->get_where('attendance', array('session' => $session, 
					'term' => $term))->num_rows(); ?></td>
					<td width="265"><strong>&nbsp;DAY(S) PRESENT:</strong></td>
					<td>&nbsp;<?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 1))->num_rows(); 
						?></td>
					<td><strong>&nbsp;DAY(S) ABSENT:</strong></td>
					<td><strong>&nbsp;</strong><?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 2))->num_rows(); 
						?></td>
			      </tr>
				</table>
				<table width="100%"  border="1">
				  <tr>
					<td valign="top"><strong>&nbsp;Subjects</strong></td>
					
					<td valign="top"><strong>&nbsp;20% CA1</strong> </td>
					<td valign="top"><strong>&nbsp;20% CA2</strong> </td>
					<td valign="top"><strong>&nbsp;60% Exam</strong> </td>
					<td valign="top"><strong>&nbsp;100% Total</strong> </td>
					<td valign="top"><strong>&nbsp;Grade</strong> </td>
					<td valign="top"><strong>&nbsp;POS</strong> </td>
					<td valign="top"><strong>&nbsp;Out Of</strong> </td>
					<td valign="top"><strong>&nbsp;Min Score</strong></td>
					<td valign="top"><strong>&nbsp;Max Score</strong> </td>
					<td valign="top"><strong>&nbsp;Class AVG</strong></td>
					<td valign="top">&nbsp;<strong>Remarks</strong> </td>
				  </tr>
				  
                    <?php 
						$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
						foreach ($select_subject as $key => $subject):
					?>
					<tr>
					<td valign="top">&nbsp;<?php echo $subject['name'];?></td>
					
                                        <?php 
										$obtained_mark_query = $this->db->get_where('mark', 
											array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 
											'student_id' => $student_id, 'term' => 1));
                                        
										

                                            $class_score_one    = $obtained_mark_query->row()->class_score1;
                                            $class_score_two    = $obtained_mark_query->row()->class_score2;
                                            //$class_score_three  = $obtained_mark_query->row()->class_score3;
                                            $exam_score         = $obtained_mark_query->row()->exam_score;
											$total_CA        	= $class_score_one; + $class_score_two;//+ $class_score_three;
                                            $total_score        = $class_score_one + $class_score_two + $exam_score;// + $class_score_three + $exam_score;
											
											if($total_score == ""){
												$total_score = 0;
											}else{
												$total_score = $total_score;	
											}
                                        
										
											$update['sum_first'] = $total_score;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $update);
										
                                        ?>
					
					<td valign="top">&nbsp;<?php if($class_score_one == 0)echo '';else echo $class_score_one;?></td>
					<td valign="top">&nbsp;<?php if($class_score_two == 0)echo '';else echo $class_score_two;?></td>
					<td valign="top">&nbsp;<?php if($exam_score == 0)echo ''; else echo $exam_score;?></td>
					<td valign="top">&nbsp;<?php if($total_score == 0)echo ''; else echo $total_score;?></td>
					<td valign="top">&nbsp;
								<?php if ($total_score <= '100' && $total_score >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($total_score <= '79' && $total_score >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($total_score <= "59" && $total_score >= '50'):?>
								<?php echo 'P';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					</td>
					<td valign="top">&nbsp;
					
										<?php
										
										$subject_id = $subject['subject_id'];
 										$sql = "SELECT mark_id, sum_first, FIND_IN_SET( sum_first,(
												SELECT GROUP_CONCAT( sum_first  ORDER BY sum_first DESC ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND sum_first = $total_score AND sum_first != 0"; 
        
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
					<td valign="top">&nbsp;<?=$number_class?></td>
					
					<td valign="top">&nbsp;
                        <?php echo $lowest_mark = $this->crud_model->get_lowest_marks_first( $exam_id , $class_id , $subject['subject_id'], 1 );?>
					</td>
					<td valign="top">&nbsp;
						<?php echo $highest_mark = $this->crud_model->get_highest_marks_first( $exam_id , $class_id , $subject['subject_id'], 1 ); ?>	
					</td>

					
					<td valign="top">&nbsp;
					
                                <?php 
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								echo $sumTotalOfFirstScore = $query->row()->sum_first;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'student_id' => $student_id, 'exam_score !=' => 0))->num_rows();
									
									
									$updatePercetangeFirst = round($sumTotalOfFirstScore/$getSubjectNumbered);
									if(is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = 0;
									}
									if(!is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = $updatePercetangeFirst;
									}
											
											$class_position_first['class_position_first'] = $updatePercetangeFirst;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $class_position_first);
									
									
                                ?>
					
					
					</td>


					<td valign="top">&nbsp;<?php echo $obtained_mark_query->row()->comment;?></td>
				  </tr>
				  <?php endforeach;?>
				</table>
				
				<table width="100%" border="0">
				  <tr>
					<td style="background:white; color:black"><span class="pull-left">GRADE DETAILS:</span><span class="pull-right"><strong>Number of Subject Offered: 
						<?php echo $getSubjectNumbered?>
					</strong> </span><br>
					80-100 = A(Excellent) 70-79 = B(V.Good) 60-69 = C(Good) 50-59 = D(Pass) 40-49 = E(Fair) 0-39 = F(Fail)</td>
				  </tr>
				</table>
				
				
				<table width="100%" border="1">
				  <tr>
					<td width="186"><strong>&nbsp;Class Position:</strong></td>
					<td width="89" class="text-uppercase">&nbsp;
					
					
										<?php
										
										
 										$sql = "SELECT mark_id, class_position_first, FIND_IN_SET( class_position_first,(
												SELECT GROUP_CONCAT( class_position_first  ORDER BY class_position_first desc ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND class_position_first = $updatePercetangeFirst AND class_position_first != 0"; 
        
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
					<td width="155"><strong>&nbsp;Total Score:</strong></td>
					<td width="119">&nbsp;
								<?php
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
									if($sumTotalOfFirstScore == ""){
										echo $sumTotalOfFirstScore = 0;
									}else{
										echo $sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
							?>					</td>
					<td colspan="2"><strong>&nbsp;<strong>Final Average</strong>:</strong></td>
					<td width="171">&nbsp;
					<?php 
					
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
									if($sumTotalOfFirstScore == ""){
										$sumTotalOfFirstScore = 0;
									}else{
										$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
								
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'student_id' => $student_id, 'exam_score !=' => 0))->num_rows();		
					?>
					
					<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?> %					</td>
				    <td width="">&nbsp;<strong>Final Grade</strong> </td>
				    <td width="75">&nbsp;
								<?php $FindGrade = round($sumTotalOfFirstScore /$getSubjectNumbered,2);?>
								<?php if ($FindGrade <= '100' && $FindGrade >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '79.9' && $FindGrade >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '69.9' && $FindGrade >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "59.9" && $FindGrade >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "49.9" && $FindGrade >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "39.9" && $FindGrade >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					
					</td>
				  </tr>
				  
				  <!--<tr>
					<td><strong>&nbsp;Total Score:</strong></td>
					<td>&nbsp;<?=$student_selected['roll'];?></td>
					<td>&nbsp;<strong>SEX:</strong></td>
					<td>&nbsp;<?=ucwords($student_selected['sex']);?></td>
					<td colspan="2">&nbsp;<strong>ACADEMIC YEAR:</strong></td>
					<td colspan="2">&nbsp;<?=$session?></td>
				  </tr>-->
				</table>
				
					<?php 
					$select = $this->db->get_where('udemy_stu_rem', array('student_id' => $student_id, 'session' => $session, 'term' => $term))->row();
					?>
				<table width="100%" border="1">
                  <tr>
                    <td colspan="2"><div align="center"><strong>AFFECTIVE ASSESSMENT </strong></div></td>
                    <td colspan="2"><div align="center"><strong>PSYCHOMOTOR ASSESSMENT</strong></div></td>
                  </tr>
                  <tr>
                    <td width="19%"><strong>Items' Name </strong></td>
                    <td width="28%"><div align="center"><strong>Scores</strong></div></td>
                    <td width="23%"><strong>Items' Name </strong></td>
                    <td width="30%"><div align="center"><strong>Scores</strong></div></td>
                  </tr>
                  <tr>
                    <td>Attentiveness</td>
                    <td><div align="center"><?=$select->at;?></div></td>
                    <td>Club / Society </td>
                    <td><div align="center"><?=$select->cl;?></div></td>
                  </tr>
                  <tr>
                    <td>Honesty</td>
                    <td><div align="center"><?=$select->ho;?></div></td>
                    <td>Drawing and Painting </td>
                    <td><div align="center"><?=$select->dr;?></div></td>
                  </tr>
                  <tr>
                    <td>Neatness</td>
                    <td><div align="center"><?=$select->ne;?></div></td>
                    <td>Hand Writting </td>
                    <td><div align="center"><?=$select->ha;?></div></td>
                  </tr>
                  <tr>
                    <td>Politeness</td>
                    <td><div align="center"><?=$select->po;?></div></td>
                    <td>Hobies</td>
                    <td><div align="center"><?=$select->hob;?></div></td>
                  </tr>
                  <tr>
                    <td>Punchuality</td>
                    <td><div align="center"><?=$select->pu;?></div></td>
                    <td>Speech Fluentcy </td>
                    <td><div align="center"><?=$select->sp;?></div></td>
                  </tr>
                  <tr>
                    <td>Relationship with Others </td>
                    <td><div align="center"><?=$select->re;?></div></td>
                    <td>Sport and Game </td>
                    <td><div align="center"><?=$select->sp;?></div></td>
                  </tr>
                </table>
				<br>
				<table width="100%" border="0">
				  <tr>
					<td style="background:white; color:black" align="center">5 = A(Excellent) 4 = B(V.Good) 3 = C(Good) 2 = D(Pass) 1 = E(Fair) 0 = F(Fail)</td>
				  </tr>
				</table>
				<table width="100%" border="0">
                  <tr>
                    <td width="15%">Form Mater's Comment</td>
                    <td colspan="3"><?=$select->fmc;?></td>
                  </tr>
                  <tr>
                    <td>Form Mater's Name</td>
                    <td><?=$select->fma;?></td>
                    <td>Signature</td>
                    <td><em><strong><?=$select->fma;?></strong><em></td>
                  </tr>
                  <tr>
                    <td>Principal's Comment</td>
                    <td colspan="3"><?=$select->pc;?></td>
                  </tr>
                  <tr>
                    <td>Principal's Name</td>
                    <td width="47%"><?=$this->db->get_where('admin', array('admin_id' => 1))->row()->name;?></td>
                    <td width="7%">Signature</td>
                    <td width="31%"><img src="<?php echo base_url();?>uploads/signature.png" width="150px" height="50px"></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="right"><strong>Next term Begins:</strong> <?=get_settings('next_term_begin')?></td>
                  </tr>
                </table>

				<?php endif;?>
				<div class="pagebreak"> </div>
				
				
				
				
				
				
			<?php if($term == 3) : ?>
				<table width="100%">
				  <tr>
					<td class="pull-left"><img src="<?php echo base_url()?>uploads/logo.png"  height="150" width="150"></td>
					<td>
						<h2 align="center"><?php echo get_settings('system_name')?></h2>
						<p align="center">MOTTO: HOME WHERE KNOWLEGE SPEAKS<br><strong>Address:</strong> <?php echo get_settings('address')?> <br/>
						<!--<i class="fa fa-envelope"></i> <?php echo get_settings('system_email')?> : <i class="fa fa-phone"></i> <?php echo get_settings('phone')?>--></p>	
					</td>
					<td class="pull-right"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="150" width="150"></td>
				  </tr>		
				</table>
				<table width="100%" border="0">
				  <tr>
					<td align="center"><strong>REPORT SHEET FOR <?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?> <?=$session?> ACADEMIC SESSION</strong></td>
				  </tr>
				</table>
								
				<table width="100%" height="100" border="1">
				  <tr>
					<td width="322"><strong>&nbsp;PUPIL'S NAME:</strong></td>
					<td width="267" class="text-uppercase">&nbsp;<?=$student_selected['name'];?></td>
					<td width="265"><strong>&nbsp;CLASS:</strong></td>
					<td width="69">&nbsp;<?=$class_name;?></td>
					<td width="233"><strong>&nbsp;TERM:</strong></td>
					<td width="92">&nbsp;<?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></td>
				  </tr>
				  <tr>
					<td><strong>&nbsp;ADMISSION NO:</strong></td>
					<td>&nbsp;<?=$student_selected['roll'];?></td>
					<td>&nbsp;<strong>SEX:</strong></td>
					<td>&nbsp;<?=ucwords($student_selected['sex']);?></td>
					<td>&nbsp;<strong>ACADEMIC YEAR:</strong></td>
					<td>&nbsp;<?=$session?></td>
				  </tr>
				  <tr>
					<td><strong>&nbsp;DAY(S) SCHOOL OPEN</strong></td>
					<td>&nbsp;
				    <?=$this->db->get_where('attendance', array('session' => $session, 
					'term' => $term))->num_rows(); ?></td>
					<td width="265"><strong>&nbsp;DAY(S) PRESENT:</strong></td>
					<td>&nbsp;<?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 1))->num_rows(); 
						?></td>
					<td><strong>&nbsp;DAY(S) ABSENT:</strong></td>
					<td><strong>&nbsp;</strong><?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 2))->num_rows(); 
						?></td>
			      </tr>
				</table>
				<table width="100%"  border="1">
				  <tr>
					<td valign="top"><strong>&nbsp;Subjects</strong></td>
					
					<td valign="top"><strong>&nbsp;20% CA1</strong> </td>
					<td valign="top"><strong>&nbsp;20% CA2</strong> </td>
					<td valign="top"><strong>&nbsp;60% Exam</strong> </td>
					<td valign="top"><strong>&nbsp;100% Total</strong> </td>
					<td valign="top"><strong>&nbsp;Grade</strong> </td>
					<td valign="top"><strong>&nbsp;POS</strong> </td>
					<td valign="top"><strong>&nbsp;Out Of</strong> </td>
					<td valign="top"><strong>&nbsp;Min Score</strong></td>
					<td valign="top"><strong>&nbsp;Max Score</strong> </td>
					<td valign="top"><strong>&nbsp;Class AVG</strong></td>
					<td valign="top">&nbsp;<strong>Remarks</strong> </td>
				  </tr>
				  
                    <?php 
						$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
						foreach ($select_subject as $key => $subject):
					?>
					<tr>
					<td valign="top">&nbsp;<?php echo $subject['name'];?></td>
					
                                        <?php 
										$obtained_mark_query = $this->db->get_where('mark', 
											array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 
											'student_id' => $student_id, 'term' => 1));
                                        
										

                                            $class_score_one    = $obtained_mark_query->row()->class_score1;
                                            $class_score_two    = $obtained_mark_query->row()->class_score2;
                                            //$class_score_three  = $obtained_mark_query->row()->class_score3;
                                            $exam_score         = $obtained_mark_query->row()->exam_score;
											$total_CA        	= $class_score_one; + $class_score_two;//+ $class_score_three;
                                            $total_score        = $class_score_one + $class_score_two + $exam_score;// + $class_score_three + $exam_score;
											
											if($total_score == ""){
												$total_score = 0;
											}else{
												$total_score = $total_score;	
											}
                                        
										
											$update['sum_first'] = $total_score;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $update);
										
                                        ?>
					
					<td valign="top">&nbsp;<?php if($class_score_one == 0)echo '';else echo $class_score_one;?></td>
					<td valign="top">&nbsp;<?php if($class_score_two == 0)echo '';else echo $class_score_two;?></td>
					<td valign="top">&nbsp;<?php if($exam_score == 0)echo ''; else echo $exam_score;?></td>
					<td valign="top">&nbsp;<?php if($total_score == 0)echo ''; else echo $total_score;?></td>
					<td valign="top">&nbsp;
								<?php if ($total_score <= '100' && $total_score >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($total_score <= '79' && $total_score >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($total_score <= "59" && $total_score >= '50'):?>
								<?php echo 'P';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					</td>
					<td valign="top">&nbsp;
					
										<?php
										
										$subject_id = $subject['subject_id'];
 										$sql = "SELECT mark_id, sum_first, FIND_IN_SET( sum_first,(
												SELECT GROUP_CONCAT( sum_first  ORDER BY sum_first DESC ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND sum_first = $total_score AND sum_first != 0"; 
        
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
					<td valign="top">&nbsp;<?=$number_class?></td>
					
					<td valign="top">&nbsp;
                        <?php echo $lowest_mark = $this->crud_model->get_lowest_marks_first( $exam_id , $class_id , $subject['subject_id'], 1 );?>
					</td>
					<td valign="top">&nbsp;
						<?php echo $highest_mark = $this->crud_model->get_highest_marks_first( $exam_id , $class_id , $subject['subject_id'], 1 ); ?>	
					</td>

					
					<td valign="top">&nbsp;
					
                                <?php 
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								echo $sumTotalOfFirstScore = $query->row()->sum_first;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'student_id' => $student_id, 'exam_score !=' => 0))->num_rows();
									
									
									$updatePercetangeFirst = round($sumTotalOfFirstScore/$getSubjectNumbered);
									if(is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = 0;
									}
									if(!is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = $updatePercetangeFirst;
									}
											
											$class_position_first['class_position_first'] = $updatePercetangeFirst;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $class_position_first);
									
									
                                ?>
					
					
					</td>


					<td valign="top">&nbsp;<?php echo $obtained_mark_query->row()->comment;?></td>
				  </tr>
				  <?php endforeach;?>
				</table>
				
				<table width="100%" border="0">
				  <tr>
					<td style="background:white; color:black"><span class="pull-left">GRADE DETAILS:</span><span class="pull-right"><strong>Number of Subject Offered: 
						<?php echo $getSubjectNumbered?>
					</strong> </span><br>
					80-100 = A(Excellent) 70-79 = B(V.Good) 60-69 = C(Good) 50-59 = D(Pass) 40-49 = E(Fair) 0-39 = F(Fail)</td>
				  </tr>
				</table>
				
				
				<table width="100%" border="1">
				  <tr>
					<td width="186"><strong>&nbsp;Class Position:</strong></td>
					<td width="89" class="text-uppercase">&nbsp;
					
					
										<?php
										
										
 										$sql = "SELECT mark_id, class_position_first, FIND_IN_SET( class_position_first,(
												SELECT GROUP_CONCAT( class_position_first  ORDER BY class_position_first desc ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND class_position_first = $updatePercetangeFirst AND class_position_first != 0"; 
        
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
					<td width="155"><strong>&nbsp;Total Score:</strong></td>
					<td width="119">&nbsp;
								<?php
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
									if($sumTotalOfFirstScore == ""){
										echo $sumTotalOfFirstScore = 0;
									}else{
										echo $sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
							?>					</td>
					<td colspan="2"><strong>&nbsp;<strong>Final Average</strong>:</strong></td>
					<td width="171">&nbsp;
					<?php 
					
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
									if($sumTotalOfFirstScore == ""){
										$sumTotalOfFirstScore = 0;
									}else{
										$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
								
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'student_id' => $student_id, 'exam_score !=' => 0))->num_rows();		
					?>
					
					<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?> %					</td>
				    <td width="">&nbsp;<strong>Final Grade</strong> </td>
				    <td width="75">&nbsp;
								<?php $FindGrade = round($sumTotalOfFirstScore /$getSubjectNumbered,2);?>
								<?php if ($FindGrade <= '100' && $FindGrade >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '79.9' && $FindGrade >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '69.9' && $FindGrade >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "59.9" && $FindGrade >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "49.9" && $FindGrade >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "39.9" && $FindGrade >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					
					</td>
				  </tr>
				  
				  <!--<tr>
					<td><strong>&nbsp;Total Score:</strong></td>
					<td>&nbsp;<?=$student_selected['roll'];?></td>
					<td>&nbsp;<strong>SEX:</strong></td>
					<td>&nbsp;<?=ucwords($student_selected['sex']);?></td>
					<td colspan="2">&nbsp;<strong>ACADEMIC YEAR:</strong></td>
					<td colspan="2">&nbsp;<?=$session?></td>
				  </tr>-->
				</table>
				
					<?php 
					$select = $this->db->get_where('udemy_stu_rem', array('student_id' => $student_id, 'session' => $session, 'term' => $term))->row();
					?>
				<table width="100%" border="1">
                  <tr>
                    <td colspan="2"><div align="center"><strong>AFFECTIVE ASSESSMENT </strong></div></td>
                    <td colspan="2"><div align="center"><strong>PSYCHOMOTOR ASSESSMENT</strong></div></td>
                  </tr>
                  <tr>
                    <td width="19%"><strong>Items' Name </strong></td>
                    <td width="28%"><div align="center"><strong>Scores</strong></div></td>
                    <td width="23%"><strong>Items' Name </strong></td>
                    <td width="30%"><div align="center"><strong>Scores</strong></div></td>
                  </tr>
                  <tr>
                    <td>Attentiveness</td>
                    <td><div align="center"><?=$select->at;?></div></td>
                    <td>Club / Society </td>
                    <td><div align="center"><?=$select->cl;?></div></td>
                  </tr>
                  <tr>
                    <td>Honesty</td>
                    <td><div align="center"><?=$select->ho;?></div></td>
                    <td>Drawing and Painting </td>
                    <td><div align="center"><?=$select->dr;?></div></td>
                  </tr>
                  <tr>
                    <td>Neatness</td>
                    <td><div align="center"><?=$select->ne;?></div></td>
                    <td>Hand Writting </td>
                    <td><div align="center"><?=$select->ha;?></div></td>
                  </tr>
                  <tr>
                    <td>Politeness</td>
                    <td><div align="center"><?=$select->po;?></div></td>
                    <td>Hobies</td>
                    <td><div align="center"><?=$select->hob;?></div></td>
                  </tr>
                  <tr>
                    <td>Punchuality</td>
                    <td><div align="center"><?=$select->pu;?></div></td>
                    <td>Speech Fluentcy </td>
                    <td><div align="center"><?=$select->sp;?></div></td>
                  </tr>
                  <tr>
                    <td>Relationship with Others </td>
                    <td><div align="center"><?=$select->re;?></div></td>
                    <td>Sport and Game </td>
                    <td><div align="center"><?=$select->sp;?></div></td>
                  </tr>
                </table>
				<br>
				<table width="100%" border="0">
				  <tr>
					<td style="background:white; color:black" align="center">5 = A(Excellent) 4 = B(V.Good) 3 = C(Good) 2 = D(Pass) 1 = E(Fair) 0 = F(Fail)</td>
				  </tr>
				</table>
				<table width="100%" border="0">
                  <tr>
                    <td width="15%">Form Mater's Comment</td>
                    <td colspan="3"><?=$select->fmc;?></td>
                  </tr>
                  <tr>
                    <td>Form Mater's Name</td>
                    <td><?=$select->fma;?></td>
                    <td>Signature</td>
                    <td><em><strong><?=$select->fma;?></strong><em></td>
                  </tr>
                  <tr>
                    <td>Principal's Comment</td>
                    <td colspan="3"><?=$select->pc;?></td>
                  </tr>
                  <tr>
                    <td>Principal's Name</td>
                    <td width="47%"><?=$this->db->get_where('admin', array('admin_id' => 1))->row()->name;?></td>
                    <td width="7%">Signature</td>
                    <td width="31%"><img src="<?php echo base_url();?>uploads/signature.png" width="150px" height="50px"></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="right"><strong>Next term Begins:</strong> <?=get_settings('next_term_begin')?></td>
                  </tr>
                </table>
			<?php endif;?>	
			
			
			
			
			<?php endif;?>	
			<div class="pagebreak"> </div>
			
			
			
			
			
			
			
			
			
			
			<?php if(get_settings('report_template') == 'udemy'):?>
				<?php if($term == 1) : ?>

				<table width="100%">
				  <tr>
					<td class="pull-left"><img src="<?php echo base_url()?>uploads/logo.png"  height="150" width="150"></td>
					<td>
						<h2 align="center"><?php echo get_settings('system_name')?></h2>
						<p align="center">MOTTO: HOME WHERE KNOWLEGE SPEAKS<br><strong>Address:</strong> <?php echo get_settings('address')?> <br/>
						<!--<i class="fa fa-envelope"></i> <?php echo get_settings('system_email')?> : <i class="fa fa-phone"></i> <?php echo get_settings('phone')?>--></p>	
					</td>
					<td class="pull-right"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="150" width="150"></td>
				  </tr>		
				</table>
				<table width="100%" border="0">
				  <tr>
					<td align="center"><strong>REPORT SHEET FOR <?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?> <?=$session?> ACADEMIC SESSION</strong></td>
				  </tr>
				</table>
								
				<table width="100%" height="100" border="1">
				  <tr>
					<td width="322"><strong>&nbsp;PUPIL'S NAME:</strong></td>
					<td width="267" class="text-uppercase">&nbsp;<?=$student_selected['name'];?></td>
					<td width="265"><strong>&nbsp;CLASS:</strong></td>
					<td width="69">&nbsp;<?=$class_name;?></td>
					<td width="233"><strong>&nbsp;TERM:</strong></td>
					<td width="92">&nbsp;<?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></td>
				  </tr>
				  <tr>
					<td><strong>&nbsp;ADMISSION NO:</strong></td>
					<td>&nbsp;<?=$student_selected['roll'];?></td>
					<td>&nbsp;<strong>SEX:</strong></td>
					<td>&nbsp;<?=ucwords($student_selected['sex']);?></td>
					<td>&nbsp;<strong>ACADEMIC YEAR:</strong></td>
					<td>&nbsp;<?=$session?></td>
				  </tr>
				  <tr>
					<td><strong>&nbsp;DAY(S) SCHOOL OPEN</strong></td>
					<td>&nbsp;
				    <?=$this->db->get_where('attendance', array('session' => $session, 
					'term' => $term))->num_rows(); ?></td>
					<td width="265"><strong>&nbsp;DAY(S) PRESENT:</strong></td>
					<td>&nbsp;<?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 1))->num_rows(); 
						?></td>
					<td><strong>&nbsp;DAY(S) ABSENT:</strong></td>
					<td><strong>&nbsp;</strong><?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 2))->num_rows(); 
						?></td>
			      </tr>
				</table>
				<table width="100%"  border="1">
				  <tr>
					<td valign="top"><strong>&nbsp;Subjects</strong></td>
					
					<td valign="top"><strong>&nbsp;20% CA1</strong> </td>
					<td valign="top"><strong>&nbsp;20% CA2</strong> </td>
					<td valign="top"><strong>&nbsp;60% Exam</strong> </td>
					<td valign="top"><strong>&nbsp;100% Total</strong> </td>
					<td valign="top"><strong>&nbsp;Grade</strong> </td>
					<td valign="top"><strong>&nbsp;POS</strong> </td>
					<td valign="top"><strong>&nbsp;Out Of</strong> </td>
					<td valign="top"><strong>&nbsp;Min Score</strong></td>
					<td valign="top"><strong>&nbsp;Max Score</strong> </td>
					<td valign="top"><strong>&nbsp;Class AVG</strong></td>
					<td valign="top">&nbsp;<strong>Remarks</strong> </td>
				  </tr>
				  
                    <?php 
						$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
						foreach ($select_subject as $key => $subject):
					?>
					<tr>
					<td valign="top">&nbsp;<?php echo $subject['name'];?></td>
					
                                        <?php 
										$obtained_mark_query = $this->db->get_where('mark', 
											array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 
											'student_id' => $student_id, 'term' => 1));
                                        
										

                                            $class_score_one    = $obtained_mark_query->row()->class_score1;
                                            $class_score_two    = $obtained_mark_query->row()->class_score2;
                                            //$class_score_three  = $obtained_mark_query->row()->class_score3;
                                            $exam_score         = $obtained_mark_query->row()->exam_score;
											$total_CA        	= $class_score_one; + $class_score_two;//+ $class_score_three;
                                            $total_score        = $class_score_one + $class_score_two + $exam_score;// + $class_score_three + $exam_score;
											
											if($total_score == ""){
												$total_score = 0;
											}else{
												$total_score = $total_score;	
											}
                                        
										
											$update['sum_first'] = $total_score;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $update);
										
                                        ?>
					
					<td valign="top">&nbsp;<?php if($class_score_one == 0)echo '';else echo $class_score_one;?></td>
					<td valign="top">&nbsp;<?php if($class_score_two == 0)echo '';else echo $class_score_two;?></td>
					<td valign="top">&nbsp;<?php if($exam_score == 0)echo ''; else echo $exam_score;?></td>
					<td valign="top">&nbsp;<?php if($total_score == 0)echo ''; else echo $total_score;?></td>
					<td valign="top">&nbsp;
								<?php if ($total_score <= '100' && $total_score >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($total_score <= '79' && $total_score >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($total_score <= "59" && $total_score >= '50'):?>
								<?php echo 'P';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					</td>
					<td valign="top">&nbsp;
					
										<?php
										
										$subject_id = $subject['subject_id'];
 										$sql = "SELECT mark_id, sum_first, FIND_IN_SET( sum_first,(
												SELECT GROUP_CONCAT( sum_first  ORDER BY sum_first DESC ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND sum_first = $total_score AND sum_first != 0"; 
        
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
					<td valign="top">&nbsp;<?=$number_class?></td>
					
					<td valign="top">&nbsp;
                        <?php echo $lowest_mark = $this->crud_model->get_lowest_marks_first( $exam_id , $class_id , $subject['subject_id'], 1 );?>
					</td>
					<td valign="top">&nbsp;
						<?php echo $highest_mark = $this->crud_model->get_highest_marks_first( $exam_id , $class_id , $subject['subject_id'], 1 ); ?>	
					</td>

					
					<td valign="top">&nbsp;
					
                                <?php 
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								echo $sumTotalOfFirstScore = $query->row()->sum_first;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'student_id' => $student_id, 'exam_score !=' => 0))->num_rows();
									
									
									$updatePercetangeFirst = round($sumTotalOfFirstScore/$getSubjectNumbered);
									if(is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = 0;
									}
									if(!is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = $updatePercetangeFirst;
									}
											
											$class_position_first['class_position_first'] = $updatePercetangeFirst;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $class_position_first);
									
									
                                ?>
					
					
					</td>


					<td valign="top">&nbsp;<?php echo $obtained_mark_query->row()->comment;?></td>
				  </tr>
				  <?php endforeach;?>
				</table>
				
				<table width="100%" border="0">
				  <tr>
					<td style="background:white; color:black"><span class="pull-left">GRADE DETAILS:</span><span class="pull-right"><strong>Number of Subject Offered: 
						<?php echo $getSubjectNumbered?>
					</strong> </span><br>
					80-100 = A(Excellent) 70-79 = B(V.Good) 60-69 = C(Good) 50-59 = D(Pass) 40-49 = E(Fair) 0-39 = F(Fail)</td>
				  </tr>
				</table>
				
				
				<table width="100%" border="1">
				  <tr>
					<td width="186"><strong>&nbsp;Class Position:</strong></td>
					<td width="89" class="text-uppercase">&nbsp;
					
					
										<?php
										
										
 										$sql = "SELECT mark_id, class_position_first, FIND_IN_SET( class_position_first,(
												SELECT GROUP_CONCAT( class_position_first  ORDER BY class_position_first desc ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND class_position_first = $updatePercetangeFirst AND class_position_first != 0"; 
        
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
					<td width="155"><strong>&nbsp;Total Score:</strong></td>
					<td width="119">&nbsp;
								<?php
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
									if($sumTotalOfFirstScore == ""){
										echo $sumTotalOfFirstScore = 0;
									}else{
										echo $sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
							?>					</td>
					<td colspan="2"><strong>&nbsp;<strong>Final Average</strong>:</strong></td>
					<td width="171">&nbsp;
					<?php 
					
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
									if($sumTotalOfFirstScore == ""){
										$sumTotalOfFirstScore = 0;
									}else{
										$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
								
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'student_id' => $student_id, 'exam_score !=' => 0))->num_rows();		
					?>
					
					<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?> %					</td>
				    <td width="">&nbsp;<strong>Final Grade</strong> </td>
				    <td width="75">&nbsp;
								<?php $FindGrade = round($sumTotalOfFirstScore /$getSubjectNumbered,2);?>
								<?php if ($FindGrade <= '100' && $FindGrade >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '79.9' && $FindGrade >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '69.9' && $FindGrade >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "59.9" && $FindGrade >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "49.9" && $FindGrade >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "39.9" && $FindGrade >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					
					</td>
				  </tr>
				  
				  <!--<tr>
					<td><strong>&nbsp;Total Score:</strong></td>
					<td>&nbsp;<?=$student_selected['roll'];?></td>
					<td>&nbsp;<strong>SEX:</strong></td>
					<td>&nbsp;<?=ucwords($student_selected['sex']);?></td>
					<td colspan="2">&nbsp;<strong>ACADEMIC YEAR:</strong></td>
					<td colspan="2">&nbsp;<?=$session?></td>
				  </tr>-->
				</table>
				
					<?php $select = $this->db->get_where('udemy_stu_rem', array('student_id' => $student_id, 'session' => $session, 'term' => $term))->row();?>
				<table width="100%" border="1">
                  <tr>
                    <td colspan="2"><div align="center"><strong>AFFECTIVE ASSESSMENT </strong></div></td>
                    <td colspan="2"><div align="center"><strong>PSYCHOMOTOR ASSESSMENT</strong></div></td>
                  </tr>
                  <tr>
                    <td width="19%"><strong>Items' Name </strong></td>
                    <td width="28%"><div align="center"><strong>Scores</strong></div></td>
                    <td width="23%"><strong>Items' Name </strong></td>
                    <td width="30%"><div align="center"><strong>Scores</strong></div></td>
                  </tr>
                  <tr>
                    <td>Attentiveness</td>
                    <td><div align="center"><?=$select->at;?></div></td>
                    <td>Club / Society </td>
                    <td><div align="center"><?=$select->cl;?></div></td>
                  </tr>
                  <tr>
                    <td>Honesty</td>
                    <td><div align="center"><?=$select->ho;?></div></td>
                    <td>Drawing and Painting </td>
                    <td><div align="center"><?=$select->dr;?></div></td>
                  </tr>
                  <tr>
                    <td>Neatness</td>
                    <td><div align="center"><?=$select->ne;?></div></td>
                    <td>Hand Writting </td>
                    <td><div align="center"><?=$select->ha;?></div></td>
                  </tr>
                  <tr>
                    <td>Politeness</td>
                    <td><div align="center"><?=$select->po;?></div></td>
                    <td>Hobies</td>
                    <td><div align="center"><?=$select->hob;?></div></td>
                  </tr>
                  <tr>
                    <td>Punchuality</td>
                    <td><div align="center"><?=$select->pu;?></div></td>
                    <td>Speech Fluentcy </td>
                    <td><div align="center"><?=$select->sp;?></div></td>
                  </tr>
                  <tr>
                    <td>Relationship with Others </td>
                    <td><div align="center"><?=$select->re;?></div></td>
                    <td>Sport and Game </td>
                    <td><div align="center"><?=$select->sp;?></div></td>
                  </tr>
                </table>
				<br>
				<table width="100%" border="0">
				  <tr>
					<td style="background:white; color:black" align="center">5 = A(Excellent) 4 = B(V.Good) 3 = C(Good) 2 = D(Pass) 1 = E(Fair) 0 = F(Fail)</td>
				  </tr>
				</table>
				<table width="100%" border="0">
                  <tr>
                    <td width="15%">Form Mater's Comment</td>
                    <td colspan="3"><?=$select->fmc;?></td>
                  </tr>
                  <tr>
                    <td>Form Mater's Name</td>
                    <td><?=$select->fma;?></td>
                    <td>Signature</td>
                    <td><em><strong><?=$select->fma;?></strong><em></td>
                  </tr>
                  <tr>
                    <td>Principal's Comment</td>
                    <td colspan="3"><?=$select->pc;?></td>
                  </tr>
                  <tr>
                    <td>Principal's Name</td>
                    <td width="47%"><?=$this->db->get_where('admin', array('admin_id' => 1))->row()->name;?></td>
                    <td width="7%">Signature</td>
                    <td width="31%"><img src="<?php echo base_url();?>uploads/signature.png" width="150px" height="50px"></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="right"><strong>Next term Begins:</strong> <?=get_settings('next_term_begin')?></td>
                  </tr>
                </table>
				<?php endif;?>
				<div class="pagebreak"> </div>
			
			
			
				<?php if($term == 2) : ?>
				<table width="100%">
				  <tr>
					<td class="pull-left"><img src="<?php echo base_url()?>uploads/logo.png"  height="150" width="150"></td>
					<td>
						<h2 align="center"><?php echo get_settings('system_name')?></h2>
						<p align="center">MOTTO: HOME WHERE KNOWLEGE SPEAKS<br><strong>Address:</strong> <?php echo get_settings('address')?> <br/>
						<!--<i class="fa fa-envelope"></i> <?php echo get_settings('system_email')?> : <i class="fa fa-phone"></i> <?php echo get_settings('phone')?>--></p>	
					</td>
					<td class="pull-right"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="150" width="150"></td>
				  </tr>		
				</table>
				<table width="100%" border="0">
				  <tr>
					<td align="center"><strong>REPORT SHEET FOR <?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?> <?=$session?> ACADEMIC SESSION</strong></td>
				  </tr>
				</table>
								
				<table width="100%" height="100" border="1">
				  <tr>
					<td width="322"><strong>&nbsp;PUPIL'S NAME:</strong></td>
					<td width="267" class="text-uppercase">&nbsp;<?=$student_selected['name'];?></td>
					<td width="265"><strong>&nbsp;CLASS:</strong></td>
					<td width="69">&nbsp;<?=$class_name;?></td>
					<td width="233"><strong>&nbsp;TERM:</strong></td>
					<td width="92">&nbsp;<?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></td>
				  </tr>
				  <tr>
					<td><strong>&nbsp;ADMISSION NO:</strong></td>
					<td>&nbsp;<?=$student_selected['roll'];?></td>
					<td>&nbsp;<strong>SEX:</strong></td>
					<td>&nbsp;<?=ucwords($student_selected['sex']);?></td>
					<td>&nbsp;<strong>ACADEMIC YEAR:</strong></td>
					<td>&nbsp;<?=$session?></td>
				  </tr>
				  <tr>
					<td><strong>&nbsp;DAY(S) SCHOOL OPEN</strong></td>
					<td>&nbsp;
				    <?=$this->db->get_where('attendance', array('session' => $session, 
					'term' => $term))->num_rows(); ?></td>
					<td width="265"><strong>&nbsp;DAY(S) PRESENT:</strong></td>
					<td>&nbsp;<?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 1))->num_rows(); 
						?></td>
					<td><strong>&nbsp;DAY(S) ABSENT:</strong></td>
					<td><strong>&nbsp;</strong><?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 2))->num_rows(); 
						?></td>
			      </tr>
				</table>
				<table width="100%"  border="1">
				  <tr>
					<td valign="top"><strong>&nbsp;Subjects</strong></td>
					
					<td valign="top"><strong>&nbsp;20% CA1</strong> </td>
					<td valign="top"><strong>&nbsp;20% CA2</strong> </td>
					<td valign="top"><strong>&nbsp;60% Exam</strong> </td>
					<td valign="top"><strong>&nbsp;100% Total</strong> </td>
					<td valign="top"><strong>&nbsp;Grade</strong> </td>
					<td valign="top"><strong>&nbsp;POS</strong> </td>
					<td valign="top"><strong>&nbsp;Out Of</strong> </td>
					<td valign="top"><strong>&nbsp;Min Score</strong></td>
					<td valign="top"><strong>&nbsp;Max Score</strong> </td>
					<td valign="top"><strong>&nbsp;Class AVG</strong></td>
					<td valign="top">&nbsp;<strong>Remarks</strong> </td>
				  </tr>
				  
                    <?php 
						$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
						foreach ($select_subject as $key => $subject):
					?>
					<tr>
					<td valign="top">&nbsp;<?php echo $subject['name'];?></td>
					
                                        <?php 
										$obtained_mark_query = $this->db->get_where('mark', 
											array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 
											'student_id' => $student_id, 'term' => 1));
                                        
										

                                            $class_score_one    = $obtained_mark_query->row()->class_score1;
                                            $class_score_two    = $obtained_mark_query->row()->class_score2;
                                            //$class_score_three  = $obtained_mark_query->row()->class_score3;
                                            $exam_score         = $obtained_mark_query->row()->exam_score;
											$total_CA        	= $class_score_one; + $class_score_two;//+ $class_score_three;
                                            $total_score        = $class_score_one + $class_score_two + $exam_score;// + $class_score_three + $exam_score;
											
											if($total_score == ""){
												$total_score = 0;
											}else{
												$total_score = $total_score;	
											}
                                        
										
											$update['sum_first'] = $total_score;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $update);
										
                                        ?>
					
					<td valign="top">&nbsp;<?php if($class_score_one == 0)echo '';else echo $class_score_one;?></td>
					<td valign="top">&nbsp;<?php if($class_score_two == 0)echo '';else echo $class_score_two;?></td>
					<td valign="top">&nbsp;<?php if($exam_score == 0)echo ''; else echo $exam_score;?></td>
					<td valign="top">&nbsp;<?php if($total_score == 0)echo ''; else echo $total_score;?></td>
					<td valign="top">&nbsp;
								<?php if ($total_score <= '100' && $total_score >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($total_score <= '79' && $total_score >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($total_score <= "59" && $total_score >= '50'):?>
								<?php echo 'P';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					</td>
					<td valign="top">&nbsp;
					
										<?php
										
										$subject_id = $subject['subject_id'];
 										$sql = "SELECT mark_id, sum_first, FIND_IN_SET( sum_first,(
												SELECT GROUP_CONCAT( sum_first  ORDER BY sum_first DESC ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND sum_first = $total_score AND sum_first != 0"; 
        
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
					<td valign="top">&nbsp;<?=$number_class?></td>
					
					<td valign="top">&nbsp;
                        <?php echo $lowest_mark = $this->crud_model->get_lowest_marks_first( $exam_id , $class_id , $subject['subject_id'], 1 );?>
					</td>
					<td valign="top">&nbsp;
						<?php echo $highest_mark = $this->crud_model->get_highest_marks_first( $exam_id , $class_id , $subject['subject_id'], 1 ); ?>	
					</td>

					
					<td valign="top">&nbsp;
					
                                <?php 
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								echo $sumTotalOfFirstScore = $query->row()->sum_first;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'student_id' => $student_id, 'exam_score !=' => 0))->num_rows();
									
									
									$updatePercetangeFirst = round($sumTotalOfFirstScore/$getSubjectNumbered);
									if(is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = 0;
									}
									if(!is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = $updatePercetangeFirst;
									}
											
											$class_position_first['class_position_first'] = $updatePercetangeFirst;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $class_position_first);
									
									
                                ?>
					
					
					</td>


					<td valign="top">&nbsp;<?php echo $obtained_mark_query->row()->comment;?></td>
				  </tr>
				  <?php endforeach;?>
				</table>
				
				<table width="100%" border="0">
				  <tr>
					<td style="background:white; color:black"><span class="pull-left">GRADE DETAILS:</span><span class="pull-right"><strong>Number of Subject Offered: 
						<?php echo $getSubjectNumbered?>
					</strong> </span><br>
					80-100 = A(Excellent) 70-79 = B(V.Good) 60-69 = C(Good) 50-59 = D(Pass) 40-49 = E(Fair) 0-39 = F(Fail)</td>
				  </tr>
				</table>
				
				
				<table width="100%" border="1">
				  <tr>
					<td width="186"><strong>&nbsp;Class Position:</strong></td>
					<td width="89" class="text-uppercase">&nbsp;
					
					
										<?php
										
										
 										$sql = "SELECT mark_id, class_position_first, FIND_IN_SET( class_position_first,(
												SELECT GROUP_CONCAT( class_position_first  ORDER BY class_position_first desc ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND class_position_first = $updatePercetangeFirst AND class_position_first != 0"; 
        
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
					<td width="155"><strong>&nbsp;Total Score:</strong></td>
					<td width="119">&nbsp;
								<?php
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
									if($sumTotalOfFirstScore == ""){
										echo $sumTotalOfFirstScore = 0;
									}else{
										echo $sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
							?>					</td>
					<td colspan="2"><strong>&nbsp;<strong>Final Average</strong>:</strong></td>
					<td width="171">&nbsp;
					<?php 
					
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
									if($sumTotalOfFirstScore == ""){
										$sumTotalOfFirstScore = 0;
									}else{
										$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
								
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'student_id' => $student_id, 'exam_score !=' => 0))->num_rows();		
					?>
					
					<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?> %					</td>
				    <td width="">&nbsp;<strong>Final Grade</strong> </td>
				    <td width="75">&nbsp;
								<?php $FindGrade = round($sumTotalOfFirstScore /$getSubjectNumbered,2);?>
								<?php if ($FindGrade <= '100' && $FindGrade >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '79.9' && $FindGrade >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '69.9' && $FindGrade >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "59.9" && $FindGrade >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "49.9" && $FindGrade >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "39.9" && $FindGrade >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					
					</td>
				  </tr>
				  
				  <!--<tr>
					<td><strong>&nbsp;Total Score:</strong></td>
					<td>&nbsp;<?=$student_selected['roll'];?></td>
					<td>&nbsp;<strong>SEX:</strong></td>
					<td>&nbsp;<?=ucwords($student_selected['sex']);?></td>
					<td colspan="2">&nbsp;<strong>ACADEMIC YEAR:</strong></td>
					<td colspan="2">&nbsp;<?=$session?></td>
				  </tr>-->
				</table>
				
					<?php 
					$select = $this->db->get_where('udemy_stu_rem', array('student_id' => $student_id, 'session' => $session, 'term' => $term))->row();
					?>
				<table width="100%" border="1">
                  <tr>
                    <td colspan="2"><div align="center"><strong>AFFECTIVE ASSESSMENT </strong></div></td>
                    <td colspan="2"><div align="center"><strong>PSYCHOMOTOR ASSESSMENT</strong></div></td>
                  </tr>
                  <tr>
                    <td width="19%"><strong>Items' Name </strong></td>
                    <td width="28%"><div align="center"><strong>Scores</strong></div></td>
                    <td width="23%"><strong>Items' Name </strong></td>
                    <td width="30%"><div align="center"><strong>Scores</strong></div></td>
                  </tr>
                  <tr>
                    <td>Attentiveness</td>
                    <td><div align="center"><?=$select->at;?></div></td>
                    <td>Club / Society </td>
                    <td><div align="center"><?=$select->cl;?></div></td>
                  </tr>
                  <tr>
                    <td>Honesty</td>
                    <td><div align="center"><?=$select->ho;?></div></td>
                    <td>Drawing and Painting </td>
                    <td><div align="center"><?=$select->dr;?></div></td>
                  </tr>
                  <tr>
                    <td>Neatness</td>
                    <td><div align="center"><?=$select->ne;?></div></td>
                    <td>Hand Writting </td>
                    <td><div align="center"><?=$select->ha;?></div></td>
                  </tr>
                  <tr>
                    <td>Politeness</td>
                    <td><div align="center"><?=$select->po;?></div></td>
                    <td>Hobies</td>
                    <td><div align="center"><?=$select->hob;?></div></td>
                  </tr>
                  <tr>
                    <td>Punchuality</td>
                    <td><div align="center"><?=$select->pu;?></div></td>
                    <td>Speech Fluentcy </td>
                    <td><div align="center"><?=$select->sp;?></div></td>
                  </tr>
                  <tr>
                    <td>Relationship with Others </td>
                    <td><div align="center"><?=$select->re;?></div></td>
                    <td>Sport and Game </td>
                    <td><div align="center"><?=$select->sp;?></div></td>
                  </tr>
                </table>
				<br>
				<table width="100%" border="0">
				  <tr>
					<td style="background:white; color:black" align="center">5 = A(Excellent) 4 = B(V.Good) 3 = C(Good) 2 = D(Pass) 1 = E(Fair) 0 = F(Fail)</td>
				  </tr>
				</table>
				<table width="100%" border="0">
                  <tr>
                    <td width="15%">Form Mater's Comment</td>
                    <td colspan="3"><?=$select->fmc;?></td>
                  </tr>
                  <tr>
                    <td>Form Mater's Name</td>
                    <td><?=$select->fma;?></td>
                    <td>Signature</td>
                    <td><em><strong><?=$select->fma;?></strong><em></td>
                  </tr>
                  <tr>
                    <td>Principal's Comment</td>
                    <td colspan="3"><?=$select->pc;?></td>
                  </tr>
                  <tr>
                    <td>Principal's Name</td>
                    <td width="47%"><?=$this->db->get_where('admin', array('admin_id' => 1))->row()->name;?></td>
                    <td width="7%">Signature</td>
                    <td width="31%"><img src="<?php echo base_url();?>uploads/signature.png" width="150px" height="50px"></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="right"><strong>Next term Begins:</strong> <?=get_settings('next_term_begin')?></td>
                  </tr>
                </table>

				<?php endif;?>
				<div class="pagebreak"> </div>
				
				
				
				
				
				
			<?php if($term == 3) : ?>
				<table width="100%">
				  <tr>
					<td class="pull-left"><img src="<?php echo base_url()?>uploads/logo.png"  height="150" width="150"></td>
					<td>
						<h2 align="center"><?php echo get_settings('system_name')?></h2>
						<p align="center">MOTTO: HOME WHERE KNOWLEGE SPEAKS<br><strong>Address:</strong> <?php echo get_settings('address')?> <br/>
						<!--<i class="fa fa-envelope"></i> <?php echo get_settings('system_email')?> : <i class="fa fa-phone"></i> <?php echo get_settings('phone')?>--></p>	
					</td>
					<td class="pull-right"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="150" width="150"></td>
				  </tr>		
				</table>
				<table width="100%" border="0">
				  <tr>
					<td align="center"><strong>REPORT SHEET FOR <?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?> <?=$session?> ACADEMIC SESSION</strong></td>
				  </tr>
				</table>
								
				<table width="100%" height="100" border="1">
				  <tr>
					<td width="322"><strong>&nbsp;PUPIL'S NAME:</strong></td>
					<td width="267" class="text-uppercase">&nbsp;<?=$student_selected['name'];?></td>
					<td width="265"><strong>&nbsp;CLASS:</strong></td>
					<td width="69">&nbsp;<?=$class_name;?></td>
					<td width="233"><strong>&nbsp;TERM:</strong></td>
					<td width="92">&nbsp;<?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></td>
				  </tr>
				  <tr>
					<td><strong>&nbsp;ADMISSION NO:</strong></td>
					<td>&nbsp;<?=$student_selected['roll'];?></td>
					<td>&nbsp;<strong>SEX:</strong></td>
					<td>&nbsp;<?=ucwords($student_selected['sex']);?></td>
					<td>&nbsp;<strong>ACADEMIC YEAR:</strong></td>
					<td>&nbsp;<?=$session?></td>
				  </tr>
				  <tr>
					<td><strong>&nbsp;DAY(S) SCHOOL OPEN</strong></td>
					<td>&nbsp;
				    <?=$this->db->get_where('attendance', array('session' => $session, 
					'term' => $term))->num_rows(); ?></td>
					<td width="265"><strong>&nbsp;DAY(S) PRESENT:</strong></td>
					<td>&nbsp;<?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 1))->num_rows(); 
						?></td>
					<td><strong>&nbsp;DAY(S) ABSENT:</strong></td>
					<td><strong>&nbsp;</strong><?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 2))->num_rows(); 
						?></td>
			      </tr>
				</table>
				<table width="100%"  border="1">
				  <tr>
					<td valign="top"><strong>&nbsp;Subjects</strong></td>
					
					<td valign="top"><strong>&nbsp;20% CA1</strong> </td>
					<td valign="top"><strong>&nbsp;20% CA2</strong> </td>
					<td valign="top"><strong>&nbsp;60% Exam</strong> </td>
					<td valign="top"><strong>&nbsp;100% Total</strong> </td>
					<td valign="top"><strong>&nbsp;Grade</strong> </td>
					<td valign="top"><strong>&nbsp;POS</strong> </td>
					<td valign="top"><strong>&nbsp;Out Of</strong> </td>
					<td valign="top"><strong>&nbsp;Min Score</strong></td>
					<td valign="top"><strong>&nbsp;Max Score</strong> </td>
					<td valign="top"><strong>&nbsp;Class AVG</strong></td>
					<td valign="top">&nbsp;<strong>Remarks</strong> </td>
				  </tr>
				  
                    <?php 
						$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
						foreach ($select_subject as $key => $subject):
					?>
					<tr>
					<td valign="top">&nbsp;<?php echo $subject['name'];?></td>
					
                                        <?php 
										$obtained_mark_query = $this->db->get_where('mark', 
											array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 
											'student_id' => $student_id, 'term' => 1));
                                        
										

                                            $class_score_one    = $obtained_mark_query->row()->class_score1;
                                            $class_score_two    = $obtained_mark_query->row()->class_score2;
                                            //$class_score_three  = $obtained_mark_query->row()->class_score3;
                                            $exam_score         = $obtained_mark_query->row()->exam_score;
											$total_CA        	= $class_score_one; + $class_score_two;//+ $class_score_three;
                                            $total_score        = $class_score_one + $class_score_two + $exam_score;// + $class_score_three + $exam_score;
											
											if($total_score == ""){
												$total_score = 0;
											}else{
												$total_score = $total_score;	
											}
                                        
										
											$update['sum_first'] = $total_score;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $update);
										
                                        ?>
					
					<td valign="top">&nbsp;<?php if($class_score_one == 0)echo '';else echo $class_score_one;?></td>
					<td valign="top">&nbsp;<?php if($class_score_two == 0)echo '';else echo $class_score_two;?></td>
					<td valign="top">&nbsp;<?php if($exam_score == 0)echo ''; else echo $exam_score;?></td>
					<td valign="top">&nbsp;<?php if($total_score == 0)echo ''; else echo $total_score;?></td>
					<td valign="top">&nbsp;
								<?php if ($total_score <= '100' && $total_score >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($total_score <= '79' && $total_score >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($total_score <= "59" && $total_score >= '50'):?>
								<?php echo 'P';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					</td>
					<td valign="top">&nbsp;
					
										<?php
										
										$subject_id = $subject['subject_id'];
 										$sql = "SELECT mark_id, sum_first, FIND_IN_SET( sum_first,(
												SELECT GROUP_CONCAT( sum_first  ORDER BY sum_first DESC ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND sum_first = $total_score AND sum_first != 0"; 
        
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
					<td valign="top">&nbsp;<?=$number_class?></td>
					
					<td valign="top">&nbsp;
                        <?php echo $lowest_mark = $this->crud_model->get_lowest_marks_first( $exam_id , $class_id , $subject['subject_id'], 1 );?>
					</td>
					<td valign="top">&nbsp;
						<?php echo $highest_mark = $this->crud_model->get_highest_marks_first( $exam_id , $class_id , $subject['subject_id'], 1 ); ?>	
					</td>

					
					<td valign="top">&nbsp;
					
                                <?php 
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								echo $sumTotalOfFirstScore = $query->row()->sum_first;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'student_id' => $student_id, 'exam_score !=' => 0))->num_rows();
									
									
									$updatePercetangeFirst = round($sumTotalOfFirstScore/$getSubjectNumbered);
									if(is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = 0;
									}
									if(!is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = $updatePercetangeFirst;
									}
											
											$class_position_first['class_position_first'] = $updatePercetangeFirst;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $class_position_first);
									
									
                                ?>
					
					
					</td>


					<td valign="top">&nbsp;<?php echo $obtained_mark_query->row()->comment;?></td>
				  </tr>
				  <?php endforeach;?>
				</table>
				
				<table width="100%" border="0">
				  <tr>
					<td style="background:white; color:black"><span class="pull-left">GRADE DETAILS:</span><span class="pull-right"><strong>Number of Subject Offered: 
						<?php echo $getSubjectNumbered?>
					</strong> </span><br>
					80-100 = A(Excellent) 70-79 = B(V.Good) 60-69 = C(Good) 50-59 = D(Pass) 40-49 = E(Fair) 0-39 = F(Fail)</td>
				  </tr>
				</table>
				
				
				<table width="100%" border="1">
				  <tr>
					<td width="186"><strong>&nbsp;Class Position:</strong></td>
					<td width="89" class="text-uppercase">&nbsp;
					
					
										<?php
										
										
 										$sql = "SELECT mark_id, class_position_first, FIND_IN_SET( class_position_first,(
												SELECT GROUP_CONCAT( class_position_first  ORDER BY class_position_first desc ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND class_position_first = $updatePercetangeFirst AND class_position_first != 0"; 
        
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
					<td width="155"><strong>&nbsp;Total Score:</strong></td>
					<td width="119">&nbsp;
								<?php
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
									if($sumTotalOfFirstScore == ""){
										echo $sumTotalOfFirstScore = 0;
									}else{
										echo $sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
							?>					</td>
					<td colspan="2"><strong>&nbsp;<strong>Final Average</strong>:</strong></td>
					<td width="171">&nbsp;
					<?php 
					
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
									if($sumTotalOfFirstScore == ""){
										$sumTotalOfFirstScore = 0;
									}else{
										$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
								
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'student_id' => $student_id, 'exam_score !=' => 0))->num_rows();		
					?>
					
					<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?> %					</td>
				    <td width="">&nbsp;<strong>Final Grade</strong> </td>
				    <td width="75">&nbsp;
								<?php $FindGrade = round($sumTotalOfFirstScore /$getSubjectNumbered,2);?>
								<?php if ($FindGrade <= '100' && $FindGrade >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '79.9' && $FindGrade >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '69.9' && $FindGrade >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "59.9" && $FindGrade >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "49.9" && $FindGrade >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "39.9" && $FindGrade >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					
					</td>
				  </tr>
				  
				  <!--<tr>
					<td><strong>&nbsp;Total Score:</strong></td>
					<td>&nbsp;<?=$student_selected['roll'];?></td>
					<td>&nbsp;<strong>SEX:</strong></td>
					<td>&nbsp;<?=ucwords($student_selected['sex']);?></td>
					<td colspan="2">&nbsp;<strong>ACADEMIC YEAR:</strong></td>
					<td colspan="2">&nbsp;<?=$session?></td>
				  </tr>-->
				</table>
				
					<?php 
					$select = $this->db->get_where('udemy_stu_rem', array('student_id' => $student_id, 'session' => $session, 'term' => $term))->row();
					?>
				<table width="100%" border="1">
                  <tr>
                    <td colspan="2"><div align="center"><strong>AFFECTIVE ASSESSMENT </strong></div></td>
                    <td colspan="2"><div align="center"><strong>PSYCHOMOTOR ASSESSMENT</strong></div></td>
                  </tr>
                  <tr>
                    <td width="19%"><strong>Items' Name </strong></td>
                    <td width="28%"><div align="center"><strong>Scores</strong></div></td>
                    <td width="23%"><strong>Items' Name </strong></td>
                    <td width="30%"><div align="center"><strong>Scores</strong></div></td>
                  </tr>
                  <tr>
                    <td>Attentiveness</td>
                    <td><div align="center"><?=$select->at;?></div></td>
                    <td>Club / Society </td>
                    <td><div align="center"><?=$select->cl;?></div></td>
                  </tr>
                  <tr>
                    <td>Honesty</td>
                    <td><div align="center"><?=$select->ho;?></div></td>
                    <td>Drawing and Painting </td>
                    <td><div align="center"><?=$select->dr;?></div></td>
                  </tr>
                  <tr>
                    <td>Neatness</td>
                    <td><div align="center"><?=$select->ne;?></div></td>
                    <td>Hand Writting </td>
                    <td><div align="center"><?=$select->ha;?></div></td>
                  </tr>
                  <tr>
                    <td>Politeness</td>
                    <td><div align="center"><?=$select->po;?></div></td>
                    <td>Hobies</td>
                    <td><div align="center"><?=$select->hob;?></div></td>
                  </tr>
                  <tr>
                    <td>Punchuality</td>
                    <td><div align="center"><?=$select->pu;?></div></td>
                    <td>Speech Fluentcy </td>
                    <td><div align="center"><?=$select->sp;?></div></td>
                  </tr>
                  <tr>
                    <td>Relationship with Others </td>
                    <td><div align="center"><?=$select->re;?></div></td>
                    <td>Sport and Game </td>
                    <td><div align="center"><?=$select->sp;?></div></td>
                  </tr>
                </table>
				<br>
				<table width="100%" border="0">
				  <tr>
					<td style="background:white; color:black" align="center">5 = A(Excellent) 4 = B(V.Good) 3 = C(Good) 2 = D(Pass) 1 = E(Fair) 0 = F(Fail)</td>
				  </tr>
				</table>
				<table width="100%" border="0">
                  <tr>
                    <td width="15%">Form Mater's Comment</td>
                    <td colspan="3"><?=$select->fmc;?></td>
                  </tr>
                  <tr>
                    <td>Form Mater's Name</td>
                    <td><?=$select->fma;?></td>
                    <td>Signature</td>
                    <td><em><strong><?=$select->fma;?></strong><em></td>
                  </tr>
                  <tr>
                    <td>Principal's Comment</td>
                    <td colspan="3"><?=$select->pc;?></td>
                  </tr>
                  <tr>
                    <td>Principal's Name</td>
                    <td width="47%"><?=$this->db->get_where('admin', array('admin_id' => 1))->row()->name;?></td>
                    <td width="7%">Signature</td>
                    <td width="31%"><img src="<?php echo base_url();?>uploads/signature.png" width="150px" height="50px"></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="right"><strong>Next term Begins:</strong> <?=get_settings('next_term_begin')?></td>
                  </tr>
                </table>
			<?php endif;?>	
			
			
			
			
			<?php endif;?>	
			<div class="pagebreak"> </div>
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			<?php if(get_settings('report_template') == 'diamond'):?><!-- START OF DIAMOND TEMPLATE -->
				
				
				
				<?php if($term == 1) : ?><!-- START OF FIRST TERM GENERAL REPORT FOR CA1 AND CA2 AND EXAM REPORT -->
					
					
				<?php if(get_settings('mid_ter_rep_card') == 1):?><!-- START OF CA1 MID TERM REPORT -->
				
				<table width="100%">
				  <tr>
					<td class="pull-left"><img src="<?php echo base_url()?>uploads/logo.png"  height="150" width="150"></td>
					<td>
						<h2 align="center"><?php echo get_settings('system_name')?></h2>
						<p align="center"><strong>MOTTO: HOME WHERE KNOWLEGE SPEAKS</strong><br><strong>Address:</strong> <?php echo get_settings('address')?> <br/>
						<!--<i class="fa fa-envelope"></i> <?php echo get_settings('system_email')?> : <i class="fa fa-phone"></i> <?php echo get_settings('phone')?>--></p>	
					</td>
					<td class="pull-right"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="150" width="150"></td>
				  </tr>		
				</table>

								
				<table width="100%" height="100" border="1">
				  <tr>
					<td width="322" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;PUPIL'S NAME:</strong></span></td>
					<td width="267" class="text-uppercase">&nbsp;<?=$student_selected['name'];?></td>
					<td width="265" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;CLASS:</strong></span></td>
					<td width="69">&nbsp;<?=$class_name;?></td>
					<td width="233" bgcolor="#CC6600"><span class="style2">&nbsp;TERM:</span></td>
					<td width="92">&nbsp;<?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></td>
				  </tr>
				  <tr>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;ADMISSION NO:</strong></span></td>
					<td>&nbsp;<?=$student_selected['roll'];?></td>
					<td bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SEX:</strong></span></td>
					<td>&nbsp;<?=ucwords($student_selected['sex']);?></td>
					<td bgcolor="#CC6600"><span class="style1">&nbsp;<strong>ACADEMIC YEAR:</strong></span></td>
					<td>&nbsp;<?=$session?></td>
				  </tr>
				  <tr>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) SCHOOL OPEN</strong></span></td>
					<td>&nbsp;
				    <?=$this->db->get_where('attendance', array('session' => $session, 
					'term' => $term))->num_rows(); ?></td>
					<td width="265" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) PRESENT:</strong></span></td>
					<td>&nbsp;<?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 1))->num_rows(); 
						?></td>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) ABSENT:</strong></span></td>
					<td><strong>&nbsp;</strong><?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 2))->num_rows(); 
						?></td>
			      </tr>
			</table>
			
				<table width="100%" border="0">
				  <tr>
					<td align="center" bgcolor="#F0F0F0"><span class="style3">CA1 MID-TERM REPORT FOR 
			        <?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?> 
			        <?=$session?> 
				    ACADEMIC SESSION</span></td>
				  </tr>
				  <tr>
				    <td align="center" bgcolor="#CC6600"><span class="style1">SECTION A: SUBJECTS SCORES </span></td>
			      </tr>
				</table>
				<table width="100%"  border="1">
				  <tr>
					<td valign="top"><strong>&nbsp;ACADEMIC<br>&nbsp;SUBJECTS</strong></td>
					
					<td valign="top"><strong>&nbsp;TOTAL<br>&nbsp;CA(100%)</strong> </td>
					<td valign="top"><strong>&nbsp;ARCHIEVED<br>&nbsp;GRADE</strong> </td>
					<td valign="top"><strong><br>&nbsp;POS</strong> </td>
					<td valign="top"><strong><br>&nbsp;OUT OF</strong> </td>
					<td valign="top"><strong><br>&nbsp;MIN SCORE</strong></td>
					<td valign="top"><strong><br>&nbsp;MAX SCORE</strong> </td>
					<td valign="top"><strong><br>&nbsp;CLASS AVG</strong></td>
					<td valign="top"><strong>&nbsp;TARGET<br>&nbsp;GRADE</strong> </td>
					<td valign="top"><br>&nbsp;<strong>REMARKS</strong> </td>
					<!--<td colspan="2" valign="top">&nbsp;<strong>GRADE SUMMARY</strong> &nbsp;<strong></strong> </td>-->
			      </tr>
				  
				  
                    <?php 
						$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
						foreach ($select_subject as $key => $subject):
					?>
					<tr>
					<td valign="top">&nbsp;<?php echo $subject['name'];?></td>
					
                                        <?php 
										$obtained_mark_query = $this->db->get_where('mark', 
											array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 
											'student_id' => $student_id, 'term' => 1));
                                        
										

                                            $class_score_one    = $obtained_mark_query->row()->class_score1;
                                            $class_score_two    = $obtained_mark_query->row()->class_score2;
                                            $class_score_three  = $obtained_mark_query->row()->class_score3;
											$class_score_four  	= $obtained_mark_query->row()->class_score4;
											$class_score_five  	= $obtained_mark_query->row()->class_score5;
											
                                           /*
										    $class_score_one1    = $obtained_mark_query->row()->class_score11;
                                            $class_score_two2    = $obtained_mark_query->row()->class_score22;
                                            $class_score_three3  = $obtained_mark_query->row()->class_score33;
											$class_score_four4   = $obtained_mark_query->row()->class_score44;
											$class_score_five5   = $obtained_mark_query->row()->class_score55;
											*/
											
											$total_ca_score1 = $class_score_one + $class_score_two + $class_score_three + $class_score_four + $class_score_five;
											$total_ca_score1_percentage = ($total_ca_score1 / 20 * 100);
											
											//$total_ca_score2 = $class_score_one1 + $class_score_two2 + $class_score_three3 + $class_score_four4 + $class_score_five5;
											//$total_ca_score2_percentage = ($total_ca_score2 / 25) * 100;
                                            
											
											
											//$exam_score         = $obtained_mark_query->row()->exam_score;
											//$total_CA        	= $class_score_one; + $class_score_two;//+ $class_score_three;
                                            $total_score        = $total_ca_score1_percentage ;
											//+ $total_ca_score2_percentage;
											
											if($total_score == ""){
												$total_score = 0;
											}else{
												$total_score = $total_score;	
											}
                                        
										
											$update['sum_first'] = $total_score;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $update);
										
                                        ?>
					
									<td valign="top">&nbsp;<?php if($total_score == 0)echo '';else echo $total_score;?></td>
									<td valign="top">&nbsp;
												<?php if ($total_score <= '100' && $total_score >= '90'):?>
												<?php echo 'A*';?>
												<?php endif;?>
												
												<?php if ($total_score <= '89' && $total_score >= '80'):?>
												<?php echo 'A';?>
												<?php endif;?>
												
												<?php if ($total_score <= '79' && $total_score >= '70'):?>
												<?php echo 'B';?>
												<?php endif;?>
												
												<?php if ($total_score <= '69' && $total_score >= '60'):?>
												<?php echo 'C';?>
												<?php endif;?>
												
												<?php if ($total_score <= "59" && $total_score >= '50'):?>
												<?php echo 'D';?>
												<?php endif;?>
												
												<?php if ($total_score <= "49" && $total_score >= '40'):?>
												<?php echo 'E';?>
												<?php endif;?>
												
												<?php if ($total_score <= "39" && $total_score >= '30'):?>
												<?php echo 'F';?>
												<?php endif;?>					
									</td>
					
									<td valign="top">&nbsp;
					
										<?php
										
										$subject_id = $subject['subject_id'];
 										$sql = "SELECT mark_id, sum_first, FIND_IN_SET( sum_first,(
												SELECT GROUP_CONCAT( sum_first  ORDER BY sum_first DESC ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND sum_first = $total_score AND sum_first != 0"; 
        
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
					<td valign="top">&nbsp;<?=$number_class?></td>
					
					<td valign="top">&nbsp;
                        <?php echo $lowest_mark = $this->crud_model->get_lowest_marks_first( $exam_id , $class_id , $subject['subject_id'], 1 );?>					
					</td>
					<td valign="top">&nbsp;
						<?php echo $highest_mark = $this->crud_model->get_highest_marks_first( $exam_id , $class_id , $subject['subject_id'], 1 ); ?>					
					</td>

					
					<td valign="top">&nbsp;
					
                                <?php 
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('subject_id', $subject_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;
								}
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'subject_id' => $subject_id))->num_rows();
									
                                ?>	
								<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?>		
					</td>
					<td valign="top">&nbsp;A</td>
					<td valign="top">&nbsp;
					
								<?php if ($total_score <= '100' && $total_score >= '90'):?>
								<?php echo 'EXCELLENT';?>
								<?php endif;?>
								
								<?php if ($total_score <= '89' && $total_score >= '80'):?>
								<?php echo 'VERY GOOD';?>
								<?php endif;?>
								
								<?php if ($total_score <= '79' && $total_score >= '70'):?>
								<?php echo 'GOOD';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'CREDIT';?>
								<?php endif;?>
								
								<?php if ($total_score <= "59" && $total_score >= '50'):?>
								<?php echo 'PASS';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>
								<?php echo 'FAIL';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '30'):?>
								<?php echo 'FAIL';?>
								<?php endif;?>
					<?php //echo $obtained_mark_query->row()->ca1_comment;?>
					</td>
						<!--
							<td valign="top">&nbsp;A</td>
							<td valign="top">&nbsp;1</td>
						-->
				  </tr>
				  <?php endforeach;?>
				</table>
				<table width="100%" border="0">
				  <tr>
					<td style="background:white; color:black"><span class="pull-left"><strong>GRADE SUMMARY</strong>:</span><span class="pull-right"><strong>Number of Subject Offered: 
					
						<?php
						
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered2 = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'student_id' => $student_id))->num_rows();
								echo $getSubjectNumbered2;
						?>
					</strong> </span><br>
					A* = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 'student_id' => $student_id, 'sum_first>=' => 90, 'sum_first<=' => 100))->num_rows();?>
					A = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 'student_id' => $student_id, 'sum_first>=' => 80, 'sum_first<=' => 89))->num_rows();?>
					B = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 'student_id' => $student_id, 'sum_first>=' => 70, 'sum_first<=' => 79))->num_rows();?>
					C = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 'student_id' => $student_id, 'sum_first>=' => 60, 'sum_first<=' => 69))->num_rows();?>
					D = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 'student_id' => $student_id, 'sum_first>=' => 50, 'sum_first<=' => 59))->num_rows();?>
					E = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 'student_id' => $student_id, 'sum_first>=' => 40, 'sum_first<=' => 49))->num_rows();?>
					F = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 'student_id' => $student_id, 'sum_first>=' => 30, 'sum_first<=' => 39))->num_rows();?> 
					</td>
				  </tr>
				  
				
				<table width="100%" border="1">
				  <tr>
					<td width="186"><strong>&nbsp;Class Position:</strong></td>
					<td width="89" class="text-uppercase">&nbsp;
					
					
										<?php
										
										
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'student_id' => $student_id))->num_rows();
									
									
									$updatePercetangeFirst = round($sumTotalOfFirstScore/$getSubjectNumbered);
									if(is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = 0;
									}
									if(!is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = $updatePercetangeFirst;
									}
											
											$class_position_ca1['class_position_ca1'] = $updatePercetangeFirst;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $class_position_ca1);
										
										
										
										
 										$sql = "SELECT mark_id, class_position_ca1, FIND_IN_SET( class_position_ca1,(
												SELECT GROUP_CONCAT( class_position_ca1  ORDER BY class_position_ca1 desc ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND class_position_ca1 = $updatePercetangeFirst AND class_position_ca1 != 0"; 
        
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
					<td width="155"><strong>&nbsp;Total Score:</strong></td>
					<td width="119">&nbsp;
								<?php
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
									if($sumTotalOfFirstScore == ""){
										echo $sumTotalOfFirstScore = 0;
									}else{
										echo $sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
							?>					
					</td>
					<td colspan="2"><strong>&nbsp;<strong>Final Average</strong>:</strong></td>
					<td width="171">&nbsp;
					<?php 
					
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
									if($sumTotalOfFirstScore == ""){
										$sumTotalOfFirstScore = 0;
									}else{
										$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
								
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'student_id' => $student_id))->num_rows();		
					?>
					
					<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?> %					
					</td>
				    <td width="">&nbsp;<strong>Final Grade</strong> </td>
				    <td width="75">&nbsp;
								<?php $FindGrade = round($sumTotalOfFirstScore /$getSubjectNumbered,2);?>
								<?php if ($FindGrade <= '100' && $FindGrade >= '90'):?>
								<?php echo 'A*';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '89' && $FindGrade >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '79' && $FindGrade >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '69' && $FindGrade >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "59" && $FindGrade >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "49" && $FindGrade >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "39" && $FindGrade >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					
					</td>
				  </tr>
				</table>
				
				
				
					<?php 
						$select = $this->db->get_where('diamond_stu_comment', array('student_id' => $student_id, 'session' => $session, 'term' => $term, 'status' => 1))->row();
					?>
				<table width="100%" border="1">
				  <tr>
					<td colspan="6" bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SECTION B: EFFECTIVE GENERAL BEHAVIOUR</strong></span></td>
					<td colspan="6" bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SECTION C: (PSYCHOMOTOR) SKILL </strong></span></td>
				  </tr>
				  <tr>
				    <td width="249">&nbsp;</td>
				    <td width="104"><strong>&nbsp;5</strong></td>
				    <td width="61" class="text-uppercase"><strong>&nbsp;4</strong></td>
				    <td width="51"><strong>&nbsp;3</strong></td>
				    <td width="58"><strong>&nbsp;2</strong></td>
				    <td width="66"><strong>&nbsp;1</strong></td>
				    <td width="297">&nbsp;</td>
				    <td width="70"><strong>&nbsp;5</strong></td>
				    <td width="69"><strong>&nbsp;4</strong></td>
				    <td width="62"><strong>&nbsp;3</strong></td>
				    <td width="65"><strong>&nbsp;2</strong></td>
				    <td width="60"><strong>&nbsp;1</strong></td>
			      </tr>
				  <tr>
				    <td width="249">&nbsp;PUNCTUALITY</td>
				    <td>&nbsp;<?php if($select->pu == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;HANDWRITING</td>
				    <td>&nbsp;<?php if($select->han == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;CLASSROOM ATTENDANCE</td>
				    <td>&nbsp;<?php if($select->cl == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;FLUENCY</td>
				    <td>&nbsp;<?php if($select->fl == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;CARRYING OUT ASSIGNMENT</td>
				    <td>&nbsp;<?php if($select->car == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;GAMES</td>
				    <td>&nbsp;<?php if($select->ga == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;NEATNESS</td>
				    <td>&nbsp;<?php if($select->ne == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;SPORTS</td>
				    <td>&nbsp;<?php if($select->sp == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;POLITENESS</td>
				    <td>&nbsp;<?php if($select->po == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;GYMNASTICS</td>
				    <td>&nbsp;<?php if($select->gy == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;HONESTY</td>
				    <td>&nbsp;<?php if($select->ho == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;DRAWING &amp; PAINTING</td>
				    <td>&nbsp;<?php if($select->dr == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;SELF CONTROL</td>
				    <td>&nbsp;<?php if($select->se == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;MUSICAL PERFORMANCE</td>
				    <td>&nbsp;<?php if($select->mu == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;RELATIONSHIP WITH OTHERS</td>
				    <td>&nbsp;<?php if($select->re == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;HANDLING TOOLS</td>
				    <td>&nbsp;<?php if($select->ha == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;SENSE OF RESPONSIBILITY</td>
				    <td>&nbsp;<?php if($select->sen == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;CRAFTS</td>
				    <td>&nbsp;<?php if($select->cr == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;OBEDIENCE</td>
				    <td>&nbsp;<?php if($select->ob == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;INITIATIVE</td>
				    <td>&nbsp;<?php if($select->ini == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;ORGANISATIONAL ABILITY</td>
				    <td>&nbsp;<?php if($select->org == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td colspan="8">&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong>KEY TO GRADES</strong></td>
				    <td>&nbsp;</td>
				    <td rowspan="6" class="text-uppercase">&nbsp;</td>
				    <td colspan="4">&nbsp;<strong>KEY TO RATINGS (SECTIONS B AND C)</strong></td>
				    <td colspan="5" rowspan="6">&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;A</td>
				    <td>&nbsp;80 - 100%</td>
				    <td>&nbsp;5</td>
				    <td colspan="3">&nbsp;Maintains an excellent degree of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;B</td>
				    <td>&nbsp;70 - 79%</td>
				    <td>&nbsp;4</td>
				    <td colspan="3">&nbsp;Maintains a high level of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;C</td>
				    <td>&nbsp;60 - 69% </td>
				    <td>&nbsp;3</td>
				    <td colspan="3">&nbsp;Acceptable level of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;P</td>
				    <td>&nbsp;50 - 59% </td>
				    <td>&nbsp;2</td>
				    <td colspan="3">&nbsp;Shows minimal regard for observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;E</td>
				    <td>&nbsp;40 - 49%</td>
				    <td>&nbsp;1</td>
				    <td colspan="3">&nbsp;Has no regard for obsevrable traits</td>
			      </tr>
				  <tr>
				    <td><span class="style4">&nbsp;F</span></td>
				    <td><span class="style4">&nbsp;0 - 39%</span></td>
				    <td colspan="10" class="text-uppercase">&nbsp;</td>
		          </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Head Teacher / Principal's Comment</em></strong></td>
				    <td colspan="11">&nbsp;<?=$select->p_comment;?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Teacher's Comment</em></strong></td>
				    <td colspan="11">&nbsp;<?=$select->tcomment;?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Signature</em></strong></td>
				    <td colspan="11">&nbsp;<img src="<?php echo base_url();?>uploads/signature.png" width="150px" height="50px"></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Date</em></strong></td>
				    <td colspan="11">&nbsp;<?=date('d, M Y')?><span class="float-right"><strong>Next Term Begins:</strong></strong> <?=get_settings('next_term_begin')?></span></td>
			      </tr>
				</table>
				<?php endif;?>	<!-- END OF CA1 MID TERM REPORT -->
				
				

				
				<?php if(get_settings('mid_ter_rep_card') == 2):?><!-- START OF CA2 MID TERM REPORT -->
				
				<table width="100%">
				  <tr>
					<td class="pull-left"><img src="<?php echo base_url()?>uploads/logo.png"  height="150" width="150"></td>
					<td>
						<h2 align="center"><?php echo get_settings('system_name')?></h2>
						<p align="center"><strong>MOTTO: HOME WHERE KNOWLEGE SPEAKS</strong><br><strong>Address:</strong> <?php echo get_settings('address')?> <br/>
						<!--<i class="fa fa-envelope"></i> <?php echo get_settings('system_email')?> : <i class="fa fa-phone"></i> <?php echo get_settings('phone')?>--></p>	
					</td>
					<td class="pull-right"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="150" width="150"></td>
				  </tr>		
				</table>

								
				<table width="100%" height="100" border="1">
				  <tr>
					<td width="322" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;PUPIL'S NAME:</strong></span></td>
					<td width="267" class="text-uppercase">&nbsp;<?=$student_selected['name'];?></td>
					<td width="265" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;CLASS:</strong></span></td>
					<td width="69">&nbsp;<?=$class_name;?></td>
					<td width="233" bgcolor="#CC6600"><span class="style2">&nbsp;TERM:</span></td>
					<td width="92">&nbsp;<?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></td>
				  </tr>
				  <tr>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;ADMISSION NO:</strong></span></td>
					<td>&nbsp;<?=$student_selected['roll'];?></td>
					<td bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SEX:</strong></span></td>
					<td>&nbsp;<?=ucwords($student_selected['sex']);?></td>
					<td bgcolor="#CC6600"><span class="style1">&nbsp;<strong>ACADEMIC YEAR:</strong></span></td>
					<td>&nbsp;<?=$session?></td>
				  </tr>
				  <tr>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) SCHOOL OPEN</strong></span></td>
					<td>&nbsp;
				    <?=$this->db->get_where('attendance', array('session' => $session, 
					'term' => $term))->num_rows(); ?></td>
					<td width="265" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) PRESENT:</strong></span></td>
					<td>&nbsp;<?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 1))->num_rows(); 
						?></td>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) ABSENT:</strong></span></td>
					<td><strong>&nbsp;</strong><?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 2))->num_rows(); 
						?></td>
			      </tr>
			</table>
			
				<table width="100%" border="0">
				  <tr>
					<td align="center" bgcolor="#F0F0F0"><span class="style3">CA2 MID-TERM REPORT FOR 
			        <?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?> 
			        <?=$session?> 
				    ACADEMIC SESSION</span></td>
				  </tr>
				  <tr>
				    <td align="center" bgcolor="#CC6600"><span class="style1">SECTION A: SUBJECTS SCORES </span></td>
			      </tr>
				</table>
				<table width="100%"  border="1">
				  <tr>
					<td valign="top"><strong>&nbsp;ACADEMIC<br>&nbsp;SUBJECTS</strong></td>
					
					<td valign="top"><strong>&nbsp;TOTAL<br>&nbsp;CA(100%)</strong> </td>
					<td valign="top"><strong>&nbsp;ARCHIEVED<br>&nbsp;GRADE</strong> </td>
					<td valign="top"><strong><br>&nbsp;POS</strong> </td>
					<td valign="top"><strong><br>&nbsp;OUT OF</strong> </td>
					<td valign="top"><strong><br>&nbsp;MIN SCORE</strong></td>
					<td valign="top"><strong><br>&nbsp;MAX SCORE</strong> </td>
					<td valign="top"><strong><br>&nbsp;CLASS AVG</strong></td>
					<td valign="top"><strong>&nbsp;TARGET<br>&nbsp;GRADE</strong> </td>
					<td valign="top"><br>&nbsp;<strong>REMARKS</strong> </td>
					<!--<td colspan="2" valign="top">&nbsp;<strong>GRADE SUMMARY</strong> &nbsp;<strong></strong> </td>-->
			      </tr>
				  
				  
                    <?php 
						$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
						foreach ($select_subject as $key => $subject):
					?>
					<tr>
					<td valign="top">&nbsp;<?php echo $subject['name'];?></td>
					
                                        <?php 
										$obtained_mark_query = $this->db->get_where('mark', 
											array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 
											'student_id' => $student_id, 'term' => 1));
                                        
										

                                            /*$class_score_one    = $obtained_mark_query->row()->class_score1;
                                            $class_score_two    = $obtained_mark_query->row()->class_score2;
                                            $class_score_three  = $obtained_mark_query->row()->class_score3;
											$class_score_four  	= $obtained_mark_query->row()->class_score4;
											$class_score_five  	= $obtained_mark_query->row()->class_score5;
											*/
                                           
										    $class_score_one1    = $obtained_mark_query->row()->class_score11;
                                            $class_score_two2    = $obtained_mark_query->row()->class_score22;
                                            $class_score_three3  = $obtained_mark_query->row()->class_score33;
											$class_score_four4   = $obtained_mark_query->row()->class_score44;
											$class_score_five5   = $obtained_mark_query->row()->class_score55;
											
											
											$total_ca_score2 = $class_score_one1 + $class_score_two2 + $class_score_three3 + $class_score_four4 + $class_score_five5;
											$total_ca_score2_percentage = ($total_ca_score2 / 20 * 100);
											
											//$total_ca_score2 = $class_score_one1 + $class_score_two2 + $class_score_three3 + $class_score_four4 + $class_score_five5;
											//$total_ca_score2_percentage = ($total_ca_score2 / 25) * 100;
                                            
											
											
											//$exam_score         = $obtained_mark_query->row()->exam_score;
											//$total_CA        	= $class_score_one; + $class_score_two;//+ $class_score_three;
                                            $total_score        = $total_ca_score2_percentage ;//+ $total_ca_score2_percentage;
											
											if($total_score == ""){
												$total_score = 0;
											}else{
												$total_score = $total_score;	
											}
                                        
										
											$update['sum_first'] = $total_score;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $update);
										
                                        ?>
					
					<td valign="top">&nbsp;<?php if($total_score == 0)echo '';else echo $total_score;?></td>
					<td valign="top">&nbsp;
								<?php if ($total_score <= '100' && $total_score >= '90'):?>
								<?php echo 'A*';?>
								<?php endif;?>
								
								<?php if ($total_score <= '89' && $total_score >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($total_score <= '79' && $total_score >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($total_score <= "59" && $total_score >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>					
					</td>
					
					<td valign="top">&nbsp;
					
										<?php
										
										$subject_id = $subject['subject_id'];
 										$sql = "SELECT mark_id, sum_first, FIND_IN_SET( sum_first,(
												SELECT GROUP_CONCAT( sum_first  ORDER BY sum_first DESC ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND sum_first = $total_score AND sum_first != 0"; 
        
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
					<td valign="top">&nbsp;<?=$number_class?></td>
					
					<td valign="top">&nbsp;
                        <?php echo $lowest_mark = $this->crud_model->get_lowest_marks_first( $exam_id , $class_id , $subject['subject_id'], 1 );?>					
					</td>
					<td valign="top">&nbsp;
						<?php echo $highest_mark = $this->crud_model->get_highest_marks_first( $exam_id , $class_id , $subject['subject_id'], 1 ); ?>					
					</td>

					
					<td valign="top">&nbsp;
					
                                <?php 
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('subject_id', $subject_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'subject_id' => $subject_id))->num_rows();
									
                                ?>	
								<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?>		
					</td>
					<td valign="top">&nbsp;A</td>
					<td valign="top">&nbsp;
					
								<?php if ($total_score <= '100' && $total_score >= '90'):?>
								<?php echo 'EXCELLENT';?>
								<?php endif;?>
								
								<?php if ($total_score <= '89' && $total_score >= '80'):?>
								<?php echo 'VERY GOOD';?>
								<?php endif;?>
								
								<?php if ($total_score <= '79' && $total_score >= '70'):?>
								<?php echo 'GOOD';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'CREDIT';?>
								<?php endif;?>
								
								<?php if ($total_score <= "59" && $total_score >= '50'):?>
								<?php echo 'PASS';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>
								<?php echo 'FAIL';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '30'):?>
								<?php echo 'FAIL';?>
								<?php endif;?>
					<?php //echo $obtained_mark_query->row()->ca1_comment;?>
					</td>
					<!--
					<td valign="top">&nbsp;A</td>
					<td valign="top">&nbsp;1</td>
					-->
				  </tr>
				  <?php endforeach;?>
				</table>
				<table width="100%" border="0">
				  <tr>
					<td style="background:white; color:black"><span class="pull-left"><strong>GRADE SUMMARY</strong>:</span><span class="pull-right"><strong>Number of Subject Offered: 
					
						<?php
						
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered2 = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'student_id' => $student_id))->num_rows();
								echo $getSubjectNumbered2;
						?>
					</strong> </span><br>
					A* = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 'student_id' => $student_id, 'sum_first>=' => 90, 'sum_first<=' => 100))->num_rows();?>
					A = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 'student_id' => $student_id, 'sum_first>=' => 80, 'sum_first<=' => 89))->num_rows();?>
					B = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 'student_id' => $student_id, 'sum_first>=' => 70, 'sum_first<=' => 79))->num_rows();?>
					C = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 'student_id' => $student_id, 'sum_first>=' => 60, 'sum_first<=' => 69))->num_rows();?>
					D = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 'student_id' => $student_id, 'sum_first>=' => 50, 'sum_first<=' => 59))->num_rows();?>
					E = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 'student_id' => $student_id, 'sum_first>=' => 40, 'sum_first<=' => 49))->num_rows();?>
					F = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 'student_id' => $student_id, 'sum_first>=' => 30, 'sum_first<=' => 39))->num_rows();?> 
					</td>
				  </tr>
				  
				
				<table width="100%" border="1">
				  <tr>
					<td width="186"><strong>&nbsp;Class Position:</strong></td>
					<td width="89" class="text-uppercase">&nbsp;
					
					
										<?php
										
										
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'student_id' => $student_id))->num_rows();
									
									
									$updatePercetangeFirst = round($sumTotalOfFirstScore/$getSubjectNumbered);
									if(is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = 0;
									}
									if(!is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = $updatePercetangeFirst;
									}
											
											$class_position_ca2['class_position_ca2'] = $updatePercetangeFirst;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $class_position_ca2);
										
										
										
										
 										$sql = "SELECT mark_id, class_position_ca2, FIND_IN_SET( class_position_ca2,(
												SELECT GROUP_CONCAT( class_position_ca2  ORDER BY class_position_ca2 desc ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND class_position_ca2 = $updatePercetangeFirst AND class_position_ca2 != 0"; 
        
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
					<td width="155"><strong>&nbsp;Total Score:</strong></td>
					<td width="119">&nbsp;
								<?php
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
									if($sumTotalOfFirstScore == ""){
										echo $sumTotalOfFirstScore = 0;
									}else{
										echo $sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
							?>					
					</td>
					<td colspan="2"><strong>&nbsp;<strong>Final Average</strong>:</strong></td>
					<td width="171">&nbsp;
					<?php 
					
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
									if($sumTotalOfFirstScore == ""){
										$sumTotalOfFirstScore = 0;
									}else{
										$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
								
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'student_id' => $student_id))->num_rows();		
					?>
					
					<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?> %					
					</td>
				    <td width="">&nbsp;<strong>Final Grade</strong> </td>
				    <td width="75">&nbsp;
								<?php $FindGrade = round($sumTotalOfFirstScore /$getSubjectNumbered,2);?>
								<?php if ($FindGrade <= '100' && $FindGrade >= '90'):?>
								<?php echo 'A*';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '89' && $FindGrade >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '79' && $FindGrade >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '69' && $FindGrade >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "59" && $FindGrade >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "49" && $FindGrade >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "39" && $FindGrade >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					
					</td>
				  </tr>
				</table>
				
				
				
					<?php 
						$session = $session;
						$select = $this->db->get_where('diamond_stu_comment', array('student_id' => $student_id, 'session' => $session, 'term' => $term, 'status' => 2))->row();
					?>
				<table width="100%" border="1">
				  <tr>
					<td colspan="6" bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SECTION B: EFFECTIVE GENERAL BEHAVIOUR</strong></span></td>
					<td colspan="6" bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SECTION C: (PSYCHOMOTOR) SKILL </strong></span></td>
				  </tr>
				  <tr>
				    <td width="249">&nbsp;</td>
				    <td width="104"><strong>&nbsp;5</strong></td>
				    <td width="61" class="text-uppercase"><strong>&nbsp;4</strong></td>
				    <td width="51"><strong>&nbsp;3</strong></td>
				    <td width="58"><strong>&nbsp;2</strong></td>
				    <td width="66"><strong>&nbsp;1</strong></td>
				    <td width="297">&nbsp;</td>
				    <td width="70"><strong>&nbsp;5</strong></td>
				    <td width="69"><strong>&nbsp;4</strong></td>
				    <td width="62"><strong>&nbsp;3</strong></td>
				    <td width="65"><strong>&nbsp;2</strong></td>
				    <td width="60"><strong>&nbsp;1</strong></td>
			      </tr>
				  <tr>
				    <td width="249">&nbsp;PUNCTUALITY</td>
				    <td>&nbsp;<?php if($select->pu == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;HANDWRITING</td>
				    <td>&nbsp;<?php if($select->han == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;CLASSROOM ATTENDANCE</td>
				    <td>&nbsp;<?php if($select->cl == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;FLUENCY</td>
				    <td>&nbsp;<?php if($select->fl == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;CARRYING OUT ASSIGNMENT</td>
				    <td>&nbsp;<?php if($select->car == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;GAMES</td>
				    <td>&nbsp;<?php if($select->ga == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;NEATNESS</td>
				    <td>&nbsp;<?php if($select->ne == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;SPORTS</td>
				    <td>&nbsp;<?php if($select->sp == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;POLITENESS</td>
				    <td>&nbsp;<?php if($select->po == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;GYMNASTICS</td>
				    <td>&nbsp;<?php if($select->gy == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;HONESTY</td>
				    <td>&nbsp;<?php if($select->ho == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;DRAWING &amp; PAINTING</td>
				    <td>&nbsp;<?php if($select->dr == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;SELF CONTROL</td>
				    <td>&nbsp;<?php if($select->se == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;MUSICAL PERFORMANCE</td>
				    <td>&nbsp;<?php if($select->mu == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;RELATIONSHIP WITH OTHERS</td>
				    <td>&nbsp;<?php if($select->re == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;HANDLING TOOLS</td>
				    <td>&nbsp;<?php if($select->ha == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;SENSE OF RESPONSIBILITY</td>
				    <td>&nbsp;<?php if($select->sen == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;CRAFTS</td>
				    <td>&nbsp;<?php if($select->cr == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;OBEDIENCE</td>
				    <td>&nbsp;<?php if($select->ob == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;INITIATIVE</td>
				    <td>&nbsp;<?php if($select->ini == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;ORGANISATIONAL ABILITY</td>
				    <td>&nbsp;<?php if($select->org == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td colspan="8">&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong>KEY TO GRADES</strong></td>
				    <td>&nbsp;</td>
				    <td rowspan="6" class="text-uppercase">&nbsp;</td>
				    <td colspan="4">&nbsp;<strong>KEY TO RATINGS (SECTIONS B AND C)</strong></td>
				    <td colspan="5" rowspan="6">&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;A</td>
				    <td>&nbsp;80 - 100%</td>
				    <td>&nbsp;5</td>
				    <td colspan="3">&nbsp;Maintains an excellent degree of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;B</td>
				    <td>&nbsp;70 - 79%</td>
				    <td>&nbsp;4</td>
				    <td colspan="3">&nbsp;Maintains a high level of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;C</td>
				    <td>&nbsp;60 - 69% </td>
				    <td>&nbsp;3</td>
				    <td colspan="3">&nbsp;Acceptable level of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;P</td>
				    <td>&nbsp;50 - 59% </td>
				    <td>&nbsp;2</td>
				    <td colspan="3">&nbsp;Shows minimal regard for observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;E</td>
				    <td>&nbsp;40 - 49%</td>
				    <td>&nbsp;1</td>
				    <td colspan="3">&nbsp;Has no regard for obsevrable traits</td>
			      </tr>
				  <tr>
				    <td><span class="style4">&nbsp;F</span></td>
				    <td><span class="style4">&nbsp;0 - 39%</span></td>
				    <td colspan="10" class="text-uppercase">&nbsp;</td>
		          </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Head Teacher / Principal's Comment</em></strong></td>
				    <td colspan="11">&nbsp;<?=$select->p_comment;?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Teacher's Comment</em></strong></td>
				    <td colspan="11">&nbsp;<?=$select->tcomment;?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Signature</em></strong></td>
				    <td colspan="11">&nbsp;<img src="<?php echo base_url();?>uploads/signature.png" width="150px" height="50px"></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Date</em></strong></td>
				    <td colspan="11">&nbsp;<?=date('d, M Y')?><span class="float-right"><strong>Next Term Begins:</strong></strong> <?=get_settings('next_term_begin')?></span></td>
			      </tr>
				</table>
				
				<?php endif;?>	<!-- END OF CA2 MID TERM REPORT -->
				
				
				
				<?php if(get_settings('mid_ter_rep_card') == 3):?><!-- START OF TERMINAL REPORT THAT CONTAING CA1 AND CA2 AND EXAM SCORES -->
				
				<table width="100%">
				  <tr>
					<td class="pull-left"><img src="<?php echo base_url()?>uploads/logo.png"  height="150" width="150"></td>
					<td>
						<h2 align="center"><?php echo get_settings('system_name')?></h2>
						<p align="center"><strong>MOTTO: HOME WHERE KNOWLEGE SPEAKS</strong><br><strong>Address:</strong> <?php echo get_settings('address')?> <br/>
						<!--<i class="fa fa-envelope"></i> <?php echo get_settings('system_email')?> : <i class="fa fa-phone"></i> <?php echo get_settings('phone')?>--></p>	
					</td>
					<td class="pull-right"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="150" width="150"></td>
				  </tr>		
				</table>

								
				<table width="100%" height="100" border="1">
				  <tr>
					<td width="322" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;PUPIL'S NAME:</strong></span></td>
					<td width="267" class="text-uppercase">&nbsp;<?=$student_selected['name'];?></td>
					<td width="265" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;CLASS:</strong></span></td>
					<td width="69">&nbsp;<?=$class_name;?></td>
					<td width="233" bgcolor="#CC6600"><span class="style2">&nbsp;TERM:</span></td>
					<td width="92">&nbsp;<?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></td>
				  </tr>
				  <tr>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;ADMISSION NO:</strong></span></td>
					<td>&nbsp;<?=$student_selected['roll'];?></td>
					<td bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SEX:</strong></span></td>
					<td>&nbsp;<?=ucwords($student_selected['sex']);?></td>
					<td bgcolor="#CC6600"><span class="style1">&nbsp;<strong>ACADEMIC YEAR:</strong></span></td>
					<td>&nbsp;<?=$session?></td>
				  </tr>
				  <tr>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) SCHOOL OPEN</strong></span></td>
					<td>&nbsp;
				    <?=$this->db->get_where('attendance', array('session' => $session, 
					'term' => $term))->num_rows(); ?></td>
					<td width="265" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) PRESENT:</strong></span></td>
					<td>&nbsp;<?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 1))->num_rows(); 
						?></td>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) ABSENT:</strong></span></td>
					<td><strong>&nbsp;</strong><?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 2))->num_rows(); 
						?></td>
			      </tr>
			</table>
			
				<table width="100%" border="0">
				  <tr>
					<td align="center" bgcolor="#F0F0F0"><span class="style3">TERMINAL REPORT FOR 
			        <?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?> 
			        <?=$session?> 
				    ACADEMIC SESSION</span></td>
				  </tr>
				  <tr>
				    <td align="center" bgcolor="#CC6600"><span class="style1">SECTION A: SUBJECTS SCORES </span></td>
			      </tr>
				</table>
				<table width="100%"  border="1">
				  <tr>
					<td valign="top"><strong>&nbsp;ACADEMIC<br>&nbsp;SUBJECTS</strong></td>
					
					<td valign="top"><strong>&nbsp;CA</strong> </td>
					<td valign="top"><strong>&nbsp;EXAM</strong> </td>
					<td valign="top"><strong>&nbsp;TOTAL</strong> </td>
					<td valign="top"><strong>&nbsp;ARCHIEVED<br>&nbsp;GRADE</strong> </td>
					<td valign="top"><strong><br>&nbsp;POS</strong> </td>
					<td valign="top"><strong><br>&nbsp;OUT OF</strong> </td>
					<td valign="top"><strong><br>&nbsp;MIN SCORE</strong></td>
					<td valign="top"><strong><br>&nbsp;MAX SCORE</strong> </td>
					<td valign="top"><strong><br>&nbsp;CLASS AVG</strong></td>
					<td valign="top"><br>&nbsp;<strong>REMARKS</strong> </td>
					<!--<td colspan="2" valign="top">&nbsp;<strong>GRADE SUMMARY</strong> &nbsp;<strong></strong> </td>-->
			      </tr>
				  
				  
<?php 
						$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
						foreach ($select_subject as $key => $subject):
					?>
					<tr>
					<td valign="top">&nbsp;<?php echo $subject['name'];?></td>
					
                                        <?php 
										$obtained_mark_query = $this->db->get_where('mark', 
											array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 
											'student_id' => $student_id, 'term' => 1));
                                        
										

                                            $class_score_one    = $obtained_mark_query->row()->class_score1;
                                            $class_score_two    = $obtained_mark_query->row()->class_score2;
                                            $class_score_three  = $obtained_mark_query->row()->class_score3;
											$class_score_four  	= $obtained_mark_query->row()->class_score4;
											$class_score_five  	= $obtained_mark_query->row()->class_score5;
											
                                          
										    $class_score_one1    = $obtained_mark_query->row()->class_score11;
                                            $class_score_two2    = $obtained_mark_query->row()->class_score22;
                                            $class_score_three3  = $obtained_mark_query->row()->class_score33;
											$class_score_four4   = $obtained_mark_query->row()->class_score44;
											$class_score_five5   = $obtained_mark_query->row()->class_score55;
											
											$total_ca_score1 = $class_score_one + $class_score_two + $class_score_three + $class_score_four + $class_score_five;
											$total_ca_score2 = $class_score_one1 + $class_score_two2 + $class_score_three3 + $class_score_four4 + $class_score_five5;
											$total_ca_score1_and_two = $total_ca_score1 + $total_ca_score2;
											
											$exam_score         = $obtained_mark_query->row()->exam_score;
                                            $total_score        = $total_ca_score1_and_two + $exam_score;
											
											if($total_score == ""){
												$total_score = 0;
											}else{
												$total_score = $total_score;	
											}
                                        
										
											$update['sum_first'] = $total_score;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $update);
										
                                        ?>
					<td valign="top">&nbsp;<?php if($total_ca_score1_and_two == 0)echo '';else echo $total_ca_score1_and_two;?></td>
					<td valign="top">&nbsp;<?php if($exam_score == 0)echo '';else echo $exam_score;?></td>
					<td valign="top">&nbsp;<?php if($total_score == 0)echo '';else echo $total_score;?></td>
					<td valign="top">&nbsp;
								<?php if ($total_score <= '100' && $total_score >= '90'):?>
								<?php echo 'A*';?>
								<?php endif;?>
								
								<?php if ($total_score <= '89' && $total_score >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($total_score <= '79' && $total_score >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($total_score <= "59" && $total_score >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>					
					</td>
					
					<td valign="top">&nbsp;
					
										<?php
										
										$subject_id = $subject['subject_id'];
 										$sql = "SELECT mark_id, sum_first, FIND_IN_SET( sum_first,(
												SELECT GROUP_CONCAT( sum_first  ORDER BY sum_first DESC ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND sum_first = $total_score AND sum_first != 0"; 
        
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
					<td valign="top">&nbsp;<?=$number_class?></td>
					
					<td valign="top">&nbsp;
                        <?php echo $lowest_mark = $this->crud_model->get_lowest_marks_first( $exam_id , $class_id , $subject['subject_id'], 1 );?>					
					</td>
					<td valign="top">&nbsp;
						<?php echo $highest_mark = $this->crud_model->get_highest_marks_first( $exam_id , $class_id , $subject['subject_id'], 1 ); ?>					
					</td>

					
					<td valign="top">&nbsp;
					
                              <?php 
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('subject_id', $subject_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'subject_id' => $subject_id))->num_rows();
                                ?>	
								<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?>		
					</td>
					<td valign="top">&nbsp;
					
								<?php if ($total_score <= '100' && $total_score >= '90'):?>
								<?php echo 'EXCELLENT';?>
								<?php endif;?>
								
								<?php if ($total_score <= '89' && $total_score >= '80'):?>
								<?php echo 'VERY GOOD';?>
								<?php endif;?>
								
								<?php if ($total_score <= '79' && $total_score >= '70'):?>
								<?php echo 'GOOD';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'CREDIT';?>
								<?php endif;?>
								
								<?php if ($total_score <= "59" && $total_score >= '50'):?>
								<?php echo 'PASS';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>
								<?php echo 'FAIL';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '30'):?>
								<?php echo 'FAIL';?>
								<?php endif;?>
					
					</td>
					
				  </tr>
				  <?php endforeach;?>
				</table>
				<table width="100%" border="0">
				  <tr>
					<td style="background:white; color:black"><span class="pull-left"><strong>GRADE SUMMARY</strong>:</span><span class="pull-right"><strong>Number of Subject Offered: 
					
						<?php
						
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered2 = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'student_id' => $student_id))->num_rows();
								echo $getSubjectNumbered2;
						?>
					</strong> </span><br>
					A* = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 'student_id' => $student_id, 'sum_first>=' => 90, 'sum_first<=' => 100))->num_rows();?>
					A = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 'student_id' => $student_id, 'sum_first>=' => 80, 'sum_first<=' => 89))->num_rows();?>
					B = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 'student_id' => $student_id, 'sum_first>=' => 70, 'sum_first<=' => 79))->num_rows();?>
					C = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 'student_id' => $student_id, 'sum_first>=' => 60, 'sum_first<=' => 69))->num_rows();?>
					D = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 'student_id' => $student_id, 'sum_first>=' => 50, 'sum_first<=' => 59))->num_rows();?>
					E = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 'student_id' => $student_id, 'sum_first>=' => 40, 'sum_first<=' => 49))->num_rows();?>
					F = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 'student_id' => $student_id, 'sum_first>=' => 30, 'sum_first<=' => 39))->num_rows();?> 
					</td>
				  </tr>
				  
				
				<table width="100%" border="1">
				  <tr>
					<td width="186"><strong>&nbsp;Class Position:</strong></td>
					<td width="89" class="text-uppercase">&nbsp;
					
					
										<?php
										
										
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'student_id' => $student_id))->num_rows();
									
									
									$updatePercetangeFirst = round($sumTotalOfFirstScore/$getSubjectNumbered);
									if(is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = 0;
									}
									if(!is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = $updatePercetangeFirst;
									}
											
											$class_position_first['class_position_first'] = $updatePercetangeFirst;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $class_position_first);
										
										
										
										
 										$sql = "SELECT mark_id, class_position_first, FIND_IN_SET( class_position_first,(
												SELECT GROUP_CONCAT( class_position_first  ORDER BY class_position_first desc ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND class_position_first = $updatePercetangeFirst AND class_position_first != 0"; 
        
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
					<td width="155"><strong>&nbsp;Total Score:</strong></td>
					<td width="119">&nbsp;
								<?php
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
									if($sumTotalOfFirstScore == ""){
										echo $sumTotalOfFirstScore = 0;
									}else{
										echo $sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
							?>					
					</td>
					<td colspan="2"><strong>&nbsp;<strong>Final Average</strong>:</strong></td>
					<td width="171">&nbsp;
					<?php 
					
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
									if($sumTotalOfFirstScore == ""){
										$sumTotalOfFirstScore = 0;
									}else{
										$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
								
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'student_id' => $student_id))->num_rows();		
					?>
					
					<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?> %					
					</td>
				    <td width="">&nbsp;<strong>Final Grade</strong> </td>
				    <td width="75">&nbsp;
								<?php $FindGrade = round($sumTotalOfFirstScore /$getSubjectNumbered,2);?>
								<?php if ($FindGrade <= '100' && $FindGrade >= '90'):?>
								<?php echo 'A*';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '89' && $FindGrade >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '79' && $FindGrade >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '69' && $FindGrade >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "59" && $FindGrade >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "49" && $FindGrade >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "39" && $FindGrade >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					
					</td>
				  </tr>
				</table>
				
				
				
					<?php 
						$session = $session;
						$select = $this->db->get_where('diamond_stu_comment', array('student_id' => $student_id, 'session' => $session, 'term' => $term, 'status' => 3))->row();
					?>
				<table width="100%" border="1">
				  <tr>
					<td colspan="6" bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SECTION B: EFFECTIVE GENERAL BEHAVIOUR</strong></span></td>
					<td colspan="6" bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SECTION C: (PSYCHOMOTOR) SKILL </strong></span></td>
				  </tr>
				  <tr>
				    <td width="249">&nbsp;</td>
				    <td width="104"><strong>&nbsp;5</strong></td>
				    <td width="61" class="text-uppercase"><strong>&nbsp;4</strong></td>
				    <td width="51"><strong>&nbsp;3</strong></td>
				    <td width="58"><strong>&nbsp;2</strong></td>
				    <td width="66"><strong>&nbsp;1</strong></td>
				    <td width="297">&nbsp;</td>
				    <td width="70"><strong>&nbsp;5</strong></td>
				    <td width="69"><strong>&nbsp;4</strong></td>
				    <td width="62"><strong>&nbsp;3</strong></td>
				    <td width="65"><strong>&nbsp;2</strong></td>
				    <td width="60"><strong>&nbsp;1</strong></td>
			      </tr>
				  <tr>
				    <td width="249">&nbsp;PUNCTUALITY</td>
				    <td>&nbsp;<?php if($select->pu == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;HANDWRITING</td>
				    <td>&nbsp;<?php if($select->han == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;CLASSROOM ATTENDANCE</td>
				    <td>&nbsp;<?php if($select->cl == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;FLUENCY</td>
				    <td>&nbsp;<?php if($select->fl == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;CARRYING OUT ASSIGNMENT</td>
				    <td>&nbsp;<?php if($select->car == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;GAMES</td>
				    <td>&nbsp;<?php if($select->ga == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;NEATNESS</td>
				    <td>&nbsp;<?php if($select->ne == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;SPORTS</td>
				    <td>&nbsp;<?php if($select->sp == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;POLITENESS</td>
				    <td>&nbsp;<?php if($select->po == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;GYMNASTICS</td>
				    <td>&nbsp;<?php if($select->gy == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;HONESTY</td>
				    <td>&nbsp;<?php if($select->ho == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;DRAWING &amp; PAINTING</td>
				    <td>&nbsp;<?php if($select->dr == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;SELF CONTROL</td>
				    <td>&nbsp;<?php if($select->se == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;MUSICAL PERFORMANCE</td>
				    <td>&nbsp;<?php if($select->mu == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;RELATIONSHIP WITH OTHERS</td>
				    <td>&nbsp;<?php if($select->re == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;HANDLING TOOLS</td>
				    <td>&nbsp;<?php if($select->ha == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;SENSE OF RESPONSIBILITY</td>
				    <td>&nbsp;<?php if($select->sen == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;CRAFTS</td>
				    <td>&nbsp;<?php if($select->cr == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;OBEDIENCE</td>
				    <td>&nbsp;<?php if($select->ob == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;INITIATIVE</td>
				    <td>&nbsp;<?php if($select->ini == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;ORGANISATIONAL ABILITY</td>
				    <td>&nbsp;<?php if($select->org == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td colspan="8">&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong>KEY TO GRADES</strong></td>
				    <td>&nbsp;</td>
				    <td rowspan="6" class="text-uppercase">&nbsp;</td>
				    <td colspan="4">&nbsp;<strong>KEY TO RATINGS (SECTIONS B AND C)</strong></td>
				    <td colspan="5" rowspan="6">&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;A</td>
				    <td>&nbsp;80 - 100%</td>
				    <td>&nbsp;5</td>
				    <td colspan="3">&nbsp;Maintains an excellent degree of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;B</td>
				    <td>&nbsp;70 - 79%</td>
				    <td>&nbsp;4</td>
				    <td colspan="3">&nbsp;Maintains a high level of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;C</td>
				    <td>&nbsp;60 - 69% </td>
				    <td>&nbsp;3</td>
				    <td colspan="3">&nbsp;Acceptable level of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;P</td>
				    <td>&nbsp;50 - 59% </td>
				    <td>&nbsp;2</td>
				    <td colspan="3">&nbsp;Shows minimal regard for observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;E</td>
				    <td>&nbsp;40 - 49%</td>
				    <td>&nbsp;1</td>
				    <td colspan="3">&nbsp;Has no regard for obsevrable traits</td>
			      </tr>
				  <tr>
				    <td><span class="style4">&nbsp;F</span></td>
				    <td><span class="style4">&nbsp;0 - 39%</span></td>
				    <td colspan="10" class="text-uppercase">&nbsp;</td>
		          </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Head Teacher / Principal's Comment</em></strong></td>
				    <td colspan="11">&nbsp;<?=$select->p_comment;?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Teacher's Comment</em></strong></td>
				    <td colspan="11">&nbsp;<?=$select->tcomment;?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Signature</em></strong></td>
				    <td colspan="11">&nbsp;<img src="<?php echo base_url();?>uploads/signature.png" width="150px" height="50px"></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Date</em></strong></td>
				    <td colspan="11">&nbsp;<?=date('d, M Y')?><span class="float-right"><strong>Next Term Begins:</strong></strong> <?=get_settings('next_term_begin')?></span></td>
			      </tr>
				</table> 
				
				<?php endif;?>	<!-- END OF TERMINAL REPORT THAT CONTAING CA1 AND CA2 AND EXAM SCORES -->
				
				
				

				
				<?php endif;?>	<!-- END OF FIRST TERM GENERAL REPORT FOR CA1 AND CA2 AND EXAM REPORT -->
				<div class="pagebreak"> </div>	
				
				
				
				
				
				
				
				
		
				<?php if($term == 2) : ?><!-- START OF FIRST TERM GENERAL REPORT FOR CA1 AND CA2 AND EXAM REPORT -->
					
					
				<?php if(get_settings('mid_ter_rep_card') == 1):?><!-- START OF CA1 MID TERM REPORT -->
				
				<table width="100%">
				  <tr>
					<td class="pull-left"><img src="<?php echo base_url()?>uploads/logo.png"  height="150" width="150"></td>
					<td>
						<h2 align="center"><?php echo get_settings('system_name')?></h2>
						<p align="center"><strong>MOTTO: HOME WHERE KNOWLEGE SPEAKS</strong><br><strong>Address:</strong> <?php echo get_settings('address')?> <br/>
						<!--<i class="fa fa-envelope"></i> <?php echo get_settings('system_email')?> : <i class="fa fa-phone"></i> <?php echo get_settings('phone')?>--></p>	
					</td>
					<td class="pull-right"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="150" width="150"></td>
				  </tr>		
				</table>

								
				<table width="100%" height="100" border="1">
				  <tr>
					<td width="322" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;PUPIL'S NAME:</strong></span></td>
					<td width="267" class="text-uppercase">&nbsp;<?=$student_selected['name'];?></td>
					<td width="265" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;CLASS:</strong></span></td>
					<td width="69">&nbsp;<?=$class_name;?></td>
					<td width="233" bgcolor="#CC6600"><span class="style2">&nbsp;TERM:</span></td>
					<td width="92">&nbsp;<?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></td>
				  </tr>
				  <tr>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;ADMISSION NO:</strong></span></td>
					<td>&nbsp;<?=$student_selected['roll'];?></td>
					<td bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SEX:</strong></span></td>
					<td>&nbsp;<?=ucwords($student_selected['sex']);?></td>
					<td bgcolor="#CC6600"><span class="style1">&nbsp;<strong>ACADEMIC YEAR:</strong></span></td>
					<td>&nbsp;<?=$session?></td>
				  </tr>
				  <tr>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) SCHOOL OPEN</strong></span></td>
					<td>&nbsp;
				    <?=$this->db->get_where('attendance', array('session' => $session, 
					'term' => $term))->num_rows(); ?></td>
					<td width="265" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) PRESENT:</strong></span></td>
					<td>&nbsp;<?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 1))->num_rows(); 
						?></td>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) ABSENT:</strong></span></td>
					<td><strong>&nbsp;</strong><?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 2))->num_rows(); 
						?></td>
			      </tr>
			</table>
			
				<table width="100%" border="0">
				  <tr>
					<td align="center" bgcolor="#F0F0F0"><span class="style3">CA1 MID-TERM REPORT FOR 
			        <?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?> 
			        <?=$session?> 
				    ACADEMIC SESSION</span></td>
				  </tr>
				  <tr>
				    <td align="center" bgcolor="#CC6600"><span class="style1">SECTION A: SUBJECTS SCORES </span></td>
			      </tr>
				</table>
				<table width="100%"  border="1">
				  <tr>
					<td valign="top"><strong>&nbsp;ACADEMIC<br>&nbsp;SUBJECTS</strong></td>
					
					<td valign="top"><strong>&nbsp;TOTAL<br>&nbsp;CA(100%)</strong> </td>
					<td valign="top"><strong>&nbsp;ARCHIEVED<br>&nbsp;GRADE</strong> </td>
					<td valign="top"><strong><br>&nbsp;POS</strong> </td>
					<td valign="top"><strong><br>&nbsp;OUT OF</strong> </td>
					<td valign="top"><strong><br>&nbsp;MIN SCORE</strong></td>
					<td valign="top"><strong><br>&nbsp;MAX SCORE</strong> </td>
					<td valign="top"><strong><br>&nbsp;CLASS AVG</strong></td>
					<td valign="top"><strong>&nbsp;TARGET<br>&nbsp;GRADE</strong> </td>
					<td valign="top"><br>&nbsp;<strong>REMARKS</strong> </td>
					<!--<td colspan="2" valign="top">&nbsp;<strong>GRADE SUMMARY</strong> &nbsp;<strong></strong> </td>-->
			      </tr>
				  
				  
                    <?php 
						$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
						foreach ($select_subject as $key => $subject):
					?>
					<tr>
					<td valign="top">&nbsp;<?php echo $subject['name'];?></td>
					
                                        <?php 
										$obtained_mark_query = $this->db->get_where('mark', 
											array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 
											'student_id' => $student_id, 'term' => 2));
                                        
										

                                            $class_score_one    = $obtained_mark_query->row()->class_score1;
                                            $class_score_two    = $obtained_mark_query->row()->class_score2;
                                            $class_score_three  = $obtained_mark_query->row()->class_score3;
											$class_score_four  	= $obtained_mark_query->row()->class_score4;
											$class_score_five  	= $obtained_mark_query->row()->class_score5;
											
                                           /*
										    $class_score_one1    = $obtained_mark_query->row()->class_score11;
                                            $class_score_two2    = $obtained_mark_query->row()->class_score22;
                                            $class_score_three3  = $obtained_mark_query->row()->class_score33;
											$class_score_four4   = $obtained_mark_query->row()->class_score44;
											$class_score_five5   = $obtained_mark_query->row()->class_score55;
											*/
											
											$total_ca_score1 = $class_score_one + $class_score_two + $class_score_three + $class_score_four + $class_score_five;
											$total_ca_score1_percentage = ($total_ca_score1 / 20 * 100);
											
											//$total_ca_score2 = $class_score_one1 + $class_score_two2 + $class_score_three3 + $class_score_four4 + $class_score_five5;
											//$total_ca_score2_percentage = ($total_ca_score2 / 25) * 100;
                                            
											
											
											//$exam_score         = $obtained_mark_query->row()->exam_score;
											//$total_CA        	= $class_score_one; + $class_score_two;//+ $class_score_three;
                                            $total_score        = $total_ca_score1_percentage ;//+ $total_ca_score2_percentage;
											
											if($total_score == ""){
												$total_score = 0;
											}else{
												$total_score = $total_score;	
											}
                                        
										
											$update['sum_second'] = $total_score;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $update);
										
                                        ?>
					
					<td valign="top">&nbsp;<?php if($total_score == 0)echo '';else echo $total_score;?></td>
					<td valign="top">&nbsp;
								<?php if ($total_score <= '100' && $total_score >= '90'):?>
								<?php echo 'A*';?>
								<?php endif;?>
								
								<?php if ($total_score <= '89' && $total_score >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($total_score <= '79' && $total_score >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($total_score <= "59" && $total_score >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>

								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>					
					</td>
					
					<td valign="top">&nbsp;
					
										<?php
										
										$subject_id = $subject['subject_id'];
 										$sql = "SELECT mark_id, sum_second, FIND_IN_SET( sum_second,(
												SELECT GROUP_CONCAT( sum_second  ORDER BY sum_second DESC ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND sum_second = $total_score AND sum_second != 0"; 
        
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
					<td valign="top">&nbsp;<?=$number_class?></td>
					
					<td valign="top">&nbsp;
                        <?php echo $lowest_mark = $this->crud_model->get_lowest_marks_first( $exam_id , $class_id , $subject['subject_id'], 2 );?>					
					</td>
					<td valign="top">&nbsp;
						<?php echo $highest_mark = $this->crud_model->get_highest_marks_first( $exam_id , $class_id , $subject['subject_id'], 2 ); ?>					
					</td>

					
					<td valign="top">&nbsp;
					
                                <?php 
								$set = $session;
                                $this->db->select_sum('sum_second');
                                $this->db->from('mark');
                                $this->db->where('subject_id', $subject_id);
								$this->db->where('term', 2);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_second;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;
								}
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 
									'subject_id' => $subject_id))->num_rows();
									
                                ?>	
								<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?>		
					</td>
					<td valign="top">&nbsp;A</td>
					<td valign="top">&nbsp;
					
								<?php if ($total_score <= '100' && $total_score >= '90'):?>
								<?php echo 'EXCELLENT';?>
								<?php endif;?>
								
								<?php if ($total_score <= '89' && $total_score >= '80'):?>
								<?php echo 'VERY GOOD';?>
								<?php endif;?>
								
								<?php if ($total_score <= '79' && $total_score >= '70'):?>
								<?php echo 'GOOD';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'CREDIT';?>
								<?php endif;?>
								
								<?php if ($total_score <= "59" && $total_score >= '50'):?>
								<?php echo 'PASS';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>
								<?php echo 'FAIL';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '30'):?>
								<?php echo 'FAIL';?>
								<?php endif;?>
					<?php //echo $obtained_mark_query->row()->ca1_comment;?>
					</td>
					<!--
					<td valign="top">&nbsp;A</td>
					<td valign="top">&nbsp;1</td>
					-->
				  </tr>
				  <?php endforeach;?>
				</table>
				<table width="100%" border="0">
				  <tr>
					<td style="background:white; color:black"><span class="pull-left"><strong>GRADE SUMMARY</strong>:</span><span class="pull-right"><strong>Number of Subject Offered: 
					
						<?php
						
								$set = $session;
                                $this->db->select_sum('sum_second');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 2);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_second;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered2 = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 
									'student_id' => $student_id))->num_rows();
								echo $getSubjectNumbered2;
						?>
					</strong> </span><br>
					A* = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 'student_id' => $student_id, 'sum_second>=' => 90, 'sum_second<=' => 100))->num_rows();?>
					A = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 'student_id' => $student_id, 'sum_second>=' => 80, 'sum_second<=' => 89))->num_rows();?>
					B = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 'student_id' => $student_id, 'sum_second>=' => 70, 'sum_second<=' => 79))->num_rows();?>
					C = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 'student_id' => $student_id, 'sum_second>=' => 60, 'sum_second<=' => 69))->num_rows();?>
					D = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 'student_id' => $student_id, 'sum_second>=' => 50, 'sum_second<=' => 59))->num_rows();?>
					E = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 'student_id' => $student_id, 'sum_second>=' => 40, 'sum_second<=' => 49))->num_rows();?>
					F = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 'student_id' => $student_id, 'sum_second>=' => 30, 'sum_second<=' => 39))->num_rows();?> 
					</td>
				  </tr>
				  
				
				<table width="100%" border="1">
				  <tr>
					<td width="186"><strong>&nbsp;Class Position:</strong></td>
					<td width="89" class="text-uppercase">&nbsp;
					
					
										<?php
										
										
								$set = $session;
                                $this->db->select_sum('sum_second');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 2);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_second;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 
									'student_id' => $student_id))->num_rows();
									
									
									$updatePercetangeFirst = round($sumTotalOfFirstScore/$getSubjectNumbered);
									if(is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = 0;
									}
									if(!is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = $updatePercetangeFirst;
									}
											
											$class_position_ca1['class_position_ca1'] = $updatePercetangeFirst;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $class_position_ca1);
										
										
										
										
 										$sql = "SELECT mark_id, class_position_ca1, FIND_IN_SET( class_position_ca1,(
												SELECT GROUP_CONCAT( class_position_ca1  ORDER BY class_position_ca1 desc ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND class_position_ca1 = $updatePercetangeFirst AND class_position_ca1 != 0"; 
        
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
					<td width="155"><strong>&nbsp;Total Score:</strong></td>
					<td width="119">&nbsp;
								<?php
								$set = $session;
                                $this->db->select_sum('sum_second');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 2);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_second;
								
									if($sumTotalOfFirstScore == ""){
										echo $sumTotalOfFirstScore = 0;
									}else{
										echo $sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
							?>					
					</td>
					<td colspan="2"><strong>&nbsp;<strong>Final Average</strong>:</strong></td>
					<td width="171">&nbsp;
					<?php 
					
								$set = $session;
                                $this->db->select_sum('sum_second');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 2);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_second;
								
									if($sumTotalOfFirstScore == ""){
										$sumTotalOfFirstScore = 0;
									}else{
										$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
								
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 
									'student_id' => $student_id))->num_rows();		
					?>
					
					<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?> %					
					</td>
				    <td width="">&nbsp;<strong>Final Grade</strong> </td>
				    <td width="75">&nbsp;
								<?php $FindGrade = round($sumTotalOfFirstScore /$getSubjectNumbered,2);?>
								<?php if ($FindGrade <= '100' && $FindGrade >= '90'):?>
								<?php echo 'A*';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '89' && $FindGrade >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '79' && $FindGrade >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '69' && $FindGrade >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "59" && $FindGrade >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "49" && $FindGrade >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "39" && $FindGrade >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					
					</td>
				  </tr>
				</table>
				
				
				
					<?php 
						$session = $session;
						$select = $this->db->get_where('diamond_stu_comment', array('student_id' => $student_id, 'session' => $session, 'term' => $term, 'status' => 1))->row();
					?>
				<table width="100%" border="1">
				  <tr>
					<td colspan="6" bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SECTION B: EFFECTIVE GENERAL BEHAVIOUR</strong></span></td>
					<td colspan="6" bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SECTION C: (PSYCHOMOTOR) SKILL </strong></span></td>
				  </tr>
				  <tr>
				    <td width="249">&nbsp;</td>
				    <td width="104"><strong>&nbsp;5</strong></td>
				    <td width="61" class="text-uppercase"><strong>&nbsp;4</strong></td>
				    <td width="51"><strong>&nbsp;3</strong></td>
				    <td width="58"><strong>&nbsp;2</strong></td>
				    <td width="66"><strong>&nbsp;1</strong></td>
				    <td width="297">&nbsp;</td>
				    <td width="70"><strong>&nbsp;5</strong></td>
				    <td width="69"><strong>&nbsp;4</strong></td>
				    <td width="62"><strong>&nbsp;3</strong></td>
				    <td width="65"><strong>&nbsp;2</strong></td>
				    <td width="60"><strong>&nbsp;1</strong></td>
			      </tr>
				  <tr>
				    <td width="249">&nbsp;PUNCTUALITY</td>
				    <td>&nbsp;<?php if($select->pu == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;HANDWRITING</td>
				    <td>&nbsp;<?php if($select->han == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;CLASSROOM ATTENDANCE</td>
				    <td>&nbsp;<?php if($select->cl == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;FLUENCY</td>
				    <td>&nbsp;<?php if($select->fl == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;CARRYING OUT ASSIGNMENT</td>
				    <td>&nbsp;<?php if($select->car == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;GAMES</td>
				    <td>&nbsp;<?php if($select->ga == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;NEATNESS</td>
				    <td>&nbsp;<?php if($select->ne == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;SPORTS</td>
				    <td>&nbsp;<?php if($select->sp == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;POLITENESS</td>
				    <td>&nbsp;<?php if($select->po == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;GYMNASTICS</td>
				    <td>&nbsp;<?php if($select->gy == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;HONESTY</td>
				    <td>&nbsp;<?php if($select->ho == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;DRAWING &amp; PAINTING</td>
				    <td>&nbsp;<?php if($select->dr == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;SELF CONTROL</td>
				    <td>&nbsp;<?php if($select->se == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;MUSICAL PERFORMANCE</td>
				    <td>&nbsp;<?php if($select->mu == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;RELATIONSHIP WITH OTHERS</td>
				    <td>&nbsp;<?php if($select->re == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;HANDLING TOOLS</td>
				    <td>&nbsp;<?php if($select->ha == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;SENSE OF RESPONSIBILITY</td>
				    <td>&nbsp;<?php if($select->sen == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;CRAFTS</td>
				    <td>&nbsp;<?php if($select->cr == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;OBEDIENCE</td>
				    <td>&nbsp;<?php if($select->ob == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;INITIATIVE</td>
				    <td>&nbsp;<?php if($select->ini == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;ORGANISATIONAL ABILITY</td>
				    <td>&nbsp;<?php if($select->org == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td colspan="8">&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong>KEY TO GRADES</strong></td>
				    <td>&nbsp;</td>
				    <td rowspan="6" class="text-uppercase">&nbsp;</td>
				    <td colspan="4">&nbsp;<strong>KEY TO RATINGS (SECTIONS B AND C)</strong></td>
				    <td colspan="5" rowspan="6">&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;A</td>
				    <td>&nbsp;80 - 100%</td>
				    <td>&nbsp;5</td>
				    <td colspan="3">&nbsp;Maintains an excellent degree of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;B</td>
				    <td>&nbsp;70 - 79%</td>
				    <td>&nbsp;4</td>
				    <td colspan="3">&nbsp;Maintains a high level of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;C</td>
				    <td>&nbsp;60 - 69% </td>
				    <td>&nbsp;3</td>
				    <td colspan="3">&nbsp;Acceptable level of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;P</td>
				    <td>&nbsp;50 - 59% </td>
				    <td>&nbsp;2</td>
				    <td colspan="3">&nbsp;Shows minimal regard for observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;E</td>
				    <td>&nbsp;40 - 49%</td>
				    <td>&nbsp;1</td>
				    <td colspan="3">&nbsp;Has no regard for obsevrable traits</td>
			      </tr>
				  <tr>
				    <td><span class="style4">&nbsp;F</span></td>
				    <td><span class="style4">&nbsp;0 - 39%</span></td>
				    <td colspan="10" class="text-uppercase">&nbsp;</td>
		          </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Head Teacher / Principal's Comment</em></strong></td>
				    <td colspan="11">&nbsp;<?=$select->p_comment;?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Teacher's Comment</em></strong></td>
				    <td colspan="11">&nbsp;<?=$select->tcomment;?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Signature</em></strong></td>
				    <td colspan="11">&nbsp;<img src="<?php echo base_url();?>uploads/signature.png" width="150px" height="50px"></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Date</em></strong></td>
				    <td colspan="11">&nbsp;<?=date('d, M Y')?><span class="float-right"><strong>Next Term Begins:</strong></strong> <?=get_settings('next_term_begin')?></span></td>
			      </tr>
				</table>
				<?php endif;?>	<!-- END OF CA1 MID TERM REPORT -->
				
				

				
				<?php if(get_settings('mid_ter_rep_card') == 2):?><!-- START OF CA2 MID TERM REPORT -->
				
				<table width="100%">
				  <tr>
					<td class="pull-left"><img src="<?php echo base_url()?>uploads/logo.png"  height="150" width="150"></td>
					<td>
						<h2 align="center"><?php echo get_settings('system_name')?></h2>
						<p align="center"><strong>MOTTO: HOME WHERE KNOWLEGE SPEAKS</strong><br><strong>Address:</strong> <?php echo get_settings('address')?> <br/>
						<!--<i class="fa fa-envelope"></i> <?php echo get_settings('system_email')?> : <i class="fa fa-phone"></i> <?php echo get_settings('phone')?>--></p>	
					</td>
					<td class="pull-right"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="150" width="150"></td>
				  </tr>		
				</table>

								
				<table width="100%" height="100" border="1">
				  <tr>
					<td width="322" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;PUPIL'S NAME:</strong></span></td>
					<td width="267" class="text-uppercase">&nbsp;<?=$student_selected['name'];?></td>
					<td width="265" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;CLASS:</strong></span></td>
					<td width="69">&nbsp;<?=$class_name;?></td>
					<td width="233" bgcolor="#CC6600"><span class="style2">&nbsp;TERM:</span></td>
					<td width="92">&nbsp;<?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></td>
				  </tr>
				  <tr>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;ADMISSION NO:</strong></span></td>
					<td>&nbsp;<?=$student_selected['roll'];?></td>
					<td bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SEX:</strong></span></td>
					<td>&nbsp;<?=ucwords($student_selected['sex']);?></td>
					<td bgcolor="#CC6600"><span class="style1">&nbsp;<strong>ACADEMIC YEAR:</strong></span></td>
					<td>&nbsp;<?=$session?></td>
				  </tr>
				  <tr>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) SCHOOL OPEN</strong></span></td>
					<td>&nbsp;
				    <?=$this->db->get_where('attendance', array('session' => $session, 
					'term' => $term))->num_rows(); ?></td>
					<td width="265" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) PRESENT:</strong></span></td>
					<td>&nbsp;<?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 1))->num_rows(); 
						?></td>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) ABSENT:</strong></span></td>
					<td><strong>&nbsp;</strong><?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 2))->num_rows(); 
						?></td>
			      </tr>
			</table>
			
				<table width="100%" border="0">
				  <tr>
					<td align="center" bgcolor="#F0F0F0"><span class="style3">CA1 MID-TERM REPORT FOR 
			        <?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?> 
			        <?=$session?> 
				    ACADEMIC SESSION</span></td>
				  </tr>
				  <tr>
				    <td align="center" bgcolor="#CC6600"><span class="style1">SECTION A: SUBJECTS SCORES </span></td>
			      </tr>
				</table>
				<table width="100%"  border="1">
				  <tr>
					<td valign="top"><strong>&nbsp;ACADEMIC<br>&nbsp;SUBJECTS</strong></td>
					
					<td valign="top"><strong>&nbsp;TOTAL<br>&nbsp;CA(100%)</strong> </td>
					<td valign="top"><strong>&nbsp;ARCHIEVED<br>&nbsp;GRADE</strong> </td>
					<td valign="top"><strong><br>&nbsp;POS</strong> </td>
					<td valign="top"><strong><br>&nbsp;OUT OF</strong> </td>
					<td valign="top"><strong><br>&nbsp;MIN SCORE</strong></td>
					<td valign="top"><strong><br>&nbsp;MAX SCORE</strong> </td>
					<td valign="top"><strong><br>&nbsp;CLASS AVG</strong></td>
					<td valign="top"><strong>&nbsp;TARGET<br>&nbsp;GRADE</strong> </td>
					<td valign="top"><br>&nbsp;<strong>REMARKS</strong> </td>
					<!--<td colspan="2" valign="top">&nbsp;<strong>GRADE SUMMARY</strong> &nbsp;<strong></strong> </td>-->
			      </tr>
				  
				  
                    <?php 
						$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
						foreach ($select_subject as $key => $subject):
					?>
					<tr>
					<td valign="top">&nbsp;<?php echo $subject['name'];?></td>
					
                                        <?php 
										$obtained_mark_query = $this->db->get_where('mark', 
											array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 
											'student_id' => $student_id, 'term' => 2));
                                        
										

                                            $class_score_one    = $obtained_mark_query->row()->class_score1;
                                            $class_score_two    = $obtained_mark_query->row()->class_score2;
                                            $class_score_three  = $obtained_mark_query->row()->class_score3;
											$class_score_four  	= $obtained_mark_query->row()->class_score4;
											$class_score_five  	= $obtained_mark_query->row()->class_score5;
											
                                           /*
										    $class_score_one1    = $obtained_mark_query->row()->class_score11;
                                            $class_score_two2    = $obtained_mark_query->row()->class_score22;
                                            $class_score_three3  = $obtained_mark_query->row()->class_score33;
											$class_score_four4   = $obtained_mark_query->row()->class_score44;
											$class_score_five5   = $obtained_mark_query->row()->class_score55;
											*/
											
											$total_ca_score1 = $class_score_one + $class_score_two + $class_score_three + $class_score_four + $class_score_five;
											$total_ca_score1_percentage = ($total_ca_score1 / 20 * 100);
											
											//$total_ca_score2 = $class_score_one1 + $class_score_two2 + $class_score_three3 + $class_score_four4 + $class_score_five5;
											//$total_ca_score2_percentage = ($total_ca_score2 / 25) * 100;
                                            
											
											
											//$exam_score         = $obtained_mark_query->row()->exam_score;
											//$total_CA        	= $class_score_one; + $class_score_two;//+ $class_score_three;
                                            $total_score        = $total_ca_score1_percentage ;//+ $total_ca_score2_percentage;
											
											if($total_score == ""){
												$total_score = 0;
											}else{
												$total_score = $total_score;	
											}
                                        
										
											$update['sum_second'] = $total_score;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $update);
										
                                        ?>
					
					<td valign="top">&nbsp;<?php if($total_score == 0)echo '';else echo $total_score;?></td>
					<td valign="top">&nbsp;
								<?php if ($total_score <= '100' && $total_score >= '90'):?>
								<?php echo 'A*';?>
								<?php endif;?>
								
								<?php if ($total_score <= '89' && $total_score >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($total_score <= '79' && $total_score >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($total_score <= "59" && $total_score >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>

								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>					
					</td>
					
					<td valign="top">&nbsp;
					
										<?php
										
										$subject_id = $subject['subject_id'];
 										$sql = "SELECT mark_id, sum_second, FIND_IN_SET( sum_second,(
												SELECT GROUP_CONCAT( sum_second  ORDER BY sum_second DESC ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND sum_second = $total_score AND sum_second != 0"; 
        
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
					<td valign="top">&nbsp;<?=$number_class?></td>
					
					<td valign="top">&nbsp;
                        <?php echo $lowest_mark = $this->crud_model->get_lowest_marks_first( $exam_id , $class_id , $subject['subject_id'], 2 );?>					
					</td>
					<td valign="top">&nbsp;
						<?php echo $highest_mark = $this->crud_model->get_highest_marks_first( $exam_id , $class_id , $subject['subject_id'], 2 ); ?>					
					</td>

					
					<td valign="top">&nbsp;
					
                                <?php 
								$set = $session;
                                $this->db->select_sum('sum_second');
                                $this->db->from('mark');
                                $this->db->where('subject_id', $subject_id);
								$this->db->where('term', 2);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_second;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;
								}
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 
									'subject_id' => $subject_id))->num_rows();
									
                                ?>	
								<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?>		
					</td>
					<td valign="top">&nbsp;A</td>
					<td valign="top">&nbsp;
					
								<?php if ($total_score <= '100' && $total_score >= '90'):?>
								<?php echo 'EXCELLENT';?>
								<?php endif;?>
								
								<?php if ($total_score <= '89' && $total_score >= '80'):?>
								<?php echo 'VERY GOOD';?>
								<?php endif;?>
								
								<?php if ($total_score <= '79' && $total_score >= '70'):?>
								<?php echo 'GOOD';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'CREDIT';?>
								<?php endif;?>
								
								<?php if ($total_score <= "59" && $total_score >= '50'):?>
								<?php echo 'PASS';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>
								<?php echo 'FAIL';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '30'):?>
								<?php echo 'FAIL';?>
								<?php endif;?>
					<?php //echo $obtained_mark_query->row()->ca1_comment;?>
					</td>
					<!--
					<td valign="top">&nbsp;A</td>
					<td valign="top">&nbsp;1</td>
					-->
				  </tr>
				  <?php endforeach;?>
				</table>
				<table width="100%" border="0">
				  <tr>
					<td style="background:white; color:black"><span class="pull-left"><strong>GRADE SUMMARY</strong>:</span><span class="pull-right"><strong>Number of Subject Offered: 
					
						<?php
						
								$set = $session;
                                $this->db->select_sum('sum_second');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 2);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_second;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered2 = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 
									'student_id' => $student_id))->num_rows();
								echo $getSubjectNumbered2;
						?>
					</strong> </span><br>
					A* = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 'student_id' => $student_id, 'sum_second>=' => 90, 'sum_second<=' => 100))->num_rows();?>
					A = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 'student_id' => $student_id, 'sum_second>=' => 80, 'sum_second<=' => 89))->num_rows();?>
					B = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 'student_id' => $student_id, 'sum_second>=' => 70, 'sum_second<=' => 79))->num_rows();?>
					C = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 'student_id' => $student_id, 'sum_second>=' => 60, 'sum_second<=' => 69))->num_rows();?>
					D = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 'student_id' => $student_id, 'sum_second>=' => 50, 'sum_second<=' => 59))->num_rows();?>
					E = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 'student_id' => $student_id, 'sum_second>=' => 40, 'sum_second<=' => 49))->num_rows();?>
					F = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 'student_id' => $student_id, 'sum_second>=' => 30, 'sum_second<=' => 39))->num_rows();?> 
					</td>
				  </tr>
				  
				
				<table width="100%" border="1">
				  <tr>
					<td width="186"><strong>&nbsp;Class Position:</strong></td>
					<td width="89" class="text-uppercase">&nbsp;
					
					
										<?php
										
										
								$set = $session;
                                $this->db->select_sum('sum_second');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 2);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_second;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 
									'student_id' => $student_id))->num_rows();
									
									
									$updatePercetangeFirst = round($sumTotalOfFirstScore/$getSubjectNumbered);
									if(is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = 0;
									}
									if(!is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = $updatePercetangeFirst;
									}
											
											$class_position_ca2['class_position_ca2'] = $updatePercetangeFirst;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $class_position_ca2);
										
										
										
										
 										$sql = "SELECT mark_id, class_position_ca2, FIND_IN_SET( class_position_ca2,(
												SELECT GROUP_CONCAT( class_position_ca2  ORDER BY class_position_ca2 desc ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND class_position_ca2 = $updatePercetangeFirst AND class_position_ca2 != 0"; 
        
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
					<td width="155"><strong>&nbsp;Total Score:</strong></td>
					<td width="119">&nbsp;
								<?php
								$set = $session;
                                $this->db->select_sum('sum_second');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 2);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_second;
								
									if($sumTotalOfFirstScore == ""){
										echo $sumTotalOfFirstScore = 0;
									}else{
										echo $sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
							?>					
					</td>
					<td colspan="2"><strong>&nbsp;<strong>Final Average</strong>:</strong></td>
					<td width="171">&nbsp;
					<?php 
					
								$set = $session;
                                $this->db->select_sum('sum_second');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 2);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_second;
								
									if($sumTotalOfFirstScore == ""){
										$sumTotalOfFirstScore = 0;
									}else{
										$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
								
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 
									'student_id' => $student_id))->num_rows();		
					?>
					
					<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?> %					
					</td>
				    <td width="">&nbsp;<strong>Final Grade</strong> </td>
				    <td width="75">&nbsp;
								<?php $FindGrade = round($sumTotalOfFirstScore /$getSubjectNumbered,2);?>
								<?php if ($FindGrade <= '100' && $FindGrade >= '90'):?>
								<?php echo 'A*';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '89' && $FindGrade >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '79' && $FindGrade >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '69' && $FindGrade >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "59" && $FindGrade >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "49" && $FindGrade >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "39" && $FindGrade >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					
					</td>
				  </tr>
				</table>
				
				
				
					<?php 
						$session = $session;
						$select = $this->db->get_where('diamond_stu_comment', array('student_id' => $student_id, 'session' => $session, 'term' => $term, 'status' => 2))->row();
					?>
				<table width="100%" border="1">
				  <tr>
					<td colspan="6" bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SECTION B: EFFECTIVE GENERAL BEHAVIOUR</strong></span></td>
					<td colspan="6" bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SECTION C: (PSYCHOMOTOR) SKILL </strong></span></td>
				  </tr>
				  <tr>
				    <td width="249">&nbsp;</td>
				    <td width="104"><strong>&nbsp;5</strong></td>
				    <td width="61" class="text-uppercase"><strong>&nbsp;4</strong></td>
				    <td width="51"><strong>&nbsp;3</strong></td>
				    <td width="58"><strong>&nbsp;2</strong></td>
				    <td width="66"><strong>&nbsp;1</strong></td>
				    <td width="297">&nbsp;</td>
				    <td width="70"><strong>&nbsp;5</strong></td>
				    <td width="69"><strong>&nbsp;4</strong></td>
				    <td width="62"><strong>&nbsp;3</strong></td>
				    <td width="65"><strong>&nbsp;2</strong></td>
				    <td width="60"><strong>&nbsp;1</strong></td>
			      </tr>
				  <tr>
				    <td width="249">&nbsp;PUNCTUALITY</td>
				    <td>&nbsp;<?php if($select->pu == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;HANDWRITING</td>
				    <td>&nbsp;<?php if($select->han == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;CLASSROOM ATTENDANCE</td>
				    <td>&nbsp;<?php if($select->cl == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;FLUENCY</td>
				    <td>&nbsp;<?php if($select->fl == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;CARRYING OUT ASSIGNMENT</td>
				    <td>&nbsp;<?php if($select->car == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;GAMES</td>
				    <td>&nbsp;<?php if($select->ga == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;NEATNESS</td>
				    <td>&nbsp;<?php if($select->ne == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;SPORTS</td>
				    <td>&nbsp;<?php if($select->sp == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;POLITENESS</td>
				    <td>&nbsp;<?php if($select->po == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;GYMNASTICS</td>
				    <td>&nbsp;<?php if($select->gy == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;HONESTY</td>
				    <td>&nbsp;<?php if($select->ho == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;DRAWING &amp; PAINTING</td>
				    <td>&nbsp;<?php if($select->dr == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;SELF CONTROL</td>
				    <td>&nbsp;<?php if($select->se == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;MUSICAL PERFORMANCE</td>
				    <td>&nbsp;<?php if($select->mu == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;RELATIONSHIP WITH OTHERS</td>
				    <td>&nbsp;<?php if($select->re == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;HANDLING TOOLS</td>
				    <td>&nbsp;<?php if($select->ha == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;SENSE OF RESPONSIBILITY</td>
				    <td>&nbsp;<?php if($select->sen == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;CRAFTS</td>
				    <td>&nbsp;<?php if($select->cr == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;OBEDIENCE</td>
				    <td>&nbsp;<?php if($select->ob == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;INITIATIVE</td>
				    <td>&nbsp;<?php if($select->ini == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;ORGANISATIONAL ABILITY</td>
				    <td>&nbsp;<?php if($select->org == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td colspan="8">&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong>KEY TO GRADES</strong></td>
				    <td>&nbsp;</td>
				    <td rowspan="6" class="text-uppercase">&nbsp;</td>
				    <td colspan="4">&nbsp;<strong>KEY TO RATINGS (SECTIONS B AND C)</strong></td>
				    <td colspan="5" rowspan="6">&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;A</td>
				    <td>&nbsp;80 - 100%</td>
				    <td>&nbsp;5</td>
				    <td colspan="3">&nbsp;Maintains an excellent degree of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;B</td>
				    <td>&nbsp;70 - 79%</td>
				    <td>&nbsp;4</td>
				    <td colspan="3">&nbsp;Maintains a high level of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;C</td>
				    <td>&nbsp;60 - 69% </td>
				    <td>&nbsp;3</td>
				    <td colspan="3">&nbsp;Acceptable level of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;P</td>
				    <td>&nbsp;50 - 59% </td>
				    <td>&nbsp;2</td>
				    <td colspan="3">&nbsp;Shows minimal regard for observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;E</td>
				    <td>&nbsp;40 - 49%</td>
				    <td>&nbsp;1</td>
				    <td colspan="3">&nbsp;Has no regard for obsevrable traits</td>
			      </tr>
				  <tr>
				    <td><span class="style4">&nbsp;F</span></td>
				    <td><span class="style4">&nbsp;0 - 39%</span></td>
				    <td colspan="10" class="text-uppercase">&nbsp;</td>
		          </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Head Teacher / Principal's Comment</em></strong></td>
				    <td colspan="11">&nbsp;<?=$select->p_comment;?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Teacher's Comment</em></strong></td>
				    <td colspan="11">&nbsp;<?=$select->tcomment;?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Signature</em></strong></td>
				    <td colspan="11">&nbsp;<img src="<?php echo base_url();?>uploads/signature.png" width="150px" height="50px"></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Date</em></strong></td>
				    <td colspan="11">&nbsp;<?=date('d, M Y')?><span class="float-right"><strong>Next Term Begins:</strong></strong> <?=get_settings('next_term_begin')?></span></td>
			      </tr>
				</table>
				
				<?php endif;?>	<!-- END OF CA2 MID TERM REPORT -->
				
				
				
				<?php if(get_settings('mid_ter_rep_card') == 3):?><!-- START OF TERMINAL REPORT THAT CONTAING CA1 AND CA2 AND EXAM SCORES -->
				
				<table width="100%">
				  <tr>
					<td class="pull-left"><img src="<?php echo base_url()?>uploads/logo.png"  height="150" width="150"></td>
					<td>
						<h2 align="center"><?php echo get_settings('system_name')?></h2>
						<p align="center"><strong>MOTTO: HOME WHERE KNOWLEGE SPEAKS</strong><br><strong>Address:</strong> <?php echo get_settings('address')?> <br/>
						<!--<i class="fa fa-envelope"></i> <?php echo get_settings('system_email')?> : <i class="fa fa-phone"></i> <?php echo get_settings('phone')?>--></p>	
					</td>
					<td class="pull-right"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="150" width="150"></td>
				  </tr>		
				</table>

								
				<table width="100%" height="100" border="1">
				  <tr>
					<td width="322" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;PUPIL'S NAME:</strong></span></td>
					<td width="267" class="text-uppercase">&nbsp;<?=$student_selected['name'];?></td>
					<td width="265" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;CLASS:</strong></span></td>
					<td width="69">&nbsp;<?=$class_name;?></td>
					<td width="233" bgcolor="#CC6600"><span class="style2">&nbsp;TERM:</span></td>
					<td width="92">&nbsp;<?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></td>
				  </tr>
				  <tr>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;ADMISSION NO:</strong></span></td>
					<td>&nbsp;<?=$student_selected['roll'];?></td>
					<td bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SEX:</strong></span></td>
					<td>&nbsp;<?=ucwords($student_selected['sex']);?></td>
					<td bgcolor="#CC6600"><span class="style1">&nbsp;<strong>ACADEMIC YEAR:</strong></span></td>
					<td>&nbsp;<?=$session?></td>
				  </tr>
				  <tr>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) SCHOOL OPEN</strong></span></td>
					<td>&nbsp;
				    <?=$this->db->get_where('attendance', array('session' => $session, 
					'term' => $term))->num_rows(); ?></td>
					<td width="265" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) PRESENT:</strong></span></td>
					<td>&nbsp;<?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 1))->num_rows(); 
						?></td>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) ABSENT:</strong></span></td>
					<td><strong>&nbsp;</strong><?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 2))->num_rows(); 
						?></td>
			      </tr>
			</table>
			
				<table width="100%" border="0">
				  <tr>
					<td align="center" bgcolor="#F0F0F0"><span class="style3">TERMINAL REPORT FOR 
			        <?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?> 
			        <?=$session?> 
				    ACADEMIC SESSION</span></td>
				  </tr>
				  <tr>
				    <td align="center" bgcolor="#CC6600"><span class="style1">SECTION A: SUBJECTS SCORES </span></td>
			      </tr>
				</table>
				<table width="100%"  border="1">
				  <tr>
					<td valign="top"><strong>&nbsp;ACADEMIC<br>&nbsp;SUBJECTS</strong></td>
					
					<td valign="top"><strong>&nbsp;CA</strong> </td>
					<td valign="top"><strong>&nbsp;EXAM</strong> </td>
					<td valign="top"><strong>&nbsp;TOTAL</strong> </td>
					<td valign="top"><strong>&nbsp;ARCHIEVED<br>&nbsp;GRADE</strong> </td>
					<td valign="top"><strong><br>&nbsp;POS</strong> </td>
					<td valign="top"><strong><br>&nbsp;OUT OF</strong> </td>
					<td valign="top"><strong><br>&nbsp;MIN SCORE</strong></td>
					<td valign="top"><strong><br>&nbsp;MAX SCORE</strong> </td>
					<td valign="top"><strong><br>&nbsp;CLASS AVG</strong></td>
					<td valign="top"><br>&nbsp;<strong>REMARKS</strong> </td>
					<!--<td colspan="2" valign="top">&nbsp;<strong>GRADE SUMMARY</strong> &nbsp;<strong></strong> </td>-->
			      </tr>
				  
				  
<?php 
						$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
						foreach ($select_subject as $key => $subject):
					?>
					<tr>
					<td valign="top">&nbsp;<?php echo $subject['name'];?></td>
					
                                        <?php 
										$obtained_mark_query = $this->db->get_where('mark', 
											array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 
											'student_id' => $student_id, 'term' => 2));
                                        
										

                                            $class_score_one    = $obtained_mark_query->row()->class_score1;
                                            $class_score_two    = $obtained_mark_query->row()->class_score2;
                                            $class_score_three  = $obtained_mark_query->row()->class_score3;
											$class_score_four  	= $obtained_mark_query->row()->class_score4;
											$class_score_five  	= $obtained_mark_query->row()->class_score5;
											
                                          
										    $class_score_one1    = $obtained_mark_query->row()->class_score11;
                                            $class_score_two2    = $obtained_mark_query->row()->class_score22;
                                            $class_score_three3  = $obtained_mark_query->row()->class_score33;
											$class_score_four4   = $obtained_mark_query->row()->class_score44;
											$class_score_five5   = $obtained_mark_query->row()->class_score55;
											
											$total_ca_score1 = $class_score_one + $class_score_two + $class_score_three + $class_score_four + $class_score_five;
											$total_ca_score2 = $class_score_one1 + $class_score_two2 + $class_score_three3 + $class_score_four4 + $class_score_five5;
											$total_ca_score1_and_two = $total_ca_score1 + $total_ca_score2;
											
											$exam_score         = $obtained_mark_query->row()->exam_score;
                                            $total_score        = $total_ca_score1_and_two + $exam_score;
											
											if($total_score == ""){
												$total_score = 0;
											}else{
												$total_score = $total_score;	
											}
                                        
										
											$update['sum_second'] = $total_score;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $update);
										
                                        ?>
					<td valign="top">&nbsp;<?php if($total_ca_score1_and_two == 0)echo '';else echo $total_ca_score1_and_two;?></td>
					<td valign="top">&nbsp;<?php if($exam_score == 0)echo '';else echo $exam_score;?></td>
					<td valign="top">&nbsp;<?php if($total_score == 0)echo '';else echo $total_score;?></td>
					<td valign="top">&nbsp;
								<?php if ($total_score <= '100' && $total_score >= '90'):?>
								<?php echo 'A*';?>
								<?php endif;?>
								
								<?php if ($total_score <= '89' && $total_score >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($total_score <= '79' && $total_score >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($total_score <= "59" && $total_score >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>					
					</td>
					
					<td valign="top">&nbsp;
					
										<?php
										
										$subject_id = $subject['subject_id'];
 										$sql = "SELECT mark_id, sum_second, FIND_IN_SET( sum_second,(
												SELECT GROUP_CONCAT( sum_second  ORDER BY sum_second DESC ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND sum_second = $total_score AND sum_second != 0"; 
        
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
					<td valign="top">&nbsp;<?=$number_class?></td>
					
					<td valign="top">&nbsp;
                        <?php echo $lowest_mark = $this->crud_model->get_lowest_marks_first( $exam_id , $class_id , $subject['subject_id'], 2 );?>					
					</td>
					<td valign="top">&nbsp;
						<?php echo $highest_mark = $this->crud_model->get_highest_marks_first( $exam_id , $class_id , $subject['subject_id'], 2 ); ?>					
					</td>

					
					<td valign="top">&nbsp;
					
                              <?php 
								$set = $session;
                                $this->db->select_sum('sum_second');
                                $this->db->from('mark');
                                $this->db->where('subject_id', $subject_id);
								$this->db->where('term', 2);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_second;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 
									'subject_id' => $subject_id))->num_rows();
                                ?>	
								<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?>		
					</td>
					<td valign="top">&nbsp;
					
								<?php if ($total_score <= '100' && $total_score >= '90'):?>
								<?php echo 'EXCELLENT';?>
								<?php endif;?>
								
								<?php if ($total_score <= '89' && $total_score >= '80'):?>
								<?php echo 'VERY GOOD';?>
								<?php endif;?>
								
								<?php if ($total_score <= '79' && $total_score >= '70'):?>
								<?php echo 'GOOD';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'CREDIT';?>
								<?php endif;?>
								
								<?php if ($total_score <= "59" && $total_score >= '50'):?>
								<?php echo 'PASS';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>
								<?php echo 'FAIL';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '30'):?>
								<?php echo 'FAIL';?>
								<?php endif;?>
					
					</td>
					
				  </tr>
				  <?php endforeach;?>
				</table>
				<table width="100%" border="0">
				  <tr>
					<td style="background:white; color:black"><span class="pull-left"><strong>GRADE SUMMARY</strong>:</span><span class="pull-right"><strong>Number of Subject Offered: 
					
						<?php
						
								$set = $session;
                                $this->db->select_sum('sum_second');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 2);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_second;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered2 = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 
									'student_id' => $student_id))->num_rows();
								echo $getSubjectNumbered2;
						?>
					</strong> </span><br>
					A* = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 'student_id' => $student_id, 'sum_second>=' => 90, 'sum_second<=' => 100))->num_rows();?>
					A = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 'student_id' => $student_id, 'sum_second>=' => 80, 'sum_second<=' => 89))->num_rows();?>
					B = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 'student_id' => $student_id, 'sum_second>=' => 70, 'sum_second<=' => 79))->num_rows();?>
					C = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 'student_id' => $student_id, 'sum_second>=' => 60, 'sum_second<=' => 69))->num_rows();?>
					D = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 'student_id' => $student_id, 'sum_second>=' => 50, 'sum_second<=' => 59))->num_rows();?>
					E = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 'student_id' => $student_id, 'sum_second>=' => 40, 'sum_second<=' => 49))->num_rows();?>
					F = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 'student_id' => $student_id, 'sum_second>=' => 30, 'sum_second<=' => 39))->num_rows();?> 
					</td>
				  </tr>
				  
				
				<table width="100%" border="1">
				  <tr>
					<td width="186"><strong>&nbsp;Class Position:</strong></td>
					<td width="89" class="text-uppercase">&nbsp;
					
					
										<?php
										
										
								$set = $session;
                                $this->db->select_sum('sum_second');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 2);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_second;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 
									'student_id' => $student_id))->num_rows();
									
									
									$updatePercetangeFirst = round($sumTotalOfFirstScore/$getSubjectNumbered);
									if(is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = 0;
									}
									if(!is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = $updatePercetangeFirst;
									}
											
											$class_position_first['class_position_first'] = $updatePercetangeFirst;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $class_position_first);
										
										
										
										
 										$sql = "SELECT mark_id, class_position_first, FIND_IN_SET( class_position_first,(
												SELECT GROUP_CONCAT( class_position_first  ORDER BY class_position_first desc ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND class_position_first = $updatePercetangeFirst AND class_position_first != 0"; 
        
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
					<td width="155"><strong>&nbsp;Total Score:</strong></td>
					<td width="119">&nbsp;
								<?php
								$set = $session;
                                $this->db->select_sum('sum_second');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 2);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_second;
								
									if($sumTotalOfFirstScore == ""){
										echo $sumTotalOfFirstScore = 0;
									}else{
										echo $sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
							?>					
					</td>
					<td colspan="2"><strong>&nbsp;<strong>Final Average</strong>:</strong></td>
					<td width="171">&nbsp;
					<?php 
					
								$set = $session;
                                $this->db->select_sum('sum_second');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 2);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_second;
								
									if($sumTotalOfFirstScore == ""){
										$sumTotalOfFirstScore = 0;
									}else{
										$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
								
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 
									'student_id' => $student_id))->num_rows();		
					?>
					
					<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?> %					
					</td>
				    <td width="">&nbsp;<strong>Final Grade</strong> </td>
				    <td width="75">&nbsp;
								<?php $FindGrade = round($sumTotalOfFirstScore /$getSubjectNumbered,2);?>
								<?php if ($FindGrade <= '100' && $FindGrade >= '90'):?>
								<?php echo 'A*';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '89' && $FindGrade >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '79' && $FindGrade >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '69' && $FindGrade >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "59" && $FindGrade >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "49" && $FindGrade >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "39" && $FindGrade >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					
					</td>
				  </tr>
				</table>
				
				
				
					<?php 
						$session = $session;
						$select = $this->db->get_where('diamond_stu_comment', array('student_id' => $student_id, 'session' => $session, 'term' => $term, 'status' => 3))->row();
					?>
				<table width="100%" border="1">
				  <tr>
					<td colspan="6" bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SECTION B: EFFECTIVE GENERAL BEHAVIOUR</strong></span></td>
					<td colspan="6" bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SECTION C: (PSYCHOMOTOR) SKILL </strong></span></td>
				  </tr>
				  <tr>
				    <td width="249">&nbsp;</td>
				    <td width="104"><strong>&nbsp;5</strong></td>
				    <td width="61" class="text-uppercase"><strong>&nbsp;4</strong></td>
				    <td width="51"><strong>&nbsp;3</strong></td>
				    <td width="58"><strong>&nbsp;2</strong></td>
				    <td width="66"><strong>&nbsp;1</strong></td>
				    <td width="297">&nbsp;</td>
				    <td width="70"><strong>&nbsp;5</strong></td>
				    <td width="69"><strong>&nbsp;4</strong></td>
				    <td width="62"><strong>&nbsp;3</strong></td>
				    <td width="65"><strong>&nbsp;2</strong></td>
				    <td width="60"><strong>&nbsp;1</strong></td>
			      </tr>
				  <tr>
				    <td width="249">&nbsp;PUNCTUALITY</td>
				    <td>&nbsp;<?php if($select->pu == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;HANDWRITING</td>
				    <td>&nbsp;<?php if($select->han == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;CLASSROOM ATTENDANCE</td>
				    <td>&nbsp;<?php if($select->cl == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;FLUENCY</td>
				    <td>&nbsp;<?php if($select->fl == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;CARRYING OUT ASSIGNMENT</td>
				    <td>&nbsp;<?php if($select->car == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;GAMES</td>
				    <td>&nbsp;<?php if($select->ga == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;NEATNESS</td>
				    <td>&nbsp;<?php if($select->ne == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;SPORTS</td>
				    <td>&nbsp;<?php if($select->sp == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;POLITENESS</td>
				    <td>&nbsp;<?php if($select->po == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;GYMNASTICS</td>
				    <td>&nbsp;<?php if($select->gy == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;HONESTY</td>
				    <td>&nbsp;<?php if($select->ho == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;DRAWING &amp; PAINTING</td>
				    <td>&nbsp;<?php if($select->dr == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;SELF CONTROL</td>
				    <td>&nbsp;<?php if($select->se == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;MUSICAL PERFORMANCE</td>
				    <td>&nbsp;<?php if($select->mu == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;RELATIONSHIP WITH OTHERS</td>
				    <td>&nbsp;<?php if($select->re == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;HANDLING TOOLS</td>
				    <td>&nbsp;<?php if($select->ha == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;SENSE OF RESPONSIBILITY</td>
				    <td>&nbsp;<?php if($select->sen == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;CRAFTS</td>
				    <td>&nbsp;<?php if($select->cr == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;OBEDIENCE</td>
				    <td>&nbsp;<?php if($select->ob == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;INITIATIVE</td>
				    <td>&nbsp;<?php if($select->ini == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;ORGANISATIONAL ABILITY</td>
				    <td>&nbsp;<?php if($select->org == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td colspan="8">&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong>KEY TO GRADES</strong></td>
				    <td>&nbsp;</td>
				    <td rowspan="6" class="text-uppercase">&nbsp;</td>
				    <td colspan="4">&nbsp;<strong>KEY TO RATINGS (SECTIONS B AND C)</strong></td>
				    <td colspan="5" rowspan="6">&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;A</td>
				    <td>&nbsp;80 - 100%</td>
				    <td>&nbsp;5</td>
				    <td colspan="3">&nbsp;Maintains an excellent degree of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;B</td>
				    <td>&nbsp;70 - 79%</td>
				    <td>&nbsp;4</td>
				    <td colspan="3">&nbsp;Maintains a high level of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;C</td>
				    <td>&nbsp;60 - 69% </td>
				    <td>&nbsp;3</td>
				    <td colspan="3">&nbsp;Acceptable level of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;P</td>
				    <td>&nbsp;50 - 59% </td>
				    <td>&nbsp;2</td>
				    <td colspan="3">&nbsp;Shows minimal regard for observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;E</td>
				    <td>&nbsp;40 - 49%</td>
				    <td>&nbsp;1</td>
				    <td colspan="3">&nbsp;Has no regard for obsevrable traits</td>
			      </tr>
				  <tr>
				    <td><span class="style4">&nbsp;F</span></td>
				    <td><span class="style4">&nbsp;0 - 39%</span></td>
				    <td colspan="10" class="text-uppercase">&nbsp;</td>
		          </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Head Teacher / Principal's Comment</em></strong></td>
				    <td colspan="11">&nbsp;<?=$select->p_comment;?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Teacher's Comment</em></strong></td>
				    <td colspan="11">&nbsp;<?=$select->tcomment;?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Signature</em></strong></td>
				    <td colspan="11">&nbsp;<img src="<?php echo base_url();?>uploads/signature.png" width="150px" height="50px"></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Date</em></strong></td>
				    <td colspan="11">&nbsp;<?=date('d, M Y')?><span class="float-right"><strong>Next Term Begins:</strong></strong> <?=get_settings('next_term_begin')?></span></td>
			      </tr>
				</table> 
				
				<?php endif;?>	<!-- END OF TERMINAL REPORT THAT CONTAING CA1 AND CA2 AND EXAM SCORES -->
				
				
				

				
				<?php endif;?>	<!-- END OF SECOND TERM GENERAL REPORT FOR CA1 AND CA2 AND EXAM REPORT -->
				<div class="pagebreak"> </div>	
				
				
				<?php if($term == 3) : ?><!-- START OF THIRD TERM GENERAL REPORT FOR CA1 AND CA2 AND EXAM REPORT -->		

				<?php if(get_settings('mid_ter_rep_card') == 1):?><!-- START OF CA1 MID TERM REPORT -->
				
				<table width="100%">
				  <tr>
					<td class="pull-left"><img src="<?php echo base_url()?>uploads/logo.png"  height="150" width="150"></td>
					<td>
						<h2 align="center"><?php echo get_settings('system_name')?></h2>
						<p align="center"><strong>MOTTO: HOME WHERE KNOWLEGE SPEAKS</strong><br><strong>Address:</strong> <?php echo get_settings('address')?> <br/>
						<!--<i class="fa fa-envelope"></i> <?php echo get_settings('system_email')?> : <i class="fa fa-phone"></i> <?php echo get_settings('phone')?>--></p>	
					</td>
					<td class="pull-right"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="150" width="150"></td>
				  </tr>		
				</table>

								
				<table width="100%" height="100" border="1">
				  <tr>
					<td width="322" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;PUPIL'S NAME:</strong></span></td>
					<td width="267" class="text-uppercase">&nbsp;<?=$student_selected['name'];?></td>
					<td width="265" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;CLASS:</strong></span></td>
					<td width="69">&nbsp;<?=$class_name;?></td>
					<td width="233" bgcolor="#CC6600"><span class="style2">&nbsp;TERM:</span></td>
					<td width="92">&nbsp;<?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></td>
				  </tr>
				  <tr>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;ADMISSION NO:</strong></span></td>
					<td>&nbsp;<?=$student_selected['roll'];?></td>
					<td bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SEX:</strong></span></td>
					<td>&nbsp;<?=ucwords($student_selected['sex']);?></td>
					<td bgcolor="#CC6600"><span class="style1">&nbsp;<strong>ACADEMIC YEAR:</strong></span></td>
					<td>&nbsp;<?=$session?></td>
				  </tr>
				  <tr>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) SCHOOL OPEN</strong></span></td>
					<td>&nbsp;
				    <?=$this->db->get_where('attendance', array('session' => $session, 
					'term' => $term))->num_rows(); ?></td>
					<td width="265" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) PRESENT:</strong></span></td>
					<td>&nbsp;<?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 1))->num_rows(); 
						?></td>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) ABSENT:</strong></span></td>
					<td><strong>&nbsp;</strong><?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 2))->num_rows(); 
						?></td>
			      </tr>
			</table>
			
				<table width="100%" border="0">
				  <tr>
					<td align="center" bgcolor="#F0F0F0"><span class="style3">CA1 MID-TERM REPORT FOR 
			        <?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?> 
			        <?=$session?> 
				    ACADEMIC SESSION</span></td>
				  </tr>
				  <tr>
				    <td align="center" bgcolor="#CC6600"><span class="style1">SECTION A: SUBJECTS SCORES </span></td>
			      </tr>
				</table>
				<table width="100%"  border="1">
				  <tr>
					<td valign="top"><strong>&nbsp;ACADEMIC<br>&nbsp;SUBJECTS</strong></td>
					
					<td valign="top"><strong>&nbsp;TOTAL<br>&nbsp;CA(100%)</strong> </td>
					<td valign="top"><strong>&nbsp;ARCHIEVED<br>&nbsp;GRADE</strong> </td>
					<td valign="top"><strong><br>&nbsp;POS</strong> </td>
					<td valign="top"><strong><br>&nbsp;OUT OF</strong> </td>
					<td valign="top"><strong><br>&nbsp;MIN SCORE</strong></td>
					<td valign="top"><strong><br>&nbsp;MAX SCORE</strong> </td>
					<td valign="top"><strong><br>&nbsp;CLASS AVG</strong></td>
					<td valign="top"><strong>&nbsp;TARGET<br>&nbsp;GRADE</strong> </td>
					<td valign="top"><br>&nbsp;<strong>REMARKS</strong> </td>
					<!--<td colspan="2" valign="top">&nbsp;<strong>GRADE SUMMARY</strong> &nbsp;<strong></strong> </td>-->
			      </tr>
				  
				  
                    <?php 
						$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
						foreach ($select_subject as $key => $subject):
					?>
					<tr>
					<td valign="top">&nbsp;<?php echo $subject['name'];?></td>
					
                                        <?php 
										$obtained_mark_query = $this->db->get_where('mark', 
											array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 
											'student_id' => $student_id, 'term' => 3));
                                        
										

                                            $class_score_one    = $obtained_mark_query->row()->class_score1;
                                            $class_score_two    = $obtained_mark_query->row()->class_score2;
                                            $class_score_three  = $obtained_mark_query->row()->class_score3;
											$class_score_four  	= $obtained_mark_query->row()->class_score4;
											$class_score_five  	= $obtained_mark_query->row()->class_score5;
											
                                           /*
										    $class_score_one1    = $obtained_mark_query->row()->class_score11;
                                            $class_score_two2    = $obtained_mark_query->row()->class_score22;
                                            $class_score_three3  = $obtained_mark_query->row()->class_score33;
											$class_score_four4   = $obtained_mark_query->row()->class_score44;
											$class_score_five5   = $obtained_mark_query->row()->class_score55;
											*/
											
											$total_ca_score1 = $class_score_one + $class_score_two + $class_score_three + $class_score_four + $class_score_five;
											$total_ca_score1_percentage = ($total_ca_score1 / 20 * 100);
											
											//$total_ca_score2 = $class_score_one1 + $class_score_two2 + $class_score_three3 + $class_score_four4 + $class_score_five5;
											//$total_ca_score2_percentage = ($total_ca_score2 / 25) * 100;
                                            
											
											
											//$exam_score         = $obtained_mark_query->row()->exam_score;
											//$total_CA        	= $class_score_one; + $class_score_two;//+ $class_score_three;
                                            $total_score        = $total_ca_score1_percentage ;//+ $total_ca_score2_percentage;
											
											if($total_score == ""){
												$total_score = 0;
											}else{
												$total_score = $total_score;	
											}
                                        
										
											$update['sum_third'] = $total_score;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $update);
										
                                        ?>
					
					<td valign="top">&nbsp;<?php if($total_score == 0)echo '';else echo $total_score;?></td>
					<td valign="top">&nbsp;
								<?php if ($total_score <= '100' && $total_score >= '90'):?>
								<?php echo 'A*';?>
								<?php endif;?>
								
								<?php if ($total_score <= '89' && $total_score >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($total_score <= '79' && $total_score >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($total_score <= "59" && $total_score >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>

								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>					
					</td>
					
					<td valign="top">&nbsp;
					
										<?php
										
										$subject_id = $subject['subject_id'];
 										$sql = "SELECT mark_id, sum_third, FIND_IN_SET( sum_third,(
												SELECT GROUP_CONCAT( sum_third  ORDER BY sum_third DESC ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND sum_third = $total_score AND sum_third != 0"; 
        
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
					<td valign="top">&nbsp;<?=$number_class?></td>
					
					<td valign="top">&nbsp;
                        <?php echo $lowest_mark = $this->crud_model->get_lowest_marks_first( $exam_id , $class_id , $subject['subject_id'], 3 );?>					
					</td>
					<td valign="top">&nbsp;
						<?php echo $highest_mark = $this->crud_model->get_highest_marks_first( $exam_id , $class_id , $subject['subject_id'], 3 ); ?>					
					</td>

					
					<td valign="top">&nbsp;
					
                                <?php 
								$set = $session;
                                $this->db->select_sum('sum_third');
                                $this->db->from('mark');
                                $this->db->where('subject_id', $subject_id);
								$this->db->where('term', 3);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_third;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;
								}
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 
									'subject_id' => $subject_id))->num_rows();
									
                                ?>	
								<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?>		
					</td>
					<td valign="top">&nbsp;A</td>
					<td valign="top">&nbsp;
					
								<?php if ($total_score <= '100' && $total_score >= '90'):?>
								<?php echo 'EXCELLENT';?>
								<?php endif;?>
								
								<?php if ($total_score <= '89' && $total_score >= '80'):?>
								<?php echo 'VERY GOOD';?>
								<?php endif;?>
								
								<?php if ($total_score <= '79' && $total_score >= '70'):?>
								<?php echo 'GOOD';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'CREDIT';?>
								<?php endif;?>
								
								<?php if ($total_score <= "59" && $total_score >= '50'):?>
								<?php echo 'PASS';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>
								<?php echo 'FAIL';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '30'):?>
								<?php echo 'FAIL';?>
								<?php endif;?>
					<?php //echo $obtained_mark_query->row()->ca1_comment;?>
					</td>
					<!--
					<td valign="top">&nbsp;A</td>
					<td valign="top">&nbsp;1</td>
					-->
				  </tr>
				  <?php endforeach;?>
				</table>
				<table width="100%" border="0">
				  <tr>
					<td style="background:white; color:black"><span class="pull-left"><strong>GRADE SUMMARY</strong>:</span><span class="pull-right"><strong>Number of Subject Offered: 
					
						<?php
						
								$set = $session;
                                $this->db->select_sum('sum_third');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 3);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_third;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered2 = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 
									'student_id' => $student_id))->num_rows();
								echo $getSubjectNumbered2;
						?>
					</strong> </span><br>
					A* = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 'student_id' => $student_id, 'sum_third>=' => 90, 'sum_third<=' => 100))->num_rows();?>
					A = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 'student_id' => $student_id, 'sum_third>=' => 80, 'sum_third<=' => 89))->num_rows();?>
					B = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 'student_id' => $student_id, 'sum_third>=' => 70, 'sum_third<=' => 79))->num_rows();?>
					C = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 'student_id' => $student_id, 'sum_third>=' => 60, 'sum_third<=' => 69))->num_rows();?>
					D = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 'student_id' => $student_id, 'sum_third>=' => 50, 'sum_third<=' => 59))->num_rows();?>
					E = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 'student_id' => $student_id, 'sum_third>=' => 40, 'sum_third<=' => 49))->num_rows();?>
					F = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 'student_id' => $student_id, 'sum_third>=' => 30, 'sum_third<=' => 39))->num_rows();?> 
					</td>
				  </tr>
				  
				
				<table width="100%" border="1">
				  <tr>
					<td width="186"><strong>&nbsp;Class Position:</strong></td>
					<td width="89" class="text-uppercase">&nbsp;
					
					
										<?php
										
										
								$set = $session;
                                $this->db->select_sum('sum_third');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 3);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_third;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 
									'student_id' => $student_id))->num_rows();
									
									
									$updatePercetangeFirst = round($sumTotalOfFirstScore/$getSubjectNumbered);
									if(is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = 0;
									}
									if(!is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = $updatePercetangeFirst;
									}
											
											$class_position_ca1['class_position_ca1'] = $updatePercetangeFirst;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $class_position_ca1);
										
										
										
										
 										$sql = "SELECT mark_id, class_position_ca1, FIND_IN_SET( class_position_ca1,(
												SELECT GROUP_CONCAT( class_position_ca1  ORDER BY class_position_ca1 desc ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND class_position_ca1 = $updatePercetangeFirst AND class_position_ca1 != 0"; 
        
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
					<td width="155"><strong>&nbsp;Total Score:</strong></td>
					<td width="119">&nbsp;
								<?php
								$set = $session;
                                $this->db->select_sum('sum_third');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 3);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_third;
								
									if($sumTotalOfFirstScore == ""){
										echo $sumTotalOfFirstScore = 0;
									}else{
										echo $sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
							?>					
					</td>
					<td colspan="2"><strong>&nbsp;<strong>Final Average</strong>:</strong></td>
					<td width="171">&nbsp;
					<?php 
					
								$set = $session;
                                $this->db->select_sum('sum_third');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 3);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_third;
								
									if($sumTotalOfFirstScore == ""){
										$sumTotalOfFirstScore = 0;
									}else{
										$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
								
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 
									'student_id' => $student_id))->num_rows();		
					?>
					
					<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?> %					
					</td>
				    <td width="">&nbsp;<strong>Final Grade</strong> </td>
				    <td width="75">&nbsp;
								<?php $FindGrade = round($sumTotalOfFirstScore /$getSubjectNumbered,2);?>
								<?php if ($FindGrade <= '100' && $FindGrade >= '90'):?>
								<?php echo 'A*';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '89' && $FindGrade >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '79' && $FindGrade >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '69' && $FindGrade >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "59" && $FindGrade >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "49" && $FindGrade >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "39" && $FindGrade >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					
					</td>
				  </tr>
				</table>
				
				
				
					<?php 
						$session = $session;
						$select = $this->db->get_where('diamond_stu_comment', array('student_id' => $student_id, 'session' => $session, 'term' => $term, 'status' => 1))->row();
					?>
				<table width="100%" border="1">
				  <tr>
					<td colspan="6" bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SECTION B: EFFECTIVE GENERAL BEHAVIOUR</strong></span></td>
					<td colspan="6" bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SECTION C: (PSYCHOMOTOR) SKILL </strong></span></td>
				  </tr>
				  <tr>
				    <td width="249">&nbsp;</td>
				    <td width="104"><strong>&nbsp;5</strong></td>
				    <td width="61" class="text-uppercase"><strong>&nbsp;4</strong></td>
				    <td width="51"><strong>&nbsp;3</strong></td>
				    <td width="58"><strong>&nbsp;2</strong></td>
				    <td width="66"><strong>&nbsp;1</strong></td>
				    <td width="297">&nbsp;</td>
				    <td width="70"><strong>&nbsp;5</strong></td>
				    <td width="69"><strong>&nbsp;4</strong></td>
				    <td width="62"><strong>&nbsp;3</strong></td>
				    <td width="65"><strong>&nbsp;2</strong></td>
				    <td width="60"><strong>&nbsp;1</strong></td>
			      </tr>
				  <tr>
				    <td width="249">&nbsp;PUNCTUALITY</td>
				    <td>&nbsp;<?php if($select->pu == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;HANDWRITING</td>
				    <td>&nbsp;<?php if($select->han == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;CLASSROOM ATTENDANCE</td>
				    <td>&nbsp;<?php if($select->cl == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;FLUENCY</td>
				    <td>&nbsp;<?php if($select->fl == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;CARRYING OUT ASSIGNMENT</td>
				    <td>&nbsp;<?php if($select->car == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;GAMES</td>
				    <td>&nbsp;<?php if($select->ga == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;NEATNESS</td>
				    <td>&nbsp;<?php if($select->ne == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;SPORTS</td>
				    <td>&nbsp;<?php if($select->sp == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;POLITENESS</td>
				    <td>&nbsp;<?php if($select->po == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;GYMNASTICS</td>
				    <td>&nbsp;<?php if($select->gy == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;HONESTY</td>
				    <td>&nbsp;<?php if($select->ho == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;DRAWING &amp; PAINTING</td>
				    <td>&nbsp;<?php if($select->dr == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;SELF CONTROL</td>
				    <td>&nbsp;<?php if($select->se == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;MUSICAL PERFORMANCE</td>
				    <td>&nbsp;<?php if($select->mu == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;RELATIONSHIP WITH OTHERS</td>
				    <td>&nbsp;<?php if($select->re == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;HANDLING TOOLS</td>
				    <td>&nbsp;<?php if($select->ha == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;SENSE OF RESPONSIBILITY</td>
				    <td>&nbsp;<?php if($select->sen == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;CRAFTS</td>
				    <td>&nbsp;<?php if($select->cr == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;OBEDIENCE</td>
				    <td>&nbsp;<?php if($select->ob == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;INITIATIVE</td>
				    <td>&nbsp;<?php if($select->ini == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;ORGANISATIONAL ABILITY</td>
				    <td>&nbsp;<?php if($select->org == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td colspan="8">&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong>KEY TO GRADES</strong></td>
				    <td>&nbsp;</td>
				    <td rowspan="6" class="text-uppercase">&nbsp;</td>
				    <td colspan="4">&nbsp;<strong>KEY TO RATINGS (SECTIONS B AND C)</strong></td>
				    <td colspan="5" rowspan="6">&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;A</td>
				    <td>&nbsp;80 - 100%</td>
				    <td>&nbsp;5</td>
				    <td colspan="3">&nbsp;Maintains an excellent degree of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;B</td>
				    <td>&nbsp;70 - 79%</td>
				    <td>&nbsp;4</td>
				    <td colspan="3">&nbsp;Maintains a high level of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;C</td>
				    <td>&nbsp;60 - 69% </td>
				    <td>&nbsp;3</td>
				    <td colspan="3">&nbsp;Acceptable level of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;P</td>
				    <td>&nbsp;50 - 59% </td>
				    <td>&nbsp;2</td>
				    <td colspan="3">&nbsp;Shows minimal regard for observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;E</td>
				    <td>&nbsp;40 - 49%</td>
				    <td>&nbsp;1</td>
				    <td colspan="3">&nbsp;Has no regard for obsevrable traits</td>
			      </tr>
				  <tr>
				    <td><span class="style4">&nbsp;F</span></td>
				    <td><span class="style4">&nbsp;0 - 39%</span></td>
				    <td colspan="10" class="text-uppercase">&nbsp;</td>
		          </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Head Teacher / Principal's Comment</em></strong></td>
				    <td colspan="11">&nbsp;<?=$select->p_comment;?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Teacher's Comment</em></strong></td>
				    <td colspan="11">&nbsp;<?=$select->tcomment;?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Signature</em></strong></td>
				    <td colspan="11">&nbsp;<img src="<?php echo base_url();?>uploads/signature.png" width="150px" height="50px"></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Date</em></strong></td>
				    <td colspan="11">&nbsp;<?=date('d, M Y')?><span class="float-right"><strong>Next Term Begins:</strong></strong> <?=get_settings('next_term_begin')?></span></td>
			      </tr>
				</table>
				<?php endif;?>	<!-- END OF CA1 MID TERM REPORT -->
				
				

				
				<?php if(get_settings('mid_ter_rep_card') == 2):?><!-- START OF CA2 MID TERM REPORT -->
				
				<table width="100%">
				  <tr>
					<td class="pull-left"><img src="<?php echo base_url()?>uploads/logo.png"  height="150" width="150"></td>
					<td>
						<h2 align="center"><?php echo get_settings('system_name')?></h2>
						<p align="center"><strong>MOTTO: HOME WHERE KNOWLEGE SPEAKS</strong><br><strong>Address:</strong> <?php echo get_settings('address')?> <br/>
						<!--<i class="fa fa-envelope"></i> <?php echo get_settings('system_email')?> : <i class="fa fa-phone"></i> <?php echo get_settings('phone')?>--></p>	
					</td>
					<td class="pull-right"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="150" width="150"></td>
				  </tr>		
				</table>

								
				<table width="100%" height="100" border="1">
				  <tr>
					<td width="322" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;PUPIL'S NAME:</strong></span></td>
					<td width="267" class="text-uppercase">&nbsp;<?=$student_selected['name'];?></td>
					<td width="265" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;CLASS:</strong></span></td>
					<td width="69">&nbsp;<?=$class_name;?></td>
					<td width="233" bgcolor="#CC6600"><span class="style2">&nbsp;TERM:</span></td>
					<td width="92">&nbsp;<?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></td>
				  </tr>
				  <tr>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;ADMISSION NO:</strong></span></td>
					<td>&nbsp;<?=$student_selected['roll'];?></td>
					<td bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SEX:</strong></span></td>
					<td>&nbsp;<?=ucwords($student_selected['sex']);?></td>
					<td bgcolor="#CC6600"><span class="style1">&nbsp;<strong>ACADEMIC YEAR:</strong></span></td>
					<td>&nbsp;<?=$session?></td>
				  </tr>
				  <tr>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) SCHOOL OPEN</strong></span></td>
					<td>&nbsp;
				    <?=$this->db->get_where('attendance', array('session' => $session, 
					'term' => $term))->num_rows(); ?></td>
					<td width="265" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) PRESENT:</strong></span></td>
					<td>&nbsp;<?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 1))->num_rows(); 
						?></td>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) ABSENT:</strong></span></td>
					<td><strong>&nbsp;</strong><?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 2))->num_rows(); 
						?></td>
			      </tr>
			</table>
			
				<table width="100%" border="0">
				  <tr>
					<td align="center" bgcolor="#F0F0F0"><span class="style3">CA1 MID-TERM REPORT FOR 
			        <?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?> 
			        <?=$session?> 
				    ACADEMIC SESSION</span></td>
				  </tr>
				  <tr>
				    <td align="center" bgcolor="#CC6600"><span class="style1">SECTION A: SUBJECTS SCORES </span></td>
			      </tr>
				</table>
				<table width="100%"  border="1">
				  <tr>
					<td valign="top"><strong>&nbsp;ACADEMIC<br>&nbsp;SUBJECTS</strong></td>
					
					<td valign="top"><strong>&nbsp;TOTAL<br>&nbsp;CA(100%)</strong> </td>
					<td valign="top"><strong>&nbsp;ARCHIEVED<br>&nbsp;GRADE</strong> </td>
					<td valign="top"><strong><br>&nbsp;POS</strong> </td>
					<td valign="top"><strong><br>&nbsp;OUT OF</strong> </td>
					<td valign="top"><strong><br>&nbsp;MIN SCORE</strong></td>
					<td valign="top"><strong><br>&nbsp;MAX SCORE</strong> </td>
					<td valign="top"><strong><br>&nbsp;CLASS AVG</strong></td>
					<td valign="top"><strong>&nbsp;TARGET<br>&nbsp;GRADE</strong> </td>
					<td valign="top"><br>&nbsp;<strong>REMARKS</strong> </td>
					<!--<td colspan="2" valign="top">&nbsp;<strong>GRADE SUMMARY</strong> &nbsp;<strong></strong> </td>-->
			      </tr>
				  
				  
                    <?php 
						$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
						foreach ($select_subject as $key => $subject):
					?>
					<tr>
					<td valign="top">&nbsp;<?php echo $subject['name'];?></td>
					
                                        <?php 
										$obtained_mark_query = $this->db->get_where('mark', 
											array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 
											'student_id' => $student_id, 'term' => 3));
                                        
										

										    $class_score_one1    = $obtained_mark_query->row()->class_score11;
                                            $class_score_two2    = $obtained_mark_query->row()->class_score22;
                                            $class_score_three3  = $obtained_mark_query->row()->class_score33;
											$class_score_four4   = $obtained_mark_query->row()->class_score44;
											$class_score_five5   = $obtained_mark_query->row()->class_score55;
											
											
											$total_ca_score2 = $class_score_one1 + $class_score_two2 + $class_score_three3 + $class_score_four4 + $class_score_five5;
											$total_ca_score2_percentage = ($total_ca_score2 / 20 * 100);
											
										
                                            $total_score        = $total_ca_score2_percentage ;
											
											if($total_score == ""){
												$total_score = 0;
											}else{
												$total_score = $total_score;	
											}
                                        
										
											$update['sum_third'] = $total_score;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $update);
										
                                        ?>
					
					<td valign="top">&nbsp;<?php if($total_score == 0)echo '';else echo $total_score;?></td>
					<td valign="top">&nbsp;
								<?php if ($total_score <= '100' && $total_score >= '90'):?>
								<?php echo 'A*';?>
								<?php endif;?>
								
								<?php if ($total_score <= '89' && $total_score >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($total_score <= '79' && $total_score >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($total_score <= "59" && $total_score >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>

								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>					
					</td>
					
					<td valign="top">&nbsp;
					
										<?php
										
										$subject_id = $subject['subject_id'];
 										$sql = "SELECT mark_id, sum_third, FIND_IN_SET( sum_third,(
												SELECT GROUP_CONCAT( sum_third  ORDER BY sum_third DESC ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND sum_third = $total_score AND sum_third != 0"; 
        
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
					<td valign="top">&nbsp;<?=$number_class?></td>
					
					<td valign="top">&nbsp;
                        <?php echo $lowest_mark = $this->crud_model->get_lowest_marks_first( $exam_id , $class_id , $subject['subject_id'], 3 );?>					
					</td>
					<td valign="top">&nbsp;
						<?php echo $highest_mark = $this->crud_model->get_highest_marks_first( $exam_id , $class_id , $subject['subject_id'], 3 ); ?>					
					</td>

					
					<td valign="top">&nbsp;
					
                                <?php 
								$set = $session;
                                $this->db->select_sum('sum_third');
                                $this->db->from('mark');
                                $this->db->where('subject_id', $subject_id);
								$this->db->where('term', 3);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_third;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;
								}
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 
									'subject_id' => $subject_id))->num_rows();
									
                                ?>	
								<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?>		
					</td>
					<td valign="top">&nbsp;A</td>
					<td valign="top">&nbsp;
					
								<?php if ($total_score <= '100' && $total_score >= '90'):?>
								<?php echo 'EXCELLENT';?>
								<?php endif;?>
								
								<?php if ($total_score <= '89' && $total_score >= '80'):?>
								<?php echo 'VERY GOOD';?>
								<?php endif;?>
								
								<?php if ($total_score <= '79' && $total_score >= '70'):?>
								<?php echo 'GOOD';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'CREDIT';?>
								<?php endif;?>
								
								<?php if ($total_score <= "59" && $total_score >= '50'):?>
								<?php echo 'PASS';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>
								<?php echo 'FAIL';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '30'):?>
								<?php echo 'FAIL';?>
								<?php endif;?>
					<?php //echo $obtained_mark_query->row()->ca1_comment;?>
					</td>
					<!--
					<td valign="top">&nbsp;A</td>
					<td valign="top">&nbsp;1</td>
					-->
				  </tr>
				  <?php endforeach;?>
				</table>
				<table width="100%" border="0">
				  <tr>
					<td style="background:white; color:black"><span class="pull-left"><strong>GRADE SUMMARY</strong>:</span><span class="pull-right"><strong>Number of Subject Offered: 
					
						<?php
						
								$set = $session;
                                $this->db->select_sum('sum_third');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 3);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_third;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered2 = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 
									'student_id' => $student_id))->num_rows();
								echo $getSubjectNumbered2;
						?>
					</strong> </span><br>
					A* = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 'student_id' => $student_id, 'sum_third>=' => 90, 'sum_third<=' => 100))->num_rows();?>
					A = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 'student_id' => $student_id, 'sum_third>=' => 80, 'sum_third<=' => 89))->num_rows();?>
					B = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 'student_id' => $student_id, 'sum_third>=' => 70, 'sum_third<=' => 79))->num_rows();?>
					C = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 'student_id' => $student_id, 'sum_third>=' => 60, 'sum_third<=' => 69))->num_rows();?>
					D = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 'student_id' => $student_id, 'sum_third>=' => 50, 'sum_third<=' => 59))->num_rows();?>
					E = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 'student_id' => $student_id, 'sum_third>=' => 40, 'sum_third<=' => 49))->num_rows();?>
					F = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 'student_id' => $student_id, 'sum_third>=' => 30, 'sum_third<=' => 39))->num_rows();?> 
					</td>
				  </tr>
				  
				
				<table width="100%" border="1">
				  <tr>
					<td width="186"><strong>&nbsp;Class Position:</strong></td>
					<td width="89" class="text-uppercase">&nbsp;
					
					
										<?php
										
										
								$set = $session;
                                $this->db->select_sum('sum_third');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 3);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_third;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 
									'student_id' => $student_id))->num_rows();
									
									
									$updatePercetangeFirst = round($sumTotalOfFirstScore/$getSubjectNumbered);
									if(is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = 0;
									}
									if(!is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = $updatePercetangeFirst;
									}
											
											$class_position_ca2['class_position_ca2'] = $updatePercetangeFirst;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $class_position_ca2);
										
										
										
										
 										$sql = "SELECT mark_id, class_position_ca2, FIND_IN_SET( class_position_ca2,(
												SELECT GROUP_CONCAT( class_position_ca2  ORDER BY class_position_ca2 desc ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND class_position_ca2 = $updatePercetangeFirst AND class_position_ca2 != 0"; 
        
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
					<td width="155"><strong>&nbsp;Total Score:</strong></td>
					<td width="119">&nbsp;
								<?php
								$set = $session;
                                $this->db->select_sum('sum_third');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 3);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_third;
								
									if($sumTotalOfFirstScore == ""){
										echo $sumTotalOfFirstScore = 0;
									}else{
										echo $sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
							?>					
					</td>
					<td colspan="2"><strong>&nbsp;<strong>Final Average</strong>:</strong></td>
					<td width="171">&nbsp;
					<?php 
					
								$set = $session;
                                $this->db->select_sum('sum_third');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 3);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_third;
								
									if($sumTotalOfFirstScore == ""){
										$sumTotalOfFirstScore = 0;
									}else{
										$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
								
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 
									'student_id' => $student_id))->num_rows();		
					?>
					
					<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?> %					
					</td>
				    <td width="">&nbsp;<strong>Final Grade</strong> </td>
				    <td width="75">&nbsp;
								<?php $FindGrade = round($sumTotalOfFirstScore /$getSubjectNumbered,2);?>
								<?php if ($FindGrade <= '100' && $FindGrade >= '90'):?>
								<?php echo 'A*';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '89' && $FindGrade >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '79' && $FindGrade >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '69' && $FindGrade >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "59" && $FindGrade >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "49" && $FindGrade >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "39" && $FindGrade >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					
					</td>
				  </tr>
				</table>
				
				
				
					<?php 
						$session = $session;
						$select = $this->db->get_where('diamond_stu_comment', array('student_id' => $student_id, 'session' => $session, 'term' => $term, 'status' => 2))->row();
					?>
				<table width="100%" border="1">
				  <tr>
					<td colspan="6" bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SECTION B: EFFECTIVE GENERAL BEHAVIOUR</strong></span></td>
					<td colspan="6" bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SECTION C: (PSYCHOMOTOR) SKILL </strong></span></td>
				  </tr>
				  <tr>
				    <td width="249">&nbsp;</td>
				    <td width="104"><strong>&nbsp;5</strong></td>
				    <td width="61" class="text-uppercase"><strong>&nbsp;4</strong></td>
				    <td width="51"><strong>&nbsp;3</strong></td>
				    <td width="58"><strong>&nbsp;2</strong></td>
				    <td width="66"><strong>&nbsp;1</strong></td>
				    <td width="297">&nbsp;</td>
				    <td width="70"><strong>&nbsp;5</strong></td>
				    <td width="69"><strong>&nbsp;4</strong></td>
				    <td width="62"><strong>&nbsp;3</strong></td>
				    <td width="65"><strong>&nbsp;2</strong></td>
				    <td width="60"><strong>&nbsp;1</strong></td>
			      </tr>
				  <tr>
				    <td width="249">&nbsp;PUNCTUALITY</td>
				    <td>&nbsp;<?php if($select->pu == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;HANDWRITING</td>
				    <td>&nbsp;<?php if($select->han == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;CLASSROOM ATTENDANCE</td>
				    <td>&nbsp;<?php if($select->cl == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;FLUENCY</td>
				    <td>&nbsp;<?php if($select->fl == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;CARRYING OUT ASSIGNMENT</td>
				    <td>&nbsp;<?php if($select->car == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;GAMES</td>
				    <td>&nbsp;<?php if($select->ga == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;NEATNESS</td>
				    <td>&nbsp;<?php if($select->ne == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;SPORTS</td>
				    <td>&nbsp;<?php if($select->sp == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;POLITENESS</td>
				    <td>&nbsp;<?php if($select->po == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;GYMNASTICS</td>
				    <td>&nbsp;<?php if($select->gy == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;HONESTY</td>
				    <td>&nbsp;<?php if($select->ho == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;DRAWING &amp; PAINTING</td>
				    <td>&nbsp;<?php if($select->dr == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;SELF CONTROL</td>
				    <td>&nbsp;<?php if($select->se == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;MUSICAL PERFORMANCE</td>
				    <td>&nbsp;<?php if($select->mu == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;RELATIONSHIP WITH OTHERS</td>
				    <td>&nbsp;<?php if($select->re == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;HANDLING TOOLS</td>
				    <td>&nbsp;<?php if($select->ha == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;SENSE OF RESPONSIBILITY</td>
				    <td>&nbsp;<?php if($select->sen == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;CRAFTS</td>
				    <td>&nbsp;<?php if($select->cr == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;OBEDIENCE</td>
				    <td>&nbsp;<?php if($select->ob == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;INITIATIVE</td>
				    <td>&nbsp;<?php if($select->ini == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;ORGANISATIONAL ABILITY</td>
				    <td>&nbsp;<?php if($select->org == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td colspan="8">&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong>KEY TO GRADES</strong></td>
				    <td>&nbsp;</td>
				    <td rowspan="6" class="text-uppercase">&nbsp;</td>
				    <td colspan="4">&nbsp;<strong>KEY TO RATINGS (SECTIONS B AND C)</strong></td>
				    <td colspan="5" rowspan="6">&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;A</td>
				    <td>&nbsp;80 - 100%</td>
				    <td>&nbsp;5</td>
				    <td colspan="3">&nbsp;Maintains an excellent degree of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;B</td>
				    <td>&nbsp;70 - 79%</td>
				    <td>&nbsp;4</td>
				    <td colspan="3">&nbsp;Maintains a high level of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;C</td>
				    <td>&nbsp;60 - 69% </td>
				    <td>&nbsp;3</td>
				    <td colspan="3">&nbsp;Acceptable level of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;P</td>
				    <td>&nbsp;50 - 59% </td>
				    <td>&nbsp;2</td>
				    <td colspan="3">&nbsp;Shows minimal regard for observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;E</td>
				    <td>&nbsp;40 - 49%</td>
				    <td>&nbsp;1</td>
				    <td colspan="3">&nbsp;Has no regard for obsevrable traits</td>
			      </tr>
				  <tr>
				    <td><span class="style4">&nbsp;F</span></td>
				    <td><span class="style4">&nbsp;0 - 39%</span></td>
				    <td colspan="10" class="text-uppercase">&nbsp;</td>
		          </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Head Teacher / Principal's Comment</em></strong></td>
				    <td colspan="11">&nbsp;<?=$select->p_comment;?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Teacher's Comment</em></strong></td>
				    <td colspan="11">&nbsp;<?=$select->tcomment;?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Signature</em></strong></td>
				    <td colspan="11">&nbsp;<img src="<?php echo base_url();?>uploads/signature.png" width="150px" height="50px"></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Date</em></strong></td>
				    <td colspan="11">&nbsp;<?=date('d, M Y')?><span class="float-right"><strong>Next Term Begins:</strong></strong> <?=get_settings('next_term_begin')?></span></td>
			      </tr>
				</table>
				
				<?php endif;?>	<!-- END OF CA2 MID TERM REPORT -->
				
				
				
				<?php if(get_settings('mid_ter_rep_card') == 3):?><!-- START OF TERMINAL REPORT THAT CONTAING CA1 AND CA2 AND EXAM SCORES -->
				
				<table width="100%">
				  <tr>
					<td class="pull-left"><img src="<?php echo base_url()?>uploads/logo.png"  height="150" width="150"></td>
					<td>
						<h2 align="center"><?php echo get_settings('system_name')?></h2>
						<p align="center"><strong>MOTTO: HOME WHERE KNOWLEGE SPEAKS</strong><br><strong>Address:</strong> <?php echo get_settings('address')?> <br/>
						<!--<i class="fa fa-envelope"></i> <?php echo get_settings('system_email')?> : <i class="fa fa-phone"></i> <?php echo get_settings('phone')?>--></p>	
					</td>
					<td class="pull-right"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="150" width="150"></td>
				  </tr>		
				</table>

								
				<table width="100%" height="100" border="1">
				  <tr>
					<td width="322" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;PUPIL'S NAME:</strong></span></td>
					<td width="267" class="text-uppercase">&nbsp;<?=$student_selected['name'];?></td>
					<td width="265" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;CLASS:</strong></span></td>
					<td width="69">&nbsp;<?=$class_name;?></td>
					<td width="233" bgcolor="#CC6600"><span class="style2">&nbsp;TERM:</span></td>
					<td width="92">&nbsp;<?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></td>
				  </tr>
				  <tr>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;ADMISSION NO:</strong></span></td>
					<td>&nbsp;<?=$student_selected['roll'];?></td>
					<td bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SEX:</strong></span></td>
					<td>&nbsp;<?=ucwords($student_selected['sex']);?></td>
					<td bgcolor="#CC6600"><span class="style1">&nbsp;<strong>ACADEMIC YEAR:</strong></span></td>
					<td>&nbsp;<?=$session?></td>
				  </tr>
				  <tr>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) SCHOOL OPEN</strong></span></td>
					<td>&nbsp;
				    <?=$this->db->get_where('attendance', array('session' => $session, 
					'term' => $term))->num_rows(); ?></td>
					<td width="265" bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) PRESENT:</strong></span></td>
					<td>&nbsp;<?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 1))->num_rows(); 
						?></td>
					<td bgcolor="#CC6600"><span class="style1"><strong>&nbsp;DAY(S) ABSENT:</strong></span></td>
					<td><strong>&nbsp;</strong><?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,
						'student_id' => $student_id,'session' => $session, 'status' => 2))->num_rows(); 
						?></td>
			      </tr>
			</table>
			
				<table width="100%" border="0">
				  <tr>
					<td align="center" bgcolor="#F0F0F0"><span class="style3">TERMINAL REPORT FOR 
			        <?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?> 
			        <?=$session?> 
				    ACADEMIC SESSION</span></td>
				  </tr>
				  <tr>
				    <td align="center" bgcolor="#CC6600"><span class="style1">SECTION A: SUBJECTS SCORES </span></td>
			      </tr>
				</table>
				<table width="100%"  border="1">
				  <tr>
					<td valign="top"><strong>&nbsp;ACADEMIC<br>&nbsp;SUBJECTS</strong></td>
					
					<td valign="top"><strong>&nbsp;CA</strong> </td>
					<td valign="top"><strong>&nbsp;EXAM</strong> </td>
					<td valign="top"><strong>&nbsp;TOTAL</strong> </td>
					<td valign="top"><strong>&nbsp;ARCHIEVED<br>&nbsp;GRADE</strong> </td>
					<td valign="top"><strong><br>&nbsp;POS</strong> </td>
					<td valign="top"><strong><br>&nbsp;OUT OF</strong> </td>
					<td valign="top"><strong><br>&nbsp;MIN SCORE</strong></td>
					<td valign="top"><strong><br>&nbsp;MAX SCORE</strong> </td>
					<td valign="top"><strong><br>&nbsp;CLASS AVG</strong></td>
					<td valign="top"><br>&nbsp;<strong>REMARKS</strong> </td>
					<!--<td colspan="2" valign="top">&nbsp;<strong>GRADE SUMMARY</strong> &nbsp;<strong></strong> </td>-->
			      </tr>
				  
				  
<?php 
						$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
						foreach ($select_subject as $key => $subject):
					?>
					<tr>
					<td valign="top">&nbsp;<?php echo $subject['name'];?></td>
					
                                        <?php 
										$obtained_mark_query = $this->db->get_where('mark', 
											array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 
											'student_id' => $student_id, 'term' => 3));
                                        
										

                                            $class_score_one    = $obtained_mark_query->row()->class_score1;
                                            $class_score_two    = $obtained_mark_query->row()->class_score2;
                                            $class_score_three  = $obtained_mark_query->row()->class_score3;
											$class_score_four  	= $obtained_mark_query->row()->class_score4;
											$class_score_five  	= $obtained_mark_query->row()->class_score5;
											
                                          
										    $class_score_one1    = $obtained_mark_query->row()->class_score11;
                                            $class_score_two2    = $obtained_mark_query->row()->class_score22;
                                            $class_score_three3  = $obtained_mark_query->row()->class_score33;
											$class_score_four4   = $obtained_mark_query->row()->class_score44;
											$class_score_five5   = $obtained_mark_query->row()->class_score55;
											
											$total_ca_score1 = $class_score_one + $class_score_two + $class_score_three + $class_score_four + $class_score_five;
											$total_ca_score2 = $class_score_one1 + $class_score_two2 + $class_score_three3 + $class_score_four4 + $class_score_five5;
											$total_ca_score1_and_two = $total_ca_score1 + $total_ca_score2;
											
											$exam_score         = $obtained_mark_query->row()->exam_score;
                                            $total_score        = $total_ca_score1_and_two + $exam_score;
											
											if($total_score == ""){
												$total_score = 0;
											}else{
												$total_score = $total_score;	
											}
                                        
										
											$update['sum_third'] = $total_score;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $update);
										
                                        ?>
					<td valign="top">&nbsp;<?php if($total_ca_score1_and_two == 0)echo '';else echo $total_ca_score1_and_two;?></td>
					<td valign="top">&nbsp;<?php if($exam_score == 0)echo '';else echo $exam_score;?></td>
					<td valign="top">&nbsp;<?php if($total_score == 0)echo '';else echo $total_score;?></td>
					<td valign="top">&nbsp;
								<?php if ($total_score <= '100' && $total_score >= '90'):?>
								<?php echo 'A*';?>
								<?php endif;?>
								
								<?php if ($total_score <= '89' && $total_score >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($total_score <= '79' && $total_score >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($total_score <= "59" && $total_score >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>					
					</td>
					
					<td valign="top">&nbsp;
					
										<?php
										
										$subject_id = $subject['subject_id'];
 										$sql = "SELECT mark_id, sum_third, FIND_IN_SET( sum_third,(
												SELECT GROUP_CONCAT( sum_third  ORDER BY sum_third DESC ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND sum_third = $total_score AND sum_third != 0"; 
        
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
					<td valign="top">&nbsp;<?=$number_class?></td>
					
					<td valign="top">&nbsp;
                        <?php echo $lowest_mark = $this->crud_model->get_lowest_marks_first( $exam_id , $class_id , $subject['subject_id'], 3 );?>					
					</td>
					<td valign="top">&nbsp;
						<?php echo $highest_mark = $this->crud_model->get_highest_marks_first( $exam_id , $class_id , $subject['subject_id'], 3 ); ?>					
					</td>

					
					<td valign="top">&nbsp;
					
                              <?php 
								$set = $session;
                                $this->db->select_sum('sum_third');
                                $this->db->from('mark');
                                $this->db->where('subject_id', $subject_id);
								$this->db->where('term', 3);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_third;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 
									'subject_id' => $subject_id))->num_rows();
                                ?>	
								<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?>		
					</td>
					<td valign="top">&nbsp;
					
								<?php if ($total_score <= '100' && $total_score >= '90'):?>
								<?php echo 'EXCELLENT';?>
								<?php endif;?>
								
								<?php if ($total_score <= '89' && $total_score >= '80'):?>
								<?php echo 'VERY GOOD';?>
								<?php endif;?>
								
								<?php if ($total_score <= '79' && $total_score >= '70'):?>
								<?php echo 'GOOD';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'CREDIT';?>
								<?php endif;?>
								
								<?php if ($total_score <= "59" && $total_score >= '50'):?>
								<?php echo 'PASS';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '40'):?>
								<?php echo 'FAIL';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '30'):?>
								<?php echo 'FAIL';?>
								<?php endif;?>
					
					</td>
					
				  </tr>
				  <?php endforeach;?>
				</table>
				<table width="100%" border="0">
				  <tr>
					<td style="background:white; color:black"><span class="pull-left"><strong>GRADE SUMMARY</strong>:</span><span class="pull-right"><strong>Number of Subject Offered: 
					
						<?php
						
								$set = $session;
                                $this->db->select_sum('sum_third');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 3);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_third;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered2 = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 
									'student_id' => $student_id))->num_rows();
								echo $getSubjectNumbered2;
						?>
					</strong> </span><br>
					A* = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 'student_id' => $student_id, 'sum_third>=' => 90, 'sum_third<=' => 100))->num_rows();?>
					A = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 'student_id' => $student_id, 'sum_third>=' => 80, 'sum_third<=' => 89))->num_rows();?>
					B = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 'student_id' => $student_id, 'sum_third>=' => 70, 'sum_third<=' => 79))->num_rows();?>
					C = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 'student_id' => $student_id, 'sum_third>=' => 60, 'sum_third<=' => 69))->num_rows();?>
					D = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 'student_id' => $student_id, 'sum_third>=' => 50, 'sum_third<=' => 59))->num_rows();?>
					E = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 'student_id' => $student_id, 'sum_third>=' => 40, 'sum_third<=' => 49))->num_rows();?>
					F = <?=$this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 'student_id' => $student_id, 'sum_third>=' => 30, 'sum_third<=' => 39))->num_rows();?> 
					</td>
				  </tr>
				  
				
				<table width="100%" border="1">
				  <tr>
					<td width="186"><strong>&nbsp;Class Position:</strong></td>
					<td width="89" class="text-uppercase">&nbsp;
					
					
										<?php
										
										
								$set = $session;
                                $this->db->select_sum('sum_third');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 3);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_third;
								
								
								if($sumTotalOfFirstScore == ""){
									$sumTotalOfFirstScore = 0;
								}else{
									$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
								}
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 
									'student_id' => $student_id))->num_rows();
									
									
									$updatePercetangeFirst = round($sumTotalOfFirstScore/$getSubjectNumbered);
									if(is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = 0;
									}
									if(!is_nan($updatePercetangeFirst)){
										$updatePercetangeFirst = $updatePercetangeFirst;
									}
											
											$class_position_first['class_position_first'] = $updatePercetangeFirst;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $class_position_first);
										
										
										
										
 										$sql = "SELECT mark_id, class_position_first, FIND_IN_SET( class_position_first,(
												SELECT GROUP_CONCAT( class_position_first  ORDER BY class_position_first desc ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND class_position_first = $updatePercetangeFirst AND class_position_first != 0"; 
        
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
					<td width="155"><strong>&nbsp;Total Score:</strong></td>
					<td width="119">&nbsp;
								<?php
								$set = $session;
                                $this->db->select_sum('sum_third');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 3);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_third;
								
									if($sumTotalOfFirstScore == ""){
										echo $sumTotalOfFirstScore = 0;
									}else{
										echo $sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
							?>					
					</td>
					<td colspan="2"><strong>&nbsp;<strong>Final Average</strong>:</strong></td>
					<td width="171">&nbsp;
					<?php 
					
								$set = $session;
                                $this->db->select_sum('sum_third');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 3);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_third;
								
									if($sumTotalOfFirstScore == ""){
										$sumTotalOfFirstScore = 0;
									}else{
										$sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
								
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 3, 
									'student_id' => $student_id))->num_rows();		
					?>
					
					<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?> %					
					</td>
				    <td width="">&nbsp;<strong>Final Grade</strong> </td>
				    <td width="75">&nbsp;
								<?php $FindGrade = round($sumTotalOfFirstScore /$getSubjectNumbered,2);?>
								<?php if ($FindGrade <= '100' && $FindGrade >= '90'):?>
								<?php echo 'A*';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '89' && $FindGrade >= '80'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '79' && $FindGrade >= '70'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= '69' && $FindGrade >= '60'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "59" && $FindGrade >= '50'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "49" && $FindGrade >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($FindGrade <= "39" && $FindGrade >= '30'):?>
								<?php echo 'F';?>
								<?php endif;?>
					
					</td>
				  </tr>
				</table>
				
				
				
					<?php 
						$session = $session;
						$select = $this->db->get_where('diamond_stu_comment', array('student_id' => $student_id, 'session' => $session, 'term' => $term, 'status' => 3))->row();
					?>
				<table width="100%" border="1">
				  <tr>
					<td colspan="6" bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SECTION B: EFFECTIVE GENERAL BEHAVIOUR</strong></span></td>
					<td colspan="6" bgcolor="#CC6600"><span class="style1">&nbsp;<strong>SECTION C: (PSYCHOMOTOR) SKILL </strong></span></td>
				  </tr>
				  <tr>
				    <td width="249">&nbsp;</td>
				    <td width="104"><strong>&nbsp;5</strong></td>
				    <td width="61" class="text-uppercase"><strong>&nbsp;4</strong></td>
				    <td width="51"><strong>&nbsp;3</strong></td>
				    <td width="58"><strong>&nbsp;2</strong></td>
				    <td width="66"><strong>&nbsp;1</strong></td>
				    <td width="297">&nbsp;</td>
				    <td width="70"><strong>&nbsp;5</strong></td>
				    <td width="69"><strong>&nbsp;4</strong></td>
				    <td width="62"><strong>&nbsp;3</strong></td>
				    <td width="65"><strong>&nbsp;2</strong></td>
				    <td width="60"><strong>&nbsp;1</strong></td>
			      </tr>
				  <tr>
				    <td width="249">&nbsp;PUNCTUALITY</td>
				    <td>&nbsp;<?php if($select->pu == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->pu == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;HANDWRITING</td>
				    <td>&nbsp;<?php if($select->han == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->han == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;CLASSROOM ATTENDANCE</td>
				    <td>&nbsp;<?php if($select->cl == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cl == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;FLUENCY</td>
				    <td>&nbsp;<?php if($select->fl == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->fl == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;CARRYING OUT ASSIGNMENT</td>
				    <td>&nbsp;<?php if($select->car == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->car == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;GAMES</td>
				    <td>&nbsp;<?php if($select->ga == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ga == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;NEATNESS</td>
				    <td>&nbsp;<?php if($select->ne == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ne == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;SPORTS</td>
				    <td>&nbsp;<?php if($select->sp == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sp == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;POLITENESS</td>
				    <td>&nbsp;<?php if($select->po == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->po == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;GYMNASTICS</td>
				    <td>&nbsp;<?php if($select->gy == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->gy == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;HONESTY</td>
				    <td>&nbsp;<?php if($select->ho == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ho == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;DRAWING &amp; PAINTING</td>
				    <td>&nbsp;<?php if($select->dr == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->dr == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;SELF CONTROL</td>
				    <td>&nbsp;<?php if($select->se == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->se == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;MUSICAL PERFORMANCE</td>
				    <td>&nbsp;<?php if($select->mu == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->mu == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;RELATIONSHIP WITH OTHERS</td>
				    <td>&nbsp;<?php if($select->re == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->re == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;HANDLING TOOLS</td>
				    <td>&nbsp;<?php if($select->ha == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ha == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;SENSE OF RESPONSIBILITY</td>
				    <td>&nbsp;<?php if($select->sen == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->sen == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;CRAFTS</td>
				    <td>&nbsp;<?php if($select->cr == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->cr == 1) echo '<i class="fa fa-check"></i>';?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;OBEDIENCE</td>
				    <td>&nbsp;<?php if($select->ob == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ob == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;INITIATIVE</td>
				    <td>&nbsp;<?php if($select->ini == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->ini == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;ORGANISATIONAL ABILITY</td>
				    <td>&nbsp;<?php if($select->org == 5) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 4) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 3) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 2) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;<?php if($select->org == 1) echo '<i class="fa fa-check"></i>';?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td colspan="8">&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong>KEY TO GRADES</strong></td>
				    <td>&nbsp;</td>
				    <td rowspan="6" class="text-uppercase">&nbsp;</td>
				    <td colspan="4">&nbsp;<strong>KEY TO RATINGS (SECTIONS B AND C)</strong></td>
				    <td colspan="5" rowspan="6">&nbsp;</td>
			      </tr>
				  <tr>
				    <td>&nbsp;A</td>
				    <td>&nbsp;80 - 100%</td>
				    <td>&nbsp;5</td>
				    <td colspan="3">&nbsp;Maintains an excellent degree of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;B</td>
				    <td>&nbsp;70 - 79%</td>
				    <td>&nbsp;4</td>
				    <td colspan="3">&nbsp;Maintains a high level of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;C</td>
				    <td>&nbsp;60 - 69% </td>
				    <td>&nbsp;3</td>
				    <td colspan="3">&nbsp;Acceptable level of observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;P</td>
				    <td>&nbsp;50 - 59% </td>
				    <td>&nbsp;2</td>
				    <td colspan="3">&nbsp;Shows minimal regard for observable traits</td>
			      </tr>
				  <tr>
				    <td>&nbsp;E</td>
				    <td>&nbsp;40 - 49%</td>
				    <td>&nbsp;1</td>
				    <td colspan="3">&nbsp;Has no regard for obsevrable traits</td>
			      </tr>
				  <tr>
				    <td><span class="style4">&nbsp;F</span></td>
				    <td><span class="style4">&nbsp;0 - 39%</span></td>
				    <td colspan="10" class="text-uppercase">&nbsp;</td>
		          </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Head Teacher / Principal's Comment</em></strong></td>
				    <td colspan="11">&nbsp;<?=$select->p_comment;?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Teacher's Comment</em></strong></td>
				    <td colspan="11">&nbsp;<?=$select->tcomment;?></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Signature</em></strong></td>
				    <td colspan="11">&nbsp;<img src="<?php echo base_url();?>uploads/signature.png" width="150px" height="50px"></td>
			      </tr>
				  <tr>
				    <td>&nbsp;<strong><em>Date</em></strong></td>
				    <td colspan="11">&nbsp;<?=date('d, M Y')?><span class="float-right"><strong>Next Term Begins:</strong></strong> <?=get_settings('next_term_begin')?></span></td>
			      </tr>
				</table> 
				
				<?php endif;?>	<!-- END OF TERMINAL REPORT THAT CONTAING CA1 AND CA2 AND EXAM SCORES -->
				
				<?php endif;?>	<!-- END OF THIRD TERM GENERAL REPORT FOR CA1 AND CA2 AND EXAM REPORT -->
				<div class="pagebreak"> </div>
				
				
				

			<?php endif;?>	<!-- END OF DIAMOND REPORT TEMPLATE -->
			<div class="pagebreak"> </div>
		
		
		
		
		
		
		
			<?php if($report_template == 2) : ?>
			
				<?php if($term == 1) : ?>
			
				<div class="row"> 
                    <div class="col-sm-12" >
							<table width="100%" border="0">
							  <tr>
								<td width="" height="">
									<img src="<?php echo base_url()?>uploads/logo.png"  height="150" width="150">
								</td>
								<td width="" valign="top" align="right"><h4>
									<strong><?php echo $system_name;?>, <?php echo get_settings('system_title')?></strong></h4>
									<h5><?php echo get_settings('address')?> </h5>
									<h5><?php echo get_settings('system_email')?></h5>
									<h5><?php echo get_settings('phone')?></h5>
								</td>
							  </tr>
							</table>
					</div>
				</div>
				<br>
				<div class="row"> 
                    <div class="col-sm-12" >
						<table width="100%" style="" border="0">
							  <tr>
								<td height="50" colspan="2" valign="" align="center" bgcolor="#666666"><h3 style="color:white">Termly Report</h3> </td>
							  </tr>
						</table>
					</div>
				</div>
				<br>
				
				<div class="row"> 
                    <div class="col-sm-12" >
						 <table width="100%" border="0">
						  <tr>
								<td width="" valign="top" align="left">
									<h5><?php echo get_phrase('student_ID');?> : <?php echo $student_selected['roll'];?></h5>
									<h5><?php echo get_phrase('name');?> : <?php echo $student_selected['name'];?> </h5>
									<h5><?php echo get_phrase('academic_session');?> : <?php echo $session?>&nbsp;&nbsp;&nbsp;<?php echo get_phrase('term').': ';?>:
									<?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></h5>
									<h5><?php echo get_phrase('gender');?> : <?php echo ucwords($student_selected['sex']);?>&nbsp;&nbsp;&nbsp;<?php echo get_phrase('class').': '.$class_name.' '. get_phrase('remarks').': '. 'Pass';?></h5>
								</td>
								<td width="" height="" align="right">
									<img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="150" width="150">
								</td>
						 </tr>
						</table>
					</div>
				</div>	
				<br>
						
				<div class="row"> 
                    <div class="col-sm-9" >
						<table width="100%  " border="1">
						  <tr>
							<td height=""  style="color:white; font-size:11px; font-weight:100;" bgcolor="#666666" align="center">Subject</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">CA<br />
							(40%)</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">Exam<br />
							(60%)</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">Total<br />
							  Score<br />
							(100%)</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">Grade</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">Class<br />
							Lowest<br />
							Score</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">Class<br />
						Highest<br />
						Score</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">Subject<br />
							Avg.<br />
							Score</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">Subject<br />
							Position</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">Remarks</td>
						  </tr>
						  
                   				<?php 
										$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
										foreach ($select_subject as $key => $subject):
								?>
						  <tr>
							<td>&nbsp;<?php echo $subject['name'];?></td>
                                        <?php 
										$obtained_mark_query = $this->db->get_where('mark', 
											array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 
											'student_id' => $student_id, 'term' => 1));
                                        
										

                                            $class_score_one    = $obtained_mark_query->row()->class_score1;
                                            $exam_score         = $obtained_mark_query->row()->exam_score;
                                            $total_score        = $class_score_one + $exam_score;
											$comment         	= $obtained_mark_query->row()->comment;
											
											$update['sum_first'] = $total_score;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $update);
                                       
                                        ?>
							
							<td>&nbsp;<?php if($class_score_one == 0)echo '';else echo $class_score_one;?></td>
							<td>&nbsp;<?php if($exam_score == 0)echo ''; else echo $exam_score;?></td>
							<td>&nbsp;<?php if($total_score == 0)echo ''; else echo $total_score;?></td>
							<td>&nbsp;
							
															
								<?php if ($total_score <= '100' && $total_score >= '70'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($total_score <= '59' && $total_score >= '50'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($total_score <= '49' && $total_score >= '40'):?>
								<?php echo 'P';?>
								<?php endif;?>
								
								<?php if ($total_score <= '39' && $total_score >= '0'):?>
								<?php echo 'F';?>
								<?php endif;?>
							
	
							
							</td>
							
							<td>&nbsp;	
							
                                          	
								
													
                                            <?php
                                                $lowest_mark = $this->crud_model->get_lowest_marks_first( $exam_id , $class_id , $subject['subject_id'], 1 );
                                                echo $lowest_mark;
                                            ?>
							
							</td>
							<td>&nbsp;
							
                                            <?php
                                                $lowest_mark = $this->crud_model->get_highest_marks_first( $exam_id , $class_id , $subject['subject_id'], 1 );
                                                echo $lowest_mark;
                                            ?>
								
								
							</td>
							<td>&nbsp;<?php if($total_score == 0)echo ''; else echo $total_score;?></td>
							
							<td>&nbsp;
							
									<?php
										
										$subject_id = $subject['subject_id'];
 										$sql = "SELECT mark_id, sum_first, FIND_IN_SET( sum_first,(
												SELECT GROUP_CONCAT( sum_first  ORDER BY sum_first DESC ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND sum_first = $total_score AND sum_first != 0"; 
        
        								$rank =  $this->db->query($sql)->row()->rank; 
        
										if($rank == 0){
											echo '--'; 
										}
        
										if($rank == 1){
											echo $rank.'st';
										}elseif($rank == 2){
										   echo $rank.'nd'; 
										}elseif($rank == 3){
										   echo $rank.'rd'; 
										}elseif($rank > 3 ){
											echo $rank.'th';         
										}else{
											echo '--'; 
										}
										
										
										?>
							
							</td>
							<td>&nbsp;<?php echo $comment;?></td>
						  </tr>
						  <?php endforeach;?>
						  
						  
						  
						</table>
					</div>
					
                    <div class="col-sm-3" >
							<table width="100%" border="1">
							  <tr>
								<td width="" align="center" style="color:white; font-size:11px; font-weight:100;" height="38" bgcolor="#666666">AFFECTIVE TRAITS</td>
								<td width="" bgcolor="#666666" align="center">&nbsp;</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Punctuality</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Mental Alertness</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Attentiveness</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Respect</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Neatness</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Politeness</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Honesty</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Relationship with Peers</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Attitude To School</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Spirit of Team Work</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Completes School Work Promptly</td>
								<td align="center">3</td>
							  </tr>
							</table>
							
							<table width="100%" border="1">
							  <tr>
								<td width="" align="center" style="color:white; font-size:11px; font-weight:100;" height="38" bgcolor="#666666">PSYCHOMOTOR SKILLS</td>
								<td width="" bgcolor="#666666" align="center">&nbsp;</td>
							  </tr>
							  
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Reading</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Verbal Fluency/Diction</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Handwriting</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Musical Skills</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Creative Arts</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Physical Education</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;General Reasoning</td>
								<td align="center">3</td>
							  </tr>

							</table>
					</div>
				</div>
				<br>
				
				<div class="row"> 
                    <div class="col-sm-5" >
							<table width="100%" border="1">
							  <tr>
								<td width="" align="center" style="color:white; font-size:11px; font-weight:100;" height="38" bgcolor="#666666">Report Summary</td>
								<td width="" bgcolor="#666666">&nbsp;</td>
							  </tr>
							  
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Overall Total Score</td>
								
								<td style="font-size:11px; font-weight:100;">&nbsp;<?php 
								$set = $session;
                                $this->db->select_sum('sum_first');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 1);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfFirstScore = $query->row()->sum_first;
								
											
											$class_position_first['class_position_first'] = $sumTotalOfFirstScore;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $class_position_first);
											
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 1, 
									'student_id' => $student_id, 'exam_score !=' => 0))->num_rows();
                                ?><?php echo $sumTotalOfFirstScore .' out of '.$getSubjectNumbered * 100;?> 
								</td>
								
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Average Score</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;<?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?> </td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Position</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;<?php
 										$sql = "SELECT mark_id, class_position_first, FIND_IN_SET( class_position_first,(
												SELECT GROUP_CONCAT( class_position_first  ORDER BY class_position_first desc ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND class_position_first = $sumTotalOfFirstScore AND class_position_first != 0"; 
        
        								$rank =  $this->db->query($sql)->row()->rank; 
        
										if($rank == 0){
											echo '--'; 
										}
        
										if($rank == 1){
											echo $rank.'st';
										}elseif($rank == 2){
										   echo $rank.'nd'; 
										}elseif($rank == 3){
										   echo $rank.'rd'; 
										}elseif($rank > 3 ){
											echo $rank.'th';         
										}else{
											echo '--'; 
										}
										?> out of <?php echo $number_class;?>
								</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Total Subjects Offered In Class</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;<?php echo $getSubjectNumbered;?></td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Total Subjects Taken</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;<?php echo $getSubjectNumbered;?></td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Head Teacher's Comment</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;Nice Result</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Principal's Comment</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;Nice Result</td>
							  </tr>

							</table>
					</div>
					
                  <div class="col-sm-5" >
							<table width="100%" border="1">
							  <tr>
								<td width="" align="center" style="color:white; font-size:11px; font-weight:100;" height="38" bgcolor="#666666">Grading System</td>
								<td width="" bgcolor="#666666">&nbsp;</td>
							  </tr>
							  
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;70% - 100%</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;Excellent</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;60% - 69%</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;Very Good</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;50% - 59%</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;Good</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;45% - 49%</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;Average</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;40% - 44%</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;Poor</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;0% - 39%</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;Fail</td>
							  </tr>
							  <tr>
								<td colspan="2" align="center" style="color:white" bgcolor="#666666"><span class="style4">&nbsp;
								CA : Continous Assessment
								Avg Score = Tot Score / No. Subj.
								Offered
								</span>
								</td>
							</tr>
							</table>
				  </div>
					
                    <div class="col-sm-2" align="center">

						<table>
							  <tr>
								<td colspan="2" align="center" >
									<img style="" src="<?php echo base_url();?>uploads/signature.png" width="150px" height="80px">
									<br>
									Mrs. Ugodebe B.<br>
									Principal
								</td>
							</tr>
							</table>
							
								
							  
					</div>
				</div>
					


				<?php endif;?>
				
				
				
				
				
				
				<?php if($term == 2) : ?>
			
				<div class="row"> 
                    <div class="col-sm-12" >
							<table width="100%" border="0">
							  <tr>
								<td width="" height="">
									<img src="<?php echo base_url()?>uploads/logo.png"  height="150" width="150">
								</td>
								<td width="" valign="top" align="right"><h4>
									<strong><?php echo $system_name;?>, <?php echo get_settings('system_title')?></strong></h4>
									<h5><?php echo get_settings('address')?> </h5>
									<h5><?php echo get_settings('system_email')?></h5>
									<h5><?php echo get_settings('phone')?></h5>
								</td>
							  </tr>
							</table>
					</div>
				</div>
				<br>
				<div class="row"> 
                    <div class="col-sm-12" >
						<table width="100%" style="" border="0">
							  <tr>
								<td height="50" colspan="2" valign="" align="center" bgcolor="#666666"><h3 style="color:white">Termly Report</h3> </td>
							  </tr>
						</table>
					</div>
				</div>
				<br>
				
				<div class="row"> 
                    <div class="col-sm-12" >
						 <table width="100%" border="0">
						  <tr>
								<td width="" valign="top" align="left">
									<h5><?php echo get_phrase('student_ID');?> : <?php echo $student_selected['roll'];?></h5>
									<h5><?php echo get_phrase('name');?> : <?php echo $student_selected['name'];?> </h5>
									<h5><?php echo get_phrase('academic_session');?> : <?php echo $session?>&nbsp;&nbsp;&nbsp;<?php echo get_phrase('term').': ';?>:
									<?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></h5>
									<h5><?php echo get_phrase('gender');?> : <?php echo ucwords($student_selected['sex']);?>&nbsp;&nbsp;&nbsp;<?php echo get_phrase('class').': '.$class_name.' '. get_phrase('remarks').': '. 'Pass';?></h5>
								</td>
								<td width="" height="" align="right">
									<img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="150" width="150">
								</td>
						 </tr>
						</table>
					</div>
				</div>	
				<br>
						
				<div class="row"> 
                    <div class="col-sm-9" >
						<table width="100%  " border="1">
						  <tr>
							<td height=""  style="color:white; font-size:11px; font-weight:100;" bgcolor="#666666" align="center">Subject</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">CA<br />
							(40%)</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">Exam<br />
							(60%)</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">Total<br />
							  Score<br />
							(100%)</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">Grade</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">Class<br />
							Lowest<br />
							Score</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">Class<br />
						Highest<br />
						Score</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">Subject<br />
							Avg.<br />
							Score</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">Subject<br />
							Position</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">Remarks</td>
						  </tr>
						  
                   				<?php 
										$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
										foreach ($select_subject as $key => $subject):
								?>
						  <tr>
							<td>&nbsp;<?php echo $subject['name'];?></td>
                                        <?php 
										$obtained_mark_query = $this->db->get_where('mark', 
											array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 
											'student_id' => $student_id, 'term' => 2));
                                        
										

                                            $class_score_one    = $obtained_mark_query->row()->class_score1;
                                            $exam_score         = $obtained_mark_query->row()->exam_score;
                                            $total_score        = $class_score_one + $exam_score;
											$comment         	= $obtained_mark_query->row()->comment;
											
											$update['sum_second'] = $total_score;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $update);
                                        
                                        ?>
							
							<td>&nbsp;<?php if($class_score_one == 0)echo '';else echo $class_score_one;?></td>
							<td>&nbsp;<?php if($exam_score == 0)echo ''; else echo $exam_score;?></td>
							<td>&nbsp;<?php if($total_score == 0)echo ''; else echo $total_score;?></td>
							<td>&nbsp;
							
															
								<?php if ($total_score <= '100' && $total_score >= '70'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($total_score <= '59' && $total_score >= '50'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($total_score <= '49' && $total_score >= '40'):?>
								<?php echo 'P';?>
								<?php endif;?>
								
								<?php if ($total_score <= '39' && $total_score >= '0'):?>
								<?php echo 'F';?>
								<?php endif;?>
							
	
							
							</td>
							
							<td>&nbsp;	
							
                                          	
								
													
                                            <?php
                                                $lowest_mark = $this->crud_model->get_lowest_marks_first( $exam_id , $class_id , $subject['subject_id'], 2 );
                                                echo $lowest_mark;
                                            ?>
							
							</td>
							<td>&nbsp;
							
                                            <?php
                                                $lowest_mark = $this->crud_model->get_highest_marks_first( $exam_id , $class_id , $subject['subject_id'], 2 );
                                                echo $lowest_mark;
                                            ?>
								
								
							</td>
							<td>&nbsp;<?php if($total_score == 0)echo ''; else echo $total_score;?></td>
							
							<td>&nbsp;
							
									<?php
										
										$subject_id = $subject['subject_id'];
 										$sql = "SELECT mark_id, sum_second, FIND_IN_SET( sum_second,(
												SELECT GROUP_CONCAT( sum_second  ORDER BY sum_second DESC ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND sum_second = $total_score AND sum_second != 0"; 
        
        								$rank =  $this->db->query($sql)->row()->rank; 
        
										if($rank == 0){
											echo '--'; 
										}
        
										if($rank == 1){
											echo $rank.'st';
										}elseif($rank == 2){
										   echo $rank.'nd'; 
										}elseif($rank == 3){
										   echo $rank.'rd'; 
										}elseif($rank > 3 ){
											echo $rank.'th';         
										}else{
											echo '--'; 
										}
										
										
										?>
							
							</td>
							<td>&nbsp;<?php echo $comment;?></td>
						  </tr>
						  <?php endforeach;?>
						  
						  
						  
						</table>
					</div>
					
                    <div class="col-sm-3" >
							<table width="100%" border="1">
							  <tr>
								<td width="" align="center" style="color:white; font-size:11px; font-weight:100;" height="38" bgcolor="#666666">AFFECTIVE TRAITS</td>
								<td width="" bgcolor="#666666" align="center">&nbsp;</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Punctuality</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Mental Alertness</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Attentiveness</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Respect</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Neatness</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Politeness</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Honesty</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Relationship with Peers</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Attitude To School</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Spirit of Team Work</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Completes School Work Promptly</td>
								<td align="center">3</td>
							  </tr>
							</table>
							
							<table width="100%" border="1">
							  <tr>
								<td width="" align="center" style="color:white; font-size:11px; font-weight:100;" height="38" bgcolor="#666666">PSYCHOMOTOR SKILLS</td>
								<td width="" bgcolor="#666666" align="center">&nbsp;</td>
							  </tr>
							  
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Reading</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Verbal Fluency/Diction</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Handwriting</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Musical Skills</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Creative Arts</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Physical Education</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;General Reasoning</td>
								<td align="center">3</td>
							  </tr>

							</table>
					</div>
				</div>
				<br>
				
				<div class="row"> 
                    <div class="col-sm-5" >
							<table width="100%" border="1">
							  <tr>
								<td width="" align="center" style="color:white; font-size:11px; font-weight:100;" height="38" bgcolor="#666666">Report Summary</td>
								<td width="" bgcolor="#666666">&nbsp;</td>
							  </tr>
							  
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Overall Total Score</td>
								
								<td style="font-size:11px; font-weight:100;">&nbsp;<?php 
								$set = $session;
                                $this->db->select_sum('sum_second');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 2);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfSecondScore = $query->row()->sum_second;
								
											
											$class_position_first['class_position_second'] = $sumTotalOfSecondScore;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $class_position_first);
											
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 
									'student_id' => $student_id, 'exam_score !=' => 0))->num_rows();
                                ?><?php echo $sumTotalOfSecondScore .' out of '.$getSubjectNumbered * 100;?> 
								</td>
								
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Average Score</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;<?=round($sumTotalOfSecondScore /$getSubjectNumbered,2)?> </td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Position</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;<?php
										
 										$sql = "SELECT mark_id, class_position_second, FIND_IN_SET( class_position_second,(
												SELECT GROUP_CONCAT( class_position_second  ORDER BY class_position_second desc ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND class_position_second = $sumTotalOfSecondScore AND class_position_second != 0"; 
        
        								$rank =  $this->db->query($sql)->row()->rank; 
        
										if($rank == 0){
											echo '--'; 
										}
        
										if($rank == 1){
											echo $rank.'st';
										}elseif($rank == 2){
										   echo $rank.'nd'; 
										}elseif($rank == 3){
										   echo $rank.'rd'; 
										}elseif($rank > 3 ){
											echo $rank.'th';         
										}else{
											echo '--'; 
										}
										?> out of <?php echo $number_class;?>
								</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Total Subjects Offered In Class</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;<?php echo $getSubjectNumbered;?></td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Total Subjects Taken</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;<?php echo $getSubjectNumbered;?></td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Head Teacher's Comment</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;Nice Result</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Principal's Comment</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;Nice Result</td>
							  </tr>

							</table>
					</div>
					
                  <div class="col-sm-5" >
							<table width="100%" border="1">
							  <tr>
								<td width="" align="center" style="color:white; font-size:11px; font-weight:100;" height="38" bgcolor="#666666">Grading System</td>
								<td width="" bgcolor="#666666">&nbsp;</td>
							  </tr>
							  
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;70% - 100%</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;Excellent</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;60% - 69%</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;Very Good</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;50% - 59%</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;Good</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;45% - 49%</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;Average</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;40% - 44%</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;Poor</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;0% - 39%</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;Fail</td>
							  </tr>
							  <tr>
								<td colspan="2" align="center" style="color:white" bgcolor="#666666"><span class="style4">&nbsp;
								CA : Continous Assessment
								Avg Score = Tot Score / No. Subj.
								Offered
								</span>
								</td>
							</tr>
							</table>
				  </div>
					
                    <div class="col-sm-2" align="center">

						<table>
							  <tr>
								<td colspan="2" align="center" >
									<img style="" src="<?php echo base_url();?>uploads/signature.png" width="150px" height="80px">
									<br>
									Mrs. Ugodebe B.<br>
									Principal
								</td>
							</tr>
							</table>
							
								
							  
					</div>
				</div>
					


				<?php endif;?>
				
				
				
				
				<?php if($term == 3) : ?>
				
				
				<div class="row"> 
                    <div class="col-sm-12" >
							<table width="100%" border="0">
							  <tr>
								<td width="" height="">
									<img src="<?php echo base_url()?>uploads/logo.png"  height="150" width="150">
								</td>
								<td width="" valign="top" align="right"><h4>
									<strong><?php echo $system_name;?>, <?php echo get_settings('system_title')?></strong></h4>
									<h5><?php echo get_settings('address')?> </h5>
									<h5><?php echo get_settings('system_email')?></h5>
									<h5><?php echo get_settings('phone')?></h5>
								</td>
							  </tr>
							</table>
					</div>
				</div>
				<br>
				<div class="row"> 
                    <div class="col-sm-12" >
						<table width="100%" style="" border="0">
							  <tr>
								<td height="50" colspan="2" valign="" align="center" bgcolor="#666666"><h3 style="color:white">Termly Report</h3> </td>
							  </tr>
						</table>
					</div>
				</div>
				<br>
				
				<div class="row"> 
                    <div class="col-sm-12" >
						 <table width="100%" border="0">
						  <tr>
								<td width="" valign="top" align="left">
									<h5><?php echo get_phrase('student_ID');?> : <?php echo $student_selected['roll'];?></h5>
									<h5><?php echo get_phrase('name');?> : <?php echo $student_selected['name'];?> </h5>
									<h5><?php echo get_phrase('academic_session');?> : <?php echo $session?>&nbsp;&nbsp;&nbsp;<?php echo get_phrase('term').': ';?>:

									<?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></h5>
									<h5><?php echo get_phrase('gender');?> : <?php echo ucwords($student_selected['sex']);?>&nbsp;&nbsp;&nbsp;<?php echo get_phrase('class').': '.$class_name.' '. get_phrase('remarks').': '. 'Pass';?></h5>
								</td>
								<td width="" height="" align="right">
									<img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="150" width="150">
								</td>
						 </tr>
						</table>
					</div>
				</div>	
				<br>
						
				<div class="row"> 
                    <div class="col-sm-9" >
						<table width="100%  " border="1">
						  <tr>
							<td height=""  style="color:white; font-size:11px; font-weight:100;" bgcolor="#666666" align="center">Subject</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">CA<br />
							(40%)</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">Exam<br />
							(60%)</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">Total<br />
							  Score<br />
							(100%)</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">Grade</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">Class<br />
							Lowest<br />
							Score</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">Class<br />
						Highest<br />
						Score</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">Subject<br />
							Avg.<br />
							Score</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">Subject<br />
							Position</td>
							<td bgcolor="#666666" style="color:white; font-size:11px; font-weight:100;" align="center">Remarks</td>
						  </tr>
						  
                   				<?php 
										$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
										foreach ($select_subject as $key => $subject):
								?>
						  <tr>
							<td>&nbsp;<?php echo $subject['name'];?></td>
                                        <?php 
										$obtained_mark_query = $this->db->get_where('mark', 
											array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 
											'student_id' => $student_id, 'term' => 3));
                                        
										

                                            $class_score_one    = $obtained_mark_query->row()->class_score1;
                                            $exam_score         = $obtained_mark_query->row()->exam_score;
                                            $total_score        = $class_score_one + $exam_score;
											$comment         	= $obtained_mark_query->row()->comment;
											
											$update['sum_third'] = $total_score;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $update);
                                        
                                        ?>
							
							<td>&nbsp;<?php if($class_score_one == 0)echo '';else echo $class_score_one;?></td>
							<td>&nbsp;<?php if($exam_score == 0)echo ''; else echo $exam_score;?></td>
							<td>&nbsp;<?php if($total_score == 0)echo ''; else echo $total_score;?></td>
							<td>&nbsp;
							
															
								<?php if ($total_score <= '100' && $total_score >= '70'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($total_score <= '59' && $total_score >= '50'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($total_score <= '49' && $total_score >= '40'):?>
								<?php echo 'P';?>
								<?php endif;?>
								
								<?php if ($total_score <= '39' && $total_score >= '0'):?>
								<?php echo 'F';?>
								<?php endif;?>
							
	
							
							</td>
							
							<td>&nbsp;	
							
                                          	
								
													
                                            <?php
                                                $lowest_mark = $this->crud_model->get_lowest_marks_first( $exam_id , $class_id , $subject['subject_id'], 3 );
                                                echo $lowest_mark;
                                            ?>
							
							</td>
							<td>&nbsp;
							
                                            <?php
                                                $lowest_mark = $this->crud_model->get_highest_marks_first( $exam_id , $class_id , $subject['subject_id'], 3 );
                                                echo $lowest_mark;
                                            ?>
								
								
							</td>
							<td>&nbsp;<?php if($total_score == 0)echo ''; else echo $total_score;?></td>
							
							<td>&nbsp;
							
									<?php
										
										$subject_id = $subject['subject_id'];
 										$sql = "SELECT mark_id, sum_third, FIND_IN_SET( sum_third,(
												SELECT GROUP_CONCAT( sum_third  ORDER BY sum_third DESC ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 
												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND sum_third = $total_score AND sum_third != 0"; 
        
        								$rank =  $this->db->query($sql)->row()->rank; 
        
										if($rank == 0){
											echo '--'; 
										}
        
										if($rank == 1){
											echo $rank.'st';
										}elseif($rank == 2){
										   echo $rank.'nd'; 
										}elseif($rank == 3){
										   echo $rank.'rd'; 
										}elseif($rank > 3 ){
											echo $rank.'th';         
										}else{
											echo '--'; 
										}
										
										
										?>
							
							</td>
							<td>&nbsp;<?php echo $comment;?></td>
						  </tr>
						  <?php endforeach;?>
						  
						  
						  
						</table>
					</div>
					
                    <div class="col-sm-3" >
							<table width="100%" border="1">
							  <tr>
								<td width="" align="center" style="color:white; font-size:11px; font-weight:100;" height="38" bgcolor="#666666">AFFECTIVE TRAITS</td>
								<td width="" bgcolor="#666666" align="center">&nbsp;</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Punctuality</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Mental Alertness</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Attentiveness</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Respect</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Neatness</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Politeness</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Honesty</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Relationship with Peers</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Attitude To School</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Spirit of Team Work</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Completes School Work Promptly</td>
								<td align="center">3</td>
							  </tr>
							</table>
							
							<table width="100%" border="1">
							  <tr>
								<td width="" align="center" style="color:white; font-size:11px; font-weight:100;" height="38" bgcolor="#666666">PSYCHOMOTOR SKILLS</td>
								<td width="" bgcolor="#666666" align="center">&nbsp;</td>
							  </tr>
							  
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Reading</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Verbal Fluency/Diction</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Handwriting</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Musical Skills</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Creative Arts</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Physical Education</td>
								<td align="center">3</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;General Reasoning</td>
								<td align="center">3</td>
							  </tr>

							</table>
					</div>
				</div>
				<br>
				
				<div class="row"> 
                    <div class="col-sm-5" >
							<table width="100%" border="1">
							  <tr>
								<td width="" align="center" style="color:white; font-size:11px; font-weight:100;" height="38" bgcolor="#666666">Report Summary</td>
								<td width="" bgcolor="#666666">&nbsp;</td>
							  </tr>
							  
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Overall Total Score</td>
								
								<td style="font-size:11px; font-weight:100;">&nbsp;<?php 
								$set = $session;
                                $this->db->select_sum('sum_third');
                                $this->db->from('mark');
                                $this->db->where('student_id', $student_id);
								$this->db->where('term', 3);
								$this->db->where('session', $set);
								
                                $query = $this->db->get();	
								$sumTotalOfThirdScore = $query->row()->sum_third;
								
											
											$class_position_third['class_position_third'] = $sumTotalOfThirdScore;
											$this->db->where('subject_id' , $subject['subject_id']);
											$this->db->where('student_id' , $student_id);
											$this->db->update('mark', $class_position_third);
											
									
									$getSubjectNumbered = $this->db->get_where('mark', array('class_id' => $class_id, 'term' => 2, 
									'student_id' => $student_id, 'exam_score !=' => 0))->num_rows();
                                ?><?php echo $sumTotalOfThirdScore .' out of '.$getSubjectNumbered * 100;?> 
								</td>
								
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Average Score</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;<?=round($sumTotalOfThirdScore /$getSubjectNumbered,2)?> </td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Position</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;<?php
										
 										$sql = "SELECT mark_id, class_position_second, FIND_IN_SET( class_position_third,(
												SELECT GROUP_CONCAT( class_position_third  ORDER BY class_position_third desc ) 
												FROM mark WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id ))
												AS rank 

												FROM mark
												WHERE exam_id = $exam_id AND class_id = $class_id AND subject_id = $subject_id AND class_position_third = $sumTotalOfThirdScore AND class_position_third != 0"; 
        
        								$rank =  $this->db->query($sql)->row()->rank; 
        
										if($rank == 0){
											echo '--'; 
										}
        
										if($rank == 1){
											echo $rank.'st';
										}elseif($rank == 2){
										   echo $rank.'nd'; 
										}elseif($rank == 3){
										   echo $rank.'rd'; 
										}elseif($rank > 3 ){
											echo $rank.'th';         
										}else{
											echo '--'; 
										}
										?> out of <?php echo $number_class;?>
								</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Total Subjects Offered In Class</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;<?php echo $getSubjectNumbered;?></td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Total Subjects Taken</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;<?php echo $getSubjectNumbered;?></td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Head Teacher's Comment</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;Nice Result</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;Principal's Comment</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;Nice Result</td>
							  </tr>

							</table>
					</div>
					
                  <div class="col-sm-5" >
							<table width="100%" border="1">
							  <tr>
								<td width="" align="center" style="color:white; font-size:11px; font-weight:100;" height="38" bgcolor="#666666">Grading System</td>
								<td width="" bgcolor="#666666">&nbsp;</td>
							  </tr>
							  
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;70% - 100%</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;Excellent</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;60% - 69%</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;Very Good</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;50% - 59%</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;Good</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;45% - 49%</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;Average</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;40% - 44%</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;Poor</td>
							  </tr>
							  <tr>
								<td style="font-size:11px; font-weight:100;">&nbsp;0% - 39%</td>
								<td style="font-size:11px; font-weight:100;">&nbsp;Fail</td>
							  </tr>
							  <tr>
								<td colspan="2" align="center" style="color:white" bgcolor="#666666"><span class="style4">&nbsp;
								CA : Continous Assessment
								Avg Score = Tot Score / No. Subj.
								Offered
								</span>
								</td>
							</tr>
							</table>
				  </div>
					
                    <div class="col-sm-2" align="center">

						<table>
							  <tr>
								<td colspan="2" align="center" >
									<img style="" src="<?php echo base_url();?>uploads/signature.png" width="150px" height="80px">
									<br>
									Mrs. Ugodebe B.<br>
									Principal
								</td>
							</tr>
							</table>
							
								
							  
					</div>
				</div>
				
				<?php endif;?>
				
				
				
				
				
				
				
				
			<?php endif;?>
		
		
		
		
		
		
		
		<hr>
  
<?php endforeach;?>
						
					
		  </div>
				</div>
			</div>
		</div>
		
		<button id="print" class="btn btn-info btn-rounded btn-block btn-sm pull-right" type="button"> <span><i class="fa fa-print"></i>&nbsp;Print</span> </button>
	</div>
</div>