<?php

namespace Smile\Bundle\SimplePageViewBundle\Twig\Extension;

use Smile\Bundle\SimplePageViewBundle\Manager\PageViewManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

 /**
 * @author    Florian Touya <mxdup@smile.fr>
 * @copyright 2015 Smile (http://www.smile.fr)
 */
class PageViewExtension extends \Twig_Extension
{
    /** @var Router $router */
    private $router;

    /**
     * Constructor
     *
     * @param Router $router
     */
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
            new \Twig_SimpleFunction('smile_page_view', array($this, 'pageView'), array('is_safe' => array('html')))
        );
    }

    /**
     * Add invisible pixel in the page
     * @param string  $type
     * @param integer $id
     *
     * @return string
     */
    public function pageView($type, $id = null)
    {
        $url = $this->router->generate('smile_page_view_persist', array('type' => $type, 'id' => $id));

        return sprintf('<img style="display:none;" alt="page_view" src="%s">', $url);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'smile_page_view';
    }
}
