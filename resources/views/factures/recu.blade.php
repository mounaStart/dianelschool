 
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu de Paiement</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .logo { max-width: 100px; }
        .content { border: 2px solid #4CAF50; padding: 20px; border-radius: 10px; }
        .footer { text-align: center; margin-top: 30px; font-size: 12px; }
        .signature { margin-top: 50px; text-align: right; }
        .title { color: #4CAF50; font-weight: bold; }
        .info { margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo de RimSchool" class="logo">
        <h2 class="title">Reçu de Paiement</h2>
        <p><strong>RimSchool - Éducation d'Excellence</strong></p>
    </div>

    <div class="content">
        <div class="info">
            <strong>Nom de l'élève :</strong> {{ $facture->eleve->prenom }} {{ $facture->eleve->nom }}
        </div>
        <div class="info">
            <strong>Classe :</strong> {{ $facture->eleve->classe->nom }}
        </div>
        <div class="info">
            <strong>Montant payé :</strong> {{ number_format($facture->montant_total, 2) }} FCFA
        </div>
        <div class="info">
            <strong>Frais :</strong> @foreach($facture->frais as $frais)
                            {{ $frais->nom }}<br>
                        @endforeach
        </div>
        <div class="info">
            <strong>Date d'émission :</strong> {{ $facture->date_emission }}
        </div>
        <div class="info">
            <strong>Date de paiement :</strong> {{ $facture->date_paiement ?? 'Non renseignée' }}
        </div>
    </div>

    <div class="signature">
        ___________________________<br>
        <strong>Signature du Responsable</strong>
    </div>

    <div class="footer">
        <p>Merci de votre confiance. RimSchool vous remercie !</p>
    </div>
</body>
</html>
