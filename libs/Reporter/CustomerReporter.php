<?php
/** @package    Franchise::Reporter */

/** import supporting libraries */
require_once("verysimple/Phreeze/Reporter.php");

/**
 * This is an example Reporter based on the Customer object.  The reporter object
 * allows you to run arbitrary queries that return data which may or may not fith within
 * the data access API.  This can include aggregate data or subsets of data.
 *
 * Note that Reporters are read-only and cannot be used for saving data.
 *
 * @package Franchise::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class CustomerReporter extends Reporter
{

	// the properties in this class must match the columns returned by GetCustomQuery().
	// 'CustomFieldExample' is an example that is not part of the `customer` table
	public $CustomFieldExample;

	public $Id;
	public $Firstname;
	public $Lastname;
	public $AccountId;
	public $BranchName;
	public $Phone;
	public $Mobile;
	public $Email;
	public $Address;
	public $Suburb;
	public $Postcode;
	public $State;
	public $City;
	public $CreatedBy;
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
			,`customer`.`id` as Id
			,`customer`.`firstname` as Firstname
			,`customer`.`lastname` as Lastname
			,`customer`.`account_id` as AccountId
			,`customer`.`branch_name` as BranchName
			,`customer`.`phone` as Phone
			,`customer`.`mobile` as Mobile
			,`customer`.`email` as Email
			,`customer`.`address` as Address
			,`customer`.`suburb` as Suburb
			,`customer`.`postcode` as Postcode
			,`customer`.`state` as State
			,`customer`.`city` as City
			,`customer`.`created_by` as CreatedBy
			,`customer`.`created_date` as CreatedDate
			,`customer`.`updated_date` as UpdatedDate
			,`customer`.`status` as Status
		from `customer`";

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
		$sql = "select count(1) as counter from `customer`";

		// the criteria can be used or you can write your own custom logic.
		// be sure to escape any user input with $criteria->Escape()
		$sql .= $criteria->GetWhere();

		return $sql;
	}
}

?>