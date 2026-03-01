<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0" /> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('landing-v1/style.css?v=1') }}" />
    <title>Mi Horóscopo</title>

    <!-- analitica web -->
    <script data-host="https://analiticaweb.com.ar" data-dnt="false" src="https://analiticaweb.com.ar/js/script.js"
        id="ZwSg9rf6GA" async defer></script>
    <script type="text/javascript">
        _linkedin_partner_id = "8154033";
        window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];
        window._linkedin_data_partner_ids.push(_linkedin_partner_id);
    </script>
    <script type="text/javascript">
        (function(l) {
            if (!l) {
                window.lintrk = function(a, b) {
                    window.lintrk.q.push([a, b])
                };
                window.lintrk.q = []
            }
            var s = document.getElementsByTagName("script")[0];
            var b = document.createElement("script");
            b.type = "text/javascript";
            b.async = true;
            b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js";
            s.parentNode.insertBefore(b, s);
        })(window.lintrk);
    </script>
    <noscript>
        <img height="1" width="1" style="display:none;" alt="" src="https://px.ads.linkedin.com/collect/?pid=8154033&fmt=gif" />
    </noscript>
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
        .woman-cook {
            display: none;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        .shake {
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }

        /* Error state styling */
        #input-email[aria-invalid="true"],
        #select-zodiac-sign[aria-invalid="true"],
        #input-name[aria-invalid="true"],
        #select-subscription[aria-invalid="true"] {
            border-color: #ef4444;
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

        /* Focus styles for accessibility */
        input:focus-visible,
        select:focus-visible,
        button:focus-visible {
            outline: 3px solid #facc15;
            outline-offset: 2px;
        }

        /* Custom SVG Arrow for Selects */
        .select-custom {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1.5rem;
            padding-right: 2.5rem;
        }
    </style>
</head>

<body class="landing wifi confirm-screen2" id="landing">
    <header class="logo-slogan">
        <img class="logo" src="{{ asset('landing-v1/public/img/logo.png') }}" alt="Logo de Mi Horóscopo" />
    </header>

    <main>
        <div class="wrapper-images">
            <div class="stripe"></div>
            <img class="woman-cook" src="{{ asset('landing-v1/public/img/logo-landing-min.webp') }}" alt="Signo"
                id="img-landing" />


        </div>
        <!-- Email Section -->
        <div class="wrapper-info hid" id="section-email">
            <br>
            <h3 class="type-text hid">Una vez que te suscribas, recibirás:</h3>
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


            <div class="wrapper-email">
                <input class="email-input" id="input-email" placeholder="Ingresa tu correo" aria-label="Ingresa tu correo electrónico" aria-required="true" type="email" autocomplete="email" inputmode="email" />

            </div>

            <div class="wrapper-btns confirm" id="btn-wrapper-email">
                <div class="wrapper-btn-shadow">
                    <button class="btn btn-confirm" id="btn-confirm-email">continuar</button>
                    {{-- <div class="shadow-mirror"></div> --}}
                </div>
            </div>
        </div>

        <!-- Zodiac Sign Section -->
        <div class="wrapper-info" id="section-zodiac">
            <br>
            <h3 class="type-text hid">Guía Astrológica Gratis</h3>
            <h5 class="type-text" id="label-zodiac-sign">Selecciona tu Signo Astrológico</h5>
            <select name="zodiac_sign" id="select-zodiac-sign" class="select-custom" required aria-labelledby="label-zodiac-sign">
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
                    <button class="btn btn-confirm" id="btn-confirm-zodiac">continuar</button>
                    {{-- <div class="shadow-mirror"></div> --}}
                </div>
            </div>
        </div>

        <!-- Name Section -->
        <div class="wrapper-info" id="section-name">
            <br>
            <h3 class="type-text hid">Guía Astrológica Gratis</h3>


            <h5 class="type-text" id="label-name">Ingresa tu Nombre</h5>
            <div class="wrapper-email">
                <input class="email-input" id="input-name" placeholder="Tu Nombre" aria-labelledby="label-name" aria-required="true" type="text" autocomplete="name" autocapitalize="words" />
            </div>

            <div class="wrapper-btns confirm" id="btn-wrapper-name">
                <div class="wrapper-btn-shadow">
                    <button class="btn btn-confirm" id="btn-confirm-name">continuar</button>
                    {{-- <div class="shadow-mirror"></div> --}}
                </div>
            </div>
        </div>

        <!-- Subscription Section -->
        <div class="wrapper-info" id="section-subscription">
            <br>
            <h3 class="type-text hid">Guía Astrológica Gratis</h3>




            <h5 class="type-text hid" id="label-subscription">Selecciona tu Suscripción</h5>
            <select class="select-custom" id="select-subscription" aria-labelledby="label-subscription" aria-required="true">
                <option value="" disabled selected>Selecciona tu suscripción</option>

                <option value="{{ env('SUBSCRIPTION_DAILY_FREQUENCY_TYPE') }}">
                    {{ env('SUBSCRIPTION_DAILY_REASON') }} - {{ env('SUBSCRIPTION_DAILY_AMOUNT') }} ARS
                </option>

                {{-- <option value="{{ env('SUBSCRIPTION_WEEKLY_FREQUENCY_TYPE') }}">
                {{ env('SUBSCRIPTION_WEEKLY_REASON') }} - {{ env('SUBSCRIPTION_WEEKLY_AMOUNT') }} ARS
                </option> --}}

                <option value="{{ env('SUBSCRIPTION_MONTHLY_FREQUENCY_TYPE') }}">
                    {{ env('SUBSCRIPTION_MONTHLY_REASON') }} - {{ env('SUBSCRIPTION_MONTHLY_AMOUNT') }} ARS
                </option>

                <option value="gaia">Mi Horóscopo Gratis - Gratis</option>

            </select>



            <div class="wrapper-btns confirm" id="btn-wrapper-subscription">
                <div class="wrapper-btn-shadow">
                    <button class="btn btn-confirm" id="btn-confirm-subscription">PAGAR</button>
                    {{-- <div class="shadow-mirror"></div> --}}
                </div>
            </div>
        </div>
    </main>

    <div id="modal" class="modal" role="dialog" aria-modal="true" aria-labelledby="modal-message">
        <div class="modal-content">
            <button class="close" aria-label="Cerrar">&times;</button>
            <p id="modal-message" role="alert">

            </p>
        </div>
    </div>

    <footer class="terms-conditions-price">
        <h5 class="subscription-price hid">
            Mi Horóscopo es una suscripción OPCIONAL. Para más información, revisa los términos y condiciones.
        </h5>

        <div class="terms-privacy-links">
            <a href="/blog/terminos-y-condiciones-de-servicio" target="_blank">
                <h5 class="terms">Términos y Condiciones</h5>
            </a>
            <span> - </span>
            <a href="/blog/politica-de-privacidad" target="_blank">
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
        // Función para obtener el valor de una cookie por su nombre
        // function getCookie(name) {
        //     let value = `; ${document.cookie}`;
        //     let parts = value.split(`; ${name}=`);
        //     if (parts.length === 2) return parts.pop().split(';').shift();
        // }

        // Captura el gclid y guárdalo en localStorage
        const gclid = getParameterByName('gclid');


        if (gclid) {
            localStorage.setItem('gclid', gclid); // Guarda el gclid en localStorage para uso posterior
            console.log('GCLID capturado:', gclid);
        } else {
            console.log('No se encontró GCLID en la URL.');
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

        // UX Improvement: Enable "Enter" key to submit sections
        function handleEnterKey(inputId, buttonId) {
            const input = document.getElementById(inputId);
            if (input) {
                input.addEventListener('keydown', function(event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        document.getElementById(buttonId).click();
                    }
                });
            }
        }

        handleEnterKey('input-email', 'btn-confirm-email');
        handleEnterKey('input-name', 'btn-confirm-name');
        handleEnterKey('select-zodiac-sign', 'btn-confirm-zodiac');

        const btnConfirmName = document.getElementById('btn-confirm-name');
        const btnConfirmSubscription = document.getElementById('btn-confirm-subscription');

        // Función para mostrar la siguiente sección y ocultar la actual usando CSS desde JavaScript
        function showNextSection(currentSection, nextSection, nextInputId) {
            currentSection.style.display = 'none'; // Ocultar la sección actual
            nextSection.style.display = 'flex'; // Mostrar la siguiente sección
            if (nextInputId) {
                const nextInput = document.getElementById(nextInputId);
                if (nextInput) {
                    nextInput.focus();
                }
            }
        }

        // Función para animar el elemento en caso de error
        function shakeElement(element) {
            element.classList.add('shake');
            setTimeout(() => {
                element.classList.remove('shake');
            }, 500);
        }

        // Eventos de los botones con validaciones correspondientes
        btnConfirmEmail.addEventListener('click', () => {
            const emailValue = emailInput.value.trim().toLowerCase();
            const validDomains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com', 'icloud.com', 'live.com', 'hotmail.com.ar', 'yahoo.com.ar', 'live.com.ar', 'fibertel.com.ar', 'speedy.com.ar', 'arnet.com.ar', 'ciudad.com.ar', 'uol.com.ar', 'mi.com.ar', 'outlook.com.ar', 'ymail.com', 'protonmail.com', 'tutanota.com', 'mailfence.com', 'startmail.com', 'runbox.com', 'posteo.net', 'mailbox.org', 'ctemplar.com', 'safe-mail.net', 'riseup.net', 'hushmail.com', 'disroot.org'];

            const emailParts = emailValue.split('@');

            if (emailParts.length !== 2 || !emailParts[0] || !emailParts[1]) {
                showModal('Por favor, ingresa un correo válido.', emailInput);
                emailInput.setAttribute('aria-invalid', 'true');
                shakeElement(emailInput);
                return;
            }

            const domain = emailParts[1];
            if (!validDomains.includes(domain)) {
                showModal('Por favor, asegúrate de que el correo esté bien escrito, sin errores de tipeo.', emailInput);
                emailInput.setAttribute('aria-invalid', 'true');
                shakeElement(emailInput);
                return;
            }

            emailInput.setAttribute('aria-invalid', 'false');
            showNextSection(emailSection, zodiacSection, 'select-zodiac-sign'); // Mostrar la siguiente sección si todo es correcto
        });

        btnConfirmZodiac.addEventListener('click', () => {
            if (zodiacSelect.value === '') {
                showModal('Por favor, selecciona tu signo.', zodiacSelect);
                zodiacSelect.setAttribute('aria-invalid', 'true');
                shakeElement(zodiacSelect);
                return;
            }

            zodiacSelect.setAttribute('aria-invalid', 'false');
            showNextSection(zodiacSection, nameSection, 'input-name');
        });

        btnConfirmName.addEventListener('click', () => {
            if (nameInput.value.trim() === '') {
                showModal('Por favor, ingresa tu nombre.', nameInput);
                nameInput.setAttribute('aria-invalid', 'true');
                shakeElement(nameInput);
                return;
            }
            nameInput.setAttribute('aria-invalid', 'false');

            // showNextSection(nameSection, subscriptionSection);

            // Recupera el gclid almacenado
            const capturedGclid = localStorage.getItem('gclid'); //GCLID capturado

            // Captura el gclid y guárdalo en localStorage
            const capturedLiFatId = getParameterByName('li_fat_id'); // LI_FAT_ID capturado
            const capturedLiEd = getParameterByName('li_ed'); // LI_ED capturado
            const capturedSubDays = getParameterByName('sub_days'); // SUB_DAYS capturado
            const capturedCost = getParameterByName('cost'); // COST capturado
            const capturedClickId = getParameterByName('click_id'); // CLICK_ID capturado
            const capturedWebPushCreativeId = getParameterByName('web_push_creative_id'); // WEB_PUSH_CREATIVE_ID capturado
            const capturedMobileBrand = getParameterByName('mobile_brand'); // MOBILE_BRAND capturado
            const capturedCityName = getParameterByName('city_name'); // CITY_NAME capturado
            const capturedBrowserFamily = getParameterByName('browser_family'); // BROWSER_FAMILY capturado
            const capturedOsType = getParameterByName('os_type'); // OS_TYPE capturado
            const capturedPrice = getParameterByName('price'); // PRICE capturado
            const capturedCountry = getParameterByName('country'); // PRICE capturado
            const capturedCurrency = getParameterByName('currency'); // PRICE capturado

            // Recupera el gclid almacenado
          

//  $extradataHoroscope = new ExtradataHoroscope();
//         $extradataHoroscope->subscription_id = $subscriptionId;
//         $extradataHoroscope->signo = $zodiacSign;
//         $extradataHoroscope->gclid = $gclid;
//         $extradataHoroscope->name = $name;
//         $extradataHoroscope->li_fat_id = $li_fat_id;
//         $extradataHoroscope->li_ed = $li_ed;
//         $extradataHoroscope->sub_days = $sub_days;
//         $extradataHoroscope->cost = $cost;
//         $extradataHoroscope->click_id = $click_id;
//         $extradataHoroscope->web_push_creative_id = $web_push_creative_id;
//         $extradataHoroscope->mobile_brand = $mobile_brand;
//         $extradataHoroscope->city_name = $city_name;
//         $extradataHoroscope->browser_family = $browser_family;
//         $extradataHoroscope->os_type = $os_type;
//         $extradataHoroscope->price = $price;
//         $extradataHoroscope->region_name = $region_name;
//         $extradataHoroscope->spot_id = $spot_id;
//         $extradataHoroscope->domain = $domain;
//         $extradataHoroscope->gbraid = $gbraid;
//         $extradataHoroscope->wbraid = $wbraid;

//         $extradataHoroscope->save();

            // UX Improvement: Show loading state on button instead of modal
            // showModal('Por favor espere un momento.');

            const originalBtnText = btnConfirmName.innerHTML;
            btnConfirmName.disabled = true;
            nameInput.disabled = true;
            btnConfirmName.classList.add('btn-loading');
            btnConfirmName.setAttribute('aria-busy', 'true');
            btnConfirmName.setAttribute('aria-live', 'polite');
            btnConfirmName.innerHTML = '<span class="spinner" aria-hidden="true"></span> Cargando...';

            const apiUrl = "{{ url('api/v1/subscribe') }}"; // Genera la URL completa
            // Envío de datos al backend


            country = "{{ $country }}";
            //Inicio de confirmación de compra - GTM
            gtag('event', 'conversion', {
                'send_to': 'AW-16701477464/8OrdCPbN1fgZENik8Zs-'
            });

            console.log('Country:', country);
            fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        email: emailInput.value,
                        zodiacSign: zodiacSelect.value,
                        name: nameInput.value,
                        subscription: "days",
                        gclid: capturedGclid, // Incluye el GCLID capturado
                        li_fat_id: capturedLiFatId,
                        country: country,
                        li_ed: capturedLiEd,
                        sub_days: capturedSubDays,
                        cost: capturedCost,
                        click_id: capturedClickId,
                        web_push_creative_id: capturedWebPushCreativeId,
                        mobile_brand: capturedMobileBrand,
                        city_name: capturedCityName,
                        browser_family: capturedBrowserFamily,
                        os_type: capturedOsType,
                        price: capturedPrice,
                        currency: capturedCurrency
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Datos enviados con éxito:', data);

                    if (data.init_point) {
                        // Redirigir al usuario al init_point
                        window.location.href = data.init_point;
                    } else {
                        window.location.href = "https://mihoroscopo.com.ar/landing";
                    }


                })
                .catch(error => {
                    console.error('Error al enviar los datos:', error);

                    // Reset button state
                    btnConfirmName.disabled = false;
                    nameInput.disabled = false;
                    btnConfirmName.classList.remove('btn-loading');
                    btnConfirmName.removeAttribute('aria-busy');
                    btnConfirmName.removeAttribute('aria-live');
                    btnConfirmName.innerHTML = originalBtnText;

                    // Recargar la página y volver al inicio
                    window.location.reload();
                });




        });

        // Cambia el texto del botón basado en la selección de suscripción
        subscriptionSelect.addEventListener('change', function() {
            var selectedValue = this.value;

            if (selectedValue === 'gaia') { // Cambia el valor según corresponda
                btnConfirmSubscription.textContent = 'Continuar Gratis';
            } else {
                btnConfirmSubscription.textContent = 'Pagar';
            }
        });

        btnConfirmSubscription.addEventListener('click', () => {
            if (subscriptionSelect.value === '') {
                showModal('Por favor, selecciona una suscripción.', subscriptionSelect);
                subscriptionSelect.setAttribute('aria-invalid', 'true');
                shakeElement(subscriptionSelect);
                return;
            }
            subscriptionSelect.setAttribute('aria-invalid', 'false');

            // Aquí puedes continuar con la lógica de confirmación final o envío de datos
            console.log('Suscripción confirmada.');



        });

        let lastFocusedElement;
        let focusAfterCloseElement;

        // Función para mostrar el modal con un mensaje
        function showModal(message, focusTarget = null) {
            lastFocusedElement = document.activeElement;
            focusAfterCloseElement = focusTarget;
            const modal = document.getElementById('modal');
            const modalMessage = document.getElementById('modal-message');
            const closeBtn = modal.querySelector('.close');

            modalMessage.textContent = message;
            modal.style.display = 'flex';

            if (closeBtn) {
                closeBtn.focus();
            }

            modal.addEventListener('keydown', trapFocus);
        }

        // Función para cerrar el modal al hacer clic en la "X"
        function closeModal() {
            const modal = document.getElementById('modal');
            modal.style.display = 'none';
            modal.removeEventListener('keydown', trapFocus);

            if (focusAfterCloseElement) {
                focusAfterCloseElement.focus();
                focusAfterCloseElement = null;
            } else if (lastFocusedElement) {
                lastFocusedElement.focus();
            }
        }

        function trapFocus(e) {
            const modal = document.getElementById('modal');
            const focusableContent = modal.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            if (focusableContent.length === 0) return;

            const firstFocusableElement = focusableContent[0];
            const lastFocusableElement = focusableContent[focusableContent.length - 1];

            if (e.key === 'Tab') {
                if (e.shiftKey) { // Shift + Tab
                    if (document.activeElement === firstFocusableElement) {
                        lastFocusableElement.focus();
                        e.preventDefault();
                    }
                } else { // Tab
                    if (document.activeElement === lastFocusableElement) {
                        firstFocusableElement.focus();
                        e.preventDefault();
                    }
                }
            } else if (e.key === 'Escape') {
                closeModal();
            }
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



        document.addEventListener('DOMContentLoaded', () => {
            const selectZodiac = document.getElementById('select-zodiac-sign');
            const imgLanding = document.getElementById('img-landing');


            selectZodiac.addEventListener('change', () => {
                const selectedSign = selectZodiac.value;
                const newSrc = `{{ asset('landing-v1/public/img/${selectedSign}.webp') }}`;

                // Capitalize first letter for alt text
                const altText = selectedSign.charAt(0).toUpperCase() + selectedSign.slice(1);

                // Hacer la imagen actual transparente
                imgLanding.style.opacity = 0;
                imgLanding.style.display = "block";



                // Cambiar la fuente de la imagen después de un breve tiempo
                setTimeout(() => {
                    imgLanding.src = newSrc; // Cambiar la fuente de la imagen
                    imgLanding.alt = altText; // Update alt text for accessibility
                    imgLanding.style.opacity = 1; // Volver a mostrar la imagen
                }, 0); // Tiempo para que la imagen se vuelva transparente
            });
        });
    </script>
</body>

</html>