<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTraitTest extends TestCase
{
    /**
     * A basic test example.
     * @group login-trait
     * @return void
     */
    public function testExample()
    {   
        $class = '\App\Http\Controllers\AuthenticatesUsers';    

        $klass = new \ReflectionClass($class);
        $method = $klass->getMethod('getLoginLable');
        $method->setAccessible(true);
        $method->invoke($obj, $name);

        //$this->assertTrue($method->invoke($obj, $name));

        // $mock = $this->getMockForTrait(\App\Http\Controllers\AuthenticatesUsers::class);
      
        // $mock->expects($this->any())
        // ->method('testMethodMethod');

    }
}
