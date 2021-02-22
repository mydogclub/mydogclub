<div class="pollShowResult">
	<div class="mb-2">
		<h2 class="block-title ">у вас уже есть<br> собака?</h2>
		@php $percent = round($poll['yes1']*(100/$poll['count']))@endphp		
		<div class="progress">
		  <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">да {{ $percent }}%</div>  
		</div>
		@php $percent = round($poll['no1']*(100/$poll['count']))@endphp
		<div class="progress mt-1">
		  <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">нет {{ $percent }}%</div>  
		</div>
	</div>
	<div class="mb-2">
		<h2 class="block-title ">вы собираетесь<br>завести собаку?</h2>
		@php $percent = round($poll['yes2']*(100/$poll['count']))@endphp		
		<div class="progress">
		  <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">да {{ $percent }}%</div>  
		</div>
		@php $percent = round($poll['no2']*(100/$poll['count']))@endphp
		<div class="progress mt-1">
		  <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">нет {{ $percent }}%</div>  
		</div>
	</div>
	<div class="mb-2">
		<h2 class="block-title ">вы опытный<br>собаковод?</h2>
		@php $percent = round($poll['yes3']*(100/$poll['count']))@endphp		
		<div class="progress">
		  <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">да {{ $percent }}%</div>  
		</div>
		@php $percent = round($poll['no3']*(100/$poll['count']))@endphp
		<div class="progress mt-1">
		  <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">нет {{ $percent }}%</div>  
		</div>
	</div>
	<div class="mb-2">
		<h2 class="block-title ">вам был полезен<br>наш сайт?</h2>
		@php $percent = round($poll['yes4']*(100/$poll['count']))@endphp		
		<div class="progress">
		  <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">да {{ $percent }}%</div>  
		</div>
		@php $percent = round($poll['no4']*(100/$poll['count']))@endphp
		<div class="progress mt-1">
		  <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">нет {{ $percent }}%</div>  
		</div>
	</div>
</div>