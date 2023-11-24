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
                

                $avatarFile = $form->get('avatar')->getData();

                if ($avatarFile) {
                    // Gérez le stockage de l'avatar
                    $uploadsDirectory = $this->getParameter('kernel.project_dir') . '/public/uploads';
                    $avatarFileName = md5(uniqid()) . '.' . $avatarFile->guessExtension();
                    $avatarFile->move($uploadsDirectory, $avatarFileName);

                    dump($uploadsDirectory . '/' . $avatarFileName);
                    // Mettez à jour le champ d'avatar de l'utilisateur avec le nom du fichier
                    $user->setAvatar($avatarFileName);
                    $entityManager->persist($user);
                    $entityManager->flush();

                }

               
                
                $entityManager = $doctrine->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('app_mots');
            }
        

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
