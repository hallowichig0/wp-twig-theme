# Bootstrap 4 Theme Boilerplate for Wordpress
This boilerplate uses kirki customizer, acf, timber, sass, bootstrap 4, jquery.

## Features

- Bootstrap **v4.3.1**
- With mobile detection library
- Configured Bootstrap 4 SASS
- Configured Kirki Customizer
- Configured ACF
- Configured Timber
- Gulp workflow and tasks are already configured.
- Third party javascript libraries are managed by NPM

## Getting Started
These instructions will get you a copy of the project up and running on your local machine for development

### # Requirements
- PHP version >= 7.2
- Node version >= 10.16.3
- NPM version >= 6.7.0
- Gulp CLI latest version

### # Theme Installation
```
NOTE: before running the installation, please make sure to follow the requirements above.
```

1. Clone the theme repository inside the wp-content/theme directory
2. Delete the `.git` folder inside the `wp-twig-theme` theme folder.
3. Install Kirki plugin
4. Install ACF Pro plugin

### # Theme workflow settings/installation
1. Run `npm install` inside the `wp-twig-theme` theme folder.
1. Run `gulp mvplugins` inside the `wp-twig-theme` theme folder.

#### Available Gulp tasks

```
NOTE: Dont use vanilla sass to compile your sass partials. Always use the included Gulp task runner to compile sass and manage third party libraries. For reference see gulpfile.js in the subtheme root directory.
```

- `gulp sass` - compiles sass files into styles.css, it also creates minified version.
- `gulp watch` - watches sass files for changes and compiles automatically.
- `gulp watchsync` - same with gulp watch but it auto reloads your browser after changes has been saved.
- `gulp mvplugins` - moves third party libraries from node_modules folder to libraries folder. Make sure to list the library folder in `line 51` of gulpfile.js
- `gulp default` - default task, it runs both `gulp sass` and `gulp mvplugins`
- `gulp minify_js` - makes a minified version of the main.js file inside the js folder

#### Installing 3rd party plugins/libraries
Always install 3rd party plugins/libraries with NPM using the command `npm install`. Instead of downloading it manually from other sources.

For example: If you want to use [slick carousel](http://kenwheeler.github.io/slick/) plugin, run the command `npm install slick-carousel` inside the theme folder and move the plugin folder to `vendor` folder using `gulp mvplugins` task.
