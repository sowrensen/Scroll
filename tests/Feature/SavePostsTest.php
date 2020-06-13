<?php


namespace Sowren\Scroll\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Sowren\Scroll\Post;

class SavePostsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_post_is_created_using_the_factory()
    {
        $post = factory(Post::class)->create();

        $this->assertCount(1, Post::all());
    }
}
