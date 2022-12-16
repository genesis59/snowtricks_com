<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\NewActivationFormType;
use App\Mailer\MailerService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserActivationNewController extends AbstractController
{
    #[Route('/utilisateur/nouvelle_activation', name: 'app_user_new_activation')]
    public function __invoke(
        Request $request,
        ManagerRegistry $managerRegistry,
        TokenGeneratorInterface $tokenGenerator,
        TranslatorInterface $translator,
        MailerService $mailerService
    ): Response {

        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(NewActivationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $managerRegistry
                ->getRepository(User::class)
                ->findOneBy(['email' => $form->getData()['email']]);

            if ($user == null || $user->isIsActivated()) {
                $this->addFlash('danger', $translator->trans('error.new_activation', [], 'flashes'));
                return $this->redirectToRoute('app_user_new_activation');
            }

            $user->setActivationToken($tokenGenerator->generateToken());
            $user->setActivationTokenCreatedAt(new \DateTimeImmutable());
            $managerRegistry->getManager()->flush();
            $mailerService->sendEmail(
                $translator->trans('activation.subject', [], 'emails'),
                $user,
                'activation'
            )
            ;
            $this->addFlash('success', $translator->trans('success.new_activation', [], 'flashes'));
            return $this->redirectToRoute('app_login');
        }
        return $this->render('user/user_activation_new/index.html.twig', [
            'form' => $form->createView(),
            'fix_footer' => true
        ]);
    }
}
