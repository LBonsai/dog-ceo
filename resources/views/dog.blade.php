<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App Name -->
    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>

<body>
    <div class="container mt-4">
        <button type="button" class="btn btn-primary" id="add-btn" data-toggle="modal" data-target="#formModal">
            Add New Dog
        </button>
        <div class="table-container">
            <table class="table table-bordered table-sticky">
                <caption>Data Table</caption>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Url</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="data-list"></tbody>
            </table>
        </div>

        <div id="imageDisplayer">
            <div class="centered-content">
                <img id="displayedImage" src="" alt="No Image"/>
                <div class="button-container">
                    <button class="btn btn-primary" id="fetch-image">Fetch Random Image</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="formModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="data-form">
                    <div class="modal-header">
                        <h5 class="modal-title">Register Form</h5>
                        <button type="button" class="close" data-dismiss="modal" id="btn-close-icon" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="form-group">
                            <label for="url">URL</label>
                            <input type="text" class="form-control" name="url" id="url" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-save" id="btn-save">Create</button>
                        <button type="button" class="btn btn-secondary btn-close" id="btn-close" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
