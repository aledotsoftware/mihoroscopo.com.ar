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
            <img class="woman-cook" src="./public/img/logo-landing.webp" alt="Image Woman Cook" id="img-landing" />
        </div>

        <!-- Email Section -->
        <div class="wrapper-info hid" id="section-email">
            <h5 class="type-text hid">Ingresa tu Correo Electrónico</h5>
            <div class="wrapper-email">
                <input class="email-input" id="input-email" placeholder="Tu correo electrónico" />
            </div>

            <div class="wrapper-btns confirm" id="btn-wrapper-email">
                <div class="wrapper-btn-shadow">
                    <button class="btn btn-confirm" id="btn-confirm-email">Confirmar</button>
                    <div class="shadow-mirror"></div>
                </div>
            </div>
        </div>

        <!-- Zodiac Sign Section -->
        <div class="wrapper-info" id="section-zodiac">
            <h5 class="type-text">Selecciona tu Signo Astrológico</h5>
            <select name="zodiac_sign" id="select-zodiac-sign" class="select-custom" required>
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

            <div class="wrapper-btns confirm" id="btn-wrapper-zodiac">
                <div class="wrapper-btn-shadow">
                    <button class="btn btn-confirm" id="btn-confirm-zodiac">Confirmar Signo</button>
                    <div class="shadow-mirror"></div>
                </div>
            </div>
        </div>

        <!-- Name Section -->
        <div class="wrapper-info" id="section-name">
            <h5 class="type-text">Ingresa tu Nombre</h5>
            <div class="wrapper-email">
                <input class="email-input" id="input-name" placeholder="Tu Nombre" />
            </div>

            <div class="wrapper-btns confirm" id="btn-wrapper-name">
                <div class="wrapper-btn-shadow">
                    <button class="btn btn-confirm" id="btn-confirm-name">Confirmar Nombre</button>
                    <div class="shadow-mirror"></div>
                </div>
            </div>
        </div>

        <!-- Subscription Section -->
        <div class="wrapper-info" id="section-subscription">
            <h5 class="type-text hid">Selecciona tu Suscripción</h5>
            <select class="select-custom" id="select-subscription">
                <option value="" disabled selected>Selecciona tu suscripción</option>
                <option value="days">Suscripción Diaria</option>
                <option value="days7">Suscripción Semanal</option>
                <option value="months">Suscripción Mensual</option>
            </select>

            <div class="wrapper-btns confirm" id="btn-wrapper-subscription">
                <div class="wrapper-btn-shadow">
                    <button class="btn btn-confirm" id="btn-confirm-subscription">Confirmar Suscripción</button>
                    <div class="shadow-mirror"></div>
                </div>
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
        // Función para obtener el valor de un parámetro de URL
        function getParameterByName(name) {
            const url = new URL(window.location.href);
            return url.searchParams.get(name);
        }

        // Captura el gclid y guárdalo en localStorage
        const gclid = getParameterByName('gclid');


        if (gclid) {
            localStorage.setItem('gclid', gclid); // Guarda el gclid en localStorage para uso posterior
            console.log('GCLID capturado:', gclid);
        } else {
            console.log('No se encontró GCLID en la URL.');
        }


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


        // Selectores de las secciones
        const emailSection = document.getElementById('section-email');
        const zodiacSection = document.getElementById('section-zodiac');
        const nameSection = document.getElementById('section-name');
        const subscriptionSection = document.getElementById('section-subscription');

        // Selectores de los inputs
        const emailInput = document.getElementById('input-email');
        const nameInput = document.getElementById('input-name');
        const zodiacSelect = document.getElementById('select-zodiac-sign');
        const subscriptionSelect = document.getElementById('select-subscription');

        // Selectores de los botones
        const btnConfirmEmail = document.getElementById('btn-confirm-email');
        const btnConfirmZodiac = document.getElementById('btn-confirm-zodiac');
        const btnConfirmName = document.getElementById('btn-confirm-name');
        const btnConfirmSubscription = document.getElementById('btn-confirm-subscription');
        // Función para mostrar la siguiente sección y ocultar la actual usando CSS desde JavaScript
        function showNextSection(currentSection, nextSection) {
            currentSection.style.display = 'none'; // Ocultar la sección actual
            nextSection.style.display = 'flex'; // Mostrar la siguiente sección
        }

        // Eventos de los botones con validaciones correspondientes
        btnConfirmEmail.addEventListener('click', () => {
            const emailValue = emailInput.value.trim().toLowerCase();
            const validDomains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com', 'icloud.com', 'live.com'];
            const emailParts = emailValue.split('@');

            if (emailParts.length !== 2 || !emailParts[0] || !emailParts[1]) {
                showModal('Por favor, ingresa un correo válido.');
                return;
            }

            const domain = emailParts[1];
            if (!validDomains.includes(domain)) {
                showModal('Por favor, asegúrate de que el correo esté bien escrito, sin errores de tipeo.');
                return;
            }

            showNextSection(emailSection, zodiacSection); // Mostrar la siguiente sección si todo es correcto
        });

        btnConfirmZodiac.addEventListener('click', () => {
            if (zodiacSelect.value === '') {
                showModal('Por favor, selecciona tu signo.');
                return;
            }

            showNextSection(zodiacSection, nameSection);
        });

        btnConfirmName.addEventListener('click', () => {
            if (nameInput.value.trim() === '') {
                showModal('Por favor, ingresa tu nombre.');
                return;
            }

            showNextSection(nameSection, subscriptionSection);
        });

        btnConfirmSubscription.addEventListener('click', () => {
            if (subscriptionSelect.value === '') {
                showModal('Por favor, selecciona una suscripción.');
                return;
            }

            // Aquí puedes continuar con la lógica de confirmación final o envío de datos
            console.log('Suscripción confirmada.');

            // Recupera el gclid almacenado
            const capturedGclid = localStorage.getItem('gclid');
            showModal('Por favor espere un momento.');

            // Envío de datos al backend
            fetch('http://127.0.0.1:8000/api/v1/subscribe', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        email: emailInput.value,
                        zodiacSign: zodiacSelect.value,
                        name: nameInput.value,
                        subscription: subscriptionSelect.value,
                        gclid: capturedGclid, // Incluye el GCLID capturado
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Datos enviados con éxito:', data);

                    if (data.init_point) {
                        // Redirigir al usuario al init_point
                        window.location.href = data.init_point;
                    } else {
                        alert('Suscripción confirmada.'); // Mensaje de confirmación
                    }


                })
                .catch(error => {
                    console.error('Error al enviar los datos:', error);
                    // Recargar la página y volver al inicio
                    window.location.reload();
                });


        });

        // Función para mostrar el modal con un mensaje
        function showModal(message) {
            const modal = document.getElementById('modal');
            const modalMessage = document.getElementById('modal-message');
            modalMessage.textContent = message;
            modal.style.display = 'flex';
        }

        // Función para cerrar el modal al hacer clic en la "X"
        function closeModal() {
            const modal = document.getElementById('modal');
            modal.style.display = 'none';
        }

        document.addEventListener('click', (event) => {
            if (event.target.matches('.close') || event.target.matches('#modal')) {
                closeModal();
            }
        });


        //estilos
        let angle = 234; // Ángulo inicial
        const buttons = document.querySelectorAll('.btn-confirm');

        setInterval(() => {
            angle = (angle + 1) % 360; // Incrementar el ángulo y mantenerlo en el rango de 0-359
            buttons.forEach(button => {
                button.style.background = `linear-gradient(${angle}deg, #16003a 20%, #c63dff 90%)`;
            });
        }, 100); // Cambia cada 100ms (ajusta según sea necesario)
    </script>
</body>

</html>
