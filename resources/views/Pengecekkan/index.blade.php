@extends('layouts.main')
@section('title', 'Customer')

@section('data')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Data Pengecekkan</h4>
                <a href="{{ route('pengecekkan.create.index') }}" class="btn btn-rounded btn-primary">Tambah Data</a>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="data-tabel">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            tabel();
        });

        function tabel() {
            $.get("{{ route('pengecekkan.gettabel') }}", {}, function(data, status) {
                $('#data-tabel').html(data);
            });
        }
    </script>
@endsection
