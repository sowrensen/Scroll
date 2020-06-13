<?php


namespace Sowren\Scroll\Fields;


class Extra extends FieldContract
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
        $extra = isset($data['extra']) ? (array) json_decode($data['extra']) : [];
        return [
            'extra' => json_encode(array_merge($extra, [
                $fieldType => $fieldValue
            ]))
        ];
    }

}
