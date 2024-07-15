<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('messages.Date Validation Form')</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        body {
            font-family: 'Noto Sans Devanagari', sans-serif;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>@lang('messages.Date Validation Form')</h2>

        <!-- Language Switcher -->
        <div class="d-flex justify-content-end mb-3">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    @lang('messages.Language')
                </button>
                <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                    <li><a class="dropdown-item" href="{{ url('/date-validation?lang=en') }}">@lang('messages.English')</a></li>
                    <li><a class="dropdown-item" href="{{ url('/date-validation?lang=ne') }}">@lang('messages.Nepali')</a></li>
                    <li><a class="dropdown-item" href="{{ url('/date-validation?lang=hi') }}">@lang('messages.Hindi')</a></li>
                </ul>
            </div>
        </div>

        <form action="{{ url('/date-validation') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="start_date_field" class="form-label">@lang('messages.Start Date')</label>
                <input type="text" class="form-control" id="start_date_field" name="start_date_field" required>
            </div>
            <div class="mb-3">
                <label for="end_date_field" class="form-label">@lang('messages.End Date')</label>
                <input type="text" class="form-control" id="end_date_field" name="end_date_field" required>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ str_replace('field ', '', $error) }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <button type="submit" class="btn btn-primary">@lang('messages.Submit')</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ne.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/hi.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var locale = "{{ app()->getLocale() }}";
            var config = {
                dateFormat: 'Y-m-d',
            };

            if (locale === 'ne') {
                config.locale = 'ne';
            } else if (locale === 'hi') {
                config.locale = 'hi';
            }

            flatpickr('#start_date_field', config);
            flatpickr('#end_date_field', config);
        });
    </script>
</body>
</html>
