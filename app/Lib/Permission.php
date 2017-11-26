<?php

namespace App\Lib;

class Permission
{
  	private $resource_route_permissions = [
      'index'=>'list',
      'create'=>'add',
      'store'=>'add',
      'show'=>'show',
      'edit'=>'edit',
      'update'=>'edit',
      'destroy'=>'delete',
    ];

    /**
     * Function checks if in the given action is a resource route 
     * so the function prepends the permission key according to the method.
     * @param string - $permission - Permision Name
     * @param string - $current_action - Controller Namespace
     * @return Array|bool
     */

    public function getName($permission,$current_action)
    {

        if(strpos($permission, '[resource]') !== false){

            $permission = str_replace('[resource]', '', $permission);
            $action_length = strlen($current_action);
            $action_method_index = strpos($current_action,'@');

            if($action_method_index ===false)
              return false;           

            $method = substr($current_action, ($action_method_index+1),$action_length);

            if(!isset($this->resource_route_permissions[$method]))
              return false;

            return [$this->resource_route_permissions[$method].'-'.$permission];

        }

        return explode(',',$permission);
    }
}