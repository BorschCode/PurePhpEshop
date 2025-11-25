<?php
/**
 * @var array $categories       Array of categories for the left sidebar navigation.
 * @var array $productsInCart   Associative array mapping product IDs to the quantity selected by the user.
 * @var array $products         Array of detailed product information (fetched from the database based on IDs in $productsInCart). Each product item has 'id', 'code', 'tittle', and 'price'.
 * @var float $totalPrice       The calculated total cost of all items in the cart.
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
                                            <a href="/alias/c<?php echo $categoryItem['id']; ?>">
                                                <?php echo $categoryItem['name']; ?>
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
                        <h2 class="title text-center">Cart</h2>

                        <?php if ($productsInCart): ?>
                            <p>You have selected these products:</p>
                            <table class="table-bordered table-striped table">
                                <thead>
                                <tr>
                                    <th>Product Code</th>
                                    <th>Name</th>
                                    <th>Cost, UAH</th>
                                    <th>Quantity, pcs</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($product['code']);?></td>
                                        <td>
                                            <a href="/alias/p<?php echo $product['id'];?>">
                                                <?php echo htmlspecialchars($product['tittle']);?>
                                            </a>
                                        </td>
                                        <td><?php echo number_format($product['price'], 2);?></td>
                                        <td><?php echo $productsInCart[$product['id']];?></td>
                                        <td>
                                            <a class="btn btn-default checkout" href="/cart/delete/<?php echo $product['id'];?>" title="Remove Item">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Total Cost, UAH:</strong></td>
                                    <td><strong><?php echo number_format($totalPrice, 2);?></strong></td>
                                </tr>
                                </tfoot>
                            </table>

                            <a class="btn btn-default checkout" href="/cart/checkout"><i class="fa fa-shopping-cart"></i> Place Order</a>
                        <?php else: ?>
                            <p>Cart is empty.</p>

                            <a class="btn btn-default checkout" href="/"><i class="fa fa-shopping-cart"></i> Return to Shopping</a>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include ROOT . '/views/layouts/footer.php'; ?>