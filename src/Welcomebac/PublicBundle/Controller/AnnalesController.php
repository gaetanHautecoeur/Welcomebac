<?php

namespace Welcomebac\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\HttpFoundation\Cookie;
use Welcomebac\StatistiquesBundle\Entity\Statistique;

class AnnalesController extends Controller {

    /**
     * Listing de toutes les annales par Serie
     */
    public function toutesAction() {
        // Gestion du cache en publique
        $response = new Response();
        $response->setSharedMaxAge($this->container->getParameter('cacheTimeRessources'));
        if ($response->isNotModified($this->getRequest())) {
            return $response;
        } 
        
        //Recupere les matieres de chaque serie
        $em = $this->getDoctrine()->getEntityManager();
        $matieresS = $em->getRepository('WelcomebacEntitesBundle:Matiere')
                ->findAllHavingAnnales('S');
        $matieresE = $em->getRepository('WelcomebacEntitesBundle:Matiere')
                ->findAllHavingAnnales('ES');
        $matieresL = $em->getRepository('WelcomebacEntitesBundle:Matiere')
                ->findAllHavingAnnales('L');

        return $this->render('WelcomebacPublicBundle:Annales:toutes.html.twig', array("matieresS" => $matieresS,
                    "matieresES" => $matieresE,
                    "matieresL" => $matieresL,), $response);
    }


    /**
     * Listing des mati?res ayant des annales d'une serie
     */
    public function serieAction($serie) {
        $response = new Response();
        
        //Recherche des matieres ayant des annales
        $em = $this->getDoctrine()->getEntityManager();
        $matieres = $em->getRepository('WelcomebacEntitesBundle:Matiere')
                ->findAllHavingAnnales($serie);
        if (!$matieres) {
            throw $this->createNotFoundException("La liste des annales par serie est introuvable");
        }
        
        // Settage du cookie et de la session pour conserver la serie de l'utilisateur
        $response->headers->setCookie(new Cookie('serie', $serie, time() + 3600 * 24 * 30));
        $this->get('session')->set('serie', $serie);
        
        // Gestion du cache en publique
        // !! apr?s le settage du cookie et session pour la serie
        $response->setSharedMaxAge($this->container->getParameter('cacheTimeRessources'));
        if ($response->isNotModified($this->getRequest())) {
            return $response;
        } 

        return $this->render('WelcomebacPublicBundle:Annales:serie.html.twig', array("matieres" => $matieres), $response);
    }

    /**
     * Surchage avec l'année de l'action de listing des annales par matiere
     */
    public function serieMatiereAnneeAction($serie, $matiere, $annee) {
        //redirection du a l'erreur sur E au lieu de ES
        if ($serie == 'E') {
            return $this->redirect($this->generateUrl('WelcomebacPublicBundle_annalesSerieMatiereAnnee', array('serie' => 'ES', 'matiere' => $matiere, 'annee' => $annee)), 301);
        }

        return $this->serieMatiereAction($serie, $matiere, array("search" => $annee));
    }

    /**
     * Listing des annales par matieres
     */
    public function serieMatiereAction($serie, $matiere, $options = array()) {
        $response = new Response();
        
        //redirection du a l'erreur sur E au lieu de ES
        if ($serie == 'E') {
            return $this->redirect($this->generateUrl('WelcomebacPublicBundle_annalesSerieMatiere', array('serie' => 'ES', 'matiere' => $matiere)), 301);
        }

        //Recherche de la matiere
        $repositoryMatiere = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Matiere');
        $matiere = $repositoryMatiere->findOneBy(array('serie' => $serie, 'url' => $matiere));
        if (!$matiere) {
            throw $this->createNotFoundException("La liste des annales par serie et matiere est introuvable");
        }
        
        // Settage du cookie et de la session pour conserver la serie de l'utilisateur
        $response->headers->setCookie(new Cookie('serie', $serie, time() + 3600 * 24 * 30));
        $this->get('session')->set('serie', $serie);
        
        // Gestion du cache en publique
        // !! apr?s le settage du cookie et session pour la serie
        $response->setSharedMaxAge($this->container->getParameter('cacheTimeRessources'));
        if ($response->isNotModified($this->getRequest())) {
            return $response;
        } 
        
        //Recherche de l'annale
        $repositoryAnnale = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Annale');
        $annales = $repositoryAnnale->findBy(
                array('matiere' => $matiere->getId()), array('date' => 'DESC')
        );
        
        if (!$annales) {
            throw $this->createNotFoundException("La liste des annales par serie et matiere est introuvable");
        }
        
        return $this->render('WelcomebacPublicBundle:Annales:serieMatiere.html.twig', array("search" => ((isset($options['search'])) ? $options['search'] : ''), "matiere" => $matiere, "annales" => $annales), $response);
    }

    /**
     * PDF de l'annale
     */
    public function annalePdfAction(Request $request, $serie, $matiere, $lieu, $annee) {
        $response = new Response();
        
        //recuperer la matiere
        $repositoryMatiere = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Matiere');
        $matiere = $repositoryMatiere->findOneBy(array('serie' => $serie, 'url' => $matiere));
        if (!$matiere) {
            throw $this->createNotFoundException("La ressource demand&eacute;e n'existe pas");
        }

        // Settage du cookie et de la session pour conserver la serie de l'utilisateur
        $this->get('session')->set('serie', $matiere->getSerie());
        $response->headers->setCookie(new Cookie('serie', $matiere->getSerie(), time() + 3600 * 24 * 30));

        //Recuperer l'annale
        $repositoryAnnale = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Annale');
        $annale = $repositoryAnnale->findOneBy(
                array(
            'matiere' => $matiere->getId(),
            'lieu_url' => $lieu,
            'date' => $annee), null, 1
        );
        if (!$annale) {
            throw $this->createNotFoundException("La ressource demand&eacute;e n'existe pas");
        }

        //Statistiques
        if ($request->headers->get('referer') != "") {
            $statistique = new Statistique();
            $statistique->setDescription('AnnalesController');
            $statistique->setReferrer($request->headers->get('referer'));
            $statistique->setUrl($request->getUri());
            $statistique->setSessionId($this->get('session')->getId());
            $statistique->setDate(new \DateTime());
            $statistique->setCampagne('Acces pdf|Annale');
            $statistique->setIdElement($annale->getId());
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
        
        function trouver($dossier, $lieuMatiereSerieAnnee) {
            if (!is_dir($dossier) OR !($dir = opendir($dossier))) {
                return false;
            }

            $found = false;
            while ($element = readdir($dir)) {
                if ($element != '.' && $element != '..') {
                    if (is_dir($dossier . '/' . $element)) {
                        if ($found = trouver($dossier . '/' . $element, $lieuMatiereSerieAnnee)) {
                            return $found;
                        }
                    } elseif ($element == $lieuMatiereSerieAnnee . ".pdf") {
                        $found = $dossier . "/" . $lieuMatiereSerieAnnee . ".pdf";
                        return $found;
                    }
                }
            }
            closedir($dir);
            return $found;
        }

        //recherche du pdf associé ? la ressource
        $dossier = $this->container->getParameter('dossierAnnales');
        $found = trouver($dossier, $annale->getIdWb());

        //Renvoi du pdf	
        if ($found) {
            $response->setStatusCode(200);
            $response->headers->set('Content-Type', 'application/pdf');
            $response->headers->set('Content-Length', filesize($found));
            $response->send();
            readfile($found);
            return $response;
        }
        throw $this->createNotFoundException("La ressource demand&eacute;e n'existe pas : $lieuMatiereSerieAnnee");
    }

    /**
     * PDF du corrigé
     */
    public function corrigePdfAction(Request $request, $lieu, $matiere, $serie, $annee) {
        $response = new Response();
        
        //Rechaerche de la matiere
        $repositoryMatiere = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Matiere');
        $matiere = $repositoryMatiere->findOneBy(array('serie' => $serie, 'url' => $matiere));
        if (!$matiere) {
            throw $this->createNotFoundException("La ressource demand&eacute;e n'existe pas");
        }

        // Settage du cookie et de la session pour conserver la serie de l'utilisateur
        $this->get('session')->set('serie', $matiere->getSerie());
        $response->headers->setCookie(new Cookie('serie', $matiere->getSerie(), time() + 3600 * 24 * 30));

        //recherche de l'annale
        $repositoryAnnale = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Annale');
        $annale = $repositoryAnnale->findOneBy(
                array('matiere' => $matiere->getId(),
            'lieu_url' => $lieu,
            'date' => $annee), null, 1
        );
        if (!$annale) {
            throw $this->createNotFoundException("La ressource demand&eacute;e n'existe pas");
        }
        
        //Statistique
        if ($request->headers->get('referer') != "") {
            $statistique = new Statistique();
            $statistique->setDescription('AnnalesController');
            $statistique->setReferrer($request->headers->get('referer'));
            $statistique->setUrl($request->getUri());
            $statistique->setSessionId($this->get('session')->getId());
            $statistique->setDate(new \DateTime());
            $statistique->setCampagne('Acces pdf|Corrige');
            $statistique->setIdElement($annale->getId());
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

        //Recherche de la resssource
        function trouver($dossier, $lieuMatiereSerieAnnee) {
            if (!is_dir($dossier) OR !($dir = opendir($dossier))) {
                return false;
            }

            $found = false;
            while ($element = readdir($dir)) {
                if ($element != '.' && $element != '..') {
                    if (is_dir($dossier . '/' . $element)) {
                        if ($found = trouver($dossier . '/' . $element, $lieuMatiereSerieAnnee)) {
                            return $found;
                        }
                    } elseif ($element == $lieuMatiereSerieAnnee . "C.pdf") {
                        $found = $dossier . "/" . $lieuMatiereSerieAnnee . "C.pdf";
                        return $found;
                    }
                }
            }
            closedir($dir);
            return $found;
        }

        $dossier = $this->container->getParameter('dossierAnnales');
        $found = trouver($dossier, $annale->getIdWb());

        //Renvoi du pdf
        if ($found) {
            $response->setStatusCode(200);
            $response->headers->set('Content-Type', 'application/pdf');
            $response->headers->set('Content-Length', filesize($found));
            $response->send();
            readfile($found);
            return $response;
        }
        throw $this->createNotFoundException("La ressource demand&eacute;e n'existe pas : " . $annale->getIdWb());
    }
    /**
     * Box d'association permettant de lier une fiche a d'autres annale et fiches
     * en fonction des visites des utilisateurs
     */
    public function associationsAction(Request $request, $nb, $type, $id) {
        //gestion du cache
        $response = new Response();
        $response->setSharedMaxAge(3600 * 24 * 30);
        if ($response->isNotModified($request)) {
            return $response;
        }

        //recherche du type
        $repositoryAnnale = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Annale');
        $repositoryFiche = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Fiche');
        if ($type == 'annale') {
            $element = $repositoryAnnale->find($id);
        } elseif ($type == 'fiche') {
            $element = $repositoryFiche->find($id);
        } else {
            throw $this->createNotFoundException("Le type de ressource n'existe pas : " . $type);
        }
        
        //Recuperation des associations
        $repositoryStats = $this->getDoctrine()->getRepository('WelcomebacStatistiquesBundle:Statistique');
        $associations = $repositoryStats->updateAssociations($element, $nb);

        //Creation des liens ? insérer dans le template
        $associations_liens = array();
        if (count($associations)) {
            foreach ($associations as $infos) {
                if ($infos['type'] == 'annale') {
                    $annale_assoc = $repositoryAnnale->find($infos['id_element']);
                    if ($annale_assoc) {
                        $associations_liens[] = '<a class="stats-click" cp="Box Associations|' . ucwords($type) . ' vers Annale" dsc="' . $element->getId() . '-' . $annale_assoc->getId() . '" title="' . $infos['nb'] . (($infos['nb'] > 1) ? ' autres utilisateurs ont' : ' autre utilisateur a') . ' visionn&eacute; cette ressource" href="' . $this->generateUrl('WelcomebacPublicBundle_' . $infos['type'], array('matiere' => $annale_assoc->getMatiere()->getUrl(), 'serie' => $annale_assoc->getMatiere()->getSerie(), 'annee' => $annale_assoc->getDate(), 'lieu' => $annale_assoc->getLieuUrl())) . '">Annale ' . $annale_assoc->getMatiere()->getNom() . ' ' . $annale_assoc->getLieu() . ' ' . $annale_assoc->getDate() . '</a>';
                    }
                } elseif ($infos['type'] == 'fiche') {
                    $fiche_assoc = $repositoryFiche->find($infos['id_element']);
                    if ($fiche_assoc) {
                        $associations_liens[] = '<a class="stats-click" cp="Box Associations|' . ucwords($type) . ' vers Fiche" dsc="' . $element->getId() . '-' . $fiche_assoc->getId() . '" title="' . $infos['nb'] . (($infos['nb'] > 1) ? ' autres utilisateurs ont' : ' autre utilisateur a') . ' visionn&eacute; cette ressource" href="' . $this->generateUrl('WelcomebacPublicBundle_fiche', array('matiere' => $fiche_assoc->getMatiere()->getUrl(), 'serie' => $fiche_assoc->getMatiere()->getSerie(), 'titre' => $fiche_assoc->getUrl())) . '">' . $fiche_assoc->getTitre() . '</a>';
                    }
                }
            }
        }
        return $this->render('WelcomebacPublicBundle:Annales:association.html.twig', array('associations' => $associations_liens), $response);
    }
    
    /**
     * Page annale
     */
    public function annaleAction(Request $request, $matiere, $serie, $lieu, $annee) {
        //Recuperation des parametres en base pour la matiere
        $repositoryMatiere = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Matiere');
        $matiere = $repositoryMatiere->findOneBy(array('serie' => $serie, 'url' => $matiere));
        if (!$matiere) {
            throw $this->createNotFoundException("La ressource demand&eacute;e n'existe pas");
        }
        // Settage du cookie et de la session pour conserver la serie de l'utilisateur
        $response = new Response();
        $this->get('session')->set('serie', $serie);
        $response->headers->setCookie(new Cookie('serie', $serie, time() + 3600 * 24 * 30));

        //Recuperation des parametres en base pour l'annale
        $repositoryAnnale = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Annale');
        $annale = $repositoryAnnale->findOneBy(
                array(
            'matiere' => $matiere->getId(),
            'lieu_url' => $lieu,
            'date' => $annee), null, 1
        );
        if (!$annale) {
            throw $this->createNotFoundException("La ressource demand&eacute;e n'existe pas");
        }

        //incrementation du compteur d'acces
        $annale->setNombreVisites($annale->getNombreVisites() + 1);
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($annale);
        $em->flush();

        //Determine si l'annale est un favori de l'utilisateur
        $favori = false;
        $utilisateur = $this->get('session')->has('utilisateur');
        if ($utilisateur && ($utilisateur = $this->get('session')->get('utilisateur'))) {
            $repositoryFavori = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Favori');
            $favori = $repositoryFavori->findOneBy(array('id_element' => $annale->getId(), 'utilisateur' => $utilisateur, 'type' => 'a'));
        }
        
        return $this->render('WelcomebacPublicBundle:Annales:annale.html.twig', array("annale" => $annale, 'favori' => $favori), $response);
    }

    /**
     * Page corrige
     */
    public function corrigeAction(Request $request, $matiere, $serie, $lieu, $annee) {

        //Recuperation de la matiere en base
        $repositoryMatiere = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Matiere');
        $matiere = $repositoryMatiere->findOneBy(array('serie' => $serie, 'url' => $matiere));
        if (!$matiere) {
            throw $this->createNotFoundException("La ressource demand&eacute;e n'existe pas");
        }
        
        // Settage du cookie et de la session pour conserver la serie de l'utilisateur
        $response = new Response();
        $this->get('session')->set('serie', $serie);
        $response->headers->setCookie(new Cookie('serie', $serie, time() + 3600 * 24 * 30));

        //recuperation de l'annale en base
        $repositoryAnnale = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Annale');
        $annale = $repositoryAnnale->findOneBy(
                array('matiere' => $matiere->getId(),
            'lieu_url' => $lieu,
            'date' => $annee), null, 1
        );
        if (!$annale) {
            throw $this->createNotFoundException("La ressource demand&eacute;e n'existe pas");
        }

        //Determine si l'annale est un favori de l'utilisateur
        $favori = false;
        $utilisateur = $this->get('session')->has('utilisateur');
        if ($utilisateur && ($utilisateur = $this->get('session')->get('utilisateur'))) {
            $repositoryFavori = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Favori');
            $favori = $repositoryFavori->findOneBy(array('id_element' => $annale->getId(), 'utilisateur' => $utilisateur, 'type' => 'c'));
        }
        
        //recuperation des notes
        $repositoryStats = $this->getDoctrine()->getRepository('WelcomebacStatistiquesBundle:Statistique');
        $notation = $repositoryStats->getNotation($annale);

        return $this->render('WelcomebacPublicBundle:Annales:corrige.html.twig', array("annale" => $annale, 'favori' => $favori, 'note' => $notation['note'], 'votes' => $notation['votes']), $response);
    }

    /**
     * Menu des annales : listing series et mati?res
     */
    public function menuAction(Request $request, $serie) {
        // Gestion du cache
        $response = new Response();
        $response->setPublic();
        $response->setSharedMaxAge($this->container->getParameter('cacheTimeRessources'));
        if ($response->isNotModified($request)) {
            return $response;
        }

        //Recuperer toutes les matieres de la serie
        $em = $this->getDoctrine()->getEntityManager();
        $matieres = $em->getRepository('WelcomebacEntitesBundle:Matiere')
                ->findAllHavingAnnales($serie);

        return $this->render('WelcomebacPublicBundle:Annales:menu.html.twig', array("matieres" => $matieres), $response);
    }

    /*
     *
     * 					REDIRECTIONS
     *
     */

    public function corrigePdf_oldAction(Request $request, $lieuMatiereSerieAnnee) {
        //Recuperation de la annale
        $em = $this->getDoctrine()->getEntityManager();
        $repositoryAnnale = $em->getRepository('WelcomebacEntitesBundle:Annale');
        $annale = $repositoryAnnale->findOneBy(array('id_wb' => $lieuMatiereSerieAnnee));

        if (!$annale) {
            throw $this->createNotFoundException("La ressource demand&eacute;e n'existe pas");
        }

        return $this->redirect($this->generateUrl('WelcomebacPublicBundle_corrigePdf', array('serie' => $annale->getMatiere()->getSerie(), 'matiere' => $annale->getMatiere()->getUrl(), 'lieu' => $annale->getLieuUrl(), 'annee' => $annale->getDate())), 301);
    }

    public function annalePdf_oldAction(Request $request, $lieuMatiereSerieAnnee) {
        //Recuperation de la annale
        $em = $this->getDoctrine()->getEntityManager();
        $repositoryAnnale = $em->getRepository('WelcomebacEntitesBundle:Annale');
        $annale = $repositoryAnnale->findOneBy(array('id_wb' => $lieuMatiereSerieAnnee));

        if (!$annale) {
            throw $this->createNotFoundException("La ressource demand&eacute;e n'existe pas");
        }

        return $this->redirect($this->generateUrl('WelcomebacPublicBundle_annalePdf', array('serie' => $annale->getMatiere()->getSerie(), 'matiere' => $annale->getMatiere()->getUrl(), 'lieu' => $annale->getLieuUrl(), 'annee' => $annale->getDate())), 301);
    }

}
