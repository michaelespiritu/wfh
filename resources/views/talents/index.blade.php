@extends('layouts.admin')

@section('style')
<style>
			.card-header{
				background-image: url('http://www.latestseotutorial.com/wp-content/uploads/2016/12/love-dp-for-facebook.jpg') !important;
				padding: 0 !important;
				background-position: center;
				background-repeat: no-repeat;
				background-size: cover;
				height: 150px;
				position: relative;
				display: flex;
				justify-content: center;
				text-align:center;
			}
			.card{
				overflow: hidden;
				border:0 !important;
				width: 300px;
				box-shadow: 0px 0px 15px 1px;
				-webkit-box-shadow:0px 0px 15px 1px;
			}
			.profile_pic{
				position: absolute;
				bottom: -50px;
				height: 112px;
				width: 112px;
				padding: 5px;
				border: 2px solid #f39c12;
				border-radius: 50%;
			}
			.card-body{
				padding-top: 55px !important;
			}
            
			.profile_pic img{
				height: 100px;
				width: 100px;
			}

			.info_container{
				padding-top: 20px;
				display: flex;
				justify-content: space-around;
				flex-direction: row;
			}

			
			.card-footer{
				padding: 0 !important;
				background: #fff !important;
				display: flex;
				border-top: 0 !important;
			}

			.message{
				display: flex;
				justify-content: center;
				padding: 10px;
				width: 50%;
				text-transform: uppercase;
				background: #f39c12;
				color: #fff;
				cursor: pointer;
				border-bottom-right-radius: calc(0.25rem - 1px);
			}

			.view_profile{
				display: flex;
				justify-content: center;
				padding: 10px;
				width: 50%;
				text-transform: uppercase;
				background: #e74c3c;
				color: #fff;
				cursor: pointer;
				border-bottom-left-radius: calc(0.25rem - 1px);
				
			}
</style>
@endsection

@section('content')
<div class="container-fluid row">

@foreach($talents as $talent)

<div class="col-md-3 col lg-4">
    @component('talents.talent-card', ['talent' => $talent])
    @endcomponent
</div>

@endforeach

</div>
@endsection

