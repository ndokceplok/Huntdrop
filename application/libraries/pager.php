<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Pager {
	
	var $base_url = '';
	var $uri_segment = 3;
	var $total_post = '';
	var $num_links	=  2; // Number of "digit" links to show before/after the currently viewed page
	var $index = '';
	var $limit = 10; 
	#var $page = '';

	public function __construct($params = array())
	{
		if (count($params) > 0)
		{
			$this->initialize($params);
		}

	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 * @return	void
	 */
	function initialize($params = array())
	{
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				if (isset($this->$key))
				{
					$this->$key = $val;
				}
			}
		}
	}
	
	function create_links()
	{
		// If our item count or per-page total is zero there is no need to continue.
		if ($this->total_post == 0 )
		{
			return '';
		}

		// Calculate the total number of pages
		$total_page = ceil( $this->total_post/$this->limit );
		
		// Is there only one page? Hm... nothing more to do here then.
		if ($total_page == 1)
		{
			return '';
		}

		$ci =& get_instance();
		
		// Determine the current page number.
		$current_page = $ci->uri->segment($this->uri_segment,1);
		// Prep the current page - no funny business!
		$current_page = (int) $current_page;

		$this->num_links = (int)$this->num_links;

		if ($this->num_links < 1)
		{
			show_error('Your number of links must be a positive number.');
		}


		// Is the page number beyond the result range?
		// If so we show the last page
		if ($current_page > $this->total_post)
		{
			$current_page = ($total_page - 1) * $this->limit;
		}

		// Calculate the start and end numbers. These determine
		// which number to start and end the digit links with
		$start = (($current_page - $this->num_links) > 0) ? $current_page - ($this->num_links ) : 1;
		$end   = (($current_page + $this->num_links) < $total_page) ? $current_page + $this->num_links : $total_page;

		// And here we go...
		$output = '';
		
		/*$output .= '
			<style>
				.pagination {text-align:center;}
				.pager_nav { display:inline-block; padding:5px; border:solid 1px #f05125; margin:0 2px; color:#000; }
				a.pager_nav:hover { border:solid 1px #f05125; background:#f05125; color:#fff; }
				.current_page { background:#f05125; color:#fff }
			</style>
		';*/
		
		//first
		if($current_page != 1) {
			$output .= '<a href="'. $this->base_url .intval(1) .'" class="pager_nav first">first</a>';
		}
		
		//prev button
		if($current_page > 1) {
			$output .= '<a href="'. $this->base_url .intval($current_page-1) .'" class="pager_nav prev">prev</a>';
		} else { $output .= '<span class="pager_nav prev">prev</span>'; }
		
		// Write the digit links
		for ($loop = $start; $loop <= $end; $loop++)
		{
			$i = $loop ;

			if ($i >= 0)
			{
				if ($current_page == $loop)
				{
				$output .= '<span class="pager_nav current_page">'. $i .'</span>'; // Current page
				}
				else
				{
				$output .= '<a href="'. $this->base_url .$i .'" class="pager_nav">'. $i .'</a>';
				}
			}
		}

		
		//next button
		if($current_page < $total_page) {
			$output .= '<a href="'. $this->base_url .intval($current_page+1) .'" class="pager_nav next">next</a>';
		} else { $output .= '<span class="pager_nav next">next</span>'; }
		
		//last
		if($current_page != $total_page) {
			$output .= '<a href="'. $this->base_url .intval($total_page) .'" class="pager_nav last">last</a>';
		}
		
		return $output;
		#return $this->total_post;
	}
	
}

//end of My_pagination class