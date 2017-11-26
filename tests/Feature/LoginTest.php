<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\AuthenticatesUsers;
use Symfony\Component\Console\Output\ConsoleOutput;

 
class LoginTest extends TestCase
{
	  use DatabaseTransactions,WithoutMiddleware,AuthenticatesUsers;
	  private $output;

  	function __construct()
  	{
  		$this->output = new ConsoleOutput();
  	}

    /**
     * A basic login test. if email is not verified.
     *
     * @return void
     */
    public function test_login_when_email_not_verified()
    {

       $this->output->writeln('<info>A basic login test. if email is not verified.</info>');
       $user = factory(\App\User::class)->create();

       $response = $this->post('/admin',[
       		$this->username()=>$user->email,
       		'password'=>"12345678"
       	])
       ->assertStatus(302)
       ->assertSessionHas('errors')
       ->assertSessionHasErrors($this->username());

    }

    /**
    * Login test. if Email is verified but password is wrong
    * @return void
    **/

    public function test_login_by_email_with_wrong_password()
    {	
    	$this->output->writeln('<info>Login test. if Email is verified but password is wrong.</info>');
    	$user = factory(\App\User::class)->create([
    		'is_email_verified'=>'Y'
    	]);

    	$response = $this->post('/admin',[
       		$this->username()=>$user->email,
       		'password'=>"123456"
       	])
       ->assertStatus(302)
       ->assertSessionHas('errors')
       ->assertSessionHasErrors([$this->username()]);
    }

    /**
    * Login test with valid email and password 
    * @return void
    **/

    public function test_login_with_valid_email_password()
    {
    	$this->output->writeln('<info>Login test with valid email and password.</info>');
    	$user = factory(\App\User::class)->create([
    		'is_email_verified'=>'Y',
    	]);

    	$response = $this->post('/admin',[
       		$this->username()=>$user->email,
       		'password'=>"12345678"
       	])
       ->assertStatus(302)
       ->assertSessionMissing('errors')
       ->assertRedirect($this->redirectPath());
    }

    /**
    * Login test with invalid email and password 
    * @return void
    **/

    public function test_login_with_invalid_email_password()
    {
    	$this->output->writeln('<info>Login test with invalid email and password.</info>');
    	$user = factory(\App\User::class)->raw();

    	$response = $this->post('/admin',[
       		$this->username()=>$user['email'],
       		'password'=>"12345678"
       	])
       ->assertStatus(302)
       ->assertSessionHas('errors')
       ->assertSessionHasErrors([$this->username()]);
    }

    /**
    * Login test with invalid mobile and password 
    * @return void
    **/

    public function test_login_with_invalid_mobile_password()
    {
    	$this->output->writeln('<info>Login test with invalid mobile and password.</info>');
    	$user = factory(\App\User::class)->raw();

    	$response = $this->post('/admin',[
       		$this->username()=>$user['mobile_no'],
       		'password'=>"12345678"
       	])
       ->assertStatus(302)
       ->assertSessionHas('errors')
       ->assertSessionHasErrors([$this->username()]);
    }

    /**
    * Login test When mobile number is corrent but not verified and the password is valid.
    * @return void
    **/

    public function test_login_with_unverified_correct_mobile_and_correct_password()
    {
       $this->output->writeln('<info>Login test When mobile number is corrent but not verified and the password is valid.</info>');
       $user = factory(\App\User::class)->create();

       $response = $this->post('/admin',[
       		$this->username()=>$user->mobile_no,
       		'password'=>"12345678"
       	])
       ->assertStatus(302)
       ->assertSessionHas('errors')
       ->assertSessionHasErrors($this->username());
    }

    /**
    * Login test When mobile number is corrent and verified and password is also correct.
    * @return void
    **/

    public function test_login_with_correct_verified_mobile_and_password()
    {

       $this->output->writeln('<info>Login test When mobile number is corrent and verified and password is also correct.</info>');
       $user = factory(\App\User::class)->create([
       		'is_mobile_no_verified'=>'Y'
       	]);

       $response = $this->post('/admin',[
       		$this->username()=>$user->mobile_no,
       		'password'=>"12345678"
       	])
       ->assertStatus(302)
       ->assertSessionMissing('errors')
       ->assertRedirect($this->redirectPath());
    }

     /**
    * Login test When mobile number is corrent and verified but password is wrong.
    * @return void
    **/

    public function test_login_with_correct_verified_mobile_and_wrong_password()
    {

       $this->output->writeln('<info>Login test When mobile number is corrent and verified but password is wrong.</info>');
       $user = factory(\App\User::class)->create([
       		'is_mobile_no_verified'=>'Y'
       	]);

       $response = $this->post('/admin',[
       		$this->username()=>$user->mobile_no,
       		'password'=>"123456789"
       	])
       ->assertStatus(302)
       ->assertSessionHas('errors')
       ->assertSessionHasErrors($this->username());
    }


    /**
    * When user attamps the login api more than 10 time with worng credentails.
    * @return void
    */

    public function test_loign_when_more_than_10_attamp_with_wrong_credentials()
    {
    	$this->output->writeln('<info>When user attamps the login api more than 10 time with worng credentails.</info>');

    	$user = factory(\App\User::class)->raw();
    	for($i=0; $i<= 9; $i++){

    		$response = $this->post('/admin',[
	       		$this->username()=>$user['mobile_no'],
	       		'password'=>"123456789"
	       	]);
    	}

    	$response = $this->post('/admin',[
       		$this->username()=>$user['mobile_no'],
       		'password'=>"123456789"
       	])
       	->assertSessionHas('errors')
       	->assertSessionHasErrors($this->username());
       	$error_message = $response->getSession()->all()['errors']->first($this->username());
       	$this->assertEquals($error_message,'Too many login attempts. Please try again in 60 seconds.');
    }

    /**
    * Login Test, When user attamps the login more than 10 time with unverified email. 
    * @return void
    */

    public function test_login_attamp_more_than10_with_unverfied_email()
    { 
      $this->output->writeln('<info>Login Test, When user attamps the login more than 10 time with unverified email.</info>');
      $user = factory(\App\User::class)->create();

      for($i=0; $i<= 9; $i++){

        $response = $this->post('/admin',[
            $this->username()=>$user->email,
            'password'=>"12345678"
          ]);
      }

      $response = $this->post('/admin',[
          $this->username()=>$user->email,
          'password'=>"12345678"
        ])
        ->assertSessionHas('errors')
        ->assertSessionHasErrors($this->username());
        $error_message = $response->getSession()->all()['errors']->first($this->username());
        $this->assertEquals($error_message,'Too many login attempts. Please try again in 60 seconds.');

    }
}
