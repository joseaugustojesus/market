<?php

namespace app\database;

class Pagination
{
    public $currentPage = 1;
    public $totalPages;
    public $linksPerPage = 5;
    public $itemsPerPage = 10;
    public $totalItems;
    public $pageIdentifier = 'page';


    public function setTotalItems(int $totalItems)
    {
        $this->totalItems = $totalItems;
    }

    public function setPageIdentifier(string $identifier)
    {
        $this->pageIdentifier = $identifier;
    }

    public function setItemsPerPage(int $itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
    }

    public function getTotal()
    {
        return $this->totalItems;
    }

    public function getPerPage()
    {
        return $this->itemsPerPage;
    }


    private function calculations()
    {
        $this->currentPage = $_GET['page'] ?? 1;
        $offset = ($this->currentPage - 1) * $this->itemsPerPage;
        $this->totalPages = ceil($this->totalItems / $this->itemsPerPage);
        return "LIMIT {$this->itemsPerPage} offset {$offset}";
    }


    public function dump()
    {

        return $this->calculations();
    }


    public function links()
    {
        $links = "<ul class='pagination'>";
        if ($this->currentPage > 1) {
            $previous  = $this->currentPage - 1;
            $linkPage = http_build_query(array_merge($_GET, [$this->pageIdentifier => $previous]));
            $first = http_build_query(array_merge($_GET, [$this->pageIdentifier => 1]));
            // $links .= "<li class='page-item'><a href='?{$first}' class='page-link'>Primeira</a></li>";
            $links .= "<li class='page-item'><a href='?{$linkPage}' class='page-link'><</a></li>";
        }


        for ($i = $this->currentPage - $this->linksPerPage; $i <= $this->currentPage + $this->linksPerPage; $i++) {
            if ($i > 0 and $i <= $this->totalPages) {
                $class = $this->currentPage == $i ? 'active' : '';
                $linkPage = http_build_query(array_merge($_GET, [$this->pageIdentifier => $i]));
                $links .= "<li class='page-item {$class}'><a href='?{$linkPage}' class='page-link'>{$i}</a></li>";
            }
        }


        if ($this->currentPage < $this->totalPages) {
            $next  = $this->currentPage + 1;
            $linkPage = http_build_query(array_merge($_GET, [$this->pageIdentifier => $next]));
            $last = http_build_query(array_merge($_GET, [$this->pageIdentifier => $this->totalPages]));
            $links .= "<li class='page-item'><a href='?{$linkPage}' class='page-link'>></a></li>";
            // $links .= "<li class='page-item'><a href='?{$last}' class='page-link'>Última</a></li>";
        }
        $links .= "</ul>";

        return $links;
    }
}
