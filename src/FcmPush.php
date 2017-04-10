<?php

/**
 * Class FcmPush
 */
class FcmPush
{
    const URL = 'https://fcm.googleapis.com/fcm/send';

    /**
     * Send message to mobile devices.
     *
     * @param array $devices
     * @param string $message
     * @param string $authID
     * @param string $priority
     * @return string
     */
    public static function send(array $devices, string $message, string $authID, string $priority = 'high')
    {
        $response = ["devices" => count($devices), "success" => 0, "failure" => 0];
        
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
            'priority'     => $priority,
//            'notification' => $message,
            'data'         => array('message' => $message)
        ];
        
        foreach ($devices as $device) {
            $data['to'] = $device;
            
            $request = json_decode(self::request($headers, $data));
            if ($request['success'] > 0) {
                $response['success']++;
            } else {
                $response['failure']++;
            }
        }

        return $response;
    }
    
    private static function request($headers, $data)
    {
        $ch = curl_init(self::URL);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        
        $response = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        
        return $response;
    }
}
