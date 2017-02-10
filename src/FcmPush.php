<?php
use GuzzleHttp\Psr7\Request;

/**
 * Class FcmPush
 */
class FcmPush
{
    const URL = 'https://fcm.googleapis.com/fcm/send';

    /**
     * Send message to mobile device
     *
     * @param $devices
     * @param string $message
     * @param string $authID
     * @return string
     */
    public static function send($devices, string $message, string $authID) : string
    {
        if (!$devices) {
            return json_encode(array(false, 'List of devices can not be empty.'));
        }
        if (!$authID || $authID === NULL) {
            return json_encode(array(false, 'Authorization key empty.'));
        }

        $headers = [
            'Authorization' => 'key = ' . $authID,
            'Content-Type'  => 'application/json'
        ];

        $data = [
            'to'           => $devices,
            'priority'     => 'high',
//            'notification' => $message,
            'data'         => array('message' => $message)
        ];

//        $result = self::request($headers, json_encode($data));
        $result = new Request('POST', self::URL, $headers, json_encode($data));

        return $result;
    }

    /**
     * Request to Google FCM
     *
     * @param array $headers
     * @param string $data
     * @return string
     */
//    private function request(array $headers, string $data)
//    {
//        $ch = curl_init();
//
//        curl_setopt($ch, CURLOPT_URL, self::URL);
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//
//        $result = curl_exec($ch);
//
//        if ($result === FALSE) {
//            die('Curl failed: ' . curl_error($ch));
//        }
//        curl_close($ch);
//
//        return $result;
//    }
}