<?php
/*
    Class to send push notifications using Google Cloud Messaging for Android
 
    Example usage
    -----------------------
    $an = new GCMPushMessage($apiKey);
    $an->setDevices($devices);
    $response = $an->send($message);
    -----------------------
     
    $apiKey Your GCM api key
    $devices An array or string of registered device tokens
    $message The mesasge you want to push out
 
    @author Matt Grundy
 
    Adapted from the code available at:
    http://stackoverflow.com/questions/11242743/gcm-with-php-google-cloud-messaging
 
*/
class GCMPushMessage {
 
    var $url = 'https://android.googleapis.com/gcm/send';
    var $serverApiKey = "";
    var $devices = array();
 
 	public function __construct($apiKeyIn) {
        // Constructor's functionality here, if you have any.
        $this->serverApiKey = $apiKeyIn;
    }
/*
    function GCMPushMessage($apiKeyIn){
        $this->serverApiKey = $apiKeyIn;
    }
*/
 
    function setDevices($deviceIds){
 
        if(is_array($deviceIds)){
            $this->devices = $deviceIds;
        } else {
            $this->devices = array($deviceIds);
        }
 
    }
 
    function send($message){
 
        if(!is_array($this->devices) || count($this->devices) == 0){
            return $this->error("No devices set");
        }
 
        if(strlen($this->serverApiKey) < 8){
            return $this->error("Server API Key not set");
        }
 
        $fields = array(
            'registration_ids'  => $this->devices,
//            'data'              => array( 'title' => $title, 'message' => $message, 'link' => $link ),
            'data'              => array( 'MESSAGE' => $message ),
        ); 
 
 
        //echo json_encode($fields);
        //exit;
 
 
        $headers = array( 
            'Authorization: key=' . $this->serverApiKey,
            'Content-Type: application/json'
        );
 
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt( $ch, CURLOPT_URL, $this->url );
 
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
 
        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
 
        // Execute post
        $result = curl_exec($ch);
 
        // Close connection
        curl_close($ch);
 
        return $result;
    }
 
    function error($msg){
    	$result = new stdClass();
    	$result->RESULT = "GCM notification failed with error:\t" . $msg;
    	return $result;
    }
}
?>