<?php

namespace Smile\Bundle\SimpleTrackingBundle\Http;

use Symfony\Component\HttpFoundation\Response;

class TransparentPixelResponse extends Response
{
    /** @var string */
    const TRACKING_IMAGE_CONTENT = 'R0lGODlhAQABAJAAAP8AAAAAACH5BAUQAAAALAAAAAABAAEAAAICBAEAOw==';

    /** @var string */
    const TRACKING_IMAGE_CONTENT_TYPE = 'image/gif';

    public function __construct()
    {
        $content = base64_decode(self::TRACKING_IMAGE_CONTENT);
        parent::__construct($content);

        $this->headers->set('Content-Type', self::TRACKING_IMAGE_CONTENT_TYPE);
        $this->setPrivate();
        $this->headers->addCacheControlDirective('no-cache', true);
        $this->headers->addCacheControlDirective('must-revalidate', true);
    }
}
