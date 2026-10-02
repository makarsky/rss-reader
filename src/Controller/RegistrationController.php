<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class RegistrationController
 * @package App\Controller
 */
class RegistrationController extends AbstractController
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * RegistrationController constructor.
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $entityManager
     * @param UserRepository $userRepository
     */
    public function __construct(
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    ) {
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordHasher
     * @return Response
     */
    #[Route('/auth/register', name: 'register')]
    public function registerAction(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return new JsonResponse([], Response::HTTP_OK, []);
        }

        $errors = [];

        foreach ($form->getErrors(true, true) as $formError) {
            $errors[$formError->getOrigin()->getName()] = $formError->getMessage();
        }

        return new JsonResponse(['errors' => $errors], Response::HTTP_OK, []);
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/auth/check-email', name: 'checkEmail')]
    public function checkEmailAction(Request $request): Response
    {
        $email = trim(json_decode($request->getContent(), true)['email']);
        $user = $this->userRepository->findOneBy(['email' => $email]);

        $data = is_null($user) ? [] : [
            'errors' => [
                'email' => 'There is already an account with this email'
            ]
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
