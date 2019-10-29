<?php

// Email configuration
$from = 'Correo electrónico recibido de <info@oralmaax.com.co>';
$sendTo = 'Correo electrónico enviado a <info@oralmaax.com.co>';
$subject = 'Has recibido un nuevo correo electrónico';
$fields = array('name' => 'Nombre', 'surname' => 'Apellido', 'phone' => 'Telefono', 'email' => 'Email', 'message' => 'Mensaje'); // array variable name => Text to appear in the email
$okMessage = 'Tu mensaje ha sido enviado exitosamente!';
$errorMessage = 'Se encontró un error al enviar el mensaje. Vuelve a intentarlo.';

try
{
    $emailText = "Has recibido un nuevo mensaje\n****************************************\n";

    foreach ($_POST as $key => $value) {

        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
else {
    echo $responseArray['message'];
}
