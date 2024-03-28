@extends('layouts.app')
@section('title', 'Team List')
@section('links')
    <style>
        .about {
            background-image: url(../storage/frontend/assets/dist/images/background.png);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }

        .main-team-listing {
            padding: 50px 0px;
        }

        .table {
            --bs-table-bg: transparent;
            margin-bottom: 0;
            padding: 20px;
            border-spacing: 0;
            border: 3px solid #ffffff;
            border-radius: 49px 49px 49px 49px;
            -moz-border-radius: 49px 49px 49px 49px;
            -webkit-border-radius: 49px 49px 49px 49px;
            box-shadow: 0 1px 1px #CCCCCC;
            border-collapse: separate !important;
            margin: 10px;
        }

        .table a{
            color: white !important;
        }

        th,
        td {
            color: white !important;
        }

        table th:first-child {
            -moz-border-radius: 6px 0 0 0;
        }

        table th {
            border-bottom: 1px solid #fff;
        }
    </style>
@endsection
@section('content')
    <section class="breadcrumbs" style="background-image: url({{ asset('storage/frontend/assets/dist/images/about-header.jpg') }})">
        <div class="page-title">
             <h2>TEAM LIST</h2>
        </div>
    </section>
    <main>
        <section class="about">
            <div class="container main-team-listing">
                <div class="row align-items-center team-list">
                    <div class="table-responsive-sm">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col"></th>
                                <th scope="col">Team</th>
                                <th scope="col">P</th>
                                <th scope="col">W</th>
                                <th scope="col">L</th>
                                <th scope="col">D</th>
                                <th scope="col">NRR</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($teams) > 0)
                                @foreach ($teams as $team)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td style="min-width: 60px; width: 100px;"><img src="{{ $team->image }}" alt="" style="width: 100%"><span
                                                style="margin-left: 10px;"></span></td>
                                        <td><a href="{{route('team.teamDetails', ['id' => $team->id])}}">{{ $team->team_name }}</a></td>
                                        <td>0.0</td>
                                        <td>0.0</td>
                                        <td>0.0</td>
                                        <td>0.0</td>
                                        <td>0.00</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <th colspan="7" class="text-center">Teams Not Found !!</th>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
