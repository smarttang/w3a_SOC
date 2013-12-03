<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Page_smart{
       public function Page_do($config = array())
       {
		if (count($config) > 0)
		{
			foreach ($config as $key => $val)
			{
				if (isset($this->$key))
				{
					$this->$key = $val;
				}
			}
		}
		$page=$config['page'];
		$page_size=10;
		$pagenav='';
		$rows=$config['rows'];
		$base_url=$config['base_url'];
                $page_count = ceil($rows/$page_size);
                if($page <= 1 || $page == '') $page = 1;
                  if($page >= $page_count) $page = $page_count;
                  $select_limit = $page_size;
                  $select_from = ($page - 1) * $page_size;
                  $pre_page = ($page == 1)? 1 : $page - 1;
                  $next_page= ($page == $page_count)? $page_count : $page + 1 ;
                  $pagenav .="<div class='pagination pagination-right'>";
		  $top_page="'$base_url/1'";
                  $pagenav .="<ul><li><a href="."javascript:goToPage(".$top_page.");>«</a></li>";
                  for($i=1;$i<=$page_count;$i++){
			$on_page="'$base_url/$i'";
                        if($i==$page)
                        {
				 
                                $pagenav.="<li><a href="."javascript:goToPage(".$on_page.");>$i</a></li>";
                        }
                        else
                        {
                                $pagenav.="<li><a href="."javascript:goToPage(".$on_page.");>$i</a></li>";
                        }
                }
		$last=$i-1;
		$last_page="'$base_url/$last'";
                $pagenav .= "<li><a href="."javascript:goToPage(".$last_page.");>»</a></li></ul></div>";
		$page_result['pagenav']=$pagenav;
		$page_result['select_limit']=$select_limit;
		$page_result['select_from']=$select_from;
		return $page_result;
         }
}
/* End of file Someclass.php */
