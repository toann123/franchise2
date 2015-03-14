<?php
/** @package    Franchise::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

/**
 * SupportMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the SupportDAO to the support datastore.
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
class SupportMap implements IDaoMap, IDaoMap2
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
			self::$FM["Id"] = new FieldMap("Id","support","id",true,FM_TYPE_INT,20,null,true);
			self::$FM["Position"] = new FieldMap("Position","support","position",false,FM_TYPE_VARCHAR,200,null,false);
			self::$FM["Firstname"] = new FieldMap("Firstname","support","firstname",false,FM_TYPE_VARCHAR,100,null,false);
			self::$FM["Lastname"] = new FieldMap("Lastname","support","lastname",false,FM_TYPE_VARCHAR,100,null,false);
			self::$FM["Phone"] = new FieldMap("Phone","support","phone",false,FM_TYPE_VARCHAR,15,null,false);
			self::$FM["Mobile"] = new FieldMap("Mobile","support","mobile",false,FM_TYPE_VARCHAR,20,null,false);
			self::$FM["Email"] = new FieldMap("Email","support","email",false,FM_TYPE_VARCHAR,200,null,false);
			self::$FM["Address"] = new FieldMap("Address","support","address",false,FM_TYPE_VARCHAR,200,null,false);
			self::$FM["Postcode"] = new FieldMap("Postcode","support","postcode",false,FM_TYPE_VARCHAR,10,null,false);
			self::$FM["State"] = new FieldMap("State","support","state",false,FM_TYPE_VARCHAR,20,null,false);
			self::$FM["City"] = new FieldMap("City","support","city",false,FM_TYPE_VARCHAR,100,null,false);
			self::$FM["CompanyId"] = new FieldMap("CompanyId","support","company_id",false,FM_TYPE_INT,20,null,false);
			self::$FM["CreatedDate"] = new FieldMap("CreatedDate","support","created_date",false,FM_TYPE_TIMESTAMP,null,"CURRENT_TIMESTAMP",false);
			self::$FM["UpdatedDate"] = new FieldMap("UpdatedDate","support","updated_date",false,FM_TYPE_TIMESTAMP,null,"0000-00-00 00:00:00",false);
			self::$FM["Status"] = new FieldMap("Status","support","status",false,FM_TYPE_TINYINT,1,null,false);
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