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
        $em = $this->getDoctrine()->getManager();
        $distances = new Distances();
        $form = $this->createForm(DistancesType::class, $distances);


        // find lat, long of the ipAdress 
       
        $api_key = 'at_YbiYhMi2tjNicWiQa4HK6bkMw2WRQ';
        $api_url = 'https://geo.ipify.org/api/v1';
        


        // find lat, long of the postAdress

        if ($request->isMethod('POST')) {
        
            $form->handleRequest($request);
            if ($form->isValid()) {
                
                //Get the ipAdress from the form before been submitted 
                $ip = $form['ipAddress']->getData();
                $url = "{$api_url}?apiKey={$api_key}&ipAddress={$ip}";
                $result = file_get_contents($url);
                $result = json_decode($result, true);
                $lat1 =  $result['location']['lat'];
                $lng1 =  $result['location']['lng']; 

                $adress = $form['postalAddress']->getData();
        
                $url = "{$api_url}?apiKey={$api_key}&address={'12 Rue Cortot, 75018 Paris France'}";
                $result=file_get_contents($url);
                $result = json_decode($result, true);
        
                $lat2 =  $result['location']['lat'];
                $lng2 =  $result['location']['lng']; 
                $distance_km =  $this->distance($lat1, $lng1, $lat2, $lng2, "K");

                //call the function calculate distance below (it use the lat,lng to calculate distance) 
                $distances->setDistance($distance_km);
                
                //dump($distances);
                //dump($lat1,$lng2,$lat2,$lng2);
                //$form->get('distance')->submit($distance_km);

                 // Add a flash session message to be able to show the distance as I am using the same rendring 
                $this->addFlash('info', 'the distance between the ipAdress location and the postal adress is :'.$distance_km.' km');
                $em->persist($distances);
                $em->flush();
                
            }       
            
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
