<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-plus"></i>&nbsp;
                <div class="pull-right"><a href="#" data-perform="panel-collapse"><i
                            class="fa fa-plus"></i>&nbsp;&nbsp;ADD NEW item HERE</a> <a href="#"
                        data-perform="panel-dismiss"></a> </div>
            </div>
            <div class="panel-wrapper collapse out" aria-expanded="true">
                <div class="panel-body">


                    <?php echo form_open(base_url() . 'inventory/item/create/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>


                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('supplier_name');?> <b
                                style="color:red">*</b></label>
                        <div class="col-sm-12">

                            <select name="supplier_id" class="form-control" required>
                                <option value=""><?php echo get_phrase('select_supplier');?></option>
                                <?php 
									$supplier = $this->db->get('supplier')->result_array();
									foreach($supplier as $row):
										?>
                                <option value="<?php echo $row['supplier_id'];?>">
                                    <?php echo $row['name'];?>
                                </option>
                                <?php
									endforeach;
								?>
                            </select>

                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('item_name');?> <b
                                style="color:red">*</b></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="name" required>

                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('quantity');?> <b
                                style="color:red">*</b></label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" name="quantity" value="" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('purchase_price');?> <b
                                style="color:red">*</b></label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" name="purchase_price" value="" required>
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('sales_price');?> <b
                                style="color:red">*</b></label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" name="sales_price" value="" required>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('date_added');?> <b
                                style="color:red">*</b></label>
                        <div class="col-sm-12">
                            <input class="form-control m-r-10" name="date" type="date"
                                value="<?php echo date('Y-m-d');?>" id="example-date-input" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('alert_quantity');?> <b
                                style="color:red">*</b></label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" name="alert_quantity" value="" required>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('description');?></label>
                        <div class="col-sm-12">
                            <textarea rows="5" class="form-control" name="description"></textarea>
                        </div>
                    </div>


                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-info btn-block btn-rounded btn-sm"> <i
                                class="fa fa-plus"></i>&nbsp;<?php echo get_phrase('add_item');?></button>
                    </div>
                    <br>
                    <?php echo form_close();?>


                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">

            <div class="panel-body table-responsive">
                <?php echo get_phrase('list_items');?>
                <hr>

                <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>
                                <div><?php echo get_phrase('supplier_name');?></div>
                            </th>
                            <th>
                                <div><?php echo get_phrase('iten_name');?></div>
                            </th>
                            <th>
                                <div><?php echo get_phrase('quantity');?></div>
                            </th>
                            <th>
                                <div><?php echo get_phrase('purchase_price');?></div>
                            </th>
                            <th>
                                <div><?php echo get_phrase('sales_price');?></div>
                            </th>
                            <th>
                                <div><?php echo get_phrase('date_added');?></div>
                            </th>
                            <th>
                                <div><?php echo get_phrase('alert_quantity');?></div>
                            </th>
                            <th>
                                <div><?php echo get_phrase('options');?></div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  foreach($item as $row):?>
                        <tr>
                            <td>
                                <?php if ($row['supplier_id'] != '')
											echo $this->db->get_where('supplier' , array('supplier_id' => $row['supplier_id']))->row()->name;
							?>
                            </td>
                            <td><?php echo $row['name'];?></td>
                            <td><span class="label label-info"><?php echo $row['quantity'];?></span></td>
                            <td><?php echo $row['purchase_price'];?></td>
                            <td><?php echo $row['sales_price'];?></td>
                            <td><?php echo date("d M, Y", $row['date']); ?></td>
                            <td><span class="label label-danger"><?php echo $row['alert_quantity'];?></span></td>

                            <td>


                                <a href="#"
                                    onclick="showAjaxModal('<?php echo base_url();?>modal/popup/edit_item_info/<?php echo $row['item_id'];?>');"
                                    class="btn btn-info btn-circle btn-sm" style="color:white"><i
                                        class="fa fa-edit"></i></a>

                                <a href="#"
                                    onclick="confirm_modal('<?php echo base_url();?>inventory/item/delete/<?php echo $row['item_id'];?>');"><button
                                        type="button" class="btn btn-danger btn-circle btn-xs"><i
                                            class="fa fa-times"></i></button></a>

                                <a href="#"
                                    onclick="showAjaxModal('<?php echo base_url();?>modal/popup/view_item_info/<?php echo $row['item_id'];?>');"
                                    class="btn btn-success btn-circle btn-sm" style="color:white"><i
                                        class="fa fa-print"></i></a>

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