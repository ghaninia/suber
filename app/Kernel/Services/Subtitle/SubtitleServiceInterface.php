<?php

namespace App\Kernel\Services\Subtitle;

use App\Models\Post;
use App\Models\Subtitle;

interface SubtitleServiceInterface {
    public function create(Post $post, string $file, array $data = []) : Subtitle ;
}
