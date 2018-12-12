<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadProduits.php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Produits;

class LoadProduits implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    // Liste des noms de compétences à ajouter
    $dis = 'Batata';
    $qte = 2;

    
      // On crée la compétence
      $produit = new Produits();
      $produit->setDiscription($dis);
      $produit->setqte($qte);


      // On la persiste
      $manager->persist($produit);


    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}