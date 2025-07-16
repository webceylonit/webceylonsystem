@extends('AdminDashboard.master')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h4>Dashboard </h4>
      </div>
      <div class="col-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">
              <svg class="stroke-icon">
                <use href="{{ asset('frontend/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
              </svg></a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
  <div class="row widget-grid">
    <div class="col-xxl-4 col-sm-6 box-col-6">
      <div class="card profile-box">
        <div class="card-body">
          <div class="media media-wrapper justify-content-between">
            <div class="media-body">
              <div class="greeting-user">
                <h4 class="f-w-600">Welcome to WebCeylon</h4>
                <p>Here what's happening in your company today</p>
                <div class="whatsnew-btn">
                  <!-- <a class="btn btn-outline-white">Whats New !</a> -->
                </div>
              </div>
            </div>
            <div>
              <div class="clockbox">
                <svg id="clock" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 600">
                  <g id="face">
                    <circle class="circle" cx="300" cy="300" r="253.9"></circle>
                    <path class="hour-marks" d="M300.5 94V61M506 300.5h32M300.5 506v33M94 300.5H60M411.3 107.8l7.9-13.8M493 190.2l13-7.4M492.1 411.4l16.5 9.5M411 492.3l8.9 15.3M189 492.3l-9.2 15.9M107.7 411L93 419.5M107.5 189.3l-17.1-9.9M188.1 108.2l-9-15.6"></path>
                    <circle class="mid-circle" cx="300" cy="300" r="16.2"></circle>
                  </g>
                  <g id="hour">
                    <path class="hour-hand" d="M300.5 298V142"></path>
                    <circle class="sizing-box" cx="300" cy="300" r="253.9"></circle>
                  </g>
                  <g id="minute">
                    <path class="minute-hand" d="M300.5 298V67"> </path>
                    <circle class="sizing-box" cx="300" cy="300" r="253.9"></circle>
                  </g>
                  <g id="second">
                    <path class="second-hand" d="M300.5 350V55"></path>
                    <circle class="sizing-box" cx="300" cy="300" r="253.9"> </circle>
                  </g>
                </svg>
              </div>
              <div class="badge f-10 p-0" id="txt"></div>
            </div>
          </div>
          <div class="cartoon"><img class="img-fluid" src="{{ asset('frontend/assets/images/dashboard/cartoon.svg') }}" alt="vector women with leptop"></div>
        </div>
      </div>
    </div>
    <div class="col-xxl-auto col-xl-3 col-sm-6 box-col-6">
      <div class="row">
        <div class="col-xl-12">
          <div class="card widget-1">
            <div class="card-body">
              <div class="widget-content">
                <div class="widget-round secondary">
                  <div class="bg-round">
                    <svg class="svg-fill">
                      <use href="frontend/assets/svg/icon-sprite.svg#cart"> </use>
                    </svg>
                    <svg class="half-circle svg-fill">
                      <use href="frontend/assets/svg/icon-sprite.svg#halfcircle"></use>
                    </svg>
                  </div>
                </div>
                <div>
                  <h4>{{ $employeeCount }}</h4><span class="f-light">Employees</span>
                </div>
              </div>
              <div class="font-secondary f-w-500"><i class="icon-arrow-up icon-rotate me-1"></i><span>+50%</span></div>
            </div>
          </div>
          <div class="col-xl-12">
            <div class="card widget-1">
              <div class="card-body">
                <div class="widget-content">
                  <div class="widget-round primary">
                    <div class="bg-round">
                      <svg class="svg-fill">
                        <use href="frontend/assets/svg/icon-sprite.svg#tag"> </use>
                      </svg>
                      <svg class="half-circle svg-fill">
                        <use href="frontend/assets/svg/icon-sprite.svg#halfcircle"></use>
                      </svg>
                    </div>
                  </div>
                  <div>
                    <h4>{{ $ongoingProjects }}</h4><span class="f-light">Ongoing Projects</span>
                  </div>
                </div>
                <div class="font-primary f-w-500"><i class="icon-arrow-up icon-rotate me-1"></i><span>+70%</span></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xxl-auto col-xl-3 col-sm-6 box-col-6">
      <div class="row">
        <div class="col-xl-12">
          <div class="card widget-1">
            <div class="card-body">
              <div class="widget-content">
                <div class="widget-round warning">
                  <div class="bg-round">
                    <svg class="svg-fill">
                      <use href="frontend/assets/svg/icon-sprite.svg#return-box"> </use>
                    </svg>
                    <svg class="half-circle svg-fill">
                      <use href="frontend/assets/svg/icon-sprite.svg#halfcircle"></use>
                    </svg>
                  </div>
                </div>
                <div>
                  <h4>{{ $clientCount }}</h4><span class="f-light">Clients</span>
                </div>
              </div>
              <div class="font-warning f-w-500"><i class="icon-arrow-down icon-rotate me-1"></i><span>-20%</span></div>
            </div>
          </div>
          <div class="col-xl-12">
            <div class="card widget-1">
              <div class="card-body">
                <div class="widget-content">
                  <div class="widget-round success">
                    <div class="bg-round">
                      <svg class="svg-fill">
                        <use href="frontend/assets/svg/icon-sprite.svg#rate"> </use>
                      </svg>
                      <svg class="half-circle svg-fill">
                        <use href="frontend/assets/svg/icon-sprite.svg#halfcircle"></use>
                      </svg>
                    </div>
                  </div>
                  <div>
                    <h4>{{ $newProjects }}</h4><span class="f-light">New Projects</span>
                  </div>
                </div>
                <div class="font-success f-w-500"><i class="icon-arrow-up icon-rotate me-1"></i><span>+70%</span></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xxl-auto col-xl-3 col-sm-6 box-col-6">
      <div class="row">
        <div class="col-xl-12">
          <div class="card widget-1">
            <div class="card-body">
              <div class="widget-content">
                <div class="widget-round warning">
                  <div class="bg-round">
                    <svg class="svg-fill">
                      <use href="frontend/assets/svg/icon-sprite.svg#return-box"> </use>
                    </svg>
                    <svg class="half-circle svg-fill">
                      <use href="frontend/assets/svg/icon-sprite.svg#halfcircle"></use>
                    </svg>
                  </div>
                </div>
                <div>
                  <h4>{{ $projectCount}}</h4><span class="f-light">Projects</span>
                </div>
              </div>
              <div class="font-warning f-w-500"><i class="icon-arrow-down icon-rotate me-1"></i><span>-20%</span></div>
            </div>
          </div>
          <div class="col-xl-12">
            <div class="card widget-1">
              <div class="card-body">
                <div class="widget-content">
                  <div class="widget-round success">
                    <div class="bg-round">
                      <svg class="svg-fill">
                        <use href="frontend/assets/svg/icon-sprite.svg#rate"> </use>
                      </svg>
                      <svg class="half-circle svg-fill">
                        <use href="frontend/assets/svg/icon-sprite.svg#halfcircle"></use>
                      </svg>
                    </div>
                  </div>
                  <div>
                    <h4>{{ $completedProjects }}</h4><span class="f-light">Completed Projects</span>
                  </div>
                </div>
                <div class="font-success f-w-500"><i class="icon-arrow-up icon-rotate me-1"></i><span>+70%</span></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>




    <div class="col-xxl-12 col-lg-12 box-col-12">
      <div class="row">

        <div class="col-xl-6">
          <div class="card growth-wrap">
            <div class="card-header card-no-border">
              <div class="header-top">
                <h5>Clients Growth</h5>
                
              </div>
            </div>
            <div class="card-body pt-5">
              <div class="growth-wrapper">
                <div id="clientsGrowthChart"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6">
          <div class="card growth-wrap">
            <div class="card-header card-no-border">
              <div class="header-top">
                <h5>Projects Growth</h5>
                
              </div>
            </div>
            <div class="card-body pt-5">
              <div class="growth-wrapper">
                <div id="projectsGrowthChart"></div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>
<!-- Container-fluid Ends-->



@endsection

@section('scripts')
<script>

  const clientData = JSON.parse('{!! json_encode($monthlyClients) !!}');
  const projectData = JSON.parse('{!! json_encode($monthlyProjects) !!}');


  const categories = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

  // Clients Growth Chart
  const clientsGrowthChart = new ApexCharts(document.querySelector("#clientsGrowthChart"), {
    series: [{
      name: "Clients",
      data: clientData
    }],
    chart: {
      height: 220,
      type: "line",
      toolbar: {
        show: true
      },
      dropShadow: {
        enabled: true,
        top: 5,
        left: 0,
        blur: 4,
        color: "#28C76F",
        opacity: 0.22,
      },
    },
    colors: ["#28C76F"],
    stroke: {
      width: 3,
      curve: "smooth"
    },
    xaxis: {
      categories: categories,
      labels: {
        style: {
          fontFamily: "Rubik, sans-serif"
        }
      },
      axisTicks: {
        show: false
      },
      axisBorder: {
        show: false
      },
    },
    fill: {
      type: "gradient",
      gradient: {
        shade: "light",
        gradientToColors: ["#81FBB8"],
        type: "horizontal",
        opacityFrom: 1,
        opacityTo: 1,
      },
    },
    yaxis: {
      labels: {
        show: true
      }
    },
    grid: {
      yaxis: {
        lines: {
          show: false
        }
      }
    },
  });
  clientsGrowthChart.render();


  // Projects Growth Chart
  const projectsGrowthChart = new ApexCharts(document.querySelector("#projectsGrowthChart"), {
    series: [{
      name: "Projects",
      data: projectData
    }],
    chart: {
      height: 220,
      type: "line",
      toolbar: {
        show: true
      },
      dropShadow: {
        enabled: true,
        top: 5,
        left: 0,
        blur: 4,
        color: "#7366FF",
        opacity: 0.22,
      },
    },
    colors: ["#7366FF"],
    stroke: {
      width: 3,
      curve: "smooth"
    },
    xaxis: {
      categories: categories,
      labels: {
        style: {
          fontFamily: "Rubik, sans-serif"
        }
      },
      axisTicks: {
        show: false
      },
      axisBorder: {
        show: true
      },
    },
    fill: {
      type: "gradient",
      gradient: {
        shade: "dark",
        gradientToColors: ["#E069AE"],
        type: "horizontal",
        opacityFrom: 1,
        opacityTo: 1,
      },
    },
    yaxis: {
      labels: {
        show: true
      }
    },
    grid: {
      yaxis: {
        lines: {
          show: false
        }
      }
    },
  });
  projectsGrowthChart.render();
</script>
@endsection