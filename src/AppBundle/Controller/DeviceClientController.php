<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Device;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\DeviceType;

class DeviceClientController extends Controller
{
    /**
     * Add device
     *
     * @Route("/adddevice", name="web_adddevice")
     */
    public function addDeviceAction()
    {
        $form = $this->createForm(DeviceType::class, null);

        return $this->render('default/newdevice.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/listdevices", name="web_listdevice")
     */
    public function listDeviceAction()
    {
        return $this->redirectToRoute('api_v1_all_device',['_format' => 'html']);
    }

    /**
     * Edit device
     *
     * @Route("/editdevice/{device}", name="web_editdevice")
     *
     * @param Device $device
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editDeviceAction(Device $device)
    {
        $form = $this->createForm(DeviceType::class, $device);

        return $this->render('default/newdevice.html.twig', [
            'form' => $form->createView(),
            'device' => $device
        ]);
    }

}
