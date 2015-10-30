<?php namespace Tuva\Options;

/**
 * Class Cache
 * @package Tuva\Options
 */
class Cache
{

    /**
     * Path to cache file
     *
     * @var string
     */
    protected $cacheFile;

    /**
     * Cached Options
     *
     * @var array
     */
    protected $options;


    /**
     * Constructor
     *
     * @param string $cacheFile
     */
    public function __construct($cacheFile)
    {
        $this->cacheFile = $cacheFile;
        $this->checkCacheFile();

        $this->options = $this->getAll();
    }

    /**
     * Sets a value
     *
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function set($key, $value)
    {
        $this->options[$key] = $value;
        $this->store();

        return $value;
    }

    /**
     * Gets a value
     *
     * @param      $key
     * @param null $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return (array_key_exists($key, $this->options) ? $this->options[$key] : $default);
    }

    /**
     * Checks if $key is cached
     *
     * @param $key
     *
     * @return bool
     */
    public function hasKey($key)
    {
        return array_key_exists($key, $this->options);
    }

    /**
     * Gets all cached options
     *
     * @return array
     */
    public function getAll()
    {
        $values = json_decode(file_get_contents($this->cacheFile), true);

        if( ! is_array($values)) return [];
        
        foreach ($values as $key => $value) {
            $values[$key] = unserialize($value);
        }
        return $values;
    }

    /**
     * Stores all options to the cache file
     *
     * @return void
     */
    private function store()
    {
        $options = [];
        foreach ($this->options as $key => $value) {
            $options[$key] = serialize($value);
        }
        file_put_contents($this->cacheFile, json_encode($options));
    }

    /**
     * Removes a value
     *
     * @return void
     */
    public function forget($key)
    {
        if (array_key_exists($key, $this->options)) {
            unset($this->options[$key]);
        }
        $this->store();
    }

    /**
     * Removes all values
     *
     * @return void
     */
    public function flush()
    {
        file_put_contents($this->cacheFile, json_encode([]));
    }

    /**
     * Checks if the cache file exists and creates it if not
     *
     * @return void
     */
    private function checkCacheFile()
    {
        if (!file_exists($this->cacheFile)) {
            $this->flush();
        }
    }
}
