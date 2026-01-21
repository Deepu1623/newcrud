<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            margin-bottom: 5px;
            display: block;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="password"] {
            width: calc(100% - 22px);
            /* Full width minus padding */
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="password"]:focus {
            border-color: #28a745;
            /* Change border color on focus */
            outline: none;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .form-footer {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #777;
        }
    </style>
  
</head>

<body>
    <div class="form-container">
        <h2>Gym Registration</h2>
        <form id="registrationForm">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="phone">Phone No:</label>
            <input type="number" id="phone" name="phone" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="userID">User ID:</label>
            <input type="text" id="userID" name="userID" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Register">
        </form>
        <div class="form-footer">
            Already have an account? <a href="<?php echo base_url('/index.php/User/loginpage') ?>">Login here</a>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#registrationForm').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                const name = $('#name').val();
                const phone = $('#phone').val();
                const email = $('#email').val();
                const userID = $('#userID').val();
                const password = $('#password').val();
                 const base_url = "<?= base_url(); ?>";
                
                $.ajax({
                    url: base_url + 'index.php/User/register',
                    type: 'POST',
                    data: {
                        name: name,
                        phone: phone,
                        userID: userID,
                        password: password,
                        email: email

                    },
                    success: function(response) {
                        if (response.trim() == 'success') {
                            Swal.fire({
                                    title: 'Success!',
                                    text: 'User registration successfully completed.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                })
                                .then(() => {
                                    // Redirect to the login page after the user clicks 'OK'
                                    window.location.href = base_url +'index.php/User/loginpage';
                                });
                        } else if (response.trim() == 'exists') {
                            Swal.fire({
                                title: 'Error!',
                                text: 'User ID already exists. Please try a new ID.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Registration failed. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Registration failed: ' + xhr.responseText,
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