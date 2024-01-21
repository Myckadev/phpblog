<?php

namespace App\Controller;

use App\Repository\ArticleRepository;

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
}