 <!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RimSchool</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa;
           
        }

        .navbar {
            background-color: #343a40;
            color: #fff;
        }

        .navbar-brand, .navbar-nav .nav-link {
            color: #f8f9fa;
        }

        .sidebar {
            height: calc(100vh - 56px);
            background-color: #343a40;
            color: #fff;
            padding: 10px;
            position: fixed;
            top: 56px;
            left: 0;
            width: 190px;
            overflow-y: auto;
            transition: all 0.3s ease;
        }

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
            background-color: blue;
            color: white;
        }

        .content {
            margin-left: 220px;
            padding: 20px;
            margin-top: 70px;
            transition: all 0.3s ease;
        }

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
    </style>
</head>
<body>
    @include('partials.navbar') <!-- Si tu as une navbar à inclure -->

   
 @if(Auth::user() && Auth::user()->hasRole('admin'))
    <!-- Layout avec sidebar -->
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <a href="/" class="{{ Request::is('/') ? 'active' : '' }}"><i class="fas fa-money-bill-wave"></i> Tableaux de bord</a>
            <a href="{{ route('eleves.index') }}" class="{{ Request::is('eleves*') ? 'active' : '' }}"><i class="fas fa-users"></i> Élèves</a>
            <a href="{{ route('classes.index') }}" class="{{ Request::is('classes*') ? 'active' : '' }}"><i class="fas fa-door-open"></i> Classes</a>
            <a href="{{ route('absences.index') }}" class="{{ Request::is('absences*') ? 'active' : '' }}"><i class="fas fa-door-open"></i> Gestion Suivies</a>
            <a href="{{ route('enseignements.index') }}" class="{{ Request::is('enseignements*') ? 'active' : '' }}"><i class="fas fa-chalkboard-teacher"></i> Enseignements</a>
            <a href="{{ route('matiers.index') }}" class="{{ Request::is('matieres*') ? 'active' : '' }}"><i class="fas fa-book"></i> Matières</a>
            <a href="{{ route('emplois-du-temps.index') }}" class="{{ Request::is('emplois*') ? 'active' : '' }}"><i class="fas fa-calendar-alt"></i> Emplois du temps</a>
            <a href="{{ route('notes.index') }}" class="{{ Request::is('notes*') ? 'active' : '' }}"><i class="fas fa-clipboard"></i> Notes</a>
            <a href="{{ route('evaluations.index') }}" class="{{ Request::is('evaluations*') ? 'active' : '' }}"><i class="fas fa-clipboard"></i> Evaluations</a>
            <a href="{{ route('frais.index') }}" class="{{ Request::is('frais*') ? 'active' : '' }}"><i class="fas fa-money-bill-wave"></i> Scolarités</a>
            <a href="#" class="{{ Request::is('salles*') ? 'active' : '' }}"><i class="fas fa-school"></i> Salles</a>
            <a href="#" class="{{ Request::is('cours*') ? 'active' : '' }}"><i class="fas fa-book-open"></i> Cours</a>
            <a href="#" class="{{ Request::is('cycles*') ? 'active' : '' }}"><i class="fas fa-graduation-cap"></i> Cycles</a>
            <a href="#" class="{{ Request::is('personnels*') ? 'active' : '' }}"><i class="fas fa-user-shield"></i> Personnels</a>
            <a href="#" class="{{ Request::is('parametres*') ? 'active' : '' }}"><i class="fas fa-cogs"></i> Paramètres</a>
        </div>

        <!-- Content -->
        <div class="content flex-grow-1" id="main-content">
            @yield('content')
        </div>
    </div>
@else
    <!-- Plein écran sans sidebar -->
   <div class="container-fluid" id="main-content" style="padding-top: 70px;">

        @yield('content')
    </div>
@endif


    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
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
</body>
</html>
