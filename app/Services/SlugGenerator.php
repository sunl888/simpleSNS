<?php

namespace App\Services;


use Closure;
use DB;
use GuzzleHttp\Client;

class SlugGenerator
{
    protected $slugIsUniqueFunc = null;

    public function generate($text, $slugMode = '', $delimiter = '-')
    {
        if (empty($slugMode)) {
            $slugMode = config('tiny.default_slug_mode');
        }
        if ('str_random' == $slugMode) {
            $slug = str_random();
        } elseif ('english' == $slugMode) {
            $slug = $this->englishSlug($text, $delimiter);
        } else {
            // default pinyin
            $slug = $this->pinyinSlug($text, $delimiter);
        }
        while (!$this->slugIsUnique($slug)) {
            if ('str_random' == $slugMode) {
                $slug .= str_random(5);
            } else {
                $slug .= '-' . str_random(5);
            }
        }
        return $slug;
    }

    public function englishSlug($text, $delimiter = '-')
    {
        if ($this->isEnglish($text)) {
            return str_slug($text);
        }
        $http = new Client();
        $salt = time();
        $api = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';
        $appid = setting('baidu_translate_appid');
        $key = setting('baidu_translate_key');

        // 如果没有配置百度翻译，直接使用拼音
        if (empty($appid) || empty($key)) {
            return $this->pinyinSlug($text);
        }
        // http://api.fanyi.baidu.com/api/trans/product/apidoc
        // appid+q+salt+密钥 的MD5值
        $sign = md5($appid . $text . $salt . $key);
        $query = http_build_query([
            'q' => $text,
            'from' => 'zh',
            'to' => 'en',
            'appid' => $appid,
            'salt' => $salt,
            'sign' => $sign,
        ]);
        $url = $api . $query;
        $response = $http->get($url);
        $result = json_decode($response->getBody(), true);
        if (isset($result['trans_result'][0]['dst'])) {
            return str_slug($result['trans_result'][0]['dst'], $delimiter);
        } else {
            return $this->pinyinSlug($text, $delimiter);
        }
    }

    public function isEnglish($text)
    {
        if (preg_match("/\p{Han}+/u", $text)) {
            return false;
        }
        return true;
    }

    public function pinyinSlug($text, $delimiter = '-')
    {
        return pinyin_permalink($text, $delimiter);
    }

    public function slugIsUnique($slug)
    {
        if (!is_null($this->slugIsUniqueFunc)) {
            return call_user_func($this->slugIsUniqueFunc, $slug);
        }
        return true;
    }

    /**
     * 设置判断 slug 是否唯一的函数
     *
     * setSlugIsUniqueFunc(function ($slug){
     *     return Post::where('slug', $slug)->count() <= 0;
     * })
     *
     * setSlugIsUniqueFunc('post', 'slug');
     *
     * @param $slugIsUniqueFuncOrTableName
     * @param string $field
     * @return $this
     */
    public function setSlugIsUniqueFunc($slugIsUniqueFuncOrTableName, string $slugField = '', $ignore = null, $ignorekeyName = 'id')
    {
        if ($slugIsUniqueFuncOrTableName instanceof Closure) {
            $this->slugIsUniqueFunc = $slugIsUniqueFuncOrTableName;
        } else {
            $this->slugIsUniqueFunc = function ($text) use ($slugIsUniqueFuncOrTableName, $slugField, $ignore, $ignorekeyName) {
                $query = DB::table($slugIsUniqueFuncOrTableName)->where($slugField, $text);
                if ($ignore) {
                    $query->where($ignorekeyName, $ignore);
                }
                return $query->count() <= 0;
            };
        }

        return $this;
    }
}
