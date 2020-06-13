<?php


namespace Sowren\Scroll\Drivers;


use Illuminate\Support\Str;
use Sowren\Scroll\ScrollFileParser;

abstract class Driver
{
    /**
     * @var array
     */
    protected $posts = [];

    /**
     * @var array
     */
    protected $config;

    public function __construct()
    {
        $this->setConfig();

        $this->validateSource();
    }

    /**
     * Fetch and parse all of the posts for the given source.
     *
     * @return mixed
     */
    public abstract function fetchPosts();

    /**
     * Fetch the appropriate config array for this source.
     *
     * @return void
     */
    protected function setConfig()
    {
        $this->config = config('scroll.'.config('scroll.driver'));
    }

    /**
     * Perform source validation if necessary.
     *
     * @return bool
     */
    protected function validateSource()
    {
        return true;
    }

    /**
     * Instantiate file parser and prepare an array of posts.
     *
     * @param  string  $content
     * @param  string  $identifier
     */
    protected function parse($content, $identifier)
    {
        $this->posts[] = array_merge(
            (new ScrollFileParser($content))->getData(),
            ['identifier' => Str::slug($identifier)]
        );
    }
}
