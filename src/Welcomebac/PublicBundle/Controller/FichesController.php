<?php

namespace Welcomebac\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Welcomebac\StatistiquesBundle\Entity\Statistique;

class FichesController extends Controller {

    /**
     * Listing de toutes les fiches par Serie
     */
    public function toutesAction() {
        // Gestion du cache
        $response = new Response();
        $response->setSharedMaxAge($this->container->getParameter('cacheTimeRessources'));
        if ($response->isNotModified($this->getRequest())) {
            return $response;
        } 
        
        //Recupere les matieres de chaque serie
        $em = $this->getDoctrine()->getEntityManager();
        $matieresS = $em->getRepository('WelcomebacEntitesBundle:Matiere')
                ->findAllHavingFiches('S');
        $matieresES = $em->getRepository('WelcomebacEntitesBundle:Matiere')
                ->findAllHavingFiches('ES');
        $matieresL = $em->getRepository('WelcomebacEntitesBundle:Matiere')
                ->findAllHavingFiches('L');

        return $this->render('WelcomebacPublicBundle:Fiches:toutes.html.twig', array("matieresS" => $matieresS,
                    "matieresES" => $matieresES,
                    "matieresL" => $matieresL), $response);
    }

    /**
     * Listing des fiches par matieres
     */
    public function serieMatiereAction($serie, $matiere) {
        $response = new Response();
        
        //Redirection suite a l'erreur de E au lieu de ES
        if ($serie == 'E') {
            return $this->redirect($this->generateUrl('WelcomebacPublicBundle_fichesSerieMatiere', array('serie' => 'ES', 'matiere' => $matiere)), 301);
        }

        //Recuperer la matiere
        $repositoryMatiere = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Matiere');
        $matiere = $repositoryMatiere->findOneBy(array('serie' => $serie, 'url' => $matiere));
        if (!$matiere) {
            throw $this->createNotFoundException("La liste des fiches par serie et matiere est introuvable");
        }

        // Settage du cookie et de la session pour conserver la serie de l'utilisateur
        $this->get('session')->set('serie', $serie);
        $response->headers->setCookie(new Cookie('serie', $serie, time() + 3600 * 24 * 30));

        // Gestion du cache
        // !! apr?s le settage du cookie et session pour la serie
        $response->setSharedMaxAge($this->container->getParameter('cacheTimeRessources'));
        if ($response->isNotModified($this->getRequest())) {
            return $response;
        }     
        
        //Affichage de la pub diplomeo selon les serie
        $pub = (in_array($matiere->getId(), array(1, 15, 6, 10))) ? true : false;

        return $this->render('WelcomebacPublicBundle:Fiches:serieMatiere.html.twig', array("matiere" => $matiere, "pub" => $pub), $response);
    }

    /**
     * Page fiche
     * @internal Pas de gestion du cache ? cause des favoris
     */
    public function ficheAction(Request $request, $matiere, $titre, $serie) {
        $response = new Response();
        
        //Redirection du a l'erreur sur E => ES    	
        if ($serie == 'E') {
            return $this->redirect($this->generateUrl('WelcomebacPublicBundle_fiche', array('serie' => 'ES', 'matiere' => $matiere, 'titre' => $titre)), 301);
        }

        //Recuperation de la matiere
        $em = $this->getDoctrine()->getEntityManager();
        $repositoryMatiere = $em->getRepository('WelcomebacEntitesBundle:Matiere');
        $matiere = $repositoryMatiere->findOneBy(array('url' => $matiere, 'serie' => $serie));
        if (!$matiere) {
            throw $this->createNotFoundException("La ressource demand&eacute;e n'existe pas");
        }

        // Settage du cookie et de la session pour conserver la serie de l'utilisateur
        $this->get('session')->set('serie', $serie);
        $response->headers->setCookie(new Cookie('serie', $serie, time() + 3600 * 24 * 30));

        //Recuperation de la fiche
        $repositoryFiche = $em->getRepository('WelcomebacEntitesBundle:Fiche');
        $fiche = $repositoryFiche->findOneBy(array('url' => $titre, 'matiere' => $matiere->getId()));
        if (!$fiche) {
            throw $this->createNotFoundException("La ressource demand&eacute;e n'existe pas");
        }

        //Mise a jour du nombre de visite
        $fiche->setNombreVisites($fiche->getNombreVisites() + 1);
        $em->flush();

        //Determine si la fiche est un favori de l'utilisateur
        $favori = false;
        $utilisateur = $this->get('session')->has('utilisateur');
        if ($utilisateur && ($utilisateur = $this->get('session')->get('utilisateur'))) {
            $repositoryFavori = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Favori');
            $favori = $repositoryFavori->findOneBy(array('id_element' => $fiche->getId(), 'utilisateur' => $utilisateur, 'type' => 'f'));
        }
        
        //recuperation des notes
        $repositoryStats = $this->getDoctrine()->getRepository('WelcomebacStatistiquesBundle:Statistique');
        $notation = $repositoryStats->getNotation($fiche);

        return $this->render('WelcomebacPublicBundle:Fiches:fiche.html.twig', array("fiche" => $fiche, 'favori' => $favori, 'note' => $notation['note'], 'votes'=> $notation['votes']), $response);
    }

    /**
     * PDF de la fiche
     */
    public function fichePdfAction(Request $request, $serie, $matiere, $titre) {
        $response = new Response();
        
        //Recuperation de la fiche
        $em = $this->getDoctrine()->getEntityManager();
        $repositoryMatiere = $em->getRepository('WelcomebacEntitesBundle:Matiere');
        $matiere = $repositoryMatiere->findOneBy(array('url' => $matiere, 'serie' => $serie));
        if (!$matiere) {
            throw $this->createNotFoundException("La ressource demand&eacute;e n'existe pas 'matiere'");
        }

        // Settage du cookie et de la session pour conserver la serie de l'utilisateur
        $this->get('session')->set('serie', $matiere->getSerie());
        $response->headers->setCookie(new Cookie('serie', $matiere->getSerie(), time() + 3600 * 24 * 30));

        //Recuperation de la fiche
        $repositoryFiche = $em->getRepository('WelcomebacEntitesBundle:Fiche');
        $fiche = $repositoryFiche->findOneBy(array('url' => $titre, 'matiere' => $matiere->getId()));
        if (!$fiche) {
            throw $this->createNotFoundException("La ressource demand&eacute;e n'existe pas 'fiche'");
        }
        
        //Statistiques
        if ($request->headers->get('referer') != "") {
            $statistique = new Statistique();
            $statistique->setDescription('FichesController');
            $statistique->setReferrer($request->headers->get('referer'));
            $statistique->setUrl($request->getUri());
            $statistique->setSessionId($this->get('session')->getId());
            $statistique->setDate(new \DateTime());
            $statistique->setCampagne('Acces pdf|Fiche');
            $statistique->setIdElement($fiche->getId());
            $statistique->setIp($request->getClientIp());
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($statistique);
            $em->flush();
        }

        // Gestion du cache
        // !! apr?s le settage du cookie et session pour la serie et apr?s les stats
        $response->setSharedMaxAge($this->container->getParameter('cacheTimeRessources'));
        if ($response->isNotModified($this->getRequest())) {
            return $response;
        }  

        //Renvoi du fichier pdf
        $filename = $this->container->getParameter('dossierFiches') . "/" . $fiche->getIdWb() . ".pdf";
        if (file_exists($filename)) {
            $response->setStatusCode(200);
            $response->headers->set('Content-Type', 'application/pdf');
            $response->headers->set('Content-Length', filesize($filename));
            $response->send();
            readfile($filename);
            return $response;
        }
        throw $this->createNotFoundException("La ressource demand&eacute;e n'existe pas '.pdf'");
    }


    /**
     * Menu des fiches : listing series, mati?res et les fiches les plus consultées
     */
    public function menuAction($serie) {

        // Gestion du cache
        $response = new Response();
        $response->setPublic();
        $response->setSharedMaxAge($this->container->getParameter('cacheTimeRessources'));
        if ($response->isNotModified($this->getRequest())) {
            return $response;
        }

        //Recuperer toutes les matieres de la serie
        $em = $this->getDoctrine()->getEntityManager();
        $matieres = $em->getRepository('WelcomebacEntitesBundle:Matiere')
                ->findAllHavingFiches($serie);

        return $this->render('WelcomebacPublicBundle:Fiches:menu.html.twig', array("matieres" => $matieres), $response);
    }
    /*
     *
     * 					REDIRECTIONS
     *
     */

    public function fichePdf_oldAction(Request $request, $id) {
        //Recuperation de la fiche
        $em = $this->getDoctrine()->getEntityManager();
        $repositoryFiche = $em->getRepository('WelcomebacEntitesBundle:Fiche');
        $fiche = $repositoryFiche->findOneBy(array('id_wb' => $id));

        if (!$fiche) {
            throw $this->createNotFoundException("La ressource demand&eacute;e n'existe pas");
        }
        return $this->redirect($this->generateUrl('WelcomebacPublicBundle_fichePdf', array('serie' => $fiche->getMatiere()->getSerie(), 'matiere' => $fiche->getMatiere()->getUrl(), 'titre' => $fiche->getUrl())), 301);
    }

}
