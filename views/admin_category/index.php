<?php
/**
 * Admin Category List Template
 *
 * Displays a table of all categories with options to create, edit, and delete.
 * Shows category ID, name, sort order, status, and action buttons.
 *
 * @var array $categoriesList List of all categories with their data
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
                    <li class="active">Category Management</li>
                </ol>
            </div>

            <a href="/admin/category/create" class="btn btn-primary"><i class="fa fa-plus"></i> Add Category</a>

            <h4>Category List</h4>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category Name</th>
                        <th>Sort Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categoriesList as $category): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($category['id']); ?></td>
                            <td><?php echo htmlspecialchars($category['name']); ?></td>
                            <td><?php echo htmlspecialchars($category['sort_order']); ?></td>
                            <td>
                                <span class="label label-<?php echo $category['status'] == 1 ? 'success' : 'default'; ?>">
                                    <?php echo $category['status'] == 1 ? 'Published' : 'Hidden'; ?>
                                </span>
                            </td>
                            <td>
                                <a href="/admin/category/update/<?php echo $category['id']; ?>" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fa fa-pencil"></i> Edit
                                </a>
                                <a href="/admin/category/delete/<?php echo $category['id']; ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this category?')">
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