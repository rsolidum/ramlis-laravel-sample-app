<?php
use Zizaco\FactoryMuff\Facade\FactoryMuff;

class MicropostTest extends TestCase {

	/**
	 * Test that Posts' body is required
	 */
	public function testPostBodyIsRequired()
	{
	  // Create new Post
	  $post = new Micropost;
	 
	  // Create a User
	  $user = FactoryMuff::create('User');
	 
	  // Post should not save
	  $this->assertFalse($user->microposts()->save($post));
	 
	  // Save the errors
	  $errors = $post->errors()->all();
	 
	  // There should be 1 error
	  $this->assertCount(1, $errors);
	 
	  // The error should be set
	  $this->assertEquals($errors[0], "The body field is required.");
	}
}