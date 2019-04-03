@extends('layouts.app')

@section('title')
<h1>KURIR JNE</h1>
@stop

@section('content')
<div class="card">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
      {{ $title }}
    </h1>
  </section>
  
  <!-- Main content -->
  <section class="content">
    <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                <h4 class="box-title">Dari : <b>{{ $origin }}</h4>
                <h4 class="box-title">Ke : <b>{{ $destination }}</b></h4>
              </div>
              <div class="box-body">
                <table class="table table-striped">
                  <thead>
                  <tr>
                    <th>Nama Layanan</th>
                    <th>Tarif</th>
                    <th>ETD (Estimates Days)</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php for($i=0; $i<count($array_result["rajaongkir"]["results"][0]["costs"]); $i++){ ?>
                      <tr>
                        <td><?php echo $array_result["rajaongkir"]["results"][0]["costs"][$i]["service"] ?> </td>
                        <td><?php echo $array_result["rajaongkir"]["results"][0]["costs"][$i]["cost"][0]["value"] ?></td>
                        <td><?php echo $array_result["rajaongkir"]["results"][0]["costs"][$i]["cost"][0]["etd"] ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                  </tfoot>
                </table>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
@stop
