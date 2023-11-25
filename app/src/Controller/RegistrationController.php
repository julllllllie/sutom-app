<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;




class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, PersistenceManagerRegistry $doctrine): Response
    {
        
        $user = new User();
        $user->setAvatar(''); // Initialisation à une chaîne vide par exemple
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // encode le mot de passe
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

                // avatar
                $avatarFile = $form->get('avatar')->getData();

                if ($avatarFile) {
                    // Gérez le stockage de l'avatar
                    $uploadsDirectory = $this->getParameter('kernel.project_dir') . '/public/uploads';
                    $avatarFileName = md5(uniqid()) . '.' . $avatarFile->guessExtension();
                    $avatarFile->move(
                        $uploadsDirectory,
                        $avatarFileName
                    );
    
                    // Mettez à jour le champ d'avatar de l'utilisateur avec le nom du fichier
                    $user->setAvatar($avatarFileName);
                }
                $entityManager = $doctrine->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                
               
                return $this->redirectToRoute('app_login');
            }
        

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}