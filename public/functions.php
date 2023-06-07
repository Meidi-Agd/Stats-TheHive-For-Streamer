<?php

namespace allFunctions;
class functions
{
    public function callAPI($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode == 404) {
            $error = false;
        }
        else{
            $error = true;
        }
        curl_close($ch);
        return $error;
    }
}