@extends('layouts.default')
@section('title', $project->name)

@section('header')

@stop

@section('titleLink')
	<a href="{{ url('projects') }}" title="Erstellen" class="btn btn-success pull-right"><i class="fa fa-chevron-left"></i>  Zurück</a>
@stop

@section('content')
	<div class="content-box">
		<ul class="nav nav-tabs page-nav" role="tablist">
			<li ><a href="{{ url('/projects') }}" title="" class=""><i class="fa fa-chevron-left"></i> Zurück</a></li>
			<li><a href="{{  url('/projects/detail/'.$project->id) }}" title="" class=""> Projekt</a></li>
			<li><a href="{{ url('/projects/task/'.$project->id) }}" title="Aufgaben" class="">Aufgaben</a></li>
			<li><a href="{{ url('/projects/timeline/'.$project->id) }}" title="Projekt Verlauf anzeigen" class="">Verlauf</a></li>
			<li class="active"><a href="{{ url('/projects/timemanagement/'.$project->id) }}" title="Arbeitsstunden anzeigen" class="">Arbeitsstunden</a></li>
			@if ($project->status <= 1)
				<li><a href="{{  url('/projects/invoice/'.$project->id) }}" title="Rechnungen" class="">Rechnungen</a></li>
			@endif
			@if ($project->status >= 2)
				<li><a href="{{  url('/projects/invoice/'.$project->id) }}" title="Abgerechnet">Abgerechnet</a></li>
			@endif
			<li><a href="{{ url('/projects/edit/'.$project->id) }}" title="Bearbeiten" class="">Bearbeiten</a></li>
		</ul>

		<div class="page project-timemanagement">

      <h2>Übersicht Bereiche</h2>

      <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Bereich</th>
                <th>Stunden</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Gesamt</th>
                <th><?php echo number_format($project->timemanagement()->sum('time'), 2); ?></th>
              </tr>
            </tfoot>
            <tbody>
              <tr>
                <td>Projektmanagement</td>
                <td><?php echo number_format($project->timemanagement()->where('work_group', 'Projektmanagement')->sum('time'),2); ?></td>
              </tr>
              <tr>
                <td>Beratung</td>
                <td><?php echo number_format($project->timemanagement()->where('work_group', 'Beratung')->sum('time'),2); ?></td>
              </tr>
              <tr>
                <td>Text</td>
                <td><?php echo number_format($project->timemanagement()->where('work_group', 'Text')->sum('time'),2); ?></td>
              </tr>
              <tr>
                <td>Print</td>
                <td><?php echo number_format($project->timemanagement()->where('work_group', 'Print')->sum('time'),2); ?></td>
              </tr>
              <tr>
                <td>Online</td>
                <td><?php echo number_format($project->timemanagement()->where('work_group', 'Online')->sum('time'),2); ?></td>
              </tr>
              <tr>
                <td>Produktion</td>
                <td><?php echo number_format($project->timemanagement()->where('work_group', 'Produktion')->sum('time'),2); ?></td>
              </tr>
              <tr>
            </tbody>
          </table>
        </div>
      </div>

      <hr />

      <h2>Stunden sortiert nach Datum</h2>

			<table class="table table-hover">
				<colgroup>
					<col>
					<col>
					<col>
					<col width="1">
				</colgroup>
				<thead>
					<tr>
						<th>Datum</th>
						<th>Mitarbeiter</th>
						<th>Arbeit</th>
						<th>Zeit</th>
					</tr>
				</thead>
				<tbody>
					@foreach($project->timemanagement as $tm)

					<?php $amount += $tm->time; ?>
					<tr>
						<td>{{ date('d.m.Y', strtotime($tm->date)) }}</td>
						<td>{{ $tm->user->firstname }} {{ $tm->user->lastname }}</td>
						<td>{{ $tm->work_group }} / {{ $tm->work_task }} @if ($tm->work_description) / {{ $tm->work_description }} @endif</td>
						<td class="text-right">{{ number_format($tm->time,2) }}</td>
					</tr>
					@endforeach
					<tfoot>
						<tr>
							<th colspan="3">Gesamt</th>
							<th class="text-right">{{ number_format($amount, 2) }}</th>
						</tr>
					</tfoot>
				</tbody>
			</table>

      <hr />

      <h2>Übersicht nach Mitarbeitern</h2>
      <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Bereich</th>
                <th>Stunden</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Gesamt</th>
                <th><?php echo number_format($project->timemanagement()->sum('time'), 2); ?></th>
              </tr>
            </tfoot>
            <tbody>
            @foreach(User::orderBy('lastname','asc')->get() as $user)
              <tr>
                <td>{{$user->firstname}} {{ $user->lastname }}</td>
                <td><?php echo number_format($project->timemanagement()->where('user_id', $user->id)->sum('time'),2); ?></td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>

		</div>
	</div>

@stop
