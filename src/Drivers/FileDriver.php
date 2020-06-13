<?php


namespace Sowren\Scroll\Drivers;


use Illuminate\Support\Facades\File;
use Sowren\Scroll\Exceptions\FileDriverDirectoryNotFoundException;

class FileDriver extends Driver
{
    /**
     * Fetch and parse all of the posts for the given source.
     *
     * @return mixed
     */
    public function fetchPosts()
    {
        $files = File::files($this->config['path']);

        foreach ($files as $file) {
            $this->parse($file->getPathname(), $file->getFilename());
        }

        return $this->posts;
    }

    /**
     * Check if posts file driver path is valid.
     *
     * @return bool|void
     * @throws FileDriverDirectoryNotFoundException
     */
    protected function validateSource()
    {
        if (!File::exists($this->config['path'])) {
            throw new FileDriverDirectoryNotFoundException("Directory at '".$this->config['path'].
                "' doesn't exist. Please check directory in the config file.");
        }
    }
}
