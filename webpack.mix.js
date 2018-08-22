let mix = require('laravel-mix');


/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */


/*
 |------------------------------------------------------
 | Laravel Admin template scripts and styles files
 |-----------------------------------------------------
 | Comments below script after the one time execute of the command "npm run production".
 | Becuase these are base the scripts and styles file. So No need make the build again and again
 |
 */ 




// Admin Login Template's base Javascript files.

mix.scripts([
	'node_modules/jquery/dist/jquery.min.js',
	'node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
	'node_modules/node-waves/dist/waves.min.js',
	'node_modules/date-format-lite/dist/index-min.js',
	'public/assets/admin/plugins/AdminBSB/js/admin.js'
	],
	'public/assets/admin/js/admin_login.base.min.js'
);
mix.copy('node_modules/bootstrap-sass/assets/fonts/bootstrap','public/assets/admin/fonts');

mix.sass('node_modules/bootstrap-sass/assets/stylesheets/_bootstrap.scss','public/assets/admin/plugins/AdminBSB/css/_bootstrap.css',{
    data: '@import "./custom_variables";'
});

mix.sass('node_modules/node-waves/src/scss/waves.scss','public/assets/admin/plugins/AdminBSB/css');


// Admin Login template's base css files
mix.styles([
	'public/assets/admin/plugins/material_icons/material-icons.css',
	'public/assets/admin/plugins/roboto_font/css/fonts.css',
	'public/assets/admin/plugins/AdminBSB/css/_bootstrap.css',
	'public/assets/admin/plugins/AdminBSB/css/waves.css',
	'node_modules/animate.css/animate.min.css',
	'public/assets/admin/plugins/AdminBSB/css/materialize.css',
	'public/assets/admin/plugins/AdminBSB/css/style.min.css',
	],
	'public/assets/admin/css/admin_login.base.min.css'
);
mix.copy('node_modules/material-design-icons/iconfont/', 'public/assets/admin/fonts');
mix.copy('public/assets/admin/plugins/roboto_font/fonts/', 'public/assets/admin/fonts');


// Admin Template's base css files
mix.styles([
	'public/assets/admin/plugins/material_icons/material-icons.css',
	'public/assets/admin/plugins/roboto_font/css/fonts.css',
	'public/assets/admin/plugins/AdminBSB/css/_bootstrap.css',
	'public/assets/admin/plugins/AdminBSB/css/waves.css',
	'node_modules/animate.css/animate.min.css',
	'public/assets/admin/plugins/AdminBSB/css/materialize.css',	
	'node_modules/bootstrap-select/dist/css/bootstrap-select.css',
	'public/assets/admin/plugins/AdminBSB/css/waitMe.min.css',
	//'node_modules/sweetalert/src/sweetalert.css',
	'public/assets/admin/plugins/AdminBSB/css/style.min.css',
	'public/assets/admin/plugins/AdminBSB/css/all-themes.min.css',
	'public/assets/admin/plugins/AdminBSB/css/mystyle.css',
	],
	'public/assets/admin/css/admin.base.min.css'
).version();



// Admin template's base javascript files.
mix.scripts([
	'node_modules/jquery/dist/jquery.min.js',
	'node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
	'node_modules/bootstrap-select/dist/js/bootstrap-select.min.js',
	'node_modules/slimscroll/example/ssmaster/jquery.slimscroll.min.js',
	'node_modules/node-waves/dist/waves.min.js',
	'node_modules/autosize/dist/autosize.min.js',
	'node_modules/bootstrap-notify/bootstrap-notify.min.js',
	'node_modules/date-format-lite/dist/index-min.js',
	'public/assets/admin/plugins/AdminBSB/js/waitMe.min.js',
	'node_modules/sweetalert/dist/sweetalert.min.js',
	'public/assets/admin/plugins/AdminBSB/js/admin.js',
	'public/assets/admin/plugins/AdminBSB/js/laravel.form.js',
	'public/assets/admin/plugins/AdminBSB/js/setting.js'
	],
	'public/assets/admin/js/admin.base.min.js'
).version();

//mix.scripts('node_modules/coffeescript/resumable.js','public/assets/admin/js/resumable.js');
//mix.scripts('node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js','public/assets/admin/js/bootstrap.min.js');
//mix.scripts('node_modules/jquery/dist/jquery.min.js','public/assets/admin/js/jquery.min.js');
mix.scripts([
	'node_modules/jquery/dist/jquery.min.js',
	'node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
	'node_modules/resumablejs/samples/coffeescript/resumable.js'
	],
	'public/assets/admin/js/resumable.template.base.min.js'
).version();


mix.scripts('node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js','public/assets/admin/js/bootstrap-tagsinput.min.js');
mix.styles('node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css','public/assets/admin/css/bootstrap-tagsinput.css');

mix.styles('node_modules/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css','public/assets/admin/css/bootstrap-editable.min.css');
mix.scripts([
	'node_modules/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.min.js',
	'public/assets/admin/plugins/AdminBSB/js/multiple_email-input-editable.js',
	'public/assets/admin/plugins/AdminBSB/js/address-input-editable.js'
	],
	'public/assets/admin/js/bootstrap-editable.min.js'
).version();

mix.copy('node_modules/x-editable/dist/bootstrap3-editable/img','public/assets/admin/img');

mix.scripts([
	'public/assets/admin/plugins/codemirror/lib/codemirror.js',
	'public/assets/admin/plugins/codemirror/mode/javascript/javascript.js',
	'public/assets/admin/plugins/codemirror/addon/selection/active-line.js',
	'public/assets/admin/plugins/codemirror/addon/edit/matchbrackets.js',
	],
	'public/assets/admin/js/codemirror.min.js'
);

mix.styles([
		'public/assets/admin/plugins/codemirror/lib/codemirror.css',
		'public/assets/admin/plugins/codemirror/lib/theme/hopscotch.css',
	],
'public/assets/admin/css/codemirror.min.css');

mix.styles([
		//'node_modules/datatables/media/css/jquery.dataTables.min.css',
		'public/assets/admin/plugins/datatable-skin/dataTables.bootstrap.css',
	],
'public/assets/admin/css/jquery.dataTables.min.css');

mix.copy('node_modules/datatables/media/images','public/assets/admin/images');
mix.scripts(
	[
		'node_modules/datatables/media/js/jquery.dataTables.min.js',
		'public/assets/admin/plugins/datatable-skin/dataTables.bootstrap.js',
		'public/assets/admin/plugins/datatable-skin/dataTables.buttons.min.js'
	],
'public/assets/admin/js/jquery.dataTables.min.js');


mix.scripts([
	'node_modules/jquery/dist/jquery.min.js',
	'node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
	'public/assets/admin/plugins/dropzone/dropzone.js',
	'public/assets/admin/plugins/cropper/cropper.min.js',
	'public/assets/admin/plugins/AdminBSB/js/waitMe.min.js'
	],'public/assets/admin/js/file-drag-drop.base.js').version();

mix.styles(
	[
		'public/assets/admin/plugins/AdminBSB/css/_bootstrap.css',
		'public/assets/admin/plugins/cropper/cropper.min.css',
		'public/assets/admin/plugins/dropzone/dropzone.css',
		'public/assets/admin/plugins/AdminBSB/css/waitMe.min.css'
	],
'public/assets/admin/css/file-drag-drop.base.css').version();

mix.copy('node_modules/cropperjs/src/images','public/assets/admin/images');