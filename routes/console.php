<?php

use Illuminate\Foundation\Inspiring;
use App\Lib\Permission as PermissionHelper;
/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');


Artisan::command('admin:Registerpermissions',function(){

	$routes = \Route::getRoutes();
	$permission = new PermissionHelper();
	
	$permission_attr = [];
	$permission_added_list = [];

	foreach ($routes as $route) {
		
		if(!isset($route->action['middleware'])){

			continue;
		}

		$middlewares = (array)$route->action['middleware'];

		foreach($middlewares as $middleware){

			if(strpos($middleware, 'canAccess:') !==false){
				
				$prefix  = ltrim($route->getPrefix(),'/');
				
				

				$permission_name = substr($middleware,10, strlen($middleware));
	    		$current_action = $route->getActionName();


	    		
	    		$names = $permission->getName($permission_name,$current_action);

	    		if($names)foreach ($names as $name) {

	    			if(!in_array($name, $permission_added_list)){

						$section = explode('-',$name);
						$section = end($section);

						$permission_attr[] = ['name'=>$name,'title'=>$name,'section'=>$section,'prefix'=>$prefix,'description'=>$name];
						$permission_added_list[] = $name;
					}
	    		}
	    		

			}
		}

	}
	
	if(count($permission_attr)){
		
		$data = \App\Models\Permission::batchInsertUpdate($permission_attr,['prefix']);
		$this->comment('Permissions has been registered successfully. Inserted: '.$data['inserted'].', Updated: '.$data['updated'].', Total: '.$data['total']);
	}else{

		$this->comment("Permission not found.");
	}


});
