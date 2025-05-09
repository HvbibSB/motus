# 🎮 Motus - Documentation

## 📂 Structure des fichiers

```
motus/
├── motus.php # Page principale du jeu
├── regles.php # Page des règles du jeu
├── score.php # Tableau des scores
├── mots.json # Liste des mots disponibles
├── db.php # Connexion à la base de données
├── style.css # Feuille de style commune
└── script.js # Scripts JavaScript
```

## 🎯 Règles du jeu

### 🏆 Objectif
Trouver le mot secret en un maximum de 6 tentatives.

### 🔤 Mécanique de jeu
- Mot aléatoire choisi parmi une liste prédéfinie
- Première lettre toujours révélée
- 6 tentatives maximum
- Chaque mot proposé doit:
  - Avoir la même longueur que le mot secret
  - Commencer par la même lettre

### 🎨 Code couleur
| Apparence | Signification |
|-----------|---------------|
| 🟩 Lettre verte | Lettre correcte et bien placée |
| 🟨 Lettre orange | Lettre correcte mais mal placée |
| ⬜ Lettre grise | Lettre absente du mot |

## 🛠️ Fonctionnalités

### 🎮 Page de jeu (`motus.php`)
- Interface interactive avec saisie du mot
- Affichage des tentatives précédentes
- Compteur de tentatives restantes
- Gestion de la victoire/défaite
- Enregistrement du score

### 📊 Tableau des scores (`score.php`)
- Classement des meilleurs scores
- Affichage:
  - Nom du joueur
  - Mot trouvé
  - Nombre de tentatives
  - Date

### 📖 Règles du jeu (`regles.php`)
- Explications détaillées
- Exemples visuels
- Liens vers:
  - Le jeu
  - Les scores

## 🛠️ Configuration requise

### 💾 Base de données
```sql
CREATE DATABASE motus;
USE motus;

CREATE TABLE word (
    id INT AUTO_INCREMENT PRIMARY KEY,
    word VARCHAR(255) NOT NULL,
    attempts INT NOT NULL,
    player_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);