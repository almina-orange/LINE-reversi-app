<?php
// read all library from composer
require_once __DIR__.'/vendor/autoload.php';

// load functions
require __DIR__.'/basic_function.php';

// instancing "CurlHTTPClient" using access token
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));

// instancing "LINEBot" using CurlHTTPClient and secret
$bot = new \LINE\LINEBot($httpClient, ['channelSecret'=>getenv('CHANNEL_SECRET')]);

// get signature of LINE Messaging API
$signature = $_SERVER['HTTP_'.\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

// check signature, and parse and storage request
// if uncorrectly, preview exception
try {
  $events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
} catch (\LINE\LINEBot\Exception\InvalidSignatureException $e) {
  error_log('parseEventRequest failed. InvalidSignatureException => '.var_export($e, true));
} catch (\LINE\LINEBot\Exception\UnknownEventTypeException $e) {
  error_log('parseEventRequest failed. UnknownEventTypeException => '.var_export($e, true));
} catch (\LINE\LINEBot\Exception\UnknownMessageTypeException $e) {
  error_log('parseEventRequest failed. UnknownMessageTypeException => '.var_export($e, true));
} catch (\LINE\LINEBot\Exception\InvalidEventRequestException $e) {
  error_log('parseEventRequest failed. InvalidEventRequestException => '.var_export($e, true));
}

/*=== main process ===*/
// proceed events
foreach ($events as $event) {
  error_log(file_get_contents('php://input'));

  // skip if not MessageEvent Class
  if (!($event instanceof \LINE\LINEBot\Event\MessageEvent)) {
    error_log('Non message event has come');
    continue;
  }

  // skip if not TextMessage Class
  if (!($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage)) {
    error_log('Non text message has come');
    continue;
  }

  // stones starting position
  $stones = [
    [0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 1, 2, 0, 0, 0],
    [0, 0, 0, 2, 1, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0]
  ];

  // reply image map
  // replyImagemap($bot, $event->getReplyToken(), 'board', $stoens);
  $bot->replyText($event->getReplyToken(), $evnet->getText());
}

/*=== functions ===*/
// reply board Imagemap
function replyImagemap($bot, $replyToken, $alternativeText, $stones) {
  // action array
  $actionArray = array();

  // add dummy tap area
  $areaBuilder = new \LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(0, 0, 1, 1);
  array_push($actionArray, new \LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder('-', $areaBuilder));

  // build "ImagemapMessage"
  // 'https://...' is URL of image
  $baseSizeBuilder = new \LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder(1040, 1040);
  $imagemapMessageBuilder = new \LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder('https://'.$_SERVER['HTTP_HOST'].'/imgs/'.urlencode(json_encode($stones)).'/'.uniqid(), $alternativeText, $baseSizeBuilder, $actionArray);

  $response = $bot->replyMessage($replyToken, $imagemapMessageBuilder);
  if (!$response->isScuceeded()) {
    error_log('Failed!'.$response->getHTTPStatus.' '.$response0->getRawBody());
  }
}
?>
