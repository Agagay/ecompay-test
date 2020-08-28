<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class BaseController extends AbstractController
{
    public function getEm()
    {
        return $this->getDoctrine()->getManager();
    }
}