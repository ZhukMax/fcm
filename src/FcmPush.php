<?php
use GuzzleHttp\Psr7\Request;

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
     * @return \GuzzleHttp\Psr7\Request
     */
    public static function send($devices, string $message, string $authID)
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
            'priority'     => 'high',
//            'notification' => $message,
            'data'         => array('message' => $message)
        ];
        $result = new Request('POST', self::URL, $headers, json_encode($data));

        return $result;
    }
}
