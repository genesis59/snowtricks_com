<?php

namespace App\Controller\User;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserActivationController extends AbstractController
{
    #[Route('/utilisateur/activation/{token}', name: 'app_user_activation')]
    public function __invoke(
        string $token,
        ManagerRegistry $managerRegistry,
        TranslatorInterface $translator
    ): Response {

        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        /** @var User $user */
        $user = $managerRegistry->getManager()
            ->getRepository(User::class)
            ->findOneBy(['activationToken' => $token]);

        if ($user == null) {
            $this->addFlash('danger', $translator->trans('snow_trick.flashes.error.activation'));
            return $this->redirectToRoute('home');
        }

        if ($user->getActivationTokenCreatedAt()->diff(new \DateTimeImmutable())->days >= 1) {
            $this->addFlash('danger', $translator->trans('snow_trick.flashes.error.activation_time'));
            return $this->redirectToRoute('app_user_new_activation');
        }

        $user->setIsActivated(true);
        $managerRegistry->getManager()->flush();
        $this->addFlash('success', $translator->trans('snow_trick.flashes.success.activation'));
        return $this->redirectToRoute('app_login');
    }
}
