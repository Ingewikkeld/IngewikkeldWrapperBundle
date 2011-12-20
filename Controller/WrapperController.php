<?php

namespace Ingewikkeld\WrapperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class WrapperController extends Controller
{
    /**
     * @Route("/")
     * @Route("/{url}", requirements={"url" = ".+?"}, defaults={"url"=""})
     * @Template()
     */
    public function indexAction($url = '')
    {
        define('SF_ROOT_DIR',    $this->get('kernel')->getRootDir().'/'.$this->container->getParameter('wrapper_legacypath'));
        define('SF_APP',         $this->container->getParameter('wrapper_app'));
        define('SF_ENVIRONMENT', $this->container->getParameter('wrapper_env'));
        define('SF_DEBUG',       $this->container->getParameter('wrapper_debug'));

        require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

        return new \Symfony\Component\HttpFoundation\Response(\sfContext::getInstance()->getController()->dispatch());

    }
}
