<x-layout>
    <div class="container-fluid p-5 bg-secondary-subtle text-center">
        <div class="row justify-content-center">
            <div class="col-12">
                <h1 class="display-1">My profile</h1>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">

                <div class="card p-5 shadow">
                    <h2 class="mb-4">Account information</h2>

                    <div class="mb-4">
                        <p class="mb-2 fw-bold">Current roles</p>

                        <span class="badge {{ $user->is_admin ? 'text-bg-success' : 'text-bg-secondary' }}">
                            Admin: {{ $user->is_admin ? 'Yes' : 'No' }}
                        </span>

                        <span class="badge {{ $user->is_revisor ? 'text-bg-success' : 'text-bg-secondary' }}">
                            Revisor: {{ $user->is_revisor ? 'Yes' : 'No' }}
                        </span>

                        <span class="badge {{ $user->is_writer ? 'text-bg-success' : 'text-bg-secondary' }}">
                            Writer: {{ $user->is_writer ? 'Yes' : 'No' }}
                        </span>
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control"
                                value="{{ old('name', $user->name) }}"
                                required
                            >

                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>

                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control"
                                value="{{ old('email', $user->email) }}"
                                required
                            >

                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                New password
                            </label>

                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control"
                                autocomplete="new-password"
                            >

                            <small class="text-muted">
                                Leave empty to keep the current password.
                            </small>

                            @error('password')
                                <span class="d-block text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">
                                Confirm new password
                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="form-control"
                                autocomplete="new-password"
                            >
                        </div>

                        <div class="mt-4 d-flex justify-content-center flex-column align-items-center">
                            <button type="submit" class="btn btn-outline-secondary">
                                Update profile
                            </button>

                            <a href="{{ route('homepage') }}" class="text-secondary mt-2">
                                Back to home
                            </a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-layout>