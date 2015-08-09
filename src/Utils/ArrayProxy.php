<?php namespace Ionut\Crud\Utils;


use ArrayAccess;

abstract class ArrayProxy implements ArrayAccess, \IteratorAggregate
{

	public function getIterator()
	{
		return $this->getProxifiedArray();
	}

	/**
	 * @throws \Exception
	 * @return ArrayAccess
	 */
	abstract protected function getProxifiedArray();

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Whether a offset exists
	 *
	 * @link http://php.net/manual/en/arrayaccess.offsetexists.php
	 * @param mixed $offset <p>
	 *                      An offset to check for.
	 *                      </p>
	 * @return boolean true on success or false on failure.
	 *                      </p>
	 *                      <p>
	 *                      The return value will be casted to boolean if non-boolean was returned.
	 */
	public function offsetExists($offset)
	{
		return $this->getProxifiedArray()->offsetExists($offset);
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Offset to retrieve
	 *
	 * @link http://php.net/manual/en/arrayaccess.offsetget.php
	 * @param mixed $offset <p>
	 *                      The offset to retrieve.
	 *                      </p>
	 * @return mixed Can return all value types.
	 */
	public function offsetGet($offset)
	{
		return $this->getProxifiedArray()->offsetGet($offset);
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Offset to set
	 *
	 * @link http://php.net/manual/en/arrayaccess.offsetset.php
	 * @param mixed $offset <p>
	 *                      The offset to assign the value to.
	 *                      </p>
	 * @param mixed $value  <p>
	 *                      The value to set.
	 *                      </p>
	 * @return void
	 */
	public function offsetSet($offset, $value)
	{
		if ($value === false) {
			return $this->offsetUnset($offset);
		}

		$this->getProxifiedArray()->offsetSet($offset, $value);
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Offset to unset
	 *
	 * @link http://php.net/manual/en/arrayaccess.offsetunset.php
	 * @param mixed $offset <p>
	 *                      The offset to unset.
	 *                      </p>
	 * @return void
	 */
	public function offsetUnset($offset)
	{
		$this->getProxifiedArray()->offsetUnset($offset);
	}

	public function __call($k, $args = [])
	{
		return call_user_func_array([$this->getProxifiedArray(), $k], $args);
	}
}