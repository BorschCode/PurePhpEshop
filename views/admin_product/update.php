<?php
/**
 * Admin Product Update Form Template
 *
 * Displays the form for editing an existing product in the admin panel.
 * Includes all product fields: title, code, pricing, categories, brand,
 * image upload, description, and various status flags.
 *
 * @var int $id Product ID being edited
 * @var array $product Product data array with all current values
 * @var array $categoriesList List of all available categories
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
                    <li><a href="/admin/product">Product Management</a></li>
                    <li class="active">Edit Product</li>
                </ol>
            </div>

            <h4>Edit Product #<?php echo htmlspecialchars($id); ?></h4>

            <br/>

            <div class="col-lg-4">
                <div class="login-form">
                    <form action="#" method="post" enctype="multipart/form-data">

                        <p>Product Name</p>
                        <input type="text" name="tittle" placeholder="Enter product name" value="<?php echo htmlspecialchars($product['tittle']); ?>" required>

                        <p>Product Code</p>
                        <input type="number" name="code" placeholder="Enter product code" value="<?php echo htmlspecialchars($product['code']); ?>" required>

                        <p>Price, $</p>
                        <input type="number" step="0.01" name="price" placeholder="0.00" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                        <p>Sale Price, $</p>
                        <input type="number" step="0.01" name="price_new" placeholder="0.00" value="<?php echo htmlspecialchars($product['price_new']); ?>">
                        <p>Primary Category:</p>
                        <select name="category_id">
                            <?php if (is_array($categoriesList)): ?>
                                <?php foreach ($categoriesList as $category): ?>
                                    <option value="<?php echo $category['id']; ?>"
                                        <?php if ($product['category_id'] == $category['id']) echo ' selected="selected"'; ?>>
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>

                        <p>Additional Categories:</p>
                        <hr>
                        <?php if (is_array($categoriesList)): ?>
                        <?php foreach ($categoriesList as $category): ?>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="categories[]" value="<?php echo $category['id']; ?>" <?php if ($product['category_id'] == $category['id']) echo 'checked="checked"'; ?>>
                                    <?php echo htmlspecialchars($category['name']) ?>
                                </label>
                            </div>
                        <?php endforeach;?>
                        <?php endif; ?>
                        <br/>

                        <p>Brand</p>
                        <input type="text" name="brand" placeholder="Enter brand name" value="<?php echo htmlspecialchars($product['brand']); ?>">

                        <p>Product Image</p>
                        <img src="<?php echo \App\Models\Product::getMediumImage($product['id']); ?>" width="200" alt="Current product image" class="img-thumbnail" />
                        <input type="file" name="image" accept="image/*">

                        <p>Detailed Description</p>
                        <textarea name="description" rows="5" placeholder="Enter product description"><?php echo htmlspecialchars($product['description']); ?></textarea>
                        
                        <p>Breadcrumbs (SEO)</p>
                        <input type="text" name="breadcrumbs" placeholder="Enter breadcrumbs for SEO" value="<?php echo htmlspecialchars($product['breadcrumbs'] ?? ''); ?>">
                        
                        <p>Meta Tags (SEO)</p>
                        <input type="text" name="metatags" placeholder="Enter meta tags for SEO" value="<?php echo htmlspecialchars($product['metatags'] ?? ''); ?>">
                        
                        <br/><br/>

                        <p>Stock Availability</p>
                        <select name="availability" class="form-control">
                            <option value="1" <?php if ($product['availability'] == 1) echo ' selected="selected"'; ?>>In Stock</option>
                            <option value="0" <?php if ($product['availability'] == 0) echo ' selected="selected"'; ?>>Out of Stock</option>
                        </select>
                        
                        <br/><br/>
                        
                        <p>New Product</p>
                        <select name="is_new" class="form-control">
                            <option value="1" <?php if ($product['is_new'] == 1) echo ' selected="selected"'; ?>>Yes</option>
                            <option value="0" <?php if ($product['is_new'] == 0) echo ' selected="selected"'; ?>>No</option>
                        </select>
                        
                        <br/><br/>

                        <p>Recommended</p>
                        <select name="is_recommended" class="form-control">
                            <option value="1" <?php if ($product['is_recommended'] == 1) echo ' selected="selected"'; ?>>Yes</option>
                            <option value="0" <?php if ($product['is_recommended'] == 0) echo ' selected="selected"'; ?>>No</option>
                        </select>
                        
                        <br/><br/>

                        <p>Status</p>
                        <select name="status" class="form-control">
                            <option value="1" <?php if ($product['status'] == 1) echo ' selected="selected"'; ?>>Published</option>
                            <option value="0" <?php if ($product['status'] == 0) echo ' selected="selected"'; ?>>Hidden</option>
                        </select>
                        
                        <br/><br/>
                        
                        <input type="submit" name="submit" class="btn btn-primary" value="Save Product">
                        
                        <br/><br/>
                        
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

