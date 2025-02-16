<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="icon" href="_img/icono.png">
        <title>HR - Origen</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>window.jQuery || document.write(decodeURIComponent('%3Cscript src="js/jquery.min.js"%3E%3C/script%3E'))</script>
        <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/23.2.5/css/dx.light.css">
        <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/23.2.5/js/dx.all.js"></script>
        <script src="https://unpkg.com/mustache@4.2.0/mustache.min.js"></script>
        <link rel="stylesheet" type="text/css" href="_css/app.css" />
        <script src="_js/app.js"></script>
        <script src="_js/data.js"></script>
    </head>
    <body>
        <div class="demo-container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="toolbardt" id="toolbar"></div>
                    <br><br><br>
                </div>
            </div>
            <div class="images"></div>
            <div id="popup"></div>
        </div>
        
        <script id="property-item" type="text/html">
            <div>
                <div class="item-content">
                <img id="house-image{{ ID }}" alt="{{ Address }}" src="{{ Image }}" />
                <div class="item-options">
                    <div>
                    <div class="address">{{ Address }}</div>
                    <div class="price large-text">{{ #formatCurrency }}{{ Price }}{{ /formatCurrency }}</div>
                    <div class="agent">
                        <div id="house{{ ID }}">
                        <img alt="Listing agent" src="https://js.devexpress.com/jQuery/Demos/WidgetsGallery/JSDemos/images/icon-agent.svg" />
                        Listing agent
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                <div id="popover{{ ID }}">
                    <div class="agent-details">
                        <img alt="{{ Agent.Name }}" src="{{ Agent.Picture }}" />
                        <div>
                            <div class="name large-text">{{ Agent.Name }}</div>
                            <div class="phone">Tel: {{ Agent.Phone }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </script>

        <script id="property-details" type="text/html">
            <div class="popup-property-details">
                <div class="large-text">{{ #formatCurrency }}{{ Price }}{{ /formatCurrency }}</div>
                <div class="opacity">{{ Address }}, {{ City }}, {{ State }}</div>
                <div id="favorites" class="favorites"></div>
                <div class="images">
                    <img alt="{{ Address }} first photo" src="{{ Image }}" />
                    <img alt="{{ Address }} second photo" src="{{ #replaceFileExtension }}{{ Image }}{{ /replaceFileExtension }}" />
                </div>
                <div>{{ Features }}</div>
            </div>
        </script>
    </body>
</html>