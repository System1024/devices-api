<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Entity\DeviceBrowser;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\DeviceBrowserType;

class DeviceBrowserController extends FOSRestController
{
    /**
     * List of device-browser
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws NotFoundHttpException
     */
    public function allDevicebrowsersAction()
    {

        $devices = $this->container->get('app.service.devicebrowser')->findAll();

        if ($devices === null) {
            throw new NotFoundHttpException('Nothing found');
        }

        $view = $this->view($devices, 200)
            ->setTemplate('default/devicebrowserslist.html.twig')
            ->setTemplateVar('devicesList');

        return $this->handleView($view);
    }

    /**
     * Delete device-browser
     *
     * @param DeviceBrowser $deviceBrowser
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteDevicebrowsersAction(DeviceBrowser $deviceBrowser)
    {
        $statusCode = 204;
        $out = null;

        if ($deviceBrowser) {
            $this->container->get('app.service.devicebrowser')->removeDeviceBrowser($deviceBrowser);
        } else {
            $out = (new BadResult('Resource not found'))->getResult();
            $statusCode = 404;
        }
        $view = $this->view($out, $statusCode);
        return $this->handleView($view);

    }

    /**
     * Modify device-browser
     *
     * @param DeviceBrowser $entity
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modifyDevicebrowsersAction(DeviceBrowser $entity, Request $request)
    {
        $statusCode = 204;
        $out = null;

        $form = $this->createForm(DeviceBrowserType::class, $entity, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if ($entity) {
            $this->container->get('app.service.devicebrowser')->modifyDeviceBrowser($entity);
        } else {
            $out = (new BadResult('Resource not found'))->getResult();
            $statusCode = 404;
        }
        $view = $this->view($out, $statusCode);
        return $this->handleView($view);
    }

    /**
     * Get device-browser
     *
     * @param DeviceBrowser $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws NotFoundHttpException
     */
    public function getDevicebrowsersAction(DeviceBrowser $id)
    {
        if ($id === null) {
            throw new NotFoundHttpException('DeviceBrowser not found');
        }

        $view = $this->view($id, 200);
        return $this->handleView($view);
    }

    /**
     * Add new device-browser
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postDevicebrowsersAction(Request $request)
    {
        $entity = new DeviceBrowser();
        $form = $this->createForm(DeviceBrowserType::class, $entity, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        $statusCode = 204;
        $out = null;
        $httpHeader = null;

        if ($form->isValid()) {
            $this->container->get('app.service.devicebrowser')->addDeviceBrowser($entity);
            $httpHeader = [
                'Location' => $this->generateUrl('api_v1_get_devicebrowsers', ['id' => $entity->getId()])
            ];

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
}
