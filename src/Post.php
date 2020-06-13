<?php


namespace Sowren\Scroll;


use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * Access any of the extra field.
     *
     * @param  string  $field
     * @return mixed
     */
    public function extra($field)
    {
        return optional(json_decode($this->extra))->$field;
    }
}
