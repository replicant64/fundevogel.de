/* eslint-disable @typescript-eslint/no-var-requires */

/*
---------------------------------------
Assets - Fonts
---------------------------------------
*/

import {src, dest, series, parallel, lastRun, TaskFunction} from 'gulp';

import conf from '../config';

const
    browserSync = require('browser-sync').init,
    del = require('del'),
    {execSync} = require('child_process'),
    flatten = require('gulp-flatten')
;


/*
 * Copies fonts - well, that's it
 */

function copyFonts() {
    const filetypes = conf.fonts.allowed.join(',');
    const fontSource = conf.src.fonts + '/**/*.{' + filetypes + '}';

    return src(fontSource, {since: lastRun(copyFonts)})
        .pipe(flatten())
        .pipe(dest(conf.dist.fonts))
        .pipe(browserSync.stream())
    ;
}


/*
 * Subsets fonts for smaller filesize
 */

function subsetFonts(callback: () => void): void {
    execSync('mkdir -p ' + conf.dist.fonts);

    const options = conf.subsetting;
    const defaults = [
        './node_modules/.bin/glyphhanger',
        options.urls ? options.urls.join(' ') : '',
        options.formats ? '--formats=' + options.formats.join(',') : '',
        options.output_css ? '--css' : '',
        '--output=' + conf.dist.fonts,
    ];

    if (options.presets) {
        let preset;

        for (preset of Object.keys(options.presets)) {
            const family = options.presets[preset];

            let command = [
                '--subset=' + conf.src.fonts + '/' + family + '.ttf',
                options.spider || options.spider[preset] ? '--spider' : '',
                options.spiderlimit && options.spiderlimit[preset] ? '--spider-limit=' + options.spiderlimit[preset].toString() : '',
                options.whitelist && options.whitelist[preset] ? '--whitelist=' + options.whitelist[preset] : '',
                options.latin || options.latin[preset] ? '--LATIN' : '',
                options.us_ascii || options.us_ascii[preset] ? '--US_ASCII' : '',
                options.css_selector && options.css_selector[preset] ? '--cssSelector="' + options.css_selector[preset] + '"' : '',
            ];

            // Apply defaults, execute command
            command = defaults.concat(command);
            execSync(command.filter(Boolean).join(' '));

            // TODO: Replace with loop
            // Rename all font files
            execSync('mv ' + conf.dist.fonts + '/' + family + '-subset.ttf ' + conf.dist.fonts + '/' + preset + '.subset.ttf');
            execSync('mv ' + conf.dist.fonts + '/' + family + '-subset.zopfli.woff ' + conf.dist.fonts + '/' + preset + '.subset.woff');
            execSync('mv ' + conf.dist.fonts + '/' + family + '-subset.woff2 ' + conf.dist.fonts + '/' + preset + '.subset.woff2');
        }
    } else {
        let command = [
            '--subset=' + conf.src.fonts + '/*.ttf',
            options.spider ? '--spider' : '',
            options.whitelist ? '--whitelist=' + options.whitelist : '',
            options.latin ? '--LATIN' : '',
            options.us_ascii ? '--US_ASCII' : '',
            options.css_selector ? '--cssSelector="' + options.css_selector + '"' : '',
        ];

        // Apply defaults, execute command
        command = defaults.concat(command);
        execSync(command.filter(Boolean).join(' '));
    }

    callback();
}


/*
 * Copies generated font styles to CSS directory
 */

function copyStyles() {
    return src(conf.dist.fonts + '/*.css')
        .pipe(dest(conf.dist.styles));
}


/*
 * Removes CSS files from fonts folder
 */

function removeCSS() {
    return del(conf.dist.fonts + '/*.css');
}


/*
 * Exports
 */

let fonts: TaskFunction;

if (conf.subsetting.enable && process.env.NODE_ENV === 'production') {
    fonts = parallel(
        copyFonts,
        series(subsetFonts, copyStyles, removeCSS)
    );
} else {
    fonts = copyFonts;
}

export = fonts;
