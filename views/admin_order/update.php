<?php
/**
 * Admin Order Update Form Template
 *
 * Displays the form for editing an existing order in the admin panel.
 * Includes customer information, order date, and status fields.
 *
 * @var int $id Order ID being edited
 * @var array $order Order data array with current values
 * @var string $pageTitle Page title for SEO
 * @var string $pageDescription Page description for SEO
 */
include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="container">
        <div class="row">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Admin Panel</a></li>
                    <li><a href="/admin/order">Order Management</a></li>
                    <li class="active">Edit Order</li>
                </ol>
            </div>

            <h4>Edit Order #<?php echo htmlspecialchars($id); ?></h4>

            <div class="col-lg-6">
                <div class="login-form">
                    <form action="#" method="post">
                        <p>Customer Name</p>
                        <input type="text" name="userName" placeholder="Enter customer name" value="<?php echo htmlspecialchars($order['user_name']); ?>" required>

                        <p>Customer Phone</p>
                        <input type="tel" name="userPhone" placeholder="Enter phone number" value="<?php echo htmlspecialchars($order['user_phone']); ?>" required>

                        <p>Customer Comment</p>
                        <textarea name="userComment" rows="3" placeholder="Customer comments"><?php echo htmlspecialchars($order['user_comment']); ?></textarea>

                        <p>Order Date</p>
                        <input type="datetime-local" name="date" value="<?php echo date('Y-m-d\TH:i', strtotime($order['date'])); ?>" required>

                        <p>Status</p>
                        <select name="status" class="form-control" required>
                            <option value="1" <?php if ($order['status'] == 1) echo ' selected="selected"'; ?>>New Order</option>
                            <option value="2" <?php if ($order['status'] == 2) echo ' selected="selected"'; ?>>Processing</option>
                            <option value="3" <?php if ($order['status'] == 3) echo ' selected="selected"'; ?>>Delivering</option>
                            <option value="4" <?php if ($order['status'] == 4) echo ' selected="selected"'; ?>>Closed</option>
                        </select>
                        
                        <br><br>
                        
                        <input type="submit" name="submit" class="btn btn-primary" value="Update Order">
                        <a href="/admin/order" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

