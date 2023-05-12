<!DOCTYPE html>
<html>
    <head>
        <title>{app_title}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <style>
        body {
            margin: 0px;
        }
        iframe {
            height: 100%;
        }
        </style>

        <script>window.jQuery || document.write('<script src="<?= base_url('assets/jquery/js/jquery.min.js') ?>"><\/script>');</script>
        <script>
            window.focus();
            setTimeout(function() {
                $('#iFramePdf').css({'position': 'absolute', 'top': '0', 'right': '0', 'bottom': '0', 'left': '0', 'height': '100%', 'overflow': 'hidden'});
            }, 2000);
            
            var elementId = "iFramePdf";
            var getMyFrame = document.getElementById(elementId);
            // getMyFrame.contentWindow.print();
            window.print(true);
        </script>
    </head>

    <body>
        <iframe id="iFramePdf" style="position: absolute;top: 0;right: 0;bottom: 0;left: 0;height: 100%;overflow: hidden;" height="100%" width="100%" frameBorder="0"  marginwidth="0" marginheight="0" align="top" scrolling="No" frameborder="0" hspace="0" vspace="0" src="<?= site_url('pdf/nota/{unique}') ?>">Browser not compatible.</iframe>
    </body>
</html>