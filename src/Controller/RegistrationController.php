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
use App\Form\ForgotPasswordFormType;
use App\Form\ResetPasswordFormType;


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
                ->subject('Welcome to Tuniscape - Please Verify Your Email')
                ->html("
        <div style=\"font-family: Arial, sans-serif; max-width: 600px;\">
            <h1 style=\"font-size: 24px; color: #333;\">Hello and welcome to Tuniscape!</h1>
            <p style=\"font-size: 16px; color: #555; line-height: 1.5;\">
                We're excited to have you on board as you embark on an incredible journey to discover the rich culture, history, and breathtaking landscapes that Tunisia has to offer.
            </p>
            <p style=\"font-size: 16px; color: #555; line-height: 1.5;\">
                Before we get started, please take a moment to confirm your email address by clicking on the link below:
            </p>
            <p>
                <a href=\"https://localhost:8000/register/verify/{$verficationCode}\" style=\"background-color: #1E90FF; color: #ffffff; text-decoration: none; padding: 10px 20px; border-radius: 5px; font-size: 16px;\">Verify My Email</a>
            </p>
            <p style=\"font-size: 16px; color: #555; line-height: 1.5;\">
                By verifying your email, you'll be able to stay updated on our latest offerings, exclusive promotions, and personalized recommendations to make your Tuniscape experience unforgettable.
            </p>
            <p style=\"font-size: 16px; color: #555; line-height: 1.5;\">
                Once again, welcome to the Tuniscape family. We look forward to helping you create lasting memories in Tunisia!
            </p>
            <p style=\"font-size: 16px; color: #555; line-height: 1.5;\">
                Warm regards,
            </p>
            <p style=\"font-size: 16px; color: #555; line-height: 1.5;\">
                The Tuniscape Team
            </p>
        </div>
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
    #[Route('/forgot-password', name: 'app_forgot_password')]
    public function forgotPassword(
        Request $request,
        EntityManagerInterface $entityManager,

    ): Response {

        $form = $this->createForm(ForgotPasswordFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

            if ($user) {
                // Generate a verification code
                $verificationCode = random_int(100000, 999999);
                $user->setVerficationCode($verificationCode);
                $username=$user->getUsername();
                $entityManager->flush();

                // Send the password reset email
                $email = (new Email())
                    ->from(new Address('tuniscape@gmail.com', 'Tuniscape'))
                    ->to($user->getEmail())
                    ->subject('Password Reset Request')
                    ->html("
                    <h1>Hi! You requested a password reset.</h1>
                    <p>
                        Hello {$username}
                        To reset your password, click the following link: <br><br>
                        <a href=\"https://localhost:8000/reset-password/{$verificationCode}\">Reset my Password</a>.
                    </p>
                    <p>
                        If you didn't request a password reset, please ignore this email.
                    </p>
                ");
                $dsn = 'smtp://tuniscape%40gmail.com:aezaetrfsezujwpt@smtp.gmail.com:587';
                $transport = Transport::fromDsn($dsn);
                $mailer = new Mailer($transport);
                $mailer->send($email);

                $this->addFlash('success', 'A password reset link has been sent to your email.');
            } else {
                $this->addFlash('error', 'No user found with this email address.');
            }

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/forgot_password.html.twig', [
            'forgotPasswordForm' => $form->createView(),
        ]);
    }
    #[Route('/reset-password/{code}', name: 'app_reset_password')]
    public function resetPassword(
        string $code,
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $userPasswordHasher
    ): Response {
        $user = $entityManager->getRepository(User::class)->findOneBy(['verficationCode' => $code]);

        if ($user) {
            if(!$user->isIsVerified())
            {
                $this->verifyUserEmail($code,$entityManager);

            }
            $form = $this->createForm(ResetPasswordFormType::class);
            $form->handleRequest($request);


            if ($form->isSubmitted() && $form->isValid()) {

                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

                // Clear the verification code
                $user->setVerficationCode(null);

                $entityManager->flush();

                $this->addFlash('success', 'Your password has been reset.');

                return $this->redirectToRoute('app_login');
            }
        } else {
            $this->addFlash('error', 'Invalid verification code.');

            return $this->redirectToRoute('app_forgot_password');
        }
        return $this->render('registration/reset_password.html.twig', [
            'resetPasswordForm' => $form->createView()
        ]);
    }
}

