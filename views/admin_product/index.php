<?php
/**
 * Admin Product List Template
 *
 * Displays a table of all products with options to create, edit, and delete.
 * Shows product ID, code, name, pricing, category, and action buttons.
 *
 * @var array $productsList List of all products with their data
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
                    <li class="active">Product Management</li>
                </ol>
            </div>

            <a href="/admin/product/create" class="btn btn-primary"><i class="fa fa-plus"></i> Add Product</a>
            
            <h4>Product List</h4>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Sale Price</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productsList as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['id']); ?></td>
                            <td><?php echo htmlspecialchars($product['code']); ?></td>
                            <td><?php echo htmlspecialchars($product['tittle']); ?></td>
                            <td>$<?php echo htmlspecialchars($product['price']); ?></td>  
                            <td>
                                <?php if ($product['price_new'] > 0): ?>
                                    $<?php echo htmlspecialchars($product['price_new']); ?>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars(\App\Models\Category::getCategoryText($product['category_id'])); ?></td>
                            <td>
                                <a href="/admin/product/update/<?php echo $product['id']; ?>" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fa fa-pencil"></i> Edit
                                </a>
                                <a href="/admin/product/delete/<?php echo $product['id']; ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this product?')">
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

