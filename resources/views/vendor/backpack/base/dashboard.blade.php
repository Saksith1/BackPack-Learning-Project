@extends(backpack_view('blank'))

{{-- @php
    $widgets['before_content'][] = [
        'type'        => 'jumbotron',
        'heading'     => trans('backpack::base.welcome'),
        'content'     => trans('backpack::base.use_sidebar'),
        'button_link' => backpack_url('logout'),
        'button_text' => trans('backpack::base.logout'),
    ];
@endphp --}}

@section('content')
<h2>Dashboard</h2>
<div class="row">
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="my-card">
          <h1 class="bg-primary">User</h1>
          <p>{{ $user }}</p>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
      <div class="my-card">
        <h1 class="bg-success">Trainer</h1>
        <p>{{ $trainer }}</p>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
      <div class="my-card">
        <h1 class="bg-warning">Category</h1>
        <p>{{ $category }}</p>
      </div>
    </div>
   <div class="col-12 col-sm-6 col-md-4 col-lg-3">
    <div class="my-card">
      <h1 class="bg-danger">Post</h1>
      <p>{{ $post }}</p>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12 col-md-6">
    <canvas id="myChart"></canvas>
    <input type="hidden" id="count_user" value={{ $user }}>
    <input type="hidden" id="count_trainer" value={{ $trainer }}>
    <input type="hidden" id="count_category" value={{ $category }}>
    <input type="hidden" id="count_post" value={{ $post }}>
  </div>
  <div class="col-12 col-md-6">
    <canvas id="myChartBar"></canvas>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  var count_user=document.getElementById('count_user').value;
  var count_trainer=document.getElementById('count_trainer').value
  var count_category=document.getElementById('count_category').value;
  var count_post=document.getElementById('count_post').value;
  var xValues = ["user", "trainer","category","post"];
  var yValues = [count_user,count_trainer,count_category,count_post];
  var barColors = [
    "#7c69ef",
    "#42ba96",
    "#ffc107",
    "#df4759"
  ];
  
  //pie
  new Chart("myChart", {
    type: "pie",
    data: {
      labels: xValues,
      datasets: [{
        backgroundColor: barColors,
        data: yValues
      }]
    },
    options: {
      title: {
        display: true,
        text: "World Wide Wine Production 2018"
      }
    }
  });

  //bar
  new Chart("myChartBar", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "World Wine Production 2018"
    }
  }
});
  </script>

@endsection

  