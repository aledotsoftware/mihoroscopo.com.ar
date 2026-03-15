<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Mi Horóscopo</title>
    <!-- analitica web -->
    <script data-host="https://analiticaweb.com.ar" data-dnt="false" src="https://analiticaweb.com.ar/js/script.js"
        id="ZwSg9rf6GA" async defer></script>

    <!-- Google tag (gtag.js)  GOOGLE ADS-->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-16701477464"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'AW-16701477464');
    </script>


    <!-- Google tag (gtag.js)  Analytics-->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-5DNG5MFGZZ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-5DNG5MFGZZ');
    </script>

    <!-- Microsft Clarity-->
    <script type="text/javascript">
        (function(c, l, a, r, i, t, y) {
            c[a] = c[a] || function() {
                (c[a].q = c[a].q || []).push(arguments)
            };
            t = l.createElement(r);
            t.async = 1;
            t.src = "https://www.clarity.ms/tag/" + i;
            y = l.getElementsByTagName(r)[0];
            y.parentNode.insertBefore(t, y);
        })(window, document, "clarity", "script", "o5xaqvsgs8");
    </script>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(to bottom right, #c63dff, #16003a);
            color: #ffffff;
        }

        header img {
            max-width: 120px;
            margin-bottom: 20px;
        }

        main {
            background: #ffffff;
            color: #000000;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 400px;
            box-sizing: border-box;
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.5em;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            font-size: 14px;
        }

        input,
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        input:focus,
        select:focus {
            border-color: #c63dff;
            outline: none;
            box-shadow: 0 0 5px rgba(198, 61, 255, 0.5);
        }

        button {
            width: 100%;
            padding: 12px;
            background: #c63dff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        button:hover:not(:disabled) {
            background: #9c30cc;
            transform: scale(1.03);
        }

        button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        button:focus-visible {
            outline: 2px solid #c63dff;
            outline-offset: 2px;
        }

        .error-message {
            text-align: center;
            margin-top: 20px;
            color: #dc3545;
            display: none;
        }

        .required-indicator {
            color: #dc3545;
            margin-left: 2px;
        }

        /* Spinner and Loading State */
        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
            margin-right: 10px;
            vertical-align: middle;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .btn-loading {
            opacity: 0.8;
            pointer-events: none;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ asset('landing-v1/public/img/logo.png') }}" alt="Logo de Mi Horóscopo">
    </header>

    <main>
        <form id="subscription-form">
            <h3>Suscríbete a Mi Horóscopo</h3>
            <h5>Una vez que te suscribas, recibirás:</h5>
            <ul class="scrollable-list">
                <li class="type-text hid">Horóscopo Gratis</li>
                <li class="type-text hid">Guía Astral</li>
                <li class="type-text hid">Consejo Diario</li>
                <li class="type-text hid">Horóscopo de Amor</li>
                <li class="type-text hid">Ritual Lunar</li>
                <li class="type-text hid">Ritual de Amor</li>
                <li class="type-text hid">Ritual de Prosperidad</li>
                <li class="type-text hid">Compatibilidad Zodiacal</li>
            </ul>
            <label for="email">Correo Electrónico<span class="required-indicator" aria-hidden="true">*</span></label>
            <input type="email" id="email" name="email" placeholder="correo@ejemplo.com" required autocomplete="email" inputmode="email">

            <label for="zodiac_sign">Selecciona tu Signo Astrológico<span class="required-indicator" aria-hidden="true">*</span></label>
            <select name="zodiac_sign" id="zodiac_sign" required>
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

            <label for="name">Nombre<span class="required-indicator" aria-hidden="true">*</span></label>
            <input type="text" id="name" name="name" placeholder="Tu Nombre" required autocomplete="name" autocapitalize="words">

            <input type="hidden" name="subscription" value="days">

            <button type="submit">Suscribirse</button>
        </form>

        <div id="error-message" class="error-message" role="alert" aria-live="assertive">
            Ocurrió un error. Por favor, inténtalo de nuevo.
        </div>
    </main>

    <script>
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

        // Captura el gclid y guárdalo en localStorage

        // UX Improvement: Clear inline errors when user starts typing/changing
        ['email', 'zodiac_sign', 'name'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('input', () => document.getElementById('error-message').style.display = 'none');
                el.addEventListener('change', () => document.getElementById('error-message').style.display = 'none');
            }
        });

        document.getElementById('subscription-form').addEventListener('submit', function(event) {
            event.preventDefault();

            const form = event.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.textContent;

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.classList.add('btn-loading');
            submitBtn.setAttribute('aria-busy', 'true');
            submitBtn.setAttribute('aria-live', 'polite');
            submitBtn.innerHTML = '<span class="spinner" aria-hidden="true"></span> Procesando...';
            document.getElementById('error-message').style.display = 'none';

            const capturedGclid = localStorage.getItem('gclid');

            country = "{{ $country }}";
            const formData = {
                email: form.email.value,
                zodiacSign: form.zodiac_sign.value,
                name: form.name.value,
                gclid: capturedGclid, // Incluye el GCLID capturado
                subscription: form.subscription.value,
                country: country
            };

            fetch("{{ url('api/v1/subscribe') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.init_point) {
                        // Redirigir a la URL proporcionada
                        window.location.href = data.init_point;
                    } else {
                        // Mostrar un mensaje de error si no hay `init_point`
                        // Reset button state
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('btn-loading');
                        submitBtn.removeAttribute('aria-busy');
                        submitBtn.removeAttribute('aria-live');
                        submitBtn.innerHTML = originalBtnText;

                        const errorMessage = document.getElementById('error-message');
                        errorMessage.style.display = 'block';
                        errorMessage.textContent = 'No se recibió una URL de redirección válida.';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);

                    // Reset button state
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('btn-loading');
                    submitBtn.removeAttribute('aria-busy');
                    submitBtn.removeAttribute('aria-live');
                    submitBtn.innerHTML = originalBtnText;

                    const errorMessage = document.getElementById('error-message');
                    errorMessage.style.display = 'block';
                    errorMessage.textContent = 'Ocurrió un error al procesar tu solicitud.';
                });
        });
    </script>
</body>

</html>