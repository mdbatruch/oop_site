<?php

    class Pagination {

        public $current_page;
        public $per_page;
        public $total_count;

        public function __construct($page=1, $per_page=20, $total_count=0) {
            $this->current_page = (int) $page;
            $this->per_page = (int) $per_page;
            $this->total_count = (int) $total_count;
        }

        public function offset() {
            return $this->per_page * ($this->current_page - 1);
        }

        public function amount_index() {

          $from = $this->current_page <= 1 ? 1 : ($this->current_page -1) * $this->per_page+1; //RANGE STARTS FROM 
          $to = $this->current_page * $this->per_page;

          if ($to > $this->total_count) {
            $to = $this->total_count;
          }

          return "(" . $from . " - " . $to . ")";
        }

        public function show_range() {
          return 'Showing <b>' . $this->amount_index() . '</b> of <b>' . $this->total_count . '</b> Results';
        }

        public function total_pages() {
            return ceil($this->total_count / $this->per_page);
        }

        public function next_page() {
            $next = $this->current_page + 1;
            return ($next <= $this->total_pages()) ? $next : false;
        }

        public function previous_page() {
            $prev = $this->current_page - 1;
            return ($prev > 0) ? $prev : false;
        }

        public function previous_link($url="") {
            $link = "";
            $chevron = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-chevron-left p-1" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
            </svg>';
            if ($this->previous_page() != false) {
            $link = "<a href=\"{$url}?page={$this->previous_page()}\">{$chevron}</a>";
            } else {
              $link = "<span class=\"disabled\">{$chevron}</span>";
            }
            return $link;
        }

        public function next_link($url="") {
            $link = "";
            $chevron = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-chevron-right p-1" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
            </svg>';
            if ($this->next_page() != false) {
            $link = "<a href=\"{$url}?page={$this->next_page()}\">{$chevron}</a>";
            } else {
              $link = "<span class=\"disabled\">{$chevron}</span>";
            }
            return $link;
        }

        public function previous_extra_link($url="") {
            $link = "";
            if ($this->previous_page() != false) {
            $link = "<a href=\"{$url}&page={$this->previous_page()}\">&laquo; Previous</a>";
            }
            return $link;
        }

        public function next_extra_link($url="") {
            $link = "";
            if ($this->next_page() != false) {
            $link = "<a href=\"{$url}&page={$this->next_page()}\">Next &raquo;</a>";
            }
            return $link;
        }

        public function number_links($url="") {

            $output = "";

            for ($i=1; $i <= $this->total_pages(); $i++) {
                if($i == $this->current_page) {
                  $output .= "<span class=\"selected\">{$i}</span>";
                } else {
                  $output .= "<a href=\"{$url}?page={$i}\">{$i}</a>";
                }
              }
            return $output;
        }

        public function number_extra_links($url="") {

            $output = "";

            for ($i=1; $i <= $this->total_pages(); $i++) {
                if($i == $this->current_page) {
                  $output .= "<span class=\"selected\">{$i}</span>";
                } else {
                  $output .= "<a href=\"{$url}&page={$i}\">{$i}</a>";
                }
              }
            return $output;
        }

        public function page_links($url, $category = false) {

            $output = "";

            if (isset($_GET['category'])) {
                // echo $this->total_count;
                echo '<div class="pagination d-block text-center">';
                    if (isset($this->previous_link)) {
                        echo "<a href=\"{$url}?page={$this->previous_page()}&category={$_GET['category']}\">&laquo;</a>";
                    }
                    for ($i=1; $i <= $this->total_pages(); $i++) {
                        if($i == $this->current_page) {
                          $output .= "<span class=\"selected\">{$i}</span>";
                        } else {
                          $output .= "<a href=\"{$url}?page={$i}&category={$_GET['category']}\">{$i}</a>";
                        }
                      }
                      if (isset($this->next_link)) {
                        echo "<a href=\"{$url}?page={$this->next_page()}&category={$_GET['category']}\">&raquo;</a>";
                      }
                echo "</div>";

            } else if ($this->total_pages() > 1) {
                $output .= "<div class=\"pagination d-flex justify-content-center text-center my-4\">";
                $output .= $this->previous_link($url);
                $output .= '<div class="pagination-index mx-2">Page ' . $this->current_page . ' of ' . $this->total_pages() . '</div>';
                $output .= $this->next_link($url);
                $output .= "</div>";
            }

            return $output;
        }

        public function page_extra_links($url, $category = false) {

            $output = "";

            if (isset($_GET['category'])) {
                // echo $this->total_count;
                echo '<div class="pagination d-block text-center">';
                    if (isset($this->previous_link)) {
                        echo "<a href=\"{$url}&page={$this->previous_page()}&category={$_GET['category']}\">&laquo;</a>";
                    }
                    for ($i=1; $i <= $this->total_pages(); $i++) {
                        if($i == $this->current_page) {
                          $output .= "<span class=\"selected\">{$i}</span>";
                        } else {
                          $output .= "<a href=\"{$url}&page={$i}&category={$_GET['category']}\">{$i}</a>";
                        }
                      }
                      if (isset($this->next_link)) {
                        echo "<a href=\"{$url}&page={$this->next_page()}&category={$_GET['category']}\">&raquo;</a>";
                      }
                echo "</div>";

            } else if ($this->total_pages() > 1) {
                $output .= "<div class=\"pagination d-block text-center\">";
                $output .= $this->previous_extra_link($url);
                $output .= $this->number_extra_links($url);
                $output .= $this->next_extra_link($url);
                $output .= "</div>";
            }

            return $output;
        }

    }

?>