<?php

namespace AppBundle\Controller;

use AppBundle\Form\DeviceType;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Entity\Device;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class DeviceController extends FOSRestController
{
    /**
     * Get device
     *
     * @param Device $device
     * @return Response
     */
    public function getDeviceAction(Device $device)
    {
        if ($device === null) {
            throw new NotFoundHttpException('Device not found');
        }

        $view = $this->view($device, 200)
            ->setTemplate('default/device.html.twig')
            ->setTemplateVar('device');

        return $this->handleView($view);
    }

    /**
     * Get all devices
     *
     * @return Response
     */
    public function allDeviceAction()
    {
        $devices = $this->container->get('app.service.device')->findAll();

        if ($devices === null) {
            throw new NotFoundHttpException('Nothing found');
        }

        $view = $this->view($devices, 200)
            ->setTemplate('default/listdevices.html.twig')
            ->setTemplateVar('deviceList');

        return $this->handleView($view);
    }

    /**
     * Add new device
     *
     * @param Request $request
     *
     * @return Response
     */
    public function postDeviceAction(Request $request)
    {
        $entity = new Device();
        $form = $this->createForm(DeviceType::class, $entity);

        $form->handleRequest($request);

        $statusCode = 204;
        $out = null;
        $httpHeaders = null;

        if ($form->isValid()) {

            $this->container->get('app.service.device')->addDevice($entity);

            $httpHeaders = [
                'Location' =>
                $this->generateUrl(
                    'api_v1_get_device', array('device' => $entity->getId()),
                    true
                )
            ];
        } else {
            $out = (new BadResult('Form not valid'))->getResult();
            $statusCode = 400;
        }
        $view = $this->view($out, $statusCode);
        if ($httpHeaders) {
            $view->setHeaders($httpHeaders);
        }

        return $this->handleView($view);

    }

    /**
     * Remove device
     *
     * @param Device $entity
     *
     * @return Response
     */
    public function deleteDeviceAction(Device $entity)
    {

        $statusCode = 204;
        $out = null;

        if ($entity) {
            $this->container->get('app.service.device')->removeDevice($entity);
        } else {
            $out = (new BadResult('Resource not found'))->getResult();
            $statusCode = 404;
        }
        $view = $this->view($out, $statusCode);
        return $this->handleView($view);
    }

    /**
     * Edit device
     *
     * @param Device $entity
     * @param Request $request
     *
     * @return Response
     */
    public function modifyDeviceAction(Device $entity, Request $request)
    {

        $form = $this->createForm(DeviceType::class, $entity, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        $statusCode = 204;
        $out = null;

        if ($form->isValid()) {
            $this->container->get('app.service.device')->modifyDevice($entity);

        } else {
            $out = (new BadResult('Form not valid'))->getResult();
            $statusCode = 400;
        }
        $view = $this->view($out, $statusCode);
        return $this->handleView($view);
    }

}

