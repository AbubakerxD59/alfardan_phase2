@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Non Tenants')

@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position">

	<h2 class="table-cap pb-2 mb-3">Non-Tenant users</h2>
	<div class=" table-responsive tenant-table">
		<table class="table  table-bordered">
			<thead>
				<tr>
					<th scope="col"><span>User Name</span></th>
					<th scope="col"><span>Email</span></th>
					<th scope="col"><span>Password</span></th>
					<th scope="col"><span>Phone Number</span></th>
					
					

					<th colspan="2"></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><a href="#">User 1</a></td>
					<td>fsdfa@gmail.com</td>
					<td>******</td>
					<td>00996123456</td>
					<td class="btn-bg1"><a href="#">EDIT</a> </td>
					<td class="btn-bg2"><a  type="button" class="table-delete fw-bold">REMOVE</a></td>
				</tr>
				<tr>
					<td><a href="#">User 1</a></td>
					<td>fsdfa@gmail.com</td>
					<td>******</td>
					<td>00996123456</td>
					<td class="btn-bg1"><a type="button" href="#">EDIT</a> </td>
					<td class="btn-bg2"><a  type="button" class="table-delete fw-bold">REMOVE</a></td>
				</tr>
				<tr>
					<td><a href="#">User 1</a></td>
					<td>fsdfa@gmail.com</td>
					<td>******</td>
					<td>00996123456</td>
					<td class="btn-bg1"><a type="button" chref="#">EDIT</a> </td>
					<td class="btn-bg2"><a  type="button" class="table-delete fw-bold">REMOVE</a></td>
				</tr>
				<tr>
					<td><a href="#">User 1</a></td>
					<td>fsdfa@gmail.com</td>
					<td>******</td>
					<td>00996123456</td>
					<td class="btn-bg1"><a type="button" href="#">EDIT</a> </td>
					<td class="btn-bg2"><a  type="button" class="table-delete fw-bold">REMOVE</a></td>
				</tr>
			</tbody>
		</table>
	</div>
	
</main>
@endsection
        