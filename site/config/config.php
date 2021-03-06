<?php

##
# GLOBAL SETTINGS
##

return [
    ##
    # INCLUDES
    ##
    'hooks' => require 'hooks.php',
    'routes' => require 'routes.php',
    'thumbs' => require_once 'thumbs.php',
    'bnomei.janitor.jobs' => require_once 'jobs.php',


    ##
    # KIRBY OPTIONS
    ##

    # Set alternative `home` identifier
    'home' => 'news',

    # Enable languages (currently supported are DE, EN & FR)
    'languages' => true,

    # Sitemap settings
    'sitemap.ignore' => ['error'],

    # Typography settings
    # See https://getkirby.com/docs/reference/system/options/smartypants
    'smartypants' => true,

    # Enable API cache for `dependencies`
    'cache.deps' => true,


    ##
    # PLUGIN OPTIONS
    ##

    # Generate donuts charts as inline SVG
    'fundevogel.donuts.inline' => true,

    # Create lossy WebP images
    'hashandsalt.webp.png.encoding' => 'lossy',
    'hashandsalt.webp.jpeg.encoding' => 'lossy',
    'hashandsalt.kirby-webp.template' => 'webp',

    # Disable security headers (see `.htaccess`)
    'bnomei.securityheaders.enabled' => 'force',
    'bnomei.securityheaders.headers' => [],
    'bnomei.securityheaders.loader' => function () {
        return kirby()->root('config') . '/settings/csp.json';
    },
    'bnomei.securityheaders.setter' => function (\Bnomei\SecurityHeaders $instance) {
        # See https://github.com/paragonie/csp-builder#build-a-content-security-policy-programmatically
        $csp = $instance->csp();

        $cssFile = option('debug') === true ? 'main.css' : 'main.min.css';
        $cssPath = 'assets/styles/' . $cssFile;
        $cssNonce = $instance->setNonce((new Asset($cssPath))->read());

        $jsFile = option('debug') === true ? 'main.js' : 'main.min.js';
        $jsPath = 'assets/scripts/' . $jsFile;
        $jsNonce = $instance->setNonce((new Asset($jsPath))->read());

        $csp->nonce('style-src', $cssNonce);
        $csp->nonce('script-src', $jsNonce);
    },

    # Adding hash to {css,js} files for cache busting
    # See https://github.com/bnomei/kirby3-fingerprint
    // 'bnomei.fingerprint.query' => false,
    'bnomei.fingerprint.hash' => function ($file) {
        $url = null;
        $fileroot = is_a($file, 'Kirby\Cms\File') || is_a($file, 'Kirby\Cms\FileVersion')
            ? $file->root()
            : kirby()->roots()->index() . DIRECTORY_SEPARATOR . ltrim(str_replace(kirby()->site()->url(), '', $file), '/');

        if (F::exists($fileroot)) {
            $filename = implode('.', [
                F::name($fileroot),
                filemtime($fileroot),
                F::extension($fileroot)
            ]);

            if (is_a($file, 'Kirby\Cms\File') || is_a($file, 'Kirby\Cms\FileVersion')) {
                $url = str_replace($file->filename(), $filename, $file->url());
            } else {
                $dirname = str_replace(kirby()->roots()->index(), '', \dirname($fileroot));
                $url = ($dirname === '.')
                    ? $filename
                    : ($dirname . '/' . $filename);
            }
        } else {
            $url = $file;
        }

        return \url($url);
    },

    # Customizing MetaTags
    'pedroborges.meta-tags.default' => function ($page, $site) {
        # General
        $seoTitle = $page->isHomePage()
            ? $site->title()
            : $page->seoTitle();
        $seoDescription = $page->seoDescription();
        $delimiter = ' | ';

        return [
            'title' => $seoTitle->isNotEmpty()
                ? $page->isHomePage() ? $seoTitle : $seoTitle . $delimiter . $site->title()
                : $page->title() . $delimiter . $site->title(),
            'meta' => [
                'description' => $seoDescription->isNotEmpty()
                    ? $seoDescription
                    : $page->text()->excerpt(155),
            ],
            'link' => [
                'canonical' => $page->url(),
                # 'icon' => [
                #     ['href' => url('assets/images/icons/favicon-62.png'), 'sizes' => '62x62', 'type' =>'image/png'],
                #     ['href' => url('assets/images/icons/favicon-192.png'), 'sizes' => '192x192', 'type' =>'image/png']
                # ],
                'alternate' => function ($page) {
                    $locales = [];

                    foreach (kirby()->languages() as $language) {
                        if ($language->code() == kirby()->language()) continue;

                        $locales[] = [
                            'hreflang' => $language->code(),
                            'href' => $page->url($language->code())
                        ];
                    }

                    return $locales;
                }
            ],
            'og' => [
                'title' => $seoTitle->isNotEmpty()
                    ? $seoTitle
                    : $page->title(),
                'type' => 'website',
                'site_name' => $site->title(),
                'url' => $page->url()
            ],
            'twitter' => [
                'card' => 'summary',
                # 'site' => $site->twitter(),
                'title' => $seoTitle->isNotEmpty()
                    ? $seoTitle
                    : $page->title(),
                'namespace:image' => function ($page, $site) {
                    $image = $site->homePage()->image();

                    if ($page->hasImages()) {
                        $image = $page->image();
                    }

                    return [
                        'image' => $image->url(),
                        'alt' => $image->altAttribute()
                    ];
                }
            ]
        ];
    },
    'pedroborges.meta-tags.templates' => function ($page, $site) {
        return [
            'lesetipps.article' => [
                'json-ld' => [
                    'Organization' => [
                        'name' => $site->title()->value(),
                        'url' => $site->url(),
                        "contactPoint" => [
                            '@type' => 'ContactPoint',
                            # 'telephone' => $site->phoneNumber()->value(),
                            'contactType' => 'customer service'
                        ]
                    ]
                ]
            ],
        ];
    }
];
