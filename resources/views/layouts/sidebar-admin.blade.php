 <div class="sidebar-admin">
  <div class="sidebar" id="sidebar">
            <a href="/" class="{{ Request::is('/') ? 'active' : '' }}"><i class="fas fa-money-bill-wave"></i> Tableaux de bord</a>
            <a href="{{ route('eleves.index') }}" class="{{ Request::is('eleves*') ? 'active' : '' }}"><i class="fas fa-users"></i> Élèves</a>
            
            <a href="{{ route('classes.index') }}" class="{{ Request::is('classes*') ? 'active' : '' }}"><i class="fas fa-door-open"></i> Classes</a>
            <a href="{{ route('absences.index') }}" class="{{ Request::is('absences*') ? 'active' : '' }}"><i class="fas fa-door-open"></i> Gestion Suivies</a>
            
            <a href="{{ route('enseignements.index') }}"  class="{{ Request::is('enseignements*') ? 'active' : '' }}"><i class="fas fa-chalkboard-teacher"></i> Enseignements</a>
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
            <a href="#" class="{{ Request::is('*') ? 'active' : '' }}"><i class="fas fa-cogs"></i> </a>

        </div>
           </div>