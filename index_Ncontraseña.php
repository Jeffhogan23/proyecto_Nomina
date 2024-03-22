<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <title>Recuperar Contraseña</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif;
        }

        section {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;
            background: url("img/conta.png") no-repeat;
            filter: brightness(98%);
            background-position: center;
            background-size: cover;
        }

        .form-box {
            position: relative;
            width: 400px;
            height: 450px;
            background: transparent;
            border: none;
            border-radius: 20px;
            backdrop-filter: blur(15px) brightness(80%);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        h2 {
            font-size: 2em;
            color: #fff;
            text-align: center;
        }

        .input-container {
            margin-bottom: 20px;
            margin-right: 10px;
            position: relative;
        }

        .input-container label {
            display: block;
            color: #fff;
            margin-bottom: 2px;
        }

        .input-container input {
            width: calc(100% - 40px); /* Modificado para dar espacio al botón */
            height: 40px;
            border: none;
            border-radius: 5px;
            padding: 0 10px;
            font-size: 1em;
            background-color: rgba(255, 255, 255, 0.7);
            transition: background-color 0.3s;
            padding-right: 40px; /* Añadido para espacio al icono */
        }

        .input-container input:focus {
            background-color: rgba(255, 255, 255, 0.9);
        }

        .show-hide-password {
            position: absolute;
            top: 65%;
            transform: translateY(-50%);
            right: 2px;
            width: 30px; /* Ancho del botón */
            height: 30px;
            background: transparent;
            border: none;
            cursor: pointer;
            outline: none;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .show-hide-password ion-icon {
            font-size: 1.5em; /* Aumentado el tamaño del icono */
            color: #555;
        }

        button[type="submit"] {
            width: 80%;
            height: 40px;
            margin-top: 15px;
            margin-left: 40px;
            border-radius: 40px;
            background-color: #ffffff;
            border: none;
            outline: none;
            cursor: pointer;
            font-size: 1em;
            font-weight: bold;
            color: #000000;
            transition: background-color 0.3s, transform 0.2s;
        }

        button[type="submit"]:hover {
            background-color: #7e200b;
            color: white;
            transition: ease-in .2s;
        }

        button[type="submit"]:active {
            background-color: #004080;
            transition: ease-in .2s;
        }

        .error-message {
            color: red;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <section>
        <div class="form-box">
            <div class="container">
                <h2 style="margin-bottom: 20px;">Recuperar Contraseña</h2>
                <form id="passwordResetForm" action="reset_password2.php" method="post" onsubmit="return validateForm()">
                    <div class="input-container">
                        <label for="email">Correo electrónico:</label>
                        <input type="email" id="email" name="email" placeholder="Correo electrónico" required>
                    </div>
                    <div class="input-container">
                        <label for="new_password">Nueva Contraseña:</label>
                        <input type="password" id="new_password" name="new_password" placeholder="Nueva Contraseña"
                            required oninput="validatePassword()">
                        <button class="show-hide-password" type="button" onclick="togglePassword('new_password')">
                            <ion-icon name="eye-off-outline"></ion-icon>
                        </button>
                    </div>
                    <div class="input-container">
                        <label for="confirm_password">Confirmar Contraseña:</label>
                        <input type="password" id="confirm_password" name="confirm_password"
                            placeholder="Confirmar Contraseña" required oninput="validatePassword()">
                        <button class="show-hide-password" type="button" onclick="togglePassword('confirm_password')">
                            <ion-icon name="eye-off-outline"></ion-icon>
                        </button>
                    </div>
                    <div id="passwordError" class="error-message"></div>
                    <button type="submit">Confirmar</button>
                </form>
            </div>
        </div>
    </section>

    <script>
        function togglePassword(inputId) {
            var input = document.getElementById(inputId);
            var icon = input.nextElementSibling.querySelector('ion-icon');
            if (input.type === "password") {
                input.type = "text";
                icon.setAttribute("name", "eye-outline");
            } else {
                input.type = "password";
                icon.setAttribute("name", "eye-off-outline");
            }
        }

        function validatePassword() {
            var newPassword = document.getElementById("new_password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            var passwordError = document.getElementById("passwordError");

            if (newPassword !== confirmPassword) {
                passwordError.textContent = "Las contraseñas no coinciden";
            } else {
                passwordError.textContent = "";
            }
        }
    </script>
</body>

</html>