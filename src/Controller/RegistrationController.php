<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
     * RegistrationController constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/auth/register", name="register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return new JsonResponse([], Response::HTTP_OK, []);
        }

        $errors = [];

        foreach ($form->getErrors(true, true) as $formError) {
            $errors[$formError->getOrigin()->getName()] = $formError->getMessage();
        }

        return new JsonResponse(['errors' => $errors], Response::HTTP_OK, []);
    }

    /**
     * @Route("/auth/check-email", name="checkEmail")
     * @param Request $request
     * @return Response
     */
    public function checkEmailAction(Request $request): Response
    {
        $email = trim(json_decode($request->getContent(), true)['email']);
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);

        $data = is_null($user) ? [] : [
            'errors' => [
                'email' => 'There is already an account with this email'
            ]
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
