<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ArticleController extends AbstractController
{
    private ArticleRepository $articleRepository;

    public function __construct()
    {
        parent::__construct();
        $this->articleRepository = $this->initializeRepository();
    }


    protected function initializeRepository(): ArticleRepository
    {
        return new ArticleRepository();
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function getArticles(): Response
    {
        $articles = $this->articleRepository->getArticlesOrderBy('updated_at', 'DESC');
        $userId = $this->sessionService->getSession('userId');

        return $this->render('pages/article.twig', args: ['articles' => $articles, 'isConnected' => !!$userId]);

    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function getArticleDetails($id): Response
    {
        $article = $this->articleRepository->find($id);

        return $this->render('pages/article_details.twig', args: ['article' => $article]);
    }
}