<?php

namespace Ocore;

/**
 * @property int $page
 * @property int $limit
 * @property int $offset
 */
class Pagination
{
    private const int LIMIT = 5;
    protected int $count_pages = 1;
    protected int $current_page = 1;
    protected string $uri = '';
    protected int $mid_size = 3;
    protected int $max_pages = 7;

    public function __construct(
        public int $page = 1,
        public int $limit = 5,
        public int $total = 1,
    )
    {
        $this->count_pages = $this->getCountPages();
        $this->current_page = $this->getCurrentPage();
        $this->uri = $this->getParams();
        $this->mid_size = $this->getMidSize();
    }

    protected function getCountPages(): int
    {
        return (int)ceil($this->total / $this->limit) ?: 1;
    }

    protected function getCurrentPage(): int
    {
        if ($this->page < 1 || $this->page > $this->count_pages) {
            abort();
        }

        return $this->page;
    }

    protected function getParams()
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $uri = $url[0];

        $params = [];
        if (isset($url[1]) && !in_array($url[1], ['', '&'])) {
            $uri .= '?';
            parse_str($url[1], $params);

            foreach ($params as $p => $v) {
                if (!str_contains($p, 'page') && !str_contains($p, 'limit')) {
                    $uri .= "$p=$v&";
                }
            }
        }
        return $uri;
    }

    protected function getMidSize(): int
    {
        return ($this->count_pages <= $this->max_pages) ? $this->count_pages : $this->mid_size;
    }

    public function getStart(): int
    {
        return ($this->current_page - 1) * $this->limit;
    }

    protected function getLink($page): string
    {
        if ($page == 1) {
            $link = rtrim($this->uri, '?&');
            if ($this->limit != static::LIMIT) {
                $link .= '&limit=' . $this->limit;
            }
            return $link;
        }

        if (str_contains($this->uri, '&') || str_contains($this->uri, '?')) {
            $link = "{$this->uri}page={$page}";
        } else {
            $link = "{$this->uri}?page={$page}";
        }

        if ($this->limit != static::LIMIT) {
            $link .= '&limit=' . $this->limit;
        }
        return $link;
    }

    public function getHTML()
    {
        $back = '';
        $forward = '';
        $start_page = '';
        $end_page = '';
        $pages_left = '';
        $pages_right = '';
        $current_page = static::getPaginationButton($this->current_page, isActive: true);

        if ($this->current_page > 1) {
            $back = static::getPaginationButton("&lt;", $this->getLink($this->current_page - 1));
        }

        if ($this->current_page < $this->count_pages) {
            $forward = static::getPaginationButton("&gt;", $this->getLink($this->current_page + 1));
        }

        if ($this->current_page > $this->mid_size + 1) {
            $start_page = static::getPaginationButton("&laquo;", $this->getLink(1));
        }

        if ($this->current_page < ($this->count_pages - $this->mid_size)) {
            $end_page = static::getPaginationButton("&raquo;", $this->getLink($this->count_pages));
        }

        for ($i = $this->mid_size; $i > 0; $i--) {
            if ($this->current_page - $i > 0) {
                $pages_left .= static::getPaginationButton($this->current_page - $i, $this->getLink($this->current_page - $i));
            }
        }

        for ($i = 1; $i <= $this->mid_size; $i++) {
            if ($this->current_page + $i <= $this->count_pages) {
                $pages_right .= static::getPaginationButton($this->current_page + $i, $this->getLink($this->current_page + $i));
            }
        }

        $pagination_body = $start_page . $back . $pages_left . $current_page . $pages_right . $forward . $end_page;
        return '<nav aria-label="Page navigation"><ul class="pagination">' . $pagination_body . '</ul></nav>';
    }

    protected static function getPaginationButton($text, $link = '', $isActive = false): string {
        $href = empty($link) ? "" :' href="' . $link . '"';
        $active = $isActive ? ' active' : '';
        return '<li class="page-item' . $active . '"><a' . $href . ' class="page-link">' . $text . '</a></li>';
    }

    public function __toString(): string
    {
        return $this->getHTML();
    }
}