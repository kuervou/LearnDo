<?php

namespace App\Controllers;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;

class CalendarController extends BaseController
{
    public function addEvent()
    {
        // Create a Google Calendar client.
        $client = new Google_Client();

        // Set the application name.
        $client->setApplicationName('LearnDo');

        // Set the client ID.
        $client->setClientId('1088626693952-0k0qi82mlnn7hu9mi95ggck5ms1jeeaf.apps.googleusercontent.com');

        // Set the client secret.
        $client->setClientSecret('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');

        // Set the redirect URI.
        $client->setRedirectUri(base_url('add-to-google-calendar'));

        // Add the calendar scope.
        $client->addScope(Google_Service_Calendar::CALENDAR);


        $datosCalendar =  $_SESSION['datosCalendar'];


        $horaInicio = \DateTime::createFromFormat('H:i:s', $datosCalendar['hora']);
        $horaFin = clone $horaInicio;
        $horaFin->modify('+1 hour');
        
        $event = new Google_Service_Calendar_Event([
            'summary' => $datosCalendar['nombre'],
            'location' => $datosCalendar['location'], 
            'description' => $datosCalendar['descripcion'],
            'start' => ['dateTime' => $datosCalendar['fecha'] . 'T' . $horaInicio->format('H:i:s'), 'timeZone' => 'America/Montevideo',],
            'end' => ['dateTime' => $datosCalendar['fecha'] . 'T' . $horaFin->format('H:i:s'), 'timeZone' => 'America/Montevideo',],
            
        ]);
        
        

        if (isset($_GET['code'])) {
            // El usuario ha sido redirigido desde la página de autorización de Google.
            // Obtenemos el token de acceso con el código que Google nos ha proporcionado.
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        
            if(!isset($token['error'])) {
                // Guardamos el token de acceso en la sesión para poder usarlo en el futuro.
                $_SESSION['access_token'] = $token['access_token'];
        
                // También deberías guardar el token de refresco, si lo hay.
                if (isset($token['refresh_token'])) {
                    $_SESSION['refresh_token'] = $token['refresh_token'];
                }
            } else {
                // Hubo un error al obtener el token de acceso.
                // Deberías manejar este error de alguna manera.
            }
        }
        


        // Check if the user has already authorized the application to access their Google Calendar.
        if (!isset($_SESSION['access_token'])) {
            // Redirect the user to a page where they can authorize the application.
            header('Location: ' . filter_var($client->createAuthUrl(), FILTER_SANITIZE_URL));
            exit;
        }

        $client->setAccessToken($_SESSION['access_token']);
        
        // Set the calendar ID.
        $calendarId = 'primary';

        // Add the event to the user's Google Calendar.
        $service = new Google_Service_Calendar($client);
        $service->events->insert($calendarId, $event);

        // Display a success message to the user.
        header('Location: ' . filter_var(base_url(''), FILTER_SANITIZE_URL));
        exit;
    }
}