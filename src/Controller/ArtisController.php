<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Artiste;
use App\Entity\Oeuvre;
use App\Form\ArtisteType;
use App\Form\OeuvType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
//use App\OeuvreRepository;

class ArtisController extends AbstractController
{
    #[Route('/artis', name: 'app_artis')]
    public function index(): Response
    {
        return $this->render('artis/index.html.twig', [
            'controller_name' => 'ArtisController',
        ]);
    }



     #[Route('/ajouterartis', name: 'app_ajouterartis')]
    public function ajouterartiste(Request $request,ManagerRegistry $doctrine): Response
    {
        $artistes= new Artiste();
        $form=$this->createform(ArtisteType::class,$artistes);
        $form->handleRequest($request);
        
        if($form -> isSubmitted()){
        $em=$doctrine->getManager();
        $em->persist($artistes);
        $em->flush();
        return $this->redirectToRoute('app_artisListe');
       }
        return $this->render('artis/Ajouterartis.html.twig', [
            'controller_name' => 'ArtisController',
            'f' => $form->createview(),
        ]);
    }



    #[Route('/artisList', name: 'app_artisListe')]
    public function afficheartiste(ManagerRegistry $doctrine): Response
    {
        $artistes=$doctrine->getRepository(Artiste::class)->findAll();
        return $this->render('artis/Listeartiste.html.twig', [
            'controller_name' => 'ArtisController',
            'artistes'=>$artistes
        ]);
    }

    #[Route('/supp/{id}', name:'S')]
    public function Delete($id,ManagerRegistry $doctrine): Response
    {
        $artist=$doctrine->getRepository(Artiste::class)->find($id);
        $em=$doctrine->getManager();
        $em->remove($artist);
        $em->flush();
        return $this->redirectToRoute('app_artisListe');
         
    }

    #[Route('/Detailsartist/{id}', name: 'D')]
    public function Detailsartiste($id,ManagerRegistry $doctrine): Response
    {
        $artist=$doctrine->getRepository(Artiste::class)->find($id);
        return $this->render('artis/Detailsartistes.html.twig', [
            'controller_name' => 'ArtisController',
            'artist'=>$artist
        ]);
    }


    #[Route('/ajouteroeuvre', name: 'app_ajouteroeuv')]
    public function ajouteroeuvre(Request $request,ManagerRegistry $doctrine): Response
    {
        $oeuvre= new Oeuvre();
        $form=$this->createform(OeuvType::class,$oeuvre);
        $form->handleRequest($request);
        
        if($form -> isSubmitted()){
        $em=$doctrine->getManager();
        $em->persist($oeuvre);
        $em->flush();
        //return $this->redirectToRoute(route:'L');
       }
        return $this->render('artis/Ajouteroeuvr.html.twig', [
            'controller_name' => 'ArtisController',
            'f' => $form->createview(),
        ]);
    }


#[Route('/liste2/{id}', name: 'L')]
    public function ListeOeuvr(ManagerRegistry $doctrine,$id): Response
    {
        $artistes=$doctrine->getRepository(Artiste::class)->jointureOuvre($id);
        return $this->render('artis/listeOuvresartiste.html.twig', [
            'controller_name' => 'ArtisController',
            'artistes'=>$artistes
        ]);
    }

      #[Route('/nbr/{id}', name: 'N')]
    public function nombre(ManagerRegistry $doctrine,$id): Response
    {
        $nbrOa=$doctrine->getRepository(Artiste::class)->nbrartis($id);
        return $this->render('artis/nombres.html.twig', [
            'controller_name' => 'ArtisController',
            'nbrOa'=>$nbrOa
        ]);
    }

}
