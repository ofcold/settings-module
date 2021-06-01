<?php

namespace Ofcold\Module\Setting;

class GenericSetting
{
    /**
     * Create a new generic Setting object.
     *
     * @param  array  $attributes
     *
     * @return void
     */
    public function __construct(protected array $attributes)
    {
    }

    /**
     * Get the name of the unique identifier for the setting.
     *
     * @return string
     */
    public function getIdentifierName(): string
    {
        return 'key';
    }

    /**
     * Get the unique identifier for the setting.
     *
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->attributes[$this->getIdentifierName()];
    }

    /**
     * Get the value for the setting item.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->attributes['value'] ?: $this->getDefaultValue();
    }

    /**
     * Get the default value for the setting item.
     *
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->attributes['defulat'];
    }

     /**
     * Get the component name for the setting item.
     *
     * @return mixed
     */
    public function getComponentName(): string
    {
        return $this->attributes['component'];
    }

     /**
     * Get the namespace for the setting item.
     *
     * @return mixed
     */
    public function getNamespace(): string
    {
        return $this->attributes['namespace'];
    }

    /**
     * Dynamically access the user's attributes.
     *
     * @param  string  $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->attributes[$key];
    }

    /**
     * Dynamically set an attribute on the user.
     *
     * @param  string  $key
     * @param  mixed  $value
     *
     * @return void
     */
    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    /**
     * Dynamically check if a value is set on the user.
     *
     * @param  string  $key
     *
     * @return bool
     */
    public function __isset($key)
    {
        return isset($this->attributes[$key]);
    }

    /**
     * Dynamically unset a value on the user.
     *
     * @param  string  $key
     *
     * @return void
     */
    public function __unset($key)
    {
        unset($this->attributes[$key]);
    }
}
