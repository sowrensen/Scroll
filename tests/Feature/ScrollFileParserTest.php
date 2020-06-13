<?php


namespace Sowren\Scroll\Tests;


use Carbon\Carbon;
use Sowren\Scroll\ScrollFileParser;

class ScrollFileParserTest extends TestCase
{
    /** @test */
    public function split_header_and_body()
    {
        $fileParser = new ScrollFileParser(__DIR__ . '/../resources/header_and_body.md');

        $data = $fileParser->getRawData();

        $this->assertStringContainsString('title: An ancient scroll found in a library', $data[1]);
        $this->assertStringContainsString('description: This scroll holds some important information', $data[1]);
        $this->assertStringContainsString('Some important information. Deciphering needed.', $data[2]);
    }

    /** @test */
    public function a_string_can_also_be_passed_to_file_parser_instead_of_a_filename()
    {
        $fileParser = new ScrollFileParser("---\ntitle: An ancient scroll found in a library\n---\nSome important information. Deciphering needed");

        $data = $fileParser->getRawData();

        $this->assertStringContainsString('title: An ancient scroll found in a library', $data[1]);
        $this->assertStringContainsString('Some important information. Deciphering needed', $data[2]);
    }

    /** @test */
    public function split_head_fields()
    {
        $fileParser = new ScrollFileParser(__DIR__ . '/../resources/header_and_body.md');

        $data = $fileParser->getData();

        $this->assertEquals('An ancient scroll found in a library', $data['title']);
        $this->assertEquals('This scroll holds some important information', $data['description']);
    }

    /** @test */
    public function body_gets_trimmed_and_saved()
    {
        $fileParser = new ScrollFileParser(__DIR__ . '/../resources/header_and_body.md');

        $data = $fileParser->getData();

        $this->assertEquals("<h3>Heading</h3>\n<p>Some important information. Deciphering needed.</p>", $data['body']);
    }

    /** @test */
    public function a_date_field_gets_parsed()
    {
        $fileParser = new ScrollFileParser("---\ndate: June 12, 2020\n---\n");

        $data = $fileParser->getData();

        $this->assertInstanceOf(Carbon::class, $data['date']);
        $this->assertEquals('12/06/2020', $data['date']->format('d/m/Y'));
    }

    /** @test */
    public function an_extra_field_gets_saved()
    {
        $fileParser = new ScrollFileParser("---\nauthor: Jon Snow\n---\n");

        $data = $fileParser->getData();

        $this->assertEquals(json_encode(['author' => 'Jon Snow']), $data['extra']);
    }

    /** @test */
    public function two_extra_fields_get_saved()
    {
        $fileParser = new ScrollFileParser("---\nauthor: Jon Snow\nmood: Numb---\n");

        $data = $fileParser->getData();

        $this->assertEquals(json_encode(['author' => 'Jon Snow', 'mood' => 'Numb']), $data['extra']);
    }
}
