# Frontend Code

This directory contains the **source files** for the generated frontend files
and the default markdown documents that are shown if the configured "pages/"
folder is currently empty.

## Setup

You will need NodeJS and the gulp package. 

https://nodejs.org/en/download/

Once you have Node (and the included npm tool) you can run the `install` command once.
Everything else will be handled by the `gulp` command (or alternatively `npm run`):

    $ cd [path to project]
    $ npm install

## Workflow

Whenever you edit or create new SCSS or JS files inside the `./frontend/` directory you only
need to call the `gulp` command to rebuild all the files for you:

    $ gulp
        
While working on files inside `./frontend/**` you can tell `gulp` to watch for file changes 
and run automatically:

    $ gulp watch

## Alternative

If you don't have the gulp-cli package installed globally (some people do), you can use NPM instead,
which will use the local version:
   
    $ npm run build
    $ npm run watch
          
### /frontend/md/

For a lack of better place, these files are not _really frontend_ but
are used if the site currently has no markdown files of its own. They are
basically only loaded and accessible if there is no `/pages/index.md`

They contain the example files and PaperPHP welcome page.
