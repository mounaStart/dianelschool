@php
    $noSidebar = in_array(Route::currentRouteName(), ['login', 'register']);
@endphp

<!-- Barre de navigation -->
<nav class="navbar navbar-expand-md navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/">DianelSchool</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        @if (!$noSidebar && Auth::check() && Auth::user()->hasRole('admin'))
            <!-- Bouton pour masquer/afficher la sidebar pour l'administrateur uniquement -->
            <button class="btn btn-outline-light ml-3" id="toggle-sidebar">
                <i class="fas fa-bars"></i> Menu
            </button>

        @endif

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Inscription</a>
                    </li>
                @else
                    @if(Auth::user()->hasRole('parents'))
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('parents.notes') }}">
                                <i class="fas fa-child"></i> Notes  Enfants
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('parents.notes') }}">
                                <i class="fas fa-graduation-cap"></i> Notes
                            </a>
                        </li>
                    @elseif(Auth::user()->hasRole('enseignant')) 
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="/enseignants/enseignements">
                                <i class="fas fa-chalkboard-teacher"></i> Mes Classes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href=" ">
                                <i class="fas fa-book"></i> Matières
                            </a>
                        </li> -->
                    @endif

                    <!-- Menu déroulant Paramètres (admin uniquement) -->
                    @if(Auth::user()->hasRole('admin'))
                        <li class="nav-item dropdown">
                            <a id="settingsDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cogs"></i>  
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="settingsDropdown">
                                <a class="dropdown-item" href="{{ route('annees_scolaires.index') }}">
                                    <i class="fas fa-calendar-alt"></i> Années Scolaires
                                </a>
                               <a class="dropdown-item" href="/parents/dashboard">
                                    <i class="fas fa-user-friends"></i> Portal Parent
                                </a>

                                 
                            </div>
                        </li>
                    @endif

                    <!-- Menu de profil utilisateur -->
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profil.show') }}">
                                <i class="fas fa-user"></i> Profil
                            </a>

                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Déconnexion
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
