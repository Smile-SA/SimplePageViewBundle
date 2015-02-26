<?php

namespace Smile\Bundle\SimplePageViewBundle\Http;

use Symfony\Component\HttpFoundation\Response;

class TransparentPixelResponse extends Response
{
    /** @var string */
    const IMAGE_CONTENT = 'R0lGODlhAQABAJAAAP8AAAAAACH5BAUQAAAALAAAAAABAAEAAAICBAEAOw==';

    /** @var string */
    const IMAGE_CONTENT_TYPE = 'image/gif';

    public function __construct()
    {
        parent::__construct(base64_decode(self::IMAGE_CONTENT));

        $this->headers->set('Content-Type', self::IMAGE_CONTENT_TYPE);
        $this->setPrivate();
        $this->headers->addCacheControlDirective('no-cache', true);
        $this->headers->addCacheControlDirective('must-revalidate', true);
    }
}
