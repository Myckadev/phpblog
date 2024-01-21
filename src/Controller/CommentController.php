<?php

namespace App\Controller;

use App\Repository\CommentRepository;

class CommentController extends AbstractController
{

    private CommentRepository $commentRepository;

    public function __construct()
    {
        parent::__construct();
        $this->commentRepository = $this->initializeRepository();
    }

    protected function initializeRepository(): CommentRepository
    {
        return new CommentRepository();
    }


}