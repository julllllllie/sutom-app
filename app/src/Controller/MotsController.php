<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use App\Entity\Mots;
use App\Entity\EssaiMot;
use Symfony\Component\HttpFoundation\Request;
use App\Form\GameType;
use App\Repository\EssaiMotRepository;
use Doctrine\ORM\EntityManagerInterface; 

class MotsController extends AbstractController
{
    #[Route('/jeu/mot={cell}', name: 'app_mots')]
    public function afficherMot(Request $request, PersistenceManagerRegistry $doctrine, EntityManagerInterface $entityManager, EssaiMotRepository $essaiMotRepository, $cell): Response
    {
        $user = $this->getUser();
        $idu = $user->getId();
        $motRepository = $doctrine->getRepository(Mots::class);
    
        $motEntity = $this->genererMot($motRepository, $cell);
        $motId = $motEntity->getId();
        $mot = $motEntity->getMot();
        $days='30';
        // Obtenez la première lettre du mot
        $premiereLettre = mb_substr($mot, 0, 1, 'UTF-8');
        $longueur = mb_strlen($mot, 'UTF-8');
        $longueurMot = $longueur - 1;
    
        $dateActuelle = new \DateTime();
        $nombreJours = cal_days_in_month(CAL_GREGORIAN, $dateActuelle->format('m'), $dateActuelle->format('Y'));
    
        $calendar = $this->generateCalendar($nombreJours);
    
        $currentDate = new \DateTime();

        // Obtenez l'historique des tentatives pour l'utilisateur et le mot en cours
        $historiqueTentatives = $essaiMotRepository->findBy(['idu' => $idu, 'idMot' => $motId]);
        
        // Création du formulaire
        $form = $this->createForm(GameType::class);

        // soumission du formulaire
        $form->handleRequest($request);

        // Récupère le mot saisi dans le formulaire
        $motSaisi = $request->request->get('mot');

        //j'initialise mes tableaux qui vont me servir pour stocker les informations de mes lettres
        $lettresCorrectes = [];
        $lettresMalPlacees = [];
        $resultat = 0;
        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifiez si le bouton "OK" a été cliqué
            if ($form->get('ok')->isClicked()) {
               // Récupérez le mot du champ 'mot' dans le formulaire
                $motSaisi = $form->get('mot')->getData();
                
              
                // Obtenez le nombre de tentatives actuel (ou initialisez-le à 0)
                $tentative = $essaiMotRepository->count(['mot' => $motSaisi]) + 1;
               
                // Obtenez l'entité Mots associée à $motSaisi (assurez-vous que cette partie est correcte)
                $motEntity = $motRepository->findOneBy(['mot' => $motSaisi]);
                
                // Vérifie si les mots ont la même longueur.
                if (strlen($motSaisi) === strlen($mot)) {
                    // Parcours les lettres et compare les lettres et leur position.
                    $lettresSaisies = str_split($motSaisi);
                    $lettresMot = str_split($mot);

                    
                    foreach ($lettresMot as $index => $lettre) {
                        if ($lettre === $lettresSaisies[$index]) {
                            // La lettre est à la bonne position.
                            $lettresCorrectes[] = $lettre;
                            
                        }elseif (in_array($lettre, $lettresSaisies)) {
                            // La lettre est présente, mais pas à la bonne position.
                            $lettresMalPlacees[] = $lettre;

                            
                        }

                    }
                    // on incrémente le résultat, si il y a aucune differences dans le mot alors resultat à 1: c'est gagné sinon resultat à 0.
                    if ($lettresMot === $lettresSaisies) {
                        // Toutes les lettres sont correctes et à la bonne position.
                        $resultat = 1;
                    } else {
                        // Au moins une lettre est incorrecte ou mal placée.
                        $resultat = 0;
                    }
                }
                // Enregistrez le mot essayé dans la table "EssaiMot" avec le nombre de tentatives et le mot 
                $essaiMot = new EssaiMot();
                $essaiMot->setMot($motSaisi);
                $essaiMot->setTentative($tentative);
                $essaiMot->setResultat($resultat); 
                $essaiMot->setIdMot($motId);
                $essaiMot->setIdu($idu);

                // Enregistrez dans la base de données
                $entityManager->persist($essaiMot);
                $entityManager->flush();

                // Redirige l'utilisateur vers la même page après le traitement du formulaire
            return $this->redirectToRoute('app_mots', ['cell' => $cell]);   
            }
        }
        // Gérez la notation si le formulaire est soumis
        if ($request->isMethod('POST')) {
            $rating = $request->request->get('rating');
            // Enregistrez la notation dans la base de données ou faites toute autre logique nécessaire
        }
return $this->render('mots/index.html.twig', [
    'premiereLettre' => $premiereLettre,
    'mot' => $mot,
    'longueurMot' => $longueurMot,
    'user' => $user,
    'calendar' => $calendar,
    'currentDate' => $currentDate,
    'days' => $days,
    'form' => $form->createView(),
    'historiqueTentatives' => $historiqueTentatives,
    'idu'=> $idu,
    'lettresCorrectes'=>$lettresCorrectes,
    'lettresMalPlacees'=>$lettresMalPlacees,
    'resultat' => $resultat,
    'motId' => $motId,
    'cell' => $cell,
]);
    }
    
    private function genererMot($motRepository, $cell): Mots
    {
        $dateActuelle = new \DateTime();

        // Récupérer le mois et l'année
        $mois = $dateActuelle->format('m'); // Format 'm' donne le mois au format numérique (01 pour janvier, 02 pour février, etc.)
        $annee = $dateActuelle->format('Y');
        $date = new \DateTime("$annee-$mois-$cell");
        // Recherchez le mot associé à la date dans la base de données
        $motEntity = $motRepository->findOneBy(['onlineAt' => $date]);
        // Vérifiez si l'entité est nulle avant de la retourner
        if ($motEntity !== null) {
            return $motEntity;
        } else {
            // Si aucun mot n'est trouvé, utilisez un mot par défaut
            return new Mots();
        }
    }
    
    private function generateCalendar($numberOfKeys)
    {
        // Générer un tableau avec le nombre de jours comme clés
        $calendar = range(1, $numberOfKeys);

        // Diviser le tableau en chunks de 10 éléments par ligne
        $calendar = array_chunk($calendar, 10);

        return $calendar;
    }
    private function isFormSubmittedAndValid(Request $request, string $form): bool
    {
        return $request->isMethod('POST') && $request->request->has($form) && $this->isCsrfTokenValid($form, $request->request->get($form)['_token']);
    }


}



