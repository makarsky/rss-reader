<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class BaseController extends AbstractController
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/", name="index")
     * @Route("/{vueRouting}", name="vue_page", requirements={"vueRouting"="^(?!.*_wdt|_profiler|api).+"})
     */
    public function indexAction(): Response
    {
        /** @var User|null $user */
        $user = $this->getUser();
        $data = null;

        if (! empty($user)) {
            $userClone = clone $user;
            $userClone->setPassword('');
            $data = $this->serializer->serialize($userClone, JsonEncoder::FORMAT);
        }

        return $this->render('app.html.twig', [
            'isAuthenticated' => json_encode(!empty($user)),
            'user' => $data ?? json_encode($data),
        ]);
    }
}
