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

        $devices = $this->getDoctrine()->getRepository('AppBundle:DeviceBrowser')->findAll();

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
            $repository = $this->getDoctrine()->getRepository('AppBundle:DeviceBrowser');
            $repository->removeDeviceBrowser($deviceBrowser);
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
            $repository = $this->getDoctrine()->getRepository('AppBundle:DeviceBrowser');
            $repository->modifyDeviceBrowser($entity);
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
//            ->setTemplate('default/device.html.twig')
//            ->setTemplateVar('device');

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

        if ($form->isValid()) {
            $repository = $this->getDoctrine()->getRepository('AppBundle:DeviceBrowser');
            $repository->addDeviceBrowser($entity);
        }
        $view = $this->view(null, 204);
        return $this->handleView($view);
    }
}
