<?php

// src/Controller/BlogController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class BlogController extends AbstractController
{

    /**
     * @Route("/blog/list/{page}", name="blog_list")
     */

    public function list($page)
    {
        return $this->render('/list.html.twig', ['page' => $page]);
    }

    /**
     * @Route("/blog/show/{slug}", requirements={"slug"="[a-z0-9\-]+"} , defaults={"slug"="article-sans-titre"}, name="blog_slug")
     *
     */

    public function show($slug)
    {

        $slug = ucwords(str_replace('-', ' ', $slug) );



        return $this->render('/show.html.twig' ,  ['slug' => $slug]);
    }


}