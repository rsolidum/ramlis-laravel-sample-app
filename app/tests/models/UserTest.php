<?php

class UserTest extends TestCase {

	/**
	 * Test Post saves correctly
	 */
	public function testPostSavesCorrectly()
	{
	  // Create a new Post
	  $post = FactoryMuff::create('Post');
	 
	  // Save the Post
	  $this->assertTrue($post->save());
	}

	/**
	 * Username is required
	 */
	public function testUsernameIsRequired()
	{
	  // Create a new User
	  $user = new User;
	  $user->email = "test@user.com";
	  $user->password = "password";
	  $user->password_confirmation = "password";
	 
	  // User should not save
	  $this->assertFalse($user->save());
	 
	  // Save the errors
	  $errors = $user->errors()->all();
	 
	  // There should be 1 error
	  $this->assertCount(1, $errors);
	 
	  // The username error should be set
	  $this->assertEquals($errors[0], "The username field is required.");
	}


}