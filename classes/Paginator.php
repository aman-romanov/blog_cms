<?php 
    /**
     * Class with inputs to select specific range of data
     */
    class Paginator{
        public $limit;
        public $offset;
        public $prev;
        public $next;

        public function __construct($page, $records_per_page, $number_of_records){
            $this->limit = $records_per_page;
            $page = filter_var($page, FILTER_VALIDATE_INT, [
                'options' => [
                    'default' => 1,
                    'min_range' => 1
                ]
                ]);
            if($page>1){
                $this->prev = $page - 1;
            }
            $total_pages = ceil($number_of_records/$records_per_page);
            
            if($page<$total_pages){
                $this->next = $page + 1;
            }
            
            $this->offset = $records_per_page * ($page - 1);
        }
    }

?>