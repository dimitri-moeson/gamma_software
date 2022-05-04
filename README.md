# gamma_software

**`Test technique`**

**Objectif**

Réalisation d’un système d’import du fichier Excel en pièce jointe pour la partie backend.

**Contexte**

En tant que client

Je souhaite que mon fichier Excel soit importé dans une base de données

Afin de pouvoir consulter, modifier ou supprimer les informations

**Stack technique**

Aucune stack n’est imposée.

**Durée du test**

Nous ne souhaitons pas que ce test excède les 7 heures (avec mise en place de la stack).

**Attendus**

* Une archive contenant : le code source, ainsi que le dump de la base de données
* Le code doit être accessible sur un repository en ligne (github par exemple)

**choix**

- Le endpoint est situé dans le dossier `Public`
- Plusieurs namespaces/dossiers :
   + le noyau (appel fichiers et base de données) : `\Manager`
   + la configuration (identifiants et parametres ) : `\config`
   + le(s) contrôleur(s) : `\Controller` 
   + le(s) modele(s) de données : `\Model`
   + le(s) vue(s) : `\View`
- fichier SQL joint : `config/gamma_sofware.sql`
- table "rockband"( id, name, country, city, start_year, end_year, founder, member_count, music_type, presentation)
- abstraction SQL : PDO
- librairie de lecture des fichiers : SimpleXLSX 