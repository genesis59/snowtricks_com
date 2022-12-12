<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\ResetPasswordType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserResetPasswordController extends AbstractController
{
    #[Route('/utilisateur/reinitialisation-password/{token}', name: 'app_user_reset_password')]
    public function __invoke(
        string $token,
        Request $request,
        ManagerRegistry $managerRegistry,
        TranslatorInterface $translator,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $user = $managerRegistry
            ->getRepository(User::class)
            ->findOneBy(['resetToken' => $token]);
        if ($user === null) {
            $this->addFlash('danger', $translator->trans('snow_trick.flashes.error.reset'));
            return $this->redirectToRoute('home');
        }
        if ($user->getResetTokenCreatedAt()->diff(new \DateTimeImmutable())->days >= 1) {
            $this->addFlash('danger', $translator->trans('snow_trick.flashes.error.forgotten_time'));
            return $this->redirectToRoute('app_login');
        }
        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordHasher->hashPassword($user, $form->getData()->getPassword()));
            $managerRegistry->getManager()->flush();
            $this->addFlash('success', $translator->trans('snow_trick.flashes.success.reset'));
            return $this->redirectToRoute('app_login');
        }
        return $this->render('user/user_reset_password/index.html.twig', [
            'form' => $form->createView(),
            'fix_footer' => true
        ]);
    }
}
