# Introduction

The SimpleTrackingBundle is an easy way to include a light and simple tracking system in your website.

#Installation

## Step 1: Download Bundle with composer

`composer require
composer require ...

## Step 2: Enable the Bundle

Enable the bundle in the kernel :

``` php
//app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Smile\Bundle\SimpleTrackingBundle\SmileSimpleTrackingBundle(),
    );
}
```

## Step 3: Enable the route

In app/config/routing.yml, load the bundle route :

```
smile_simple_tracking:
    resource: "@SmileSimpleTrackingBundle/Controller/"
    type:     annotation
    prefix:   /
```

# Utilisation:

## Twig function

Enable the tracking in a page using the following Twig function :

``` twig
{{ track(type, trackId) }}
```

The type is used to explain what the type of page you are currently in (for example if your application is a news article, you can put in type: 'news' ).

TrackId is the unique identifier of the current page element (for example the numerical id of your article).

## Batch

In order to compress tracking data, you must run the batch `php app/console smile:tracking:update`.

You can add it in a cron task (we advise to run it once each day)

This batch compress data by type, trackId and date in the table `tracking_track_count` and remove the processed entries from the table `tracking_track`.
