<?php


namespace Sowren\Scroll\Repositories;


use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Sowren\Scroll\Post;

class PostRepository
{
    /**
     * Takes a post array and updates or creates it on the database.
     *
     * @param  array  $post
     *
     * @return void
     */
    public function save($post)
    {
        Post::updateOrCreate([
            'identifier' => $post['identifier'],
        ], [
            'slug' => Str::slug($post['title']),
            'title' => $post['title'],
            'body' => $post['body'],
            'extra' => $this->extra($post)
        ]);
    }

    /**
     * Collect all of the extra fields to set it as a json string.
     *
     * @param  array  $post
     *
     * @return false|string
     */
    private function extra($post)
    {
        $extra = (array) json_decode($post['extra'] ?? '[]');
        $attributes = Arr::except($post, ['title', 'body', 'identifier', 'extra']);

        return json_encode(array_merge($extra, $attributes));
    }
}
