<?php

class VCardQRGenerator {
    private $defaultConfig = [
        'niveauCorrection' => 'L',
        'taillePixel' => 10,
        'tailleCadre' => 4,
        'dossierQRCodes' => 'qrcodes',
        'organisation' => 'TechnoSolutions Industries'
    ];

    private $config;

    public function __construct(array $config = []) {
        $this->config = array_merge($this->defaultConfig, $config);
        $this->initializeDirectory();
    }

    /**
     * Initialise le dossier de stockage des QR codes
     * @throws Exception si le dossier ne peut pas être créé
     */
    private function initializeDirectory(): void {
        if (!is_dir($this->config['dossierQRCodes'])) {
            if (!mkdir($this->config['dossierQRCodes'], 0755, true)) {
                throw new Exception("Impossible de créer le dossier " . $this->config['dossierQRCodes']);
            }
        }
    }

    /**
     * Valide les données du contact
     * @param array $contactData Données du contact
     * @throws Exception si les données sont invalides
     */
    private function validateContactData(array $contactData): void {
        $requiredFields = ['nom', 'fonction', 'mobile', 'fixe', 'email', 'adresse', 'site_web'];
        
        foreach ($requiredFields as $field) {
            if (empty($contactData[$field])) {
                throw new Exception("Le champ '{$field}' est requis");
            }
        }

        if (!filter_var($contactData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("L'adresse email n'est pas valide");
        }
    }

    /**
     * Génère le contenu vCard
     * @param array $contact Données du contact
     * @return string Contenu vCard formaté
     */
    private function generateVCardContent(array $contact): string {
        return "BEGIN:VCARD\n" .
               "VERSION:3.0\n" .
               "ORG:" . $this->config['organisation'] . "\n" .
               "FN:" . $contact['nom'] . "\n" .
               "TITLE:" . $contact['fonction'] . "\n" .
               "TEL;TYPE=CELL:" . $contact['mobile'] . "\n" .
               "TEL;TYPE=WORK:" . $contact['fixe'] . "\n" .
               "EMAIL:" . $contact['email'] . "\n" .
               "ADR:;;" . $contact['adresse'] . "\n" .
               "URL:" . $contact['site_web'] . "\n" .
               "NOTE:" . ($contact['note'] ?? '') . "\n" .
               "END:VCARD";
    }

    /**
     * Génère un QR Code pour un contact
     * @param array $contact Données du contact
     * @param string|null $customFilename Nom de fichier personnalisé
     * @return string Chemin du fichier QR code généré
     * @throws Exception en cas d'erreur
     */
    public function generateContactQR(array $contact, ?string $customFilename = null): string {
        try {
            // Validation des données
            $this->validateContactData($contact);

            // Génération du nom de fichier
            $filename = $customFilename ?? $this->generateFilename($contact['nom']);
            $fullPath = $this->config['dossierQRCodes'] . '/' . $filename;

            // Génération du contenu vCard
            $vcard = $this->generateVCardContent($contact);

            // Génération du QR Code
            if (!class_exists('QRcode')) {
                require_once('phpqrcode/qrlib.php');
            }

            QRcode::png(
                $vcard,
                $fullPath,
                $this->config['niveauCorrection'],
                $this->config['taillePixel'],
                $this->config['tailleCadre']
            );

            return $fullPath;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la génération du QR code : " . $e->getMessage());
        }
    }

    /**
     * Génère un nom de fichier standardisé
     * @param string $nom Nom du contact
     * @return string Nom de fichier formaté
     */
    private function generateFilename(string $nom): string {
        $nom = strtolower(trim($nom));
        $nom = preg_replace('/[^a-z0-9]/', '_', $nom);
        return $nom . '_qr.png';
    }
}

// Exemple d'utilisation
try {
    // Initialisation du générateur
    $generator = new VCardQRGenerator();

    // Définition des informations du contact
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

    // Génération du QR code
    $qrCodePath = $generator->generateContactQR($contact);
    echo "QR Code généré avec succès : " . basename($qrCodePath);

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
    exit(1);
}