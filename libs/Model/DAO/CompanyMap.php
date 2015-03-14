<?php
/** @package    Franchise::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

/**
 * CompanyMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the CompanyDAO to the company datastore.
 *
 * WARNING: THIS IS AN AUTO-GENERATED FILE
 *
 * This file should generally not be edited by hand except in special circumstances.
 * You can override the default fetching strategies for KeyMaps in _config.php.
 * Leaving this file alone will allow easy re-generation of all DAOs in the event of schema changes
 *
 * @package Franchise::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class CompanyMap implements IDaoMap, IDaoMap2
{

	private static $KM;
	private static $FM;
	
	/**
	 * {@inheritdoc}
	 */
	public static function AddMap($property,FieldMap $map)
	{
		self::GetFieldMaps();
		self::$FM[$property] = $map;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public static function SetFetchingStrategy($property,$loadType)
	{
		self::GetKeyMaps();
		self::$KM[$property]->LoadType = $loadType;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function GetFieldMaps()
	{
		if (self::$FM == null)
		{
			self::$FM = Array();
			self::$FM["Id"] = new FieldMap("Id","company","id",true,FM_TYPE_INT,20,null,true);
			self::$FM["Name"] = new FieldMap("Name","company","name",false,FM_TYPE_VARCHAR,200,null,false);
			self::$FM["Code"] = new FieldMap("Code","company","code",false,FM_TYPE_VARCHAR,100,null,false);
			self::$FM["Territory"] = new FieldMap("Territory","company","territory",false,FM_TYPE_VARCHAR,100,null,false);
			self::$FM["Region"] = new FieldMap("Region","company","region",false,FM_TYPE_VARCHAR,100,null,false);
			self::$FM["Start"] = new FieldMap("Start","company","start",false,FM_TYPE_DATETIME,null,null,false);
			self::$FM["Phone"] = new FieldMap("Phone","company","phone",false,FM_TYPE_VARCHAR,15,null,false);
			self::$FM["Mobile"] = new FieldMap("Mobile","company","mobile",false,FM_TYPE_VARCHAR,20,null,false);
			self::$FM["Email"] = new FieldMap("Email","company","email",false,FM_TYPE_VARCHAR,200,null,false);
			self::$FM["Address"] = new FieldMap("Address","company","address",false,FM_TYPE_VARCHAR,100,null,false);
			self::$FM["Suburb"] = new FieldMap("Suburb","company","suburb",false,FM_TYPE_VARCHAR,200,null,false);
			self::$FM["Postcode"] = new FieldMap("Postcode","company","postcode",false,FM_TYPE_VARCHAR,10,null,false);
			self::$FM["State"] = new FieldMap("State","company","state",false,FM_TYPE_VARCHAR,50,null,false);
			self::$FM["City"] = new FieldMap("City","company","city",false,FM_TYPE_VARCHAR,100,null,false);
			self::$FM["CreatedDate"] = new FieldMap("CreatedDate","company","created_date",false,FM_TYPE_TIMESTAMP,null,"CURRENT_TIMESTAMP",false);
			self::$FM["UpdatedDate"] = new FieldMap("UpdatedDate","company","updated_date",false,FM_TYPE_TIMESTAMP,null,"0000-00-00 00:00:00",false);
			self::$FM["Status"] = new FieldMap("Status","company","status",false,FM_TYPE_TINYINT,1,null,false);
		}
		return self::$FM;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function GetKeyMaps()
	{
		if (self::$KM == null)
		{
			self::$KM = Array();
		}
		return self::$KM;
	}

}

?>