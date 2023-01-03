<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\UriSigner;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserActivationController extends AbstractController
{
    #[Route('/utilisateur/activation/{token}', name: 'app_user_activation')]
    public function __invoke(
        string $token,
        UserRepository $userRepository,
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
        $user = $userRepository->findOneBy(['activationToken' => $token]);

        if ($user == null) {
            $this->addFlash('danger', $translator->trans('flashes.error.activation', [], 'flashes'));
            return $this->redirectToRoute('home');
        }

        if ($user->isIsActivated()) {
            $this->addFlash('info', $translator->trans('flashes.error.already_activation', [], 'flashes'));
            return $this->redirectToRoute('home');
        }

        if ($user->getActivationTokenCreatedAt()->diff(new \DateTimeImmutable())->days >= 1) {
            $this->addFlash('danger', $translator->trans('flashes.error.activation_time', [], 'flashes'));
            return $this->redirectToRoute('app_user_new_activation');
        }
        $userRepository->activate($user);
        $this->addFlash('success', $translator->trans('flashes.success.activation', [], 'flashes'));
        return $this->redirectToRoute('home');
    }
}
