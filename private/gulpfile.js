// @todo: Incluir descrições para cada uma das tasks
// @todo: Talvez forçar a manter as versões atuais das dependências

// Requisitos Básicos
var gulp = require('gulp');
var sass = require('gulp-sass');
var file_include = require('gulp-file-include');
var clean_css = require('gulp-clean-css');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var replace = require('gulp-replace');
var plumber = require('gulp-plumber');

// Caracteres Especiais
var specialChars = {
	"Á": "&Aacute;",
	"á": "&aacute;",
	"É": "&Eacute;",
	"é": "&eacute;",
	"Í": "&Iacute;",
	"í": "&iacute;",
	"Ó": "&Oacute;",
	"ó": "&oacute;",
	"Ú": "&Uacute;",
	"ú": "&uacute;",
	"Â": "&Acirc;",
	"â": "&acirc;",
	"Ê": "&Ecirc;",
	"ê": "&ecirc;",
	"Ô": "&Ocirc;",
	"ô": "&ocirc;",
	"À": "&Agrave;",
	"à": "&agrave;",
	"Ã": "&Atilde;",
	"ã": "&atilde;",
	"Õ": "&Otilde;",
	"õ": "&otilde;",
	"Ü": "&Uuml;",
	"ü": "&uuml;",
	"Ç": "&Ccedil;",
	"ç": "&ccedil;"
};

// Inputs e Outputs
var io = {
	settings: {
		input: './configs/partials/**/*.html',
		output: './configs/',
	},
	css: {
		input: './scss/*.scss',
		output: './admin/css/',
	},
	js: {
		input: './js/*.js',
		output: './js/',
	}
};

// SETTINGS.html
function settings_task (input) {
	return gulp
		.src( [input] )
		.pipe( plumber({ 
			errorHandler: function (error) {
				console.log(error);
			}
		}))
		.pipe( file_include({
			prefix: '@@',
			basepath: '@file',
			indent: true
		}))
		.pipe(replace(/(Á|á|É|é|Í|í|Ó|ó|Ú|ú|Â|â|Ê|ê|Ô|ô|À|à|Ã|ã|Õ|õ|Ü|ü|Ç|ç)/g, function(match, p1, offset, string) {
			return specialChars[match];
		}))
		.pipe( gulp.dest( io.settings.output ) );
}

gulp.task('settings', function() {
	return settings_task( './configs/partials/settings.html' );
});

// SASS
// 1. Processa SCSS
// 2. Minifica e remove comentários
// 3. Renomeia para .min
// 4. Salva o output
var sass_options = {
	errLogToConsole: true,
	outpuStyle: 'compressed'
};

function sass_task (input) {
	console.log(input + ' input');
	return gulp
		.src( input )
		.pipe( plumber({ 
			errorHandler: function (error) {
				console.log(error);
			}
		}))
		.pipe( sass(sass_options).on('error', sass.logError) )
		.pipe( clean_css( {debug: true, level: {1: {specialComments: 0}}}, (details) => {
			console.log(`${details.name}: ${details.stats.originalSize}`);
			console.log(`${details.name}: ${details.stats.minifiedSize}`);
		}) )
		.pipe( rename(
			function (path) {
				console.log(path.basename, path)
				path.basename += ".min";
			}
		))
		.pipe( gulp.dest( io.css.output ) );
}

gulp.task('sass', function () {
	return sass_task( io.css.input );
});

// JS
// 1. Minifica o JS
// 2. Renomeia para .min
// 3. Salva o output
var js_options = {};

function js_task (input) {
	return gulp
		.src( input )
		.pipe( uglify({
			warnings: true,
			mangle: false,
			sourceMap: false
		}))
		.pipe( rename(
			function (path) {
				console.log(path.basename, path)
				path.dirname += "/min";
				path.basename += ".min";
			}
		))
		.pipe( gulp.dest( io.js.output ) );
}

gulp.task('js', function () {
	return js_task( io.js.input );
});

// TODAS AS TAREFAS
// Roda todas as tarefas uma só vez
gulp.task('once', gulp.series('settings', 'sass', 'js'));

// WATCH
gulp.task('watch', function () {
	gulp.watch(io.settings.input)
		.on('change', function (file) {
			var new_path = file.replace(/\\/g, '/');
			settings_task('./configs/partials/settings.html');
			console.log( 'O arquivo "' + file + '" foi modificado. Executando tarefas...');
		});
	gulp.watch(io.css.input)
		.on('change', function (file) {
			var new_path = file.replace(/\\/g, '/');
			sass_task(new_path);
			console.log( 'O arquivo "' + file + '" foi modificado. Executando tarefas...');
			var regEx = new RegExp(/^_/g)
			var fileName = file.split('\\').reverse()[0];
			if (regEx.test(fileName)) {
				sass_task('css/scss/*.scss')
			}
		});
	gulp.watch(io.js.input)
		.on('change', function (file) {
			var new_path = file.replace(/\\/g, '/');
			js_task(new_path);
			console.log( 'O arquivo "' + file + '" foi modificado. Executando tarefas...');
		});
});
