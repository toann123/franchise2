<?php
/** @package    Franchise::Reporter */

/** import supporting libraries */
require_once("verysimple/Phreeze/Reporter.php");

/**
 * This is an example Reporter based on the User object.  The reporter object
 * allows you to run arbitrary queries that return data which may or may not fith within
 * the data access API.  This can include aggregate data or subsets of data.
 *
 * Note that Reporters are read-only and cannot be used for saving data.
 *
 * @package Franchise::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class UserReporter extends Reporter
{

	// the properties in this class must match the columns returned by GetCustomQuery().
	// 'CustomFieldExample' is an example that is not part of the `user` table
	public $CustomFieldExample;
	
	public $RoleName;

	public $Id;
	public $Code;
	public $RoleId;
	public $Username;
	public $Password;
	public $FirstName;
	public $LastName;
	public $AccountTypeId;
	public $CompanyId;
	public $Email;
	public $Phone;
	public $Mobile;
	public $Address;
	public $Surburb;
	public $Postcode;
	public $State;
	public $City;
	public $CreatedDate;
	public $UpdatedDate;
	public $Status;
	
	public $CompanyName;
	public $CompanyCode;
	public $Start;
	public $CompanyStatus;

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
			company.name as CompanyName
			,company.code as CompanyCode
			,company.start as Starr
			,company.status as CompanyStatus
			,`user`.`a_id` as Id
			,`user`.`code` as Code
			,`user`.`a_role_id` as RoleId
			,`user`.`a_username` as Username
			,`user`.`a_password` as Password
			,`user`.`a_first_name` as FirstName
			,`user`.`a_last_name` as LastName
			,`user`.`account_type_id` as AccountTypeId
			,`user`.`company_id` as CompanyId
			,`user`.`email` as Email
			,`user`.`phone` as Phone
			,`user`.`mobile` as Mobile
			,`user`.`address` as Address
			,`user`.`surburb` as Surburb
			,`user`.`postcode` as Postcode
			,`user`.`state` as State
			,`user`.`city` as City
			,`user`.`created_date` as CreatedDate
			,`user`.`updated_date` as UpdatedDate
			,`user`.`status` as Status
		from `user`
		inner join company on user.company_id = company.id";

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
		$sql = "select count(1) as counter from `user` inner join role on r_id = a_role_id";

		// the criteria can be used or you can write your own custom logic.
		// be sure to escape any user input with $criteria->Escape()
		$sql .= $criteria->GetWhere();

		return $sql;
	}
}

?>