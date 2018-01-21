<?php

namespace App\Models\Traits;

use App\Services\SlugGenerator;

trait HasSlug
{

    public function slug(): string
    {
        return $this->attributes[$this->slugKey()];
    }

    public function generateSlug($text)
    {

        return app(SlugGenerator::class)
            ->setSlugIsUniqueFunc($this->getTable(), $this->slugKey(), $this->exists ? $this->getKey() : null, $this->getKeyName())
            ->generate($text, $this->slugMode(), $this->delimiter());
    }

    public function delimiter(): string
    {
        return '-';
    }

    public function scopeBySlug($query, $slug)
    {
        $query->where($this->slugKey(), $slug);
    }

    public function slugKey(): string
    {
        return 'slug';
    }

    public function slugMode(): string
    {
        return '';
    }

}
