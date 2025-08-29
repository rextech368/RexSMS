<?php 
	$edit_data = $this->db->get_where('sales' , array('sales_id' => $param2))->result_array();
	foreach ($edit_data as $row):
?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading"> <i class="fa fa-list"></i>&nbsp;&nbsp;<?php echo get_phrase('edit_sales');?>
            </div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body table-responsive">

                    <?php echo form_open(base_url() . 'inventory/sales/do_update/' . $row['sales_id'] , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>



                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('purchase_by');?></label>
                        <div class="col-sm-12">

                            <select name="student_id" class="form-control select2" required>
                                <option value=""><?php echo get_phrase('select_student');?></option>
                                <?php 
									$supplier = $this->db->get('student')->result_array();
									foreach($supplier as $row2):
										?>
                                <option value="<?php echo $row2['student_id'];?>" <?php if ($row['student_id'] == $row2['student_id'])
                                				echo 'selected';?>>
                                    <?php echo $row2['name'];?>
                                </option>
                                <?php
									endforeach;
								?>
                            </select>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('description');?></label>
                        <div class="col-sm-12">
                            <textarea rows="5" class="form-control"
                                name="description"><?php echo $row['description']; ?></textarea>
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('sales_date');?></label>
                        <div class="col-sm-12">
                            <input class="form-control m-r-10" name="date" type="date" readonly=""
                                value="<?php echo date('Y-m-d', $row['date']);?>" id="example-date-input" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('seller');?></label>
                        <div class="col-sm-12">

						<input type="text" class="form-control" name="seller" value="<?php echo $this->db->get_where('admin', array('admin_id' => $this->session->userdata('admin_id')))->row()->name;?>" readonly="" /required>

                        </div>
                    </div>





                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-block btn-info btn-rounded btn-sm"> <i
                                class="fa fa-plus"></i>&nbsp;<?php echo get_phrase('add_sales');?></button>
                        <img id="install_progress" src="<?php echo base_url() ?>assets/images/loader-2.gif"
                            style="margin-left: 20px; display: none" />
                    </div>
                    <br>
                    <?php echo form_close();?>
                </div>
            </div>
            <?php endforeach;?>