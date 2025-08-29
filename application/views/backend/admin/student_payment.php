<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-info">
            <div class="panel-heading"> 
                <i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo get_phrase('New Student Payment');?>
            </div>
            <div class="panel-body table-responsive">
                <!----CREATION FORM STARTS---->
                <?php echo form_open(base_url() . 'admin/student_payment/single_invoice', array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                
                <div class="form-group">
                    <label class="col-md-12" for="example-text"><?php echo get_phrase('Receipt Number');?> <b style="color:red">*</b></label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" name="invoice_number" value="<?php echo date('m-Y'). 'RCP' . date('H-is'); ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12" for="example-text"><?php echo get_phrase('Class');?> <b style="color:red">*</b></label>
                    <div class="col-sm-12">
                        <select name="class_id" id="class_id" class="form-control select2" onchange="return get_class_student(this.value)" required>
                            <option value=""><?php echo get_phrase('select_class');?></option>
                            <?php 
                            $classes = $this->db->get('class')->result_array();
                            foreach($classes as $class): ?>
                                <option value="<?php echo $class['class_id']; ?>"><?php echo $class['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div id="single_title_amount_student_holder"></div>

                <div class="form-group">
                    <label class="col-md-12" for="payment_date"><?php echo get_phrase('Select Date');?> <b style="color:red">*</b></label>
                    <div class="col-sm-12">
                        <input type="date" name="payment_date" value="<?php echo date('Y-m-d'); ?>" class="form-control datepicker" id="example-date-input" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12" for "example-text"><?php echo get_phrase('Payment Discount');?> %</label>
                    <div class="col-sm-12">
                        <input type="number" class="form-control" name="discount" min="0" value="0">
                    </div>
                </div>

                <!-- Payment Status -->
                <div class="form-group">
                    <label class="col-md-12" for "example-text"><?php echo get_phrase('Payment Status');?> <b style="color:red">*</b></label>
                    <div class="col-sm-12">
                        <select name="status" class="form-control select2" required>
                            <option value=""> <?php echo get_phrase('payment_status'); ?> </option>
                            <option value='1'> Complete </option>
                            <option value='2'> Incomplete </option>
                        </select>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="form-group">
                    <label class="col-md-12" for "example-text"><?php echo get_phrase('Payment Method');?>  <b style= "color:red">*</b></label>
                    <div class= "col-sm-12">
                        <select name= "payment_method"  class= "form-control select2" required >
                            <option value= ""><?php echo get_phrase('payment_method'); ?></option >
                            <option value= "1"> Bank 1 </option >
                            <option value= "2"> Bank 2 </option >
                            <option value= "3"> Bank 3 </option >
                        </select >
                    </ div >
                </ div >

                <!-- Description Field -->
                <div class="form-group">
                    <label class="col-md-12" for "example-text"><?php echo get_phrase('Description');?></label>
                    <div class="col-sm-12">
                        <textarea class="form-control" name="description"></textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <button type='submit' class='btn btn-info btn-block btn-rounded btn-sm'><i class='fa fa-plus'></i>&nbsp;<?php echo get_phrase('create');?></button>
                </div>

                <?php echo form_close(); ?>
            </div> <!-- End of panel body -->
        </div> <!-- End of panel -->
    </div> <!-- End of column -->
</div> <!-- End of row -->

<script>
// JavaScript to calculate amount paid based on amount and discount
document.querySelector('[name=amount]').addEventListener('input', function() {
    const amount = parseFloat(this.value) || 0;
    const discount = parseFloat(document.querySelector('[name=discount]').value) || 0;

    // Calculate amount paid after discount
    const amountPaid = amount - (amount * (discount / 100));
    // Assuming you want to display the calculated amount in a hidden field or just use it in the model
    document.querySelector('[name=amount_paid]').value = amountPaid.toFixed(2); // This line can be removed if not needed
});

// JavaScript to fetch students based on selected class
function get_class_student(class_id) {
    $.ajax({
        url: '<?php echo base_url();?>admin/get_class_student/' + class_id,
        success: function(response) {
            jQuery('#single_title_amount_student_holder').html(response);
        }
    });
}
</script>




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


/*
function get_class_student(class_id){
    $.ajax({
        url:        '<?php echo base_url();?>admin/get_class_student/' + class_id,
        success:    function(response){
            jQuery('#student_selector_holder').html(response);
        } 

    });
}
*/


function get_class_student(class_id){
    $.ajax({
        url:        '<?php echo base_url();?>admin/get_single_title_amount_student_holder/' + class_id,
        success:    function(response){
            jQuery('#single_title_amount_student_holder').html(response);
        } 

    });
}


function get_single_class_title_amount(id){
    $.ajax({
        url:        '<?php echo base_url();?>admin/get_single_class_title_amount/' + id,
        success:    function(response){
            jQuery('#single_class_title_amount').html(response);
        } 

    });
}



function get_class_mass_student(class_id){
    $.ajax({
        url:        '<?php echo base_url();?>admin/get_mass_title_amount_student_holder/' + class_id,
        success:    function(response){
            jQuery('#mass_title_amount_student_holder').html(response);
        } 

    });
}


function get_mass_class_title_amount(id){
    $.ajax({
        url:        '<?php echo base_url();?>admin/get_mass_class_title_amount/' + id,
        success:    function(response){
            jQuery('#mass_class_title_amount').html(response);
        } 

    });
}


</script>




<!--
<script type="text/javascript">
function get_class_mass_student(class_id){
    $.ajax({
        url:        '<?php echo base_url();?>admin/get_class_mass_student/' + class_id,
        success:    function(response){
            jQuery('#mass_student_selector_holder').html(response);
        } 

    });
}
</script>
-->