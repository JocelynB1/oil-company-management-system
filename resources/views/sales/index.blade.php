@extends('layouts.app')
@section('content')
<?php
$u=route("getProductSalesPerType","");
$a=<<<JS
<script>
  new Vue({
  el: '.box-box',
 
 
  methods: {
    startPie: function(canvas, type){
 
      // init chart.js
      let chart = new Chart(canvas, {  mounted() {
         let uri = '{$u}';
         let ProductType = new Array();
         let UnitPrice = new Array();
         this.axios.get(uri).then((response) => {
            let data = response.data;
            if(data) {
               data.forEach(element => {
               ProductType.push(element.product_type);
               UnitPrice.push(element.unit_price);
               });
               this.renderChart({
               labels: ProductType,
               datasets: [{
                  label: 'Bitcoin',
                  backgroundColor: '#FC2525',
                  data: UnitPrice
            }]
         }, {responsive: true, maintainAspectRatio: false})
       }
       else {
          console.log('No data');
       }
      });            
   }
}
</script>
JS;
//echo $a;
?>
<div class="container" >
    <div  style="display: block;">
        
      
          {{ csrf_field() }}
          <div class="row">
<product-sales-per-date></product-sales-per-date>
          </div>
        
          <div class="row">
<product-sales-per-type></product-sales-per-type>
          </div>
          <div class="row">
<outstanding-inventory></outstanding-inventory>
          </div>
<div class="box-box" style="display: block;">
  <div class="row">
    <div class="col-md-12">
      <div class="chart-responsive">
        <canvas width="300" height="300" ref="canvas"></canvas>
      </div>
      <!-- ./chart-responsive -->
    </div>
  </div>
  <!-- /.row -->
</div>
     










            <div class="col-md-3 box-body">
                <div class="chart-responsive">
                    <canvas width="150" height="150" ref="canvas"></canvas>
                </div>
                <!-- ./chart-responsive -->
            </div>

            <div class="col-md-3 box-body1">
                <div class="chart-responsive">
                    <canvas width="150" height="150" ref="canvas"></canvas>
                </div>
                <!-- ./chart-responsive -->
            </div>

            <div class="col-md-3 box-body2">
                <div class="chart-responsive">
                    <canvas width="150" height="150" ref="canvas"></canvas>
                </div>
                <!-- ./chart-responsive -->
            </div>

            <div class="col-md-3 box-body3">
                <div class="chart-responsive">
                    <canvas width="150" height="150" ref="canvas"></canvas>
                </div>
                <!-- ./chart-responsive -->
            </div>

        </div>
        <!-- /.row -->
           <div class="row">

            <div class="col-md-3 box-b">
                <div class="chart-responsive">
                    <canvas width="150" height="150" ref="canvas"></canvas>
                </div>
                <!-- ./chart-responsive -->
            </div>

            <div class="col-md-3 box-b1">
                <div class="chart-responsive">
                    <canvas width="150" height="150" ref="canvas"></canvas>
                </div>
                <!-- ./chart-responsive -->
            </div>

            <div class="col-md-3 box-b2">
                <div class="chart-responsive">
                    <canvas width="150" height="150" ref="canvas"></canvas>
                </div>
                <!-- ./chart-responsive -->
            </div>

            <div class="col-md-3 box-b3">
                <div class="chart-responsive">
                    <canvas width="150" height="150" ref="canvas"></canvas>
                </div>
                <!-- ./chart-responsive -->
            </div>

        </div>
    </div>

</div>
@endsection
