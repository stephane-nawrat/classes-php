# classes-php
Création d'une classe et ses méthodes associées.

---

## 📚 Guide Git & GitHub (Pédagogique)

### Structure des branches

Ce projet utilise une stratégie de branches par fonctionnalité :
```
main (code stable)
  │
  ├── feat/database       → Création BDD + tables
  ├── feat/config         → Configuration + .env
  ├── feat/user-mysqli    → Classe User (MySQLi)
  ├── feat/user-pdo       → Classe UserPDO (PDO)
  └── docs/final          → Documentation finale
```

### Workflow type

#### 1. Créer une nouvelle branche
```bash
# Créer et basculer sur une nouvelle branche
git checkout -b feat/ma-fonctionnalite

# Vérifier sur quelle branche on est
git branch
```

#### 2. Travailler et commiter
```bash
# Voir les fichiers modifiés
git status

# Ajouter les fichiers
git add .                    # Tous les fichiers
git add fichier.php          # Un fichier spécifique

# Commiter avec un message clair
git commit -m "feat(scope): description courte

- Détail 1
- Détail 2"

# Push vers GitHub (premier push)
git push -u origin feat/ma-fonctionnalite

# Push suivants (si tracking configuré)
git push
```

#### 3. Merger dans main
```bash
# Retour sur main
git checkout main

# Récupérer les dernières modifications
git pull origin main

# Merger la branche de fonctionnalité
git merge feat/ma-fonctionnalite

# Push main
git push origin main
```

#### 4. Nettoyer les branches (optionnel)
```bash
# Supprimer la branche locale (après merge)
git branch -d feat/ma-fonctionnalite

# Supprimer la branche distante
git push origin --delete feat/ma-fonctionnalite
```

---

### Convention de messages de commit

Format recommandé : **Conventional Commits**
```
<type>(<scope>): <description>

[corps optionnel]
```

**Types courants :**
- `feat` : Nouvelle fonctionnalité
- `fix` : Correction de bug
- `docs` : Documentation
- `test` : Ajout/modification de tests
- `refactor` : Refactorisation de code
- `style` : Formatage (pas de changement de logique)

**Exemples :**
```bash
git commit -m "feat(database): create users table"
git commit -m "fix(auth): resolve password hashing issue"
git commit -m "docs(readme): add git workflow section"
git commit -m "test(user): add connection test"
```

---

### Commandes utiles
```bash
# Voir l'historique des commits
git log --oneline --graph --all

# Voir les différences avant commit
git diff

# Annuler les modifications non commitées
git checkout -- fichier.php

# Voir les branches locales
git branch

# Voir toutes les branches (locales + distantes)
git branch -a

# Changer de branche
git checkout nom-branche

# Voir le statut détaillé
git status
```

---

### Configuration recommandée
```bash
# Votre identité (à faire une seule fois)
git config --global user.name "Votre Nom"
git config --global user.email "votre@email.com"

# Push simplifié (juste "git push")
git config --global push.default current
git config --global push.autoSetupRemote true

# Éditeur par défaut (VSCode)
git config --global core.editor "code --wait"

# Couleurs dans le terminal
git config --global color.ui auto
```

---

### Résolution de problèmes courants

#### Erreur : "non-fast-forward"
```bash
# Récupérer les modifications distantes d'abord
git pull origin main
git push origin main
```

#### Oublié de créer une branche
```bash
# Créer une branche avec les modifications actuelles
git checkout -b feat/nouvelle-branche
```

#### Commit sur la mauvaise branche
```bash
# Annuler le dernier commit (garde les modifications)
git reset --soft HEAD~1

# Changer de branche
git checkout bonne-branche

# Re-commiter
git add .
git commit -m "message"
```

---

### Ressources

- [Documentation Git officielle](https://git-scm.com/doc)
- [Conventional Commits](https://www.conventionalcommits.org/)
- [GitHub Guides](https://guides.github.com/)
