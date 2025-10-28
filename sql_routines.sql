DELIMITER $$
CREATE DEFINER=`u487445196_mihoroscopo`@`127.0.0.1` PROCEDURE `CheckAllZodiacSigns`()
BEGIN
    -- Crea una tabla temporal con todos los signos del zodiaco
    CREATE TEMPORARY TABLE IF NOT EXISTS all_zodiac_signs (
        zodiac_sign ENUM('aries', 'tauro', 'geminis', 'cancer', 'leo', 'virgo', 'libra', 'escorpio', 'sagitario', 'capricornio', 'acuario', 'piscis')
    );

    -- Inserta todos los signos del zodiaco en la tabla temporal
    TRUNCATE TABLE all_zodiac_signs; -- Limpia la tabla en caso de que ya tenga datos
    INSERT INTO all_zodiac_signs (zodiac_sign)
    VALUES
        ('aries'), ('tauro'), ('geminis'), ('cancer'), ('leo'),
        ('virgo'), ('libra'), ('escorpio'), ('sagitario'), ('capricornio'),
        ('acuario'), ('piscis');

    -- Consulta para verificar si todos los signos están presentes por fecha
    SELECT
        h.date,
        CASE
            WHEN COUNT(DISTINCT c.zodiac_sign) = 12 THEN 'TRUE'
            ELSE 'FALSE'
        END AS all_signs_present
    FROM
        (SELECT DISTINCT date FROM content_horoscopes) h
    LEFT JOIN
        content_horoscopes c ON c.date = h.date
    GROUP BY
        h.date
    ORDER BY
        h.date;

    -- Elimina la tabla temporal
    DROP TEMPORARY TABLE IF EXISTS all_zodiac_signs;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`u487445196_mihoroscopo`@`127.0.0.1` PROCEDURE `GenerateConversions`()
BEGIN
    -- Eliminar la tabla si ya existe
    DROP TABLE IF EXISTS ads_conversions;

    -- Crear la tabla nuevamente
    CREATE TABLE ads_conversions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        hashed_email VARCHAR(255),
        conversion_value DECIMAL(10,2),
        currency_code VARCHAR(10),
        gclid VARCHAR(255),
        conversion_event_time DATETIME
    );

    -- Insertar los resultados de la consulta en la nueva tabla
    INSERT INTO ads_conversions (hashed_email, conversion_value, currency_code, gclid, conversion_event_time)
    SELECT
        subscriptions.email as hashed_email,
        payment.net_received_amount as conversion_value,
        payment.currency_id as currency_code,
        extradata_horoscopes.gclid as gclid,
        payment.created_at as conversion_event_time
    FROM
        subscriptions
    INNER JOIN
        payment ON subscriptions.external_reference = payment.external_reference
    INNER JOIN
        extradata_horoscopes ON extradata_horoscopes.subscription_id = subscriptions.subscription_id
    WHERE
        extradata_horoscopes.gclid IS NOT NULL;

END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`u487445196_mihoroscopo`@`127.0.0.1` PROCEDURE `GetGroupedSubscriptions`()
BEGIN
    SELECT
        `subscriptions`.`created_at`,
        `extradata_horoscopes`.`gclid`,
        SUM(IFNULL(`charged_amount`, 0)) AS total_charged_amount,
        'ARS' AS currency_id
    FROM
        `extradata_horoscopes`
    INNER JOIN
        `subscriptions` ON `subscriptions`.`subscription_id` = `extradata_horoscopes`.`subscription_id`
    LEFT JOIN
        `payment` ON `subscriptions`.`external_reference` = `payment`.`external_reference`
    WHERE
        1
    GROUP BY
        `extradata_horoscopes`.`gclid`
    ORDER BY
        `subscriptions`.`created_at` ASC;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`u487445196_mihoroscopo`@`127.0.0.1` PROCEDURE `getMonthlySummary`()
BEGIN
    SELECT
        DATE(created_at) AS date,                           -- Date of the payment
        COUNT(payment_id) AS total_payments,                -- Number of payments per day
        AVG(total_paid_amount) AS average_payment,         -- Average payment amount per day
        SUM(total_paid_amount) AS total_paid,              -- Total amount paid by users per day
        SUM(net_received_amount) AS total_received         -- Total amount received by the company per day
    FROM
        payment
    WHERE
        created_at >= NOW() - INTERVAL 1 MONTH               -- Filter for the last month
        AND status = 'approved'                              -- Only include approved payments
    GROUP BY
        DATE(created_at)                                     -- Group by date (day)
    ORDER BY
        date ASC;                                           -- Order results by date
END$$
DELIMITER ;
