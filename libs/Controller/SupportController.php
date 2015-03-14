<?php
/** @package    FRANCHISE::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
require_once("Model/Support.php");

/**
 * SupportController is the controller class for the Support object.  The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package FRANCHISE::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class SupportController extends AppBaseController
{

	/**
	 * Override here for any controller-specific functionality
	 *
	 * @inheritdocs
	 */
	protected function Init()
	{
		parent::Init();

		// TODO: add controller-wide bootstrap code
		
		// TODO: if authentiation is required for this entire controller, for example:
		// $this->RequirePermission(ExampleUser::$PERMISSION_USER,'SecureExample.LoginForm');
	}

	/**
	 * Displays a list view of Support objects
	 */
	public function ListView()
	{
		$this->Render();
	}

	/**
	 * API Method queries for Support records and render as JSON
	 */
	public function Query()
	{
		try
		{
			$criteria = new SupportCriteria();
			
			// TODO: this will limit results based on all properties included in the filter list 
			$filter = RequestUtil::Get('filter');
			if ($filter) $criteria->AddFilter(
				new CriteriaFilter('Id,Position,Firstname,Lastname,Phone,Mobile,Email,Address,Postcode,State,City,CompanyId,CreatedDate,UpdatedDate,Status'
				, '%'.$filter.'%')
			);

			// TODO: this is generic query filtering based only on criteria properties
			foreach (array_keys($_REQUEST) as $prop)
			{
				$prop_normal = ucfirst($prop);
				$prop_equals = $prop_normal.'_Equals';

				if (property_exists($criteria, $prop_normal))
				{
					$criteria->$prop_normal = RequestUtil::Get($prop);
				}
				elseif (property_exists($criteria, $prop_equals))
				{
					// this is a convenience so that the _Equals suffix is not needed
					$criteria->$prop_equals = RequestUtil::Get($prop);
				}
			}

			$output = new stdClass();

			// if a sort order was specified then specify in the criteria
 			$output->orderBy = RequestUtil::Get('orderBy');
 			$output->orderDesc = RequestUtil::Get('orderDesc') != '';
 			if ($output->orderBy) $criteria->SetOrder($output->orderBy, $output->orderDesc);

			$page = RequestUtil::Get('page');

			if ($page != '')
			{
				// if page is specified, use this instead (at the expense of one extra count query)
				$pagesize = $this->GetDefaultPageSize();

				$supports = $this->Phreezer->Query('Support',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $supports->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $supports->TotalResults;
				$output->totalPages = $supports->TotalPages;
				$output->pageSize = $supports->PageSize;
				$output->currentPage = $supports->CurrentPage;
			}
			else
			{
				// return all results
				$supports = $this->Phreezer->Query('Support',$criteria);
				$output->rows = $supports->ToObjectArray(true, $this->SimpleObjectParams());
				$output->totalResults = count($output->rows);
				$output->totalPages = 1;
				$output->pageSize = $output->totalResults;
				$output->currentPage = 1;
			}


			$this->RenderJSON($output, $this->JSONPCallback());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method retrieves a single Support record and render as JSON
	 */
	public function Read()
	{
		try
		{
			$pk = $this->GetRouter()->GetUrlParam('id');
			$support = $this->Phreezer->Get('Support',$pk);
			$this->RenderJSON($support, $this->JSONPCallback(), true, $this->SimpleObjectParams());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method inserts a new Support record and render response as JSON
	 */
	public function Create()
	{
		try
		{
						
			$json = json_decode(RequestUtil::GetBody());

			if (!$json)
			{
				throw new Exception('The request body does not contain valid JSON');
			}

			$support = new Support($this->Phreezer);

			// TODO: any fields that should not be inserted by the user should be commented out

			// this is an auto-increment.  uncomment if updating is allowed
			// $support->Id = $this->SafeGetVal($json, 'id');

			$support->Position = $this->SafeGetVal($json, 'position');
			$support->Firstname = $this->SafeGetVal($json, 'firstname');
			$support->Lastname = $this->SafeGetVal($json, 'lastname');
			$support->Phone = $this->SafeGetVal($json, 'phone');
			$support->Mobile = $this->SafeGetVal($json, 'mobile');
			$support->Email = $this->SafeGetVal($json, 'email');
			$support->Address = $this->SafeGetVal($json, 'address');
			$support->Postcode = $this->SafeGetVal($json, 'postcode');
			$support->State = $this->SafeGetVal($json, 'state');
			$support->City = $this->SafeGetVal($json, 'city');
			$support->CompanyId = $this->SafeGetVal($json, 'companyId');
			$support->CreatedDate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'createdDate')));
			$support->UpdatedDate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'updatedDate')));
			$support->Status = $this->SafeGetVal($json, 'status');

			$support->Validate();
			$errors = $support->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$support->Save();
				$this->RenderJSON($support, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method updates an existing Support record and render response as JSON
	 */
	public function Update()
	{
		try
		{
						
			$json = json_decode(RequestUtil::GetBody());

			if (!$json)
			{
				throw new Exception('The request body does not contain valid JSON');
			}

			$pk = $this->GetRouter()->GetUrlParam('id');
			$support = $this->Phreezer->Get('Support',$pk);

			// TODO: any fields that should not be updated by the user should be commented out

			// this is a primary key.  uncomment if updating is allowed
			// $support->Id = $this->SafeGetVal($json, 'id', $support->Id);

			$support->Position = $this->SafeGetVal($json, 'position', $support->Position);
			$support->Firstname = $this->SafeGetVal($json, 'firstname', $support->Firstname);
			$support->Lastname = $this->SafeGetVal($json, 'lastname', $support->Lastname);
			$support->Phone = $this->SafeGetVal($json, 'phone', $support->Phone);
			$support->Mobile = $this->SafeGetVal($json, 'mobile', $support->Mobile);
			$support->Email = $this->SafeGetVal($json, 'email', $support->Email);
			$support->Address = $this->SafeGetVal($json, 'address', $support->Address);
			$support->Postcode = $this->SafeGetVal($json, 'postcode', $support->Postcode);
			$support->State = $this->SafeGetVal($json, 'state', $support->State);
			$support->City = $this->SafeGetVal($json, 'city', $support->City);
			$support->CompanyId = $this->SafeGetVal($json, 'companyId', $support->CompanyId);
			$support->CreatedDate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'createdDate', $support->CreatedDate)));
			$support->UpdatedDate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'updatedDate', $support->UpdatedDate)));
			$support->Status = $this->SafeGetVal($json, 'status', $support->Status);

			$support->Validate();
			$errors = $support->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$support->Save();
				$this->RenderJSON($support, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}


		}
		catch (Exception $ex)
		{


			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method deletes an existing Support record and render response as JSON
	 */
	public function Delete()
	{
		try
		{
						
			// TODO: if a soft delete is prefered, change this to update the deleted flag instead of hard-deleting

			$pk = $this->GetRouter()->GetUrlParam('id');
			$support = $this->Phreezer->Get('Support',$pk);

			$support->Delete();

			$output = new stdClass();

			$this->RenderJSON($output, $this->JSONPCallback());

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}
}

?>
