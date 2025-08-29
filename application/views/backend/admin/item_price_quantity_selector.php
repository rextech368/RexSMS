<?php
	$query = $this->db->get_where('item' , array('item_id' => $item_id));
	if($query->num_rows() > 0):
	$items = $query->result_array();
	foreach($items as $row):
?>

<div class="form-group">
    <label class="col-md-12" for="example-text">Item price</label>
    <div class="col-sm-12">
	
		<input type="number" class="form-control" name="sales_price" value="<?php echo $row['sales_price'];?>" readonly="" placeholder="sales price" required>
        
    </div>
</div>


<div class="form-group">
    <label class="col-md-12" for="example-text">Available in stock</label>
    <div class="col-sm-12">
	<input type="number" class="form-control" name="stock_quantity" value="<?php echo $row['quantity'];?>" readonly="" placeholder="stock quantity" required>
        
    </div>
</div>


                    <div class="form-group">
                        <label class="col-md-12" for="example-text">How many quantity of item(s) you want to purchase?
                            <b style="color:red">*</b></label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" name="quantity" value="" max="<?=$row['quantity']?>" placeholder="Quantity" required>
                        </div>
                    </div>

              		<?php 
						 $a = $row['quantity']; 
						 $b = $row['alert_quantity']; 
 					?>
					
                    <?php if($b == $a || $b > $a ) : ?>
                    <div class="alert alert-danger" style="border: 1px dotted red">
                        Item&nbsp;<strong><?php echo $row ['name'];?></strong>&nbsp;is almost finished in stock.
                        Remaining&nbsp;<strong><?php echo $row ['quantity'];?></strong> in stock. Please order more from
                        supplier
                    </div>
                    <?php endif; ?>



 <?php endforeach;?>
<?php endif;?>




