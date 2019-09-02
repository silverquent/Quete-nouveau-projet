<?php
// src/Controller/BlogController.php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class BlogController extends AbstractController
{

    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();
        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }
        return $this->render(
            'index.html.twig',
            ['articles' => $articles]
        );
    }


    /**
     * Getting a article with a formatted slug for title
     *
     * @param string $slug The slugger
     *
     * @Route("/show/{slug<^[a-z0-9-]+$>}",
     *     defaults={"slug" = null},
     *     name="show")
     * @return Response
     */


    public function show(?string $slug): Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ',
            ucwords(trim(strip_tags($slug)), "-")
        );
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        if (!$article) {
            throw $this->createNotFoundException(
                'No article with ' . $slug . ' title, found in article\'s table.'
            );
        }
        return $this->render(
            'show.html.twig',
            [
                'article' => $article,
                'slug' => $slug
            ]
        );
    }
/*
    /**
     * @Route("/category/{categoryName}",
     *          methods={"GET"},
     *          name="show_category")
     */
/*
    public function showByCategory(string $categoryName) : Response
    {
        if (!$categoryName) {
            throw $this
                ->createNotFoundException('No category\'s name has been sent to find articles in article\'s table.');
        }

        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneByName($categoryName);

        $limit=3;
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findByCategory($category,['id' => 'DESC'], $limit);
        return $this->render('category.html.twig', ['articles' => $articles,'category' => $category,]
        );
    }
*/

    /**
     * @Route("/category/{name}", name="show_category")
     * @param Category $category
     * @return Response
     */
    //on récupére  les articles d’une catégorie en utilisant  $category->getArticles().

    public function showByCategory(Category $category): Response
    {
        if (!$category) {
            throw $this
                ->createNotFoundException('No category has been sent to find a category in article\'s table.');
        }
        $articles = $category->getArticles();
        return $this->render('category.html.twig', ['articles' => $articles, 'category' => $category]);
    }



}