<?php
	include('./MelissaDataConsumer.php');

	class MelissaDataConsumerTest extends PHPUnit_Framework_TestCase
	{

		public $debug_write = false;

		/**
			Test to see if all methods are in the melissa data consumer class
		*/
		public function testClassAndMethodNames()
		{
			$this->assertTrue(class_exists('MelissaDataConsumer'));

			if ($this->debug_write === true) mkdir('./test/tmp');

			$MelissaDataReflection = new ReflectionClass("MelissaDataConsumer");

			$this->assertTrue($MelissaDataReflection->hasProperty("ID"));
			$this->assertTrue($MelissaDataReflection->hasProperty("URL"));

			$this->assertTrue($MelissaDataReflection->hasMethod('__construct'));
			$this->assertTrue($MelissaDataReflection->hasMethod('setID'));
			$this->assertTrue($MelissaDataReflection->hasMethod('getID'));
			$this->assertTrue($MelissaDataReflection->hasMethod('getURL'));
			$this->assertTrue($MelissaDataReflection->hasMethod('setURL'));
			$this->assertTrue($MelissaDataReflection->hasMethod('sendCommand'));
			$this->assertTrue($MelissaDataReflection->hasMethod('getZipCodeCount'));
			$this->assertTrue($MelissaDataReflection->hasMethod('getZipCodeBuyList'));
			$this->assertTrue($MelissaDataReflection->hasMethod('getCityCount'));
			$this->assertTrue($MelissaDataReflection->hasMethod('getCityBuyList'));
			$this->assertTrue($MelissaDataReflection->hasMethod('getCountyCount'));
			$this->assertTrue($MelissaDataReflection->hasMethod('getCountyBuyList'));
			$this->assertTrue($MelissaDataReflection->hasMethod('getStateCount'));
			$this->assertTrue($MelissaDataReflection->hasMethod('getStateBuyList'));
			$this->assertTrue($MelissaDataReflection->hasMethod('getRadiusCount'));
			$this->assertTrue($MelissaDataReflection->hasMethod('getRadiusBuyList'));
			$this->assertTrue($MelissaDataReflection->hasMethod('getStreetRecordCount'));
			$this->assertTrue($MelissaDataReflection->hasMethod('getStreetRecordBuyList'));
			$this->assertTrue($MelissaDataReflection->hasMethod('getCitiesByCountyCount'));
			$this->assertTrue($MelissaDataReflection->hasMethod('getCitiesByState'));
			$this->assertTrue($MelissaDataReflection->hasMethod('getCountiesByState'));
			$this->assertTrue($MelissaDataReflection->hasMethod('getStatesCount'));
			$this->assertTrue($MelissaDataReflection->hasMethod('getZipsByCity'));
		}


		/**
			Test to see if the send command methods works.
		*/
		public function testSendCommand()
		{
			$jsonContents = file_get_contents('./config.json');
			$json = json_decode($jsonContents);

			$MelissaData = new MelissaDataConsumer($json->APIKEY);

			$options = new \stdClass;
			$options->st = 'wa';

			$returnXML = $MelissaData->sendCommand('get/CountiesByState', $options);

			$DOMDocument = new DOMDocument();
			$DOMDocument->loadXML($returnXML);
			$schemaValidate = $DOMDocument->schemaValidate('./test/XSD/Consumer/getCountiesByState.xsd');

			$this->assertTrue($schemaValidate);
		}

		/**
			Tests to see if the zip code count method is returning the right xml structure.  Assert true if so.
		*/
		public function testGetZipCodeCount()
		{
			$jsonContents = file_get_contents('./config.json');
			$json = json_decode($jsonContents);

			$MelissaData = new MelissaDataConsumer($json->APIKEY);

			$returnXML = $MelissaData->getZipCodeCount('98119');
			if ($this->debug_write === true) file_put_contents('./test/tmp/'.__METHOD__.'.xml', $returnXML);

			$DOMDocument = new DOMDocument();
			$DOMDocument->loadXML($returnXML);
			$schemaValidate = $DOMDocument->schemaValidate('./test/XSD/Consumer/getZipCodeCount.xsd');

			$this->assertTrue($schemaValidate);
		}

		/**
			Tests to see if the zip code buy list method is returning the right xml structure.  Assert true if so.
		*/
		public function testGetZipCodeBuyList()
		{
			$jsonContents = file_get_contents('./config.json');
			$json = json_decode($jsonContents);

			$MelissaData = new MelissaDataConsumer($json->APIKEY);

			$options = new \stdClass;
			$options->zip = '98119';

			$returnXML = $MelissaData->getZipCodeBuyList('98119');
			if ($this->debug_write === true) file_put_contents('./test/tmp/'.__METHOD__.'.xml', $returnXML);

			$DOMDocument = new DOMDocument();
			$DOMDocument->loadXML($returnXML);
			$schemaValidate = $DOMDocument->schemaValidate('./test/XSD/Consumer/getZipCodeBuyList.xsd');

			$this->assertTrue($schemaValidate);
		}

		/**
			Tests to see if the get city count method works and is returning the right xml structure.  Assert true if so.
		*/
		public function testGetCityCount()
		{
			$jsonContents = file_get_contents('./config.json');
			$json = json_decode($jsonContents);

			$MelissaData = new MelissaDataConsumer($json->APIKEY);

			$returnXML = $MelissaData->getCityCount('wa;seattle');
			if ($this->debug_write === true) file_put_contents('./test/tmp/'.__METHOD__.'.xml', $returnXML);

			$DOMDocument = new DOMDocument();
			$DOMDocument->loadXML($returnXML);
			$schemaValidate = $DOMDocument->schemaValidate('./test/XSD/Consumer/getCityCount.xsd');

			$this->assertTrue($schemaValidate);
		}

		/**
			Tests to see if the get city buy list method is returning the right xml structure
		*/
		public function testGetCityBuyList()
		{
			$jsonContents = file_get_contents('./config.json');
			$json = json_decode($jsonContents);

			$MelissaData = new MelissaDataConsumer($json->APIKEY);

			$returnXML = $MelissaData->getCityBuyList('wa;seattle');
			if ($this->debug_write === true) file_put_contents('./test/tmp/'.__METHOD__.'.xml', $returnXML);

			$DOMDocument = new DOMDocument();
			$DOMDocument->loadXML($returnXML);
			$schemaValidate = $DOMDocument->schemaValidate('./test/XSD/Consumer/getCityBuyList.xsd');

			$this->assertTrue($schemaValidate);
		}

		/**
			Tests to see if the get county count method is returning the right xml structure.  Assert true if so.
		*/
		public function testGetCountyCount()
		{
			$jsonContents = file_get_contents('./config.json');
			$json = json_decode($jsonContents);

			$MelissaData = new MelissaDataConsumer($json->APIKEY);

			$returnXML = $MelissaData->getCountyCount('wa;snohomish');
			if ($this->debug_write === true) file_put_contents('./test/tmp/'.__METHOD__.'.xml', $returnXML);

			$DOMDocument = new DOMDocument();
			$DOMDocument->loadXML($returnXML);
			$schemaValidate = $DOMDocument->schemaValidate('./test/XSD/Consumer/getCountyCount.xsd');

			$this->assertTrue($schemaValidate);
		}

		/**
			Tests to see if the zip code count method is returning the right xml structure.  Assert true if so.
		*/
		public function testGetCountyBuyList()
		{
			$jsonContents = file_get_contents('./config.json');
			$json = json_decode($jsonContents);

			$MelissaData = new MelissaDataConsumer($json->APIKEY);

			$returnXML = $MelissaData->getCountyBuyList('wa;snohomish');
			if ($this->debug_write === true) file_put_contents('./test/tmp/'.__METHOD__.'.xml', $returnXML);

			$DOMDocument = new DOMDocument();
			$DOMDocument->loadXML($returnXML);
			$schemaValidate = $DOMDocument->schemaValidate('./test/XSD/Consumer/getCountyBuyList.xsd');

			$this->assertTrue($schemaValidate);
		}

		/**
			Tests to see if the get state count method is returning the right xml structure.  Assert true if so.
		*/
		public function testGetStateCount()
		{
			$jsonContents = file_get_contents('./config.json');
			$json = json_decode($jsonContents);

			$MelissaData = new MelissaDataConsumer($json->APIKEY);

			$returnXML = $MelissaData->getStateCount('wa');
			if ($this->debug_write === true) file_put_contents('./test/tmp/'.__METHOD__.'.xml', $returnXML);

			$DOMDocument = new DOMDocument();
			$DOMDocument->loadXML($returnXML);
			$schemaValidate = $DOMDocument->schemaValidate('./test/XSD/Consumer/getStateCount.xsd');

			$this->assertTrue($schemaValidate);
		}

		/**
			Tests to see if the get state buy list method is returning the right xml structure.  Assert true if so.
		*/
		public function testGetStateBuyList()
		{
			$jsonContents = file_get_contents('./config.json');
			$json = json_decode($jsonContents);

			$MelissaData = new MelissaDataConsumer($json->APIKEY);

			$returnXML = $MelissaData->getStateBuyList('wa');
			if ($this->debug_write === true) file_put_contents('./test/tmp/'.__METHOD__.'.xml', $returnXML);

			$DOMDocument = new DOMDocument();
			$DOMDocument->loadXML($returnXML);
			$schemaValidate = $DOMDocument->schemaValidate('./test/XSD/Consumer/getStateBuyList.xsd');

			$this->assertTrue($schemaValidate);
		}

		/**
			Tests to see if the get radius count method is returning the right xml structure.  Assert true if so.
		*/
		public function testGetRadiusCount()
		{
			$jsonContents = file_get_contents('./config.json');
			$json = json_decode($jsonContents);

			$MelissaData = new MelissaDataConsumer($json->APIKEY);

			$returnXML = $MelissaData->getRadiusCount('Pier 52, 801 Alaskan Way', '98104', '5', '1');
			if ($this->debug_write === true) file_put_contents('./test/tmp/'.__METHOD__.'.xml', $returnXML);

			$DOMDocument = new DOMDocument();
			$DOMDocument->loadXML($returnXML);
			$schemaValidate = $DOMDocument->schemaValidate('./test/XSD/Consumer/getRadiusCount.xsd');

			$this->assertTrue($schemaValidate);
		}

		/**
			Tests to see if the get radius buy list is returning the right xml structure.  Assert true if so.
		*/
		public function testGetRadiusBuyList()
		{
			$jsonContents = file_get_contents('./config.json');
			$json = json_decode($jsonContents);

			$MelissaData = new MelissaDataConsumer($json->APIKEY);

			$returnXML = $MelissaData->getRadiusBuyList('Pier 52, 801 Alaskan Way', '98104', '5', '1');
			if ($this->debug_write === true) file_put_contents('./test/tmp/'.__METHOD__.'.xml', $returnXML);

			$DOMDocument = new DOMDocument();
			$DOMDocument->loadXML($returnXML);
			$schemaValidate = $DOMDocument->schemaValidate('./test/XSD/Consumer/getRadiusBuyList.xsd');

			$this->assertTrue($schemaValidate);
		}

		/**
			Tests to see if the get street record count method is returning the right xml structure.  Assert true if so.
		*/
		public function testGetStreetRecordCount()
		{
			$jsonContents = file_get_contents('./config.json');
			$json = json_decode($jsonContents);

			$MelissaData = new MelissaDataConsumer($json->APIKEY);

			$returnXML = $MelissaData->getStreetRecordCount('98119', 'Republican');
			if ($this->debug_write === true) file_put_contents('./test/tmp/'.__METHOD__.'.xml', $returnXML);

			$DOMDocument = new DOMDocument();
			$DOMDocument->loadXML($returnXML);
			$schemaValidate = $DOMDocument->schemaValidate('./test/XSD/Consumer/getStreetRecordCount.xsd');

			$this->assertTrue($schemaValidate);
		}

		/**
			Tests to see if the street buy list method is returning the right xml structure.  Assert true if so.
		*/
		public function testGetStreetBuyList()
		{
			$jsonContents = file_get_contents('./config.json');
			$json = json_decode($jsonContents);

			$MelissaData = new MelissaDataConsumer($json->APIKEY);

			$returnXML = $MelissaData->getStreetRecordBuyList('98119', 'Republican');
			if ($this->debug_write === true) file_put_contents('./test/tmp/'.__METHOD__.'.xml', $returnXML);

			$DOMDocument = new DOMDocument();
			$DOMDocument->loadXML($returnXML);
			$schemaValidate = $DOMDocument->schemaValidate('./test/XSD/Consumer/getStreetRecordBuyList.xsd');

			$this->assertTrue($schemaValidate);
		}

		/**
			Tests to see if the zip code count method is returning the right xml structure.  Assert true if so.
		*/
		public function testGetCitiesByCountyCount()
		{
			$jsonContents = file_get_contents('./config.json');
			$json = json_decode($jsonContents);

			$MelissaData = new MelissaDataConsumer($json->APIKEY);

			$returnXML = $MelissaData->getCitiesByCountyCount('wa', 'snohomish');

			$DOMDocument = new DOMDocument();
			$DOMDocument->loadXML($returnXML);
			$schemaValidate = $DOMDocument->schemaValidate('./test/XSD/Consumer/getCitiesByCountyCount.xsd');

			$this->assertTrue($schemaValidate);
		}

		/**
			Tests to see if the get cities by state method is returning the right xml structure.  Assert true if so.
		*/
		public function testGetCitiesByState()
		{
			$jsonContents = file_get_contents('./config.json');
			$json = json_decode($jsonContents);

			$MelissaData = new MelissaDataConsumer($json->APIKEY);

			$returnXML = $MelissaData->getCitiesByState('wa');

			$DOMDocument = new DOMDocument();
			$DOMDocument->loadXML($returnXML);
			$schemaValidate = $DOMDocument->schemaValidate('./test/XSD/Consumer/getCitiesByState.xsd');

			$this->assertTrue($schemaValidate);
		}

		/**
			Tests to see if the get countries by state method is returning the right xml structure.  Assert true if so.
		*/
		public function testGetCountiesByState()
		{
			$jsonContents = file_get_contents('./config.json');
			$json = json_decode($jsonContents);

			$MelissaData = new MelissaDataConsumer($json->APIKEY);

			$returnXML = $MelissaData->getCountiesByState('wa');

			$DOMDocument = new DOMDocument();
			$DOMDocument->loadXML($returnXML);
			$schemaValidate = $DOMDocument->schemaValidate('./test/XSD/Consumer/getCountiesByState.xsd');

			$this->assertTrue($schemaValidate);
		}

		/**
			Tests to see if the get states count method is returning the right xml structure.  Assert true if so.
		*/
		public function testGetStatesCount()
		{
			$jsonContents = file_get_contents('./config.json');
			$json = json_decode($jsonContents);

			$MelissaData = new MelissaDataConsumer($json->APIKEY);

			$returnXML = $MelissaData->getStatesCount();

			$DOMDocument = new DOMDocument();
			$DOMDocument->loadXML($returnXML);
			$schemaValidate = $DOMDocument->schemaValidate('./test/XSD/Consumer/getStatesCount.xsd');

			$this->assertTrue($schemaValidate);
		}

		/**
			Tests to see if the get zipcodes by city method is returning the right xml structure.  Assert true if so.
		*/
		public function testGetZipsByCity()
		{
			$jsonContents = file_get_contents('./config.json');
			$json = json_decode($jsonContents);

			$MelissaData = new MelissaDataConsumer($json->APIKEY);

			$returnXML = $MelissaData->getZipsByCity('wa;seattle');

			$DOMDocument = new DOMDocument();
			$DOMDocument->loadXML($returnXML);
			$schemaValidate = $DOMDocument->schemaValidate('./test/XSD/Consumer/getZipsByCity.xsd');

			$this->assertTrue($schemaValidate);
		}
	}
?>