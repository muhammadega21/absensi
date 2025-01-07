 <!-- Reports -->
 <div class="col-12">
     <div class="card">

         <div class="filter">
             <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
             <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                 <li class="dropdown-header text-start">
                     <h6>Filter</h6>
                 </li>

                 <li><a class="dropdown-item" href="#">This Week</a></li>
                 <li><a class="dropdown-item" href="#">This Month</a></li>
                 <li><a class="dropdown-item" href="#">This Year</a></li>
             </ul>
         </div>

         <div class="card-body">
             <h5 class="card-title">Reports <span>/This Week</span></h5>

             <!-- Line Chart -->
             <div id="reportsChart"></div>

             <script>
                 document.addEventListener("DOMContentLoaded", () => {
                     new ApexCharts(document.querySelector("#reportsChart"), {
                         series: [{
                                 name: "Hadir",
                                 data: [31, 40, 28, 51, 42, 82, 56],
                             },

                             {
                                 name: "Alfa",
                                 data: [15, 11, 32, 18, 9, 24, 11],
                             },
                         ],
                         chart: {
                             height: 350,
                             type: "area",
                             toolbar: {
                                 show: false,
                             },
                         },
                         markers: {
                             size: 4,
                         },
                         colors: ["#2eca6a", "#f14141"],
                         fill: {
                             type: "gradient",
                             gradient: {
                                 shadeIntensity: 1,
                                 opacityFrom: 0.3,
                                 opacityTo: 0.4,
                                 stops: [0, 90, 100],
                             },
                         },
                         dataLabels: {
                             enabled: false,
                         },
                         stroke: {
                             curve: "smooth",
                             width: 2,
                         },
                         xaxis: {
                             type: "date",
                             categories: [
                                 "2018-09-19",
                                 "2018-09-19",
                                 "2018-09-19",
                                 "2018-09-19",
                                 "2018-09-19",
                                 "2018-09-19",
                                 "2018-09-19",
                             ],
                         },
                         tooltip: {
                             x: {
                                 format: "dd/MM/yy",
                             },
                         },
                     }).render();
                 });
             </script>

             <!-- End Line Chart -->

         </div>

     </div>
 </div><!-- End Reports -->
