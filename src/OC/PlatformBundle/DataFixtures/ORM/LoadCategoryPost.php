<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadCategoryPost.php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\CategoryPost;

class LoadCategoryPost implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $names = array(
      'Développement web',
      'Développement mobile',
      'Graphisme',
      'Intégration',
      'Réseau'
    );

    foreach ($names as $name) {
      // On crée la catégorie
      $categoryPost = new CategoryPost();
      $categoryPost->setName($name);

      // On la persiste
      $manager->persist($categoryPost);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}