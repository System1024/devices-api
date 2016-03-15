<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Browser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\BrowserType;

class BrowserClientController extends Controller
{
    /**
     * Add browser to DB
     *
     * @Route("/addbrowser", name="web_addbrowser")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction()
    {
        $form = $this->createForm(BrowserType::class, null);

        return $this->render('default/managebrowser.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Edit browser
     *
     * @Route("/editbrowser/{browser}", name="web_editbrowser")
     *
     * @param Browser $browser
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Browser $browser)
    {
        $form = $this->createForm(BrowserType::class, $browser);

        return $this->render('default/managebrowser.html.twig', [
            'form' => $form->createView(),
            'browser' => $browser
        ]);
    }
}
