<?php

namespace App\Controller;

use App\Form\LikeNoteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Notes;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class LikeNoteController extends AbstractController
{
    #[Route('/resultat/{cell}', name:'result_mots')]
    public function show(Request $request, PersistenceManagerRegistry $doctrine, $cell): Response
    {
        $user = $this->getUser();
        $idu = $user->getId();
        $form = $this->createForm(LikeNoteType::class);

        $form->handleRequest($request);
        $rating = $form->get('rating')->getData();
        $liked = $form->get('liked')->getData();

    if ($form->isSubmitted() && $form->isValid()) {
        // Associez la note au mot
        $note = new Notes();
        $note->setNote($rating);
        $note->setAime($liked);
        $note->setIdu($idu);

        // Enregistrez la note dans la base de données
        $entityManager = $doctrine->getManager();
        $entityManager->persist($note);
        $entityManager->flush();
        
    }
    return $this->redirectToRoute('app_mots', ['cell' => $cell]);
    }
}