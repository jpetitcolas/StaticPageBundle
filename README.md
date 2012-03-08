# StaticPageBundle

This very simple bundle provides an easy way to include static pages into your Symfony2 application using all the features provided by the framework such as Twig.

## Installation

### Adding bundle submodule

As usual, there are two ways to add the bundle into your projects.

#### With deps file

```
[StaticPageBundle]
    git=git://github.com/jpetitcolas/StaticPageBundle.git
    target=/bundles/JPetitcolas/StaticPageBundle
```

Then, just update the vendors with appropriate command:

``` bash
php bin/vendors update
```

#### As a Git submodule

If you rather like to use git submodules directly without editing your deps file, just type the following into your command line interface:

``` bash
git submodule add https://github.com/jpetitcolas/StaticPageBundle.git vendor/bundles/JPetitcolas/StaticPageBundle
```

### Configuring the bundle

The bundle is very common to configure.

Register the namespace into `autoload.php` file:

``` php
<?php
// app/autoload.php

$loader->registerNamespaces(array(
    'JPetitcolas'       => __DIR__.'/../vendor/bundles',
));
```

Then, register the bundle into your `app/AppKernel.php` file:

``` php
<?php
// app/AppKernel.php

$bundles = array(
    new JPetitcolas\StaticPageBundle\JPetitcolasStaticPageBundle(),
);
```

Finally, update your routing file accordingly:

``` yaml
JPetitcolasStaticPageBundle:
    resource: "@JPetitcolasStaticPageBundle/Controller/"
    type:     annotation
    prefix:   /
```

Feel free to add the prefix you want.

That's all! Your bundle is ready to work!

## How to use

Using this bundle is very easy. Just add the files you want into `app/Resources/JPetitcolasStaticPageBundle/views/StaticPage` folder.

The URL of your page is linked to your template file name, without the `.html.twig` extension. For instance, if you want to get `/terms-of-service` url, you should edit `terms-of-service.html.twig` file into above folder.
