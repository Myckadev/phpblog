<?php

namespace App\Controller;

use App\Entity\Article;
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

        return $this->render('pages/article.twig', args: ['articles' => $articles]);

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

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function postArticle(): Response | RedirectResponse
    {
        try {
            return $this->handleForm(
                validateForm: function () {
                    $postData = $this->requestService->getBody('title', 'description', 'content');

                    if (count(array_diff(['title', 'description', 'content'], array_keys($postData)))) {
                        throw new \Exception('Invalid form', code: 404);
                    } else {
                        return new Article(...['id' => null, 'userId' => $this->sessionService->getSession('userId') , ...$postData]);
                    }
                },
                onSuccess: function ($article) {
                    $this->articleRepository->save($article);

                    return $this->redirect('/');
                },
                csrfToken: $this->requestService->getBody('csrf_token')['csrf_token'],
            );
        } catch (\Exception $e) {
            return $this->render('error.twig', args: ['message' => $e->getMessage()], statusCode: $e->getCode());
        }
    }
}