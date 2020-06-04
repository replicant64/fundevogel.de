const
    src = 'source/',
    root = 'public/',
    dist = root + 'assets/',
    pkg = require('../../package.json'),

    localURL = 'localhost',
    faviconSnippet = 'favicons.html',

    pngquant = require('imagemin-pngquant')
;

module.exports = {
    public: root,
    src: {
        styles: src + 'styles',
        scripts: src + 'scripts',
        images: src + 'images',
        icons: src + 'images/icons',
        fonts: src + 'fonts',
    },
    dist: {
        styles: dist + 'styles',
        scripts: dist + 'scripts',
        images: dist + 'images',
        icons: dist + 'images',
        fonts: dist + 'fonts',
    },
    styles: {
        linting: {
            // For more options, see https://github.com/olegskl/gulp-stylelint#formatters
            fix: false,
            failAfterError: false,
            reporters: [{
                formatter: 'string',
                console: true,
            }],
        },
        sass: {
            // For more options, see https://github.com/sass/node-sass#options
            precision: 10, // https://github.com/sass/sass/issues/1122
            includePaths: ['node_modules'],
        },
        prefix: {
            // For more options, see https://github.com/postcss/autoprefixer#options
        },
    },
    scripts: {
        input: 'main.js', // Place it in your `src` + `scripts` directory
        linting: {}, // For more options, see https://github.com/adametry/gulp-eslint#eslintoptions
        webpack: {
            mode: 'none',
            watch: false,
        },
        babel: {
            presets: ['@babel/preset-env'],
        },
    },
    images: {
        allowed: ['png', 'jpg', 'svg', 'gif'],
        minify: {
            progressive: true,
            use: [pngquant()],
        },
    },
    icons: {
        minify: {
            plugins: [{
                removeDoctype: false,
            },
            {
                removeComments: false,
            },
            // {
            //   cleanupNumericValues: {
            //     floatPrecision: 1,
            //   },
            // },
            {
                convertColors: {
                    names2hex: false,
                    rgb2hex: false,
                },
            }],
        }, // For more options, see https://github.com/ben-eb/gulp-svgmin#plugins
        output: 'icons.svg', // SVG sprite filename
        inline: false,
    },
    fonts: {
        allowed: ['ttf', 'woff', 'woff2'], // For example, generating from OTF without shipping source files
    },
    server: {
        enable: true,
        connect: {
            // For more options, see https://github.com/micahblu/gulp-connect-php#options
            base: '.',
            router: 'vendor/getkirby/cms/router.php',
        },
    },
    browsersync: {
    // For more options, see https://browsersync.io/docs/options
        proxy: localURL,
        port: 4000,
        notify: true,
        open: true,
        online: false,
    },
    watch: {
        code: [
            'site/**/*.{php,yml}',
            'content/**/*',
        ],
    },
    sourcemaps: {
        enable: true,
        path: '.', // This defaulfs to `dist` + `styles` & `dist` + `scripts`
    },
    favicons: {
        enable: true,
        input: 'logo.png', // Place it in your `src` + `images` directory
        snippet: faviconSnippet,
        options: {
            // For more options, see https://github.com/itgalaxy/favicons
            path: '/favicons/',
            appName: 'Kinder- und Jugendbuchhandlung Fundevogel',
            appShortName: 'Fundevogel',
            developerName: 'Martin Folkers',
            developerURL: 'https://twobrain.io',
            // The following are taken from `package.json` to prevent duplicate code
            appDescription: pkg.description,
            url: pkg.homepage,
            version: pkg.version,
            lang: 'de-DE',
            background: '#fafafa',
            theme_color: '#f0694b',
            start_url: '/',
            pipeHTML: true,
            html: '../../../site/snippets/generated/' + faviconSnippet,
            icons: {
                // By default, only `android`, `appleIcon` & `windows` are enabled
                appleStartup: false,
                coast: false,
                favicons: false, // See https://forum.getkirby.com/t/how-to-make-a-proper-compressed-favicon-ico/2725
                firefox: false,
                yandex: false,
            },
        },
    },
    subsetting: {
    // For more options, see https://github.com/filamentgroup/glyphhanger
        enable: false,
        urls: [
            // In combination with `spider: true`, this should be sufficient:
            localURL, // Browsersync source
            // Otherwise, add as many local/external files & URLs as you like:
            // pkg.homepage,
            // 'http://example.com',
            // './example.html'
        ],
        formats: ['woff'], // Available formats: 'ttf', 'woff', 'woff-zopfli', 'woff2'
        spider: false,
        whitelist: false,
        us_ascii: false,
        latin: false,
        output_css: true,
        css_selector: false,
    },
};