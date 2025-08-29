<?php 
	$edit_data = $this->db->get_where('item' , array('item_id' => $param2))->result_array();
	foreach ($edit_data as $row):
?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading"> <i class="fa fa-list"></i>&nbsp;&nbsp;<?php echo get_phrase('edit_item');?>
            </div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body table-responsive">

                    <?php echo form_open(base_url() . 'inventory/item/do_update/' . $row['item_id'] , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('supplier_name');?></label>
                        <div class="col-sm-12">

                            <select name="supplier_id" class="form-control select2" required>
                                <option value=""><?php echo get_phrase('select_supplier');?></option>
                                <?php 
									$supplier = $this->db->get('supplier')->result_array();
									foreach($supplier as $row2):
										?>
                                <option value="<?php echo $row2['supplier_id'];?>" <?php if ($row['supplier_id'] == $row2['supplier_id'])
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
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('item_name');?></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="name" value="<?php echo $row ['name']; ?>"
                                required>

                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('quantity');?></label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" name="quantity"
                                value="<?php echo $row ['quantity']; ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('purchase_price');?></label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" name="purchase_price"
                                value="<?php echo $row ['purchase_price']; ?>" required>
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('sales_price');?></label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" name="sales_price"
                                value="<?php echo $row ['sales_price']; ?>" required>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('date_added');?></label>
                        <div class="col-sm-12">
                            <input class="form-control m-r-10" name="date" type="date"
                                value="<?php echo date('Y-m-d');?>" id="example-date-input" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('alert_quantity');?></label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" name="alert_quantity"
                                value="<?php echo $row ['alert_quantity']; ?>" required>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('description');?></label>
                        <div class="col-sm-12">
                            <textarea rows="5" class="form-control"
                                name="description"><?php echo $row ['description']; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-rounded btn-block btn-sm"><i
                                class="fa fa-edit"></i>&nbsp;<?php echo get_phrase('update');?></button>
                    </div>
                    <?php echo form_close();?>
                </div>
            </div>
            <?php endforeach;?>