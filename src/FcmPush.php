<?php

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
     * @param $message
     * @param $authID
     * @return mixed
     */
    public function send($devices, $message, $authID)
    {
        $headers = [
            'Authorization' => 'key = ' . $authID,
            'Content-Type'  => 'application/json'
        ];

        $fields = [
            'to'           => $devices,
            'priority'     => 'high',
//            'notification' => $message,
            'data'         => array('message' => $message)
        ];

        $result = self::curl($headers, $fields);

        return $result;
    }

    /**
     * @param array $headers
     * @param array $fields
     * @return mixed
     */
    private function curl($headers, $fields)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);

        return $result;
    }
}