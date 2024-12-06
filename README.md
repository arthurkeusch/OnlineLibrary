# Online Library

Online Library est une application web permettant de gérer une bibliothèque en ligne. Ce projet offre des fonctionnalités pour les utilisateurs (consultation, emprunt, commentaires) et pour les administrateurs (gestion des livres).

## Fonctionnalités

### Pour les utilisateurs non connectés :
- Visualiser la liste des livres disponibles.
- Consulter les informations détaillées d’un livre.
- S’inscrire et se connecter.

### Pour les utilisateurs connectés :
- Emprunter un livre (si disponible).
- Laisser un commentaire sur un livre emprunté.
- Accéder à une liste des livres empruntés avec leurs dates d’emprunt.

### Pour les administrateurs :
- Ajouter, modifier et supprimer des livres.
- Visualiser les livres en cours d’emprunt et leur durée.

---

## Installation

### Étapes :
1. Clonez le repository :
   ```bash
   git clone https://github.com/arthurkeusch/OnlineLibrary.git
   cd OnlineLibrary
   ```

2. Installez les dépendances :
   ```bash
   composer install
   ```

3. Migration du serveur :
   ```bash
   php OnlineLibrary migrate
   ```

4. Lancement du serveur
   ```bash
   php OnlineLibrary serve
   ```
---

## Contributeurs

- **Paul GRAVINESE**
- **Arthur KEUSCH**
- **Cécile KUZNIACK**
