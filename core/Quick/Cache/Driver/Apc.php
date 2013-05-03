<?php namespace Quick\Cache\Driver;
/*
 * This file belongs to the Quick Cache package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * copyright 2012 -- Jerel Unruh -- http://unruhdesigns.com
 */

class Apc
{
	/**
	 * Set a simple key:value
	 * 
	 * @param string  $key   The key to retrieve the value with later
	 * @param string  $value A serialized string to store
	 * @param integer $ttl   Seconds to live before expiration
	 */
    public function set($key, $value, $ttl=0) 
    {
    	return (bool) \apc_store($key, $value, $ttl);
    }

    /**
     * Get your cached value
     * 
     * @param  string $key
     * @return string
     */
    public function get($key)
    {
    	return \apc_fetch($key);
    }

    /**
     * Delete a value by its key
     * 
     * @param  string $key
     * @return bool
     */
    public function forget($key)
    {
    	return \apc_delete($key);
    }

    /**
     * Cache data for a class/method
     * 
     * @param array   $identifier class|method|args
     * @param mixed   $data       Data to store
     * @param integer $ttl        Seconds to live before exiration
     */
    public function set_method($identifier, $data, $ttl=0)
    {
    	$key = $this->_key($identifier);
    	$this->set($key, $data, $ttl);
    	return $data;
    }

    /**
     * Get cached data for a class/method
     * @param  array $identifier  class|method|args
     * @return array
     */
    public function get_method($identifier)
    {
    	$key = $this->_key($identifier);
    	$item = $this->get($key);

    	return ($item == false) ?
    		array('status' => false, 'data' => null) :
    		array('status' => true, 'data' => $item);
    }

    /**
     * Clear all the cached items for this driver
     * 
     * @return bool
     */
    public function flush()
    {
    	return (bool) \apc_clear_cache('user');
    }

    /**
     * Creates a key for cached class methods
     * @param  array $identifier  class|method|args
     * @return string
     */
    private function _key($identifier) {
    	extract($identifier);
    	$arg_string = "";
    	return md5(serialize($class . $method . implode('~', $args)));
    }
}