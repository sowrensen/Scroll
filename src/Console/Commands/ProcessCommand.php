<?php


namespace Sowren\Scroll\Console\Commands;


use Illuminate\Console\Command;
use Sowren\Scroll\Facades\Scroll;
use Sowren\Scroll\Repositories\PostRepository;

class ProcessCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "scroll:process";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Update scrolls";

    /**
     * Execute the console command.
     *
     * @param  \Sowren\Scroll\Repositories\PostRepository  $postRepository
     *
     * @return mixed
     */
    public function handle(PostRepository $postRepository)
    {
        if (Scroll::configIsNotPublished()) {
            return $this->warn("Please publish the config file by running ".
                "php artisan vendor:publish --tag=scroll-config."
            );
        }

        try {
            $posts = Scroll::driver()->fetchPosts();

            $this->info('Total posts: '.count($posts));

            foreach ($posts as $post) {
                $postRepository->save($post);
                $this->info('Post saved: '.$post['title']);
            }
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}
