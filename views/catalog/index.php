<?php
/**
 * Category Products View Template
 *
 * Displays products within a specific category with sidebar navigation.
 * Shows product grid with images, pricing (including sale prices), and add-to-cart functionality.
 * Includes "New" badges for recently added products and hover effects for product images.
 *
 * @var array $categories List of all product categories for sidebar navigation
 * @var array $latestProducts Array of products in the current category
 * @var string $pageTitle Page title for SEO
 * @var string $pageDescription Page description for SEO
 */
include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Catalog</h2>
                    <div class="panel-group category-products">
                        <?php foreach ($categories as $categoryItem): ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a href="/alias/c<?php echo $categoryItem['id'];?>">
                                            <?php echo htmlspecialchars($categoryItem['name']);?>
                                        </a>
                                    </h4>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-9 padding-right">
                <div class="features_items">
                    <h2 class="title text-center">Latest Products</h2>

                    <?php foreach ($latestProducts as $product): ?>
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <div class="imageProduct">
                                            <img src="<?php echo \App\Models\Product::getLowImage($product['id']); ?>" alt="<?php echo htmlspecialchars($product['tittle']); ?>" />
                                            <img src="<?php echo \App\Models\Product::getMediumImage($product['id']); ?>" alt="<?php echo htmlspecialchars($product['tittle']); ?>"/>
                                        </div>

                                        <?php if ($product['price_new']): ?>
                                            <h4><s>$<?php echo $product['price'];?></s></h4>
                                            <h2>$<?php echo $product['price_new'];?></h2>
                                        <?php else: ?>
                                            <h2>$<?php echo $product['price'];?></h2>
                                        <?php endif; ?>
                                        <p>
                                            <a href="/alias/p<?php echo $product['id'];?>">
                                                <?php echo htmlspecialchars($product['tittle']);?>
                                            </a>
                                        </p>
                                        <a href="/cart/add/<?php echo $product['id']; ?>" class="btn btn-default add-to-cart" data-id="<?php echo $product['id']; ?>">
                                            <i class="fa fa-shopping-cart"></i>Add to Cart
                                        </a>
                                    </div>
                                    <?php if ($product['is_new']): ?>
                                        <img src="/assets/img/home/new.png" class="new" alt="New Product" />
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>