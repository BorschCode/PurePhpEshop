<?php
/**
 * Admin Order List Template
 *
 * Displays a table of all orders with options to view, edit, and delete.
 * Shows order ID, customer name, phone, date, status, and action buttons.
 *
 * @var array $ordersList List of all orders with their data
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
                    <li class="active">Order Management</li>
                </ol>
            </div>

            <h4>Order List</h4>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Phone</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ordersList as $order): ?>
                        <tr>
                            <td>
                                <a href="/admin/order/view/<?php echo $order['id']; ?>">
                                    #<?php echo htmlspecialchars($order['id']); ?>
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($order['user_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['user_phone']); ?></td>
                            <td><?php echo htmlspecialchars($order['date']); ?></td>
                            <td>
                                <span class="label label-<?php echo $order['status'] == 1 ? 'info' : ($order['status'] == 4 ? 'success' : 'warning'); ?>">
                                    <?php echo \App\Core\Order::getStatusText($order['status']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="/admin/order/view/<?php echo $order['id']; ?>" class="btn btn-sm btn-info" title="View">
                                    <i class="fa fa-eye"></i> View
                                </a>
                                <a href="/admin/order/update/<?php echo $order['id']; ?>" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fa fa-pencil"></i> Edit
                                </a>
                                <a href="/admin/order/delete/<?php echo $order['id']; ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this order?')">
                                    <i class="fa fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

