<?php
/**
 * Admin Category Delete Confirmation Template
 *
 * Displays a confirmation page for deleting a category.
 * Shows category information and requires user confirmation.
 *
 * @var int $id Category ID to be deleted
 * @var array|null $category Category data array (if available)
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
                    <li><a href="/admin/category">Category Management</a></li>
                    <li class="active">Delete Category</li>
                </ol>
            </div>

            <div class="col-md-6">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h4>Delete Category #<?php echo htmlspecialchars($id); ?></h4>
                    </div>
                    <div class="panel-body">
                        <p><strong>Warning:</strong> Are you sure you want to delete this category?</p>
                        <p>This action cannot be undone.</p>
                        
                        <form method="post" style="display: inline;">
                            <input type="submit" name="submit" value="Delete Category" class="btn btn-danger" />
                            <a href="/admin/category" class="btn btn-default">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>