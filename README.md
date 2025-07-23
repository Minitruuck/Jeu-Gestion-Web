# HainergieIF
Le nom du jeu n'est pas une faute d'orthographe, c'est fait exprès. Projet UTBM

📌 Organisation de la base de données

<1️⃣ Utilisateurs>

-Contient les informations des joueurs (email, mot de passe, argent disponible, demande d’énergie, date du jeu).

<2️⃣ Centrales>

-Stocke les centrales électriques possédées par les joueurs.

-Chaque centrale a un type (fossile, renouvelable, nucléaire), un coût d’achat, un coût d’entretien, une consommation de combustible et un taux de production ajustable.

<3️⃣ Mines>

-Liste les mines achetées par les joueurs.

-Chaque mine a un type (pétrole, métal, uranium), un coût d’achat, un coût d’entretien et une production mensuelle de ressource.

<4️⃣ Ressources>

-Gère les stocks de ressources des joueurs.

-Chaque joueur possède une certaine quantité de pétrole, métal et uranium.

<5️⃣ Offres de vente>

-Permet aux joueurs de mettre en vente de l’énergie ou des ressources.

-Chaque offre précise le type de ressource/énergie, la quantité et le prix.

<6️⃣ Contrats d’énergie>

-Stocke les contrats d’achat/vente d’énergie entre joueurs.

-Chaque contrat précise l’acheteur, le vendeur, la quantité d’énergie et la durée du contrat.

<7️⃣ Historique des transactions>

Garde une trace des ventes et achats de ressources ou d’énergie.

<8️⃣ Événements du jeu>

-Gère l’évolution du jeu à chaque tour (mise à jour des coûts, production, demande d’énergie, exécution des contrats).
