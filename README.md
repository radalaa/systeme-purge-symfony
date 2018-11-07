Créez un système pour nettoyer les entités

Mission : un système de purge

Beaucoup d’annonces vont être créées sur notre site, certaines trouveront des candidatures pertinentes, d’autres pas forcément. C’est dans ce dernier cas qu’il nous faut un moyen de nettoyer les annonces sans candidatures qui ne sont plus utile à personne !

Pour cela, vous devez écrire un service que nous appellerons “oc_platform.purger.advert”. Ce service va récupérer et supprimer toutes les annonces dont la date de modification est plus vieille que X jours. Ce “X” doit être un paramètre de la méthode de votre service.

Attention également à ne pas supprimer des annonces ayant au moins une candidature. A partir du moment où on a une candidature sur une certaine annonce, alors on souhaite garder cette annonce indéfiniment.

La méthode à créer a donc la signature suivante :

<?php
public function purge($days)
Pour tester ce service, je vous invite à créer une action dans le contrôleur Advert, par exemple à l’URL /platform/purge/{days}, qui ne fait qu’exécuter la purge grâce à ce service. Pas besoin de vue, cette action de contrôleur ne sera pas notée.

Pour remplir cette mission, vous devrez peut-être créer une nouvelle méthode dans un repository.

https://s3-eu-west-1.amazonaws.com/static.oc-static.com/prod/courses/files/developpez-votre-site-web-avec-le-framework-symfony/Activite_Partie_3_start.zip