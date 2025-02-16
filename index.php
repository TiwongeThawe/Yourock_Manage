<?php
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ url_for('static', filename='css/styles.css') }}">
    <title>YouRock</title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center text-primary">YouRock Password Generator</h1>
        <div class="card shadow p-4">
            <form id="passwordForm">
                <div class="mb-3">
                    <label for="length" class="form-label">Password Length</label>
                    <input type="number" class="form-control" id="passwordLength" value="12" min="6" max="32" required>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="uppercase">
                    <label class="form-check-label" for="uppercase">Include Uppercase Letters</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="numbers">
                    <label class="form-check-label" for="numbers">Include Numbers</label>
                </div>
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="specials">
                    <label class="form-check-label" for="specials">Include Special Characters</label>
                </div>
                <button type="submit" id='generate' class="btn btn-primary w-100">Generate Password</button>
            </form>
            <div class="mt-4">
                <label for="generatedPassword" class="form-label">Generated Password</label>
                <input type="text" class="form-control" id="password" readonly>
                <button class="btn btn-success mt-2" id="copyBtn">Copy to Clipboard</button>
            </div>
        </div>
    </div>

    <footer class="footer text-center">
        <div class"container">
            <p>&copy; By Tiwonge Thawe
            </p>
        </div>

    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#passwordForm').on('submit', function(e) {
            e.preventDefault();
            const length = $('#length').val();
            const uppercase = $('#uppercase').is(':checked');
            const numbers = $('#numbers').is(':checked');
            const specials = $('#specials').is(':checked');

            $.ajax({
                url: '/generate',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ length, uppercase, numbers, specials }),
                success: function(response) {
                    $('#generatedPassword').val(response.password);
                }
            });
        });

        $('#copyBtn').on('click', function() {
            const passwordField = document.getElementById('generatedPassword');
            passwordField.select();
            document.execCommand('copy');
            alert('Password copied to clipboard!');
        });
    </script>
</body>
</html>