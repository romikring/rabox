<?php
/**
 *
 * @author Roman Habrusionok <romikring@gmail.com>
 */
namespace Box\Storage\Interfaces;

/**
 * Storage interface
 */
interface Storage
{
    /**
     * Data setter
     *
     * @param string $key  Data key
     * @param mixed $value Date
     */
    public function set($key, $value);
    /**
     * Data getter
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key);
    /**
     * Checks data exists or not
     *
     * @param string $key Key
     *
     * @return boolean
     */
    public function has($key);
    /**
     * Delete some data by key
     *
     * @param string $key Key
     */
    public function delete($key);
    /**
     * Destroy all data for current namespase
     */
    public function destroy();
    /**
     * Resets all data under current namespace
     */
    public function reset();
}
