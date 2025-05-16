<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rappel de Paiement</title>
</head>
<body>
    <h2>Rappel de Paiement - RimSchool</h2>

    <p>Bonjour {{ $facture->eleve->prenom }} {{ $facture->eleve->nom }},</p>

    <p>Nous vous rappelons que votre facture n°{{ $facture->id }} d'un montant de 
       <strong>{{ number_format($facture->montant_total, 2) }} FCFA</strong> est en retard.</p>

    <p>La date limite de paiement était le <strong>{{ $facture->date_echeance }}</strong>.</p>

    <p>Merci de régulariser votre situation dans les plus brefs délais.</p>

    <p>Cordialement,</p>
    <p><strong>L'équipe RimSchool</strong></p>
</body>
</html>
