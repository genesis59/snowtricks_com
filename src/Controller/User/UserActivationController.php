<?php

namespace App\Controller\User;

use App\Entity\Token;
use App\Entity\User;
use App\Repository\TokenRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\UriSigner;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserActivationController extends AbstractController
{
    #[Route('/utilisateur/activation/{token}/{uuidUser}', name: 'app_user_activation')]
    public function __invoke(
        string $token,
        string $uuidUser,
        UserRepository $userRepository,
        TokenRepository $tokenRepository,
        TranslatorInterface $translator,
        UriSigner $uriSigner,
        Request $request
    ): Response {

        if (!$uriSigner->checkRequest($request)) {
            $this->addFlash('danger', $translator->trans('flashes.error.invalid_token', [], 'flashes'));
            return $this->redirectToRoute('home');
        }
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }
        /** @var User $user */
        $user = $userRepository->findOneBy(['uuid' => $uuidUser]);
        /** @var Token $token */
        $token = $tokenRepository->findOneBy(['token' => $token]);
        if ($user == null || $token == null) {
            $this->addFlash('danger', $translator->trans('flashes.error.activation', [], 'flashes'));
            return $this->redirectToRoute('home');
        }

        if ($user->isIsActivated()) {
            $this->addFlash('info', $translator->trans('flashes.error.already_activation', [], 'flashes'));
            return $this->redirectToRoute('home');
        }

        if ($token->getExpiredAt() < (new \DateTimeImmutable())) {
            $this->addFlash('danger', $translator->trans('flashes.error.activation_time', [], 'flashes'));
            return $this->redirectToRoute('app_user_new_activation');
        }
        $userRepository->activate($user);
        $this->addFlash('success', $translator->trans('flashes.success.activation', [], 'flashes'));
        return $this->redirectToRoute('home');
    }
}
