<?php

  // Simple Paginator class
  //
  // (c) 2006 Denis St-Michel - blog.dstmichel.ca

  // Create a unordered list of links for browsing through a set of results


  class Pagination {

    var $pagination;          // the html content of the generated pagination list
    var $pages;               // the total amount of pages
    var $captions = array();  // associatives array containing captions

    
        // constructor
    function Pagination() {
          $this->reset();
    }

    
        // reset and clear
    function reset() {
      $this->pagination = '';
      $this->pages      = 0;
            // defining default value for captions
      $this->captions = array('first'=>'&lt;&lt;', 'previous'=>'&lt;', 'next'=>'&gt;', 'last'=>'&gt;&gt;');
       
    }
    

    // setting captions
    function setCaption_first($caption) {
      $this->captions['first'] = $caption;
    }
    function setCaption_previous($caption) {
      $this->captions['previous'] = $caption;
    }
    function setCaption_next($caption) {
      $this->captions['next'] = $caption;
    }
    function setCaption_last($caption) {
      $this->captions['last'] = $caption;
    }


    // calculating the total number of pages
    function setNumberOfPages($total_items,$items_per_page) {
      $this->pages = intval($total_items/$items_per_page)+1;
    }


    // generating the paginator unordered list of links
    function draw($current_page,$url) {
     
      // no need to draw a paginator if there is only one page of result
      if ($this->pages != 1) {

        // initializing variables;
        $previous_page = $current_page-1;
        $next_page     = $current_page+1;

        if ($previous_page < 1) { $previous_page=1; }
        if ($next_page > $this->pages) { $next_page=$this->pages; }

        // we begin the unordered list of items
        $this->pagination = '';

        // we start by adding the link for the very first page and the previous page
        if ($current_page != 1) {
          $this->pagination .= '<a href="'.$url.'&page=1">'.$this->captions['first'].'</a> ';
          $this->pagination .= '<a href="'.$url.'&page='.$previous_page.'">'.$this->captions['previous'].'</a> ';
        }
		if($current_page == 1) {
			echo "<< << ";
		}
      
        // then we generate a link for every single page
        for ($i=1; $i<=$this->pages; $i++) {
          if ($current_page == $i) {
            $this->pagination .= ''.$i.'';
          }
          else {
            $this->pagination .= ' <a href="'.$url.'&page='.$i.'">'.$i.'</a> ';    
          }
        }

        // we now add the link for the next page and the last page
        if ($current_page != $this->pages) {
          $this->pagination .= '  <a href="'.$url.'&page='.$next_page.'">'.$this->captions['next'].'</a> ';
          $this->pagination .= '  <a href="'.$url.'&page='.$this->pages.'">'.$this->captions['last'].'</a> ';
        }

        // finally we close the unordered list of links
        $this->pagination .= '';

      }

    }


  // end of class
  }

?> 