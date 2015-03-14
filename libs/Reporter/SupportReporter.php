<?php
/** @package    Franchise::Reporter */

/** import supporting libraries */
require_once("verysimple/Phreeze/Reporter.php");

/**
 * This is an example Reporter based on the Support object.  The reporter object
 * allows you to run arbitrary queries that return data which may or may not fith within
 * the data access API.  This can include aggregate data or subsets of data.
 *
 * Note that Reporters are read-only and cannot be used for saving data.
 *
 * @package Franchise::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class SupportReporter extends Reporter
{

	// the properties in this class must match the columns returned by GetCustomQuery().
	// 'CustomFieldExample' is an example that is not part of the `support` table
	public $CustomFieldExample;

	public $Id;
	public $Position;
	public $Firstname;
	public $Lastname;
	public $Phone;
	public $Mobile;
	public $Email;
	public $Address;
	public $Postcode;
	public $State;
	public $City;
	public $CompanyId;
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
			,`support`.`id` as Id
			,`support`.`position` as Position
			,`support`.`firstname` as Firstname
			,`support`.`lastname` as Lastname
			,`support`.`phone` as Phone
			,`support`.`mobile` as Mobile
			,`support`.`email` as Email
			,`support`.`address` as Address
			,`support`.`postcode` as Postcode
			,`support`.`state` as State
			,`support`.`city` as City
			,`support`.`company_id` as CompanyId
			,`support`.`created_date` as CreatedDate
			,`support`.`updated_date` as UpdatedDate
			,`support`.`status` as Status
		from `support`";

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
		$sql = "select count(1) as counter from `support`";

		// the criteria can be used or you can write your own custom logic.
		// be sure to escape any user input with $criteria->Escape()
		$sql .= $criteria->GetWhere();

		return $sql;
	}
}

?>