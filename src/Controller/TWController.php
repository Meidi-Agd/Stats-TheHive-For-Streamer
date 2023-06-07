<?php

namespace App\Controller;

use functions;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TWController extends AbstractController
{
    #[Route('/wars/{name}', name: 'wars_name')]
    public function wars_name(string $name): Response
    {
        $prestige = 0; $gamePlay = 0; $gameWin = 0; $winRate = 0; $kills = 0; $death = 0; $KD = 0;
        $url = "https://api.playhive.com/v0/game/all/wars/" . $name;
        if($this->callAPI($url) == true)
        {
            $file = file_get_contents($url);
            $json = json_decode($file);
            $prestige = $json->{'prestige'};
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
            $prestige = "none";
            $gamePlay = "none";
            $gameWin = "none";
            $winRate = "none";
            $kills = "none";
            $death = "none";
            $KD = "none";
            $name = "not Found";
            $error = true;
        }







        return $this->render('tw/ba', [
            'controller_name' => 'TWController',
            'prestige' => $prestige,
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

    #[Route('/wars', name: 'wars')]
    public function index(): Response
    {
//            return $this->render('home/index.html.twig', [
//                'Title' => 'Treasure Wars',
//            ]);

            return $this->redirect('/home');

    }
}
