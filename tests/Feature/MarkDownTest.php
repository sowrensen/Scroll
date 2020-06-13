<?php


namespace Sowren\Scroll\Tests;


use Sowren\Scroll\MarkdownParser;

class MarkDownTest extends TestCase
{
    /** @test */
    public function simple_markdown_should_parsed()
    {
        $this->assertEquals("<h1>Heading 1</h1>", MarkdownParser::parse("# Heading 1"));
    }
}
