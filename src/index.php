<?php

require '../vendor/autoload.php';

use GuzzleHttp\Client;
use Infobip\Api\SendWhatsAppApi;
use Infobip\Model\WhatsAppMessage;
use Infobip\Model\WhatsAppTemplateContent;
use Infobip\Model\WhatsAppTemplateDataContent;
use Infobip\Model\WhatsAppTemplateBodyContent;
use Infobip\Model\WhatsAppBulkMessage;
use Infobip\Configuration;

$client = new Client();

$configuration = (new Configuration())
->setHost('IB_API_HOST')
->setApiKeyPrefix('Authorization', 'App')
->setApiKey('Authorization', 'IB_API_KEY');

$whatsAppApi = new SendWhatsAppApi($client, $configuration);

$message = (new WhatsAppMessage())
->setFrom('447860099299')
->setTo('IB_PHONE_NUMBER')
->setContent(
    (new WhatsAppTemplateContent())
        ->setLanguage('en')
        ->setTemplateName('welcome_multiple_languages')
        ->setTemplateData(
            (new WhatsAppTemplateDataContent())
                ->setBody(
                    (new WhatsAppTemplateBodyContent())
                        ->setPlaceholders(['IB_USER_NAME'])
                )
        )
);

$bulkMessage = (new WhatsAppBulkMessage())->setMessages([$message]);

$messageInfo = $whatsAppApi->sendWhatsAppTemplateMessage($bulkMessage);

foreach ($messageInfo->getMessages() as $messageInfoItem) {
    echo $messageInfoItem->getStatus()->getDescription() . PHP_EOL;
}