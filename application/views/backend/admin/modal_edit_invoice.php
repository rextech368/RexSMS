<?php 
$invoices = $this->db->get_where('invoice', array('invoice_id' => $param2))->result_array();
foreach($invoices as $key => $invoice): ?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading"> 
                <i class="fa fa-list"></i>&nbsp;&nbsp;<?php echo get_phrase('edit_invoice');?>
            </div>
            <div class="panel-body table-responsive">
                <?php echo form_open(base_url() . 'admin/student_payment/update_invoice/'. $invoice['invoice_id'], array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top')); ?>
                
                <div class="form-group">
                    <label class="col-md-12" for="student_id"><?php echo get_phrase('student');?></label>
                    <div class="col-sm-12">
                        <select name="student_id" class="form-control select2" style="width:100%;" required>
                            <?php 
                            $this->db->order_by('class_id','asc');
                            $students = $this->db->get('student')->result_array();
                            foreach($students as $student):
                            ?>
                                <option value="<?php echo $student['student_id'];?>" <?php if($invoice['student_id'] == $student['student_id']) echo 'selected'; ?>>
                                    class <?php echo $this->crud_model->get_class_name($student['class_id']);?> - roll <?php echo $student['roll'];?> - <?php echo $student['name'];?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-12" for="title"><?php echo get_phrase('title');?></label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" name="title" value="<?php echo $invoice['title'];?>" required/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-12" for="description"><?php echo get_phrase('description');?></label>
                    <div class="col-sm-12">
                        <textarea rows="5" class="form-control" name="description" required><?php echo $invoice['description'];?></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-12" for="amount"><?php echo get_phrase('total_amount');?></label>
                    <div class="col-sm-12">
                        <input type="number" class="form-control" name="amount" value="<?php echo $invoice['amount'];?>" required/>
                    </div>
                </div>
                
                <div class="form-group"> 
                    <label class="col-sm-12" for="amount_paid"><?php echo get_phrase('amount_you_have_paid');?>*</label>        
                    <div class="col-sm-12">
                        <input type="number" class="form-control" name="amount_paid" value="<?php echo $invoice['amount_paid'];?>" required readonly/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-12" for="status"><?php echo get_phrase('status');?></label>
                    <div class="col-sm-12">
                        <select name="status" class="form-control select2" style="width:100%" required>
                            <option value="1" <?php if($invoice['status'] == '1') echo 'selected';?>><?php echo get_phrase('paid');?></option>
                            <option value="2" <?php if($invoice['status'] == '2') echo 'selected';?>><?php echo get_phrase('unpaid');?></option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-12" for="date"><?php echo get_phrase('date');?></label>
                    <div class="col-sm-12">
                        <input class="form-control" name="date" type="date" value="<?php echo date('Y-m-d', strtotime($invoice['creation_timestamp'])); ?>" id="example-date-input" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-info btn-sm">
                        <i class="fa fa-plus"></i>&nbsp;<?php echo get_phrase('save_now');?>
                    </button>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?php endforeach; ?>