<?php

use GuzzleHttp\Psr7\Request,
    GuzzleHttp\Client;

/**
 * Class FcmPush
 */
class FcmPush
{
    const URL = 'https://fcm.googleapis.com/fcm/send';

    /**
     * Send message to mobile devices.
     *
     * @param string|array $devices
     * @param string $message
     * @param string $authID
     * @param string $priority
     * @return \GuzzleHttp\Client
     */
    public static function send($devices, string $message, string $authID, string $priority = 'high')
    {
        if (!$devices) {
            return json_encode(array(false, 'List of devices can not be empty.'));
        }
        if (!$authID || $authID === NULL) {
            return json_encode(array(false, 'Authorization key empty.'));
        }

        $headers = [
            'Authorization: key = ' . $authID,
            'Content-Type: application/json'
        ];

        $data = [
            'to'           => $devices,
            'priority'     => $priority,
//            'notification' => $message,
            'data'         => array('message' => $message)
        ];
        
        $client = new Client();
        //$request = new Request('POST', self::URL, $headers, json_encode($data));
        $response = $client->send('POST', self::URL, ["headers" => $headers, $data]);

        return $response;
    }
}
