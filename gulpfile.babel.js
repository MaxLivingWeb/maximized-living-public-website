'use strict';

import path from 'path';

// Core Gulp
import gulp from 'gulp';

// Config Values
import paths from './gulpfile.json';

// Other Tools
import notifier from 'node-notifier';
import newer from 'gulp-newer';
import es from 'event-stream';

// Style Processing
import sass from 'gulp-sass';
import sassGlob from 'gulp-sass-bulk-import';
import postcss from 'gulp-postcss';
import autoprefixer from 'autoprefixer';
import cssnano from 'cssnano';
import normalize from 'postcss-normalize';

// Javascript Processing
import rollup from 'rollup-stream';
import source from 'vinyl-source-stream';
import builtIns from 'rollup-plugin-node-builtins';
import babel from 'rollup-plugin-babel';
import resolve from 'rollup-plugin-node-resolve';
import uglify from 'rollup-plugin-uglify';

// Image Processing
import imagemin from 'gulp-imagemin';
import imageminJpegoptim from 'imagemin-jpegoptim';

const env = process.env.NODE_ENV; // eslint-disable-line

function emitLog(stage, err) {
    if (err) {
        notifier.notify({
            'title': `ERROR: ${stage}`,
            'message': `There was an error within ${stage}`
        });
        console.log(err); // eslint-disable-line
    }
}

const outputName = (string) => {
    const removed = path.parse(string);
    return path.parse(removed['name']);
};

// Styles Task
gulp.task('styles', () => {
    let processors = [
        autoprefixer(),
        normalize()
    ];
    if (env !== 'development') {
        processors.push(cssnano({discardUnused: {fontFace: false}}));
    }

    let tasks = paths.themeName.map((theme) => {
        return gulp.src(`resources/${theme}/${paths.src.styles}/**/*.scss`)
            .pipe(sassGlob())
            .pipe(
                sass({includePaths: ['./node_modules/**/']})
                    .on('error', (err) => {
                        emitLog('styles', err);
                        this.emit('end');
                    })
            )
            .pipe(postcss(processors))
            .pipe(gulp.dest(`${paths.dest.theme}/${theme}/styles/`));
    });
    return es.merge(tasks);
});

// Scripts Task
gulp.task('scripts', () => {
    const tasks = paths.themeName.map((theme) => {
        return gulp.src(`resources/${theme}/${paths.src.scripts}/**/*.compile.js`, (err, files) => {
            const fileTasks = files.map((entry) => {
                const output = outputName(entry);
                return rollup({
                    input: entry,
                    format: 'iife',
                    plugins: [
                        builtIns(),
                        resolve(),
                        babel({
                            presets: [
                                [
                                    'env',
                                    {
                                        'modules': false
                                    }
                                ]
                            ],
                            babelrc: false,
                            plugins: [
                                'external-helpers'
                            ]
                        }),
                        uglify()
                    ]
                })
                    .pipe(source(`${output['name']}.js`))
                    .pipe(gulp.dest(`${paths.dest.theme}/${theme}/scripts/`));
            });
            return es.merge(fileTasks);
        });
    });
    return es.merge(tasks);
});

// Images Task
gulp.task('images', () => {
    let tasks = paths.themeName.map((theme) => {
        if (env === 'development') {
            return gulp.src(`resources/${theme}/${paths.src.images}/**/*.+(jpg|jpeg|gif|png|svg)`)
                .pipe(newer(`${paths.dest.theme}/${theme}/images/`))
                .pipe(gulp.dest(`${paths.dest.theme}/${theme}/images/`))
                .on('end', (err) => {
                    emitLog('images', err);
                });
        }
        return gulp.src(`resources/${theme}/${paths.src.images}/**/*.+(jpg|jpeg|gif|png|svg)`)
            .pipe(imagemin([
                imagemin.gifsicle({interlaced: true}),
                imagemin.optipng({optimzationLevel: 5}),
                imagemin.svgo({
                    plugins: [
                        {
                            cleanupIDs: false,
                            removeEmptyAttrs: false,
                            removeViewBox: false
                        }
                    ]
                }),
                imageminJpegoptim({
                    max: 85,
                    progressive: true
                })
            ]))
            .pipe(gulp.dest(`${paths.dest.theme}/${theme}/images`))
            .on('end', (err) => {
                emitLog('images', err);
            });
    });
    return es.merge(tasks);
});

// Watch Task
gulp.task('watch', ['default'], () => {
    paths.themeName.map((theme) => {
        gulp.watch(`resources/${theme}/${paths.src.styles}/**/*.scss`, ['styles']);
        gulp.watch(`resources/${theme}/${paths.src.scripts}/**/*.js`, ['scripts']);
        gulp.watch(`resources/${theme}/${paths.src.images}/**/*.+(jpg|jpeg|gif|png|svg)`, ['images']);
    });
});

// Compilation Task
gulp.task('default', ['styles', 'scripts', 'images']);
