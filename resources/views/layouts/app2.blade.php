<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DianelSchool</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa;
        }
body {
        padding-top: 70px; /* Ajuste à la hauteur réelle de ta navbar */
    }
        /* Barre de navigation */
        .navbar {
            background-color: #343a40;
            color: #fff;
        }
        .navbar-brand {
            color: #f8f9fa;
        }
        .navbar-nav .nav-link {
            color: #f8f9fa;
        }

        /* Menu vertical avec défilement */
        .sidebar {
            height: calc(100vh - 56px); /* Prend toute la hauteur, moins la barre de navigation */
            background-color: #343a40;
            color: #fff;
            padding: 10px;
            position: fixed;
            top: 56px;
            left: 0;
            width: 190px;
            overflow-y: auto; /* Activer le défilement vertical */
            transition: all 0.3s ease;
        }

        /* Masquer la sidebar quand elle est cachée */
        .sidebar-hidden {
            transform: translateX(-220px);
        }

        .sidebar a {
            color: #fff;
            padding: 15px;
            display: block;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .sidebar .active {
            /* background-color: #007bff; */

            background-color: blue; /* Couleur de fond bleue */
    color: white; /* Couleur du texte en blanc */
        }

        /* Contenu principal */
        .content {
    margin-left: 220px;
    padding: 20px;
    margin-top: 70px; /* Ajouté pour éviter que les cartes soient cachées */
    transition: all 0.3s ease;
}
.sidebar-admin {
    width: 220px;
    position: fixed;
    top: 70px; /* pour être aligné avec navbar si elle est fixed */
    left: 0;
    height: 100%;
    background-color: #343a40;
}

        /* Réduire la marge quand la sidebar est cachée */
        .content.content-expanded {
            margin-left: 0;
        }

        .photo-preview {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border: 2px solid #ddd;
            border-radius: 5px;
            margin-top: 10px;
        }

        .form-section {
            margin-bottom: 20px;
        }
        .form-section .form-group {
            margin-bottom: 15px;
        }
        
    /* Style des liens du menu déroulant */
    .submenu-links {
        padding-left: 0;
        margin-top: 10px;
    }

    .submenu-links .submenu-item {
        background-color: #f8f9fa; /* Couleur de fond des liens */
        padding: 10px 15px;
        color: #495057; /* Couleur du texte */
        border: 1px solid transparent; /* Bordure transparente pour l'espace */
        transition: background-color 0.3s ease, border 0.3s ease;
        text-decoration: none;
        display: block;
        border-radius: 4px; /* Coins arrondis */
    }

    .submenu-links .submenu-item:hover {
        background-color: #007bff; /* Couleur au survol */
        color: white; /* Couleur du texte au survol */
        border: 1px solid #0056b3; /* Bordure au survol */
    }

    /* Style du bouton Ajouter Élève */
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        padding: 10px 20px;
        font-size: 16px;
    }

    .btn-primary:hover {
        background-color: #0056b3; /* Couleur au survol */
        border-color: #0056b3;
    }

    /* Ajustement de la largeur du bouton déroulant pour mieux s'aligner */
    .btn-secondary.dropdown-toggle {
        width: 100%;
        text-align: left;
    }

    /* Style spécifique pour le bouton d'action */
    .btn-secondary.dropdown-toggle::after {
        float: right;
        margin-top: 5px;
    }
 


    /* Assure une bonne visibilité de l'icône */
.icon-container {
    color: white; /* Couleur de l'icône pour qu'elle ressorte */
    opacity: 0.8; /* Ajuste l'opacité si besoin pour plus de lisibilité */
}

/* Style de la carte pour améliorer la disposition */
.card-title {
    font-weight: bold;
    font-size: 1.25rem;
}

.card-footer p {
    font-weight: bold;
    color: white; /* Couleur du total */
}
.photo-container {
        width: 100%; /* La largeur dépend de col-md-4 */
        padding-top: 40%; /* Maintient un ratio 1:1 basé sur la largeur */
        position: relative; /* Nécessaire pour placer l'image correctement */
    }

    .photo-preview {
        position: absolute; /* Place l'image dans le conteneur */
        top: 0;
        left: 0;
        width: 100%; /* L'image occupe toute la largeur du conteneur */
        height: 100%; /* L'image occupe toute la hauteur du conteneur */
        object-fit: cover; /* Assure que l'image remplit le conteneur sans déformation */
        border: 2px solid #ddd; /* Ajoute une bordure élégante */
    }


    </style>
</head>
<body>
  

@include('partials.navbar')

 
     
        @if(Auth::user() && Auth::user()->hasRole('admin'))
            @include('partials.sidebar-admin')

            <div class="content " id="main-content">
                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        @else
            <div class="col-md-12">
                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        @endif
  
 

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#toggle-sidebar').click(function() {
                $('#sidebar').toggleClass('sidebar-hidden');
                $('#main-content').toggleClass('content-expanded');
            });
        });
    </script>
<script>

document.addEventListener("DOMContentLoaded", function() {
    const element = document.getElementById('votre-element-id'); // Remplacez par l'ID de votre élément
    if (element) {
        element.addEventListener('click', function() {
            // Votre code ici

            document.getElementById('validerAnneeScolaire').addEventListener('click', function() {
        const anneeScolaireId = document.getElementById('annee_scolaire_id').value;
        
        // Ajoutez l'année scolaire sélectionnée au formulaire
        const inputHiddenAnneeScolaire = document.createElement('input');
        inputHiddenAnneeScolaire.type = 'hidden';
        inputHiddenAnneeScolaire.name = 'annee_scolaire_id';
        inputHiddenAnneeScolaire.value = anneeScolaireId;
        document.querySelector('#formulaireInscription form').appendChild(inputHiddenAnneeScolaire);

        // Fermer le modal
        $('#anneeScolaireModal').modal('hide');

        // Afficher le formulaire d'inscription
        document.getElementById('formulaireInscription').style.display = 'block';
    });
        });
    }
});


  
</script>

    <!-- JavaScript pour afficher l'aperçu de la photo -->
    <script>
        function previewPhoto() {
            const file = document.getElementById('photo').files[0];
            const preview = document.getElementById('photoPreview');

            const reader = new FileReader();
            reader.onloadend = function() {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }
    </script>
<script>
    $(document).ready(function () {
        console.log("jQuery est bien chargé !");
    });
</script>
<script>
    $(document).ready(function () {
    $('#classe_id').change(function () {
        var classeId = $(this).val();
        console.log("Classe sélectionnée : ", classeId);

        if (classeId) {
            $.ajax({
                url: '{{ route("notes.get") }}',
                method: 'GET',
                data: { classe_id: classeId },
                dataType: 'html',
                success: function (response) {
                    console.log("Réponse AJAX :", response);
                    $('#notesContainer').html(response);
                },
                error: function (xhr, status, error) {
                    console.error("Erreur AJAX :", xhr.responseText);
                    $('#notesContainer').html('<p>Une erreur est survenue lors du chargement des notes.</p>');
                }
            });
        } else {
            $('#notesContainer').html('<p>Sélectionnez une classe pour afficher les notes.</p>');
        }
    });
});

</script> 
<script>
    $(document).ready(function() {
        $('#classe_id').on('change', function() {
            var classeId = $(this).val();
            if(classeId) {
                $.ajax({
                    url: '/matieres/' + classeId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#matiere_id').empty();
                        $('#matiere_id').append('<option value="">-- Sélectionnez une matière --</option>');
                        $.each(data, function(key, value) {
                            $('#matiere_id').append('<option value="'+ value.matiere.id +'">'+ value.matiere.nom +'</option>');
                        });
                    }
                });
            } else {
                $('#matiere_id').empty();
                $('#matiere_id').append('<option value="">-- Sélectionnez une matière --</option>');
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#classe_id').change(function() {
            let classeId = $(this).val();

            if (classeId) {
                $.ajax({
                    url: "{{ route('get.eleves.par.classe') }}",
                    type: 'GET',
                    data: { classe_id: classeId },
                    success: function(data) {
                        $('#eleve_id').empty();
                        $('#eleve_id').append('<option value="" disabled selected>-- Sélectionner un élève --</option>');

                        $.each(data, function(index, eleve) {
                            $('#eleve_id').append(
                                `<option value="${eleve.id}">${eleve.prenom} ${eleve.nom}</option>`
                            );
                        });
                    }
                });
            } else {
                $('#eleve_id').empty().append('<option value="" disabled selected>-- Sélectionner un élève --</option>');
            }
        });
    });
</script>
@yield('scripts')

</body>
</html>
