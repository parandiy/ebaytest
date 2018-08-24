<?php

namespace AppBundle\Controller;

use DTS\eBaySDK\Constants\GlobalIds;
use DTS\eBaySDK\Product\Types\ProductIdentifier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use \DTS\eBaySDK\Shopping\Services;
use \DTS\eBaySDK\Shopping\Types;

class DefaultController
	extends Controller
{
	private $params;
	private $env;


	private $config;

	public function __construct()
	{
		$this->config = [
			'sandbox'    => [
				'credentials'    => [
					'devId'  => '7bed5958-5109-4724-810f-c64caaf23e27',
					'appId'  => 'MichaelP-Testing-SBX-859ccfefe-100cc167',
					'certId' => 'SBX-59ccfefe4dbf-85c8-4f8a-ac12-e9c9',
				],
				'authToken'      => 'AgAAAA**AQAAAA**aAAAAA**qnp/Ww**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4ajCZGDowudj6x9nY+seQ**0LMEAA**AAMAAA**zJlGDQgm9W58C/uwTaLCaZNyWxbVvA9EDIr4aBD2Cm/At07fRqrkctO/hUHJUvFH9Eq4F0U5wRpuDBJ7KXDCmIYRJB29WQbzg8sYf5xmLjv4iyANHKg97SfbZIHaSaXSr1u/jdzPiJXhP1pATPEi885B2O2l1VMECXmqdjoNTHHS922yDjvSohFRKsA2JZi283ZuIBdz77eeYNKaHM8ZcCnK1/zB7OaUlnXm7iqUsBQ9fkmi2/NHH2E3/CrNWm9SWNkSAEu5umUIOizrCS7snE8X/Nkzsoqs+38Cd0KDj94EqeI+0SO6RtWYP9ZSg4c/cjeoTfxC6RfA1ZNM5lc3b5r739RPtwOZwKoNgQL+rUdOs2mhw1URJV4PFi3HmFfR5Le3sUHPnpweLKUhiQ67yNoGqPQRz/2zzZ6CN5a/PpDYm6EhVYBnouGJZ7GecdEUyASBnR339owk8mz1bUuvjU8k/oz8vsYU3CLKpBVdmg9KKAhhFxNQOslYv0iE/tCqmpXrMeXRBxV0XPr9gGq8s2QgisPF0GUx5XSLNi4rHu7ipMpFjBjltR5mg5zyAb4ybgdw6QSjUtKC+J91MJRQUwIHQPJ1lLcNY1smPbJmX5zaeFNw9hPELaApTKsW+mC7e0rq5D9EZkknZUQ1WMLZ8vQZhuP2Tkj1SKqNdrl3ecd7VEGXTgQrsrkSzu/Zu8oYU1agr9TG0niNc+5+jgSxz5sjbHOvzRflJTk9kOUEt0TYH9etUdcs1PB9KkNUeTIn',
				'oauthUserToken' => 'AgAAAA**AQAAAA**aAAAAA**bUd/Ww**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4ajCZGCpgqdj6x9nY+seQ**0LMEAA**AAMAAA**Y9M5EQeQV0HYFIvCMZVezdfzogT7RQUsuywcohL3qouFApOm/aj/G6wM/BtD2ofHdp8wyTqDZZMQlfzTfxgaKpqHaY1/am+9TQ6uTeUA9dqAwS5hahoeXKBB3tNzxbat8jGPI0cEsrqnycHbJqvZK4MtaTKwpKl7d4a50L0DOnlsJtV8/XsQeqR3wvBYVMzqreQhuUqj65RuQeQJTKABcgnmkE6bVmMQqAA880EB3MaDgoyHlg4M2V2iJ6U5ZC3hxPqMzpY7iRYAdppQIwLY6G5TDkfETUCd0PM70AVk0x8057oeRwUnhMnrWxBSOHvPUs23c0elRHk+J8aySza2x/5J5snIoGIWYAunjoXDdOy42MKgJA3bU2jR/HybmNfavsCLXZPLEQVjs018v/xFiE0oeoWJeEA7VO/5sduYXnI4MB4wwIsKe1fmXXyoWIY0qIH2hP8EB09dDNE46Mqrg6k8sJbC7FdF5VR1B2VHf6wEIfqHV6pCATb8mtZPS9p1DWfiuhd+HOShZ53k/7hroskoYxbvadMKvzR4MVlNwWv1+/t2AwWeiths+G3lllNRjOsYro3IKhbutZj1fzD0n5h+96pAJXVNXUcaqrH/jkvULA6Y2WKrUQxa1ghiuCPLhvXdX9eVzdfZYBy91ic+EodWxdPP6T0PRM9ii0NxJsdrZfzdYUB5FhFmKv5b5Qx08mRRyHK3b2389kg0B+06VypNo6b8txzpcxqGuExPRjczANY9VL+rtya2H5Afc2Kb',
				'ruName'         => 'Michael_Parandi-MichaelP-Testin-qhhnxmuqc',
				'sandbox'        => TRUE,
				'siteId'         => \DTS\eBaySDK\Constants\SiteIds::US
			],
			'production' => [
				'credentials'    => [
					'devId'  => '7bed5958-5109-4724-810f-c64caaf23e27',
					'appId'  => 'Mychailo-Testing-PRD-d59c57255-ecb21662',
					'certId' => 'PRD-59c57255d6e1-8512-4b25-b133-5028',
				],
				'authToken'      => 'AgAAAA**AQAAAA**aAAAAA**In5/Ww**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wJloWlDJKHow6dj6x9nY+seQ**VZMEAA**AAMAAA**4ulr/pU7FmYWWiXRC15M3pHqJApIprhoUl66SNiPBwWiOokZUhyv11UniqyLracBDVbv3DQDZzA7KbKLAt7aeLHMtpQQv72EM5bFKv/9TYo+7j3FDbRptYjyQgxxhm9FABHdkwjv+LwRa9ItQbPh6NVRBQP0xMOIm8cTZWTms0wz9SGP7IuvZA+39hLslu2i6UVJCGJv+eqTPqzosvV1/DTyJ83QDcnEUmQLT9MaxX9fowIfuJ+vcwY/UN5Tosxl6XElOTNkiW69v3ah7M2yO5AxoxyWerlVdLFvfSjlh8DoSUfpgdPzqq12oLKpQU1anAWa2IpyfaE+tMJZzg8+CKoUTk6PoU6CZIAoSzE4WTv3Akx5JUDFJaZOp+cbcLiq/nzok85Ar9VbhW23Gc2pbZNZbGDdD6i527dNirygEnk0RQNcwdK9pL90KHgY87WTr29DFxTonnyty+9CieK+4exAaheYqpfXibfV/+x4XfeWCQMZfSDjjcUh/wdGYN+ZSJwFpG2TjaKwy4DMMfbyLNuD6rjW0aptskiev0W6a9ubMGcqUN5PleqtrjTrgTs6H0CZWd7xGRyZ3WKpmxodGHm+9/YyUaQ+mz627Lk1MHaU+RF1ew480sco72z/WgtkN9Bs7uiFz1iM411qDmp36YCQSloWEq92NOW+kuEP0iIz2TawvnO/cyBt1PGKtt6e1zJdtNIbjJtfKOe7RYKDTBQjtRmpdhADUPHTK+FEwSIP3flrQXK9Pp2DmOmaPM41',
				'oauthUserToken' => 'v^1.1#i^1#p^1#r^0#f^0#I^3#t^H4sIAAAAAAAAAOVXbWwURRju3bUlJ4LBLwzU5FgQDGT3Zndvr7srd+ZKqTTQD7iT1FbAvd3Zdu3e7rEz1/Z+oG1jMDQoJEYQftgaDISYEBuCkvBDUTQBTEpiJMHwoYQQScQoBjRRorPbo1wr4bN8JN6fy7zzzjvP87zvvLMDusuDc9cuWvvHJN8E/0A36Pb7fOxEECwvmzc54J9WVgKKHHwD3bO6S3sDP81HSsbMyssgytoWgqGujGkh2TPGqJxjybaCDCRbSgYiGatyMlG3ROYYIGcdG9uqbVKh2uoYpaqcCniR4wAH0nyaJVbrSsyUHaMiuhbhlbQuaaKkVYoRMo9QDtZaCCsWjlEcYEUaiDQXSQFe5iQ5IjCVADRToeXQQYZtERcGUHEPruytdYqwXh+qghB0MAlCxWsTNcmGRG31wvrU/HBRrHhBhyRWcA6NHi2wNRharpg5eP1tkOctJ3OqChGiwvHhHUYHlRNXwNwGfE/qqKLqRG5Fi0Z0yHPcuEhZYzsZBV8fh2sxNFr3XGVoYQPnb6QoUSP9KlRxYVRPQtRWh9y/pTnFNHQDOjFqYVXipURjIxWvy6ttimHadAoibFitdOOyaloTJFWo5ASBhmqaY6NRrrDPcLCCymM2WmBbmuFqhkL1Nq6CBDQcKw1bJA1xarAanISOXUDFfkJBwqgkNLs5HU5iDrdZblphhugQ8oY3TsDIaowdI53DcCTC2AlPoRilZLOGRo2d9EqxUD1dKEa1YZyVw+HOzk6mk2dspzXMAcCGm+qWJNU2mFEo19c9656/ceMFtOFRUSFZiQwZ57MESxcpVQLAaqXinCSJUbag+2hY8bHW/xiKOIdHH4jxOiC8JHJSJUsaUqUuamBcek28UKNhFwdMK3k6ozjtEGdNRYW0Suosl4GOocm8oHO8qENai0o6HZF0nU4LWpRmdQgBhOm0Kon/o3Nys5WeVO0sbLRNQ82PT72PV63zjtaoODifhKZJDDdb9NckiVyS94Cee9ZvgaIbA5EgStZg3NJmVDsTthXS01zTKg/1HfE2yG34QCWVEBxmamjD1xjj0WVQh8o4ENk5h9zgTIPb1lN2O7TIKcGObZrQWX7Tbe9uN/T708yvyUo1DSLjqgeN2a11ydssbQXfX9Klvb6mscRZgReAyPKicEfcFnhpTeXvSc+6hbwushGG2l34/AiPfgvFS7wf2+vbA3p9g+Q5BcLgGXYmmFEeeLE08PA0ZGDIGIrOIKPVIp/4DmTaYT6rGI6/3NdS8fHOVUWvr4EV4KmR91cwwE4seoyBiqszZewjUyexIhC5COA5KSI0g5lXZ0vZJ0sfX6/UnxeOnDm19mX/nk1NHYEvTvScAZNGnHy+shJSFiXVu85/eIia3BB6bHDf9z01sy4e/O7X80OXP5E+OH7pnyC7Oj201zb21W33zW7Y9BnX1142qydoHf5In3LsraN9/ld2RIZmNL3Rf6l9gu/0hvXT133lBJSzPe/WDsyZ4p+3dbYe3PfLhudbqk489Prgyqe3bVm35EDFD1Vo3v7ctuSPx9lLR06pR8s3H1xMh+Zs7J+yK8e+fXnH1hkn9x8VW3dv3rzz7z8Dh4Ymvnfg2y//ev/RN825Fztmc72HE32vaavP9p/uir1w7tl1e/oXH/i5Y++FNWtA33PRqX0ngydX7l7ab0/+fcvghO6K1vau+S3TL3y+4lxz7ztf13xj//ZpvVPRxT5xrEXo255KD6fvX/8QTP8XDwAA',
				'ruName'         => 'Mychailo_Parand-Mychailo-Testin-ovrhj',
				'siteId'         => \DTS\eBaySDK\Constants\SiteIds::US
			]
		];

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
