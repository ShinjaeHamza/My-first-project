<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="./styles.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f3f4f6;
            margin: 0;
        }

        .form {
            background-color: #fff;
            display: block;
            padding: 1rem;
            max-width: 350px;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .form-title {
            font-size: 1.25rem;
            line-height: 1.75rem;
            font-weight: 600;
            text-align: center;
            color: #000;
        }

        .input-container {
            position: relative;
            margin-bottom: 1rem;
        }

        .input-container input {
            background-color: #fff;
            padding: 1rem;
            padding-right: 3rem;
            font-size: 0.875rem;
            line-height: 1.25rem;

            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            outline: none;
        }

        .submit {
            display: block;
            padding: 0.75rem 1.25rem;
            background-color: #4F46E5;
            color: #ffffff;
            font-size: 0.875rem;
            line-height: 1.25rem;
            font-weight: 500;
            width: 100%;
            border: none;
            border-radius: 0.5rem;
            text-transform: uppercase;
            cursor: pointer;
            outline: none;
        }

        .submit:hover {
            background-color: #4338ca;
        }

        .signup-link {
            color: #6B7280;
            font-size: 0.875rem;
            line-height: 1.25rem;
            text-align: center;
        }

        .signup-link a {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="form">
        <h2 class="form-title">Registration</h2>
        <form action="register.php" method="post">
            <div class="input-container">
                <label>Username:</label>
                <input type="text" name="username" required>
            </div>
            <div class="input-container">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="submit">Register</button>
        </form>
        <p class="signup-link">Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>

</html>