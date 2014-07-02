@extends('layouts.master')
@section('content')
<div class="container">
	<div class="row character-sheet">
		<div class="col-sm-10 col-sm-offset-1">
			<div class="row">
				<div class="col-sm-6 portrait-container">
					<img class="character-portrait" src="{{ $character->Media('Portrait') }}" alt="{{ $character->Name() }}" />
				</div>
				<div class="col-sm-6">
					<ul class="class-description">
						<li><h3>{{ $character->Name() }}</h3></li>
						<li><img class="class-icon" src="{{ $character->ActiveClass()->JobIcon() }}" alt="{{ $character->ActiveClass()->Job() }}"/>Lvl {{ $character->ActiveClass()->Level() }} {{ $character->ActiveClass()->Job() }}</li>
						<li>Race: {{ $character->Race() }}</li>
						<li>Item Level: {{ $character->ItemLevel() }}</li>
						<li>FC: {{ $character->FreeCompany()->Name() }}</li>
					</ul>
					<h4>Stats</h4>
					<div class="row">
						@foreach ($character->Stats('core') as $name => $stat)
							<div class="col-sm-4">
								{{{ strtoupper($name) }}} - {{ $stat }}
							</div>
						@endforeach
					</div>
					<div class="row">
						@foreach ($character->Stats('attributes') as $name => $stat)
						<div class="col-sm-4">
							{{{ mapTerm($name) }}} - {{ $stat }}
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="col-sm-12">
					<h3>Gear</h3>
					<div class="row">
						@foreach ($character->ActiveClass()->Gear() as $item)
						<div class="col-sm-6">
							<img class="class-icon" src="{{ $item['icon'] }}" alt="{{ $item['name'] }}" />
							iLvl {{ $item['ilevel'] }} - {{ $item['name'] }}
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="col-sm-12">
					<h3>Classes</h3>
					<div class="row">
						@foreach ($character->AltClasses() as $class)
						<div class="col-sm-4">
							<img class="class-icon" src="{{ $class->icon() }}" alt="{{ $class->name() }}" />
							Lvl {{ $class->level() }} {{ $class->name() }}
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="col-sm-12">
					<h3>Minions</h3>
					<div class="row">
						@foreach ($character->Minions() as $minion)
						<div class="col-sm-4">
							<img class="class-icon" src="{{ $minion['icon'] }}" alt="{{ $minion['name'] }}" />
							{{{ ucwords($minion['name']) }}}
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="col-sm-12">
					<h3>Mounts</h3>
					<div class="row">
						@foreach ($character->Mounts() as $mount)
						<div class="col-sm-4">
							<img class="class-icon" src="{{ $mount['icon'] }}" alt="{{ $mount['name'] }}" />
							{{{ ucwords($mount['name']) }}}
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop