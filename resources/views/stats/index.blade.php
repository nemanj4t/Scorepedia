@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row">
            @foreach ($stats as $key => $stat)
                <div class="col-md-4">
                    <table class="table" style="border-top-style:hidden">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <h4>
                                        <a href="/statistics?show=full"> {{ ucfirst($key) }} </a>
                                    </h4>
                                </th>
                                <th scope="col">
                                    <h4>
                                        <a href="/statistics?show=full"> <i class="fas fa-long-arrow-alt-right fa 9x"></i> </a>
                                    </h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($stat as $i => $player)
                            <tr style="font-weight: bold; border-bottom-style: hidden">
                                <th scope="row">
                                    <h5 style="font-weight: bold">
                                        <a href="/players/{{ $player['id'] }}" class="link">
                                            {{ $i + 1 }}. {{ $player['name'] }}
                                        </a>
                                    </h5>
                                </th>
                                @if ($i == 0)
                                    <td style="font-size:24px">{{ $player['score'] }}</td>
                                @else
                                    <td style="font-size:18px">{{ $player['score'] }}</td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    </div>
@endsection
