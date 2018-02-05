<?php

/*
 * add .styleci.yml
 */

namespace App\Services;

use Illuminate\Filesystem\Filesystem;

class HTMLPurifier
{
    private $purifier;
    protected $files;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    // todo 所有的配置放到配置文件中去
    public function getPurifier()
    {
        $c = config('purifier');
        if (! $this->purifier) {
            $config = \HTMLPurifier_Config::createDefault();
            $config->set('HTML.Doctype', 'HTML 4.01 Transitional');
            $config->set('CSS.AllowTricky', true);
            $this->checkCacheDirectory($c);
            $config->set('Cache.SerializerPath', $c['cachePath']);
            // Allow iframes from:
            // o YouTube.com
            // o Vimeo.com
            $config->set('HTML.SafeIframe', true);
            $config->set('URI.SafeIframeRegexp', '%^' . config('app.url') . '%');
            $config->set('HTML.Allowed', implode(',', $c['allowed']));
            // Set some HTML5 properties
            $config->set('HTML.DefinitionID', 'html5-definitions'); // unqiue id
            $config->set('HTML.DefinitionRev', 1);
            if ($def = $config->maybeGetRawHTMLDefinition()) {
                // http://developers.whatwg.org/sections.html
                $def->addElement('section', 'Block', 'Flow', 'Common');
                $def->addElement('nav', 'Block', 'Flow', 'Common');
                $def->addElement('article', 'Block', 'Flow', 'Common');
                $def->addElement('aside', 'Block', 'Flow', 'Common');
                $def->addElement('header', 'Block', 'Flow', 'Common');
                $def->addElement('footer', 'Block', 'Flow', 'Common');
                // Content model actually excludes several tags, not modelled here
                $def->addElement('address', 'Block', 'Flow', 'Common');
                $def->addElement('hgroup', 'Block', 'Required: h1 | h2 | h3 | h4 | h5 | h6', 'Common');
                // http://developers.whatwg.org/grouping-content.html
                $def->addElement('figure', 'Block', 'Optional: (figcaption, Flow) | (Flow, figcaption) | Flow', 'Common');
                $def->addElement('figcaption', 'Inline', 'Flow', 'Common');
                // http://developers.whatwg.org/the-video-element.html#the-video-element
                $def->addElement('video', 'Block', 'Optional: (source, Flow) | (Flow, source) | Flow', 'Common', array(
                    'src'      => 'URI',
                    'type'     => 'Text',
                    'width'    => 'Length',
                    'height'   => 'Length',
                    'poster'   => 'URI',
                    'preload'  => 'Enum#auto,metadata,none',
                    'controls' => 'Bool',
                ));
                $def->addElement('source', 'Block', 'Flow', 'Common', array(
                    'src'  => 'URI',
                    'type' => 'Text',
                ));
                // http://developers.whatwg.org/text-level-semantics.html
                $def->addElement('s', 'Inline', 'Inline', 'Common');
                $def->addElement('var', 'Inline', 'Inline', 'Common');
                $def->addElement('sub', 'Inline', 'Inline', 'Common');
                $def->addElement('sup', 'Inline', 'Inline', 'Common');
                $def->addElement('mark', 'Inline', 'Inline', 'Common');
                $def->addElement('wbr', 'Inline', 'Empty', 'Core');
                // http://developers.whatwg.org/edits.html
                $def->addElement('ins', 'Block', 'Flow', 'Common', array('cite' => 'URI', 'datetime' => 'CDATA'));
                $def->addElement('del', 'Block', 'Flow', 'Common', array('cite' => 'URI', 'datetime' => 'CDATA'));
                // TinyMCE
                $def->addAttribute('img', 'data-mce-src', 'Text');
                $def->addAttribute('img', 'data-mce-json', 'Text');
                // Others
                $def->addAttribute('iframe', 'allowfullscreen', 'Bool');
                $def->addAttribute('table', 'height', 'Text');
                $def->addAttribute('td', 'border', 'Text');
                $def->addAttribute('th', 'border', 'Text');
                $def->addAttribute('tr', 'width', 'Text');
                $def->addAttribute('tr', 'height', 'Text');
                $def->addAttribute('tr', 'border', 'Text');
            }
            $this->purifier = new \HTMLPurifier($config);
        }

        return $this->purifier;
    }

    /**
     * Check/Create cache directory
     * Array $config.
     */
    private function checkCacheDirectory($config)
    {
        $cachePath = $config['cachePath'];
        if ($cachePath) {
            if (! $this->files->isDirectory($cachePath)) {
                $this->files->makeDirectory($cachePath, $config['cacheFileMode'] ?: 0755);
            }
        }
    }

    public function clean($html, $config = null)
    {
        return $this->getPurifier()->purify($html, $config);
    }
}
