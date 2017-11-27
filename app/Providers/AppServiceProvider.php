<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        if(\Request::is('admin*')){

            $menu = new \App\Lib\AdminMenu();
            view()->share(['adminMenu'=>$menu]);
        }

        //
        if(env('mail_redirection'))
         \Mail::alwaysTo(env('mail_redirection'));
         \Mail::alwaysReplyTo('mohit@singsys.com');

        
        // \Form::component('laMedia', 'la.la_image', ['name', 'value' => null,'setting','attributes' => []]);

        // \Form::component('laFile', 'la.la_file', ['name', 'value' => null,'setting', 'attributes' => [] ));

        Blade::directive('datetime', function ($expression) {           

           return "<font class='<?php echo \Request::has('timezone')?'':'laravel_date' ?>' data-format='datetime' data-datetime='<?php echo \Carbon\Carbon::parse($expression)->toW3cString(); ?>'><?php echo \Carbon\Carbon::parse($expression)->setTimezone(\Request::get('timezone',env('APP_TIMEZONE')))->format(Cache::get('settings.datetime_format'));  ?></font>";
        });

        Blade::directive('time', function ($expression) {

           return "<font class='<?php echo \Request::has('timezone')?'':'laravel_date' ?>' data-format='time' data-datetime='<?php echo \Carbon\Carbon::parse($expression)->toW3cString(); ?>'><?php echo \Carbon\Carbon::parse($expression)->setTimezone(\Request::get('timezone',env('APP_TIMEZONE')))->format(Cache::get('settings.time_format'));  ?></font>";
        });

        Blade::directive('date', function ($expression) {
           
           return "<font class='<?php echo \Request::has('timezone')?'':'laravel_date' ?>' data-format='date' data-datetime='<?php echo \Carbon\Carbon::parse($expression)->toW3cString(); ?>'><?php echo \Carbon\Carbon::parse($expression)->setTimezone(\Request::get('timezone',env('APP_TIMEZONE')))->format(Cache::get('settings.date_format'));  ?></font>";
        });

       
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }


}
