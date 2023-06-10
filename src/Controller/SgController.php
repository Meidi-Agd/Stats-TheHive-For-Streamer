<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SgController extends AbstractController
{
    #[Route('/sg/{name}', name: 'sg_name')]
    public function sky_name(string $name): Response
    {
        $gamePlay = 0; $gameWin = 0; $winRate = 0; $kills = 0; $death = 0; $KD = 0;
        $url = "https://api.playhive.com/v0/game/all/sg/" . $name;
        if($this->callAPI($url) == true)
        {
            $file = file_get_contents($url);
            $json = json_decode($file);
            if(!empty($json->{'played'}))
            {
                $gamePlay = $json->{'played'};
                $gameWin = $json->{'victories'};
                $winRate = number_format(($gameWin / $gamePlay) * 100, 2);
            }
            if(!empty($json->{'deaths'})){
                $death = $json->{'deaths'};
                if(!empty($json->{'kills'})){
                    $kills = $json->{'kills'};
                    $KD = number_format($kills / $death, 2);
                }
            }
            $error = false;
        }
        else
        {
            $gamePlay = "none";
            $gameWin = "none";
            $winRate = "none";
            $kills = "none";
            $death = "none";
            $KD = "none";
            $name = "not Found";
            $error = true;
        }







        return $this->render('sg/index.html.twig', [
            'controller_name' => 'SGController',
            'gamePlay' => $gamePlay,
            'gameWin' => $gameWin,
            'winRate' => $winRate,
            'kills' => $kills,
            'deaths' => $death,
            'kd' => $KD,
            'nickname' => $name,
            'error' => $error,
        ]);
    }

    #[Route('/sg', name: 'sg')]
    public function index(): Response
    {
//        return $this->render('sky/index.html.twig', [
//            'controller_name' => 'SkyController',
//        ]);
        return $this->redirect('/home');
    }

    function callAPI($url)
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
