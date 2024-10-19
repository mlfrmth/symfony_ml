<?php

namespace App\Controller;

use App\Event\UserRegisteredEvent;
use Symfony\Component\HttpFoundation\{
    Request,
    Response
};
use App\Form\User\{
    LoginFormType,
    RegistrationFormType
};
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormError;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class UserController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface   $entityManager,
        private readonly UserRepository           $userRepository,
        private readonly EventDispatcherInterface $dispatcher
    )
    {
    }

    #[Route('/user/dashboard', name: 'user_index')]
    public function index(): Response
    {
        return $this->render('auth/index.html.twig');
    }

    #[Route('/user/login', name: 'user_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('homepage_index');
        }

        $user = new User();
        $form = $this->createForm(LoginFormType::class, $user);

        return $this->render('user/login.html.twig', [
            'loginForm' => $form->createView(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    #[Route('/user/register', name: 'user_register')]
    public function register(Request $request): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('homepage_index');
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);

        // TODO: custom validator?
        if ($form->isSubmitted() && $form->isValid()) {
            $emailExist = $this->userRepository->findOneBy(['email' => $user->getEmail()]);

            if ($emailExist)
                $form->get('email')->addError(new FormError('The email is already in use.'));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->dispatcher->dispatch(
                new UserRegisteredEvent($user),
                UserRegisteredEvent::NAME
            );

            return $this->redirectToRoute('user_login');
        }

        return $this->render('user/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/user/logout', name: 'user_logout')]
    public function logout(): void
    {

    }
}
