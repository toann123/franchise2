<?php
/** @package    Franchise::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

/**
 * WorkMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the WorkDAO to the work datastore.
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
class WorkMap implements IDaoMap, IDaoMap2
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
			self::$FM["Id"] = new FieldMap("Id","work","id",true,FM_TYPE_INT,20,null,true);
			self::$FM["Name"] = new FieldMap("Name","work","name",false,FM_TYPE_VARCHAR,200,null,false);
			self::$FM["Description"] = new FieldMap("Description","work","description",false,FM_TYPE_TEXT,null,null,false);
			self::$FM["CreatedDate"] = new FieldMap("CreatedDate","work","created_date",false,FM_TYPE_TIMESTAMP,null,"CURRENT_TIMESTAMP",false);
			self::$FM["UpdatedDate"] = new FieldMap("UpdatedDate","work","updated_date",false,FM_TYPE_TIMESTAMP,null,"0000-00-00 00:00:00",false);
			self::$FM["Status"] = new FieldMap("Status","work","status",false,FM_TYPE_TINYINT,1,null,false);
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