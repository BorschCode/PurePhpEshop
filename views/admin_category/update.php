<?php
/**
 * Admin Category Update Form Template
 *
 * Displays the form for editing an existing category in the admin panel.
 * Includes category name, sort order, and status fields with current values.
 *
 * @var array $category Category data array with current values
 * @var array|null $errors Array of validation error messages
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
                    <li class="active">Edit Category</li>
                </ol>
            </div>

            <h4>Edit Category "<?php echo htmlspecialchars($category['name']); ?>"</h4>

            <?php if (isset($errors) && is_array($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="col-lg-4">
                <div class="login-form">
                    <form action="#" method="post">
                        <p>Category Name</p>
                        <input type="text" name="name" placeholder="Enter category name" value="<?php echo htmlspecialchars($category['name']); ?>" required>

                        <p>Sort Order</p>
                        <input type="number" name="sort_order" placeholder="0" value="<?php echo htmlspecialchars($category['sort_order']); ?>" min="0" required>

                        <p>Status</p>
                        <select name="status" class="form-control">
                            <option value="1" <?php if ($category['status'] == 1) echo ' selected="selected"'; ?>>Published</option>
                            <option value="0" <?php if ($category['status'] == 0) echo ' selected="selected"'; ?>>Hidden</option>
                        </select>

                        <br><br>

                        <input type="submit" name="submit" class="btn btn-primary" value="Update Category">
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>