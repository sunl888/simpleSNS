<?php

namespace App\Models;


use App\Models\Presenter\CategoryPresenter;
use App\Models\Traits\HasSlug;
use App\Observers\ClearNavigationCache;
use App\Support\Presenter\PresentableInterface;

class Category extends BaseModel
{
    use HasSlug;

    const TYPE_POST = 'post', TYPE_PAGE = 'page', TYPE_LINK = 'link', TYPE_CHANNEL = 'channel';
    protected $fillable = ['image', 'cate_name', 'order',
        'description', 'cate_slug', 'creator_id'];

    /**
     * 数据模型的启动方法
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::observe(ClearNavigationCache::class);
    }

    /**
     * 文章列表
     * @param  $query
     * @return mixed
     */
    public function postListWithOrder($order = null)
    {
        $query = $this->posts()->byType(static::TYPE_POST)->byStatus(Post::STATUS_PUBLISH)->orderByTop();
        switch ($order) {
            case 'default':
                $query->ordered()->recent();
                break;
            case 'recent':
                $query->recent()->ordered();
                break;
            case 'popular':
                $query->orderBy('views_count', 'desc')->recent();
                break;
            default:
                $query->ordered()->recent();
                break;
        }
        return $query;
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * 获取该分类的单页
     * @return mixed
     */
    public function getPage()
    {
        return $this->posts()->byType(Category::TYPE_PAGE)->first();
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    /**
     * 该分类是否为顶级分类
     *
     * @return bool
     */
    public function isTopCategory()
    {
        return $this->parent_id == 0;
    }

    /**
     * 导航栏查询作用域
     * @param $query
     * @return mixed
     */
    public function scopeNav($query)
    {
        return $query->where('is_nav', true);
    }

    /**
     * 顶级分类查询作用域
     * @param $query
     * @return mixed
     */
    public function scopeTopCategories($query)
    {
        return $query->where('parent_id', 0);
    }

    /**
     * Category 类型查询作用域
     * @param $query
     * @param null $type
     * @return mixed
     */
    public function scopeByType($query, $type = null)
    {
        if (in_array($type, [static::TYPE_POST, static::TYPE_LINK, static::TYPE_PAGE, static::TYPE_CHANNEL])) {
            $query->where('type', $type);
        }
        return $query;
    }

    /**
     * 获取该分类下的文章数量
     *
     * @return mixed
     */
    public function getPostNum()
    {
        return $this->posts()->post()->count();
    }

    /**
     * 判断是否为同一个分类(该方法已过时)
     * 代替方法 is()
     * @deprecated
     * @param  Category $category
     * @return bool
     */
    public function equals(Category $category)
    {
        return $this->id == $category->id;
    }

    /**
     * 判断当前栏目(分类)是否为外部链接
     *
     * @return bool
     */
    public function isExtLink()
    {
        return $this->type == static::TYPE_LINK;
    }

    /**
     * 判断当前栏目(分类)是否为单网页
     *
     * @return bool
     */
    public function isPage()
    {
        return $this->type == static::TYPE_PAGE;
    }

    /**
     * 判断当前栏目(分类)是否为列表栏目
     *
     * @return bool
     */
    public function isPostList()
    {
        return $this->type == static::TYPE_POST;
    }

    /**
     * 判断当前栏目(分类)是否为频道封面栏目
     *
     * @return bool
     */
    public function isChannel()
    {
        return $this->type == static::TYPE_CHANNEL;
    }

    /**
     * 获取当前分类下的热门文章
     *
     * @param  $limit
     * @param  null $exceptPost
     * @return mixed
     */
    public function getHotPosts($limit, $exceptPost = null)
    {
        $query = $this->posts()->publishPost();
        if ($exceptPost != null) {
            if (is_numeric($exceptPost)) {
                $query->where('id', '!=', $exceptPost);
            } elseif ($exceptPost instanceof Post) {
                $query->where('id', '!=', $exceptPost->id);
            }
        }
        return $query->orderBy('views_count', 'desc')->recent()->limit($limit)->get();
    }

    public function hasChildren()
    {
        return $this->children->isNotEmpty();
    }

    public function getPresenter()
    {
        return new CategoryPresenter($this);
    }

    public function slugKey(): string
    {
        return 'cate_slug';
    }


    public function slugMode()
    {
        return setting('category_slug_mode');
    }

    /**
     * meta keywords
     * @return string
     */
    public function getKeywords()
    {
        return $this->cate_name . ',' . setting('default_keywords');
    }

    /**
     * meta description
     */
    public function getDescription()
    {
        //\Breadcrumbs::
        return $this->description ?: setting('default_description');
    }
}
