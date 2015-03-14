<?php
/** @package    Franchise::Reporter */

/** import supporting libraries */
require_once("verysimple/Phreeze/Reporter.php");

/**
 * This is an example Reporter based on the Account object.  The reporter object
 * allows you to run arbitrary queries that return data which may or may not fith within
 * the data access API.  This can include aggregate data or subsets of data.
 *
 * Note that Reporters are read-only and cannot be used for saving data.
 *
 * @package Franchise::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class AccountReporter extends Reporter
{

	// the properties in this class must match the columns returned by GetCustomQuery().
	// 'CustomFieldExample' is an example that is not part of the `account` table
	public $CustomFieldExample;

	public $Id;
	public $Firstname;
	public $Lastname;
	public $AccountTypeId;
	public $CompanyId;
	public $Email;
	public $Phone;
	public $Mobile;
	public $Address;
	public $Suburb;
	public $Postcode;
	public $State;
	public $City;
	public $Password;
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
			,`account`.`id` as Id
			,`account`.`firstname` as Firstname
			,`account`.`lastname` as Lastname
			,`account`.`account_type_id` as AccountTypeId
			,`account`.`company_id` as CompanyId
			,`account`.`email` as Email
			,`account`.`phone` as Phone
			,`account`.`mobile` as Mobile
			,`account`.`address` as Address
			,`account`.`suburb` as Suburb
			,`account`.`postcode` as Postcode
			,`account`.`state` as State
			,`account`.`city` as City
			,`account`.`password` as Password
			,`account`.`created_date` as CreatedDate
			,`account`.`updated_date` as UpdatedDate
			,`account`.`status` as Status
		from `account`";

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
		$sql = "select count(1) as counter from `account`";

		// the criteria can be used or you can write your own custom logic.
		// be sure to escape any user input with $criteria->Escape()
		$sql .= $criteria->GetWhere();

		return $sql;
	}
}

?>