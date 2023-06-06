<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SMS SCAN | @yield('page_title')</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <style>
        #example_wrapper {
            padding: 10px;
        }
        .modal{
            background: rgba(0,0,0,0.3) !important;
        }
    </style>
</head>
@php
    $school = getSchoolInfoByUsername(Auth::user()->username);
@endphp
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('school.include.sidebar')
            <div class="layout-page">
                @include('school.include.header')
                @yield('content')
                @include('school.include.footer')
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>

    <div class="modal" tabindex="-1" id="BlockModal">
        <form id="BlockModalForm" method="POST">
            @csrf
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Status</h5>
                    <button type="button" class="btn-close closeBTNBlockModal" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <h4 class="text-danger text-center BlockBodyTextClass">Are you sure to block?</h4>
                    <input type="hidden" id="BlockModalID" name="id">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary closeBTNBlockModal" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger BlockSubmitBtnClass">Yes,Blocked</button>
                  </div>
                </div>
              </div>
            </div>
        </form>
    </div>
    <div class="modal" tabindex="-1" id="StatusModal">
        <form id="StatusModalForm" method="POST">
            @csrf
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Status</h5>
                    <button type="button" class="btn-close closeBTNStatusModal" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <h4 class="text-danger text-center StatusBodyTextClass">Are you sure to InActive?</h4>
                    <input type="hidden" id="StatusModalID" name="id">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary closeBTNStatusModal" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger StatusSubmitBtnClass">Yes,InActive</button>
                  </div>
                </div>
              </div>
            </div>
        </form>
    </div>
    <div class="modal" tabindex="-1" id="DeleteModal">
        <form id="DeleteModalForm" method="POST">
            @csrf
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Status</h5>
                    <button type="button" class="btn-close closeBTNDeleteModal" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <h4 class="text-danger text-center">Are you sure to delete?</h4>
                    <input type="hidden" id="DeleteModalID" name="id">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary closeBTNDeleteModal" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Yes,Delete it</button>
                  </div>
                </div>
              </div>
            </div>
        </form>
    </div>
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
    <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
    <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    @stack('footer-script')
    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                "paging": false
            });
            $(".blockSchoolBtn").on("click", function(){
                $("#BlockModal").show();
                var id = $(this).attr("data-id");
                var url = $(this).attr("data-url");
                var status = $(this).attr("data-status");
                if(status == "blocked"){
                    $(".BlockSubmitBtnClass").addClass("btn-primary");
                    $(".BlockSubmitBtnClass").text('Yes,Activate');
                    $(".BlockBodyTextClass").addClass("text-primary");
                    $(".BlockBodyTextClass").text('Are you sure to Activate?');
                }

                $("#BlockModalID").val(id);
                $("#BlockModalForm").attr("action", url);
            });

            $(".closeBTNBlockModal").on("click",function(){
                $("#BlockModal").hide();
            });


            $(".statusBtn").on("click", function(){
                $("#StatusModal").show();
                var id = $(this).attr("data-id");
                var url = $(this).attr("data-url");
                var status = $(this).attr("data-status");
                if(status == "inactive"){
                    $(".StatusSubmitBtnClass").addClass("btn-primary");
                    $(".StatusSubmitBtnClass").text('Yes,Activate');
                    $(".StatusBodyTextClass").addClass("text-primary");
                    $(".StatusBodyTextClass").text('Are you sure to Activate?');
                }

                $("#StatusModalID").val(id);
                $("#StatusModalForm").attr("action", url);
            });

            $(".closeBTNStatusModal").on("click",function(){
                $("#StatusModal").hide();
            });

            $(".deleteBtn").on("click", function(){
                $("#DeleteModal").show();
                var id = $(this).attr("data-id");
                var url = $(this).attr("data-url");

                $("#DeleteModalID").val(id);
                $("#DeleteModalForm").attr("action", url);
            });

            $(".closeBTNDeleteModal").on("click",function(){
                $("#DeleteModal").hide();
            });
        });
    </script>
</body>

</html>
