<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\ServiceRequest;

use App\Models\PetApplication;

use App\Models\MaintenanceAbsentiaRequest;

use App\Models\GuestAccessRequest;

use App\Models\AccessKeyRequest;

use App\Models\VehicleRequest;

use App\Models\HousekeeperRequest;


use PDF;

class PdfGeneratorController extends Controller
{

	public function pdfServiceView($id){
		
		$service=ServiceRequest::where('id',$id)->first();
		
		$pdf = PDF::loadView('admin.pdf.service', compact('service'));
		
        return $pdf->download($service->form_id.''.'.pdf');
	}

	public function pdfPetView($id){
		
		$pet=PetApplication::where('id',$id)->first();
		
		$pdf = PDF::loadView('admin.pdf.pet', compact('pet'));
		
        return $pdf->download($pet->id.''.'.pdf');
	}

	public function maintenanceAbsentia($id){
		
		$maintenance=MaintenanceAbsentiaRequest::where('id',$id)->first();
		
		$pdf = PDF::loadView('admin.pdf.maintenance_absentia', compact('maintenance'));
		
        return $pdf->download($maintenance->form_id.''.'.pdf');
	}

	public function guestAccess($id){
		
		$guest=GuestAccessRequest::where('id',$id)->first();
		
		$pdf = PDF::loadView('admin.pdf.guest_access', compact('guest'));
		
        return $pdf->download($guest->form_id.''.'.pdf');
	}

	public function accessKey($id){
		
		$access=AccessKeyRequest::where('id',$id)->first();
		
		$pdf = PDF::loadView('admin.pdf.access_key', compact('access'));
		
        return $pdf->download($access->form_id.''.'.pdf');
	}

	public function vehicle($id){
		
		$vehicle=VehicleRequest::where('id',$id)->first();
		
		$pdf = PDF::loadView('admin.pdf.vehicle', compact('vehicle'));
		
        return $pdf->download($vehicle->form_id.''.'.pdf');
	}

	public function housekeeper($id){
		
		$housekeeper=HousekeeperRequest::where('id',$id)->first();
		
		$pdf = PDF::loadView('admin.pdf.housekeeper', compact('housekeeper'));
		
        return $pdf->download($housekeeper->form_id.''.'.pdf');
	}
}