<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <form id="userForm">
                    @csrf
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="phone" placeholder="Phone">
                    </div>
                    <div class="form-group">
                    <select name="role_id" class="form-control">
                        <option value="">Select Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col-md-6">
                <div id="errors" style="color: red;"></div>
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody id="usersTable">
                        @foreach($user as $value)
                        <tr>
                                    <td>{{$value->email ?? ''}}</td>
                                    <td>{{$value->phone ?? ''}}</td>
                                    <td>{{$value->role->name ?? ''}}</td>
                                    
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#userForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('saveData') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#errors').html('');
                        $('#userForm')[0].reset();
                        $('#usersTable').prepend(`
                            <tr>
                                <td>${response.email ?? ''}</td>
                                <td>${response.phone ?? ''}</td>
                                <td>${response.role.name ?? ''}</td>
                            </tr>
                        `);
                    },
                    error: function(xhr) {
                        // Display validation errors
                        var errors = xhr.responseJSON.errors;
                        var errorHtml = '';
                        $.each(errors, function(key, value) {
                            errorHtml += `<p>${value}</p>`;
                        });
                        $('#errors').html(errorHtml);
                    }
                });
            });
        });
    </script>
</body>
</html>
