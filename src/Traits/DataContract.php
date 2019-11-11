<?php

namespace inkvizytor\FluentForm\Traits;

use Illuminate\Support\Arr;

/**
 * Class DataContract
 *
 * @package inkvizytor\FluentForm
 */
trait DataContract
{
    /** @var array */
    protected $data = [];

    /**
     * @param string $key
     * @param string|array $value
     * @return $this
     */
    public function data($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
     * @param string|null $default
     * @return array|string
     */
    public function getData($key, $default = null)
    {
        if ($key !== null)
        {
            return Arr::get($this->data, $key, $default);
        }
        else
        {
            return $this->data;
        }
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param array $options
     */
    protected function appendData(&$options)
    {
        foreach ($this->data as $key => $value)
        {
            $options["data-$key"] = is_array($value) ? json_encode($value) : $value;
        }
    }
} 