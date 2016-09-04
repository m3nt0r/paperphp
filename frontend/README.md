# Frontend Code

This directory contains the **source files** for the generated frontend files
and the default markdown documents that are shown if the configured "pages/"
folder is currently empty.

## Generator

I use [Grunt](http://gruntjs.com) for running the generators. You will need
to have [node.js](http://nodejs.org) installed to install and run any of these.

One you have **node.js**, and the **npm** utility that comes with it, you can 
install the development packages required for this project like so:

```bash
    $ cd [your paperphp install path]
    $ npm install
```

Once that is done, run **grunt**. If that won't work you might not have it
installed globally. You can use the local package through **npm** like so:
   
```bash
    $ npm start
```

This will launch grunt in "watch"-mode. It will observe all frontend sources for 
changes and rebuild the files as necessary. 

Other npm commands are outlined below as an alternative to using the _grunt_ command directly.

### /frontend/js/

Javascript is generated via [browserify](http://browserify.org/)
The entry point is `paperphp.js`

    grunt browserify
     
    // alternative: npm run build-js

The `vendor.js` however is just a concat of external libs that don't 
need to be rebuild every time you update application file. Which files
are included is configured in the Gruntfile.js. If those are changed,
run the following command

    grunt concat
     
    // alternative: npm run build-js

### /frontend/less/

Stylesheets are generated via [LESS.css](http://lesscss.org/)

     grunt less
     
     // alternative: npm run build-css
          
### /frontend/md/

For a lack of better place, these files are not _really frontend_ but
are used if the site currently has no markdown files of its own. They are
basically only loaded and accessible if there is no `/pages/index.md`

They contain the example files and PaperPHP welcome page.
