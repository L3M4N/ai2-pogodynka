<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherController extends AbstractController
{

    #[Route('/weather/{city}/{country}', name: 'app_weather_city', requirements: ['country' => '[A-Z]{2}'])]
    public function city(
        String $city,
        String $country,
        LocationRepository $locationRepository,
        MeasurementRepository $measurementRepository
    ): Response {

        $location = $locationRepository->findOneBy(['city' => $city, 'country' => $country]);

        $measurements = $measurementRepository->findByLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);

    }
}
