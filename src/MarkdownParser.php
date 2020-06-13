<?php


namespace Sowren\Scroll;


use Parsedown;

class MarkdownParser
{
    /**
     * Parse a markdown to HTML string.
     *
     * @param  string  $string  The markdown string
     *
     * @return string
     */
    public static function parse($string)
    {
        return Parsedown::instance()->text($string);
    }
}
