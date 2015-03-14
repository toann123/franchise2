<?php
/** @package Franchise::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/Phreezable.php");
require_once("SupportMap.php");

/**
 * SupportDAO provides object-oriented access to the support table.  This
 * class is automatically generated by ClassBuilder.
 *
 * WARNING: THIS IS AN AUTO-GENERATED FILE
 *
 * This file should generally not be edited by hand except in special circumstances.
 * Add any custom business logic to the Model class which is extended from this DAO class.
 * Leaving this file alone will allow easy re-generation of all DAOs in the event of schema changes
 *
 * @package Franchise::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class SupportDAO extends Phreezable
{
	/** @var int */
	public $Id;

	/** @var string */
	public $Position;

	/** @var string */
	public $Firstname;

	/** @var string */
	public $Lastname;

	/** @var string */
	public $Phone;

	/** @var string */
	public $Mobile;

	/** @var string */
	public $Email;

	/** @var string */
	public $Address;

	/** @var string */
	public $Postcode;

	/** @var string */
	public $State;

	/** @var string */
	public $City;

	/** @var int */
	public $CompanyId;

	/** @var timestamp */
	public $CreatedDate;

	/** @var timestamp */
	public $UpdatedDate;

	/** @var int */
	public $Status;



}
?>