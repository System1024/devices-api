<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Browserversion;
use AppBundle\Form\BrowserversionType;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class BrowserVersionController extends FOSRestController
{
    /**
     * Get browser version
     *
     * @param Browserversion $browserVersion
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getBrowserversionAction(Browserversion $browserVersion)
    {

        if ($browserVersion === null) {
            throw new NotFoundHttpException('Browser version not found');
        }

        $view = $this->view($browserVersion, 200)
            ->setTemplate('default/browserversion.html.twig')
            ->setTemplateVar('browser');

        return $this->handleView($view);
    }

    /**
     * Get list of brouser versions
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allBrowserversionAction()
    {
        $devices = $this->getDoctrine()->getRepository('AppBundle:Browserversion')->findAll();

        if ($devices === null) {
            throw new NotFoundHttpException('Nothing found');
        }

        $view = $this->view($devices, 200)
            ->setTemplate('default/browserversionslist.html.twig')
            ->setTemplateVar('browserVersionList');

        return $this->handleView($view);
    }

    /**
     * Add new browser version
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postBrowserversionAction(Request $request)
    {
        $entity = new Browserversion();
        $form = $this->createForm(BrowserversionType::class, $entity, ['method' => $request->getMethod()]);

        $form->handleRequest($request);

        $statusCode = 204;
        $out = null;


        if ($form->isValid()) {
            $repository = $this->getDoctrine()->getRepository('AppBundle:Browserversion');
            $repository->addBrowserversion($entity);

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
        $view->setHeader('Location', $this->generateUrl(
            'api_v1_get_browserversion', array('browserVersion' => $entity->getId()),
            true
        ));
        return $this->handleView($view);

    }

    /**
     * Remove browser version
     *
     * @param Browserversion $entity
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteBrowserversionAction(Browserversion $entity)
    {

        $statusCode = 204;
        $out = null;

        if ($entity) {
            $repository = $this->getDoctrine()->getRepository('AppBundle:Browserversion');
            $repository->removeBrowserversion($entity);
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
     * Modufy browser version
     *
     * @param Browserversion $entity
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modifyBrowserversionAction(Browserversion $entity, Request $request)
    {
        $statusCode = 204;
        $out = null;

        $form = $this->createForm(BrowserversionType::class, $entity, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if ($entity) {
            $repository = $this->getDoctrine()->getRepository('AppBundle:Browserversion');
            $repository->modifyBrowserversion($entity);
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
