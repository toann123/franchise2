<?php
/** @package    Franchise::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

/**
 * CustomerMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the CustomerDAO to the customer datastore.
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
class CustomerMap implements IDaoMap, IDaoMap2
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
			self::$FM["Id"] = new FieldMap("Id","customer","id",true,FM_TYPE_INT,20,null,true);
			self::$FM["Firstname"] = new FieldMap("Firstname","customer","firstname",false,FM_TYPE_VARCHAR,100,null,false);
			self::$FM["Lastname"] = new FieldMap("Lastname","customer","lastname",false,FM_TYPE_VARCHAR,100,null,false);
			self::$FM["AccountId"] = new FieldMap("AccountId","customer","account_id",false,FM_TYPE_INT,20,null,false);
			self::$FM["BranchName"] = new FieldMap("BranchName","customer","branch_name",false,FM_TYPE_VARCHAR,200,null,false);
			self::$FM["Phone"] = new FieldMap("Phone","customer","phone",false,FM_TYPE_INT,15,null,false);
			self::$FM["Mobile"] = new FieldMap("Mobile","customer","mobile",false,FM_TYPE_VARCHAR,15,null,false);
			self::$FM["Email"] = new FieldMap("Email","customer","email",false,FM_TYPE_VARCHAR,200,null,false);
			self::$FM["Address"] = new FieldMap("Address","customer","address",false,FM_TYPE_VARCHAR,200,null,false);
			self::$FM["Suburb"] = new FieldMap("Suburb","customer","suburb",false,FM_TYPE_VARCHAR,200,null,false);
			self::$FM["Postcode"] = new FieldMap("Postcode","customer","postcode",false,FM_TYPE_INT,5,null,false);
			self::$FM["State"] = new FieldMap("State","customer","state",false,FM_TYPE_VARCHAR,10,null,false);
			self::$FM["City"] = new FieldMap("City","customer","city",false,FM_TYPE_VARCHAR,200,null,false);
			self::$FM["CreatedBy"] = new FieldMap("CreatedBy","customer","created_by",false,FM_TYPE_INT,20,null,false);
			self::$FM["CreatedDate"] = new FieldMap("CreatedDate","customer","created_date",false,FM_TYPE_TIMESTAMP,null,"CURRENT_TIMESTAMP",false);
			self::$FM["UpdatedDate"] = new FieldMap("UpdatedDate","customer","updated_date",false,FM_TYPE_TIMESTAMP,null,"0000-00-00 00:00:00",false);
			self::$FM["Status"] = new FieldMap("Status","customer","status",false,FM_TYPE_INT,11,null,false);
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