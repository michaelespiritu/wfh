<div class="container h-100">
	<div class="row h-100 justify-content-center align-items-center">
		<div class="card">
			<div class="card-header">
				<div class="profile_pic">
				<img src="{{ $talent->profile_image }}">
				</div>
			</div>
			<div class="card-body">
				<div class="d-lfex justify-content-center flex-column text-center">
					<div class="name_container">
						<div class="name">{{ $talent->name }}</div>
					</div>
					<div class="address">
						<small>
							{{ $talent->title }}
						</small>
					</div>
				</div>
				
			</div>
			<div class="card-footer">
				<div class="view_profile">
					<p class="mb-0" data-toggle="modal" data-target="#talent-{{$talent->identifier}}">
						<small>
							View profile
						</small>
					</p>	
				</div>
				<div class="message">
					<p class="mb-0">
						<small>
							Message
						</small>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>


<div 
	class="modal fade" 
	id="talent-{{$talent->identifier}}"
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="talent-{{$talent->identifier}}-Label" 
	aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content rounded-0">
			<div class="modal-header align-items-center">
				<div>
					<h5 
						class="modal-title mb-0" 
						id="talent-{{$talent->identifier}}-Label">
						{{ $talent->name }}
					</h5>
					<p class="mb-0"><small>{{ $talent->title }}</small></p>
					<div class="text-center text-lg-left">
						{!! $talent->convertSkillsToHtml() !!}
					</div>
				</div>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
				
			</div>

			<div class="modal-body">
				

				<div itemprop="description" class="text-left mb-3">

					{!! $talent->coverLetter() !!}

				</div>

				
			</div>

		</div>

	</div>
</div>