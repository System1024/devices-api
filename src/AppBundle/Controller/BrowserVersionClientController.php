<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Browserversion;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\BrowserversionType;

class BrowserVersionClientController extends Controller
{

    /**
     * Add browser page
     *
     * @Route("/addbrowserversion", name="web_addbrowserversion")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function addAction()
    {
        $form = $this->createForm(BrowserversionType::class, null);

        return $this->render('default/addbrowserversion.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Show browser versions
     *
     * @Route("/showbrowserversions", name="web_showbrowserversion")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction()
    {
        $browsers = $this->getDoctrine()->getRepository('AppBundle:Browser')->findAll();

        return $this->render('default/newbrowserversion.html.twig', ['browsersList' => $browsers]);
    }

    /**
     * Edit browser versions
     *
     * @Route("/editbrowserversion/{browserVersion}", name="web_editbrowserversion")
     *
     * @param Browserversion $browserVersion
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Browserversion $browserVersion)
    {
        $form = $this->createForm(BrowserversionType::class, $browserVersion);

        return $this->render('default/addbrowserversion.html.twig', [
            'form' => $form->createView()
            ,'browserVersion' => $browserVersion
        ]);
    }
}
