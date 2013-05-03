<?php
/*
 * This file belongs to the Quick Cache package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * copyright 2012 -- Jerel Unruh -- http://unruhdesigns.com
 */

class Apc_Test extends PHPUnit_Framework_TestCase
{
	protected $apc;

	public function setUp()
	{
		$this->apc = new Quick\Cache\Driver\Apc(new Quick\Cache\Config);
	}
    public function test_set_and_get()
    {
        $this->apc->set('name', 'Jerel Unruh', 3600);

        $this->assertEquals($this->apc->get('name'), 'Jerel Unruh');
    }

    public function test_forget()
    {
        $this->assertEquals($this->apc->forget('name'), 1);
    }

    public function test_set_method()
    {
        $this->assertEquals($this->apc->set_method(
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
        $this->assertEquals($this->apc->get_method(
            array('class' => 'Some\Class\Foo',
                'method' => 'my_method',
                'args' => array('first', 'second', 'third'),
                )
            ), array('status' => true, 'data' => 'This is my data.'));
    }

    public function test_get_method_missing()
    {
        $this->assertEquals($this->apc->get_method(
            array('class' => 'Some\Class\Foo\Missing',
                'method' => 'my_method',
                'args' => array('first', 'second', 'third'),
                )
            ), array('status' => false, 'data' => null));
    }

    public function test_flush()
    {
        $this->assertTrue($this->apc->flush());
    }
}