<?php
/** @package    FRANCHISE::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
require_once("Model/Lead.php");

/**
 * LeadController is the controller class for the Lead object.  The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package FRANCHISE::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class LeadController extends AppBaseController
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
	 * Displays a list view of Lead objects
	 */
	public function ListView()
	{
		$this->Render();
	}

	/**
	 * API Method queries for Lead records and render as JSON
	 */
	public function Query()
	{
		try
		{
			$criteria = new LeadCriteria();
			
			// TODO: this will limit results based on all properties included in the filter list 
			$filter = RequestUtil::Get('filter');
			if ($filter) $criteria->AddFilter(
				new CriteriaFilter('Id,Status,StateId,CustomerId,AccountId,AccountTypeId,CreatedDate,UpdatedDate,ServiceId'
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

				$leads = $this->Phreezer->Query('Lead',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $leads->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $leads->TotalResults;
				$output->totalPages = $leads->TotalPages;
				$output->pageSize = $leads->PageSize;
				$output->currentPage = $leads->CurrentPage;
			}
			else
			{
				// return all results
				$leads = $this->Phreezer->Query('Lead',$criteria);
				$output->rows = $leads->ToObjectArray(true, $this->SimpleObjectParams());
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
	 * API Method retrieves a single Lead record and render as JSON
	 */
	public function Read()
	{
		try
		{
			$pk = $this->GetRouter()->GetUrlParam('id');
			$lead = $this->Phreezer->Get('Lead',$pk);
			$this->RenderJSON($lead, $this->JSONPCallback(), true, $this->SimpleObjectParams());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method inserts a new Lead record and render response as JSON
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

			$lead = new Lead($this->Phreezer);

			// TODO: any fields that should not be inserted by the user should be commented out

			// this is an auto-increment.  uncomment if updating is allowed
			// $lead->Id = $this->SafeGetVal($json, 'id');

			$lead->Status = $this->SafeGetVal($json, 'status');
			$lead->StateId = $this->SafeGetVal($json, 'stateId');
			$lead->CustomerId = $this->SafeGetVal($json, 'customerId');
			$lead->AccountId = $this->SafeGetVal($json, 'accountId');
			$lead->AccountTypeId = $this->SafeGetVal($json, 'accountTypeId');
			$lead->CreatedDate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'createdDate')));
			$lead->UpdatedDate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'updatedDate')));
			$lead->ServiceId = $this->SafeGetVal($json, 'serviceId');

			$lead->Validate();
			$errors = $lead->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$lead->Save();
				$this->RenderJSON($lead, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method updates an existing Lead record and render response as JSON
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
			$lead = $this->Phreezer->Get('Lead',$pk);

			// TODO: any fields that should not be updated by the user should be commented out

			// this is a primary key.  uncomment if updating is allowed
			// $lead->Id = $this->SafeGetVal($json, 'id', $lead->Id);

			$lead->Status = $this->SafeGetVal($json, 'status', $lead->Status);
			$lead->StateId = $this->SafeGetVal($json, 'stateId', $lead->StateId);
			$lead->CustomerId = $this->SafeGetVal($json, 'customerId', $lead->CustomerId);
			$lead->AccountId = $this->SafeGetVal($json, 'accountId', $lead->AccountId);
			$lead->AccountTypeId = $this->SafeGetVal($json, 'accountTypeId', $lead->AccountTypeId);
			$lead->CreatedDate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'createdDate', $lead->CreatedDate)));
			$lead->UpdatedDate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'updatedDate', $lead->UpdatedDate)));
			$lead->ServiceId = $this->SafeGetVal($json, 'serviceId', $lead->ServiceId);

			$lead->Validate();
			$errors = $lead->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$lead->Save();
				$this->RenderJSON($lead, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}


		}
		catch (Exception $ex)
		{


			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method deletes an existing Lead record and render response as JSON
	 */
	public function Delete()
	{
		try
		{
						
			// TODO: if a soft delete is prefered, change this to update the deleted flag instead of hard-deleting

			$pk = $this->GetRouter()->GetUrlParam('id');
			$lead = $this->Phreezer->Get('Lead',$pk);

			$lead->Delete();

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
