<?php


$accessToken =   "EAAIs0WZCXf5MBANW9v7Xdyi2zFnYyIVIZAucid6NHTRHqIw1HoKnrAIZAEuwtZCeiYtZBpKScYIK6gbcE6tx9s35wMCCg29MPxyfj9l3hMj0Kc6SZAxB8ZCyz7HSHDAtclU6MfbRjrYkJZCZBrTZCcLmQYJqitVfsoNNldyWnvy0nHkqniSq7xoHP7";


$input = json_decode(file_get_contents('php://input'), true);

$senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
$messageText = $input['entry'][0]['messaging'][0]['message']['text'];

$response = null;
$answer = "";
//set Message

$data = file_get_contents('php://input');



$response = blog($messageText, $senderId);



$ch = curl_init('https://graph.facebook.com/v5.0/me/messages?access_token='.$accessToken);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
if(!empty($input)){
$result = curl_exec($ch);
file_put_contents('result.json', json_encode($response));
}

curl_close($ch);


function blog($messageText,$senderId){



  if($messageText == "hi") {
    $answer = "Hello, my name is new";
    //send message to facebook bot
    $response = [
        'recipient' => [ 'id' => $senderId ],
        'message' => [ 'text' => $answer ]
    ];
    file_put_contents('test.json', json_encode($response) );
}



  if($messageText == "blog"){
    $answer = ["attachment"=>[
     "type"=>"template",
     "payload"=>[
       "template_type"=>"generic",
       "elements"=>[
         [
           "title"=>"Welcome to Peter\'s Hats",
           "item_url"=>"https://www.cloudways.com/blog/migrate-symfony-from-cpanel-to-cloud-hosting/",
           "image_url"=>"https://www.cloudways.com/blog/wp-content/uploads/Migrating-Your-Symfony-Website-To-Cloudways-Banner.jpg",
           "subtitle"=>"We\'ve got the right hat for everyone.",
           "buttons"=>[
             [
               "type"=>"web_url",
               "url"=>"https://petersfancybrownhats.com",
               "title"=>"View Website"
             ],
             [
               "type"=>"postback",
               "title"=>"Start Chatting",
               "payload"=>"DEVELOPER_DEFINED_PAYLOAD"
             ]              
           ]
         ]
       ]
     ]
   ]];

    $response = [
   'recipient' => [ 'id' => $senderId ],
   'message' => $answer 
];

}


if($messageText == "hello"){
  $response = [
    'recipient' => [ 'id' => $senderId ],
    'payload' => "<GET_STARTED_PAYLOAD>" 
 ];
}
return $response;

}