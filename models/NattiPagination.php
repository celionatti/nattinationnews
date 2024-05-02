<?php

declare(strict_types=1);

/**
 * ======================================
 * ===============        ===============
 * ===== NattiPagination Model
 * ===============        ===============
 * ======================================
 */

namespace PhpStrike\models;


class NattiPagination
{
    protected $totalItems;
    protected $itemsPerPage;
    protected $currentPage;

    public function __construct($totalItems, $itemsPerPage, $currentPage)
    {
        $this->totalItems = $totalItems;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
    }

    public function getTotalPages()
    {
        return ceil($this->totalItems / $this->itemsPerPage);
    }

    public function getStartItem()
    {
        return ($this->currentPage - 1) * $this->itemsPerPage + 1;
    }

    public function getEndItem()
    {
        $endItem = $this->currentPage * $this->itemsPerPage;
        return ($endItem > $this->totalItems) ? $this->totalItems : $endItem;
    }

    public function hasPreviousPage()
    {
        return $this->currentPage > 1;
    }

    public function getPreviousPage()
    {
        return ($this->hasPreviousPage()) ? $this->currentPage - 1 : null;
    }

    public function hasNextPage()
    {
        return $this->currentPage < $this->getTotalPages();
    }

    public function getNextPage()
    {
        return ($this->hasNextPage()) ? $this->currentPage + 1 : null;
    }


    public function generateBootstrapDefLinks($url)
    {
        $links = '';

        if ($this->getTotalPages() > 1) {
            $links .= '<ul class="page-numbers">';

            if ($this->hasPreviousPage()) {
                $prevUrl = $url . ((strpos($url, '?') !== false) ? '&' : '?') . 'page=' . $this->getPreviousPage();
                $links .= '<li><a href="' . $prevUrl . '" class="prev page-numbers">PREV</a></li>';
            }

            $maxLinks = 5; // Maximum links to show before and after the current page
            $halfMaxLinks = floor($maxLinks / 2);
            $startPage = max(1, $this->currentPage - $halfMaxLinks);
            $endPage = min($this->getTotalPages(), $startPage + $maxLinks - 1);

            for ($i = $startPage; $i <= $endPage; $i++) {
                $activeClass = ($i == $this->currentPage) ? 'current' : '';
                $pageUrl = $url . ((strpos($url, '?') !== false) ? '&' : '?') . 'page=' . $i;
                $links .= '<li><span class="page-numbers ' . $activeClass . '" aria-current="page">' . $i . '</span></li>';
            }

            if ($this->hasNextPage()) {
                $nextUrl = $url . ((strpos($url, '?') !== false) ? '&' : '?') . 'page=' . $this->getNextPage();
                $links .= '<li><a href="' . $nextUrl . '" class="next page-numbers">NEXT</a></li>';
            }

            $links .= '</ul>';
        }

        return $links;
    }
}