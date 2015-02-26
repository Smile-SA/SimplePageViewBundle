# Introduction

The SimplePageViewBundle is an easy way to include a light and simple page view counting system in your website.

It does not provide session management. All page displayed (refreshed, F5, ...) are processed.

#Installation

## Step 1: Download Bundle with composer

`composer require "smile/simple-page-view-bundle:~0.1"`

## Step 2: Enable the Bundle

Enable the bundle in the kernel :

``` php
//app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Smile\Bundle\SimplePageViewBundle\SmileSimplePageViewBundle(),
    );
}
```

## Step 3: Enable the route

In app/config/routing.yml, load the bundle route :

```
smile_simple_page_view:
    resource: "@SmileSimplePageViewBundle/Controller/"
    type:     annotation
    prefix:   /
```

## Step 4: Update database schema

Run the update database schema command :

`php app/console doctrine:schema:update --force`

# Utilisation:

## Twig function

Enable the collect of information in a page using the following Twig function :

``` twig
{{ smile_page_view(pageType, pageId) }}
```

The pageType is used to explain what the type of page you are currently in (for example if your application is a news article, you can put in type 'news' ).

pageId is the unique identifier of the current page element (for example the numerical id of your article). It is not mandatory.

## Batch

In order to aggregate and compress page view data, you must run the batch `php app/console smile:pageviews:aggregate`.

You can add it in a cron task (we advise to run it once each day)

This batch compress data by type, id and date in the table `smile_page_view_stats` and remove the processed entries from the table `smile_page_view_storage`.
