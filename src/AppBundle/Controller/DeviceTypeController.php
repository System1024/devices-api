<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Devicetypes;
use AppBundle\Form\DevicetypesType;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class DeviceTypeController extends FOSRestController
{
    /**
     * Get devicetype
     *
     * @param Devicetypes $deviceType Devicetypes
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getDevicetypeAction(Devicetypes $deviceType)
    {
        if ($deviceType === null) {
            throw new NotFoundHttpException('Not found');
        }
        $view = $this->view($deviceType, 200)
            ->setTemplate('default/devicetype.html.twig')
            ->setTemplateVar('devicetype');

        return $this->handleView($view);
    }

    /**
     * Get list of devicetypes
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allDevicetypeAction()
    {
        $devices = $this->container->get('app.service.devicetype')->findAll();

        if ($devices === null) {
            throw new NotFoundHttpException('Nothing found');
        }

        $view = $this->view($devices, 200)
            ->setTemplate('default/devicetypeslist.html.twig')
            ->setTemplateVar('devicetypesList');

        return $this->handleView($view);
    }

    /**
     * Add new devicetype to DB
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postDevicetypeAction(Request $request)
    {

        $entity = new Devicetypes();
        $form = $this->createForm(DevicetypesType::class, $entity, ['method' => $request->getMethod()]);

        $form->handleRequest($request);

        $statusCode = 204;
        $out = null;
        $httpHeader = null;

        if ($form->isValid()) {
            try {

                $this->container->get('app.service.devicetype')->addDeviceType($entity);

                $httpHeader = ['Location' =>
                    $this->generateUrl(
                        'api_v1_get_devicetype', ['deviceType' => $entity->getId()],
                        true
                    )
                ];
            }
            catch (\Exception $e) {
                $statusCode = 500;
                $out = (new BadResult($e->getMessage()))->getResult();

            }
        } else {

//            $out = (new BadResult('Form not valid'))->getResult();
            $out = (new BadResult($form->getErrors()))->getResult();
            $statusCode = 400;
        }

        $view = $this->view($out, $statusCode);

        if ($httpHeader) {
            $view->setHeaders($httpHeader);

        }
        return $this->handleView($view);

    }

    /**
     * Remove devicetype from DB
     *
     * @param Devicetypes $entity
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteDevicetypeAction(Devicetypes $entity)
    {
        $statusCode = 204;
        $out = null;

        if ($entity) {
            try {
                $this->container->get('app.service.devicetype')->removeDeviceType($entity);
            } catch (\Exception $e ) {
                $out = (new BadResult($e->getMessage()))->getResult();
                $statusCode = 409;
            }
        } else {
            $out = (new BadResult('Resource not found'))->getResult();
            $statusCode = 404;
        }
        $view = $this->view($out, $statusCode);
        return $this->handleView($view);
    }

    /**
     * Edit devicetype
     *
     * @param $deviceType Devicetypes
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modifyDevicetypeAction(Devicetypes $deviceType, Request $request)
    {
        $statusCode = 204;
        $out = null;

        $form = $this->createForm(DevicetypesType::class, $deviceType, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if ($deviceType) {
            $this->container->get('app.service.devicetype')->modifyDeviceType($deviceType);
        } else {
            $out = (new BadResult('Resource not found'))->getResult();
            $statusCode = 404;
        }
        $view = $this->view($out, $statusCode);
        return $this->handleView($view);
    }
}
