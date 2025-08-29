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
</style> 
	
    <?php
		$class_name = $this->db->get_where('class', array('class_id' => $class_id))->row()->name;
		$select_student_from_model = $this->db->get_where('student', array('student_id'   => $this->session->userdata('student_id')))->result_array();
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
		<div class="printableArea page" align="center"> 
		
			<?php if(get_settings('report_template') == 'gate'):?>
				<?php if($term == 1) : ?>

				<table width="100%" style="margin-top: 20px; height: 100px;">
				  <tr>
					<td class="pull-left"><img src="<?php echo base_url()?>uploads/logo.png"  height="100" width="100"></td>
					<td>
						<P align="center"><strong style="font-size:20px"><?php echo get_settings('system_name')?></strong></P>
						<p align="center">MOTTO: HOME WHERE KNOWLEGE SPEAKS<br>
						<?php echo get_settings('address')?><br>
						<strong style="font-size:20px">EXAMINATION REPORT SHEET</strong></p>
					</td>
					<td class="pull-right"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="100" width="100"></td>
				  </tr>		
				</table>
					
				<table width="100%" height="100" border="1">
				  <tr>
					<td width="234"><strong>NAME:</strong></td>
					<td width="361" class="text-uppercase"><?=$student_selected['name'];?></td>
					<td width="217"><strong>CLASS:</strong></td>
					<td width="182"><?=$class_name;?></td>
					<td width="230"><strong>TERM:</strong></td>
					<td width="206"><?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></td>
				  </tr>
				  <tr>
					<td><strong>ADMISSION NO:</strong></td>
					<td><?=$student_selected['roll'];?></td>
					<td><strong>NO. IN CLASS:</strong></td>
					<td><?=$number_class;?></td>
					<td><strong>SESSION:</strong></td>
					<td><?=$session?></td>
				  </tr>
				  <tr>
					<td><strong>DAY(S) SCHOOL OPEN</strong></td>
					<td><?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term))->num_rows(); ?></td>
					<td width="217"><strong>DAY(S) PRESENT:</strong></td>
					<td><?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,'student_id' => $student_id, 'status' => 1))->num_rows(); ?></td>
					<td><strong>DAY(S) ABSENT:</strong></td>
					<td><?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,'student_id' => $student_id, 'status' => 2))->num_rows(); ?></td>
			      </tr>
				</table>
				<table width="100%"  border="1">
				  <tr>
					<td valign="top"><strong>Subjects</strong></td>
					
					<td valign="top"><strong>CA1<br>(20%)</strong> </td>
					<td valign="top"><strong>CA2<br>(20%)</strong> </td>
					<td valign="top"><strong>CA3<br>(20%)</strong> </td>
					<td valign="top"><strong>Exam<br>(40%)</strong> </td>
					<td valign="top"><strong>Total<br>(100%)</strong> </td>
					<td valign="top"><strong>Grade</strong> </td>
					<td valign="top"><strong>Avg.<br>SCORE </strong></td>
					<td valign="top"><strong>Remarks</strong> </td>
				  </tr>
				  
                    <?php 
						$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
						foreach ($select_subject as $key => $subject):
					?>
					<tr>
					<td valign="top"> <?php echo $subject['name'];?></td>
					
                      <?php 
							$obtained_mark_query = $this->db->get_where('mark', array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 'student_id' => $student_id, 'term' => 1));
							$class_score_one    = $obtained_mark_query->row()->class_score1;
							$class_score_two    = $obtained_mark_query->row()->class_score2;
							$class_score_three  = $obtained_mark_query->row()->class_score3;
							$exam_score         = $obtained_mark_query->row()->exam_score;
							$total_CA        	= $class_score_one + $class_score_two + $class_score_three;
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
					
					<td align="center" valign="top"><?php if($class_score_one == 0)echo '';else echo $class_score_one;?></td>
					<td align="center" valign="top"><?php if($class_score_two == 0)echo '';else echo $class_score_two;?></td>
					<td align="center" valign="top"><?php if($class_score_three == 0)echo '';else echo $class_score_three;?></td>
					<td align="center" valign="top"><?php if($exam_score == 0)echo ''; else echo $exam_score;?></td>
					<td align="center" valign="top"><?php if($total_score == 0)echo ''; else echo $total_score;?></td>
					<td align="center" valign="top">
								<?php if ($total_score <= '100' && $total_score >= '70'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($total_score <= '59' && $total_score >= '50'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '45'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($total_score <= "44" && $total_score >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '0'):?>
								<?php echo 'F';?>
								<?php endif;?>
					</td>
					
					
					<td align="center" valign="top"><?=$total_score?></td>


					<td valign="top"> 
								<?php //echo $obtained_mark_query->row()->comment;?>
					
								<?php if ($total_score <= '100' && $total_score >= '70'):?>
								<?php echo 'EXCELLENT';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'VERY GOOD';?>
								<?php endif;?>
								
								<?php if ($total_score <= '59' && $total_score >= '50'):?>
								<?php echo 'GOOD';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '45'):?>
								<?php echo 'AVERAGE';?>
								<?php endif;?>
								
								<?php if ($total_score <= "44" && $total_score >= '40'):?>
								<?php echo 'BELOW AVERAGE';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '0'):?>
								<?php echo 'FAIL';?>
								<?php endif;?>
					
					
					</td>
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
					<td style="background:white; color:black"><span class="pull-left"><strong>GRADE DETAILS:</strong></span><span class="pull-right"><strong>Number of Subject Offered: 
						<?php echo $getSubjectNumbered?>
					</strong> </span><br>
					A = 70 - 100, B = 60 - 69, C = 50 - 59, D = 40 - 49, E = 0 - 39</td>
				  </tr>
				</table>
				
				
				<table width="100%" border="1">
				  <tr>
					<td height="59"><strong>TOTAL MARK OBTAINABLE: </strong><?php echo $getSubjectNumbered*100?></td>
					<td><strong>TOTAL MARK:</strong>
					<?php
								
									if($sumTotalOfFirstScore == ""){
										echo $sumTotalOfFirstScore = 0;
									}else{
										echo $sumTotalOfFirstScore = $sumTotalOfFirstScore;	
									}
							?>					</td>
					<td><strong>AVERAGE MARK:</strong>
					  <?=round($sumTotalOfFirstScore /$getSubjectNumbered,2)?> 
				    %</td>
					<td><strong>FINAL GRADE: </strong> 
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
					<?php endif;?>							</td>
			      </tr>
				</table>
				
				
				<table width="100%" border="0">
				  <tr>
					<td>
					<span class="pull-left">
					<strong>SCALE DETAILS:</strong><br>
					5 - Excellence degree of observable trait, 4 - Good level of observation trait, 3 - Acceptable level of observable trait, 2 - Poor level of observable trait, 1 - No observable trait
					</span>
					</td>
				  </tr>
				</table>
				
					<?php $select = $this->db->get_where('udemy_stu_rem', array('student_id' => $student_id, 'session' => $session, 'term' => $term))->row();?>
				<table width="100%" border="1">
                 
                  <tr>
                    <td width="34%"><span role="presentation" dir="ltr"><strong>AFFECTIVE TRAITS</strong></span></td>
                    <td width="17%"><div align="center"><strong>RATING</strong></div></td>
                    <td width="29%"><span role="presentation" dir="ltr"><strong>PSYCHOMOTOR</strong></span></td>
                    <td width="20%"><div align="center"><strong>RATING</strong></div></td>
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
                    <td><div align="center"><?=$select->spo;?></div></td>
                  </tr>
                </table>
				<br>
				
				<table width="100%" border="1">
                  <tr>
                    <td width="28%"><span role="presentation" dir="ltr">TEACHER'S REMARK:</span></td>
                    <td colspan="3"><?=$select->fmc;?></td>
                  </tr>
                  <tr>
                    <td><span role="presentation" dir="ltr">TEACHER'S NAME: </span></td>
                    <td><?=$select->fma;?></td>
                    <td>SIGNATURE</td>
                    <td><em><strong><?=$select->fma;?></strong><em></td>
                  </tr>
                  <tr>
                    <td><span role="presentation" dir="ltr">HEAD OF SCHOOL REMARK:</span></td>
                    <td colspan="3"><?=$select->pc;?></td>
                  </tr>
                  <tr>
                    <td><span role="presentation" dir="ltr">HEAD OF SCHOOL'S NAME:</span></td>
                    <td width="30%"><?=$this->db->get_where('admin', array('admin_id' => 1))->row()->name;?></td>
                    <td width="11%">SIGNATURE</td>
                    <td width="31%"><img src="<?php echo base_url();?>uploads/signature.png" width="150px" height="50px"></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="left"><strong>NEXT TERM BEGINS:</strong> <?=get_settings('next_term_begin')?></td>
                  </tr>
                </table>
				
				<?php endif;?>
				<!-- FIRST TERM BEGINS HERE -->
				
				
				<!-- SECOND TERM BEGINS HERE -->
				<?php if($term == 2) : ?>

				<table width="100%" style="margin-top: 20px; height: 100px;">
				  <tr>
					<td class="pull-left"><img src="<?php echo base_url()?>uploads/logo.png"  height="100" width="100"></td>
					<td>
						<P align="center"><strong style="font-size:20px"><?php echo get_settings('system_name')?></strong></P>
						<p align="center">MOTTO: HOME WHERE KNOWLEGE SPEAKS<br>
						<?php echo get_settings('address')?><br>
						<strong style="font-size:20px">EXAMINATION REPORT SHEET</strong></p>
					</td>
					<td class="pull-right"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="100" width="100"></td>
				  </tr>		
				</table>
					
				<table width="100%" height="100" border="1">
				  <tr>
					<td width="234"><strong>NAME:</strong></td>
					<td width="361" class="text-uppercase"><?=$student_selected['name'];?></td>
					<td width="217"><strong>CLASS:</strong></td>
					<td width="182"><?=$class_name;?></td>
					<td width="230"><strong>TERM:</strong></td>
					<td width="206"><?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></td>
				  </tr>
				  <tr>
					<td><strong>ADMISSION NO:</strong></td>
					<td><?=$student_selected['roll'];?></td>
					<td><strong>NO. IN CLASS:</strong></td>
					<td><?=$number_class;?></td>
					<td><strong>SESSION:</strong></td>
					<td><?=$session?></td>
				  </tr>
				  <tr>
					<td><strong>DAY(S) SCHOOL OPEN</strong></td>
					<td><?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term))->num_rows(); ?></td>
					<td width="217"><strong>DAY(S) PRESENT:</strong></td>
					<td><?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,'student_id' => $student_id, 'status' => 1))->num_rows(); ?></td>
					<td><strong>DAY(S) ABSENT:</strong></td>
					<td><?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,'student_id' => $student_id, 'status' => 2))->num_rows(); ?></td>
			      </tr>
				</table>
				<table width="100%"  border="1">
				  <tr>
					<td valign="top"><strong>Subjects</strong></td>
					
					<td valign="top"><strong>CA1<br>(20%)</strong> </td>
					<td valign="top"><strong>CA2<br>(20%)</strong> </td>
					<td valign="top"><strong>CA3<br>(20%)</strong> </td>
					<td valign="top"><strong>Exam<br>(40%)</strong> </td>
					<td valign="top"><strong>Total<br>(100%)</strong> </td>
					<td valign="top"><strong>Grade</strong> </td>
					<td valign="top"><strong>Avg.<br>SCORE</strong></td>
					<td valign="top"><strong>Remarks</strong> </td>
				  </tr>
				  
                    <?php 
						$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
						foreach ($select_subject as $key => $subject):
					?>
					<tr>
					<td valign="top"><?php echo $subject['name'];?></td>
					
                      <?php 
							$obtained_mark_query = $this->db->get_where('mark', array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 'student_id' => $student_id, 'term' => 2));
							$class_score_one    = $obtained_mark_query->row()->class_score1;
							$class_score_two    = $obtained_mark_query->row()->class_score2;
							$class_score_three  = $obtained_mark_query->row()->class_score3;
							$exam_score         = $obtained_mark_query->row()->exam_score;
							$total_CA        	= $class_score_one + $class_score_two + $class_score_three;
							$total_score        = $class_score_one + $class_score_two + $class_score_three + $exam_score;
												
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
					
					<td align="center" valign="top"><?php if($class_score_one == 0)echo '';else echo $class_score_one;?></td>
					<td align="center" valign="top"><?php if($class_score_two == 0)echo '';else echo $class_score_two;?></td>
					<td align="center" valign="top"><?php if($class_score_three == 0)echo '';else echo $class_score_three;?></td>
					<td align="center" valign="top"><?php if($exam_score == 0)echo ''; else echo $exam_score;?></td>
					<td align="center" valign="top"><?php if($total_score == 0)echo ''; else echo $total_score;?></td>
					<td align="center" valign="top">
								<?php if ($total_score <= '100' && $total_score >= '70'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($total_score <= '59' && $total_score >= '50'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '45'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($total_score <= "44" && $total_score >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '0'):?>
								<?php echo 'F';?>
								<?php endif;?>
					</td>
					
					
					<td align="center" valign="top"><?=$total_score?></td>


					<td valign="top"> 
					
					<?php //echo $obtained_mark_query->row()->comment;?>
					
								<?php if ($total_score <= '100' && $total_score >= '70'):?>
								<?php echo 'EXCELLENT';?>
								<?php endif;?>
								
								<?php if ($total_score <= '69' && $total_score >= '60'):?>
								<?php echo 'VERY GOOD';?>
								<?php endif;?>
								
								<?php if ($total_score <= '59' && $total_score >= '50'):?>
								<?php echo 'GOOD';?>
								<?php endif;?>
								
								<?php if ($total_score <= "49" && $total_score >= '45'):?>
								<?php echo 'AVERAGE';?>
								<?php endif;?>
								
								<?php if ($total_score <= "44" && $total_score >= '40'):?>
								<?php echo 'BELOW AVERAGE';?>
								<?php endif;?>
								
								<?php if ($total_score <= "39" && $total_score >= '0'):?>
								<?php echo 'FAIL';?>
								<?php endif;?>
					
					
					</td>
				  </tr>
				  <?php endforeach;?>
				</table>
				
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
				
				
				<table width="100%" border="0">
				  <tr>
					<td style="background:white; color:black"><span class="pull-left"><strong>GRADE DETAILS:</strong></span><span class="pull-right"><strong>Number of Subject Offered: 
						<?php echo $getSubjectNumbered?>
					</strong> </span><br>
					A = 70 - 100, B = 60 - 69, C = 50 - 59, D = 40 - 49, E = 0 - 39</td>
				  </tr>
				</table>
				
				
				<table width="100%" border="1">
				  <tr>
					<td height="59"><strong>TOTAL MARK OBTAINABLE: </strong><?php echo $getSubjectNumbered*100?></td>
					<td><strong>TOTAL MARK:</strong>
					<?php
								
									if($sumTotalOfSecondScore == ""){
										echo $sumTotalOfSecondScore = 0;
									}else{
										echo $sumTotalOfSecondScore = $sumTotalOfSecondScore;	
									}
							?>					</td>
					<td><strong>AVERAGE MARK:</strong>
					  <?=round($sumTotalOfSecondScore /$getSubjectNumbered,2)?> 
				    %</td>
					<td><strong>FINAL GRADE: </strong> 
								<?php $FindGrade = round($sumTotalOfSecondScore /$getSubjectNumbered,2);?>
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
				
				
				<table width="100%" border="0">
				  <tr>
					<td>
					<span class="pull-left">
					<strong>SCALE DETAILS:</strong><br>
					5 - Excellence degree of observable trait, 4 - Good level of observation trait, 3 - Acceptable level of observable trait, 2 - Poor level of observable trait, 1 - No observable trait
					</span>
					</td>
				  </tr>
				</table>
				
					<?php $select = $this->db->get_where('udemy_stu_rem', array('student_id' => $student_id, 'session' => $session, 'term' => $term))->row();?>
				<table width="100%" border="1">
                 
                  <tr>
                    <td width="34%"><span role="presentation" dir="ltr"><strong>AFFECTIVE TRAITS</strong></span></td>
                    <td width="17%"><div align="center"><strong>RATING</strong></div></td>
                    <td width="29%"><span role="presentation" dir="ltr"><strong>PSYCHOMOTOR</strong></span></td>
                    <td width="20%"><div align="center"><strong>RATING</strong></div></td>
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
                    <td><div align="center"><?=$select->spo;?></div></td>
                  </tr>
                </table>
				<br>
				
				<table width="100%" border="1">
                  <tr>
                    <td width="28%"><span role="presentation" dir="ltr"> TEACHER'S REMARK:</span></td>
                    <td colspan="3"><?=$select->fmc;?></td>
                  </tr>
                  <tr>
                    <td><span role="presentation" dir="ltr"> TEACHER'S NAME: </span></td>
                    <td><?=$select->fma;?></td>
                    <td>SIGNATURE</td>
                    <td><em><strong><?=$select->fma;?></strong><em></td>
                  </tr>
                  <tr>
                    <td><span role="presentation" dir="ltr">HEAD OF SCHOOL REMARK:</span></td>
                    <td colspan="3"><?=$select->pc;?></td>
                  </tr>
                  <tr>
                    <td><span role="presentation" dir="ltr">HEAD OF SCHOOL'S NAME:</span></td>
                    <td width="30%"><?=$this->db->get_where('admin', array('admin_id' => 1))->row()->name;?></td>
                    <td width="11%">SIGNATURE</td>
                    <td width="31%"><img src="<?php echo base_url();?>uploads/signature.png" width="150px" height="50px"></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="left"><strong>NEXT TERM BEGINS:</strong> <?=get_settings('next_term_begin')?></td>
                  </tr>
                </table>
				
				<?php endif;?>
				<!-- SECOND TERM ENDS HERE -->
				
				
				
				
				<!-- THIRD TERM BEGINS HERE -->
				<?php if($term == 3) : ?>

				<table width="100%" style="margin-top: 20px; height: 100px;">
				  <tr>
					<td class="pull-left"><img src="<?php echo base_url()?>uploads/logo.png"  height="100" width="100"></td>
					<td>
						<P align="center"><strong style="font-size:20px"><?php echo get_settings('system_name')?></strong></P>
						<p align="center">MOTTO: HOME WHERE KNOWLEGE SPEAKS<br>
						<?php echo get_settings('address')?><br>
						<strong style="font-size:20px">EXAMINATION REPORT SHEET</strong></p>
					</td>
					<td class="pull-right"><img src="<?php echo $this->crud_model->get_image_url('student', $student_selected['student_id']); ?>"  height="100" width="100"></td>
				  </tr>		
				</table>
					
				<table width="100%" height="100" border="1">
				  <tr>
					<td width="234"><strong>NAME:</strong></td>
					<td width="361" class="text-uppercase"><?=$student_selected['name'];?></td>
					<td width="217"><strong>CLASS:</strong></td>
					<td width="182"><?=$class_name;?></td>
					<td width="230"><strong>TERM:</strong></td>
					<td width="206"><?php if($term == 1) echo '1ST TERM'; elseif($term == 2) echo '2ND TERM'; else echo '3RD TERM';?></td>
				  </tr>
				  <tr>
					<td><strong>ADMISSION NO:</strong></td>
					<td><?=$student_selected['roll'];?></td>
					<td><strong>NO. IN CLASS:</strong></td>
					<td><?=$number_class;?></td>
					<td><strong>SESSION:</strong></td>
					<td><?=$session?></td>
				  </tr>
				  <tr>
					<td><strong>DAY(S) SCHOOL OPEN</strong></td>
					<td><?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term))->num_rows(); ?></td>
					<td width="217"><strong>DAY(S) PRESENT:</strong></td>
					<td><?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,'student_id' => $student_id, 'status' => 1))->num_rows(); ?></td>
					<td><strong>DAY(S) ABSENT:</strong></td>
					<td><?=$this->db->get_where('attendance', array('session' => $session, 'term' => $term,'student_id' => $student_id, 'status' => 2))->num_rows(); ?></td>
			      </tr>
				</table>
				<table width="100%"  border="1">
				  <tr>
					<td valign="top"><strong>Subjects</strong></td>
					
					<td valign="top"><strong>CA1<br>(20%)</strong> </td>
					<td valign="top"><strong>CA2<br>(20%)</strong> </td>
					<td valign="top"><strong>CA3<br>(20%)</strong> </td>
					<td valign="top"><strong>Exam<br>(40%)</strong> </td>
					<td valign="top"><strong>Total<br>(100%)</strong> </td>
					<td valign="top"><strong>CUM.<br>B/F</strong> </td>
					<td valign="top"><strong>Avg.<br>SCORE</strong></td>
					<td valign="top"><strong>Grade</strong> </td>
					<td valign="top"><strong>Remarks</strong> </td>
				  </tr>
				  
                    <?php 
						$select_subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
						foreach ($select_subject as $key => $subject):
					?>
					<tr>
					<td valign="top"><?php echo $subject['name'];?></td>
					
						<?php 
						

						
							$obtained_mark_query2= $this->db->get_where('mark', array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 'student_id' => $student_id, 'term' => 2));
							$class_score_one2    = $obtained_mark_query2->row()->class_score1;
							$class_score_two2    = $obtained_mark_query2->row()->class_score2;
							$class_score_three2  = $obtained_mark_query2->row()->class_score3;
							$exam_score2         = $obtained_mark_query2->row()->exam_score;
							$total_CA2        	 = $class_score_one2 + $class_score_two2 + $class_score_three2;
							$total_score2        = $total_CA2 + $exam_score2;
												
							if($total_score2 == ""){
								$total_score2 = 0;
							}else{
								$total_score2 = $total_score2;	
							}	
							
							
							$obtained_mark_query3= $this->db->get_where('mark', array('class_id' => $class_id, 'subject_id' => $subject['subject_id'], 'student_id' => $student_id, 'term' => 3));
							$class_score_one3    = $obtained_mark_query3->row()->class_score1;
							$class_score_two3    = $obtained_mark_query3->row()->class_score2;
							$class_score_three3  = $obtained_mark_query3->row()->class_score3;
							$exam_score3         = $obtained_mark_query3->row()->exam_score;
							$total_CA3        	 = $class_score_one3 + $class_score_two3 + $class_score_three3;
							$total_score3        = $total_CA3 + $exam_score3;
												
							if($total_score3 == ""){
								$total_score3 = 0;
							}else{
								$total_score3 = $total_score3;	
							}
														
							$divide = ($total_score2 + $total_score3) / 2;
							$roundDivide = round($divide,2);	
							
							$update['sum_third'] = $roundDivide;
							$this->db->where('subject_id' , $subject['subject_id']);
							$this->db->where('student_id' , $student_id);
							$this->db->update('mark', $update);
										
						?>
					
					<td align="center" valign="top"><?php if($class_score_one3 == 0)echo '';else echo $class_score_one3;?></td>
					<td align="center" valign="top"><?php if($class_score_two3 == 0)echo '';else echo $class_score_two3;?></td>
					<td align="center" valign="top"><?php if($class_score_three3 == 0)echo '';else echo $class_score_three3;?></td>
					<td align="center" valign="top"><?php if($exam_score3 == 0)echo ''; else echo $exam_score3;?></td>
					<td align="center" valign="top"><?php if($total_score3 == 0)echo ''; else echo $total_score3;?></td>
					<td align="center" valign="top"><?php if($roundDivide == 0)echo ''; else echo $roundDivide;?></td>
					<td align="center" valign="top"><?=$roundDivide?></td>
					<td align="center" valign="top">
								<?php if ($roundDivide <= '100' && $roundDivide >= '70'):?>
								<?php echo 'A';?>
								<?php endif;?>
								
								<?php if ($roundDivide <= '69.99' && $roundDivide >= '60'):?>
								<?php echo 'B';?>
								<?php endif;?>
								
								<?php if ($roundDivide <= '59.99' && $roundDivide >= '50'):?>
								<?php echo 'C';?>
								<?php endif;?>
								
								<?php if ($roundDivide <= "49.99" && $roundDivide >= '45'):?>
								<?php echo 'D';?>
								<?php endif;?>
								
								<?php if ($roundDivide <= "44.99" && $roundDivide >= '40'):?>
								<?php echo 'E';?>
								<?php endif;?>
								
								<?php if ($roundDivide <= "39.99" && $roundDivide >= '0'):?>
								<?php echo 'F';?>
								<?php endif;?>
					</td>
					
					
					


					<td valign="top"> 
					<?php //echo $obtained_mark_query->row()->comment;?>
					
								<?php if ($roundDivide <= '100' && $roundDivide >= '70'):?>
								<?php echo 'EXCELLENT';?>
								<?php endif;?>
								
								<?php if ($roundDivide <= '69.99' && $roundDivide >= '60'):?>
								<?php echo 'VERY GOOD';?>
								<?php endif;?>
								
								<?php if ($roundDivide <= '59.99' && $roundDivide >= '50'):?>
								<?php echo 'GOOD';?>
								<?php endif;?>
								
								<?php if ($roundDivide <= "49.99" && $roundDivide >= '45'):?>
								<?php echo 'AVERAGE';?>
								<?php endif;?>
								
								<?php if ($roundDivide <= "44.99" && $roundDivide >= '40'):?>
								<?php echo 'BELOW AVERAGE';?>
								<?php endif;?>
								
								<?php if ($roundDivide <= "39.99" && $roundDivide >= '0'):?>
								<?php echo 'FAIL';?>
								<?php endif;?>
					
					
					
					</td>
				  </tr>
				  <?php endforeach;?>
				</table>
				
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
				
				
				<table width="100%" border="0">
				  <tr>
					<td style="background:white; color:black"><span class="pull-left"><strong>GRADE DETAILS:</strong></span><span class="pull-right"><strong>Number of Subject Offered: 
						<?php echo $getSubjectNumbered?>
					</strong> </span><br>
					A = 70 - 100, B = 60 - 69, C = 50 - 59, D = 40 - 49, E = 0 - 39</td>
				  </tr>
				</table>
				
				
				<table width="100%" border="1">
				  <tr>
					<td height="59"><strong>TOTAL MARK OBTAINABLE: </strong><?php echo $getSubjectNumbered*100?></td>
					<td><strong>TOTAL MARK:</strong>
					<?php
								
									if($sumTotalOfThirdScore == ""){
										echo $sumTotalOfThirdScore = 0;
									}else{
										echo $sumTotalOfThirdScore = $sumTotalOfThirdScore;	
									}
							?>					</td>
					<td><strong>AVERAGE MARK:</strong>
					  <?=round($sumTotalOfThirdScore /$getSubjectNumbered,2)?> 
				    %</td>
					<td><strong>FINAL GRADE: </strong> 
								<?php $FindGrade = round($sumTotalOfThirdScore /$getSubjectNumbered,2);?>
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
				
				
				<table width="100%" border="0">
				  <tr>
					<td>
					<span class="pull-left">
					<strong>SCALE DETAILS:</strong><br>
					5 - Excellence degree of observable trait, 4 - Good level of observation trait, 3 - Acceptable level of observable trait, 2 - Poor level of observable trait, 1 - No observable trait
					</span>
					</td>
				  </tr>
				</table>
				
					<?php $select = $this->db->get_where('udemy_stu_rem', array('student_id' => $student_id, 'session' => $session, 'term' => $term))->row();?>
				<table width="100%" border="1">
                 
                  <tr>
                    <td width="34%"><span role="presentation" dir="ltr"><strong>AFFECTIVE TRAITS</strong></span></td>
                    <td width="17%"><div align="center"><strong>RATING</strong></div></td>
                    <td width="29%"><span role="presentation" dir="ltr"><strong>PSYCHOMOTOR</strong></span></td>
                    <td width="20%"><div align="center"><strong>RATING</strong></div></td>
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
                    <td><div align="center"><?=$select->spo;?></div></td>
                  </tr>
                </table>
				<br>
				
				<table width="100%" border="1">
                  <tr>
                    <td width="28%"><span role="presentation" dir="ltr"> TEACHER'S REMARK:</span></td>
                    <td colspan="3"><?=$select->fmc;?></td>
                  </tr>
                  <tr>
                    <td><span role="presentation" dir="ltr"> TEACHER'S NAME: </span></td>
                    <td><?=$select->fma;?></td>
                    <td>SIGNATURE</td>
                    <td><em><strong><?=$select->fma;?></strong><em></td>
                  </tr>
                  <tr>
                    <td><span role="presentation" dir="ltr">HEAD OF SCHOOL REMARK:</span></td>
                    <td colspan="3"><?=$select->pc;?></td>
                  </tr>
                  <tr>
                    <td><span role="presentation" dir="ltr">HEAD OF SCHOOL'S NAME:</span></td>
                    <td width="30%"><?=$this->db->get_where('admin', array('admin_id' => 1))->row()->name;?></td>
                    <td width="11%">SIGNATURE</td>
                    <td width="31%"><img src="<?php echo base_url();?>uploads/signature.png" width="150px" height="50px"></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="left"><strong>NEXT TERM BEGINS:</strong> <?=get_settings('next_term_begin')?></td>
                  </tr>
                </table>
				
				<?php endif;?>
				<!-- THIRD TERM ENDS HERE -->
				
				<?php endif;?>
				<p style='overflow:hidden;page-break-before:always;'></p>
		</div> 
		<?php endforeach;?>
		

	
		<br>
		<div align="center">
			<button id="print" class="btn btn-success btn-sm" type="button"> <span><i class="fa fa-print"></i>&nbsp;Print</span> </button>
		</div><br><br>
 
