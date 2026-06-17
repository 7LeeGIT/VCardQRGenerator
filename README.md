# Générateur de QR Code vCard

Un générateur de QR codes en PHP qui crée des cartes de visite numériques au format vCard, facilement scannables et partageables.

## 📋 Description

Ce projet permet de générer automatiquement des QR codes contenant des informations de contact professionnelles au format vCard 3.0. Les QR codes générés peuvent être scannés avec n'importe quel smartphone, permettant ainsi d'enregistrer instantanément les informations de contact dans le carnet d'adresses du téléphone.

## ✨ Fonctionnalités

- Génération de QR codes au format vCard 3.0
- Support complet des informations de contact :
  - Nom complet
  - Fonction/Titre professionnel
  - Numéro de téléphone mobilekk
  - Numéro de téléphone fixe
  - Adresse email
  - Adresse postale complète
  - Site web
  - Notes additionnelles
- Configuration personnalisable du QR code (niveau de correction, taille des pixels)
- Création automatique du dossier de stockage des QR codes
- Format vCard compatible avec tous les smartphones modernes

## 🔧 Prérequis

- PHP 5.6 ou supérieur
- Bibliothèque [phpqrcode](http://phpqrcode.sourceforge.net/)
- Droits d'écriture sur le serveur pour la création des QR codes

## 📥 Installation

1. Clonez le repository :
```bash
git clone https://github.com/7leegit/VCardQRGenerator.git
```

2. Installez la bibliothèque phpqrcode dans le dossier du projet :
```bash
cd VCardQRGenerator
# Placez la bibliothèque phpqrcode dans un dossier 'phpqrcode'
```

3. Vérifiez les permissions du dossier :
```bash
chmod 755 VCardQRGenerator
```

## 💻 Utilisation

### Code d'exemple

```php
// Importez le fichier principal
require_once('main.php');

// Définissez les informations du contact
$contact = [
    'nom' => 'Marie DUBOIS',
    'fonction' => 'Directrice Marketing',
    'mobile' => '06 12 34 56 78',
    'fixe' => '01 23 45 67 89',
    'email' => 'marie.dubois@technosolutions.fr',
    'adresse' => '42, rue de l\'Innovation, 75008 Paris',
    'site_web' => 'www.technosolutions.fr',
    'note' => 'Experte en stratégie digitale'
];

// Générez le QR code
$nomFichier = 'qrcodes/marie_dubois_qr.png';
$generator->generateContactQR(
    $contact['nom'],
    $contact['fonction'],
    $contact['mobile'],
    $contact['fixe'],
    $contact['email'],
    $contact['adresse'],
    $contact['site_web'],
    $contact['note'],
    $nomFichier
);
```

### Personnalisation du QR Code

Vous pouvez modifier les paramètres suivants dans la fonction `genererQRCodeContact()` :

```php
$niveauCorrection = 'L'; // L, M, Q, H (du moins au plus précis)
$taillePixel = 10;       // Taille de chaque pixel du QR code
$tailleCadre = 4;        // Taille de la bordure
```

## 📁 Structure du Projet

```
qrcode-vcard-generator/
├── main.php              # Fichier principal
├── phpqrcode/           # Dossier de la bibliothèque phpqrcode
├── qrcodes/             # Dossier de stockage des QR codes générés
└── README.md            # Documentation
```

## 🔍 Exemples d'Utilisation

Le QR code généré peut être :
- Imprimé sur des cartes de visite
- Partagé numériquement
- Affiché sur un site web
- Intégré dans des signatures email

## 🤝 Contribution

Les contributions sont les bienvenues ! Pour contribuer :

1. Forkez le projet
2. Créez une nouvelle branche (`git checkout -b feature/amelioration`)
3. Committez vos changements (`git commit -am 'Ajout d'une nouvelle fonctionnalité'`)
4. Poussez vers la branche (`git push origin feature/amelioration`)
5. Ouvrez une Pull Request

## 📝 Licence

Ce projet est sous licence MIT - voir le fichier [LICENSE.md](LICENSE.md) pour plus de détails.

## 📫 Contact

Si vous avez des questions ou des suggestions, n'hésitez pas à ouvrir une issue ou à me contacter directement.

## 🙏 Remerciements

- Bibliothèque [phpqrcode](http://phpqrcode.sourceforge.net/)
---

Développé avec ❤️ par 7Lee