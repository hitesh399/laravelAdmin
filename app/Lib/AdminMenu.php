<?php

namespace App\Lib;

class AdminMenu {

	public $menuArr =[];

	public $adminPrefix = 'admin';

	function __construct(){

		$this->menuArr = trans('admin_menu');
	}

	public function print()
	{
		ob_start();
		echo '<ul class="list">';
		echo '<li class="header active">MAIN NAVIGATION</li>';
		$this->recursiveWalkInMenu($this->menuArr);
		echo '</ul>';
		return ob_get_clean();
	}

	private function recursiveWalkInMenu($menu)
	{

		foreach($menu as $m){

			if(!$this->canAccess($m))
				continue;

			$has_child = $this->hasChild($m);

			$url = $has_child?'javascript:void(0);':url($this->adminPrefix.'/'.$this->getMenuAttribute($m,'link'));
			$title = $this->getMenuAttribute($m,'title','Untitle');
			$icon = $this->getMenuAttribute($m,'icon','');

			$link_class ='';

			!$has_child?:$link_class .=' menu-toggle';

			$li_class = '';

			!$this->isActive($m)?:$li_class .= ' active';

			echo '<li class="'.$li_class.'"><a href="'.$url.'" class="'.$link_class.'">'.$icon.'<span>'.$title.'</span></a>';

			if($has_child){

				echo '<ul class="ml-menu">';
					
					$child_menu = $m['child'];
					$this->recursiveWalkInMenu($child_menu);			

				echo '</ul></li>';
			}else{

				echo '</li>';
			}
		}
	}


	private function getMenuAttribute($menu,$key,$default='')
	{
		return isset($menu[$key])?$menu[$key]:$default;
	}

	private function hasChild($menu)
	{
		$child = $this->getMenuAttribute($menu,'child',[]);

		return count($child) >0 && is_array($child);
	}


	private function isActive($m)
	{
		$active_when = (array)$this->getMenuAttribute($m,'tab_active_if_current_page_is',[]);
		$active = false;
		$prefix = $this->adminPrefix;

		array_walk($active_when, function($slug) use(&$active,$prefix){

			if(\Request::is($prefix.'/'.$slug)){

				$active = true;
			}
		});

		return $active;
	}

	private function canAccess($menu)
	{
		$user = \Auth::user();

		if(!$user)
			return false;

		$menu_permissions = $this->getMenuAttribute($menu,'visibile_if_permission_of',[]);	

		if(empty($menu_permissions))
			return true;		

		$role_permissions = \Cache::get('role_access.'.$user->role_id);

		if(empty($role_permissions))
			return false;
			
		$is = false;

		array_walk($menu_permissions, function($perm) use(&$is,$role_permissions){

			if(in_array($perm, $role_permissions))
				$is = true;
		});		

		return $is;
	}
}