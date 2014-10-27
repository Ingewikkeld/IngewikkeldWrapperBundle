<?php

namespace Ingewikkeld\WrapperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
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
        return new Response($this->get('ingewikkeld_wrapper.sf1_context_proxy')->getContext()->getController()->dispatch());
    }
}
