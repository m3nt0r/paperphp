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

## Meta Tags / Data

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
for this particular author. 

    ---
    title: "My life as doe"
    author: "j-doe"
    twitter: "jdoe204808"
    ---

Anything that is in the header section will be available via the `document` variable.

    Follow me on Twitter: https://twitter.com/{{ document.twitter }}
    
This brings us to...
    
## Templates

I opted for [Twig](twig.sensiolabs.org/documentation) as engine for the templating system. 
It features inheritance, macros, caching and has many useful filters and functions. 

By default, there is only one template for everything, but you can use the header to 
declare any `template` file you want, per document. That template again may contain 
any amount of includes, variable placeholders, an so on. 

This should give you enough control about the presentation. 

## Setup

Your webserver should at least run PHP 5.5

Download the zip file linked below and upload everything to your webserver. 
And That should already be everything you need to do. 

If you see the default welcome page you may begin creating your own Markdown pages.

[Download "paperphp.zip"](https://github.com/paperphp/paperphp/raw/master/release/paperphp.zip)

## Configuration

Copy the `config.json.default` to `config.json` and modify it to your liking. 

## Hosting

On a Apache webserver you should have zero issues. Other Webservers may need some custom 
configuration to get the URL rewriting going.

Regardless of which server you end up using, for security reasons i recommend pointing the 
VirtualHost to the `public/` directory. 

### URL rewriting

The .htaccess tries to use mod_rewrite if enabled. If you can't use .htaccess or enable the module, 
you can use the `?url=` parameter to call documents. For example:

    index.php?url=stuff/about-me 
    index.php?url=/stuff/about-me 



### Troubleshooting

- If you don't see anything, check if `cache` is writable. Also, check your server logs.
- If you still don't get something, check if you installed/uploaded the required _composer_ packages. 
- If you get redirect issues (error 500), try commenting out the RewriteBase statement in the `public/.htaccess`

## Development`

This package uses composer for managing vendor assets. 
To load the required vendor libraries, run the `install` command once. 

    $ cd [path to project]
    $ composer install

To learn how to install the **composer** utility itself:

https://getcomposer.org/download/


## License

The MIT License (MIT)