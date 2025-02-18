<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Manager</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/YOUR-FONTAWESOME-KEY.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">
    
    <div class="container mt-5">
        <h2 class="text-center">Your Passwords</h2>
        <div class="text-end mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPasswordModal">
                <i class="fas fa-plus"></i> Add New
            </button>
        </div>
        
        <table class="table table-striped table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Website</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="passwordTable">
                <!-- Dynamic content will be loaded here -->
            </tbody>
        </table>
    </div>
    
    <!-- Modal for Adding New Password -->
    <div class="modal fade" id="addPasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="passwordForm">
                        <div class="mb-3">
                            <label class="form-label">Website</label>
                            <input type="text" class="form-control" id="website" name="website" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Editing Password -->
    <!-- Edit Password Modal -->
<div class="modal fade" id="editPasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editPasswordForm">
                    <input type="hidden" id="editId">
                    <div class="mb-3">
                        <label class="form-label">Website</label>
                        <input type="text" class="form-control" id="editWebsite" name="website" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" id="editUsername" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control" id="editPassword" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
    
    <script>
        $(document).ready(function () {
            // Load passwords
            function loadPasswords() {
                $.get("./get_passwords.php", function (data) {
                    let passwords = JSON.parse(data);
                    let html = "";
        
                    passwords.forEach((pw) => {
                        html += `
                            <tr>
                                <td>${pw.website}</td>
                                <td>${pw.username}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning edit-btn" data-id="${pw.id}" data-website="${pw.website}" data-username="${pw.username}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-btn" data-id="${pw.id}">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
        
                    $("#passwordTable").html(html);
                });
            }
        
            loadPasswords();
        
            // Save password
            $("#passwordForm").submit(function (e) {
                e.preventDefault();
        
                let website = $("#website").val();
                let username = $("#username").val();
                let password = $("#password").val();
        
                $.post("./save_password.php", { website, username, password }, function (response) {
                    alert(response);
                    loadPasswords();
                    $("#addPasswordModal").modal("hide");
                });
            });
        
            // Edit password
            $(document).on("click", ".edit-btn", function () {
                let id = $(this).data("id");
                let website = $(this).data("website");
                let username = $(this).data("username");
        
                $("#editId").val(id);
                $("#editWebsite").val(website);
                $("#editUsername").val(username);
                $("#editPasswordModal").modal("show");
            });
        
            $("#editPasswordForm").submit(function (e) {
                e.preventDefault();
        
                let id = $("#editId").val();
                let website = $("#editWebsite").val();
                let username = $("#editUsername").val();
                let password = $("#editPassword").val();
        
                $.post("./edit_password.php", { id, website, username, password }, function (response) {
                    alert(response);
                    loadPasswords();
                    $("#editPasswordModal").modal("hide");
                });
            });
        
            // Delete password
            $(document).on("click", ".delete-btn", function () {
                if (confirm("Are you sure you want to delete this password?")) {
                    let id = $(this).data("id");
        
                    $.post("./delete_password.php", { id }, function (response) {
                        alert(response);
                        loadPasswords();
                    });
                }
            });
        
        });
        
        
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
