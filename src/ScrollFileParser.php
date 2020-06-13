<?php


namespace Sowren\Scroll;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use ReflectionClass;

class ScrollFileParser
{
    /**
     * @var string
     */
    protected $filename;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var array
     */
    protected $rawData;

    /**
     * ScrollFileParser constructor.
     *
     * @param  string  $filename  The parsable file path or markdown
     * @throws \ReflectionException
     */
    public function __construct($filename)
    {
        $this->filename = $filename;

        $this->splitFile();

        $this->explodeData();

        $this->processFields();
    }

    /**
     * Get the parsed data.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get the parsed raw data.
     *
     * @return mixed
     */
    public function getRawData()
    {
        return $this->rawData;
    }

    /**
     * Separate header and body.
     *
     * @return void
     */
    protected function splitFile()
    {
        preg_match('/^\-{3}(.*?)\-{3}(.*)/s',
            File::exists($this->filename) ? File::get($this->filename) : $this->filename,
            $this->rawData);
    }

    /**
     * Separate each line in the head, trims it and saves it, along with the body.
     *
     * @return void
     */
    protected function explodeData()
    {
        foreach (explode("\n", trim($this->rawData[1])) as $fieldString) {
            preg_match('/(.*):\s?(.*)/s', $fieldString, $fieldArray);

            $this->data[$fieldArray[1]] = $fieldArray[2];
        }

        $this->data['body'] = trim($this->rawData[2]);
    }

    /**
     * Iterates through each field and tries to find a class with a matching name. If found
     * it will call a process() method on it. Any other fields, get sent sent to a catch
     * all class called Extra, where they will be merged and JSON encoded in extra.
     *
     * @return void
     * @throws \ReflectionException
     */
    protected function processFields()
    {
        foreach ($this->data as $field => $value) {

            $class = $this->getField(Str::title($field));

            if (!class_exists($class) && !method_exists($class, 'process')) {
                $class = "Sowren\\Scroll\\Fields\\Extra";
            }

            $this->data = array_merge(
                $this->data,
                $class::process($field, $value, $this->data)
            );
        }
    }

    /**
     * Attempt to find a field by the same name out of the array of available fields.
     *
     * @param  string  $field
     *
     * @return string
     * @throws \ReflectionException
     */
    private function getField($field)
    {
        foreach (\Sowren\Scroll\Facades\Scroll::availableFields() as $availableField) {
            $class = new ReflectionClass($availableField);

            if ($class->getShortName() == $field) {
                return $class->getName();
            }
        }
    }
}
