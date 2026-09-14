@extends('layouts.layout')

@section('content')
    @vite('/resources/css/films.css')
    <style>
        /* Card Layout Tweaks */
        .admin-actions { display: flex; gap: 10px; margin-top: 15px; }
        .btn-edit { background: none; color: #3aff7c; cursor: pointer; font-size: 13px; font-weight: 600; padding: 6px 12px; border: 1px solid rgba(58, 255, 124, 0.3); border-radius: 8px; transition: 0.2s; }
        .btn-edit:hover { background: rgba(58, 255, 124, 0.1); }
        .btn-delete { background: none; color: #ff3a5e; cursor: pointer; font-size: 13px; font-weight: 600; padding: 6px 12px; border: 1px solid rgba(255, 58, 94, 0.3); border-radius: 8px; transition: 0.2s; }
        .btn-delete:hover { background: rgba(255, 58, 94, 0.1); }
        .employee-avatar { width: 100%; aspect-ratio: 1; background: #101214; border-radius: 16px; display: grid; place-items: center; font-size: 48px; color: #3aff7c; border: 1px solid #292d32; }

        /* Modal Styles */
        .modal-overlay { position: fixed; inset: 0; z-index: 999; background: rgba(4, 5, 6, 0.85); backdrop-filter: blur(8px); display: none; place-items: center; padding: 20px; opacity: 0; transition: opacity 0.3s ease; }
        .modal-overlay.active { display: grid; opacity: 1; }
        .modal-content { width: 100%; max-width: 600px; background: #080a0c; border: 1px solid #25282d; border-radius: 16px; padding: 40px; position: relative; transform: translateY(20px); transition: transform 0.3s ease; }
        .modal-overlay.active .modal-content { transform: translateY(0); }
        .modal-close { position: absolute; top: 20px; right: 20px; background: none; border: none; color: #a9adb4; font-size: 24px; cursor: pointer; transition: color 0.2s; }
        .modal-close:hover { color: #fff; }
        .modal-title { margin: 0 0 25px; font-size: 24px; font-weight: 800; color: #fff; }
        .modal-title span { color: #36ff78; }

        /* Form Styles */
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; color: #a9adb4; font-size: 13px; font-weight: 700; margin-bottom: 8px; letter-spacing: 1px; }
        .form-control { width: 100%; height: 48px; padding: 0 17px; background: #0b0d0f; border: 1px solid #25282d; border-radius: 12px; color: #fff; font: inherit; font-size: 14px; transition: 0.2s; box-sizing: border-box; }
        .form-control:focus { border-color: #39f57a; background: #0e1113; outline: none; }
        .form-row { display: flex; gap: 16px; }
        .form-row .form-group { flex: 1; }
        .submit-btn { width: 100%; height: 50px; background: #37f678; color: #050706; border: none; border-radius: 12px; font-size: 15px; font-weight: 700; cursor: pointer; transition: 0.2s; margin-top: 10px; }
        .submit-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(54, 255, 119, 0.3); }
    </style>

    <main class="films-page">
        <section class="films-hero" style="padding-bottom: 60px;">
            <div class="page-container">
                <div class="films-hero__content">
                    <span class="section-label">ADMIN PANEEL</span>
                    <h1>Medewerkers <span>Beheer</span></h1>
                </div>
            </div>
        </section>

        <section class="films-section" style="padding-top: 0;">
            <div class="page-container">
                <div class="films-section__header">
                    <div>
                        <h2>Alle Medewerkers</h2>
                    </div>
                    <button type="button" class="header__login" style="width: auto; cursor: pointer;" onclick="openModal('addModal')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        <span>Nieuwe Medewerker</span>
                    </button>
                </div>

                <div class="films-grid">
                    @foreach ($employees as $employee)
                        <article class="film-card">
                            <div class="employee-avatar">
                                {{ strtoupper(substr($employee->first_name, 0, 1)) }}{{ strtoupper(substr($employee->surname, 0, 1)) }}
                            </div>

                            <div class="film-card__content">
                                <div class="film-card__top">
                                    <h3>{{ $employee->first_name }} {{ $employee->prefix }} {{ $employee->surname }}</h3>
                                </div>

                                <p style="margin-bottom: 5px;">
                                    <strong>Email:</strong> {{ $employee->email }}<br>
                                    <strong>Rol:</strong> {{ $employee->role_name }}
                                </p>

                                <div class="admin-actions">
                                    <!-- Pass employee data into data-attributes for JS to read -->
                                    <button type="button" class="btn-edit"
                                            data-id="{{ $employee->id }}"
                                            data-first="{{ $employee->first_name }}"
                                            data-prefix="{{ $employee->prefix }}"
                                            data-surname="{{ $employee->surname }}"
                                            data-dob="{{ $employee->date_of_birth }}"
                                            data-email="{{ $employee->email }}"
                                            data-role="{{ $employee->fk_role }}"
                                            onclick="openEditModal(this)">
                                        Bewerken
                                    </button>

                                    <form action="{{ route('medewerkers.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze medewerker wilt verwijderen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">Verwijderen</button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    <!-- ADD MODAL -->
    <div id="addModal" class="modal-overlay">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal('addModal')">&times;</button>
            <h2 class="modal-title">Nieuwe <span>Medewerker</span></h2>

            <form action="{{ route('medewerkers.store') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group" style="flex: 2;">
                        <label>VOORNAAM</label>
                        <input type="text" name="first_name" class="form-control" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>TUSSENVOEGSEL</label>
                        <input type="text" name="prefix" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label>ACHTERNAAM</label>
                    <input type="text" name="surname" class="form-control" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>GEBOORTEDATUM</label>
                        <input type="date" name="date_of_birth" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>ROL</label>
                        <select name="fk_role" class="form-control" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>EMAILADRES</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>WACHTWOORD</label>
                    <input type="password" name="password" class="form-control" required minlength="8">
                </div>
                <button type="submit" class="submit-btn">Opslaan</button>
            </form>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div id="editModal" class="modal-overlay">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal('editModal')">&times;</button>
            <h2 class="modal-title">Bewerk <span>Medewerker</span></h2>

            <!-- Action URL updated dynamically by JS -->
            <form id="editForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="form-group" style="flex: 2;">
                        <label>VOORNAAM</label>
                        <input type="text" name="first_name" id="edit_first_name" class="form-control" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>TUSSENVOEGSEL</label>
                        <input type="text" name="prefix" id="edit_prefix" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label>ACHTERNAAM</label>
                    <input type="text" name="surname" id="edit_surname" class="form-control" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>GEBOORTEDATUM</label>
                        <input type="date" name="date_of_birth" id="edit_date_of_birth" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>ROL</label>
                        <select name="fk_role" id="edit_fk_role" class="form-control" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>EMAILADRES</label>
                    <input type="email" name="email" id="edit_email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>NIEUW WACHTWOORD (Optioneel)</label>
                    <input type="password" name="password" class="form-control" minlength="8" placeholder="Laat leeg om te behouden">
                </div>
                <button type="submit" class="submit-btn">Wijzigingen Opslaan</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.add('active');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
            document.body.style.overflow = '';
        }

        function openEditModal(btn) {
            // Read data attributes from the clicked button
            const id = btn.getAttribute('data-id');

            // Dynamically set the form action URL to point to the correct employee ID
            document.getElementById('editForm').action = `/medewerkers/${id}`;

            // Populate inputs
            document.getElementById('edit_first_name').value = btn.getAttribute('data-first');
            document.getElementById('edit_prefix').value = btn.getAttribute('data-prefix');
            document.getElementById('edit_surname').value = btn.getAttribute('data-surname');
            document.getElementById('edit_date_of_birth').value = btn.getAttribute('data-dob');
            document.getElementById('edit_email').value = btn.getAttribute('data-email');
            document.getElementById('edit_fk_role').value = btn.getAttribute('data-role');

            openModal('editModal');
        }

        // Close modals when clicking outside the content box
        window.onclick = function(event) {
            if (event.target.classList.contains('modal-overlay')) {
                event.target.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
    </script>
@endsection
