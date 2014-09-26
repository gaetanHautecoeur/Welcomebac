<?php

namespace Welcomebac\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Facebook\Facebook;

class TraitementsController extends Controller {

    //Creation du sitemap
    public function siteMapAction(Request $request) {
        $repositoryMatiere = $this->getDoctrine()->getRepository('WelcomebacEntitesBundle:Matiere');
        $matieres = $repositoryMatiere->findAll();

        $response = new Response();
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/xml');
        return $this->render('WelcomebacPublicBundle:Traitements:sitemap.xml.twig', array('matieres' => $matieres), $response);
    }

    //Insertion des anciens stats fichiers dans la bdd
    public function statsAction(Request $request, $type) {

        function saveStats($em, $filename, $type, $fiche) {
            if ($fp = fopen($filename, "r")) {
                while (!feof($fp)) {
                    $ligne = fgets($fp);
                    $tab = explode(';', $ligne);
                    if (count($tab) == 6) {
                        $time = $tab[0];
                        $id = $tab[2];
                        $ip = $tab[3];
                        $referal = $tab[4];
                        $found = $tab[5];
                        if ($referal && $found && ($fiche['id'] == $id || $fiche['id_wb'] == $id)) {

                            $date = new \DateTime();
                            $date->setTimestamp($time);

                            $description = "OldStats des " . ucwords($type) . "s";
                            $campagne = "Acces pdf|" . ucwords($type);
                            echo "INSERT INTO `Statistique` (  `id` ,  `date` ,  `campagne` ,  `referrer` ,  `url` ,  `id_element` ,  `ip` ,  `description` ,  `session_id` )  VALUES ('', '" . $date->format('Y-m-d H:i:s') . "', '" . $campagne . "', '" . addslashes($referal) . "', '', '" . $fiche['id'] . "', '" . $ip . "', '" . $description . "', '" . $ip . "');<br/>";
                        }
                    }
                }
                fclose($fp); // On ferme le fichier
                unset($fp);
            }
        }

        $results = array();
        $filenames = array();
        $dir = $this->container->getParameter('dossierLogs') . "/";
        // Ouvre un dossier bien connu, et liste tous les fichiers
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {

                    if (preg_match('/^compteur_a.*\.csv$/', $file)) {
                        $filenames[] = array('filename' => $file, 'type' => 'annale');
                    }

                    if (preg_match('/^compteur_f.*\.csv$/', $file)) {
                        //$filenames[] = array('filename'=>$file, 'type'=>'fiche');
                    }

                    if (preg_match('/^compteur_c.*\.csv$/', $file)) {
                        $filenames[] = array('filename' => $file, 'type' => 'corrige');
                    }
                }
                closedir($dh);
            }
        }

        $em = $this->getDoctrine()->getEntityManager();
        if ($type == 'fiche') {
            $objets = $em->createQueryBuilder()
                    ->select('f.id, f.id_wb')
                    ->from('Welcomebac\EntitesBundle\Entity\Fiche', 'f')
                    ->getQuery()
                    ->getResult();
        } else {
            $objets = $em->createQueryBuilder()
                    ->select('a.id, a.id_wb')
                    ->from('Welcomebac\EntitesBundle\Entity\Annale', 'a')
                    ->where('a.id >= :min AND a.id <= :max')
                    ->setParameter('min', 0)
                    ->setParameter('max', 200)
                    ->getQuery()
                    ->getResult();
        }


        foreach ($filenames as $filename) {
            foreach ($objets as $objet) {
                if ($filename['type'] == $type) {
                    saveStats($em, $dir . $filename['filename'], $filename['type'], $objet);
                }
            }
        }
        exit;
    }

}
