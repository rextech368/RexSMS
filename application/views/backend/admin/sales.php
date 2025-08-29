<div class="row">
<div class="col-sm-12">
	<div class="panel panel-default">
		<div class="panel-heading"><i class="fa fa-plus"></i>&nbsp;ADD NEW SALES HERE</div>        
			<div class="panel-body">
				
				<div class="row">
					
					
					
					
					<div class="col-sm-5">
					
                    <?php echo form_open(base_url() . 'inventory/sales/create/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>


                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('item_name');?> <b
                                style="color:red">*</b></label>
                        <div class="col-sm-12">

                            <select name="item_id" class="form-control"
                                onchange="return get_item_price_quantity(this.value)" required>
                                <option><?php echo get_phrase('select_item');?></option>
                                <?php 
									$item = $this->db->get('item')->result_array();
									foreach($item as $row):
										?>
                                <option value="<?php echo $row['item_id'];?>">
                                    <?php echo $row['name'];?>
                                </option>
                                <?php
									endforeach;
								?>
                            </select>


                        </div>
                    </div>
                    <div id="price_quantity_selection_holder"></div>


                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('purchase_by');?> <b
                                style="color:red">*</b></label>
                        <div class="col-sm-12">

                            <select name="student_id" class="form-control" required>
                                <option value=""><?php echo get_phrase('select_student');?></option>
                                <?php 
									$student = $this->db->get('student')->result_array();
									foreach($student as $row):
										?>
                                <option value="<?php echo $row['student_id'];?>">
                                    <?php echo $row['name'];?>
                                </option>
                                <?php
									endforeach;
								?>
                            </select>

                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('sales_date');?> <b
                                style="color:red">*</b></label>
                        <div class="col-sm-12">
                            <input class="form-control m-r-10" name="date" type="date" readonly=""
                                value="<?php echo date('Y-m-d');?>" id="example-date-input" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('seller');?> <b
                                style="color:red">*</b></label>
                        <div class="col-sm-12">
						<input type="text" class="form-control" name="seller" 
						value="<?php echo $this->db->get_where('admin', array('admin_id' => $this->session->userdata('admin_id')))->row()->name;?>" readonly="" /required>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('description');?> </label>
                        <div class="col-sm-12">
                            <textarea rows="5" class="form-control" name="description"></textarea>
                        </div>
                    </div>
					
					
					
                    <div class="alert alert-default" style="border: 1px dotted red">Please ensure you check purchase
                        information very well before hitting submit button, as submitted purchased can not be undone
                        after submission. Only PURCHASE BY , DATE , SELLER AND DESCRIPTION cab be editted.
					</div>
                    <hr>

                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-block btn-info btn-rounded btn-sm"> <i
                                class="fa fa-plus"></i>&nbsp;<?php echo get_phrase('add_sales');?></button>
                        <img id="install_progress" src="<?php echo base_url() ?>assets/images/loader-2.gif"
                            style="margin-left: 20px; display: none" />
                    </div>
                    <br>
                    <?php echo form_close();?>
					</div>
					
					
					<div class="col-sm-7">
					
					<div class="panel-body table-responsive">
                <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>
                                <div><?php echo get_phrase('item_name');?></div>
                            </th>
                            <th>
                                <div><?php echo get_phrase('item_price');?></div>
                            </th>
                            <th>
                                <div><?php echo get_phrase('purchased_quantity');?></div>
                            </th>
                            <th>
                                <div><?php echo get_phrase('total_amount');?></div>
                            </th>
                            <th>
                                <div><?php echo get_phrase('student');?></div>
                            </th>
                            <th>
                                <div><?php echo get_phrase('seller');?></div>
                            </th>
                            <th>
                                <div><?php echo get_phrase('description');?></div>
                            </th>
                            <th>
                                <div><?php echo get_phrase('date_added');?></div>
                            </th>
                            <th>
                                <div><?php echo get_phrase('options');?></div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  foreach($sales as $row):?>
                        <tr>
                            <td>
                                <?php if ($row['item_id'] != '')
											echo $this->db->get_where('item' , array('item_id' => $row['item_id']))->row()->name;
							?>
                            </td>
                            <td><?php if ($row['item_id'] != '')
								echo number_format($this->db->get_where('item' , array('item_id' => $row['item_id']))->row()->sales_price, 2,".",",");
							?></td>
                            <td><span class="label label-info"><?php echo $row['quantity'];?></span></td>
                            <td><span class="label label-success"><?php echo number_format($row['total_amount'], 2,".",",");?></span></td>
                            <td><?php if ($row['student_id'] != '')
											echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->name;
							?></td>
                            <td><?php echo $row['seller'];?></td>
                            <td><?php echo $row['description'];?></td>
                            <td><?php echo date("d M, Y", $row['date']); ?></td>
                            <td>


                                <a href="#"
                                    onclick="showAjaxModal('<?php echo base_url();?>modal/popup/edit_sales_info/<?php echo $row['sales_id'];?>');"
                                    class="btn btn-info btn-circle btn-sm" style="color:white"><i
                                        class="fa fa-edit"></i></a>

                                <a href="#"
                                    onclick="confirm_modal('<?php echo base_url();?>inventory/sales/delete/<?php echo $row['sales_id'];?>');"><button
                                        type="button" class="btn btn-danger btn-circle btn-xs"><i
                                            class="fa fa-times"></i></button></a>

                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
				</div>
					</div>
					
				</div>
			
				
				
				
				
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function get_item_price_quantity(item_id) {
    $.ajax({
        url: '<?php echo base_url();?>admin/get_item_price_quantity/' + item_id,
        success: function(response) {
            jQuery('#price_quantity_selection_holder').html(response);
        }
    });
}
</script>