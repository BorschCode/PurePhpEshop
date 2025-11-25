<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Class Pagination
 * Class for generating paginated navigation
 */
final class Pagination
{
    /**
     * Number of navigation links to display
     */
    private int $max = 10;

    /**
     * GET key used for the page number in the URL
     */
    private string $index = 'page';

    /**
     * Current page number
     */
    private int $currentPage;

    /**
     * Total number of records
     */
    private int $total;

    /**
     * Records per page (Limit)
     */
    private int $limit;

    /**
     * Total number of pages
     */
    private int $amount;

    /**
     * Initializes necessary data for navigation
     */
    public function __construct(int $total, int $currentPage, int $limit, string $index)
    {
        // Set the total number of records
        $this->total = $total;

        // Set the limit of records per page
        $this->limit = $limit;

        // Set the key in the URL
        $this->index = $index;

        // Calculate and set the total number of pages
        $this->amount = $this->amount();

        // Set the current page number
        $this->setCurrentPage($currentPage);
    }

    /**
     * Generates and returns the navigation links
     */
    public function get(): string
    {
        // Variable to store links
        $links = '';

        // Get limits for the loop (start and end page numbers)
        [$start, $end] = $this->limits();

        $html = '<ul class="pagination">';
        // Generate the links
        for ($page = $start; $page <= $end; $page++) {
            // If this is the current page, no link is generated and the 'active' class is added
            if ($page === $this->currentPage) {
                $links .= '<li class="active"><a href="#">' . $page . '</a></li>';
            } else {
                // Otherwise, generate the link
                $links .= $this->generateHtml($page);
            }
        }

        // If links were created
        if ($links !== '') {
            // If the current page is not the first page (show 'To First' link)
            if ($this->currentPage > 1) {
                // Create 'To First' link (using '<')
                $links = $this->generateHtml(1, '&lt;') . $links;
            }

            // If the current page is not the last page (show 'To Last' link)
            if ($this->currentPage < $this->amount) {
                // Create 'To Last' link (using '>')
                $links .= $this->generateHtml($this->amount, '&gt;');
            }
        }

        $html .= $links . '</ul>';

        // Return the resulting HTML
        return $html;
    }

    /**
     * Generates the HTML code for a single link
     */
    private function generateHtml(int $page, ?string $text = null): string
    {
        // If link text is not specified
        if ($text === null) {
            // Set the text to the page number
            $text = (string) $page;
        }

        // Clean current URI by removing previous page index (e.g., /page-1)
        $currentURI = rtrim($_SERVER['REQUEST_URI'] ?? '', '/') . '/';
        $currentURI = preg_replace('~/page-[0-9]+~', '', $currentURI);

        // Formulate and return the HTML code for the link
        return '<li><a href="' . $currentURI . $this->index . $page . '">' . $text . '</a></li>';
    }

    /**
     * Determines the start and end pages for the visible block of links
     */
    private function limits(): array
    {
        // Calculate links to the left (so the active link is in the middle)
        $left = $this->currentPage - (int) round($this->max / 2);

        // Calculate the start of the count (minimum is 1)
        $start = $left > 0 ? $left : 1;

        // If there are enough pages ahead to show $this->max links
        if ($start + $this->max <= $this->amount) {
            // Set the end of the loop forward by $this->max pages
            $end = $start > 1 ? $start + $this->max : $this->max;
        } else {
            // End is the total number of pages
            $end = $this->amount;

            // Start is the end minus $this->max (minimum is 1)
            $start = $this->amount - $this->max > 0 ? $this->amount - $this->max : 1;
        }

        // Return the start and end pages
        return [$start, $end];
    }

    /**
     * Sets and validates the current page number
     */
    private function setCurrentPage(int $currentPage): void
    {
        // Get the page number
        $this->currentPage = $currentPage;

        // If the current page is greater than zero
        if ($this->currentPage > 0) {
            // If current page is greater than the total number of pages
            if ($this->currentPage > $this->amount) {
                // Set the page to the last one
                $this->currentPage = $this->amount;
            }
        } else {
            // If invalid or zero, set the page to the first one
            $this->currentPage = 1;
        }
    }

    /**
     * Calculates the total number of pages
     */
    private function amount(): int
    {
        // Divide total records by limit and return (rounded up for partial pages)
        return (int) ceil($this->total / $this->limit);
    }
}
