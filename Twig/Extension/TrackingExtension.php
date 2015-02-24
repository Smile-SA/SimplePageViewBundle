<?php

namespace Smile\SimpleTrackingBundle\Twig\Extension;

use Smile\SimpleTrackingBundle\Manager\TrackingManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

 /**
 * @author    Florian Touya <mxdup@smile.fr>
 * @copyright 2015 Smile (http://www.smile.fr)
 */
class TrackingExtension extends \Twig_Extension
{
    /** @var Router $router */
    private $router;


    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('track', array($this, 'track'), array('is_safe' => array('html')))
        );
    }

    /**
     * @param string  $type
     * @param integer $id
     *
     * @return string
     */
    public function track($type, $id)
    {
        $url = $this->router->generate('smile_tracking_track', array('type' => $type, 'id' => $id));

        return sprintf('<img style="display:none;" alt="track" src="%s">', $url);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tracking';
    }
}
