<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="style.css" />
    <title>Mi Horóscopo</title>
</head>

<body class="landing wifi confirm-screen2" id="landing">
    <header class="logo-slogan">
        <img
            class="logo"
            src="./public/img/logo.png"
            alt="Logo de Mi Horóscopo" />
    </header>

    <main>
        <div class="wrapper-images">
            <div class="stripe"></div>
            <img
                class="woman-cook"
                src="./public/img/logo-landing.webp"
                alt="Image Woman Cook"
                id="img-landing" />
        </div>

        <div class="wrapper-info hid" id="email-section">
            <h5 class="type-text hid">Ingresa tu Correo Electrónico</h5>
            <div class="wrapper-email">

                <input
                    class="email-input"
                    id="email-input"
                    placeholder="Tu correo electrónico" />
            </div>
        </div>

        <div class="wrapper-info" id="zodiac-sign-section">
            <h5 class="type-text ">Selecciona tu Signo Astrológico</h5>
            <select name="zodiac_sign" id="zodiac_sign" class="select-custom" required>
                <option value="" disabled selected>Selecciona tu signo</option>
                <option value="aries">Aries</option>
                <option value="tauro">Tauro</option>
                <option value="geminis">Géminis</option>
                <option value="cancer">Cáncer</option>
                <option value="leo">Leo</option>
                <option value="virgo">Virgo</option>
                <option value="libra">Libra</option>
                <option value="escorpio">Escorpio</option>
                <option value="sagitario">Sagitario</option>
                <option value="capricornio">Capricornio</option>
                <option value="acuario">Acuario</option>
                <option value="piscis">Piscis</option>
            </select>

        </div>

        <div class="wrapper-info" id="name-section">
            <h5 class="type-text">Ingresa tu Nombre</h5>
            <div class="wrapper-email">
                <input
                    class="email-input"
                    id="name-input"
                    placeholder="Tu Nombre" />
            </div>
        </div>



        <div class="wrapper-info" id="subscription-section">
            <h5 class="type-text hid">Selecciona tu Suscripción</h5>


            <select class="select-custom">
                <option value="" name disabled selected>Selecciona tu signo</option>

                <option value="days">Suscripción Diaria</option>
                <option value="days7">Suscripción Semanal</option>
                <option value="months">Suscripción Mensual</option>




            </select>

        </div>



        <div class="wrapper-btns confirm" id="btn-confirm-email-warpper">
            <div class="wrapper-btn-shadow">
                <button class="btn btn-confirm" id="btn-confirm-email">Confirmar</button>
                <div class="shadow-mirror"></div>
            </div>
        </div>



        <div class="wrapper-btns confirm" id="btn-confirm-email">
            <div class="wrapper-btn-shadow">
                <button class="btn btn-confirm" id="btn-confirm">Subscribe</button>
                <div class="shadow-mirror"></div>
            </div>
        </div>



        <div class="wrapper-btns confirm" id="btn-confirm-email">
            <div class="wrapper-btn-shadow">
                <button class="btn btn-confirm" id="btn-confirm">Subscribe</button>
                <div class="shadow-mirror"></div>
            </div>
        </div>


        <div class="wrapper-btns confirm" id="btn-confirm-email">
            <div class="wrapper-btn-shadow">
                <button class="btn btn-confirm" id="btn-confirm">Subscribe</button>
                <div class="shadow-mirror"></div>
            </div>
        </div>

    </main>

    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="modal-message">

            </p>
        </div>
    </div>

    <footer class="terms-conditions-price">
        <h5 class="subscription-price hid">
            Mi Horóscopo es una suscripción auto-renovable. Para más información términos y condiciones y política de privacidad.
        </h5>
        <p class="text-disclaimer hide3">
            Mi Horóscopo es una suscripción auto-renovable. Para más información términos y condiciones y política de privacidad.
        </p>
        <div class="terms-privacy-links">
            <a href="https://mihoroscopo.com.ar/blog/terminos-de-servicio" target="_blank">
                <h5 class="terms">Términos y Condiciones</h5>
            </a>
            <span> - </span>
            <a href="https://mihoroscopo.com.ar/blog/politica-de-privacidad" target="_blank">
                <h5 class="terms">Política de Privacidad</h5>
            </a>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-sha1/0.6.0/sha1.min.js"></script>


    <script type="text/javascript">
        const confirmButton = document.getElementById("btn-confirm-email");
        const emailInput = document.getElementById("email-input");


        const landing = document.getElementById("landing");

        const emailSection = document.getElementById("email-section");
        const nameSection = document.getElementById("name-section");







        confirmButton.addEventListener("click", () => {
            const emailValue = emailInput.value.trim().toLowerCase();
            const validDomains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com', 'icloud.com', 'live.com'];

            // Validar que el email tenga un formato básico de correo
            const emailParts = emailValue.split('@');

            if (emailParts.length !== 2 || !emailParts[0] || !emailParts[1]) {
                showModal('Por favor, ingresa un correo válido.');
                return;
            }

            const domain = emailParts[1];

            // Verificar si el dominio está en la lista permitida
            if (!validDomains.includes(domain)) {
                showModal('Por favor, Asegúrate de que el correo esté bien escrito, sin errores de tipeo.');
                return;
            }

            // Si todas las validaciones pasan, puedes continuar con el envío del formulario o la acción correspondiente
            console.log('Correo válido, continuando con el proceso...');
        });






        // Función para mostrar el modal con un mensaje
        function showModal(message) {
            const modal = document.getElementById('modal');
            const modalMessage = document.getElementById('modal-message');
            modalMessage.textContent = message;
            modal.style.display = 'block';
        }

        // Función para cerrar el modal al hacer clic en la "X"
        function closeModal() {
            const modal = document.getElementById('modal');
            modal.style.display = 'none';
        }

        // // Asignar el evento de clic para cerrar el modal
        // const closeBtn = document.getElementsByClassName('close')[0];
        // closeBtn.addEventListener('click', closeModal);

        document.addEventListener('click', (event) => {
            if (event.target.matches('.close') || event.target.matches('#modal')) {
                closeModal();
            }
        });
    </script>
</body>

</html>
