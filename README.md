Cr�ez un syst�me pour nettoyer les entit�s

Mission : un syst�me de purge

Beaucoup d�annonces vont �tre cr��es sur notre site, certaines trouveront des candidatures pertinentes, d�autres pas forc�ment. C�est dans ce dernier cas qu�il nous faut un moyen de nettoyer les annonces sans candidatures qui ne sont plus utile � personne !

Pour cela, vous devez �crire un service que nous appellerons �oc_platform.purger.advert�. Ce service va r�cup�rer et supprimer toutes les annonces dont la date de modification est plus vieille que X jours. Ce �X� doit �tre un param�tre de la m�thode de votre service.

Attention �galement � ne pas supprimer des annonces ayant au moins une candidature. A partir du moment o� on a une candidature sur une certaine annonce, alors on souhaite garder cette annonce ind�finiment.

La m�thode � cr�er a donc la signature suivante :

<?php
public function purge($days)
Pour tester ce service, je vous invite � cr�er une action dans le contr�leur Advert, par exemple � l�URL /platform/purge/{days}, qui ne fait qu�ex�cuter la purge gr�ce � ce service. Pas besoin de vue, cette action de contr�leur ne sera pas not�e.

Pour remplir cette mission, vous devrez peut-�tre cr�er une nouvelle m�thode dans un repository.

https://s3-eu-west-1.amazonaws.com/static.oc-static.com/prod/courses/files/developpez-votre-site-web-avec-le-framework-symfony/Activite_Partie_3_start.zip