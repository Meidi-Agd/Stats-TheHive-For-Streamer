<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(): Response
    {
        //Treasure Wars stats top
        $urlWars = "https://api.playhive.com/v0/game/monthly/wars";
        if($this->callAPI($urlWars) == true)
        {
            $file = file_get_contents($urlWars);
            $json = json_decode($file);

            foreach ($json as $item)
            {
                if ($item->{'index'} == 0){
                    $tw1 = $item->{'username'};
                }
                if ($item->{'index'} == 1){
                    $tw2 = $item->{'username'};
                }
                if ($item->{'index'} == 2){
                    $tw3 = $item->{'username'};
                    break;
                }
            }
        }

        //SkyWars stats top
        $urlSky = "https://api.playhive.com/v0/game/monthly/sky";
        if($this->callAPI($urlSky) == true)
        {
            $file = file_get_contents($urlSky);
            $json = json_decode($file);

            foreach ($json as $item)
            {
                if ($item->{'index'} == 0){
                    $ts1 = $item->{'username'};
                }
                if ($item->{'index'} == 1){
                    $ts2 = $item->{'username'};
                }
                if ($item->{'index'} == 2){
                    $ts3 = $item->{'username'};
                    break;
                }
            }
        }

        //Capture the flag stats top
        $urlCtf = "https://api.playhive.com/v0/game/monthly/ctf";
        if($this->callAPI($urlCtf) == true)
        {
            $file = file_get_contents($urlCtf);
            $json = json_decode($file);

            foreach ($json as $item)
            {

                if ($item->{'index'} == 0){
                    $tc1 = $item->{'username'};
                }
                if ($item->{'index'} == 1){
                    $tc2 = $item->{'username'};
                }
                if ($item->{'index'} == 2){
                    $tc3 = $item->{'username'};
                    break;
                }
            }
        }

        //SurvivalGame stats top
        $urlSg = "https://api.playhive.com/v0/game/monthly/sg";
        if($this->callAPI($urlSg) == true)
        {
            $file = file_get_contents($urlSg);
            $json = json_decode($file);

            foreach ($json as $item)
            {
                if ($item->{'index'} == 0){
                    $tsg1 = $item->{'username'};
                }
                if ($item->{'index'} == 1){
                    $tsg2 = $item->{'username'};
                }
                if ($item->{'index'} == 2){
                    $tsg3 = $item->{'username'};
                    break;
                }
            }
        }

        //DeathRun stats top
        $urlCtf = "https://api.playhive.com/v0/game/monthly/dr";
        if($this->callAPI($urlCtf) == true)
        {
            $file = file_get_contents($urlCtf);
            $json = json_decode($file);

            foreach ($json as $item)
            {

                if ($item->{'index'} == 0){
                    $tdr1 = $item->{'username'};
                }
                if ($item->{'index'} == 1){
                    $tdr2 = $item->{'username'};
                }
                if ($item->{'index'} == 2){
                    $tdr3 = $item->{'username'};
                    break;
                }
            }
        }


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'topWars1' => $tw1,
            'topWars2' => $tw2,
            'topWars3' => $tw3,
            'topSky1' => $ts1,
            'topSky2' => $ts2,
            'topSky3' => $ts3,
            'topCtf1' => $tc1,
            'topCtf2' => $tc2,
            'topCtf3' => $tc3,
            'topSg1' => $tsg1,
            'topSg2' => $tsg2,
            'topSg3' => $tsg3,
            'topDr1' => $tdr1,
            'topDr2' => $tdr2,
            'topDr3' => $tdr3,
        ]);
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
