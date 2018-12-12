<?php

// src/OC/PlatformBundle/Controller/AdvertController.php

namespace OC\PlatformBundle\Controller;

use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\AdvertSkill;
use OC\PlatformBundle\Entity\Skill;
use OC\PlatformBundle\Entity\Image;
use OC\PlatformBundle\Entity\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdvertController extends Controller
    {
    /**
    * @param $days
    * @return \Symfony\Component\HttpFoundation\Response
    */
    public function purgeAction($days){
        //appller le service purgeAdvert
        $advert = $this->container->get('oc_platform.purger.advert')->purge($days);

        // On arrête l'excution car la vue n'est pas nécessaire
        die();
        // On donne toutes les informations nécessaire à la vue
        return $this->render('OCPlatformBundle:Advert:purge.html.twig', array(
            'listAdverts' => $advert,
        ));

    }
  public function indexAction($page)
  {
    if ($page < 1) {
      throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
    }

    // Ici je fixe le nombre d'annonces par page à 3
    // Mais bien sûr il faudrait utiliser un paramètre, et y accéder via $this->container->getParameter('nb_per_page')
    $nbPerPage = 3;

    // On récupère notre objet Paginator
    $listAdverts = $this->getDoctrine()
      ->getManager()
      ->getRepository('OCPlatformBundle:Advert')
      ->getAdverts($page, $nbPerPage)
    ;

    // On calcule le nombre total de pages grâce au count($listAdverts) qui retourne le nombre total d'annonces
    $nbPages = ceil(count($listAdverts) / $nbPerPage);

    // Si la page n'existe pas, on retourne une 404
    if ($page > $nbPages) {
      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    }

    // On donne toutes les informations nécessaires à la vue
    return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
      'listAdverts' => $listAdverts,
      'nbPages'     => $nbPages,
      'page'        => $page,
    ));
  }

  public function viewAction($id)
  {
    $em = $this->getDoctrine()->getManager();

    // Pour récupérer une seule annonce, on utilise la méthode find($id)
    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

    // $advert est donc une instance de OC\PlatformBundle\Entity\Advert
    // ou null si l'id $id n'existe pas, d'où ce if :
    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    // Récupération de la liste des candidatures de l'annonce
    $listApplications = $em
      ->getRepository('OCPlatformBundle:Application')
      ->findBy(array('advert' => $advert))
    ;

    // Récupération des AdvertSkill de l'annonce
    $listAdvertSkills = $em
      ->getRepository('OCPlatformBundle:AdvertSkill')
      ->findBy(array('advert' => $advert))
    ;

    return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
      'advert'           => $advert,
      'listApplications' => $listApplications,
      'listAdvertSkills' => $listAdvertSkills,
    ));
  }

  //route /add

  public function addAction()
  {
    /////////////////////////////////////////////////////////////

         // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();
        // Création de l'entité Advert
        $advert = new Advert();
        $advert->setAuthor('Dina');
        $advert->setContent("Nous recherchons un développeur PHP débutant sur Lyon. Blabla…");
        $advert->setTitle("Recherche développeur Symfony");
        $advert->setUpdatedadvert(new \DateTime());

        //////////////////Ajout des Produits//////////////////////////::::
         // On récupère toutes les compétences possibles
          //Boucle pour ajouter 3 compétences
          for ($i = 1; $i <= 3; $i++) {
            $listSkills = 'listSkills'.$i;
            $listSkills = $em->getRepository('OCPlatformBundle:Skill')->find($i);
             $advertskill='advertskill'.$i;
            $advertskill = new AdvertSkill();
            $advertskill->setAdvert($advert);
            $advertskill->setSkill($listSkills);
            $advertskill->setLevel('Expert');
            $em->persist($advertskill);
          } 
           
           
        ///////////////////////////////////Ajoter une categorie /////////////////////////////////////////////////
        //On récupère toutes les categories possible
        //Boucle pour ajuter 3 categorie
          for ($i = 1; $i <= 3; $i++) {
          $category = $em->getRepository('OCPlatformBundle:Category')->find($i);
          $advert->addCategory($category);
          } 
        ///////////////////////////add 1 image par annonce///////////////////////////////////////////////////////////////

        $imageAdvert = new Image();
        $imageAdvert->setUrl("https://cdn.pixabay.com/photo/2014/05/03/00/45/computer-336628_960_720.jpg");
        $imageAdvert->setAlt("Ordinateur accessoires");

        $advert->setImage($imageAdvert);

        ////////////////////////////add 3 condidatures//////////////////////////////////

        $application1 = new Application();
        $application1->setAuthor('Dina');
        $application1->setContent("Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…");

        $application2 = new Application();
        $application2->setAuthor('David');
        $application2->setContent("Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…");

        $application3 = new Application();
        $application3->setAuthor('Toto');
        $application3->setContent("Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…");

        // On lie les candidatures à l'annonce
        $application1->setAdvert($advert);
        $application2->setAdvert($advert);
        $application3->setAdvert($advert);


        
/////////////////persist tout////////////////////////////////////
        $em->persist($advert);
        $em->persist($application1);
        $em->persist($application2);
        $em->persist($application3);
////////////////enregistrer///////////////////////////////////////
        $em->flush();
        ///////////////////////////////////////////////////////////////////////
        echo "Vous avez ajouter des annonces !!!  Bravo";
    die();
    return $this->render('OCPlatformBundle:Advert:test.html.twig', array(
      'advert' => $advert
    ));
  }

  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getManager();

    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    // On boucle sur les catégories de l'annonce pour les supprimer
    foreach ($advert->getCategories() as $category) {
      $advert->removeCategory($category);
    }

    $em->flush();
    
    return $this->render('OCPlatformBundle:Advert:delete.html.twig');
  }

  public function menuAction($limit)
  {
    $em = $this->getDoctrine()->getManager();

    $listAdverts = $em->getRepository('OCPlatformBundle:Advert')->findBy(
      array(),                 // Pas de critère
      array('date' => 'desc'), // On trie par date décroissante
      $limit,                  // On sélectionne $limit annonces
      0                        // À partir du premier
    );

    return $this->render('OCPlatformBundle:Advert:menu.html.twig', array(
      'listAdverts' => $listAdverts
    ));
  }
}
