<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Browser;
use AppBundle\Form\BrowserType;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class BrowserController extends FOSRestController
{
    /**
     * Get browser
     *
     * @param $browser Browser
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getBrowserAction(Browser $browser)
    {
        if ($browser === null) {
            throw new NotFoundHttpException('Browser not found');
        }
        $view = $this->view($browser, 200)
            ->setTemplate('default/browser.html.twig')
            ->setTemplateVar('browser');

        return $this->handleView($view);
    }

    /**
     * Get list of browsers
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allBrowserAction()
    {
        $devices = $this->container->get('app.service.browser')->findAll();

        if ($devices === null) {
            throw new NotFoundHttpException('Nothing found');
        }

        $view = $this->view($devices, 200)
            ->setTemplate('default/browserslist.html.twig')
            ->setTemplateVar('browsersList');

        return $this->handleView($view);
    }

    /**
     * Add new browser to DB
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postBrowserAction(Request $request)
    {

        $entity = new Browser();
        $form = $this->createForm(BrowserType::class, $entity, ['method' => $request->getMethod()]);

        $form->handleRequest($request);

        $statusCode = 204;
        $out = null;
        $httpHeader = null;

        if ($form->isValid()) {
            try {

                $entity = $this->container->get('app.service.browser')->addBrowser($entity);

                $httpHeader = ['Location' =>
                    $this->generateUrl(
                        'api_v1_get_browser', ['browser' => $entity->getId()],
                        true
                    )
                ];
            }
            catch (\Exception $e) {
                $statusCode = 500;
                $out = (new BadResult($e->getMessage()))->getResult();

            }
        } else {

            $out = (new BadResult('Form not valid'))->getResult();
            $statusCode = 400;
        }

        $view = $this->view($out, $statusCode);

        if ($httpHeader) {
            $view->setHeaders($httpHeader);

        }
        return $this->handleView($view);

    }

    /**
     * Remove browser from DB
     *
     * @param Browser $entity
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteBrowserAction(Browser $entity)
    {
        $statusCode = 204;
        $out = null;

//        if ($entity) {
            try {
                $this->container->get('app.service.browser')->removeBrowser($entity);
            } catch (\Exception $e ) {
                $out = (new BadResult($e->getMessage()))->getResult();
                $statusCode = 409;
            }
//        } else {
//              $out = (new BadResult('Resource not found'))->getResult();
//            $statusCode = 404;
//        }
        $view = $this->view($out, $statusCode);
        return $this->handleView($view);
    }

    /**
     * Edit browser
     *
     * @param $browser Browser
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modifyBrowserAction(Browser $browser, Request $request)
    {
        $statusCode = 204;
        $out = null;

        $form = $this->createForm(BrowserType::class, $browser, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if ($browser) {
            $this->container->get('app.service.browser')->modifyBrowser($browser);
        } else {
            $out = (new BadResult('Resource not found'))->getResult();
            $statusCode = 404;
        }
        $view = $this->view($out, $statusCode);
        return $this->handleView($view);
    }
}
