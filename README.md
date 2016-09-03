# PaperPHP

The idea is to use static documents for static pages, such as 
articles, and then use file directories to visualize structure.

## How it works

Files are written with Markdown. Place them into the "pages" directory
and they can be reached by their filename and path. The Markdown is converted
to HTML and the user has a readable representation of your document online.

For example:

    ./pages/stuff/about-me.md

will become instantly available at 

    http://[sitenmame]/stuff/about-me


## Meta / Data

You can add any amount of structured data into the special "header" portion
of your document. By default you can use it to give your resulting HTML document
a `title` and `description`. 

    ---
    title: My Content
    description: "This is a description"
    ---

The data within wil be made available in the templates so you can use them as you 
see fit. For example, you could add a `author` field and output this information 
somewhere in your <head> section or maybe even load a custom vcard template, tailored
for this particular author. All data is stored in the `document` variable. See the 
default templates for examples.

## Templates

I opted for [Twig](twig.sensiolabs.org/documentation) as engine for the templating system. 
It features inheritance, macros, caching and has many useful filters and functions. 

By default, there is only one template for everything, but you can use the header to 
declare any `template` file you want, per document. That template again may contain 
any amount of includes, variable placeholders, an so on. 

This should give you enough control about the presentation. The rest is up to the design.

## Setup

This package uses composer. To learn how to install composer [check here](https://getcomposer.org/doc/00-intro.md#system-requirements).
Now type the following command:

    composer install
    
Once the process is complete, upload everything to your webserver of choice. It should run
at least PHP 5.5. If you see the default welcome page, the _installation_ is complete and you 
can begin creating your Markdown pages.

I plan on creating full distributions at a later point, which makes the "composer" routine obsolete.

## Hosting

On Apache you should have zero issues. However, i recommend pointing the VirtualHost to the
`public/` directory, for security reasons. PaperPHP will run with or without it. Your choice.

### Troubleshooting

- The entire system currently relies on Apache mod_rewrite, so make sure you have it enabled.
- If you don't see anything, check if `cache` is writable. Also, check your server logs.
- If you still don't get something, check if you installed/uploaded the required composer packages. 
- If you get redirect issues, try commenting out the RewriteBase statement in the `public/.htaccess`

## License

The MIT License (MIT)