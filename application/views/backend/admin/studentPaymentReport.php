<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-body table-responsive">
                <h1 align="center"><strong>Financial Reports</strong></h1>

                <!-- Amount Paid by Class Summary -->
                <h4 align="center">Amount Paid Per Class</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo get_phrase('Class Name'); ?></th>
                            <th><?php echo get_phrase('Total Amount Paid'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $total_class_paid = 0; // Initialize total variable
                    if (!empty($amount_paid_by_class)): 
                        foreach ($amount_paid_by_class as $class): 
                            $total_class_paid += $class['total_paid']; // Accumulate total
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($class['class_name']); ?></td>
                                <td><?php echo number_format((float)$class['total_paid'], 2, '.', ''); ?></td> 
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td><strong><?php echo get_phrase('Total'); ?></strong></td>
                            <td><strong><?php echo number_format((float)$total_class_paid, 2, '.', ''); ?></strong></td>
                        </tr>
                    <?php else: ?>
                        <tr><td colspan="2" align="center"><?php echo get_phrase('No data available for classes.'); ?></td></tr> 
                    <?php endif; ?>
                    </tbody> 
                </table>

                <!-- Amount Paid Per Month Summary -->
                <h4 align="center">Amount Paid Per Month</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr><th><?php echo get_phrase('Month'); ?></th><th><?php echo get_phrase('Total Amount Paid'); ?></th></tr></thead><tbody> 
                    <?php 
                    $total_monthly_paid = 0; // Initialize total variable
                    if (!empty($amount_paid_per_month)): 
                        foreach ($amount_paid_per_month as $month_data): 
                            if (isset($month_data['month']) && isset($month_data['total_paid'])) {
                                $total_monthly_paid += $month_data['total_paid']; // Accumulate total
                                $month_name = date("F", mktime(0, 0, 0, (int)$month_data['month'], 10));
                                ?>
                                <tr><td><?php echo htmlspecialchars($month_name); ?></td><td><?php echo number_format((float)$month_data['total_paid'], 2, '.', ''); ?></td></tr> 
                            <?php } endforeach; ?>
                            <tr>
                                <td><strong><?php echo get_phrase('Total'); ?></strong></td>
                                <td><strong><?php echo number_format((float)$total_monthly_paid, 2, '.', ''); ?></strong></td>
                            </tr>
                    <?php else: ?>
                        <tr><td colspan="2" align="center"><?php echo get_phrase('No data available for months.'); ?></td></tr> 
                    <?php endif; ?>
                    </tbody> 
                </table>

                 <!-- Frequency of Payments Over Months Summary -->
                <h4 align="center">Number of Payments per Months</h4> 
                <table class="table table-bordered">
                    <thead> 
                        <tr><th><?php echo get_phrase('Month'); ?></th><th><?php echo get_phrase('Payment Count'); ?></th></tr></thead><tbody> 
                    <?php 
                    $total_payment_count = 0; // Initialize total variable
                    if (!empty($payment_frequency)): 
                        foreach ($payment_frequency as $freq_data): 
                            if (isset($freq_data['month']) && isset($freq_data['payment_count'])) {
                                $total_payment_count += $freq_data['payment_count']; // Accumulate total
                                $month_name_freq = date("F", mktime(0, 0, 0, (int)$freq_data['month'], 10));
                                ?>
                                <tr><td><?php echo htmlspecialchars($month_name_freq); ?></td><td><?php echo htmlspecialchars($freq_data['payment_count']); ?></td></tr> 
                            <?php } endforeach; ?> 
                            <tr>
                                <td><strong><?php echo get_phrase('Total'); ?></strong></td>
                                <td><strong><?php echo htmlspecialchars($total_payment_count); ?></strong></td>
                            </tr> 
                    <?php else: ?>
                        <tr><td colspan="2" align="center"><?php echo get_phrase('No payment frequency data available.'); ?></td></tr> 
                    <?php endif; ?> 
                    </tbody> 
                </table>

            </div> <!-- End of panel body -->
        </div> <!-- End of panel -->
    </div> <!-- End of column -->
</div> <!-- End of row -->

<style>
body {
    font-family: Arial, sans-serif;
}

.panel {
    margin: 20px;
}

strong {
    color: #02352d;
}

h4 {
    margin-top: 20px;
}

.table {
    width: 100%;
    margin-bottom: 20px;
}

.table th {
    background-color: #f8f9fa;
}

.table td {
    text-align: center;
}

.table-bordered {
    border: 1px solid #dee2e6;
}

.table-bordered th,
.table-bordered td {
    border: 1px solid #dee2e6;
}

.table th,
.table td {
    padding: 10px;
}

.table tr:nth-child(even) {
    background-color: #f2f2f2;
}

.table tr:hover {
    background-color: #d1ecf1;
}
</style>