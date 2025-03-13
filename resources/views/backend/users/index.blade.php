<div class="mt-4">
    <h2>Users</h2>
     <a href="{{ route('backend.users.create') }}" class="btn btn-warning mb-3 fw-bold">+ Add User</a>
    <div class="card p-3">
        <div class="d-flex justify-content-end mb-3">
            <label>Search: <input type="text" class="form-control form-control-sm"></label>
        </div>
        <table class="table table-bordered">
            <thead class="table-warning">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->password }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <p>Showing {{ $users->count() }} entries</p>
    </div>
</div>