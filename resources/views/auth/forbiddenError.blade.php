<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>TraceEdu</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('TemplateAdmin/src/assets/vendors/feather/feather.css') }}" />
    <link rel="stylesheet" href="{{ asset('TemplateAdmin/src/assets/vendors/mdi/css/materialdesignicons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('TemplateAdmin/src/assets/vendors/ti-icons/css/themify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('TemplateAdmin/src/assets/vendors/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('TemplateAdmin/src/assets/vendors/typicons/typicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('TemplateAdmin/src/assets/vendors/simple-line-icons/css/simple-line-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('TemplateAdmin/src/assets/vendors/css/vendor.bundle.base.css') }}" />
    <link rel="stylesheet" href="{{ asset('TemplateAdmin/src/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" />
    
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('TemplateAdmin/src/assets/css/style.css') }}" />
    <!-- endinject -->
    
    <link rel="shortcut icon" href="{{ asset('TemplateAdmin/TEH.png') }}" />
    
    <style>
      /* Full-screen glitch effect */
      .glitch {
        position: relative;
        color: white;
        font-size: 5rem;
        text-shadow: 0.05em 0 0 rgba(255, 0, 0, 0.75),
                    -0.05em -0.025em 0 rgba(0, 255, 0, 0.75),
                    0.025em 0.05em 0 rgba(0, 0, 255, 0.75);
        animation: glitch 500ms infinite;
      }
      
      .glitch span {
        position: absolute;
        top: 0;
        left: 0;
      }
      
      .glitch span:first-child {
        animation: glitch 650ms infinite;
        clip-path: polygon(0 0, 100% 0, 100% 45%, 0 45%);
        transform: translate(-0.025em, -0.0125em);
        opacity: 0.8;
      }
      
      .glitch span:last-child {
        animation: glitch 375ms infinite;
        clip-path: polygon(0 60%, 100% 60%, 100% 100%, 0 100%);
        transform: translate(0.0125em, 0.025em);
        opacity: 0.8;
      }
      
      @keyframes glitch {
        0% {
          text-shadow: 0.05em 0 0 rgba(255, 0, 0, 0.75),
                      -0.05em -0.025em 0 rgba(0, 255, 0, 0.75),
                      0.025em 0.05em 0 rgba(0, 0, 255, 0.75);
        }
        14% {
          text-shadow: 0.05em 0 0 rgba(255, 0, 0, 0.75),
                      -0.05em -0.025em 0 rgba(0, 255, 0, 0.75),
                      0.025em 0.05em 0 rgba(0, 0, 255, 0.75);
        }
        15% {
          text-shadow: -0.05em -0.025em 0 rgba(255, 0, 0, 0.75),
                      0.025em 0.025em 0 rgba(0, 255, 0, 0.75),
                      -0.05em -0.05em 0 rgba(0, 0, 255, 0.75);
        }
        49% {
          text-shadow: -0.05em -0.025em 0 rgba(255, 0, 0, 0.75),
                      0.025em 0.025em 0 rgba(0, 255, 0, 0.75),
                      -0.05em -0.05em 0 rgba(0, 0, 255, 0.75);
        }
        50% {
          text-shadow: 0.025em 0.05em 0 rgba(255, 0, 0, 0.75),
                      0.05em 0 0 rgba(0, 255, 0, 0.75),
                      0 -0.05em 0 rgba(0, 0, 255, 0.75);
        }
        99% {
          text-shadow: 0.025em 0.05em 0 rgba(255, 0, 0, 0.75),
                      0.05em 0 0 rgba(0, 255, 0, 0.75),
                      0 -0.05em 0 rgba(0, 0, 255, 0.75);
        }
        100% {
          text-shadow: -0.025em 0 0 rgba(255, 0, 0, 0.75),
                      -0.025em -0.025em 0 rgba(0, 255, 0, 0.75),
                      -0.025em -0.05em 0 rgba(0, 0, 255, 0.75);
        }
      }
      
      /* Optional: Add scanlines for more retro effect */
      /* .glitch-container {
        position: relative;
        overflow: hidden;
      }
      
      .glitch-container::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(
          to bottom,
          rgba(255, 255, 255, 0.1) 0%,
          rgba(255, 255, 255, 0.1) 50%,
          transparent 50%,
          transparent 100%
        );
        background-size: 100% 4px;
        pointer-events: none;
        animation: scanline 6s linear infinite;
      }
      
      @keyframes scanline {
        0% {
          background-position: 100% 100%;
        }
        100% {
          background-position: 100% 100%;
        }
      } */
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center text-center error-page bg-primary">
          <div class="row flex-grow">
            <div class="col-lg-7 mx-auto text-white">
              <div class="row align-items-center d-flex flex-row mb-4">
                <div class="col-lg-6 text-lg-right pr-lg-4 glitch-container">
                  <h1 class="display-1 mb-0 fw-bold glitch" data-text="403">
                    403
                    <span aria-hidden="true">403</span>
                    <span aria-hidden="true">403</span>
                  </h1>
                </div>
                <div class="col-lg-6 text-lg-left pl-lg-4">
                  <h2 class="fw-bold">FORBIDDEN</h2>
                  <h5 class="fw-light fs-5">You don't have permission<br>to access this resource.</h5>
                </div>
              </div>

              <div class="row mt-4">
                <div class="col-12 text-center">
                  <a href="{{ route('dashboard') }}" class="btn btn-rounded" style="background-color: white; color: #0d6efd; font-weight: 600;">
                    <i class="fa fa-arrow-left me-2"></i> Back to Dashboard
                  </a>
                </div>
              </div>                          

              <div class="row mt-4">
                <div class="col-12">
                  <p class="text-white fw-medium fs-6 text-center">
                    If you believe this is a mistake, please contact your administrator.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="{{ asset('TemplateAdmin/src/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('TemplateAdmin/src/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <!-- endinject -->

    <!-- inject:js -->
    <script src="{{ asset('TemplateAdmin/src/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('TemplateAdmin/src/assets/js/template.js') }}"></script>
    <script src="{{ asset('TemplateAdmin/src/assets/js/settings.js') }}"></script>
    <script src="{{ asset('TemplateAdmin/src/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('TemplateAdmin/src/assets/js/todolist.js') }}"></script>
    <!-- endinject -->
  </body>
</html>