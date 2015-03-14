<?php
/** @package    FRANCHISE::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
require_once("Model/Schedule.php");

/**
 * ScheduleController is the controller class for the Schedule object.  The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package FRANCHISE::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class ScheduleController extends AppBaseController
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
	 * Displays a list view of Schedule objects
	 */
	public function ListView()
	{
		$this->Render();
	}

	/**
	 * API Method queries for Schedule records and render as JSON
	 */
	public function Query()
	{
		try
		{
			$criteria = new ScheduleCriteria();
			
			// TODO: this will limit results based on all properties included in the filter list 
			$filter = RequestUtil::Get('filter');
			if ($filter) $criteria->AddFilter(
				new CriteriaFilter('Id,WorkId,AccountId,Startdate,Enddate,Maximum,CreatedDate,UpdatedDate,Status'
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

				$schedules = $this->Phreezer->Query('Schedule',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $schedules->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $schedules->TotalResults;
				$output->totalPages = $schedules->TotalPages;
				$output->pageSize = $schedules->PageSize;
				$output->currentPage = $schedules->CurrentPage;
			}
			else
			{
				// return all results
				$schedules = $this->Phreezer->Query('Schedule',$criteria);
				$output->rows = $schedules->ToObjectArray(true, $this->SimpleObjectParams());
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
	 * API Method retrieves a single Schedule record and render as JSON
	 */
	public function Read()
	{
		try
		{
			$pk = $this->GetRouter()->GetUrlParam('id');
			$schedule = $this->Phreezer->Get('Schedule',$pk);
			$this->RenderJSON($schedule, $this->JSONPCallback(), true, $this->SimpleObjectParams());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method inserts a new Schedule record and render response as JSON
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

			$schedule = new Schedule($this->Phreezer);

			// TODO: any fields that should not be inserted by the user should be commented out

			// this is an auto-increment.  uncomment if updating is allowed
			// $schedule->Id = $this->SafeGetVal($json, 'id');

			$schedule->WorkId = $this->SafeGetVal($json, 'workId');
			$schedule->AccountId = $this->SafeGetVal($json, 'accountId');
			$schedule->Startdate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'startdate')));
			$schedule->Enddate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'enddate')));
			$schedule->Maximum = $this->SafeGetVal($json, 'maximum');
			$schedule->CreatedDate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'createdDate')));
			$schedule->UpdatedDate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'updatedDate')));
			$schedule->Status = $this->SafeGetVal($json, 'status');

			$schedule->Validate();
			$errors = $schedule->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$schedule->Save();
				$this->RenderJSON($schedule, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method updates an existing Schedule record and render response as JSON
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
			$schedule = $this->Phreezer->Get('Schedule',$pk);

			// TODO: any fields that should not be updated by the user should be commented out

			// this is a primary key.  uncomment if updating is allowed
			// $schedule->Id = $this->SafeGetVal($json, 'id', $schedule->Id);

			$schedule->WorkId = $this->SafeGetVal($json, 'workId', $schedule->WorkId);
			$schedule->AccountId = $this->SafeGetVal($json, 'accountId', $schedule->AccountId);
			$schedule->Startdate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'startdate', $schedule->Startdate)));
			$schedule->Enddate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'enddate', $schedule->Enddate)));
			$schedule->Maximum = $this->SafeGetVal($json, 'maximum', $schedule->Maximum);
			$schedule->CreatedDate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'createdDate', $schedule->CreatedDate)));
			$schedule->UpdatedDate = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'updatedDate', $schedule->UpdatedDate)));
			$schedule->Status = $this->SafeGetVal($json, 'status', $schedule->Status);

			$schedule->Validate();
			$errors = $schedule->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$schedule->Save();
				$this->RenderJSON($schedule, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}


		}
		catch (Exception $ex)
		{


			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method deletes an existing Schedule record and render response as JSON
	 */
	public function Delete()
	{
		try
		{
						
			// TODO: if a soft delete is prefered, change this to update the deleted flag instead of hard-deleting

			$pk = $this->GetRouter()->GetUrlParam('id');
			$schedule = $this->Phreezer->Get('Schedule',$pk);

			$schedule->Delete();

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
