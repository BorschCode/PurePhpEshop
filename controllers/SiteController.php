<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;

final class SiteController
{
    /**
     * Handles the display of the homepage (index page).
     */
    public function actionIndex(): bool
    {
        // Fetch categories list
        $categories = Category::getCategoriesList();

        // Fetch the 6 latest products
        $latestProducts = Product::getLatestProducts(6);

        // Fetch recommended products for a slider (uncommented for potential future use)
        // $sliderProducts = Product::getRecommendedProducts();

        $pageTitle = "Home";
        $pageDescription = "Store home page";

        require_once ROOT.'/views/main/index.php';
        return true;
    }

    /**
     * Handles the contact form submission and display.
     */
    public function actionContact(): bool
    {
        $userEmail = '';
        $userText = '';
        $result = false; // Flag for successful submission
        $errors = [];     // Use an array to collect validation errors

        if (isset($_POST['submit'])) {

            // Use null coalescing operator for safer variable access
            $userEmail = $_POST['userEmail'] ?? '';
            $userText = $_POST['userText'] ?? '';

            // 1. Validate email
            if (!User::checkEmail($userEmail)) {
                $errors[] = 'Invalid email address.';
            }

            // 2. Validate message content
            if (empty(trim($userText))) {
                $errors[] = 'The message cannot be empty.';
            }

            if (empty($errors)) {
                $adminEmail = 'admin@test.com';
                $message = "Message from contact form:\n\n{$userText}\n\nReply to: {$userEmail}";
                $subject = 'New Contact Form Submission';

                // Note: mail() is often unreliable; a proper SMTP library is recommended in production
                $mailSent = mail($adminEmail, $subject, $message, "From: {$userEmail}");

                if ($mailSent) {
                    $result = true; // Submission successful
                } else {
                    $errors[] = 'A server error occurred. Please try again later.';
                }
            }
        }

        $pageTitle = "Contact Us";
        $pageDescription = "Store contact page";
        // Pass $userEmail, $userText, $result, and $errors to the view
        require_once ROOT . '/views/main/contact.php';

        return true;
    }

    /**
     * Displays the blog index page.
     */
    public function actionBlog(): bool
    {
        $pageTitle = "Blog";
        $pageDescription = "Latest news and articles";
        require_once ROOT . '/views/blog/index.php';
        return true;
    }

    /**
     * Displays the 'About Us' page.
     */
    public function actionAbout(): bool
    {
        $pageTitle = "About Us";
        $pageDescription = "Our company story and mission";
        require_once ROOT . '/views/about/index.php';
        return true;
    }
}
