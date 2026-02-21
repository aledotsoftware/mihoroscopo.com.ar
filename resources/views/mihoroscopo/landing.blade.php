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
                <input class="email-input" id="input-email" placeholder="Ingresa tu correo" aria-label="Ingresa tu correo electrónico" type="email" />

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
                <input class="email-input" id="input-name" placeholder="Tu Nombre" aria-labelledby="label-name" />
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
            <select class="select-custom" id="select-subscription" aria-labelledby="label-subscription">
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
            const validDomains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com', 'icloud.com', 'live.com', 'hotmail.com.ar', 'yahoo.com.ar', 'live.com.ar', 'fibertel.com.ar', 'speedy.com.ar', 'arnet.com.ar', 'ciudad.com.ar', 'uol.com.ar', 'mi.com.ar', 'outlook.com.ar', 'ymail.com', 'protonmail.com', 'tutanota.com', 'mailfence.com', 'startmail.com', 'runbox.com', 'posteo.net', 'mailbox.org', 'ctemplar.com', 'safe-mail.net', 'riseup.net', 'hushmail.com', 'disroot.org'];

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
            btnConfirmName.innerHTML = '<span class="spinner"></span> Cargando...';

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
                showModal('Por favor, selecciona una suscripción.');
                return;
            }

            // Aquí puedes continuar con la lógica de confirmación final o envío de datos
            console.log('Suscripción confirmada.');



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