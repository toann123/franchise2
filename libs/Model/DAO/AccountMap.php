<?php
/** @package    Franchise::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

/**
 * AccountMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the AccountDAO to the account datastore.
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
class AccountMap implements IDaoMap, IDaoMap2
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
			self::$FM["Id"] = new FieldMap("Id","account","id",true,FM_TYPE_INT,20,null,true);
			self::$FM["Firstname"] = new FieldMap("Firstname","account","firstname",false,FM_TYPE_VARCHAR,100,null,false);
			self::$FM["Lastname"] = new FieldMap("Lastname","account","lastname",false,FM_TYPE_VARCHAR,100,null,false);
			self::$FM["AccountTypeId"] = new FieldMap("AccountTypeId","account","account_type_id",false,FM_TYPE_INT,20,null,false);
			self::$FM["CompanyId"] = new FieldMap("CompanyId","account","company_id",false,FM_TYPE_INT,20,null,false);
			self::$FM["Email"] = new FieldMap("Email","account","email",false,FM_TYPE_VARCHAR,200,null,false);
			self::$FM["Phone"] = new FieldMap("Phone","account","phone",false,FM_TYPE_VARCHAR,20,null,false);
			self::$FM["Mobile"] = new FieldMap("Mobile","account","mobile",false,FM_TYPE_VARCHAR,20,null,false);
			self::$FM["Address"] = new FieldMap("Address","account","address",false,FM_TYPE_VARCHAR,200,null,false);
			self::$FM["Suburb"] = new FieldMap("Suburb","account","suburb",false,FM_TYPE_VARCHAR,200,null,false);
			self::$FM["Postcode"] = new FieldMap("Postcode","account","postcode",false,FM_TYPE_INT,5,null,false);
			self::$FM["State"] = new FieldMap("State","account","state",false,FM_TYPE_VARCHAR,20,null,false);
			self::$FM["City"] = new FieldMap("City","account","city",false,FM_TYPE_VARCHAR,100,null,false);
			self::$FM["Password"] = new FieldMap("Password","account","password",false,FM_TYPE_VARCHAR,200,null,false);
			self::$FM["CreatedDate"] = new FieldMap("CreatedDate","account","created_date",false,FM_TYPE_TIMESTAMP,null,"CURRENT_TIMESTAMP",false);
			self::$FM["UpdatedDate"] = new FieldMap("UpdatedDate","account","updated_date",false,FM_TYPE_TIMESTAMP,null,"0000-00-00 00:00:00",false);
			self::$FM["Status"] = new FieldMap("Status","account","status",false,FM_TYPE_TINYINT,1,null,false);
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