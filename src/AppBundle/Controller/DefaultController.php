<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
	extends Controller
{
	private $params;
	private $env;


	private $config;

	public function __construct($config)
	{
		$this->config = $config;

		$this->env = 'production';
	}

	/**
	 * @Route("/", name="homepage")
	 */
	public function indexAction()
	{

		$service = new \DTS\eBaySDK\Trading\Services\TradingService( [
			                                                             'credentials' => $this->config[$this->env]['credentials'],
			                                                             //'sandbox'     => TRUE,
			                                                             'siteId'      => $this->config[$this->env]['siteId']
		                                                             ] );


		$pictures_uploaded_urls = [ 'http://lorempixel.com/1500/1024/abstract', 'http://lorempixel.com/1500/1000/abstract' ];

		/* Не работает почему то загрузка файлов
		 *
		$images_dir = $this->get( 'kernel' )
		                   ->getRootDir() . '/../web/images/';

		foreach ( glob( $images_dir . "*.jpg" ) as $k => $filename )
		{
			$request                                      = new \DTS\eBaySDK\Trading\Types\UploadSiteHostedPicturesRequestType();
			$request->RequesterCredentials                = new \DTS\eBaySDK\Trading\Types\CustomSecurityHeaderType();
			$request->RequesterCredentials->eBayAuthToken = $this->config[$this->env]['authToken'];

			$request->PictureName = 'Example' . $k;
			$request->Version     = '517';

			$request->attachment( file_get_contents( $filename ) );

			$response = $service->uploadSiteHostedPictures( $request );

			$pictures_uploaded_urls[] = $response->SiteHostedPictureDetails->FullURL;
		}*/


		$picture_details              = new \DTS\eBaySDK\Trading\Types\PictureDetailsType;
		$picture_details->GalleryType = \DTS\eBaySDK\Trading\Enums\GalleryTypeCodeType::C_GALLERY;
		$picture_details->PictureURL  = $pictures_uploaded_urls;


		$item                 = new \DTS\eBaySDK\Trading\Types\ItemType();
		$item->ItemID         = '153137002480';
		$item->Title          = "Fuel Hose Fitting Russell 644123 1";
		$item->Description    = 'test descr';
		$item->Quantity       = 20;
		$item->SKU            = '12345678';
		$item->StartPrice     = new \DTS\eBaySDK\Trading\Types\AmountType( [ 'value' => 900.00 ] );
		$item->PictureDetails = $picture_details;


		$request = new \DTS\eBaySDK\Trading\Types\ReviseFixedPriceItemRequestType();

		$request->RequesterCredentials                = new \DTS\eBaySDK\Trading\Types\CustomSecurityHeaderType();
		$request->RequesterCredentials->eBayAuthToken = $this->config[$this->env]['authToken'];

		$request->Item = $item;


		$response = $service->reviseFixedPriceItem( $request );

		// replace this example code with whatever you need
		return $this->render( 'default/index.html.twig',
		                      [
			                      'base_dir' => realpath( $this->getParameter( 'kernel.project_dir' ) ) . DIRECTORY_SEPARATOR,
			                      'response' => $response
		                      ] );
	}


	/**
	 * @Route("/test", name="test")
	 */
	public function testAction( Request $request )
	{
		return $this->render( 'default/index.html.twig',
		                      [
			                      'base_dir' => realpath( $this->getParameter( 'kernel.project_dir' ) ) . DIRECTORY_SEPARATOR,
		                      ] );
	}
}
