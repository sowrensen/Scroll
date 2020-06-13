<?php


namespace Sowren\Scroll;


use Illuminate\Support\Str;

class Scroll
{
    /**
     * @var array
     */
    protected $fields = [];

    /**
     * Check if config file is published.
     *
     * @return bool
     */
    public function configIsNotPublished()
    {
        return is_null(config('scroll'));
    }

    /**
     * Get the instance of the appropriate Scroll driver.
     *
     * @return mixed
     */
    public function driver()
    {
        $driver = Str::title(config('scroll.driver'));
        $class = "Sowren\\Scroll\\Drivers\\".$driver."Driver";

        return new $class;
    }

    /**
     * Get the URI prefix for the blog.
     *
     * @return string|mixed
     */
    public function prefix()
    {
        return config('scroll.prefix', 'scrolls');
    }

    /**
     * Merge an array of fields into the existing fields array.
     *
     * @param  array  $fields
     */
    public function fields(array $fields)
    {
        $this->fields = array_merge($this->fields, $fields);
    }

    /**
     * Get the available fields.
     *
     * @return array
     */
    public function availableFields()
    {
        // Reverse the order so that user defined custom field
        // classes get precedence over package field classes.
        return array_reverse($this->fields);
    }

}
