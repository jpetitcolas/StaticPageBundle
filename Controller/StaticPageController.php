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

        //make Location configable
        $location = $this->container->getParameter('j_petitcolas_static_page.template.location');
        $template = sprintf($location, $page);
        if(!$this->get('templating')->exists($template)) {
            throw new NotFoundHttpException(sprintf('Unable to find template %s.', $template));
        }
        
        $response = $this->render($template);
        if($this->container->getParameter('j_petitcolas_static_page.httpcache')){
            if($this->container->getParameter('j_petitcolas_static_page.httpcache.Public')){
                $response->setPublic();
            }
            else{
                $response->setPrivate();
            }
            $response->setMaxAge($this->container->getParameter('j_petitcolas_static_page.httpcache.MaxAge'));
            $response->setSharedMaxAge($this->container->getParameter('j_petitcolas_static_page.httpcache.SharedMaxAge'));
            $response->setTtl($this->container->getParameter('j_petitcolas_static_page.httpcache.TTL'));
        }
        return $response;
    }
}
