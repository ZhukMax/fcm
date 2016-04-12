<?php
trait GooglePushTrait
{
	public function gpush ($devicesID, $message, $authID)
	{
		if (!is_array($devicesID))
			return array(false, 'error-devices-array');
		if (!$authID || $authID == NULL)
			return array(false, 'authorization-key-empty');

			$postData = array(
				'registration_ids' => $devicesID,
				'data' => array('message' => $message)
			);
			$ch = curl_init('https://android.googleapis.com/gcm/send');
			curl_setopt_array($ch, array(
				CURLOPT_POST => TRUE,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_HTTPHEADER => array(
					'Authorization: key='.$authID,
					'Content-Type: application/json'
				),
				CURLOPT_POSTFIELDS => json_encode($postData)
			));
			$response = curl_exec($ch);
			
			if($response === FALSE)
				die(curl_error($ch));
				
			return $response;
	}
}
?>
