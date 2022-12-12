<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\ForgottenPasswordType;
use App\Mailer\MailerService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserForgottenPasswordController extends AbstractController
{
    #[Route('/utilisateur/mot-de-passe-oublié', name: 'app_user_forgotten_password')]
    public function __invoke(
        Request $request,
        ManagerRegistry $managerRegistry,
        TokenGeneratorInterface $tokenGenerator,
        MailerService $mailerService,
        TranslatorInterface $translator
    ): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(ForgottenPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $managerRegistry
                ->getRepository(User::class)
                ->findOneBy(['email' => $form->getData()['email']]);

            if ($user == null) {
                $this->addFlash('danger', $translator->trans('snow_trick.flashes.error.forgotten'));
                return $this->redirectToRoute('app_user_forgotten_password');
            }

            $user->setResetToken($tokenGenerator->generateToken());
            $user->setResetTokenCreatedAt(new \DateTimeImmutable());
            $managerRegistry->getManager()->flush();
            $mailerService->sendEmail(
                $translator->trans('snow_trick.email.forgotten.subject'),
                $user,
                'forgotten_password'
            );
            $this->addFlash('success', $translator->trans('snow_trick.flashes.success.forgotten'));
            return $this->redirectToRoute('home');
        }

        return $this->render('user/user_forgotten_password/index.html.twig', [
            'form' => $form->createView(),
            'fix_footer' => true
        ]);
    }
}
