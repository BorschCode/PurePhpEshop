<?php
/**
 * About Us Page View Template
 *
 * Displays information about the store including company history, mission,
 * and values. This page provides customers with background information
 * about the business and builds trust through transparency.
 *
 * @var string $pageTitle Page title for SEO
 * @var string $pageDescription Page description for SEO
 */
include ROOT.'/views/layouts/header.php'?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="text-center">
                    <h1 class="page-title">About Our Store</h1>
                </div>
                
                <div class="about-content">
                    <h2>Our Story</h2>
                    <p>Welcome to our Pure PHP E-Commerce Catalog - a modern, framework-free online shopping experience built with cutting-edge PHP 8.4 technology.</p>
                    
                    <h2>Our Mission</h2>
                    <p>We are committed to providing high-quality products with exceptional customer service. Our catalog features carefully selected items across multiple categories, ensuring you find exactly what you're looking for.</p>
                    
                    <h2>Why Choose Us?</h2>
                    <ul>
                        <li><strong>Quality Products:</strong> We source only the best items for our customers</li>
                        <li><strong>Secure Shopping:</strong> Your data and transactions are protected</li>
                        <li><strong>Fast Delivery:</strong> Quick and reliable shipping options</li>
                        <li><strong>Customer Support:</strong> Dedicated team ready to help you</li>
                    </ul>
                    
                    <h2>Technology</h2>
                    <p>Our platform is built using modern PHP 8.4 with strict typing, PSR-4 autoloading, and Docker containerization. This ensures a fast, secure, and reliable shopping experience.</p>
                    
                    <h2>Contact Information</h2>
                    <p>Have questions? We'd love to hear from you! Visit our <a href="/contacts/">contact page</a> to get in touch with our team.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<?php include ROOT.'/views/layouts/footer.php'?>