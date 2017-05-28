<!doctype html>
<html class="no-js" lang="$ContentLocale">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
	<title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> &raquo; $SiteConfig.Title</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<% require themedCSS('normalize') %>
	<% require themedCSS('main') %>
	<% require themedCSS('betterform') %>

        <% require javascript('https://code.jquery.com/jquery-3.2.1.min.js') %>
        <% require javascript('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js') %>

        <script src="{$ThemeDir}/js/vendor/modernizr-2.8.3.min.js"></script>
    </head>
    <body>
        <% include Header %>
        <div id="main-wrapper">
            <!--[if lt IE 8]>
            <div class="row">
                <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
            </div>
            <![endif]-->

            <div class="row">
                <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                    <h2>PHP Form Validation Example</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                    <p><span class="help-block">* required field.</span></p>
                </div>
            </div>

            $BetterForm


            <div id="your-input" style="display: none;">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                        <h2>Your Input:</h2>
                    </div>
                </div>

                <div class="row">
                    <p class="col-xs-12 col-sm-10 col-sm-offset-1 name"><span class="value"></span></p>
                </div>
                <div class="row">
                    <p class="col-xs-12 col-sm-10 col-sm-offset-1 email"><span class="value"></span></p>
                </div>
                <div class="row">
                    <p class="col-xs-12 col-sm-10 col-sm-offset-1 website"><span class="value"></span></p>
                </div>
                <div class="row">
                    <p class="col-xs-12 col-sm-10 col-sm-offset-1 comment"><span class="value"></span></p>
                </div>
                <div class="row">
                    <p class="col-xs-12 col-sm-10 col-sm-offset-1 gender"><span class="value"></span></p>
                </div>
            </div>
        </div>

        <% include Footer %>

        <script src="{$ThemeDir}/js/plugins.js"></script>
        <script src="{$ThemeDir}/js/main.js"></script>
        <script type="text/javascript" src="{$ThemeDir}/js/betterform.js"></script>
    </body>
</html>
