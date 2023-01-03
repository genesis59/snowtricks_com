<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\UriSigner;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserResetPasswordController extends AbstractController
{
    #[Route('/utilisateur/reinitialisation-password/{token}', name: 'app_user_reset_password')]
    public function __invoke(
        string $token,
        Request $request,
        UserRepository $userRepository,
        TranslatorInterface $translator,
        UserPasswordHasherInterface $passwordHasher,
        UriSigner $uriSigner
    ): Response {

        if (!$uriSigner->checkRequest($request)) {
            $this->addFlash('danger', $translator->trans('flashes.error.invalid_token', [], 'flashes'));
            return $this->redirectToRoute('home');
        }
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $user = $userRepository->findOneBy(['resetToken' => $token]);
        if ($user === null) {
            $this->addFlash('danger', $translator->trans('flashes.error.reset', [], 'flashes'));
            return $this->redirectToRoute('home');
        }
        if ($user->getResetTokenCreatedAt()->diff(new \DateTimeImmutable())->days >= 1) {
            $this->addFlash('danger', $translator->trans('flashes.error.forgotten_time', [], 'flashes'));
            return $this->redirectToRoute('app_user_forgotten_password');
        }
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->upgradePassword($user, $passwordHasher->hashPassword($user, $form->getData()['password']));
            $this->addFlash('success', $translator->trans('flashes.success.reset', [], 'flashes'));
            return $this->redirectToRoute('home');
        }
        return $this->render('user/user_reset_password/index.html.twig', [
            'form' => $form->createView(),
            'add_header' => false,
            'fix_footer' => true
        ]);
    }
}
