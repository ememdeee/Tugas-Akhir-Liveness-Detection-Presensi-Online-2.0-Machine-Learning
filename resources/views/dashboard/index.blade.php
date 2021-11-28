@extends('layouts.main')

@section('container')

<div class="badge bg-primary text-wrap mb-3" style="width: 9rem;">
    {{ $date }}
</div>

<form action="/dashboard" method="post">
    @csrf
<table class="table table-striped">
    <tr>
        <td><b>No</b></td>
        <td><b>Nama</b></td>
        <td><b>Email</b></td>
        <td><b>Waktu Datang</b></td>
        <td><b>Waktu Istirahat</b></td>
        <td><b>Waktu Setelah Istirahat</b></td>
        <td><b>Waktu Pulang</b></td>
        <td><b>Lama di Kantor</b></td>
    </tr>
    @foreach($users as $i => $user)
    <?php
        $presensi = App\Presensi::whereDate('waktu_datang', $date)
            ->where('user_id',$user->id)
            ->first();
    ?>
    <tr>
        <td>
            {{$i+1}}
        </td>

        <td>
            {{$user->name}}
        </td>

        <td>
            {{$user->email}}
        </td>

        @if ($presensi !== null)
            <td class="text-success">{{ $presensi->waktu_datang->format('d F Y; H:m:s') }}</td>
        @else
            <td class="text-danger">Belum Absen</td>
        @endif

        @if ($presensi !== null)
            <td class="text-success">{{ $presensi->waktu_istirahat->format('d F Y; H:m:s') }}</td>
        @else
            <td class="text-danger">Belum Istirahat</td>
        @endif

        @if ($presensi !== null)
            <td class="text-success">{{ $presensi->waktu_setelah_istirahat->format('d F Y; H:m:s') }}</td>
        @else
            <td class="text-danger">Belum balik Istirahat</td>
        @endif

        @if ($presensi !== null)
            <td class="text-success">{{ $presensi->waktu_pulang->format('d F Y; H:m:s') }}</td>
        @else
            <td class="text-danger">Belum Pulang</td>
        @endif
        
        @if ($presensi !== null && $presensi->waktu_pulang !== null)
            <?php 
                $datangTimestamp = $presensi->waktu_datang->timestamp;
                $pulangTimestamp = $presensi->waktu_pulang->timestamp;
                $istirahatTimestamp = $presensi->waktu_istirahat->timestamp;
                $setelahistirahatTimestamp = $presensi->waktu_setelah_istirahat->timestamp;
                $diff = ($pulangTimestamp - $datangTimestamp)-($setelahistirahatTimestamp-$istirahatTimestamp);
            ?>
            <td class="text-success">{{ floor($diff/3600) }} jam, {{floor(fmod($diff,3600)/60)}} menit, {{fmod($diff,60)}} detik</td>
            <!-- <td class="text-success">{{ $presensi->waktu_pulang->diffForHumans($presensi->waktu_datang) }}</td> -->
        @else
            <td class="text-danger">Belum Pulang</td>
        @endif
    </tr>
    @endforeach
</table>
<div class="my-4">
    <label for="tanggal">Tanggal:</label>
    <input type="date" id="tanggal" name="tanggal">
    <input type="submit">
</div>
</form>
<!-- 
<h1>hallo</h1> -->



@endsection