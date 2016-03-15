<?php

namespace AppBundle\Controller;

use AppBundle\Entity\DeviceBrowser;
use AppBundle\Form\DeviceBrowserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DeviceBrowserClientController extends Controller
{

    /**
     * Page for adding devicebrowser to DB
     *
     * @Route("/adddevicebrowser", name="web_adddevicebrowser")
     */
    public function addDeviceBrowserAction()
    {
        $form = $this->createForm(DeviceBrowserType::class, null, ['method' => 'POST']);

        return $this->render('default/adddevicebrowserslist.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * Page for editing device-browser
     *
     * @Route("/editdevicebrowser/{deviceBrowser}", name="web_editdevicebrowser")
     */
    public function editDeviceBrowserAction(DeviceBrowser $deviceBrowser)
    {
        $form = $this->createForm(DeviceBrowserType::class, $deviceBrowser);

        return $this->render('default/adddevicebrowserslist.html.twig', [
            'form' => $form->createView(),
            'deviceBrowser' => $deviceBrowser
        ]);
    }

}
