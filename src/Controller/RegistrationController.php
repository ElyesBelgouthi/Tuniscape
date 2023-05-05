<?php


namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Mailer\MailerInterface;


class RegistrationController extends AbstractController
{
    /**
     * @throws \Exception
     */
    #[Route('/register', name: 'app_register')]
    public function register(
        Request                     $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface  $userAuthenticator,
        LoginAuthenticator $authenticator,
        EntityManagerInterface      $entityManager,
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // Generate a verification code
            $verficationCode = random_int(100000, 999999);
            $user->setVerficationCode($verficationCode);

            $entityManager->persist($user);
            $entityManager->flush();
            $dsn = 'smtp://tuniscape%40gmail.com:aezaetrfsezujwpt@smtp.gmail.com:587';
            $transport = Transport::fromDsn($dsn);
            $mailer = new Mailer($transport);
            // Create a new Email instance
            $email = (new Email())
                ->from(new Address('tuniscape@gmail.com', 'Tuniscape'))
                ->to($user->getEmail())
                ->subject('Please Confirm your Email')
                ->html("
                    <h1>Hi! Please confirm your email!</h1>
                    <p>
                        Please confirm your email address by clicking the following link: <br><br>
                        <a href=\"https://localhost:8000/register/verify/{$verficationCode}\">Confirm my Email</a>.
                    </p>
                    <p>
                        Cheers!
                    </p>
                ");

            // Send the email
            $mailer->send($email);

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/register/verify/{code}', name: 'app_verify_email')]
    public function verifyUserEmail(
        string                 $code,
        EntityManagerInterface $entityManager
    ): Response
    {
        $user = $entityManager->getRepository(User::class)->findOneBy(['verficationCode' => $code]);

        if ($user) {
            $user->setIsVerified(true);
            $user->setVerficationCode(null);
            $entityManager->flush();

            $this->addFlash('success', 'Your email address has been verified.');

            return $this->redirectToRoute('app_home');
        } else {
            $this->addFlash('error', 'Invalid verfication code.');

            return $this->redirectToRoute('app_register');
        }
    }
}

