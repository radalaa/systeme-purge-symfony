<?php
// src/OC/PlatformBundle/Email/ApplicationMailer.php

namespace OC\PlatformBundle\Purge;

use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\AdvertSkill;
use OC\PlatformBundle\Entity\Skill;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @property  em
 */
class AdvertPurge{

    public function __construct($em)
     {
         $this->em = $em;
     }

    /**
     *
     */
    public function purge($days){
        //Chercher les annonces sans candidatures , pour cela on appel la function findAdvertNotActif() dans le Repository Advert
      $advert = $this->em->getRepository('OCPlatformBundle:Advert')->findAdvertNotActif();

      /////////////////  Boucle pour supprimer les annonces on la date de modification
        foreach($advert as $value)
         {
          $IdAdvert= $value->getId();
          $DateUpdate=$value->getUpdatedadvert();
      
          $interval = $DateUpdate->diff(new \DateTime());
          $DiffDays = abs($interval->format('%R%a'));

          if ($DiffDays >=  $days ){

            echo "l'annonce N° ". $IdAdvert ." sera supprimée, car elle n'est pas pertinente.";
                    //recuperer une annonce
                    $advert = $this->em->getRepository('OCPlatformBundle:Advert')->findOneBy(array('id'=> $IdAdvert));
                    //chercher les skills pour les supprimer 
                    $advertSkill = $this->em->getRepository('OCPlatformBundle:AdvertSkill')->findBy(array('advert' => $IdAdvert));
                    //Boucle Pour supprimer les Skill
                    foreach ($advertSkill as $key) {
                      $Skill = $this->em->getRepository('OCPlatformBundle:AdvertSkill')->findOneBy(array('id' => $key->getId()));
                      if ($Skill != null){

                        $this->em->remove($Skill);  
                       $this->em->flush();
                      }  

                    }


                      foreach ($advert->getCategories() as $category) {
                        $advert->removeCategory($category); 
                      }

                        $this->em->remove($advert);
                        $this->em->flush();

          }       
        }
    return true;
  }
}