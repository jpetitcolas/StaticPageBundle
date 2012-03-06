<?php

namespace JPetitcolas\StaticPageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StaticPageController extends Controller
{
    /**
     * Render a static page by its name.
     * @param string $page Template (and page) name
     * @return Response
     *
     * @throws NotFoundHttpException If the template does not exist.
     *
     * @Route("/{page}")
     */
    public function indexAction($page = 'home')
    {
        // Do not deliver home page at "/home" URL (avoid duplicate content)
        $requestUri = $this->getRequest()->getRequestUri();
        if(strpos($requestUri, '/home')) {
            return $this->redirect('/', 301);
        }

        $template = sprintf('JPetitcolasStaticPageBundle:StaticPage:%s.html.twig', $page);
        if(!$this->get('templating')->exists($template)) {
            throw new NotFoundHttpException(sprintf('Unable to find template %s.', $template));
        }

        return $this->render($template);
    }
}
