
<!DOCTYPE html>
<html>
  <head>
    <title>{{config('idoc.title')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      body {
        margin: 0;
        padding: 0;
        font-family: Verdana, Geneva, sans-serif;
      }

      #redoc_container .menu-content img {
        padding: 0px 0px 30px 0px;
      }
    </style>
    <link rel="icon" type="image/png" href="/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="/favicon.ico">
    <style>
        .espozG,
        .fDvFMp {
            visibility: hidden;
        }
        .LiUBH,
        .jpdiZh,
        .dtUibw {
            display: none;
        }
        .bSFXlp {
            display: block; 
        }
        .cjtbAK {
            width: 100% !important;
        }
        .fLUKgj {
            background: #fff !important;
        }
    </style>
  </head>
  <body>
    <div id="redoc_container"></div>
    <script src="{{ asset('js/redocpro-standalone.min.js') }}"></script>
    <script>
      RedocPro.init(
        "{{config('idoc.output') . "/openapi.json"}}", {
          "showConsole": true,
          "pathInMiddlePanel": true,
          "redocExport": "RedocPro",
          "layout": { "scope": "section" },
          "unstable_externalDescription": '{{route('idoc.info')}}',
          "hideDownloadButton" : {{config('idoc.hide_download_button') ?: 0}}
        },
        document.getElementById("redoc_container")
      );

      var constantMock = window.fetch;
      window.fetch = function() {

        if (/\/api/.test(arguments[0]) && !arguments[1].headers.Accept) {
          arguments[1].headers.Accept = 'application/json';
        }

        return constantMock.apply(this, arguments)
      }
    </script>
  </body>
</html>
