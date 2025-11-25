<?php
/**
 * Contact Form View Template
 *
 * Displays a contact form for users to send messages to the site administrators.
 * Shows success message after successful submission or displays validation errors.
 * Form includes email and message fields with basic validation.
 *
 * @var bool $result True if message was sent successfully, false otherwise
 * @var array $errors Array of validation error messages to display
 * @var string $userEmail User's email address (preserved on form errors)
 * @var string $userText User's message text (preserved on form errors)
 * @var string $pageTitle Page title for SEO
 * @var string $pageDescription Page description for SEO
 */
include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4 padding-right">
                <?php if ($result): ?>
                    <p>Message sent successfully! We will reply to your specified email address.</p>
                <?php else: ?>
                    <?php if (isset($errors) && is_array($errors) && !empty($errors)): ?>
                        <ul class="alert alert-danger">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <div class="signup-form">
                        <h2>Contact Us</h2>
                        <h5>Have a question? Write to us</h5>
                        <br/>
                        <form action="#" method="post">
                            <label for="userEmail">Your Email</label>
                            <input type="email" id="userEmail" name="userEmail" placeholder="E-mail" value="<?php echo htmlspecialchars($userEmail ?? ''); ?>" required/>
                            <label for="userText">Message</label>
                            <textarea id="userText" name="userText" placeholder="Your message" rows="5" required><?php echo htmlspecialchars($userText ?? ''); ?></textarea>
                            <br/>
                            <input type="submit" name="submit" class="btn btn-default" value="Send Message" />
                        </form>
                    </div>
                <?php endif; ?>
                <br/>
                <br/>
            </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>