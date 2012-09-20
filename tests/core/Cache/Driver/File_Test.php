<?php 

class File_Test extends PHPUnit_Framework_TestCase
{
	protected $file;

	public function setUp()
	{
		$this->file = new Quick\Cache\Driver\File(new Quick\Cache\Config);
	}

	public function test_set_and_get()
	{
		$this->file->set('name', 'Jerel Unruh');

		$this->assertEquals($this->file->get('name'), 'Jerel Unruh');
	}

	public function test_forget()
	{
		$this->assertEquals($this->file->forget('name'), 1);
	}

	public function test_set_method()
	{
		$this->assertEquals($this->file->set_method(
			array('class' => 'Some\Class\Foo', 
				'method' => 'my_method', 
				'args' => array('first', 'second', 'third'), 
				),
				'This is my data.',
				1500
			), 'This is my data.');
	}

	public function test_get_method()
	{
		$this->assertEquals($this->file->get_method(
			array('class' => 'Some\Class\Foo', 
				'method' => 'my_method', 
				'args' => array('first', 'second', 'third'), 
				)
			), array('status' => true, 'data' => 'This is my data.'));
	}

	public function test_get_method_missing()
	{
		$this->assertEquals($this->file->get_method(
			array('class' => 'Some\Class\Foo\Missing', 
				'method' => 'my_method', 
				'args' => array('first', 'second', 'third'), 
				)
			), array('status' => false, 'data' => null));
	}

	public function test_clear_method()
	{
		$this->assertTrue($this->file->clear('Some\Class\Foo', 'my_method'));

		// make sure it's gone
		$this->assertEquals($this->file->get_method(
			array('class' => 'Some\Class\Foo', 
				'method' => 'my_method', 
				'args' => array('first', 'second', 'third'), 
				)
			), array('status' => false, 'data' => null));
	}

	public function test_clear_class()
	{
		// set some data again
		$this->assertEquals($this->file->set_method(
			array('class' => 'Some\Class\Foo', 
				'method' => 'my_method', 
				'args' => array('first', 'second', 'third'), 
				),
				'This is my data.',
				1500
			), 'This is my data.');

		// clear it
		$this->assertTrue($this->file->clear('Some\Class\Foo', null));

		// make sure it's gone
		$this->assertEquals($this->file->get_method(
			array('class' => 'Some\Class\Foo', 
				'method' => 'my_method', 
				'args' => array('first', 'second', 'third'), 
				)
			), array('status' => false, 'data' => null));
	}

	public function test_flush()
	{
		$this->assertTrue($this->file->flush());
	}
}