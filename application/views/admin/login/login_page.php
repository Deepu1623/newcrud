<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Login Form</title>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/sweetalert2.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('<?php echo base_url('assets/images/gymbaclground.jpg'); ?>') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }


        .form-container {
            background: rgba(255, 255, 255, 0.1);
            /* semi-transparent white */
            backdrop-filter: blur(10px);
            /* blurs background behind */
            -webkit-backdrop-filter: blur(10px);
            /* Safari support */
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            width: 320px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
        }


        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #fff;
        }

        label {
            margin-bottom: 5px;
            display: block;
            font-weight: bold;
            color: #fff;
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #28a745;
            outline: none;
        }

        input[type="submit"] {
            background-color: rgb(63, 60, 60);
            color: white;
            border: 1px solid white;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .form-footer a {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: black;
        }

        .form-footer {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #fff;
        }
    </style>

</head>

<body>
    <div class="form-container">
        <h2>Gym Login</h2>
        <form id="loginForm">
            <label for="userID">User ID:</label>
            <input type="text" id="userID" name="userID" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Login">
        </form>
        <div class="form-footer">
            Don't have an account? <a href="<?php echo base_url('User/registration') ?>">Register here</a>
    </div>

    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                const userID = $('#userID').val();
                const password = $('#password').val();

                $.ajax({
                    url: base_url + 'index.php/User/login',
                    type: 'POST',
                    data: {
                        userID: userID,
                        password: password
                    },
                    success: function(response) {
                        if (response.trim() == 'success') {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Login successful.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                // Redirect to the dashboard or homepage
                                window.location.href = 'http://localhost/newcrud/index.php/User/dashboard';
                            });
                        } else if (response.trim() == 'invalid') {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Invalid User ID or Password. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Login failed. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Login failed: ' + xhr.responseText,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>