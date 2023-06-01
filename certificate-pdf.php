<?php
require "config/limited.php";
require "config/config.php";

$html = '
<html>
<head>
<style>
. {
    font-family: Courier New;
}
body {font-family: Courier New;
	font-size: 10pt;
}
p {	margin: 0pt; }
table.items {
	border: 0.1mm solid #000000;
}
td { vertical-align: top; }
.items td {
	border-left: 0.1mm solid #000000;
	border-right: 0.1mm solid #000000;
}
table thead td { background-color: #EEEEEE;
	text-align: center;
	border: 0.1mm solid #000000;
	font-variant: small-caps;
}
.items td.blanktotal {
	background-color: #EEEEEE;
	border: 0.1mm solid #000000;
	background-color: #FFFFFF;
	border: 0mm none #000000;
	border-top: 0.1mm solid #000000;
	border-right: 0.1mm solid #000000;
}
.items td.totals {
	text-align: right;
	border: 0.1mm solid #000000;
}
.items td.cost {
	text-align: "." center;
}
</style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
<table width="100%"><tr>
<td width="50%" style="color:#0000BB; "><span style="font-weight: bold; font-size: 14pt;"><img src="img/los_santos.png" width="110"></td>
<td width="50%" style="text-align: right;"><img src="img/ems_sanctuary.png" width="110"><img src="img/caduceus.png" height="110"></td>
</tr></table>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}<br>
Hôpital de Los Santos
</div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<table width="100%" style="font-family: serif;" cellpadding="10"><tr>
<td width="45%" style=""><span style="font-size: 11pt; color: #555555;">de: <b>'. htmlspecialchars($_POST["cert-doctor"]) .'</b>
<br/>
à: <b>'.$WEBSITE_SETTINGS_NAME.'</b>
<br/>
le: <b>'. htmlspecialchars($_POST["cert-date"]) .'</b>
</td>

<td width="10%">&nbsp;</td>
</tr></table>
<br />
<br />
<div style="font-size: 15pt; text-align: center;"><b>'. htmlspecialchars($_POST["cert-type"]) .'<br>
'.$WEBSITE_SETTINGS_NAME.'</b></div>
<br/><br/>

<div style="font-size: 11pt; text-align: left;"><u>A l’attention de l’entreprise <b>'. htmlspecialchars($_POST["entreprise"]) .'</b></u></div>
<br/><br/>
<div style="font-size: 11pt; text-align: left;">
Je soussigné, <b>'. htmlspecialchars($_POST["doctor"]) .'</b>, médecin à Los Santos, certifie avoir reçu <b>'. htmlspecialchars($_POST["patientlastname"]) .' '. htmlspecialchars($_POST["patientfirstname"]) .'</b> né le <b>'. htmlspecialchars($_POST["patientdate"]) .'</b>, le <b>'. htmlspecialchars($_POST["date"]) .'</b> et atteste que son état ne lui permet pas d’exercer ses fonctions au sein de votre entreprise pour une durée de <b>'. htmlspecialchars($_POST["duration"]) .' JOUR(S)</b>. 
<br/><br/>
<b>Un nouvel examen sera nécessaire avant toute reprise d\'activité.</b>

<br/><br/><br/><br/>

<div style="font-size: 11pt; text-align: right;"><img src="img/tampon_generique.png"/><br/> <img src="img/signatures/'. htmlspecialchars($_POST["doctor"]) .'.png" width="175px"/></div>
<br/>
</div>
</body>
</html>
';

$path = (getenv('MPDF_ROOT')) ? getenv('MPDF_ROOT') : __DIR__;
require_once $path . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf([
	'margin_left' => 20,
	'margin_right' => 15,
	'margin_top' => 48,
	'margin_bottom' => 25,
	'margin_header' => 10,
	'margin_footer' => 10
]);

$mpdf->SetProtection(array('print'));
$mpdf->SetTitle("Arrêt de travail");
$mpdf->SetAuthor("Hôpital Viceroy");
$mpdf->showWatermarkText = true;
$mpdf->watermarkTextAlpha = 0.1;
$mpdf->SetDisplayMode('fullpage');

$mpdf->WriteHTML($html);
if (!empty($_POST['publish'])):
    $mpdf->Output('files/Arrêts/'. $_POST["patientlastname"] . '_' . $_POST["patientfirstname"] . '_' . $_POST["numr"] . '.pdf', F);
//=======================================================================================================
// Create new webhook in your Discord channel settings and copy&paste URL
//=======================================================================================================

$webhookurl = "<WEBHOOKURL>";

//=======================================================================================================
// Compose message. You can use Markdown
// Message Formatting -- https://discordapp.com/developers/docs/reference#message-formatting
//========================================================================================================

$timestamp = date("c", strtotime("now"));

$json_data = json_encode([
    // Message
    "content" => "Un nouvel arrêt a été publié dans les archives de l'hôpital de Viceroy !",
    
    // Username
    "username" => "EMS - Archives",

    // Avatar URL.
    // Uncoment to replace image set in webhook
    "avatar_url" => "https://sanctu.noroute.fr/ems/img/ems_sanctuary_white.png",

    // Text-to-speech
    "tts" => false,

    // File upload
    // "file" => "",

    // Embeds Array
    "embeds" => [
        [
            // Embed Title
            "title" => "📃 Lien de l'arrêt",

            // Embed Type
            "type" => "rich",

            // Embed Description
            "description" => "Un nouvel arrêt est délivré par l'hôpital de Viceroy.",

            // URL of title link
            "url" => 'https://sanctu.noroute.fr/ems/files/Arrêts/'. $_POST["patientlastname"] . '_' . $_POST["patientfirstname"] . '_' . $_POST["numr"] . '.pdf',

            // Timestamp of embed must be formatted as ISO8601
            "timestamp" => $timestamp,

            // Embed left border color in HEX
            "color" => hexdec( "2A9FD6" ),

            // Footer
            "footer" => [
                "text" => "Wqnted#9745",
                "icon_url" => "https://secure.gravatar.com/avatar/01b9050917da6448445eab81fc65ee2b.jpg?size=375"
            ],

            // Image to send
            "image" => [
                "url" => "https://sanctu.noroute.fr/ems/img/ems_sanctuary_white.png"
            ],

            // Thumbnail
            //"thumbnail" => [
            //    "url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=400"
            //],

            // Author
            "author" => [
                "name" => "Hôpital de Viceroy",
                "url" => "https://sanctu.noroute.fr/ems/"
            ],

            // Additional Fields array
            "fields" => [
                // Field 1
                [
                    "name" => "🩺 Docteur·esse",
                    "value" => ''. htmlspecialchars($_POST["doctor"]) .'',
                    "inline" => false
                ],
                // Field 2
                [
                    "name" => "👫🏼 Patient·e",
                    "value" => ''. htmlspecialchars($_POST["patientlastname"]) .' '. htmlspecialchars($_POST["patientfirstname"]) .'
					Né·e le : '. htmlspecialchars($_POST["patientdate"]) .'',
                    "inline" => false
                ],
                [
                    "name" => "💼 Arrêt",
                    "value" => 'Le : '. htmlspecialchars($_POST["date"]) .'
					Pendant : '. htmlspecialchars($_POST["duration"]) .' jour(s)
                    Entreprise : '. htmlspecialchars($_POST["entreprise"]) .'
                    ',
                    "inline" => false
                ],
				[
                    "name" => "📅 Fait le",
                    "value" => ''. htmlspecialchars($_POST["date"]) .'',
                    "inline" => false
                ]
            ]
        ]
    ]

], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );


$ch = curl_init( $webhookurl );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec( $ch );
// If you need to debug, or find out why you can't send message uncomment line below, and execute script.
// echo $response;
curl_close( $ch );
echo "<script>window.close();</script>";
else:
$mpdf->Output();
endif;