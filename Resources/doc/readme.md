# Introduction
The SimpleTrackingBundle is an esay way to include a tracking system in your website.

#Installation
## Step 1: Download Bundle with composer
composer require ...

## Step 2: Enable the Bundle
Enable the bundle in the kernel

    <?php
    //app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Smile\SimpleTrackingBundle\SmileSimpleTrackingBundle(),
        );
    }

# Utilisation:
## Twig function
Enable the tracking page with the next Twig function
    {{ track(type, trackId) }}

The type is used for explain what page is tracking. ( for example if your application is blog, you can put in type: 'post' )

TrackId: is unique identication of track element (for blog you can put the post Id)

## Batch
For compress data of tracking, you must run the batch
    php app/console smile:tracking:update

This batch compress data by type and trackId
