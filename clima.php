<?php


function obtenerClima($ciudad, $clave_api) {

    $url = "http://api.openweathermap.org/data/2.5/weather?q={$ciudad}&appid={$clave_api}";

    $curl = curl_init($url);


    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $respuesta = curl_exec($curl);


    curl_close($curl);

   
    $datos_clima = json_decode($respuesta, true);

    if ($datos_clima && $datos_clima['cod'] == 200) {
        $clima = $datos_clima['weather'][0]['description'];
        $temperatura_actual = kelvinToCelsius($datos_clima['main']['temp']);
        $temperatura_min = kelvinToCelsius($datos_clima['main']['temp_min']);
        $temperatura_max = kelvinToCelsius($datos_clima['main']['temp_max']);
        $humedad = $datos_clima['main']['humidity'];
        $velocidad_viento = $datos_clima['wind']['speed'];
        $ciudad = $datos_clima['name'];
        $pais = $datos_clima['sys']['country'];

        $clima_actual = "El clima en {$ciudad}, {$pais}: {$clima}. 
                         Temperatura actual: {$temperatura_actual}°C. 
                         Temperatura mínima: {$temperatura_min}°C. 
                         Temperatura máxima: {$temperatura_max}°C. 
                         Humedad: {$humedad}%. 
                         Velocidad del viento: {$velocidad_viento} m/s.";

        return $clima_actual;
    } else {

        return "Error al obtener el clima para {$ciudad}.";
    }
}

function kelvinToCelsius($kelvin) {
    return $kelvin - 273.15;
}

$ciudad = "Ciudad de Mexico";


$clave_api = "ef907a1f2a22bde7b2335d915349a675";

echo obtenerClima($ciudad, $clave_api);

?>