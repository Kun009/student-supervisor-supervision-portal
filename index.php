<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Custom CSS -->
    <style>
       body {
    background-color: #f8f9fa;
    background-image: url('../projectsupervision/imageedit_1_9134895484.png'); /* Replace with the path to your watermark image */
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    position: relative;
}

.login-option {
    text-align: center;
    margin: 20px;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.5s, transform 0.5s;
}

.animated {
    opacity: 1;
    transform: translateY(0);
}

    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 login-option" id="studentOption">
            <button class="btn btn-primary btn-lg btn-block" onclick="redirectTo('../projectsupervision/student')">
                <i class="fas fa-user-graduate fa-3x"></i>
                <p>Student</p>
            </button>
        </div>
        <div class="col-md-4 login-option" id="lecturerOption">
            <button class="btn btn-success btn-lg btn-block" onclick="redirectTo('../projectsupervision/lecturer')">
                <i class="fas fa-chalkboard-teacher fa-3x"></i>
                <p>Lecturer</p>
            </button>
        </div>
        <div class="col-md-4 login-option" id="adminOption">
            <button class="btn btn-danger btn-lg btn-block" onclick="redirectTo('../projectsupervision/admin')">
                <i class="fas fa-user-cog fa-3x"></i>
                <p>Admin</p>
            </button>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Custom JS -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        animateLoginOptions();
    });

    function animateLoginOptions() {
        var loginOptions = document.querySelectorAll('.login-option');
        loginOptions.forEach(function(option, index) {
            setTimeout(function() {
                option.classList.add('animated');
            }, index * 200);
        });
    }

    function redirectTo(url) {
        // You can add any additional logic before redirecting if needed
        window.location.href = url;
    }
</script>

</body>
</html>
