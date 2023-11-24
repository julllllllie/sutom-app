<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;



// src/Controller/ProfilController.php

namespace App\Controller;

use App\Form\ModifProfilType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ModifProfilController extends AbstractController
{

    #[Route('/profil/modifier', name: 'profil_modifier')]
    public function modifierProfil(Request $request, PersistenceManagerRegistry $doctrine, Security $security,UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = $security->getUser();

        $form = $this->createForm(ModifProfilType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

            }
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('mots/profil.html.twig', [
            'form' => $form,
            'user'=> $user,
        ]);

        
    }
}
