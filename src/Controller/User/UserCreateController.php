<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Event\UserEmailEvent;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use App\UploadService\UploadService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserCreateController extends AbstractController
{
    #[Route('/utilisateur/inscription', name: 'app_user_create')]
    public function __invoke(
        Request $request,
        UserRepository $userRepository,
        TranslatorInterface $translator,
        EventDispatcherInterface $dispatcher,
        UploadService $uploadService
    ): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadService->handleUploadPhoto($user);
            $userRepository->save($user, true);
            $dispatcher->dispatch(new UserEmailEvent($user), UserEmailEvent::ACTIVATION_EMAIL);
            $this->addFlash('success', $translator->trans('flashes.success.register', [], 'flashes'));
            return $this->redirectToRoute('home');
        }

        return $this->render('user/user_create/index.html.twig', [
            'form' => $form->createView(),
            'add_header' => false,
            'fix_footer' => true
        ]);
    }
}
