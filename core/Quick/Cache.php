<?php namespace Quick; 

use Quick\Cache\Config;

class Cache
{
	protected $driver;

	public function __construct()
	{
		$config = new Config;

		$driver_class = 'Quick\Cache\Driver\\' . ucfirst($config->get('driver'));

		$this->driver = new $driver_class;
	}

	/**
	 * Cache a key/value item
	 * 
	 * @param 	string 			$key
	 * @param 	string|array 	$value The value to cache
	 * @return	bool
	 */
	public function set($key, $value)
	{
		return $this->driver->set($key, $value);
	}

	/**
	 * Get a value by key
	 * 
	 * @param 	string 	$key
	 * @return
	 */
	public function get($key)
	{
		return $this->driver->get($key);
	}

	/**
	 * Drop an item by key
	 * 
	 * @param 	string 	$key
	 * @return	bool
	 */
	public function forget($key)
	{
		return $this->driver->forget($key);
	}

	/**
	 * Call a method, cache the result, and return the data
	 * 
	 * @param string|object $class 	Either a namespace class or an object
	 * @param string 		$method	The method to call
	 * @param array  		$args	The arguments to pass to the method
	 * @return
	 */
	public function method($class, $method, $args = array(), $ttl = null)
	{
		if (is_string($class))
		{
			$class = new $class;
		}

		$data = call_user_func_array(array($class, $method), $args);

		$identifier = array($class, $method, $args);

		return $this->driver->method($data, $identifier, $ttl);
	}

	/**
	 * Clear all cached items for a class + method or class
	 * 
	 * @param 	string|object 	$class 	The namespace class or object used to identify the cached item
	 * @param 	string 			$method	The method used to identify the cached item
	 * @return 	bool
	 */
	public function clear($class, $method = null)
	{
		return $this->driver->clear($class, $method);
	}

	/**
	 * Clear all cached items for this driver
	 * 
	 * @return  bool
	 */
	public function flush()
	{
		return $this->driver->flush();
	}
}