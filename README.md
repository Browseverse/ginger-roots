# Ginger Roots

Ginger Roots is a fork of the incredible Roots Theme mixed together with [{{Mustache}}](http://mustache.github.com/) templates.
It uses [Mustache.php](https://github.com/bobthecow/mustache.php) to wrap and convert existing .php templates into
.mustache files.

## Mustache Theme support

Many of the built-in Mustache features are supported, plus wordpress-specific adaptation, including:

* i18n via custom `{{#__}}{{/__}}` tags
* partials `{{> }}` to include other templates
* Wordpress foundations such as the loop (via `{{#the_loop}}`)
* Pre-populated wordpress context data, e.g. `{{is_singular}}`, `{{the_permalink}}`

* All mustache templates are located inside `templates` folder
* Templates correspond to their .php counterparts, i.e. there is `page.php` which uses `templates/page.mustache`
* New templates can be created even without a php counterpart, as long as they don't need new context data

## Why Mustache?

Because it's neat. Wordpress and PHP are very powerful, but adjusting php templates embedded with html can easily become messy.
Mustache forces you to split application logic and presentation in a nice way. 

## Quick start

* Clone the git repo - `git clone git://github.com/gingerlime/roots.git` - or [download it](https://github.com/gingerlime/roots/zipball/master)
* Read [Theme Activation](https://github.com/retlehs/roots/wiki/Theme-activation) to understand everything that happens once you activate Roots

Ginger Roots specifics:

Terms:

* Rootache - the very unattractive name for the Mustache.php sub-class used in Ginger Roots
* template / $template - the mustache template, before rendering
* context / $context - the 'storage space' for all data used to render the template. Typically a $context is a Rootache
  instance.

Editing Templates:

* Hack away any file in templates/

Adding data or logic:

* Use the appropriate php file to add data to the context
* Extend the Rootache class

## [Roots Theme](http://rootstheme.com/)

Roots is a starting WordPress theme made for developers that’s based on [HTML5 Boilerplate](http://html5boilerplate.com/), Starkers, and the most popular CSS frameworks.

Roots includes support for Blueprint CSS, 960 Grid System, 1140px Grid, Adapt.js, Less Framework, Foundation, and Bootstrap with the ability to set site-wide classes for the main content area and the sidebar. There's also the option to not use any CSS framework.


## Features

* HTML5 Boilerplate's markup, style, and .htaccess
* Popular CSS frameworks included (with the option to use none)
* Clean URLs (no more `/wp-content/`)
* All static theme assets are rewritten to the website root (`/css/`, `/img/`, and `/js/`)
* Cleaner HTML output of navigation menus
* Root relative URLs
* Posts use the hNews microformat
* The gallery shortcode has been modified to use `<figure>` and `<figcaption>`
* `wp_head` has been cleaned up along with the output of enqueued styles and scripts
* Robots.txt optimized for SEO
* [Multilingual ready](http://www.rootstheme.com/wpml/) (English, Spanish, French, Italian, Dutch, Brazilian Portuguese, Macedonian, Finnish, Danish, and Turkish)

### Theme Options
![Theme Options](http://www.rootstheme.com/img/roots-settings.png)

## Contributing

Anyone and everyone is welcome to contribute. There are several ways you can help out:

1. Raising [issues](https://github.com/retlehs/roots/issues) on GitHub
2. Sending pull requests for bug fixes or new features and improvements
3. Making the [docs](https://github.com/retlehs/roots/wiki) better
4. Replying to questions on the [mailing list](http://groups.google.com/group/roots-theme)

## Project information

* Source: [https://github.com/retlehs/roots](https://github.com/retlehs/roots)
* Web: [http://rootstheme.com/](http://rootstheme.com/)
* Docs: [https://github.com/retlehs/roots/wiki](https://github.com/retlehs/roots/wiki)
* Mailing list: [http://groups.google.com/group/roots-theme](http://groups.google.com/group/roots-theme)
* Twitter: [@retlehs](https://twitter.com/#!/retlehs)
* Contributors: [https://github.com/retlehs/roots/contributors](https://github.com/retlehs/roots/contributors)

## License

### Major components:

* HTML5 Boilerplate: The Unlicense
* Modernizr: MIT/BSD license
* jQuery: MIT/GPL license
* Normalize.css: Public Domain
* Blueprint CSS: Modified MIT License
* 960 Grid System: MIT/GPL License
* The 1140px Grid: CC BY-SA 3.0 Australia License
* Adapt.js: MIT/GPL license
* Less Framework 4: MIT license
* Foundation: MIT license
* Bootstrap: Apache 2.0 license

### Everything else:

The Unlicense (aka: public domain)
