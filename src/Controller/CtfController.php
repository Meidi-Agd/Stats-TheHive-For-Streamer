<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CtfController extends AbstractController
{
    #[Route('/ctf/{name}', name: 'ctf_name')]
    public function sky_name(string $name): Response
    {
        $gamePlay = 0; $gameWin = 0; $winRate = 0; $kills = 0; $assists = 0; $death = 0; $KD = 0;$KDA = 0;
        $url = "https://api.playhive.com/v0/game/all/ctf/" . $name;

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
                if(!empty($json->{'assists'}))
                {
                    $assists = $json->{'assists'};
                    $KDA = number_format(($kills + $assists) / $death, 2);
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
            $assists = "none";
            $death = "none";
            $KD = "none";
            $name = "not Found";
            $error = true;
        }







        return $this->render('ctf/index.html.twig', [
            'controller_name' => 'SKYController',
            'gamePlay' => $gamePlay,
            'gameWin' => $gameWin,
            'winRate' => $winRate,
            'kills' => $kills,
            'assists' => $assists,
            'deaths' => $death,
            'kd' => $KD,
            'kda' => $KDA,
            'nickname' => $name,
            'error' => $error,
        ]);
    }

    #[Route('/ctf', name: 'ctf')]
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
