<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomepageController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository,
    )
    {
    }

    #[Route('/', name: 'homepage_index')]
    public function index(): Response
    {
        return $this->render(
            'homepage/index.html.twig',
            ['userList' => $this->getUser() ? $this->userRepository->findAll() : []],
        );
    }
}
