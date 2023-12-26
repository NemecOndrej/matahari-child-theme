"use strict";
var gulp = require("gulp");
var sassInheritance = require("gulp-sass-inheritance");
var sass = require("gulp-sass")(require("sass"));
var cached = require("gulp-cached");
var gulpif = require("gulp-if");
var filter = require("gulp-filter");
const sourcemaps = require("gulp-sourcemaps");
const prefix = require("gulp-autoprefixer");
const fs = require("fs");
const gutil = require("gulp-util");
const ftp = require("vinyl-ftp");
const sftp = require("gulp-sftp");
const path = require("path");

var prefixerOptions = {
    overrideBrowserslist: ["last 2 versions"],
};

//const config = require('../../../.vscode/sftp.json'); //Tady můžeš změnit cestu k souboru sftp.json podle tvojí adresářové struktury

function deployFiles(pathFile, pathMap) {
    const globs = ["./" + pathFile, "./" + pathMap];

    //var filePathArr = path.join(__filename, '..').split("\\");
    var filePathArr = path.join(__filename, "..").split("/"); //tento řádek použij pokud používáš MAC OS
    var themeFolderName = filePathArr[filePathArr.length - 1];

    if (config.protocol == "ftp") {
        //  FTP version
        const conn = ftp.create({
            host: config.host,
            user: config.username,
            password: config.password,
            port: config.port,
            parallel: 10,
            reload: true,
            remotePath:
                config.remotePath +
                "wp-content/themes/" +
                themeFolderName +
                "/",
            debug: function (d) {
                console.log(d);
            },
            log: gutil.log,
        });
        return gulp
            .src(globs, { base: ".", buffer: false })
            .pipe(
                conn.newer(
                    config.remotePath +
                        "wp-content/themes/" +
                        themeFolderName +
                        "/"
                )
            ) // only upload newer files
            .pipe(
                conn.dest(
                    config.remotePath +
                        "wp-content/themes/" +
                        themeFolderName +
                        "/"
                )
            );
    } else {
        // SFTP version
        const conn = sftp({
            host: config.host,
            user: config.user,
            pass: config.password,
            port: config.port,
            remotePath: config.remote_path,
        });
        return gulp.src(globs, { base: ".", buffer: false }).pipe(conn);
    }
}

gulp.task("start-d", function (cb) {
    global.isWatching = true;

    gulp.watch("./assets/css/**/*.scss").on("change", function (filePath) {
        gulp.src("assets/css/**/*.scss")
            .pipe(sourcemaps.init())
            .pipe(gulpif(global.isWatching, cached("sass")))
            .pipe(sassInheritance({ dir: "./assets/css/" }))
            .pipe(
                filter(function (file) {
                    return !/\/_/.test(file.path) || !/^_/.test(file.relative);
                })
            )
            .pipe(
                sass({
                    //style: 'compressed',
                    errLogToConsole: true,
                    onError: function (err) {
                        return notify().write(err);
                    },
                })
            )
            .pipe(prefix(prefixerOptions))
            .pipe(sourcemaps.write("."))
            .pipe(gulp.dest("./assets/css/"));
    });

    gulp.watch("./assets/css/**/*.css").on("change", function (filePath) {
        var mapPath = filePath.replace(".css", ".css.map");
        fs.access(filePath, (err) => {
            if (err) {
                console.log(err.message);
                console.log(err.code);
            } else {
                deployFiles(filePath, mapPath);
            }
        });
    });

    cb();
});

gulp.task("start-nd", function (cb) {
    global.isWatching = true;

    gulp.watch("./assets/css/**/*.scss").on("change", function (filePath) {
        gulp.src("assets/css/**/*.scss")
            .pipe(sourcemaps.init())
            .pipe(gulpif(global.isWatching, cached("sass")))
            .pipe(sassInheritance({ dir: "./assets/css/" }))
            .pipe(
                filter(function (file) {
                    return !/\/_/.test(file.path) || !/^_/.test(file.relative);
                })
            )
            .pipe(
                sass({
                    //style: 'compressed',
                    errLogToConsole: true,
                    onError: function (err) {
                        return notify().write(err);
                    },
                })
            )
            .pipe(prefix(prefixerOptions))
            .pipe(sourcemaps.write("."))
            .pipe(gulp.dest("./assets/css/"));
    });

    cb();
});
