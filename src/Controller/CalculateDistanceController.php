<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Distances;
use App\Form\DistancesType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class CalculateDistanceController extends AbstractController
{

   
    /**
     * @Route("/calculate/distance", name="calculate_distance")
     */
    public function index(Request $request)
    {
        $distances = new Distances();
        $form = $this->createForm(DistancesType::class, $distances);

        // find lat, long of the ipAdress 
       
        $api_key = 'at_YbiYhMi2tjNicWiQa4HK6bkMw2WRQ';
        $api_url = 'https://geo.ipify.org/api/v1';
        


        // find lat, long of the postAdress

        if ($request->isMethod('POST')) {
       
           

        
            $form->handleRequest($request);
            if ($form->isValid()) {
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($distances);
                $em->flush();
                return $this->render('calculate_distance/index.html.twig', [
                        'form' => $form->createView()
                ]);
                 // Add a flash session message
                $this->addFlash('info', 'A calculated distance has been approved');
                $ip = $form->get('ipAddress');
                $url = "{$api_url}?apiKey={$api_key}&ipAddress={$ip}";
                $result = file_get_contents($url);
                $result = json_decode($result, true);
                $lat1 =  $result['location']['lat'];
                $lng1 =  $result['location']['lng']; 

                $adress = $form->get('postalAddress');
        
                $url = "{$api_url}?apiKey={$api_key}&Address={$adress}";
                $result=file_get_contents($url);
                $result = json_decode($result, true);
        
                $lat2 =  $result['location']['lat'];
                $lng2 =  $result['location']['lng']; 
            }
            
            $distance_km =  $this->distance($lat1, $lng1, $lat2, $lng2, "K");
            get('distance')->submit($distance_km);
        }

        return $this->render('calculate_distance/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function distance($lat1, $lon1, $lat2, $lon2, $unit) {
       
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
          return 0;
        }
        else {
          $theta = $lon1 - $lon2;
          $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
          $dist = acos($dist);
          $dist = rad2deg($dist);
          $miles = $dist * 60 * 1.1515;
          $unit = strtoupper($unit);
      
          if ($unit == "K") {
            return ($miles * 1.609344);
          } else if ($unit == "N") {
            return ($miles * 0.8684);
          } else {
            return $miles;
          }
        }
    }
}
