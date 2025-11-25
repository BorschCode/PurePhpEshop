<?php
/**
 * @var array $categories      Array of categories for the left sidebar navigation.
 * @var bool $result           Flag indicating if the order was successfully placed (true) or if the checkout form is shown (false).
 * @var int $totalQuantity     Total number of items selected in the cart.
 * @var float $totalPrice      Total price of all items in the cart.
 * @var array|null $errors     Array of validation errors, if the form submission failed.
 * @var string $userName       Value for the User Name input field.
 * @var string $userPhone      Value for the Phone Number input field.
 * @var string $userComment    Value for the Order Comment input field.
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


                        <?php if ($result): ?>

                            <p>Your order has been placed. We will call you back soon.</p>

                        <?php else: ?>

                            <p>Selected items: <?php echo $totalQuantity; ?>, Total amount: <?php echo number_format($totalPrice, 2); ?> UAH.</p><br/>

                            <div class="col-sm-4">
                                <?php if (isset($errors) && is_array($errors)): ?>
                                    <ul class="text-danger">
                                        <?php foreach ($errors as $error): ?>
                                            <li> - <?php echo $error; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>

                                <p>Fill out the form below to place your order. Our manager will contact you shortly.</p>

                                <div class="login-form">
                                    <form action="#" method="post">

                                        <p>Your Name</p>
                                        <input type="text" name="userName" placeholder="" value="<?php echo htmlspecialchars($userName ?? ''); ?>"/>

                                        <p>Phone Number</p>
                                        <input type="text" name="userPhone" placeholder="" value="<?php echo htmlspecialchars($userPhone ?? ''); ?>"/>

                                        <p>Comment on the order</p>
                                        <input type="text" name="userComment" placeholder="Message" value="<?php echo htmlspecialchars($userComment ?? ''); ?>"/>

                                        <br/>
                                        <br/>
                                        <input type="submit" name="submit" class="btn btn-default" value="Place Order" />
                                    </form>
                                </div>
                            </div>

                        <?php endif; ?>

                    </div>

                </div>
            </div>
        </div>
    </section>


<?php include ROOT . '/views/layouts/footer.php'; ?>