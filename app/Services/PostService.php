<?php

namespace App\Services;


class PostService
{
    public function makeExcerpt($content, $limit = 300)
    {
        $html = $content;
        $excerpt = trim(preg_replace('/\s\s+/', ' ', strip_tags($html)));
        return str_limit($excerpt, $limit);
    }
}
