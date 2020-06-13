<?php


namespace Sowren\Scroll\Fields;


use Carbon\Carbon;

class Date extends FieldContract
{
    /**
     * Process the field and make any modifications.
     *
     * @param  string  $fieldType
     * @param  string  $fieldValue
     * @param  mixed|array  $data
     *
     * @return array
     */
    public static function process($fieldType, $fieldValue, $data)
    {
        return [
            $fieldType => Carbon::parse($fieldValue),
        ];
    }

}
