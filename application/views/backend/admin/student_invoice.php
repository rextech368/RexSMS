<style>
	.table {
		border-collapse: collapse; /* Ensures borders are collapsed */
	}

	.table th, .table td {
		border: 1px solid #ddd; /* Thin border for table cells */
		padding: 8px; /* Padding for table cells */
	}

	.table th {
		background-color: #f2f2f2; /* Light gray background for headers */
		text-align: left; /* Align header text to the left */
	}

	.table tr:hover {
		background-color: #f1f1f1; /* Highlight row on hover */
	}
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading"> 
                <i class="fa fa-list"></i>&nbsp;&nbsp;<?php echo get_phrase('unpaid_invoices');?>
            </div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body table-responsive">
                    <!-- <div class="row">
                        <div class="col-md-12">
                            <input type="text" id="search" placeholder="<?php echo get_phrase('search');?>" class="form-control" onkeyup="searchInvoices()" />
                        </div>
                    </div> -->
                    <table id="example23" class="display nowrap table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><div><?php echo get_phrase('student');?></div></th>
                                <th><div><?php echo get_phrase('title');?></div></th>
                                <th><div><?php echo get_phrase('description');?></div></th>
                                <th><div><?php echo get_phrase('total');?></div></th>
                                <th><div><?php echo get_phrase('discount');?></div></th>
                                <th><div><?php echo get_phrase('amount_to_pay');?></div></th>
                                <th><div><?php echo get_phrase('amount_paid');?></div></th>
                                <th><div><?php echo get_phrase('date');?></div></th>
                                <th><div><?php echo get_phrase('recorded_by');?></div></th> <!-- New Field -->
                                <th><div><?php echo get_phrase('payment_status');?></div></th>
                                <th><div><?php echo get_phrase('options');?></div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $count = 1;
                                $this->db->where('status', '2'); // Unpaid invoices
                                $this->db->order_by('creation_timestamp', 'desc');
                                $invoices = $this->db->get('invoice')->result_array();
                                foreach ($invoices as $key => $row):
                            ?>
                            <tr>
                                <td><?php echo $this->crud_model->get_type_name_by_id('student', $row['student_id']);?></td>
                                <td><?php echo $row['title'];?></td>
                                <td><?php echo $row['description'];?></td>
                                <td class="text-uppercase"><?php echo $this->db->get_where('settings', array('type' => 'currency'))->row()->description; ?> <?php echo number_format($row['amount'], 2, ".", ",");?></td>
                                <td><?php echo $row['discount'];?> %</td>
                                <td><?php echo $row['amount'] - number_format($row['amount'] * $row['discount'] / 100, 2, ".", ",");?></td>
                                <td><?php echo $this->db->get_where('settings', array('type' => 'currency'))->row()->description; ?> <?php echo number_format($row['amount_paid'], 2, ".", ",");?></td>
                                <td><?php echo date('d M,Y', strtotime($row['creation_timestamp']));?></td>
                                <td><?php echo $this->crud_model->get_type_name_by_id('admin', $row['recorded_by']); // Display Recorded By ?></td> <!-- Display Recorded By -->
                                <td>
                                    <span class="label label-<?php if($row['status'] == '1') echo 'success'; elseif ($row['status'] == '2') echo 'danger'; else echo 'warning';?>">
                                        <?php if($row['status'] == '1'):?>
                                            <?php echo 'Paid';?>
                                        <?php endif;?>

                                        <?php if($row['status'] == '2'):?>
                                            <?php echo 'Unpaid';?>
                                        <?php endif;?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($row['due'] != 0): ?>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_take_payment/<?php echo $row['invoice_id'];?>');">
                                            <button type="button" class="btn btn-info btn-circle btn-xs"><i class="fa fa-credit-card"></i></button>
                                        </a>
                                    <?php endif; ?>
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_view_invoice/<?php echo $row['invoice_id'];?>');">
										<button type="button" class="btn btn-warning btn-circle btn-xs"><i class="fa fa-print"></i></button>
									</a>
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_edit_invoice/<?php echo $row['invoice_id'];?>');">
                                        <button type="button" class="btn btn-success btn-circle btn-xs"><i class="fa fa-edit"></i></button>
                                    </a>
                                    <a href="#" onclick="confirm_modal('<?php echo base_url();?>admin/student_payment/delete_invoice/<?php echo $row['invoice_id'];?>');">
                                        <button type="button" class="btn btn-danger btn-circle btn-xs"><i class="fa fa-times"></i></button>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading"> 
                <i class="fa fa-list"></i>&nbsp;&nbsp;<?php echo get_phrase('paid_invoices');?>
            </div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body table-responsive">
                    <!-- <div class="row">
                        <div class="col-md-12">
                            <input type="text" id="search_paid" placeholder="<?php echo get_phrase('search');?>" class="form-control" onkeyup="searchPaidInvoices()" />
                        </div>
                    </div> -->
                    <table id="example23" class="display nowrap table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><div><?php echo get_phrase('student');?></div></th>
                                <th><div><?php echo get_phrase('title');?></div></th>
                                <th><div><?php echo get_phrase('description');?></div></th>
                                <th><div><?php echo get_phrase('total');?></div></th>
                                <th><div><?php echo get_phrase('discount');?></div></th>
                                <th><div><?php echo get_phrase('amount_to_pay');?></div></th>
                                <th><div><?php echo get_phrase('amount_paid');?></div></th>
                                <th><div><?php echo get_phrase('date');?></div></th>
                                <th><div><?php echo get_phrase('recorded_by');?></div></th> <!-- New Field -->
                                <th><div><?php echo get_phrase('payment_status');?></div></th>
                                <th><div><?php echo get_phrase('options');?></div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $count = 1;
                                $this->db->where('status', '1'); // Paid invoices
                                $this->db->order_by('creation_timestamp', 'desc');
                                $invoices = $this->db->get('invoice')->result_array();
                                foreach ($invoices as $key => $row):
                            ?>
                            <tr>
                                <td><?php echo $this->crud_model->get_type_name_by_id('student', $row['student_id']);?></td>
                                <td><?php echo $row['title'];?></td>
                                <td><?php echo $row['description'];?></td>
                                <td class="text-uppercase"><?php echo $this->db->get_where('settings', array('type' => 'currency'))->row()->description; ?> <?php echo number_format($row['amount'], 2, ".", ",");?></td>
                                <td><?php echo $row['discount'];?> %</td>
                                <td><?php echo $this->db->get_where('settings', array('type' => 'currency'))->row()->description; ?> <?php echo number_format($row['amount'] - ($row['amount'] * $row['discount'] / 100), 2, ".", ",");?></td>
                                <td><?php echo $this->db->get_where('settings', array('type' => 'currency'))->row()->description; ?> <?php echo number_format($row['amount_paid'], 2, ".", ",");?></td>
                                <td><?php echo date('d M,Y', strtotime($row['creation_timestamp']));?></td>
                                <td><?php echo $this->crud_model->get_type_name_by_id('admin', $row['recorded_by']); // Display Recorded By ?></td> <!-- Display Recorded By -->
                                <td>
                                    <span class="label label-success">Paid</span>
                                </td>
                                <td>
									<a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_view_invoice/<?php echo $row['invoice_id'];?>');"><button type="button" class="btn btn-warning btn-circle btn-xs"><i class="fa fa-print"></i></button></a>
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_edit_invoice/<?php echo $row['invoice_id'];?>');">
                                        <button type="button" class="btn btn-success btn-circle btn-xs"><i class="fa fa-edit"></i></button>
                                    </a>
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

<script>
	function showAjaxModal(url) {
		$('#modal_view_invoice').modal('show');
		$.ajax({
			url: url,
			success: function(response) {
				$('#invoice_content').html(response);
			}
		});
	}
</script>