<?php

namespace App\Kernel\Services\Subtitle;

use App\Models\Post;
use App\Models\Subtitle;
use Illuminate\Support\Str ;
use App\Kernel\Enums\EnumSubtitle;
use App\Kernel\UploadCenter\SubtitleFile;

class SubtitleService
{

    public function create(Post $post, string $file , array $data = []) : Subtitle
    {

        $subtitle =
            Subtitle::create([
                "post_id" => $post->id,
                "language" => $data["language"] ?? EnumSubtitle::LANG_FA ,
                "film_resulation" => $data["film_resulation"] ?? null
            ]);

        if (!filter_var($file, FILTER_VALIDATE_URL)) return $subtitle;

        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $name = sprintf("%s-%s.%s" , Str::random(5) , $post->name, $ext);

        (new SubtitleFile($post->production_year, $post->name))
            ->setFile(
                file_get_contents($file)
            )
            ->setFileable($subtitle)
            ->setOriginalName($name)
            ->append()
            ->upload();

        return $subtitle->load("files");
    }
}
