<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Browser;
use AppBundle\Form\BrowserType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
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
        $devices = $this->getDoctrine()->getRepository('AppBundle:Browser')->findAll();

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
        $header = null;

        if ($form->isValid()) {
            $repository = $this->getDoctrine()->getRepository('AppBundle:Browser');
            $repository->addBrowser($entity);

        } else {

            $out = [
                'result' => 'Fail',
                'message' => 'Form not valid',
                'request' => $request->request,
                'errors' => $form->getErrors()
            ];
            $statusCode = 400;
        }

        $view = $this->view($out, $statusCode);
        if ($header) {
            $view->setHeader('Location',
                $this->generateUrl(
                    'api_v1_get_browser', array('browser' => $entity->getId()),
                    true
                )
            );
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

        if ($entity) {
            try {
                $repository = $this->getDoctrine()->getRepository('AppBundle:Browser');
                $repository->removeBrowser($entity);
            } catch (\Exception $e ) {
                $out = [
                    'result' => 'Fail',
                    'message' => $e->getMessage()
                ];
                $statusCode = 409;
            }
        } else {
            $out = [
                'result' => 'Fail',
                'message' => 'Resource not found'
            ];
            $statusCode = 404;
        }
        $view = $this->view($out, $statusCode);
        return $this->handleView($view);
    }

    /**
     * Edit browser
     *
     * @param $browser Browser
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
            $repository = $this->getDoctrine()->getRepository('AppBundle:Browser');
            $repository->modifyBrowser($browser);
        } else {
            $out = [
                'result' => 'Fail',
                'message' => 'Resource not found'
            ];
            $statusCode = 404;
        }
        $view = $this->view($out, $statusCode);
        return $this->handleView($view);
    }
}
