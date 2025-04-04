<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BlogPublished
{
    use Dispatchable;
    use SerializesModels;

    public mixed $post;

    public function __construct($post)
    {
        $this->post = $post;
    }
}
