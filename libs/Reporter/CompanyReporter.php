<?php
/** @package    Franchise::Reporter */

/** import supporting libraries */
require_once("verysimple/Phreeze/Reporter.php");

/**
 * This is an example Reporter based on the Company object.  The reporter object
 * allows you to run arbitrary queries that return data which may or may not fith within
 * the data access API.  This can include aggregate data or subsets of data.
 *
 * Note that Reporters are read-only and cannot be used for saving data.
 *
 * @package Franchise::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class CompanyReporter extends Reporter
{

	// the properties in this class must match the columns returned by GetCustomQuery().
	// 'CustomFieldExample' is an example that is not part of the `company` table
	public $CustomFieldExample;

	public $Id;
	public $Name;
	public $Code;
	public $Territory;
	public $Region;
	public $Start;
	public $Phone;
	public $Mobile;
	public $Email;
	public $Address;
	public $Suburb;
	public $Postcode;
	public $State;
	public $City;
	public $CreatedDate;
	public $UpdatedDate;
	public $Status;

	/*
	* GetCustomQuery returns a fully formed SQL statement.  The result columns
	* must match with the properties of this reporter object.
	*
	* @see Reporter::GetCustomQuery
	* @param Criteria $criteria
	* @return string SQL statement
	*/
	static function GetCustomQuery($criteria)
	{
		$sql = "select
			'custom value here...' as CustomFieldExample
			,`company`.`id` as Id
			,`company`.`name` as Name
			,`company`.`code` as Code
			,`company`.`territory` as Territory
			,`company`.`region` as Region
			,`company`.`start` as Start
			,`company`.`phone` as Phone
			,`company`.`mobile` as Mobile
			,`company`.`email` as Email
			,`company`.`address` as Address
			,`company`.`suburb` as Suburb
			,`company`.`postcode` as Postcode
			,`company`.`state` as State
			,`company`.`city` as City
			,`company`.`created_date` as CreatedDate
			,`company`.`updated_date` as UpdatedDate
			,`company`.`status` as Status
		from `company`";

		// the criteria can be used or you can write your own custom logic.
		// be sure to escape any user input with $criteria->Escape()
		$sql .= $criteria->GetWhere();
		$sql .= $criteria->GetOrder();

		return $sql;
	}
	
	/*
	* GetCustomCountQuery returns a fully formed SQL statement that will count
	* the results.  This query must return the correct number of results that
	* GetCustomQuery would, given the same criteria
	*
	* @see Reporter::GetCustomCountQuery
	* @param Criteria $criteria
	* @return string SQL statement
	*/
	static function GetCustomCountQuery($criteria)
	{
		$sql = "select count(1) as counter from `company`";

		// the criteria can be used or you can write your own custom logic.
		// be sure to escape any user input with $criteria->Escape()
		$sql .= $criteria->GetWhere();

		return $sql;
	}
}

?>